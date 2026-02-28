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
    protected $fcmToken;

    /**
     * إنشاء نسخة جديدة من المهمة
     *
     * @param User $user المستخدم (للتسجيل والتحقق)
     * @param string $title عنوان الإشعار
     * @param string $body نص الإشعار
     * @param array|null $data بيانات إضافية
     * @param string|null $token رمز الجهاز المحدد (لو لم يرسل، سيجلب من اليوزر مباشرة - للمتوافقية القديمة)
     */
    public function __construct(User $user, string $title, string $body, ?array $data = [], $token = null)
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->fcmToken = $token;
    }

    /**
     * تنفيذ المهمة (Execute the job)
     */
    public function handle(): void
    {
        // نستخدم التوكن الممرر، لو مفيش نجرب نجيب أول توكن متاح لليوزر (لضمان عمل الكود القديم لو وجد)
        $token = $this->fcmToken;

        if (!$token) {
            return;
        }

        try {
            // الاتصال بخدمة Firebase للبدء في تجهيز الإرسال
            $messaging = Firebase::messaging();

            // تجهيز رسالة الإشعار للجهاز المحدد بأسلوب متوافق مع نسخة kreait/firebase-php 8.x
            $message = CloudMessage::new()
                ->withToken($token)
                ->withNotification(FirebaseNotification::create($this->title, $this->body))
                ->withData($this->data ?? []);

            // إرسال الإشعار
            $messaging->send($message);
        } catch (\Throwable $e) {
            // تسجيل أي خطأ يحدث في الخلفية لسهولة تتبعه
            Log::error('Queued FCM Error: ' . $e->getMessage(), [
                'user_id' => $this->user->id,
                'title' => $this->title
            ]);
        }
    }
}
