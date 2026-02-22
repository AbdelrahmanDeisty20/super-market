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

    /**
     * تحديث الـ FCM Token الخاص بجهاز المستخدم (لحفل استقبال الإشعارات)
     */
    public function updateFcmToken(User $user, string $token)
    {
        return $user->update(['fcm_token' => $token]);
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
