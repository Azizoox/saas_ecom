<?php
require_once __DIR__.'/vendor/autoload.php';

// Create a simple script to check the database
use Illuminate\Support\Facades\DB;

try {
    // Initialize Laravel application
    (require_once __DIR__.'/bootstrap/app.php')
        ->make(Illuminate\Contracts\Console\Kernel::class)
        ->bootstrap();

    // Check if order #10 exists
    $order = DB::table('orders')->where('id', 10)->first();
    
    if ($order) {
        echo "Order #10 exists:\n";
        echo "- ID: " . $order->id . "\n";
        echo "- Shop ID: " . $order->shop_id . "\n";
        echo "- Order Number: " . $order->order_number . "\n";
        
        // Check if the corresponding shop exists
        $shop = DB::table('shops')->where('id', $order->shop_id)->first();
        if ($shop) {
            echo "- Shop Subdomain: " . $shop->subdomain . "\n";
        } else {
            echo "- ERROR: Shop with ID " . $order->shop_id . " does not exist!\n";
        }
    } else {
        echo "Order #10 does not exist in the database.\n";
    }

    // Also check for shop with subdomain 'shopa'
    $shopa = DB::table('shops')->where('subdomain', 'shopa')->first();
    if ($shopa) {
        echo "\nShop 'shopa' exists with ID: " . $shopa->id . "\n";
    } else {
        echo "\nShop 'shopa' does not exist in the database.\n";
    }

    // Check all shops
    echo "\nAll shops in database:\n";
    $shops = DB::table('shops')->get();
    foreach ($shops as $shop) {
        echo "- ID: " . $shop->id . ", Subdomain: " . $shop->subdomain . ", Name: " . $shop->name . ", Status: " . $shop->status . "\n";
    }

    // Check all orders
    echo "\nAll orders in database:\n";
    $orders = DB::table('orders')->get();
    foreach ($orders as $order) {
        echo "- ID: " . $order->id . ", Shop ID: " . $order->shop_id . ", Order Number: " . $order->order_number . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}