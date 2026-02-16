<?php

namespace App\Service;

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
        $categories = Category::where('is_visible', true)
            ->paginate(10);

        if ($categories->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No categories found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Categories fetched successfully'),
            'data' => $categories
        ];
    }

    public function getCategoryById($id)
    {
        $category = Category::with(['products.unit', 'products.images', 'products.offers'])->find($id);
        if (!$category) {
            return [
                'status' => false,
                'message' => __('messages.Category not found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Category fetched successfully'),
            'data' => new CategoryResource($category)
        ];
    }
}