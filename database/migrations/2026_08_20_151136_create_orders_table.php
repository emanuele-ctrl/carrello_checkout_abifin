<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Unique order code for recap page
            // no user id as we don't need to authenticate, clients' data are stored as normal string
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_address');
            $table->text('notes')->nullable(); // Notes must be nullable
            $table->unsignedInteger('total_cents'); //total to show the user: "free shipping/6.90€" separated from the total
            $table->unsignedInteger('shipping_cents');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
