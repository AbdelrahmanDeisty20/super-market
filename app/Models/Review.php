<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id', // معرف المنتج الذي يتم تقييمه
        'user_id', // معرف المستخدم الذي كتب التقييم
        'comment', // نص التقييم (اختياري)
        'rating', // درجة التقييم (مثال: من 1 إلى 5)
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على المنتج التابع له التقييم
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // التقييم ينتمي لمنتج واحد
    }

    /**
     * الحصول على المستخدم الذي قام بالتقييم
     */
    public function user()
    {
        return $this->belongsTo(User::class); // التقييم ينتمي لمستخدم واحد
    }
}
