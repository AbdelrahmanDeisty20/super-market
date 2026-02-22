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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // Unique ID for each coupon
            $table->string('code')->unique(); // Unique code user enters (e.g., SAVE10)
            $table->enum('type', ['fixed', 'percentage']); // Type of discount
            $table->decimal('value', 10, 2); // The discount amount or percentage
            $table->decimal('min_order_value', 10, 2)->default(0); // Minimum order amount to apply coupon
            $table->dateTime('start_date')->nullable(); // When the coupon becomes valid
            $table->dateTime('end_date')->nullable(); // When the coupon expires
            $table->integer('usage_limit')->nullable(); // Max times coupon can be used
            $table->integer('used_count')->default(0); // Current usage count
            $table->boolean('is_active')->default(true); // Toggle to enable/disable coupon
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
