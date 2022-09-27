<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRfqNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $notification_data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       
        $this->notification_data=$data;
        
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
            'title' => 'New RFQ posted',
            'rfq_data' => $this->notification_data['rfq'],
            'url' => $this->notification_data['url'],
        ];
    }
}
