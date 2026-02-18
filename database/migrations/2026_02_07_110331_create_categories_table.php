<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Foreign key constraint for parent_id (auto-référence)
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
            
            // Foreign key for shop_id if you have a shops table
            // Uncomment this if your shops table exists
            // $table->foreign('shop_id')
            //       ->references('id')
            //       ->on('shops')
            //       ->onDelete('cascade');
            
            // Indexes
            $table->index(['shop_id']);
            $table->index(['parent_id']);
            $table->index(['is_active']);
            $table->index(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Important: Désactiver temporairement les vérifications de clés étrangères
        Schema::disableForeignKeyConstraints();
        
        Schema::dropIfExists('categories');
        
        // Réactiver les vérifications de clés étrangères
        Schema::enableForeignKeyConstraints();
    }
};