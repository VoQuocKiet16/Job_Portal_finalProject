<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoleChangeRequestApproved extends Notification
{
    use Queueable;

    protected $requested_role;

    public function __construct($requested_role)
    {
        $this->requested_role = $requested_role;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your role change request has been approved.')
                    ->line('Your new role is: ' . $this->requested_role)
                    ->action('Go to Profile', url('/account/profile'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your role change request has been approved.',
            'new_role' => $this->requested_role,
        ];
    }
}
