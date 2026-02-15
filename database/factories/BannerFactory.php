<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'banners/' . $this->faker->image(null, 1200, 400, null, false),
            'title_ar' => $this->faker->word() . ' عنوان بنر',
            'title_en' => $this->faker->word(),
            'description_ar' => $this->faker->sentence() . ' وصف بنر',
            'description_en' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'is_active' => true,
        ];
    }
}
