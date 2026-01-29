<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name_ar",
        "name_en",
        "description_ar",
        "description_en",
        "price",
        "stock",
        "brand_id",
        "category_id",
        "image",
    ];
    public function getNameAttribute()
    {
        $lang = app()->getLocale();
        return $this->{"name_{$lang}"};
    }
    public function getDescriptionAttribute()
    {
        $lang = app()->getLocale();
        return $this->{"description_{$lang}"};
    }
    public function getImagePathAttribute()
    {
        return asset('storage/app/public/products/'.$this->image);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
