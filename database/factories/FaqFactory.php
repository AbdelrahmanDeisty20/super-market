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
            'question_ar' => 'هل تتوفر خدمة التوصيل لمناطق بعيدة؟',
            'question_en' => 'Is delivery available to remote areas?',
            'answer_ar' => 'نعم، نحن نوفر خدمة التوصيل لجميع المناطق داخل المدينة خلال ٢٤ ساعة من تأكيد الطلب.',
            'answer_en' => $this->faker->paragraph(),
        ];
    }
}
