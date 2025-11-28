<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $oldStatus;
    public $newStatus;

    public function __construct(User $user, $oldStatus, $newStatus)
    {
        $this->user = $user;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('User Status Changed - ' . config('app.name'))
                    ->line('User status has been changed:')
                    ->line('User: ' . $this->user->name)
                    ->line('From: ' . ucfirst($this->oldStatus))
                    ->line('To: ' . ucfirst($this->newStatus))
                    ->action('View User', route('admin.users.edit', $this->user))
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $isAdmin = $notifiable->hasRole('admin');

        if ($isAdmin) {
            return [
                'title' => 'User Status Updated',
                'message' => $this->user->name . "'s status changed from " . $this->oldStatus . ' to ' . $this->newStatus,
                'user_id' => $this->user->id,
                'user_name' => $this->user->name,
                'old_status' => $this->oldStatus,
                'new_status' => $this->newStatus,
                'type' => 'user_status_changed',
                'url' => route('admin.users.edit', $this->user)
            ];
        } else {
            return [
                'title' => 'Account Status Updated',
                'message' => 'Your account status has been changed to ' . $this->newStatus,
                'type' => 'account_status_changed',
                'url' => route('profile')
            ];
        }
    }
}
