<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Brand extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name_ar', // اسم الماركة بالعربية
        'name_en', // اسم الماركة بالإنجليزية
        'image', // مسار صورة شعار الماركة
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على الاسم المترجم للماركة
     */
    public function getNameAttribute()
    {
        return $this->getTranslatedValue('name');
    }

    /**
     * الحصول على جميع منتجات هذه الماركة
     */
    public function products()
    {
        return $this->hasMany(Product::class); // الماركة تحتوي على منتجات متعددة
    }
}
