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
        Schema::create('banners', function (Blueprint $table) {
            $table->id(); // Unique ID for each banner
            $table->string('image'); // Banner background image
            $table->string('title_ar')->nullable(); // Arabic heading text on banner
            $table->string('title_en')->nullable(); // English heading text on banner
            $table->text('description_ar')->nullable(); // Arabic sub-text
            $table->text('description_en')->nullable(); // English sub-text
            $table->string('url')->nullable(); // Target link when clicked
            $table->boolean('is_active')->default(true); // Toggle to enable/disable banner
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
