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
        $brands = Brand::paginate(10);

        if ($brands->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No brands found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Brands fetched successfully'),
            'data' => $brands
        ];
    }

    public function getBrandById($id)
    {
        $brand = Brand::with(['products.unit', 'products.images', 'products.offers'])->find($id);

        if (!$brand) {
            return [
                'status' => false,
                'message' => __('messages.Brand not found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Brand fetched successfully'),
            'data' => new BrandResource($brand)
        ];
    }
}