<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Unit extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name_ar', // اسم وحدة القياس بالعربية (مثال: كيلو)
        'name_en', // اسم وحدة القياس بالإنجليزية (مثال: kg)
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على الاسم المترجم للوحدة
     */
    public function getNameAttribute()
    {
        return $this->getTranslatedValue('name');
    }

    /**
     * الحصول على جميع المنتجات التي تستخدم هذه الوحدة
     */
    public function products()
    {
        return $this->hasMany(Product::class); // الوحدة الواحدة يمكن أن تستخدم في منتجات متعددة
    }
}
