<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Crée le compte Super Admin (email + mot de passe).
     * Utilisez les variables d'environnement SUPER_ADMIN_EMAIL et SUPER_ADMIN_PASSWORD
     * ou les valeurs par défaut ci-dessous (à changer en production).
     */
    public function run(): void
    {
        $email = env('SUPER_ADMIN_EMAIL', 'superadmin@shoopino.com');
        $password = env('SUPER_ADMIN_PASSWORD', 'SuperAdmin123!');

        if (User::where('email', $email)->exists()) {
            $this->command->info("Super Admin déjà existant: {$email}");
            return;
        }

        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => $email,
            'phone' => '+21600000000',
            'password' => Hash::make($password),
            'role' => 'super_admin',
        ]);

        $this->command->info("Super Admin créé: {$email}");
        $this->command->warn('En production, définissez SUPER_ADMIN_EMAIL et SUPER_ADMIN_PASSWORD dans .env et changez le mot de passe après la première connexion.');
    }
}
