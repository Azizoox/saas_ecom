<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTestShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-shop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test shop for development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = \App\Models\User::first();
        
        if (!$user) {
            $user = \App\Models\User::create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'phone' => '123456789',
            ]);
            
            $this->info('Created admin user');
        }
        
        $shop = \App\Models\Shop::create([
            'user_id' => $user->id,
            'name' => 'Magasin Principal',
            'subdomain' => 'main',
            'status' => 'active',
        ]);
        
        $this->info('Created shop: ' . $shop->name);
        $this->info('Shop ID: ' . $shop->id);
        
        $this->info('Test shop created successfully!');
    }
}
