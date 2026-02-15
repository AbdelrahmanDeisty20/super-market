<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \App\Models\Product::all();
        if ($products->isEmpty()) {
            Offer::factory(3)->create();
            return;
        }

        Offer::factory(3)->create()->each(function ($offer) use ($products) {
            $offer->products()->attach(
                $products->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
