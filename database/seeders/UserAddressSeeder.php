<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin@admin.com')->first();

        if ($admin) {
            \App\Models\UserAddress::updateOrCreate(
                ['user_id' => $admin->id, 'label' => 'Home'],
                [
                    'address' => '15 شارع التحرير الدقي',
                    'is_default' => true,
                ]
            );

            \App\Models\UserAddress::updateOrCreate(
                ['user_id' => $admin->id, 'label' => 'Work'],
                [
                    'address' => '22 كورنيش النيل، سبورتنج',
                    'is_default' => false,
                ]
            );
        }
    }
}
