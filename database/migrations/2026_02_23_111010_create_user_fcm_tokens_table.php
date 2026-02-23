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
        // إنشاء جدول خاص لحفظ رموز أجهزة المستخدمين (يدعم تسجيل الدخول من أكثر من جهاز)
        Schema::create('user_fcm_tokens', function (Blueprint $table) {
            $table->id();
            // ربط التوكن بالمستخدم وحذفه تلقائياً عند حذف المستخدم
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->text('fcm_token'); // رمز الجهاز الخاص بـ Firebase
            $table->string('device_id')->nullable(); // معرف الجهاز (اختياري للتمييز بين الأجهزة)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_fcm_tokens');
    }
};
