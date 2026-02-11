<?php

namespace App\Services;

use App\Models\Category;
use App\Http\Resources\API\CategoryResource;

class CategoryService
{
    /**
     * Get all visible categories.
     *
     * @return array
     */
    public function getCategories()
    {
        $categories = Category::where('is_visible', true)->get();

        if ($categories->isEmpty()) {
            return [
                'success' => false,
                'message' => __('No categories found'),
                'data' => []
            ];
        }

        return [
            'success' => true,
            'message' => __('Categories fetched successfully'),
            'data' => CategoryResource::collection($categories)
        ];
    }
}
