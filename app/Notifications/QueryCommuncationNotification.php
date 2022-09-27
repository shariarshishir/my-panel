<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QueryCommuncationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;
    public $type;

    public function __construct($data, $type)
    {
        $this->data=$data;
        $this->type=$type;
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
        if($this->data->orderModificationRequest->type == 1){
            $url= route('user.order.query.index');
        }else{
            $url = route('ord.mod.req.index');
        }
        return [
            'title' => "Order Modification Request Reply",
            'notification_data'=> $this->data->order_modification_request_id,
            'notification_type'=>"QueryWithModification",
            'order_qurey_type' => $this->data->orderModificationRequest->type,
            'url' => $this->type== 'admin' ? $url : route('query.show',$this->data->order_modification_request_id),
        ];
    }
}
