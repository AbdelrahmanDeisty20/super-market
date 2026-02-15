<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Banner extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'image', // مسار صورة البانر (الخلفية)
        'title_ar', // العنوان بالعربية
        'title_en', // العنوان بالإنجليزية
        'description_ar', // الوصف بالعربية
        'description_en', // الوصف بالإنجليزية
        'url', // الرابط الذي يفتح عند الضغط على البانر
        'is_active', // هل البانر مفعل حالياً؟
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على العنوان المترجم للبانر
     */
    public function getTitleAttribute()
    {
        return $this->getTranslatedValue('title');
    }

    /**
     * الحصول على الوصف المترجم للبانر
     */
    public function getDescriptionAttribute()
    {
        return $this->getTranslatedValue('description');
    }
}
