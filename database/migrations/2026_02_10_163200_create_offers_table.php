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
        Schema::create('offers', function (Blueprint $table) {
            $table->id(); // Unique ID for each offer
            $table->string('title_ar'); // Arabic title of the offer
            $table->string('title_en')->nullable(); // English title
            $table->text('description_ar')->nullable(); // Arabic description
            $table->text('description_en')->nullable(); // English description
            $table->string('image')->nullable(); // Promotional image for the offer
            $table->enum('type', ['fixed', 'percentage', 'bogo']); // Type: Fixed, Percentage, or Buy 1 Get 1
            $table->decimal('value', 10, 2)->nullable(); // Discount value
            $table->dateTime('start_date')->nullable(); // Offer start time
            $table->dateTime('end_date')->nullable(); // Offer end time
            $table->boolean('is_active')->default(true); // Toggle to enable/disable offer
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
