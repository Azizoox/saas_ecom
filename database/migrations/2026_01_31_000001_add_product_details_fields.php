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
        Schema::table('products', function (Blueprint $table) {
            // Informations générales
            $table->string('reference')->nullable()->after('name');
            $table->string('barcode')->nullable()->after('reference');
            $table->string('supplier')->nullable()->after('barcode');
            $table->string('brand')->nullable()->after('supplier');
            
            // Descriptions
            $table->text('short_description')->nullable()->after('description');
            
            // Images
            $table->json('images')->nullable()->after('image');
            
            // SEO
            $table->string('meta_title')->nullable()->after('images');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            
            // Variantes et groupes
            $table->json('variants')->nullable()->after('meta_keywords');
            $table->unsignedBigInteger('product_group_id')->nullable()->after('variants');
            $table->foreign('product_group_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_group_id']);
            $table->dropColumn([
                'reference',
                'barcode',
                'supplier',
                'brand',
                'short_description',
                'images',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'variants',
                'product_group_id'
            ]);
        });
    }
};