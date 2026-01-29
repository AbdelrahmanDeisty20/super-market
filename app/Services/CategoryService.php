<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function index()
    {
        $categories = Category::select('id','name_ar','name_en','image')->get();
        if ($categories->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => __('No categories exists right now'),
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => __('Categories fetched successfully'),
            'categories' => $categories,
        ]);
    }
}