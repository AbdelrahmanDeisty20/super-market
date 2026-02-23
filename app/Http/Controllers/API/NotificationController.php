<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\NotificationResource;
use App\Service\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    use ApiResponse;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of user notifications.
     */
    public function index(): JsonResponse
    {
        $notifications = $this->notificationService->getUserNotifications();

        $message = $notifications->isEmpty()
            ? __('messages.You have no notifications yet')
            : __('messages.Notifications fetched successfully');

        return $this->paginated(
            NotificationResource::class,
            $notifications,
            $message,
            ['unread_count' => $this->notificationService->getUnreadCount()]
        );
    }

    /**
     * Update user FCM token.
     */
    public function updateToken(Request $request): JsonResponse
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'device_id' => 'nullable|string',
        ]);

        $this->notificationService->updateFcmToken(auth()->user(), $request->fcm_token, $request->device_id);

        return $this->success([], __('messages.FCM Token updated successfully'));
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id): JsonResponse
    {
        $this->notificationService->markAsRead($id);
        return $this->success([], __('messages.Notification marked as read'));
    }

    /**
     * Mark all as read.
     */
    public function markAllAsRead(): JsonResponse
    {
        $this->notificationService->markAllAsRead();
        return $this->success([], __('messages.All notifications marked as read'));
    }
}
