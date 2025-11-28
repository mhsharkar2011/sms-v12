<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New User Registration - ' . config('app.name'))
                    ->line('A new user has registered in the system.')
                    ->line('Name: ' . $this->user->name)
                    ->line('Email: ' . $this->user->email)
                    ->line('Role: ' . $this->user->roles->first()->name ?? 'No role assigned')
                    ->action('View User', route('admin.users.edit', $this->user))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New User Registration',
            'message' => $this->user->name . ' has registered as ' . ($this->user->roles->first()->name ?? 'user'),
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'role' => $this->user->roles->first()->name ?? null,
            'type' => 'user_registered',
            'url' => route('admin.users.edit', $this->user)
        ];
    }
}
