<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApprovedNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Account Has Been Approved!')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Great news! Your account has been reviewed and approved by our admin team.')
            ->line('You can now log in and access the platform.')
            ->action('Login Now', route('login'))
            ->line('Welcome aboard — we are glad to have you.');
    }
}
