<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function index()
    {
        $brands = Brand::select('id','name_ar','name_en','image')->get();
        if ($brands->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => __('No brands exists right now'),
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => __('Brands fetched successfully'),
            'brands' => $brands,
        ]);
    }
}