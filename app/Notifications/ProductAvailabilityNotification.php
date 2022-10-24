<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductAvailabilityNotification extends Notification
{
    use Queueable;

    public  $data;
    public  $alert_data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $alert_data=null)
    {
        $this->data=$data;
        $this->alert_data=$alert_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => "Check Your Product Availability",
            'notification_data'=> $this->data,
            'alert_data'    =>  $this->alert_data,
            'notification_type'=>"ProductAvailability",
            'url' => '/seller-product'
        ];
    }
}
