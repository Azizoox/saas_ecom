<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $shop = app('shop');

        if (!$shop) {
            abort(404);
        }

        $page = $shop->pages()->where('slug', 'accueil')->first();
        $productsQuery = Product::where('shop_id', $shop->id)->where('is_active', true);

        $currentCategory = null;
        $categorySlug = $request->query('category');
        if ($categorySlug) {
            $currentCategory = $shop->categories()->where('slug', $categorySlug)->where('is_active', true)->first();
            if ($currentCategory) {
                $productsQuery->where('category_id', $currentCategory->id);
            }
        }

        $products = $productsQuery->get();
        $components = $shop->components()->where('is_active', true)->orderBy('order')->get();

        // If there's a category filter, use the category products view
        if ($currentCategory) {
            return view('shop.category-products', [
                'shop' => $shop,
                'products' => $products,
                'currentCategory' => $currentCategory,
            ]);
        }
        
        return view('shop.index', [
            'shop' => $shop,
            'page' => $page,
            'products' => $products,
            'components' => $components,
            'currentCategory' => $currentCategory,
        ]);
    }

    // public function page(string $slug): View
    // {
    //     $shop = app('shop');
        
    //     if (!$shop) {
    //         abort(404);
    //     }

    //     $page = $shop->pages()
    //         ->where('slug', $slug)
    //         ->where('is_active', true)
    //         ->firstOrFail();

    //     // Si c'est la page "Boutique", charger les produits
    //     $products = null;
    //     if ($slug === 'boutique') {
    //         $products = $shop->products()
    //             ->where('is_active', true)
    //             ->orderBy('created_at', 'desc')
    //             ->get();
    //     }

    //     return view('shop.page', [
    //         'shop' => $shop,
    //         'page' => $page,
    //         'products' => $products,
    //     ]);
    // }
    public function showProduct(string $subdomain, string $id): View
    {
        Log::info('showProduct called with subdomain: ' . $subdomain . ', id: ' . $id);
        
        // Charger la boutique
        $shop = Shop::where('subdomain', $subdomain)
            ->where('status', 'active')
            ->first();
            
        Log::info('Shop found: ' . ($shop ? $shop->id : 'null'));
        
        if (!$shop) {
            Log::error('Shop not found for subdomain: ' . $subdomain);
            abort(404);
        }

        // Charger le produit
        $productId = (int) $id;
        $product = Product::where('id', $productId)
            ->where('shop_id', $shop->id)
            ->where('is_active', true)
            ->first();
            
        Log::info('Product found: ' . ($product ? $product->id : 'null'));

        if (!$product) {
            Log::error('Product not found or not active', [
                'product_id' => $productId,
                'shop_id' => $shop->id
            ]);
            abort(404);
        }
        
        Log::info('Product validation passed');

        // Produits similaires
        $relatedProducts = Product::where('shop_id', $shop->id)
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('shop.product-show', [
            'shop' => $shop,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
    
    public function checkout()
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        $cartItems = \App\Models\Cart::getCartItems(Auth::id());
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index', ['subdomain' => $shop->subdomain])->with('error', 'Votre panier est vide.');
        }
        
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        
        $shippingCost = 0; // Free shipping for now
        $totalPrice = $subtotal + $shippingCost;
        
        return view('shop.checkout', [
            'shop' => $shop,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'totalPrice' => $totalPrice,
        ]);
    }
    
    public function processOrder(Request $request)
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|in:card,paypal',
        ]);
        
        $cartItems = \App\Models\Cart::getCartItems(Auth::id());
        
        if ($cartItems->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Votre panier est vide.']);
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        
        $shippingCost = 0; // Free shipping for now
        $totalPrice = $subtotal + $shippingCost;
        
        // Create order + items transactionally
        DB::transaction(function () use ($shop, $request, $cartItems, $subtotal, $shippingCost, $totalPrice) {
            /** @var Order $order */
            $order = Order::create([
                'shop_id' => $shop->id,
                'customer_name' => $request->first_name . ' ' . $request->last_name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_postal_code' => $request->postal_code,
                'shipping_state' => null,
                'shipping_country' => $request->country,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => Order::STATUS_NEW,
                'subtotal' => $subtotal,
                'shipping_total' => $shippingCost,
                'discount_total' => 0,
                'total' => $totalPrice,
                'notes' => null,
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'sku' => $item->product->sku,
                    'unit_price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'line_total' => 0, // recalculated in model
                ]);

                // Optionally decrease stock
                if ($item->product->stock !== null) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Record initial status history
            $order->statusHistories()->create([
                'from_status' => null,
                'to_status' => $order->status,
                'changed_by_user_id' => Auth::id(),
                'note' => 'Commande créée depuis la boutique en ligne',
            ]);
        });

        // Clear cart after successful order
        \App\Models\Cart::clearCart(Auth::id());
        
        return redirect()->route('shop.index', ['subdomain' => $shop->subdomain])
            ->with('success', 'Votre commande a été passée avec succès! Vous pouvez la suivre dans votre tableau de bord vendeur.');
    }
    
    public function showPage(string $subdomain, string $slug)
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        $page = $shop->pages()->where('slug', $slug)->where('is_active', true)->first();
        
        if (!$page) {
            abort(404);
        }
        
        // Load products if this page should display them
        $products = $shop->products()->where('is_active', true)->get();
        
        return view('shop.page', [
            'shop' => $shop,
            'page' => $page,
            'products' => $products,
        ]);
    }
    
    public function search(Request $request)
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        $query = $request->input('q');
        $results = collect();
        
        if ($query) {
            $results = Product::where('shop_id', $shop->id)
                ->where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', '%' . $query . '%')
                      ->orWhere('description', 'LIKE', '%' . $query . '%')
                      ->orWhere('short_description', 'LIKE', '%' . $query . '%');
                })
                ->limit(10)
                ->get();
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products' => $results->map(function($product) use ($shop) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->short_description ?: $product->description,
                        'price' => $product->formatted_price,
                        'image' => $product->image ? asset('storage/' . $product->image) : null,
                        'url' => route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id])
                    ];
                })
            ]);
        }
        
        $components = $shop->components()->where('is_active', true)->orderBy('order')->get();
        
        return view('shop.search-results', [
            'shop' => $shop,
            'products' => $results,
            'query' => $query,
            'components' => $components,
        ]);
    }
}