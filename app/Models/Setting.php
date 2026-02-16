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

        if ($setting->type === 'image' && $setting->value) {
            // Check if it's multiple images (JSON array)
            $decoded = json_decode($setting->value, true);
            if (is_array($decoded)) {
                return array_map(function ($path) {
                    return (new self)->getImageUrl($path);
                }, $decoded);
            }

            return (new self)->getImageUrl($setting->value);
        }

        if ($setting->type === 'json' || is_array(json_decode($setting->value, true))) {
            return json_decode($setting->value, true);
        }

        return $setting->value;
    }

    /**
     * Set a setting value.
     */
    public static function setValue(string $key, $value, string $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }
}
