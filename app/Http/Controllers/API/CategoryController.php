<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\API\CategoryResource;
use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    protected $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the categories.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->categoryService->getCategories();

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        $message = $result['data']->isEmpty() ? __('messages.No categories found yet') : __('messages.Categories fetched successfully');
        return $this->paginated(CategoryResource::class, $result['data'], $message);
    }

    public function show($id)
    {
        $result = $this->categoryService->getCategoryById($id);
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }
        return $this->success($result['data'], $result['message']);
    }
}
