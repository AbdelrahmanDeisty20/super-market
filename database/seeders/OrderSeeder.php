<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin@admin.com')->first();
        $address = \App\Models\UserAddress::where('user_id', $admin->id)->first();

        if ($admin && $address) {
            $order = \App\Models\Order::create([
                'user_id' => $admin->id,
                'status' => 'delivered',
                'delivery_date' => now()->subDays(2),
                'delivery_time' => '14:00',
                'subtotal' => 150.00,
                'delivery_fee' => 30.00,
                'discount' => 0,
                'total' => 180.00,
                'address_id' => $address->id,
            ]);

            // Add some items to the order
            $product = \App\Models\Product::first();
            if ($product) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'price' => $product->price,
                ]);
            }
        }
    }
}
