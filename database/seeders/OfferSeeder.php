<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = [
            [
                'title_ar' => 'عروض رمضان الخير',
                'title_en' => 'Ramadan Kareem Offers',
                'description_ar' => 'خصومات تصل إلى 50% على جميع مستلزمات رمضان.',
                'description_en' => 'Up to 50% discount on all Ramadan supplies.',
                'type' => 'percentage',
                'value' => 15,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(2),
                'image' => 'offers/ramadan.jpg',
            ],
            [
                'title_ar' => 'تخفيضات عطلة نهاية الأسبوع',
                'title_en' => 'Weekend Flash Sale',
                'description_ar' => 'توفير كبير على المنظفات والمشروبات.',
                'description_en' => 'Big savings on cleaning tools and beverages.',
                'type' => 'fixed',
                'value' => 25,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(3),
                'image' => 'offers/weekend.jpg',
            ],
        ];

        foreach ($offers as $offData) {
            $offer = Offer::updateOrCreate(['title_en' => $offData['title_en']], $offData);

            // Attach random products to each offer
            $products = Product::inRandomOrder()->limit(5)->pluck('id');
            $offer->products()->sync($products);
        }
    }
}