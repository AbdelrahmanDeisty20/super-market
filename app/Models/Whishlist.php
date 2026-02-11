<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whishlist extends Model
{
    protected $fillable = [
        'user_id', // معرف المستخدم صاحب قائمة الأمنيات
        'product_id', // معرف المنتج المضاف للقائمة
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على المستخدم صاحب القائمة
     */
    public function user()
    {
        return $this->belongsTo(User::class); // القائمة تنتمي لمستخدم واحد
    }

    /**
     * الحصول على المنتج المضاف للقائمة
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // القائمة تشير لمنتج واحد
    }
}
