<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->randomElement(['كيلو', 'قطعة', 'لتر', 'كرتونة']),
            'name_en' => $this->faker->randomElement(['kg', 'piece', 'liter', 'box']),
        ];
    }
}
