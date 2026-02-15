<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();

        if ($categories->isEmpty() || $brands->isEmpty()) {
            return;
        }

        Product::factory(20)->create()->each(function ($product) use ($categories, $brands, $units) {
            $product->update([
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'unit_id' => $units->random()->id,
            ]);

            // Create 3 additional images for each product
            ProductImage::factory(3)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
