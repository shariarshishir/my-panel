<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderQueryNotification extends Notification
{
    use Queueable;

    public  $query;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($query)
    {
        $this->query=$query;


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
            'title' => "Order Query Request",
            'notification_data'=> $this->query,
            'notification_type'=>"OrderQuery",
            'url' =>route('query.show',$this->query->id)
        ];
    }
}
