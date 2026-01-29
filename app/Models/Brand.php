<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
    ];

    protected $appends = ['name', 'image_path'];

    protected $hidden = ['name_ar', 'name_en', 'image'];

    public function getNameAttribute()
    {
        $lang = app()->getLocale();
        return $this->{"name_{$lang}"};
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImagePathAttribute()
    {
        return asset('storage/brands/'.$this->image);
    }
}
