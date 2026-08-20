<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete(); // Foreign key to orders table with cascade on delete
            $table->foreignId('product_id')->constrained(); // Foreign key to products table not on cascade to preserve data history
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_price_cents'); // unitary price in the moment of the order, to avoid issues with price changes assinged ad checkout
            $table->unsignedInteger('subtotal_cents'); // quantity * unit_price_cents, stored to avoid recalculation and potential floating point issues
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
