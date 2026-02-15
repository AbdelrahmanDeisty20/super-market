<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->unique()->company() . ' ماركة',
            'name_en' => $this->faker->unique()->company(),
            'image' => 'brands/' . $this->faker->image(null, 640, 480, null, false),
        ];
    }
}
