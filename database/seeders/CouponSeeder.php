<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'min_order_value' => 100,
                'usage_limit' => 1000,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3),
            ],
            [
                'code' => 'SAVE50',
                'type' => 'fixed',
                'value' => 50,
                'min_order_value' => 500,
                'usage_limit' => 500,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
            ],
            [
                'code' => 'RAMADAN2026',
                'type' => 'percentage',
                'value' => 20,
                'min_order_value' => 300,
                'usage_limit' => 2000,
                'is_active' => true,
                'start_date' => Carbon::create(2026, 2, 1),
                'end_date' => Carbon::create(2026, 4, 1),
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 30, // Assuming 30 is delivery fee
                'min_order_value' => 200,
                'usage_limit' => 100,
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(['code' => $coupon['code']], $coupon);
        }
    }
}
