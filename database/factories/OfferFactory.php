<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ar' => $this->faker->word() . ' عرض',
            'title_en' => $this->faker->word(),
            'description_ar' => $this->faker->sentence() . ' وصف عرض عربي',
            'description_en' => $this->faker->sentence(),
            'image' => 'offers/' . $this->faker->image(null, 640, 480, null, false),
            'type' => $this->faker->randomElement(['fixed', 'percentage', 'bogo']),
            'value' => $this->faker->numberBetween(10, 100),
            'start_date' => now(),
            'end_date' => now()->addMonths(1),
            'is_active' => true,
        ];
    }
}
