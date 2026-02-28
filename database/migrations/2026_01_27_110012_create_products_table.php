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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Unique ID for each product
            $table->string('name_ar'); // Arabic product name
            $table->string('name_en')->nullable(); // English product name
            $table->text('description_ar'); // Detailed Arabic description
            $table->text('description_en')->nullable(); // Detailed English description
            $table->decimal('price', 10, 2); // Regular selling price
            $table->decimal('discount_price', 10, 2)->nullable()->default(null); // Discounted price if applicable, null means no discount
            $table->integer('stock'); // Available quantity in stock
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Link to product category
            $table->foreignId('brand_id')->constrained()->onDelete('cascade'); // Link to product brand
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete(); // Link to measurement unit (e.g., kg)
            $table->decimal('min_quantity', 10, 2)->default(1); // Minimum purchase amount
            $table->decimal('step_quantity', 10, 2)->default(1); // Increment amount (e.g., +0.5 kg)
            $table->boolean('is_featured')->default(false); // Badge for featured/popular items
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
