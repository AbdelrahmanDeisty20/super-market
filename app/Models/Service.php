<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title_ar', // عنوان الخدمة بالعربية (مثال: شحن مجاني)
        'title_en', // عنوان الخدمة بالإنجليزية
        'content_ar', // وصف الخدمة بالعربية
        'content_en', // وصف الخدمة بالإنجليزية
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على العنوان المترجم للخدمة
     */
    public function getTitleAttribute()
    {
        return $this->getTranslatedValue('title');
    }

    /**
     * الحصول على المحتوى المترجم للخدمة
     */
    public function getContentAttribute()
    {
        return $this->getTranslatedValue('content');
    }
}
