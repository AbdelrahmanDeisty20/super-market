<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Super Market', 'type' => 'text'],
            ['key' => 'site_logo', 'value' => 'settings/logo.png', 'type' => 'image'],
            ['key' => 'contact_email', 'value' => 'contact@supermarket.com', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => json_encode(['01234567890', '01122334455']), 'type' => 'json'],
            ['key' => 'address', 'value' => '123 Market St, Cairo, Egypt', 'type' => 'text'],
            ['key' => 'facebook_link', 'value' => 'https://facebook.com/supermarket', 'type' => 'text'],
            ['key' => 'instagram_link', 'value' => 'https://instagram.com/supermarket', 'type' => 'text'],
            ['key' => 'whatsapp_number', 'value' => '01234567890', 'type' => 'text'],
            ['key' => 'currency', 'value' => 'EGP', 'type' => 'text'],
            ['key' => 'min_delivery_fee', 'value' => '30', 'type' => 'text'],
            ['key' => 'home_hero_image', 'value' => json_encode(['settings/hero1.jpg', 'settings/hero2.jpg', 'settings/hero3.jpg']), 'type' => 'image'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}