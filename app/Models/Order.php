<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status', // حالة الطلب (قيد الانتظار، تم الشحن، إلخ)
        'delivery_date', // تاريخ التوصيل المختار
        'delivery_time', // وقت التوصيل المختار
        'subtotal', // المجموع الفرعي للطلبات
        'delivery_fee', // رسوم التوصيل
        'total', // المجموع الكلي النهائي للطلب
        'address_id', // معرف عنوان التوصيل المختار
        'user_id', // معرف المستخدم صاحب الطلب
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على المستخدم الذي قام بالطلب
     */
    public function user()
    {
        return $this->belongsTo(User::class); // الطلب ينتمي لمستخدم واحد
    }

    /**
     * الحصول على عنوان التوصيل الخاص بالطلب
     */
    public function address()
    {
        return $this->belongsTo(UserAddress::class); // الطلب له عنوان توصيل واحد
    }

    /**
     * الحصول على جميع أصناف المنتجات داخل الطلب
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class); // الطلب يحتوي على أصناف متعددة
    }
}
