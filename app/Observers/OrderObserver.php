<?php

namespace App\Observers;

use App\Models\Order;
use App\Service\FcmService;

class OrderObserver
{
    protected $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    /**
     * يتم استدعاء هذه الدالة عند تحديث أي بيانات في الطلب
     */
    public function updated(Order $order): void
    {
        // بنتحقق لو عمود "الحالة" (status) هو اللي اتغير
        if ($order->wasChanged('status')) {
            $this->sendStatusNotification($order);
        }
    }

    /**
     * دالة مساعدة لتجهيز وإرسال إشعار تغيير الحالة
     */
    protected function sendStatusNotification(Order $order)
    {
        $user = $order->user;
        $status = $order->status;

        // مصفوفة العناوين والرسائل لكل حالة
        $notifications = [
            'processing' => [
                'title' => \__('messages.Order Processing'),
                'body' => \__('messages.Your order is now being processed. Order ID: ') . $order->id,
            ],
            'shipped' => [
                'title' => \__('messages.Order Shipped'),
                'body' => \__('messages.Your order has been shipped and is on its way! Order ID: ') . $order->id,
            ],
            'delivered' => [
                'title' => \__('messages.Order Delivered'),
                'body' => \__('messages.Your order has been delivered successfully. Enjoy! Order ID: ') . $order->id,
            ],
            'cancelled' => [
                'title' => \__('messages.Order Cancelled'),
                'body' => \__('messages.Your order has been cancelled. Order ID: ') . $order->id,
            ],
        ];

        // لو الحالة الجديدة ليها إشعار متعرف، نبعته
        if (isset($notifications[$status])) {
            // 1. إرسال إشعار Push Notification عن طريق Firebase (FCM)
            $this->fcmService->sendNotification(
                $user,
                $notifications[$status]['title'],
                $notifications[$status]['body'],
                ['order_id' => (string)$order->id],
                'order_status_updated'
            );

            // 2. إرسال تحديث لحظي (Real-time Broadcast) عن طريق WebSocket (Reverb)
            \event(new \App\Events\OrderStatusUpdated($order));
        }
    }
}
