<?php

namespace App\Service;

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
                'message' => __('messages.No brands found'),
                'data' => []
            ];
        }

        return [
            'success' => true,
            'message' => __('messages.Brands fetched successfully'),
            'data' => BrandResource::collection($brands)
        ];
    }
}
