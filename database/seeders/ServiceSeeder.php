<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title_ar' => 'توصيل مجاني',
                'title_en' => 'Free Delivery',
                'content_ar' => 'احصل على توصيل مجاني لجميع طلباتك التي تزيد عن 500 جنيه.',
                'content_en' => 'Get free delivery on all orders over 500 EGP.',
            ],
            [
                'title_ar' => 'دعم 24/7',
                'title_en' => '24/7 Support',
                'content_ar' => 'فريق الدعم الفني لدينا متاح دائماً للإجابة على استفساراتك في أي وقت.',
                'content_en' => 'Our technical support team is always available to answer your inquiries at any time.',
            ],
            [
                'title_ar' => 'جودة مضمونة',
                'title_en' => 'Guaranteed Quality',
                'content_ar' => 'نحن نضمن جودة جميع المنتجات التي نقدمها لعملائنا.',
                'content_en' => 'We guarantee the quality of all products we offer to our customers.',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title_en' => $service['title_en']], $service);
        }
    }
}
