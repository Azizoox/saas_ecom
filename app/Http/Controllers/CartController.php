<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        $cartItems = Cart::getCartItems(Auth::id());
        $totalPrice = Cart::getTotalPrice(Auth::id());
        $displayMode = $shop->settings?->display_mode ?? 'light';
        
        return view('shop.cart', compact('cartItems', 'totalPrice', 'shop', 'displayMode'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is in stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Quantité demandée indisponible en stock.'
            ], 400);
        }

        Cart::addToCart($request->product_id, $request->quantity, Auth::id());

        $cartCount = Cart::getCartCount(Auth::id());
        
        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier avec succès!',
            'cart_count' => $cartCount
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is in stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Quantité demandée indisponible en stock.'
            ], 400);
        }

        Cart::updateQuantity($request->product_id, $request->quantity, Auth::id());

        $cartItems = Cart::getCartItems(Auth::id());
        $totalPrice = Cart::getTotalPrice(Auth::id());
        
        return response()->json([
            'success' => true,
            'cart_items' => $cartItems,
            'total_price' => $totalPrice,
            'cart_count' => Cart::getCartCount(Auth::id())
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        Cart::removeFromCart($request->product_id, Auth::id());

        $cartCount = Cart::getCartCount(Auth::id());
        
        return response()->json([
            'success' => true,
            'message' => 'Produit retiré du panier.',
            'cart_count' => $cartCount
        ]);
    }

    public function clearCart()
    {
        Cart::clearCart(Auth::id());
        
        return response()->json([
            'success' => true,
            'message' => 'Panier vidé avec succès.',
            'cart_count' => 0
        ]);
    }

    public function getCartCount($subdomain)
    {
        $count = auth()->check() 
            ? Cart::getCartCount(auth()->id()) 
            : 0;
            
        return response()->json(['count' => $count]);
    }
}