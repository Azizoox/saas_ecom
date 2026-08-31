<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CashRegister;

class CashRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default cash registers
        CashRegister::create([
            'name' => 'Caisse Principale',
            'location' => 'Accueil',
            'is_active' => true,
            'opening_balance' => 0,
        ]);
        
        CashRegister::create([
            'name' => 'Caisse Secondaire',
            'location' => 'Arrière-boutique',
            'is_active' => true,
            'opening_balance' => 0,
        ]);
    }
}
