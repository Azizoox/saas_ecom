<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Shop;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all shops
        $shops = Shop::all();
        
        if ($shops->isEmpty()) {
            $this->command->info('No shops found. Please create shops first.');
            return;
        }

        // Define 10 categories for each shop
        $categories = [
            [
                'name' => 'Électronique',
                'description' => 'Tous vos appareils électroniques et accessoires',
                'icon' => 'bi-laptop',
                'order' => 1
            ],
            [
                'name' => 'Vêtements',
                'description' => 'Mode et vêtements pour hommes et femmes',
                'icon' => 'bi-t-shirt',
                'order' => 2
            ],
            [
                'name' => 'Maison & Jardin',
                'description' => 'Articles pour la maison et le jardin',
                'icon' => 'bi-house-door',
                'order' => 3
            ],
            [
                'name' => 'Sports & Loisirs',
                'description' => 'Équipements sportifs et articles de loisirs',
                'icon' => 'bi-bicycle',
                'order' => 4
            ],
            [
                'name' => 'Beauté & Santé',
                'description' => 'Produits de beauté et articles de santé',
                'icon' => 'bi-heart',
                'order' => 5
            ],
            [
                'name' => 'Alimentation',
                'description' => 'Produits alimentaires et boissons',
                'icon' => 'bi-cup-straw',
                'order' => 6
            ],
            [
                'name' => 'Livres & Papeterie',
                'description' => 'Livres, magazines et fournitures de bureau',
                'icon' => 'bi-book',
                'order' => 7
            ],
            [
                'name' => 'Jeux & Jouets',
                'description' => 'Jeux, jouets et articles pour enfants',
                'icon' => 'bi-controller',
                'order' => 8
            ],
            [
                'name' => 'Auto & Moto',
                'description' => 'Pièces détachées et accessoires automobiles',
                'icon' => 'bi-car-front',
                'order' => 9
            ],
            [
                'name' => 'Bijoux & Montres',
                'description' => 'Bijoux, montres et accessoires de mode',
                'icon' => 'bi-watch',
                'order' => 10
            ]
        ];

        foreach ($shops as $shop) {
            foreach ($categories as $categoryData) {
                // Create unique slug per shop
                $baseSlug = \Illuminate\Support\Str::slug($categoryData['name']);
                $slug = $baseSlug . '-' . $shop->id;
                
                Category::create([
                    'shop_id' => $shop->id,
                    'name' => $categoryData['name'],
                    'slug' => $slug,
                    'description' => $categoryData['description'],
                    'icon' => $categoryData['icon'],
                    'order' => $categoryData['order'],
                    'is_active' => true, // All categories are active
                    'parent_id' => null
                ]);
            }
            
            $this->command->info("Created 10 categories for shop: {$shop->name}");
        }
    }
}
