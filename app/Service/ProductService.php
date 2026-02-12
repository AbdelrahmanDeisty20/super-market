<?php

namespace App\Service;

use App\Models\Product;

class ProductService
{
    public function index()
    {
        $products = Product::select('id', 'name_ar', 'name_en', 'image', 'price', 'description_ar', 'description_en', 'stock')->get();
        if ($products->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => __('No products exists right now'),
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => __('Products fetched successfully'),
            'products' => $products,
        ]);
    }
}
