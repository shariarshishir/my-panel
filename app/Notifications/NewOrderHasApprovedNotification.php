<?php

namespace App\Notifications;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderHasApprovedNotification extends Notification
{
    use Queueable;
    public  $order;
    public  $user_type;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order,$user_type)
    {
      
        $this->order = $order;
        $this->user_type =  $user_type;
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
        if($this->user_type=="wholesaler"){
            return [
                'title' => "New Order has placed by merchant bay",
                'notification_data' => $this->order->id,
                'notification_type' => "OrderApproved",
                'url' => '/wholesaler/order/'.$this->order->businessProfile->id
            ];

        }
        else{
            return [
                'title' => "New Order has approved by merchant bay",
                'notification_data' => $this->order->id,
                'notification_type' => "OrderApproved",
                'url' => '/my-order'
            ];

        }
       
    }


}
