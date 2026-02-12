<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends VerifyEmailBase
{

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        \Illuminate\Support\Facades\Log::info('Sending verification email', [
            'user_id' => $notifiable->id,
            'locale' => app()->getLocale(),
            'subject_translation' => __('api.verification.subject'),
            'messages_test' => __('messages.Account registered successfully, please verify your email address'),
        ]);

        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(__('messages.verification.subject'))
            ->greeting(__('messages.verification.greeting'))
            ->line(__('messages.verification.instruction'))
            ->action(__('messages.verification.action'), $verificationUrl)
            ->line(__('messages.verification.footer'))
            ->salutation(__('messages.verification.salutation'));
    }
}