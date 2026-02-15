<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, \App\Traits\HasImageUrls;

    protected $fillable = ['key', 'value', 'type'];

    /**
     * Get setting value by key.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        if ($setting->type === 'image') {
            return (new self)->getImageUrl($setting->value);
        }

        return $setting->value;
    }
}
