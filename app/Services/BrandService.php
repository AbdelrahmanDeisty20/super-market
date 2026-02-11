<?php

namespace App\Services;

use App\Http\Resources\API\BrandResource;
use App\Models\Brand;

class BrandService
{
    /**
     * Get all active brands.
     *
     * @return array
     */
    public function getBrands()
    {
        $brands = Brand::all();

        if ($brands->isEmpty()) {
            return [
                'success' => false,
                'message' => __('No brands found'),
                'data' => []
            ];
        }

        return [
            'success' => true,
            'message' => __('Brands fetched successfully'),
            'data' => BrandResource::collection($brands)
        ];
    }
}