<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordBase implements ShouldQueue
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        parent::__construct($token);
        $this->token = $token;
        $this->locale = app()->getLocale();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('messages.password_reset.subject'))
            ->greeting(__('messages.password_reset.greeting'))
            ->line(__('messages.password_reset.instruction'))
            ->action(__('messages.password_reset.action'), url(config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . $notifiable->getEmailForPasswordReset()))
            ->line(__('messages.password_reset.expire', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(__('messages.password_reset.footer'))
            ->salutation(__('messages.password_reset.salutation'));
    }
}
