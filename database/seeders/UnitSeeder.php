<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name_ar' => 'كيلو جرام', 'name_en' => 'KG'],
            ['name_ar' => 'جرام', 'name_en' => 'Gram'],
            ['name_ar' => 'قطعة', 'name_en' => 'Piece'],
            ['name_ar' => 'لتر', 'name_en' => 'Liter'],
            ['name_ar' => 'مللي لتر', 'name_en' => 'ML'],
            ['name_ar' => 'كرتونة', 'name_en' => 'Carton'],
            ['name_ar' => 'عبوة', 'name_en' => 'Pack'],
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate(['name_en' => $unit['name_en']], $unit);
        }
    }
}