<?php

namespace App\Service;

use App\Models\Setting;
use App\Service\CouponService;
use App\Models\Order;
use App\Models\User;
use App\Service\CartService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $cartService;
    protected $couponService;
    protected $fcmService;

    public function __construct(CartService $cartService, CouponService $couponService, \App\Service\FcmService $fcmService)
    {
        $this->cartService = $cartService;
        $this->couponService = $couponService;
        $this->fcmService = $fcmService;
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

            // حساب المجموع الفرعي (مع مراعاة سعر الخصم)
            $subtotal = $cart->items->sum(function ($item) {
                $product = $item->product;
                $currentPrice = $product->discount_price > 0 ? $product->discount_price : $product->price;
                return $currentPrice * $item->quantity;
            });

            // الحصول على العنوان ورسوم التوصيل الثابتة
            $address = \App\Models\UserAddress::findOrFail($data['address_id']);
            $deliveryFee = Setting::getValue('min_delivery_fee', 30);

            // حساب الخصم إذا وجد كوبون
            $discount = 0;
            $couponId = null;
            if (!empty($data['coupon_code'])) {
                $couponResult = $this->couponService->checkCoupon($data['coupon_code'], $subtotal + $deliveryFee);
                if ($couponResult['status']) {
                    $coupon = $couponResult['data']->resource; // وصول إلى الموديل من الـ Resource
                    if ($coupon->type === 'fixed') {
                        $discount = $coupon->value;
                    } else {
                        $discount = ($subtotal * $coupon->value) / 100;
                    }
                    $couponId = $coupon->id;

                    // تحديث عدد مرات استخدام الكوبون
                    $coupon->increment('used_count');
                } else {
                    throw new \Exception($couponResult['message']);
                }
            }

            // إنشاء الطلب
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $data['address_id'],
                'delivery_date' => $data['delivery_date'],
                'delivery_time' => $data['delivery_time'],
                'subtotal' => round($subtotal, 2),
                'delivery_fee' => $deliveryFee,
                'discount' => round($discount, 2),
                'total' => round($subtotal + $deliveryFee - $discount, 2),
                'coupon_id' => $couponId,
                'status' => 'pending',
            ]);

            // نقل أصناف السلة إلى أصناف الطلب وتحديث المخزون
            foreach ($cart->items as $cartItem) {
                $product = $cartItem->product;

                if ($product->stock < $cartItem->quantity) {
                    throw new \Exception(\__('messages.Insufficient stock for product') . ': ' . $product->name);
                }

                $product->decrement('stock', $cartItem->quantity);

                $currentPrice = $product->discount_price > 0 ? $product->discount_price : $product->price;

                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $currentPrice,
                ]);
            }

            // تفريغ السلة بعد إنشاء الطلب
            $this->cartService->clearCart($user);

            // إرسال إشعار للمستخدم
            $this->fcmService->sendNotification(
                $user,
                \__('messages.Order Created'),
                \__('messages.Your order has been placed successfully. Order ID: ') . $order->id,
                ['order_id' => (string)$order->id],
                'order_created'
            );

            return $order->load(['items.product.images', 'address']);
        });
    }

    /**
     * جلب جميع طلبات المستخدم
     */
    public function getOrders(User $user)
    {
        return Order::where('user_id', $user->id)
            ->with(['items.product.images', 'address'])
            ->latest()
            ->get();
    }

    /**
     * جلب طلب معين
     */
    public function getOrder(User $user, $orderId)
    {
        return Order::where('user_id', $user->id)
            ->with(['items.product.images', 'address'])
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

        $order->update([
            'address_id' => $data['address_id'] ?? $order->address_id,
            'delivery_date' => $data['delivery_date'] ?? $order->delivery_date,
            'delivery_time' => $data['delivery_time'] ?? $order->delivery_time,
        ]);

        // إرسال إشعار بتحديث الطلب (اختياري، لكن مفيد إذا تم تحديث الحالة مثلاً)
        // إذا كان هناك تحديث للحالة في مكان آخر، سنضيفه هناك.

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

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            $order->update(['status' => 'cancelled']);
        });

        return $order->load(['items.product', 'address']);
    }
}
