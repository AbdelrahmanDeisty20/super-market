<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'address', // العنوان بالكامل (نص احتياطي)
        'label', // تسمية العنوان (مثال: المنزل، العمل)
        'is_default', // هل هذا هو العنوان الافتراضي؟
        'user_id', // معرف المستخدم صاحب العنوان
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على المستخدم صاحب هذا العنوان
     */
    public function user()
    {
        return $this->belongsTo(User::class); // العنوان ينتمي لمستخدم واحد
    }
}
