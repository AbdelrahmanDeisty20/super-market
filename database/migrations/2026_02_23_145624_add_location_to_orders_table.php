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
        Schema::table('orders', function (Blueprint $table) {
            // إضافة أعمدة لتخزين آخر موقع معروف للمندوب (إحداثيات GPS)
            $table->decimal('last_lat', 10, 8)->nullable()->after('address_id');
            $table->decimal('last_long', 11, 8)->nullable()->after('last_lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['last_lat', 'last_long']);
        });
    }
};
