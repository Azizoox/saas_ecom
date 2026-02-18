<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesStatsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShopComponentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Test route
Route::get('/test-db', function() {
    try {
        $shops = \App\Models\Shop::all();
        $products = \App\Models\Product::all();
        return response()->json([
            'shops_count' => $shops->count(),
            'products_count' => $products->count(),
            'shops' => $shops->take(5)->map(fn($s) => ['id' => $s->id, 'subdomain' => $s->subdomain]),
            'products' => $products->take(5)->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'shop_id' => $p->shop_id])
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Route d'accueil - redirige vers login
Route::get('/', function () {
    return view('landing');
});

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Debug routes
Route::get('/debug-shops', function() {
    try {
        $shops = \App\Models\Shop::all();
        $products = \App\Models\Product::all();
        
        return response()->json([
            'shops' => $shops->map(fn($s) => ['id' => $s->id, 'subdomain' => $s->subdomain, 'name' => $s->name, 'status' => $s->status]),
            'products' => $products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'shop_id' => $p->shop_id, 'is_active' => $p->is_active])
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/debug-shop/{subdomain}', function($subdomain) {
    try {
        $shop = \App\Models\Shop::where('subdomain', $subdomain)->first();
        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }
        
        $products = \App\Models\Product::where('shop_id', $shop->id)->get();
        
        return response()->json([
            'shop' => ['id' => $shop->id, 'subdomain' => $shop->subdomain, 'name' => $shop->name, 'status' => $shop->status],
            'products' => $products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'is_active' => $p->is_active])
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Routes authentifiées (dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    
    // Routes pour les produits
    Route::resource('products', ProductController::class);
    
    // Route de test pour le formulaire
    // Route::get('/test-product-form', function() {
    //     $user = auth()->user();
    //     $shops = $user->shops;
    //     return view('products.create_advanced', ['shops' => $shops]);
    // })->name('test.product.form');

    // Routes pour les commandes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Factures
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/orders/{order}/invoice', [InvoiceController::class, 'generate'])->name('invoices.generate');
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/orders/{order}/invoice/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');

    // Logistique (ramassage / emballage / retours)
    Route::get('/logistics/pickups', [LogisticsController::class, 'pickups'])->name('logistics.pickups');
    Route::get('/logistics/pickups/slip', [LogisticsController::class, 'pickupSlip'])->name('logistics.pickups.slip');
    Route::post('/logistics/pickups/{order}/picked', [LogisticsController::class, 'markPickedUp'])->name('logistics.pickups.picked');

    Route::get('/logistics/packings', [LogisticsController::class, 'packings'])->name('logistics.packings');
    Route::post('/logistics/packings/{order}/packed', [LogisticsController::class, 'markPacked'])->name('logistics.packings.packed');
    Route::get('/logistics/packings/{order}/label', [LogisticsController::class, 'label'])->name('logistics.packings.label');

    Route::get('/logistics/returns', [LogisticsController::class, 'returns'])->name('logistics.returns');
    Route::post('/logistics/returns/{return}', [LogisticsController::class, 'updateReturn'])->name('logistics.returns.update');

    // Statistiques ventes
    Route::get('/stats/sales', [SalesStatsController::class, 'index'])->name('stats.sales');
    
    // Routes pour les paramètres
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general');
    Route::put('/settings/company', [SettingsController::class, 'updateCompany'])->name('settings.company');
    Route::put('/settings/address', [SettingsController::class, 'updateAddress'])->name('settings.address');
    Route::put('/settings/display', [SettingsController::class, 'updateDisplay'])->name('settings.display');
    Route::put('/settings/payments', [SettingsController::class, 'updatePayments'])->name('settings.payments');
    Route::put('/settings/social', [SettingsController::class, 'updateSocial'])->name('settings.social');

    // Routes pour les catégories
    Route::resource('categories', CategoryController::class);
    
    // Route pour obtenir les sous-catégories
    Route::get('/categories/subcategories/{parentId}', [CategoryController::class, 'getSubcategories'])->name('categories.subcategories');
    
    // Routes pour le Builder de la page d'accueil
    Route::get('/builder', [ShopComponentController::class, 'index'])->name('builder.index');
    Route::post('/builder/components', [ShopComponentController::class, 'store'])->name('builder.store');
    Route::put('/builder/components/{component}', [ShopComponentController::class, 'update'])->name('builder.update');
    Route::delete('/builder/components/{component}', [ShopComponentController::class, 'destroy'])->name('builder.destroy');
    Route::post('/builder/reorder', [ShopComponentController::class, 'reorder'])->name('builder.reorder');
});

// Routes pour les boutiques (localhost/shop/{subdomain})
Route::prefix('shop/{subdomain}')->middleware([\App\Http\Middleware\HandleTenancy::class])->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    
    Route::get('/product/{id}', [ShopController::class, 'showProduct'])->name('shop.product');
    
    Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
    
    Route::get('/page/{slug}', [ShopController::class, 'showPage'])->name('shop.page');
    
    // Routes pour le panier
    Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('shop.cart.add');
    Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('shop.cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('shop.cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('shop.cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('shop.cart.count');
    
    // Routes pour la commande
    Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
    Route::post('/process-order', [ShopController::class, 'processOrder'])->name('shop.process-order');
});

// Routes API pour le panier
// Route::prefix('api')->group(function () {
//     Route::post('/cart/add', [CartController::class, 'addToCart']);
//     Route::post('/cart/update', [CartController::class, 'updateQuantity']);
//     Route::post('/cart/remove', [CartController::class, 'removeFromCart']);
//     Route::post('/cart/clear', [CartController::class, 'clearCart']);
//     Route::get('/cart/count', [CartController::class, 'getCartCount']);
// });