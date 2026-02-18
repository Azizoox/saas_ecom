<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            
            // Display settings
            $table->string('currency')->default('TND');
            $table->string('language')->default('fr');
            $table->string('timezone')->default('Africa/Tunis');
            $table->string('theme')->default('default');
            $table->string('primary_color')->default('#3490dc');
            $table->enum('display_mode', ['light', 'dark', 'auto'])->default('light');
            $table->string('date_format')->default('d/m/Y');
            
            // Payment settings
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('account_holder')->nullable();
            $table->boolean('payment_cod')->default(true);
            $table->boolean('payment_bank_transfer')->default(false);
            $table->boolean('payment_card')->default(false);
            $table->enum('payment_status', ['pending', 'validated', 'rejected'])->default('pending');
            
            // Social media
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            
            // Legacy fields
            $table->string('logo')->nullable();
            $table->json('settings')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};
