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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Unique ID for each item in the order
            $table->foreignId('order_id')->constrained()->cascadeOnDelete(); // Link to the parent order
            $table->foreignId('product_id')->constrained()->cascadeOnDelete(); // Link to the product purchased
            $table->decimal('quantity', 10, 2); // Amount purchased (Supports kg/weighted items)
            $table->decimal('price', 10, 2); // Price snapshot at time of purchase (prevents historical changes)
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
