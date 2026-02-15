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
            ['name_ar' => 'خضروات وفواكه', 'name_en' => 'Vegetables & Fruits', 'image' => 'categories/veg.jpg'],
            ['name_ar' => 'لحوم ودواجن', 'name_en' => 'Meat & Poultry', 'image' => 'categories/meat.jpg'],
            ['name_ar' => 'ألبان وأجبان', 'name_en' => 'Dairy & Cheese', 'image' => 'categories/dairy.jpg'],
            ['name_ar' => 'منظفات', 'name_en' => 'Cleaning Supplies', 'image' => 'categories/cleaning.jpg'],
            ['name_ar' => 'مشروبات', 'name_en' => 'Beverages', 'image' => 'categories/drinks.jpg'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
