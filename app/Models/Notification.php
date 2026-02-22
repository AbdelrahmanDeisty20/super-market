<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // الحقول المسموح بتعبئتها دفعة واحدة
    protected $fillable = [
        'user_id', // العميل المستهدف
        'title',   // عنوان الإشعار
        'body',    // نص الإشعار
        'type',    // نوع الإشعار (مثل طلب جديد، عرض خاص)
        'data',    // مصفوفة بيانات إضافية
        'read_at', // تاريخ القراءة
    ];

    // تحويل الحقول لأنواع بيانات محددة تلقائياً
    protected $casts = [
        'data' => 'array',     // يتم تخزينها كـ JSON في القاعدة وتخرج كمصفوفة
        'read_at' => 'datetime', // تاريخ وقت
    ];

    /**
     * علاقة الإشعار بصاحب الحساب
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
