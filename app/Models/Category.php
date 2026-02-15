<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name_ar', // اسم القسم باللغة العربية
        'name_en', // اسم القسم باللغة الانجليزية
        'image', // مسار صورة القسم
        'is_visible', // هل القسم مرئي في الموقع؟
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على الاسم المترجم للقسم
     */
    public function getNameAttribute()
    {
        return $this->getTranslatedValue('name');
    }

    /**
     * الحصول على جميع منتجات هذا القسم
     */
    public function products()
    {
        return $this->hasMany(Product::class); // القسم يحتوي على منتجات متعددة
    }
}
