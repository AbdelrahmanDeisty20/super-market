<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
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
}
