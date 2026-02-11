<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id', // معرف السلة التابع لها الصنف
        'product_id', // معرف المنتج المضاف للسلة
        'quantity', // الكمية المطلوبة (تدعم الكسور للأوزان)
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على السلة التابع لها هذا الصنف
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class); // الصنف ينتمي لسلة واحدة
    }

    /**
     * الحصول على المنتج الخاص بهذا الصنف
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // الصنف يشير لمنتج واحد
    }
}
