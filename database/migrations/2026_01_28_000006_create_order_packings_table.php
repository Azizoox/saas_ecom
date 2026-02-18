<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_packings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');

            $table->string('status')->default('pending'); // pending, packed
            $table->dateTime('packed_at')->nullable();

            // basic label data (can be extended)
            $table->string('label_reference')->nullable();

            $table->timestamps();
            $table->unique(['order_id']);
            $table->index(['shop_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_packings');
    }
};

