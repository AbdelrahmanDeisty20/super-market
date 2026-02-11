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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Unique ID for each service/feature
            $table->string('title_ar'); // Service title in Arabic (e.g., توصيل مجاني)
            $table->string('title_en')->nullable(); // Service title in English (e.g., Free Delivery)
            $table->text('content_ar'); // Service description in Arabic
            $table->text('content_en')->nullable(); // Service description in English
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
