<?php

namespace App\Observers;

use App\Models\Coupon;
use App\Jobs\BroadcastNotificationJob;

class CouponObserver
{
    /**
     * يتم استدعاء هذه الدالة بعد إنشاء كوبون جديد
     */
    public function created(Coupon $coupon): void
    {
        // تم تعطيل الإرسال التلقائي للكل بناءً على طلب المستخدم
        // الإشعار سيتم إرساله يدوياً من لوحة التحكم للمستخدمين المحددين
    }

    /**
     * يتم استدعاء هذه الدالة عند تحديث الكوبون
     */
    public function updated(Coupon $coupon): void
    {
        // تم تعطيل الإرسال التلقائي للكل بناءً على طلب المستخدم
    }

    /**
     * دالة مساعدة لتجهيز وإرسال الإشعار
     */
    protected function sendNotification(Coupon $coupon)
    {
        $title = \__('messages.New Coupon for You');

        // بنكتب نص الإشعار وبنحط فيه قيمة الخصم والكود
        $value = $coupon->type === 'percentage' ? $coupon->value . '%' : $coupon->value;
        $body = \__('messages.Use code :code to get :value discount', [
            'code' => $coupon->code,
            'value' => $value
        ]);

        // إرسال المهمة للطابور
        BroadcastNotificationJob::dispatch(
            $title,
            $body,
            ['coupon_code' => $coupon->code],
            'coupon_created'
        );
    }
}
