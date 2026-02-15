<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Offer extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = [
        'title_ar', // عنوان العرض بالعربية
        'title_en', // عنوان العرض بالإنجليزية
        'description_ar', // وصف العرض بالعربية
        'description_en', // وصف العرض بالإنجليزية
        'image', // مسار صورة العرض الترويجية
        'type', // نوع العرض (مبلغ ثابت، نسبة، أو "اشتري 1 واحصل على 1")
        'value', // قيمة الخصم في العرض
        'start_date', // تاريخ بداية العرض
        'end_date', // تاريخ نهاية العرض
        'is_active', // هل العرض مفعل حالياً؟
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على عنوان العرض المترجم
     */
    public function getTitleAttribute()
    {
        return $this->getTranslatedValue('title');
    }

    /**
     * الحصول على وصف العرض المترجم
     */
    public function getDescriptionAttribute()
    {
        return $this->getTranslatedValue('description');
    }

    /**
     * الحصول على المنتجات المشمولة في هذا العرض
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
