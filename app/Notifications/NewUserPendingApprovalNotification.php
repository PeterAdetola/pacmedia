<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserPendingApprovalNotification extends Notification
{
    use Queueable;

    public function __construct(public User $newUser) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New User Awaiting Approval')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new user has registered and is awaiting your approval.')
            ->line('Name: ' . $this->newUser->name)
            ->line('Email: ' . $this->newUser->email)
            ->action('Review User', route('admin.users.index'))
            ->line('Please log in to approve or reject this account.');
    }
}
