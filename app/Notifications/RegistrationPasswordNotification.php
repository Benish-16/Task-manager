<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class RegistrationPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Build the password reset URL
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Welcome to Our Platform!'))
            ->greeting('🎉 Congratulations, ' . $notifiable->name . '!')
            ->line('Your account has been successfully created.')
            ->line('Please set your password by clicking the button below:')
            ->action('Set Password', $url)
            ->line(Lang::get('This password reset link will expire in :count minutes.', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')
            ]))
            ->line('If you did not register, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $notifiable->id,
            'email' => $notifiable->email,
        ];
    }
}