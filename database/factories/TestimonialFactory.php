<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => 'تجربة شراء ممتازة ومنتجات طازجة دائماً، خدمة التوصيل سريعة جداً والمعاملة في منتهى الرقي.',
            'rating' => $this->faker->numberBetween(1, 5),
            'user_id' => User::factory(),
        ];
    }
}
