<?php

namespace App\Service;

use App\Models\User;
use App\Models\Notification;
use App\Jobs\SendFcmNotificationJob;
use Illuminate\Support\Facades\Log;

class FcmService
{
    /**
     * إرسال إشعار لمستخدم محدد (تحميل العملية للخلفية إذا كان متاحاً)
     *
     * @param User $user المستخدم المستهدف
     * @param string $title عنوان الإشعار
     * @param string $body نص الإشعار
     * @param array|null $data بيانات إضافية (مثل معرف الطلب)
     * @param string|null $type نوع الإشعار (order_created, offer, etc.)
     * @return void
     */
    public function sendNotification(User $user, $title, $body, $data = null, $type = null)
    {
        // 1. حفظ الإشعار في سجل التنبيهات بقاعدة البيانات (فوري ليظهر في التطبيق)
        Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'body' => $body,
            'type' => $type,
            'data' => $data,
        ]);

        // 2. إرسال إشعار الدفع (Push Notification) عبر الطابور (Job) لتسريع الأداء
        if ($user->fcm_token) {
            // هنا بنرمي مهمة التواصل مع Firebase للـ Job اللي شغال في الخلفية
            // العميل مش هيستنى رد Firebase، الطلب بيكمل فوراً
            SendFcmNotificationJob::dispatch($user, $title, $body, $data ?? []);
        }
    }
}
