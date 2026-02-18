<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $shops = $user->shops;
        
        // Compter le nombre total de produits
        $totalProducts = Product::whereIn('shop_id', $shops->pluck('id'))->count();
        
        // Compter le nombre total de catégories
        $totalCategories = Category::whereIn('shop_id', $shops->pluck('id'))->count();
        $totalOrders = Order::whereIn('shop_id', $shops->pluck('id'))->count();

        return view('dashboard.index', [
            'user' => $user,
            'shops' => $shops,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalOrders' => $totalOrders,
        ]);
    }
}
