<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'image',
    ];

    protected $appends = ['name', 'image_path'];

    protected $hidden = ['name_ar', 'name_en', 'image'];

    public function getNameAttribute()
    {
        $lang = app()->getLocale();
        return $this->{"name_{$lang}"};
    }

    public function getImagePathAttribute()
    {
        return asset('storage/categories/' . $this->image);
    }
}
