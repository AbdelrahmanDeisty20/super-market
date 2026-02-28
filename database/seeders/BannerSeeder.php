<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Banner::create([
                'title_ar' => 'بانر إعلاني ' . $i,
                'title_en' => 'Advertising Banner ' . $i,
                'image' => 'super-market.jpg',
                'is_active' => true,
            ]);
        }
    }
}
