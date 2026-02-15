<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10, 1000);
        return [
            'name_ar' => $this->faker->word() . ' منتج',
            'name_en' => $this->faker->word(),
            'description_ar' => $this->faker->sentence() . ' وصف بالعربي',
            'description_en' => $this->faker->sentence(),
            'price' => $price,
            'discount_price' => $this->faker->boolean(30) ? $price * 0.8 : 0,
            'stock' => $this->faker->numberBetween(0, 100),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'unit_id' => Unit::factory(),
            'min_quantity' => 1,
            'step_quantity' => 1,
            'is_featured' => $this->faker->boolean(10),
        ];
    }
}
