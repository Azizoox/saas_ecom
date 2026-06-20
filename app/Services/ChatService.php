<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatService
{
    private const MAX_HISTORY_MESSAGES = 20;
    private const MAX_TOKENS = 700;

    private ?string $lastApiError = null;

    public function __construct(
        private ChatContextBuilder $contextBuilder
    ) {}

    public function sendMessage(Conversation $conversation, string $userInput, ?Shop $shop = null): string
    {
        try {
            $conversation->messages()->create(['role' => 'user', 'content' => $userInput]);

            $shop = $shop ?? $this->resolveShop($conversation);
            $dynamicContext = $this->contextBuilder->build($shop, $userInput);
            $systemPrompt = $this->buildSystemPrompt($conversation, $shop, $dynamicContext);

            $history = $conversation->messages()
                ->latest()
                ->take(self::MAX_HISTORY_MESSAGES)
                ->get()
                ->reverse()
                ->values()
                ->map(fn ($m) => [
                    'role'    => $m->role,
                    'content' => $m->content,
                ])
                ->toArray();

            $this->lastApiError = null;
            $reply = $this->callOpenAI($systemPrompt, $history);

            if (!$reply) {
                $reply = $this->getDatabaseReply($userInput, $shop) ?? $this->getDefaultReply($userInput, $shop, $this->lastApiError);
            }

            $conversation->messages()->create(['role' => 'assistant', 'content' => $reply]);

            return $reply;
        } catch (\Exception $e) {
            Log::error('ChatService error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            $defaultReply = "Je suis désolé, j'ai rencontré une erreur technique. Veuillez réessayer dans un instant.";

            try {
                $conversation->messages()->create(['role' => 'assistant', 'content' => $defaultReply]);
            } catch (\Exception $logError) {
                Log::error('Failed to save error message: ' . $logError->getMessage());
            }

            return $defaultReply;
        }
    }

    private function resolveShop(Conversation $conversation): ?Shop
    {
        if (app()->bound('shop')) {
            return app('shop');
        }

        $shopId = $conversation->metadata['shop_id'] ?? null;
        if ($shopId) {
            return Shop::where('id', $shopId)->where('status', 'active')->first();
        }

        return null;
    }

    private function callOpenAI(string $systemPrompt, array $history): ?string
    {
        $apiKey = config('services.openai.key');

        if (!$apiKey || !str_starts_with(trim($apiKey), 'sk-')) {
            Log::info('No valid OpenAI API key configured, using default replies');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . trim($apiKey),
                'Content-Type'  => 'application/json',
            ])->timeout(45)->post('https://api.openai.com/v1/chat/completions', [
                'model'       => config('services.openai.model', 'gpt-4o-mini'),
                'messages'    => array_merge([['role' => 'system', 'content' => $systemPrompt]], $history),
                'max_tokens'  => self::MAX_TOKENS,
                'temperature' => 0.6,
            ]);

            if ($response->successful()) {
                $reply = $response->json('choices.0.message.content');
                if ($reply) {
                    return trim($reply);
                }
                Log::warning('No content in OpenAI response');
            } else {
                $status = $response->status();
                $errorMessage = $response->json('error.message');

                Log::warning('OpenAI API returned error', [
                    'status'  => $status,
                    'message' => $errorMessage,
                ]);

                if ($status === 429) {
                    $this->lastApiError = 'quota_exceeded';
                }
            }
        } catch (\Exception $e) {
            Log::warning('OpenAI API call failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Réponses construites directement depuis la base de données (sans OpenAI).
     */
    private function getDatabaseReply(string $userInput, ?Shop $shop): ?string
    {
        if (!$shop) {
            return null;
        }

        $shopName = $shop->name;
        $input = mb_strtolower(trim($userInput));

        // Suivi de commande par numéro ORD-...
        $orderNumber = $this->contextBuilder->extractOrderNumber($userInput);
        if ($orderNumber) {
            $order = Order::query()
                ->where('shop_id', $shop->id)
                ->where('order_number', $orderNumber)
                ->with('items')
                ->first();

            if ($order) {
                $status = $this->translateStatus($order->status);
                $total = number_format((float) $order->total, 2, ',', ' ');
                $items = $order->items->map(fn ($i) => "{$i->product_name} (x{$i->quantity})")->implode(', ');

                return "Commande {$order->order_number} :\n- Statut : {$status}\n- Total : {$total} TND\n- Articles : {$items}\n\nBesoin d'autre chose ?";
            }

            return "Je n'ai pas trouvé la commande {$orderNumber}. Vérifiez le numéro (format : ORD-YYYYMMDD-XXXXXX) ou contactez-nous à {$shop->contact_email}.";
        }

        // Commandes du client connecté
        if (preg_match('/(mes commandes|ma commande|suivi|statut)/i', $input) && auth()->check()) {
            $orders = Order::query()
                ->where('shop_id', $shop->id)
                ->where('customer_email', auth()->user()->email)
                ->latest()
                ->limit(3)
                ->get();

            if ($orders->isNotEmpty()) {
                $list = $orders->map(function ($order) {
                    $total = number_format((float) $order->total, 2, ',', ' ');
                    return "• {$order->order_number} — {$this->translateStatus($order->status)} — {$total} TND";
                })->implode("\n");

                return "Voici vos dernières commandes chez {$shopName} :\n{$list}\n\nDonnez-moi un numéro de commande pour plus de détails.";
            }

            return "Vous n'avez pas encore de commande chez {$shopName}. Parcourez notre catalogue et ajoutez des articles au panier !";
        }

        // Recherche produit dynamique (mots-clés dans le message)
        $products = $this->contextBuilder->searchProducts($shop, $userInput);
        if ($products->isNotEmpty()) {
            $list = $this->contextBuilder->formatProductList($products);

            if (preg_match('/(prix|cout|tarif|combien|cher)/i', $input)) {
                return "Voici les prix que j'ai trouvés :\n{$list}\n\nCliquez sur un produit pour voir les détails et commander.";
            }

            if (preg_match('/(stock|disponib|rupture)/i', $input)) {
                return "Disponibilité actuelle :\n{$list}";
            }

            return "J'ai trouvé ces produits dans notre catalogue :\n{$list}\n\nLequel vous intéresse ? Je peux vous en dire plus.";
        }

        // Recherche par catégorie
        if (preg_match('/(categorie|catégorie|rayon)/i', $input)) {
            $categories = $shop->categories()
                ->where('is_active', true)
                ->orderBy('order')
                ->get(['name', 'description']);

            if ($categories->isNotEmpty()) {
                $list = $categories->map(fn ($c) => "• {$c->name}")->implode("\n");
                return "Nos catégories chez {$shopName} :\n{$list}\n\nDites-moi une catégorie ou un produit précis.";
            }
        }

        return null;
    }

    private function translateStatus(string $status): string
    {
        return match ($status) {
            Order::STATUS_NEW        => 'Nouvelle',
            Order::STATUS_PREPARING  => 'En préparation',
            Order::STATUS_SHIPPED    => 'Expédiée',
            Order::STATUS_DELIVERED  => 'Livrée',
            Order::STATUS_CANCELLED  => 'Annulée',
            Order::STATUS_RETURNED   => 'Retournée',
            default                  => $status,
        };
    }

    private function getDefaultReply(string $userInput, ?Shop $shop = null, ?string $apiError = null): string
    {
        $shopName = $shop?->name ?? config('app.name', 'notre boutique');
        $input = strtolower(trim($userInput));
        $catalogHint = $this->getCatalogHint($shop);

        if (preg_match('/(bonjour|salut|hi|hello|hey|coucou|bonsoir)/i', $input)) {
            return "Bonjour ! 👋 Bienvenue chez {$shopName}. Je suis votre assistant shopping — produits, prix, livraison, commandes : posez-moi vos questions !";
        }

        if (preg_match('/(produit|article|catalogue|acheter|recommand)/i', $input)) {
            return "Nous avons une belle sélection de produits.{$catalogHint} Dites-moi ce que vous cherchez (type, budget, usage) et je vous orienterai.";
        }

        if (preg_match('/(prix|cout|tarif|combien|pas cher|cher|budget)/i', $input)) {
            return "Les prix sont indiqués sur chaque fiche produit en TND.{$catalogHint} Quel article vous intéresse ? Je peux vous donner une fourchette.";
        }

        if (preg_match('/(livraison|expedition|transport|delai|recevoir)/i', $input)) {
            return "Nous livrons partout en Tunisie 🇹🇳. Les délais et frais dépendent de votre ville. Ajoutez vos articles au panier pour voir le total, ou indiquez-moi votre ville pour une estimation.";
        }

        if (preg_match('/(commande|order|commander|suivi|statut)/i', $input)) {
            return "Pour commander : ajoutez au panier → validez → payez. Pour suivre une commande, connectez-vous à votre compte ou donnez-moi votre numéro de commande.";
        }

        if (preg_match('/(paiement|payer|carte|espece|virement)/i', $input)) {
            return "Plusieurs moyens de paiement sécurisés sont disponibles au moment du checkout. Si un paiement échoue, vérifiez vos informations ou essayez une autre méthode.";
        }

        if (preg_match('/(retour|rembours|echang|garantie)/i', $input)) {
            return "Pour un retour ou échange, contactez-nous avec votre numéro de commande et le motif. Nous vous expliquerons la procédure adaptée à votre cas.";
        }

        if (preg_match('/(aide|help|support|probleme|erreur|bug)/i', $input)) {
            return "Je suis là pour vous aider ! Décrivez votre problème (commande, paiement, livraison, produit) et je vous guide étape par étape.";
        }

        if (preg_match('/(merci|thank|au revoir|bye|a plus)/i', $input)) {
            return "Avec plaisir ! 😊 Revenez quand vous voulez. Bonne continuation chez {$shopName} !";
        }

        if ($apiError === 'quota_exceeded') {
            return "Je fonctionne en mode limité pour le moment.{$catalogHint} Posez votre question sur nos produits, la livraison ou les commandes — je ferai de mon mieux pour vous aider !";
        }

        return "Merci pour votre message !{$catalogHint} Comment puis-je vous aider ? Produits, prix, livraison, commande — je suis à votre écoute.";
    }

    private function getCatalogHint(?Shop $shop): string
    {
        if (!$shop) {
            return '';
        }

        $categories = $shop->categories()
            ->where('is_active', true)
            ->orderBy('order')
            ->limit(5)
            ->pluck('name');

        if ($categories->isEmpty()) {
            return '';
        }

        return ' Catégories populaires : ' . $categories->implode(', ') . '.';
    }

    private function buildCatalogContext(?Shop $shop): string
    {
        if (!$shop) {
            return "Aucun catalogue boutique chargé pour cette session.";
        }

        $categories = $shop->categories()
            ->where('is_active', true)
            ->orderBy('order')
            ->limit(12)
            ->get(['name', 'description']);

        $products = Product::query()
            ->where('shop_id', $shop->id)
            ->where('is_active', true)
            ->with('category:id,name')
            ->orderByDesc('created_at')
            ->limit(25)
            ->get(['id', 'name', 'price', 'stock', 'short_description', 'description', 'category_id', 'brand']);

        $lines = ["Boutique : {$shop->name}"];

        if ($shop->description) {
            $lines[] = "Description : " . mb_substr(strip_tags($shop->description), 0, 300);
        }

        if ($categories->isNotEmpty()) {
            $lines[] = "\n### Catégories";
            foreach ($categories as $cat) {
                $desc = $cat->description ? ' — ' . mb_substr(strip_tags($cat->description), 0, 80) : '';
                $lines[] = "- {$cat->name}{$desc}";
            }
        }

        if ($products->isNotEmpty()) {
            $lines[] = "\n### Produits (prix en TND, stock approximatif)";
            foreach ($products as $product) {
                $price = number_format((float) $product->price, 2, ',', ' ');
                $stock = $product->stock > 0 ? "en stock ({$product->stock})" : 'rupture';
                $category = $product->category?->name ?? 'Sans catégorie';
                $desc = $product->short_description ?: $product->description;
                $desc = $desc ? ' — ' . mb_substr(strip_tags($desc), 0, 100) : '';
                $brand = $product->brand ? " [{$product->brand}]" : '';
                $lines[] = "- {$product->name}{$brand} | {$price} TND | {$category} | {$stock}{$desc}";
            }
        } else {
            $lines[] = "\nAucun produit actif pour le moment.";
        }

        return implode("\n", $lines);
    }

    private function buildSystemPrompt(Conversation $conversation, ?Shop $shop, string $dynamicContext = ''): string
    {
        $shopName = $shop?->name ?? config('app.name', 'la boutique');
        $userName = auth()->check() ? auth()->user()->name : null;
        $identity = $userName
            ? "Le client s'appelle {$userName} (connecté)."
            : "Le client est un visiteur (non connecté).";

        $catalogContext = $this->buildCatalogContext($shop);

        $sections = [
            "Tu es l'assistant e-commerce officiel de « {$shopName} », une boutique en ligne en Tunisie.",
            "",
            "## Catalogue actuel (données réelles — utilise-les pour recommander)",
            $catalogContext,
        ];

        if ($dynamicContext) {
            $sections[] = "";
            $sections[] = "## Données dynamiques pour ce message (prioritaires — issues de la base de données)";
            $sections[] = $dynamicContext;
        }

        $sections = array_merge($sections, [
            "",
            "## Objectif",
            "- Aider le client à trouver le bon produit, comparer les options, et finaliser son achat.",
            "- Répondre sur commandes, paiement, livraison en Tunisie, retours et disponibilité.",
            "- Proposer des recommandations personnalisées basées sur le catalogue ci-dessus.",
            "",
            "## Contexte client",
            "- {$identity}",
            "- Devise : dinars tunisiens (TND).",
            "- Pour le suivi de commande : demander le numéro de commande ou inviter à se connecter.",
            "",
            "## Règles de réponse",
            "- Toujours en français, ton chaleureux, professionnel et concis (2–5 phrases sauf si liste utile).",
            "- Base tes réponses sur le catalogue fourni. Cite des produits réels avec prix quand pertinent.",
            "- Si un produit n'est pas dans le catalogue : dis-le clairement et propose des alternatives du catalogue.",
            "- Pour un conseil d'achat : pose 1–2 questions (budget, usage, préférences) puis suggère 2–3 produits du catalogue avec avantages.",
            "- Ne jamais inventer de produits, prix ou stocks absents du catalogue.",
            "- Si info manquante : pose une question ciblée ou indique où la trouver (fiche produit, panier, compte client).",
            "- Problème technique/commande : reformule, propose des étapes concrètes, demande numéro de commande si besoin.",
            "",
            "## Format",
            "- Listes courtes avec tirets pour comparer des produits.",
            "- Pas de blabla. Chaque réponse = réponse utile + prochaine étape claire.",
            "- Emojis avec modération (1 max par message).",
            "",
            "## Sécurité",
            "- Ne demande jamais mot de passe, CVV, code OTP.",
            "- Numéro de commande / email OK pour le support, avec alternative (contacter le support).",
        ]);

        return implode("\n", $sections);
    }
}
