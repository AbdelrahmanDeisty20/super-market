<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\WhishlistRequest;
use App\Http\Resources\API\WhishlistResource;
use App\Service\WhishlistService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WhishlistController extends Controller
{
    use ApiResponse;

    protected $whishlistService;

    public function __construct(WhishlistService $whishlistService)
    {
        $this->whishlistService = $whishlistService;
    }

    public function index(Request $request): JsonResponse
    {
        $items = $this->whishlistService->getUserWhishlist($request->user());
        $message = $items->isEmpty() ? __('messages.No wishlist items found yet') : __('messages.Wishlist fetched successfully');
        return $this->paginated(WhishlistResource::class, $items, $message);
    }

    public function toggle(WhishlistRequest $request): JsonResponse
    {
        $result = $this->whishlistService->toggleWhishlist($request->user(), $request->product_id);

        $message = $result['status'] === 'added'
            ? __('messages.Product added to wishlist')
            : __('messages.Product removed from wishlist');

        return $this->success([], $message);
    }

    public function destroy(Request $request): JsonResponse
    {
        $this->whishlistService->clearWhishlist($request->user());
        return $this->success([], __('messages.Whishlist cleared successfully'));
    }
}