<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about-us',
                'title_ar' => 'من نحن',
                'title_en' => 'About Us',
                'content_ar' => 'نحن متجر سوبر ماركت نسعى لتقديم أفضل المنتجات الغذائية والمنزلية لعملائنا بأعلى جودة وأفضل الأسعار.',
                'content_en' => 'We are a Super Market store striving to provide the best food and household products to our customers with the highest quality and best prices.',
            ],
            [
                'slug' => 'privacy-policy',
                'title_ar' => 'سياسة الخصوصية',
                'title_en' => 'Privacy Policy',
                'content_ar' => 'نحن نلتزم بحماية خصوصية بياناتك الشخصية وضمان سرية المعلومات التي تشاركها معنا.',
                'content_en' => 'We are committed to protecting the privacy of your personal data and ensuring the confidentiality of the information you share with us.',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
