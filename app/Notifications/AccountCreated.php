<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class AccountCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $password;

    public function __construct(User $user, $password = null)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
                    ->subject('Your Account Has Been Created - ' . config('app.name'))
                    ->line('Your account has been successfully created.')
                    ->line('Email: ' . $this->user->email)
                    ->line('Name: ' . $this->user->name);

        if ($this->password) {
            $mail->line('Temporary Password: ' . $this->password)
                 ->line('Please change your password after first login.');
        }

        $mail->action('Login to Your Account', route('login'))
             ->line('Thank you for using our application!');

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Account Created',
            'message' => 'Your account has been created successfully.',
            'type' => 'account_created',
            'url' => route('login')
        ];
    }
}
