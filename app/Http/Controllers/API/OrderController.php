<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Order\StoreOrderRequest;
use App\Http\Requests\API\Order\UpdateOrderRequest;
use App\Http\Resources\API\Order\OrderResource;
use App\Service\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * عرض جميع طلبات المستخدم
     */
    public function index(Request $request): JsonResponse
    {
        $orders = $this->orderService->getOrders($request->user());

        if ($orders->isEmpty()) {
            return $this->success([], \__('messages.No orders found yet'));
        }

        return $this->success(OrderResource::collection($orders), \__('messages.Orders fetched successfully'));
    }

    /**
     * عرض طلب معين
     */
    public function show(Request $request, $id): JsonResponse
    {
        $order = $this->orderService->getOrder($request->user(), $id);
        return $this->success(new OrderResource($order), \__('messages.Order fetched successfully'));
    }

    /**
     * إنشاء طلب جديد من السلة
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->user(), $request->validated());
            return $this->success(new OrderResource($order), \__('messages.Order created successfully'), 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * تحديث طلب (عنوان التوصيل، تاريخ ووقت التوصيل)
     */
    public function update(UpdateOrderRequest $request, $id): JsonResponse
    {
        try {
            $order = $this->orderService->updateOrder($request->user(), $id, $request->validated());
            return $this->success(new OrderResource($order), \__('messages.Order updated successfully'));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * إلغاء طلب
     */
    public function cancel(Request $request, $id): JsonResponse
    {
        try {
            $order = $this->orderService->cancelOrder($request->user(), $id);
            return $this->success(new OrderResource($order), \__('messages.Order cancelled successfully'));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * جلب بيانات التتبع الحالية (Status + Lat + Long)
     */
    public function tracking(Request $request, $id): JsonResponse
    {
        $order = $this->orderService->getOrder($request->user(), $id);

        return $this->success([
            'id' => $order->id,
            'status' => $order->status,
            'last_lat' => (float) $order->last_lat,
            'last_long' => (float) $order->last_long,
        ], \__('messages.Tracking data fetched successfully'));
    }
}
