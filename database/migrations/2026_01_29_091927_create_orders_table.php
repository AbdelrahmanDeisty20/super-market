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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Unique ID for each order
            $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled'])->default('pending'); // Current status of the order
            $table->date('delivery_date'); // Selected delivery date from UI
            $table->time('delivery_time'); // Selected delivery time from UI (fixed typo)
            $table->decimal('subtotal', 10, 2); // Calculated subtotal for products (changed to decimal)
            $table->decimal('delivery_fee', 10, 2); // Delivery cost based on location (changed to decimal)
            $table->decimal('total', 10, 2); // Final total amount for the order (changed to decimal)
            $table->foreignId('address_id')->constrained('user_addresses')->onDelete('cascade'); // Link to the delivery address
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
