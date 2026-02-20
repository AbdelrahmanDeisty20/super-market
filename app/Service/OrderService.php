<?php

namespace App\Service;

use App\Models\Order;
use App\Models\User;
use App\Service\CartService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * إنشاء طلب جديد من سلة التسوق الحالية
     */
    public function createOrder(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = $this->cartService->getCart($user);
            $cart->load('items.product');

            if ($cart->items->isEmpty()) {
                throw new \Exception(\__('messages.Cart is empty'));
            }

            // حساب المجموع الفرعي
            $subtotal = $cart->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // رسوم التوصيل (يمكن تعديلها لاحقاً حسب العنوان)
            $deliveryFee = 0;

            // إنشاء الطلب
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $data['address_id'],
                'delivery_date' => $data['delivery_date'],
                'delivery_time' => $data['delivery_time'],
                'subtotal' => round($subtotal, 2),
                'delivery_fee' => $deliveryFee,
                'total' => round($subtotal + $deliveryFee, 2),
                'status' => 'pending',
            ]);

            // نقل أصناف السلة إلى أصناف الطلب
            foreach ($cart->items as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }

            // تفريغ السلة بعد إنشاء الطلب
            $this->cartService->clearCart($user);

            return $order->load(['items.product', 'address']);
        });
    }

    /**
     * جلب جميع طلبات المستخدم
     */
    public function getOrders(User $user)
    {
        return Order::where('user_id', $user->id)
            ->with(['items.product', 'address'])
            ->latest()
            ->get();
    }

    /**
     * جلب طلب معين
     */
    public function getOrder(User $user, $orderId)
    {
        return Order::where('user_id', $user->id)
            ->with(['items.product', 'address'])
            ->findOrFail($orderId);
    }

    /**
     * تحديث طلب (عنوان التوصيل، تاريخ ووقت التوصيل)
     */
    public function updateOrder(User $user, $orderId, array $data)
    {
        $order = Order::where('user_id', $user->id)->findOrFail($orderId);

        // لا يمكن تعديل الطلب إلا إذا كان في حالة "قيد الانتظار"
        if ($order->status !== 'pending') {
            throw new \Exception(\__('messages.Order cannot be updated'));
        }

        $order->update($data);

        return $order->load(['items.product', 'address']);
    }

    /**
     * إلغاء طلب
     */
    public function cancelOrder(User $user, $orderId)
    {
        $order = Order::where('user_id', $user->id)->findOrFail($orderId);

        if ($order->status !== 'pending') {
            throw new \Exception(\__('messages.Order cannot be cancelled'));
        }

        $order->update(['status' => 'cancelled']);

        return $order->load(['items.product', 'address']);
    }
}
