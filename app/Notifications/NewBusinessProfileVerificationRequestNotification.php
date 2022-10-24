<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBusinessProfileVerificationRequestNotification extends Notification
{
    use Queueable;

    public $businessProfileVerificationsRequest;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($businessProfileVerificationsRequest)
    {
        $this->businessProfileVerificationsRequest = $businessProfileVerificationsRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }



    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Profile verification request',
            'notification_data' => $this->businessProfileVerificationsRequest ,
            'notification_type'=>"BusinessProfileVerificationRequest",
            'url'=>route('verification.request.index')
        ];
       
    }


}
