<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'users_count' => User::count(),
            'shops_count' => Shop::count(),
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'orders_count' => Order::count(),
            'orders_pending' => Order::whereIn('status', ['new', 'preparing'])->count(),
            'orders_total_amount' => Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'shops_active' => Shop::where('status', 'active')->count(),
        ];

        $recentUsers = User::where('role', '!=', 'super_admin')
            ->latest()
            ->take(5)
            ->get();

        $recentShops = Shop::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentOrders = Order::with('shop')
            ->latest()
            ->take(10)
            ->get();

        return view('super-admin.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'recentShops' => $recentShops,
            'recentOrders' => $recentOrders,
        ]);
    }
}
