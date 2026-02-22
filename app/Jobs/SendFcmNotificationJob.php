<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class SendFcmNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $title;
    protected $body;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $title, string $body, ?array $data = [])
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    /**
     * تنفيذ المهمة (Execute the job)
     */
    public function handle(): void
    {
        // التحقق من أن المستخدم لديه رمز جهاز (Token) فعال
        if (!$this->user->fcm_token) {
            return;
        }

        try {
            // الاتصال بخدمة Firebase للبدء في تجهيز الإرسال
            $messaging = Firebase::messaging();

            // تجهيز رسالة الإشعار
            $message = CloudMessage::withTarget('token', $this->user->fcm_token)
                ->withNotification(FirebaseNotification::create($this->title, $this->body)) // العنوان والنص
                ->withData($this->data ?? []); // البيانات الإضافية

            // الخطوة النهائية: إرسال الإشعار فعلياً عبر سيرفرات Firebase لنظام الـ Push
            $messaging->send($message);
        } catch (\Exception $e) {
            // تسجيل أي خطأ يحدث في الخلفية لسهولة تتبعه
            Log::error('Queued FCM Error: ' . $e->getMessage(), [
                'user_id' => $this->user->id,
                'title' => $this->title
            ]);
        }
    }
}
