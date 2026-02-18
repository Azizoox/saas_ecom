<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all shops and their categories
        $shops = Shop::all();
        
        if ($shops->isEmpty()) {
            $this->command->info('No shops found. Please create shops first.');
            return;
        }

        // Define sample products for each category
        $products = [
            // Électronique
            [
                'name' => 'Smartphone dernière génération',
                'description' => 'Smartphone haut de gamme avec écran OLED, caméra triple, et batterie longue durée',
                'price' => 899.99,
                'stock' => 25,
                'sku' => 'PHONE-001',
                'brand' => 'TechBrand'
            ],
            [
                'name' => 'Ordinateur portable professionnel',
                'description' => 'PC portable performant pour le travail et les jeux, processeur i7, 16GB RAM',
                'price' => 1299.99,
                'stock' => 15,
                'sku' => 'LAPTOP-001',
                'brand' => 'TechPro'
            ],
            [
                'name' => 'Casque audio sans fil',
                'description' => 'Casque Bluetooth avec réduction de bruit active et autonomie 30h',
                'price' => 199.99,
                'stock' => 40,
                'sku' => 'HEAD-001',
                'brand' => 'SoundMax'
            ],
            
            // Vêtements
            [
                'name' => 'T-shirt coton bio',
                'description' => 'T-shirt confortable en coton biologique, disponible en plusieurs couleurs',
                'price' => 29.99,
                'stock' => 100,
                'sku' => 'TSHIRT-001',
                'brand' => 'EcoWear'
            ],
            [
                'name' => 'Jean slim fit',
                'description' => 'Jean élégant coupe slim en denim de qualité supérieure',
                'price' => 79.99,
                'stock' => 60,
                'sku' => 'JEAN-001',
                'brand' => 'DenimStyle'
            ],
            
            // Maison & Jardin
            [
                'name' => 'Lampe de bureau LED',
                'description' => 'Lampe de bureau réglable avec éclairage LED, idéale pour le travail',
                'price' => 49.99,
                'stock' => 35,
                'sku' => 'LAMP-001',
                'brand' => 'HomeLight'
            ],
            [
                'name' => 'Set de couverts 24 pièces',
                'description' => 'Service de table en acier inoxydable, 24 pièces avec étui de rangement',
                'price' => 39.99,
                'stock' => 20,
                'sku' => 'CUTLERY-001',
                'brand' => 'KitchenPro'
            ],
            
            // Sports & Loisirs
            [
                'name' => 'Vélo de montagne',
                'description' => 'VTT professionnel avec suspension avant, 21 vitesses, cadre aluminium',
                'price' => 499.99,
                'stock' => 8,
                'sku' => 'BIKE-001',
                'brand' => 'MountainPro'
            ],
            [
                'name' => 'Raquette de tennis professionnelle',
                'description' => 'Raquette de tennis en carbone, poids équilibré pour performance optimale',
                'price' => 129.99,
                'stock' => 12,
                'sku' => 'RACKET-001',
                'brand' => 'SportTech'
            ],
            
            // Beauté & Santé
            [
                'name' => 'Crème hydratante anti-âge',
                'description' => 'Crème de jour enrichie en vitamines et acide hyaluronique',
                'price' => 34.99,
                'stock' => 75,
                'sku' => 'CREAM-001',
                'brand' => 'BeautyCare'
            ]
        ];

        foreach ($shops as $shop) {
            // Get categories for this shop
            $categories = Category::where('shop_id', $shop->id)->get();
            
            if ($categories->isEmpty()) {
                $this->command->info("No categories found for shop: {$shop->name}");
                continue;
            }
            
            // Create 3-5 products per category
            foreach ($categories as $category) {
                // Take 3-5 products from our list for each category
                $categoryProducts = array_slice($products, 0, rand(3, 5));
                
                foreach ($categoryProducts as $productData) {
                    Product::create([
                        'shop_id' => $shop->id,
                        'category_id' => $category->id,
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                        'sku' => $productData['sku'] . '-' . $shop->id . '-' . $category->id,
                        'brand' => $productData['brand'],
                        'is_active' => true,
                        'short_description' => substr($productData['description'], 0, 100) . '...'
                    ]);
                }
            }
            
            $this->command->info("Created products for shop: {$shop->name}");
        }
    }
}
