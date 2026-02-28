<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name_ar', // اسم المنتج بالعربية
        'name_en', // اسم المنتج بالانجليزية
        'description_ar', // وصف المنتج بالعربية
        'description_en', // وصف المنتج بالانجليزية
        'price', // السعر الأساسي
        'discount_price', // سعر الخصم (إن وجد)
        'stock', // الكمية المتوفرة في المخزن
        'category_id', // معرف القسم التابع له
        'brand_id', // معرف الماركة التابعة لها
        'unit_id', // معرف وحدة القياس (كيلو، قطعة، إلخ)
        'min_quantity', // أقل كمية يمكن شراؤها
        'step_quantity', // مقدار الزيادة عند طلب كمية إضافية
        'is_featured', // هل المنتج مميز (يظهر في المقدمة)؟
    ]; // الحقول القابلة للتعبئة

    /**
     * نطاق لجلب المنتجات التي تنتمي لأقسام مرئية فقط.
     */
    public function scopeVisible($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('is_visible', true);
        });
    }

    /**
     * الحصول على العروض المرتبطة بالمنتج
     */
    public function offers()
    {
        return $this->belongsToMany(Offer::class)->where('is_active', true);
    }

    /**
     * الحصول على الاسم المترجم للمنتج
     */
    public function getNameAttribute()
    {
        return $this->getTranslatedValue('name');
    }

    /**
     * الحصول على الوصف المترجم للمنتج
     */
    public function getDescriptionAttribute()
    {
        return $this->getTranslatedValue('description');
    }

    /**
     * الحصول على القسم التابع له المنتج
     */
    public function category()
    {
        return $this->belongsTo(Category::class); // المنتج ينتمي لقسم واحد
    }

    /**
     * الحصول على الماركة التابعة لها المنتج
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class); // المنتج ينتمي لماركة واحدة
    }

    /**
     * الحصول على وحدة القياس الخاصة بالمنتج
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class); // المنتج له وحدة قياس واحدة
    }

    /**
     * الحصول على جميع صور المنتج الإضافية
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class); // المنتج يمكن أن يحتوي على صور متعددة
    }

    /**
     * الحصول على جميع تقييمات المنتج
     */
    public function reviews()
    {
        return $this->hasMany(Review::class); // المنتج يمكن أن يحصل على تقييمات متعددة
    }
}
