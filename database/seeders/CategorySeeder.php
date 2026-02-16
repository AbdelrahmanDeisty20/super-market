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
            ['name_ar' => 'خضروات وفواكه', 'name_en' => 'Fruits & Vegetables', 'image' => 'categories/veg.jpg'],
            ['name_ar' => 'لحوم ودواجن', 'name_en' => 'Meat & Poultry', 'image' => 'categories/meat.jpg'],
            ['name_ar' => 'ألبان وأجبان', 'name_en' => 'Dairy & Cheese', 'image' => 'categories/dairy.jpg'],
            ['name_ar' => 'مخبوزات', 'name_en' => 'Bakery', 'image' => 'categories/bakery.jpg'],
            ['name_ar' => 'مشروبات', 'name_en' => 'Beverages', 'image' => 'categories/drinks.jpg'],
            ['name_ar' => 'معلبات', 'name_en' => 'Canned Food', 'image' => 'categories/canned.jpg'],
            ['name_ar' => 'منظفات', 'name_en' => 'Cleaning Supplies', 'image' => 'categories/cleaning.jpg'],
            ['name_ar' => 'عناية شخصية', 'name_en' => 'Personal Care', 'image' => 'categories/personal_care.jpg'],
            ['name_ar' => 'سناكس وحلويات', 'name_en' => 'Snacks & Sweets', 'image' => 'categories/snacks.jpg'],
            ['name_ar' => 'مجمدات', 'name_en' => 'Frozen Food', 'image' => 'categories/frozen.jpg'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name_en' => $category['name_en']], $category);
        }
    }
}
