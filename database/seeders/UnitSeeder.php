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
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
