<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title_ar', // عنوان الصفحة بالعربية
        'title_en', // عنوان الصفحة بالإنجليزية
        'content_ar', // محتوى الصفحة بالعربية
        'content_en', // محتوى الصفحة بالإنجليزية
    ]; // الحقول القابلة للتعبئة

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
}
