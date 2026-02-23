<?php

namespace App\Service;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * جلب الإشعارات الخاصة بالمستخدم الحالي بشكل مرقم (Paginated)
     */
    public function getUserNotifications($perPage = 15)
    {
        return Notification::where('user_id', Auth::id())
            ->latest() // ترتيب من الأحدث للأقدم
            ->paginate($perPage);
    }

    public function updateFcmToken(User $user, string $token, string $deviceId = null)
    {
        // لو باعت الـ device_id، بنحاول نخلص من أي سجلات قديمة لنفس الجهاز عشان ميكررش
        if ($deviceId) {
            // بنحدّث السجل لو كان لنفس الجهاز (سواء كان لليوزر ده أو كان Guest أو يوزر تاني سجل خروج)
            // ده بيضمن إن الـ device_id دايمًا مربوط بآخر يوزر عمل login عليه
            return \App\Models\UserFcmToken::updateOrCreate(
                ['device_id' => $deviceId],
                [
                    'user_id' => $user->id,
                    'fcm_token' => $token,
                ]
            );
        }

        // لو مبعتش device_id، بنعتمد على الـ user_id والتوكن نفسه (للتوافق القديم)
        return \App\Models\UserFcmToken::updateOrCreate(
            [
                'user_id' => $user->id,
                'fcm_token' => $token,
            ],
            [
                'fcm_token' => $token,
            ]
        );
    }

    /**
     * تحديد إشعار معين كمقروء
     */
    public function markAsRead(int $id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        return $notification->update(['read_at' => now()]);
    }

    /**
     * تحديد كل إشعارات المستخدم كمقروءة دفعة واحدة
     */
    public function markAllAsRead()
    {
        return Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * جلب عدد الإشعارات التي لم تقرأ بعد (لإظهار الرقم بجانب أيقونة التنبيهات)
     */
    public function getUnreadCount()
    {
        return Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();
    }
}
