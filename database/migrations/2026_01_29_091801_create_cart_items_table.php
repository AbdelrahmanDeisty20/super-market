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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // Unique ID for each item in the cart
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete(); // Link to the parent cart
            $table->foreignId('product_id')->constrained()->cascadeOnDelete(); // Link to the product being added
            $table->decimal('quantity', 10, 2); // Amount of product (Decimal supports weights like 0.25kg)
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
