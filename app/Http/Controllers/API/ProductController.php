<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\API\ProductListResource;
use App\Http\Resources\API\ProductResource;
use App\Http\Controllers\Controller;
use App\Service\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use ApiResponse;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function index(\Illuminate\Http\Request $request): JsonResponse
    {
        $result = $this->productService->getProducts($request->all());

        if (!$result['status']) {
            return $this->error($result['message']);
        }

        return $this->paginated(ProductResource::class, $result['data']);
    }

    /**
     * Display the specified product.
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $result = $this->productService->getProductById($id);

        if (!$result['status']) {
            return $this->error($result['message']);
        }

        return $this->success($result['data'], $result['message']);
    }

    public function isFeatured()
    {
        $result = $this->productService->isFeatured();

        if (!$result['status']) {
            return $this->error($result['message']);
        }

        return $this->paginated(ProductListResource::class, $result['data']);
    }

    public function onSale()
    {
        $result = $this->productService->onSale();

        if (!$result['status']) {
            return $this->error($result['message']);
        }

        return $this->paginated(ProductListResource::class, $result['data']);
    }

    public function related($id)
    {
        $result = $this->productService->getRelatedProducts($id);

        if (!$result['status']) {
            return $this->error($result['message']);
        }

        return $this->success($result['data'], $result['message']);
    }

    public function mayLike()
    {
        $result = $this->productService->getMayLikeProducts();

        if (!$result['status']) {
            return $this->error($result['message']);
        }

        return $this->success($result['data'], $result['message']);
    }
}
