<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'session_id'
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Static methods for cart operations
    public static function addToCart($productId, $quantity = 1, $userId = null)
    {
        $sessionId = Session::getId();
        
        // Check if item already exists in cart
        $cartItem = self::where('product_id', $productId)
            ->where('session_id', $sessionId)
            ->first();

        if ($cartItem) {
            // Update quantity if item already exists
            $cartItem->increment('quantity', $quantity);
        } else {
            // Create new cart item
            self::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'session_id' => $sessionId
            ]);
        }
    }

    public static function getCartItems($userId = null)
    {
        $sessionId = Session::getId();
        
        return self::with('product')
            ->where(function($query) use ($sessionId, $userId) {
                $query->where('session_id', $sessionId);
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->get();
    }

    public static function updateQuantity($productId, $quantity, $userId = null)
    {
        $sessionId = Session::getId();
        
        $cartItem = self::where('product_id', $productId)
            ->where('session_id', $sessionId)
            ->first();

        if ($cartItem) {
            if ($quantity <= 0) {
                $cartItem->delete();
            } else {
                $cartItem->update(['quantity' => $quantity]);
            }
        }
    }

    public static function removeFromCart($productId, $userId = null)
    {
        $sessionId = Session::getId();
        
        self::where('product_id', $productId)
            ->where('session_id', $sessionId)
            ->delete();
    }

    public static function clearCart($userId = null)
    {
        $sessionId = Session::getId();
        
        self::where('session_id', $sessionId)
            ->when($userId, function($query, $userId) {
                $query->orWhere('user_id', $userId);
            })
            ->delete();
    }

    public static function getTotalPrice($userId = null)
    {
        $cartItems = self::getCartItems($userId);
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        return $total;
    }

    public static function getCartCount($userId = null)
    {
        $cartItems = self::getCartItems($userId);
        $count = 0;

        foreach ($cartItems as $item) {
            $count += $item->quantity;
        }

        return $count;
    }
}