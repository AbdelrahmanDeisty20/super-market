<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'user_id', // معرف المستخدم صاحب التقييم
        'comment', // نص التعليق أو الرأي
        'rating', // التقييم بالنجوم (1-5)
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على المستخدم صاحب الرأي
     */
    public function user()
    {
        return $this->belongsTo(User::class); // الرأي ينتمي لمستخدم واحد
    }
}
