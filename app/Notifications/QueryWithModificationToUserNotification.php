<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QueryWithModificationToUserNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $data;

    public function __construct($data)
    {
        $this->data=$data;
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

    public function toDatabase($notifiable)
    {
        return [
            'title' => "Order Modification Request Processed",
            'notification_data'=> $this->data,
            'notification_type'=>"QueryWithModification",
            'url' => route('ord.mod.req.index'),
        ];
    }
}
