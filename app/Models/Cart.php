<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', // معرف المستخدم صاحب سلة التسوق
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على المستخدم صاحب السلة
     */
    public function user()
    {
        return $this->belongsTo(User::class); // السلة تنتمي لمستخدم واحد
    }

    /**
     * الحصول على جميع الأصناف الموجودة داخل السلة
     */
    public function items()
    {
        return $this->hasMany(CartItem::class); // السلة تحتوي على أصناف متعددة
    }
}
