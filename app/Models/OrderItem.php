<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', // معرف الطلب التابع له الصنف
        'product_id', // معرف المنتج الذي تم شراؤه
        'quantity', // الكمية المشتراة
        'price', // سعر المنتج وقت الشراء (لحفظ السجل التاريخي)
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على الطلب التابع له هذا الصنف
     */
    public function order()
    {
        return $this->belongsTo(Order::class); // الصنف ينتمي لطلب واحد
    }

    /**
     * الحصول على المنتج الخاص بهذا الصنف
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // الصنف يشير لمنتج واحد
    }
}
