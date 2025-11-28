<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserDeleted extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('User Deleted - ' . config('app.name'))
                    ->line('A user has been deleted from the system.')
                    ->line('Name: ' . $this->user->name)
                    ->line('Email: ' . $this->user->email)
                    ->line('Deleted by: ' . auth()->user()->name)
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'User Deleted',
            'message' => 'User ' . $this->user->name . ' has been deleted by ' . auth()->user()->name,
            'deleted_user_name' => $this->user->name,
            'deleted_user_email' => $this->user->email,
            'deleted_by' => auth()->user()->name,
            'type' => 'user_deleted',
            'url' => route('admin.users.index')
        ];
    }
}
