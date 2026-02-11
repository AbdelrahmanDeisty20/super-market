<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id', // معرف المنتج التابعة له الصورة
        'image', // مسار الصورة
        'order', // ترتيب ظهور الصورة في المعرض
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على المنتج التابع له هذه الصورة
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // الصورة تنتمي لمنتج واحد
    }
}
