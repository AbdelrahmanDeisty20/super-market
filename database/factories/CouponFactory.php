<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->lexify('??????')),
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'value' => $this->faker->numberBetween(5, 50),
            'min_order_value' => $this->faker->numberBetween(0, 500),
            'start_date' => now(),
            'end_date' => now()->addMonths(1),
            'usage_limit' => $this->faker->numberBetween(10, 100),
            'used_count' => 0,
            'is_active' => true,
        ];
    }
}
