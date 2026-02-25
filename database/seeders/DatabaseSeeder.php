<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Run seeders in order
        $this->call([
            SuperAdminSeeder::class,
            CategorySeeder::class,
            CashRegisterSeeder::class,
        ]);
    }
}
