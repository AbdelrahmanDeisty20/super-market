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
            ['name_ar' => 'جهينة', 'name_en' => 'Juhayna', 'image' => 'brands/juhayna.png'],
            ['name_ar' => 'المراعي', 'name_en' => 'Almarai', 'image' => 'brands/almarai.png'],
            ['name_ar' => 'بيبسي', 'name_en' => 'Pepsi', 'image' => 'brands/pepsi.png'],
            ['name_ar' => 'كوكا كولا', 'name_en' => 'Coca-Cola', 'image' => 'brands/coca-cola.png'],
            ['name_ar' => 'نستلة', 'name_en' => 'Nestle', 'image' => 'brands/nestle.png'],
            ['name_ar' => 'برسيل', 'name_en' => 'Persil', 'image' => 'brands/persil.png'],
            ['name_ar' => 'إريال', 'name_en' => 'Ariel', 'image' => 'brands/ariel.png'],
            ['name_ar' => 'شيبسي', 'name_en' => 'Chipsy', 'image' => 'brands/chipsy.png'],
            ['name_ar' => 'جالاكسي', 'name_en' => 'Galaxy', 'image' => 'brands/galaxy.png'],
            ['name_ar' => 'حلواني أخوان', 'name_en' => 'Halwani Bros', 'image' => 'brands/halwani.png'],
            ['name_ar' => 'الضحى', 'name_en' => 'El Doha', 'image' => 'brands/eldoha.png'],
            ['name_ar' => 'ليبتون', 'name_en' => 'Lipton', 'image' => 'brands/lipton.png'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['name_en' => $brand['name_en']], $brand);
        }
    }
}
