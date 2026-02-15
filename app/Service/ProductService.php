<?php

namespace App\Service;

use App\Http\Resources\API\ProductListResource;
use App\Models\Product;
use App\Http\Resources\API\ProductResource;

class ProductService
{
    /**
     * Get all products with relationships.
     *
     * @return array
     */
    public function getProducts($filters = [])
    {
        $query = Product::with(['category', 'brand', 'unit', 'images', 'offers']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            // Split by spaces OR transitions between English and Arabic characters
            $strings = preg_split('/[\s]+|(?<=[a-zA-Z])(?=[\x{0600}-\x{06FF}])|(?<=[\x{0600}-\x{06FF}])(?=[a-zA-Z])/u', $search);

            foreach ($strings as $string) {
                $filteredWord = trim($string);
                if (empty($filteredWord)) continue;

                $query->where(function ($q) use ($filteredWord) {
                    $q->where('name_ar', 'like', "%$filteredWord%")
                        ->orWhere('name_en', 'like', "%$filteredWord%")
                        ->orWhere('description_ar', 'like', "%$filteredWord%")
                        ->orWhere('description_en', 'like', "%$filteredWord%")
                        ->orWhereHas('category', function ($cq) use ($filteredWord) {
                            $cq->where('name_ar', 'like', "%$filteredWord%")
                                ->orWhere('name_en', 'like', "%$filteredWord%");
                        })
                        ->orWhereHas('brand', function ($bq) use ($filteredWord) {
                            $bq->where('name_ar', 'like', "%$filteredWord%")
                                ->orWhere('name_en', 'like', "%$filteredWord%");
                        });
                });
            }
        }

        if (!empty($filters['categories'])) {
            $query->whereIn('category_id', (array)$filters['categories']);
        }

        if (!empty($filters['units'])) {
            $query->whereIn('unit_id', (array)$filters['units']);
        }

        if (!empty($filters['offers'])) {
            $offers = (array)$filters['offers'];
            $query->whereHas('offers', function ($q) use ($offers) {
                $q->whereIn('offers.id', $offers)
                    ->orWhereIn('offers.type', $offers);
            });
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        $products = $query->paginate(10);

        if ($products->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No products found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Products fetched successfully'),
            'data' => $products
        ];
    }

    /**
     * Get product by ID with relationships.
     *
     * @param int|string $id
     * @return array
     */
    public function getProductById($id)
    {
        $product = Product::with(['category', 'brand', 'unit', 'images', 'offers'])->find($id);

        if (!$product) {
            return [
                'status' => false,
                'message' => __('messages.Product not found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Product fetched successfully'),
            'data' => new ProductResource($product)
        ];
    }

    public function isFeatured()
    {
        $products = Product::with(['unit', 'images', 'offers'])->where('is_featured', true)->paginate(10);

        if ($products->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No products found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Products fetched successfully'),
            'data' => $products
        ];
    }


    public function onSale()
    {
        $products = Product::with(['unit', 'images', 'offers'])->whereHas('offers', function ($q) {
            $q->where('type', 'percentage')->orWhere('type', 'fixed');
        })->paginate(10);

        if ($products->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No products found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Products fetched successfully'),
            'data' => $products,
        ];
    }


    public function getRelatedProducts($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return [
                'status' => false,
                'message' => __('messages.Product not found'),
                'data' => []
            ];
        }

        $products = Product::with(['unit', 'images', 'offers'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $productId)
            ->limit(3)->get();

        return [
            'status' => true,
            'message' => __('messages.Products fetched successfully'),
            'data' => ProductListResource::collection($products)
        ];
    }

    public function getMayLikeProducts()
    {
        $products = Product::with(['unit', 'images', 'offers'])
            ->inRandomOrder()
            ->limit(3)->get();

        if ($products->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No products found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Products fetched successfully'),
            'data' => ProductListResource::collection($products)
        ];
    }
}
