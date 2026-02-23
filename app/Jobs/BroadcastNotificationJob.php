<?php

namespace App\Jobs;

use App\Models\User;
use App\Service\FcmService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BroadcastNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $body;
    protected $data;
    protected $type;

    /**
     * إنشاء نسخة جديدة من المهمة
     *
     * @param string $title عنوان الإشعار
     * @param string $body نص الإشعار
     * @param array|null $data بيانات إضافية
     * @param string|null $type نوع الإشعار
     */
    public function __construct($title, $body, $data = [], $type = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * تنفيذ المهمة: إرسال الإشعار لكل المستخدمين اللي عندهم رمز جهاز (Token)
     */
    public function handle(FcmService $fcmService): void
    {
        // بنمر على كل المستخدمين اللي ليهم جهاز واحد على الأقل مسجل (FCM Token)
        User::has('fcmTokens')->chunk(100, function ($users) use ($fcmService) {
            /** @var User $user */
            foreach ($users as $user) {
                // بنبعت الإشعار للمستخدم، والـ FcmService جواه اللوجيك اللي بيبعته لكل أجهزته
                $fcmService->sendNotification(
                    $user,
                    $this->title,
                    $this->body,
                    $this->data,
                    $this->type
                );
            }
        });
    }
}
