<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Cart\AddToCartRequest;
use App\Http\Requests\API\Cart\UpdateCartItemRequest;
use App\Http\Resources\API\Cart\CartResource;
use App\Service\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * عرض محتويات السلة
     */
    public function index(Request $request): JsonResponse
    {
        $cart = $this->cartService->getCart($request->user());
        $cart->load('items.product.images');

        if ($cart->items->isEmpty()) {
            return $this->success([], \__('messages.Cart is empty'));
        }

        return $this->success(new CartResource($cart), \__('messages.Cart fetched successfully'));
    }

    /**
     * إضافة منتج إلى السلة
     */
    public function store(AddToCartRequest $request): JsonResponse
    {
        $cart = $this->cartService->addToCart($request->user(), $request->validated());
        return $this->success(new CartResource($cart), \__('messages.Item added to cart successfully'));
    }

    /**
     * تحديث الكمية في السلة
     */
    public function update(UpdateCartItemRequest $request, $item_id): JsonResponse
    {
        $cart = $this->cartService->updateQuantity(
            $request->user(),
            $item_id,
            $request->validated()['quantity']
        );
        return $this->success(new CartResource($cart), \__('messages.Cart updated successfully'));
    }

    /**
     * حذف صنف من السلة
     */
    public function destroy(Request $request, $item_id): JsonResponse
    {
        $cart = $this->cartService->removeItem($request->user(), $item_id);
        return $this->success(new CartResource($cart), \__('messages.Item removed from cart successfully'));
    }

    /**
     * تفريغ السلة بالكامل
     */
    public function clear(Request $request): JsonResponse
    {
        $cart = $this->cartService->clearCart($request->user());
        return $this->success(new CartResource($cart), \__('messages.Cart cleared successfully'));
    }
}
