<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ar' => $this->faker->word() . ' خدمة',
            'title_en' => $this->faker->word(),
            'content_ar' => $this->faker->sentence() . ' محتوى خدمة بالعربي',
            'content_en' => $this->faker->sentence(),
        ];
    }
}
