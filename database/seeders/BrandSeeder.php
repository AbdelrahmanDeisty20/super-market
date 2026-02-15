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
            ['name_ar' => 'نستله', 'name_en' => 'Nestle', 'image' => 'brands/nestle.png'],
            ['name_ar' => 'جهينة', 'name_en' => 'Juhayna', 'image' => 'brands/juhayna.png'],
            ['name_ar' => 'بيبسي', 'name_en' => 'Pepsi', 'image' => 'brands/pepsi.png'],
            ['name_ar' => 'برسيل', 'name_en' => 'Persil', 'image' => 'brands/persil.png'],
            ['name_ar' => 'المراعي', 'name_en' => 'Almarai', 'image' => 'brands/almarai.png'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
