<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->unique()->word() . ' بالعربي',
            'name_en' => $this->faker->unique()->word(),
            'image' => 'categories/' . $this->faker->image(null, 640, 480, null, false),
            'is_visible' => true,
        ];
    }
}
