<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_ar' => $this->faker->sentence() . '؟',
            'question_en' => $this->faker->sentence() . '?',
            'answer_ar' => $this->faker->paragraph() . ' اجابة بالعربي',
            'answer_en' => $this->faker->paragraph(),
        ];
    }
}
