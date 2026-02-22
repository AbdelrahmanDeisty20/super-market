<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            UnitSeeder::class,
            ProductSeeder::class,
            UserAddressSeeder::class,
            OrderSeeder::class,
            BannerSeeder::class,
            FaqSeeder::class,
            ServiceSeeder::class,
            CouponSeeder::class,
            OfferSeeder::class,
            TestimonialSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
        ]);
    }
}
