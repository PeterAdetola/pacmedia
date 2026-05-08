<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountSuspendedNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Account Has Been Suspended')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your account has been suspended by an administrator.')
            ->line('If you believe this is a mistake, please contact our support team.')
            ->line('Thank you for your understanding.');
    }
}
