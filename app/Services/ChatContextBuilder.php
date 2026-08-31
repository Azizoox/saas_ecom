<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Collection;

class ChatContextBuilder
{
    public function build(?Shop $shop, string $userInput): string
    {
        if (!$shop) {
            return '';
        }

        $sections = array_filter([
            $this->buildShopInfo($shop),
            $this->buildRelevantProducts($shop, $userInput),
            $this->buildOrderLookup($shop, $userInput),
            $this->buildUserOrders($shop),
        ]);

        return implode("\n\n", $sections);
    }

    public function searchProducts(?Shop $shop, string $query, int $limit = 6): Collection
    {
        if (!$shop) {
            return collect();
        }

        $keywords = $this->extractKeywords($query);

        if (empty($keywords)) {
            return Product::query()
                ->where('shop_id', $shop->id)
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->orderByDesc('created_at')
                ->limit($limit)
                ->get(['id', 'name', 'price', 'stock', 'brand', 'short_description', 'description', 'category_id']);
        }

        return Product::query()
            ->where('shop_id', $shop->id)
            ->where('is_active', true)
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('name', 'like', "%{$word}%")
                        ->orWhere('short_description', 'like', "%{$word}%")
                        ->orWhere('description', 'like', "%{$word}%")
                        ->orWhere('brand', 'like', "%{$word}%")
                        ->orWhereHas('category', fn ($cat) => $cat->where('name', 'like', "%{$word}%"));
                }
            })
            ->orderByDesc('stock')
            ->orderBy('price')
            ->limit($limit)
            ->get(['id', 'name', 'price', 'stock', 'brand', 'short_description', 'description', 'category_id']);
    }

    public function formatProductList(Collection $products): string
    {
        if ($products->isEmpty()) {
            return '';
        }

        return $products->map(function (Product $product) {
            $price = number_format((float) $product->price, 2, ',', ' ');
            $stock = $product->stock > 0 ? "✓ en stock ({$product->stock})" : '✗ rupture';
            $brand = $product->brand ? " [{$product->brand}]" : '';

            return "• {$product->name}{$brand} — {$price} TND — {$stock}";
        })->implode("\n");
    }

    public function extractOrderNumber(string $text): ?string
    {
        if (preg_match('/\b(ORD-\d{8}-[A-Z0-9]{6})\b/i', $text, $matches)) {
            return strtoupper($matches[1]);
        }

        return null;
    }

    private function buildShopInfo(Shop $shop): string
    {
        $lines = ["### Infos boutique"];
        $lines[] = "- Nom : {$shop->name}";

        if ($shop->description) {
            $lines[] = '- Description : ' . mb_substr(strip_tags($shop->description), 0, 200);
        }

        if ($shop->contact_email) {
            $lines[] = "- Email : {$shop->contact_email}";
        }

        if ($shop->contact_phone) {
            $lines[] = "- Téléphone : {$shop->contact_phone}";
        }

        if ($shop->city) {
            $lines[] = "- Ville : {$shop->city}";
        }

        $settings = $shop->settings;
        if ($settings) {
            $payments = [];
            if ($settings->payment_cod) {
                $payments[] = 'paiement à la livraison';
            }
            if ($settings->payment_bank_transfer) {
                $payments[] = 'virement bancaire';
            }
            if ($settings->payment_card) {
                $payments[] = 'carte bancaire';
            }
            if ($payments) {
                $lines[] = '- Paiements acceptés : ' . implode(', ', $payments);
            }
            if ($settings->whatsapp_number) {
                $lines[] = "- WhatsApp : {$settings->whatsapp_number}";
            }
        }

        return implode("\n", $lines);
    }

    private function buildRelevantProducts(Shop $shop, string $userInput): string
    {
        $products = $this->searchProducts($shop, $userInput);

        if ($products->isEmpty()) {
            return '';
        }

        $lines = ["### Produits pertinents pour cette question"];
        foreach ($products as $product) {
            $price = number_format((float) $product->price, 2, ',', ' ');
            $stock = $product->stock > 0 ? "en stock ({$product->stock})" : 'rupture';
            $desc = $product->short_description ?: $product->description;
            $desc = $desc ? ' — ' . mb_substr(strip_tags($desc), 0, 80) : '';
            $brand = $product->brand ? " [{$product->brand}]" : '';
            $lines[] = "- {$product->name}{$brand} | {$price} TND | {$stock}{$desc}";
        }

        return implode("\n", $lines);
    }

    private function buildOrderLookup(Shop $shop, string $userInput): string
    {
        $orderNumber = $this->extractOrderNumber($userInput);
        if (!$orderNumber) {
            return '';
        }

        $order = Order::query()
            ->where('shop_id', $shop->id)
            ->where('order_number', $orderNumber)
            ->with('items')
            ->first();

        if (!$order) {
            return "### Commande {$orderNumber}\n- Introuvable dans notre système. Vérifiez le numéro.";
        }

        $status = $this->translateOrderStatus($order->status);
        $total = number_format((float) $order->total, 2, ',', ' ');
        $items = $order->items->map(fn ($i) => "{$i->product_name} x{$i->quantity}")->implode(', ');

        return implode("\n", [
            "### Commande {$order->order_number}",
            "- Statut : {$status}",
            "- Total : {$total} TND",
            "- Paiement : {$order->payment_status}",
            "- Articles : {$items}",
            "- Client : {$order->customer_name}",
        ]);
    }

    private function buildUserOrders(Shop $shop): string
    {
        if (!auth()->check()) {
            return '';
        }

        $orders = Order::query()
            ->where('shop_id', $shop->id)
            ->where('customer_email', auth()->user()->email)
            ->latest()
            ->limit(3)
            ->get(['order_number', 'status', 'total', 'created_at']);

        if ($orders->isEmpty()) {
            return '';
        }

        $lines = ['### Dernières commandes du client connecté'];
        foreach ($orders as $order) {
            $total = number_format((float) $order->total, 2, ',', ' ');
            $status = $this->translateOrderStatus($order->status);
            $date = $order->created_at->format('d/m/Y');
            $lines[] = "- {$order->order_number} | {$status} | {$total} TND | {$date}";
        }

        return implode("\n", $lines);
    }

    private function extractKeywords(string $text): array
    {
        $stopWords = [
            'je', 'tu', 'il', 'nous', 'vous', 'les', 'des', 'une', 'un', 'le', 'la', 'de', 'du',
            'et', 'ou', 'en', 'au', 'aux', 'pour', 'par', 'sur', 'avec', 'sans', 'est', 'sont',
            'que', 'qui', 'quoi', 'comment', 'combien', 'prix', 'produit', 'produits', 'acheter',
            'chercher', 'cherche', 'vouloir', 'veux', 'voudrais', 'bonjour', 'salut', 'merci',
            'avez', 'avoir', 'est-ce', 'quel', 'quelle', 'quels', 'quelles', 'the', 'a', 'an',
        ];

        $words = preg_split('/\s+/', mb_strtolower(trim($text)));
        $keywords = [];

        foreach ($words as $word) {
            $word = preg_replace('/[^a-zàâäéèêëïîôùûüç0-9-]/u', '', $word);
            if (strlen($word) >= 3 && !in_array($word, $stopWords, true)) {
                $keywords[] = $word;
            }
        }

        return array_unique($keywords);
    }

    private function translateOrderStatus(string $status): string
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
}
