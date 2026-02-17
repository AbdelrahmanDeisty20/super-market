<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug',
        'title_ar', // عنوان الصفحة بالعربية
        'title_en', // عنوان الصفحة بالإنجليزية
        'content_ar', // محتوى الصفحة بالعربية
        'content_en', // محتوى الصفحة بالإنجليزية
        'sections', // أقسام الصفحة المتعددة
    ]; // الحقول القابلة للتعبئة

    protected $casts = [
        'sections' => 'array',
    ];

    /**
     * الحصول على العنوان المترجم للصفحة
     */
    public function getTitleAttribute()
    {
        return $this->getTranslatedValue('title');
    }

    /**
     * الحصول على المحتوى المترجم للصفحة
     */
    public function getContentAttribute()
    {
        return $this->getTranslatedValue('content');
    }

    /**
     * الحصول على الأقسام المترجمة للصفحة
     */
    public function getSectionsAttribute($value)
    {
        $sections = is_string($value) ? json_decode($value, true) : $value;

        if (empty($sections)) {
            return [];
        }

        $locale = app()->getLocale();

        return array_map(function ($section) use ($locale) {
            $titleAr = $section['title_ar'] ?? '';
            $titleEn = $section['title_en'] ?? '';
            $contentAr = $section['content_ar'] ?? '';
            $contentEn = $section['content_en'] ?? '';

            return [
                'title' => ($locale === 'ar' ? $titleAr : $titleEn) ?: $titleAr,
                'content' => ($locale === 'ar' ? $contentAr : $contentEn) ?: $contentAr,
            ];
        }, $sections);
    }
}
