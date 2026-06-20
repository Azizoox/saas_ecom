<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifier si la colonne email_verified_at existe déjà
        if (!Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }
        
        // Ajouter verification_token si elle n'existe pas
        if (!Schema::hasColumn('users', 'verification_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('verification_token')->nullable()->after('email_verified_at');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'verification_token')) {
                $table->dropColumn('verification_token');
            }
            // Ne pas drop email_verified_at car elle vient de la migration originale
        });
    }
};