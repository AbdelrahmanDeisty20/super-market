<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name_ar' => 'خضروات وفواكه', 'name_en' => 'Fruits & Vegetables', 'image' => 'super-market.jpg'],
            ['name_ar' => 'لحوم ودواجن', 'name_en' => 'Meat & Poultry', 'image' => 'super-market.jpg'],
            ['name_ar' => 'ألبان وأجبان', 'name_en' => 'Dairy & Cheese', 'image' => 'super-market.jpg'],
            ['name_ar' => 'مخبوزات', 'name_en' => 'Bakery', 'image' => 'super-market.jpg'],
            ['name_ar' => 'مشروبات', 'name_en' => 'Beverages', 'image' => 'super-market.jpg'],
            ['name_ar' => 'معلبات', 'name_en' => 'Canned Food', 'image' => 'super-market.jpg'],
            ['name_ar' => 'منظفات', 'name_en' => 'Cleaning Supplies', 'image' => 'super-market.jpg'],
            ['name_ar' => 'عناية شخصية', 'name_en' => 'Personal Care', 'image' => 'super-market.jpg'],
            ['name_ar' => 'سناكس وحلويات', 'name_en' => 'Snacks & Sweets', 'image' => 'super-market.jpg'],
            ['name_ar' => 'مجمدات', 'name_en' => 'Frozen Food', 'image' => 'super-market.jpg'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name_en' => $category['name_en']], $category);
        }
    }
}
