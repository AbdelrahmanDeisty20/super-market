<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name_ar' => 'جهينة', 'name_en' => 'Juhayna', 'image' => 'super-market.jpg'],
            ['name_ar' => 'المراعي', 'name_en' => 'Almarai', 'image' => 'super-market.jpg'],
            ['name_ar' => 'بيبسي', 'name_en' => 'Pepsi', 'image' => 'super-market.jpg'],
            ['name_ar' => 'كوكا كولا', 'name_en' => 'Coca-Cola', 'image' => 'super-market.jpg'],
            ['name_ar' => 'نستلة', 'name_en' => 'Nestle', 'image' => 'super-market.jpg'],
            ['name_ar' => 'برسيل', 'name_en' => 'Persil', 'image' => 'super-market.jpg'],
            ['name_ar' => 'إريال', 'name_en' => 'Ariel', 'image' => 'super-market.jpg'],
            ['name_ar' => 'شيبسي', 'name_en' => 'Chipsy', 'image' => 'super-market.jpg'],
            ['name_ar' => 'جالاكسي', 'name_en' => 'Galaxy', 'image' => 'super-market.jpg'],
            ['name_ar' => 'حلواني أخوان', 'name_en' => 'Halwani Bros', 'image' => 'super-market.jpg'],
            ['name_ar' => 'الضحى', 'name_en' => 'El Doha', 'image' => 'super-market.jpg'],
            ['name_ar' => 'ليبتون', 'name_en' => 'Lipton', 'image' => 'super-market.jpg'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['name_en' => $brand['name_en']], $brand);
        }
    }
}
