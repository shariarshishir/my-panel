<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderQueryFromAdminNotification;
use App\Mail\OrderQueryFromAdminMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\PushNotificationTrait;
class OrderQueryFromAdminListener implements ShouldQueue
{
    use PushNotificationTrait;

    public function handle($event)
    {

        //send push notification
        $fcmToken=$event->query->orderModificationRequest->user->fcm_token;
        $title = "Order query request processed";
        $message = "Your order query request has been processed.Please check your order query list.";
        $action_url = route('user.order.query.index'); 
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        //send database notification and mail to user
        Notification::send($event->query->orderModificationRequest->user,new OrderQueryFromAdminNotification($event->query));
        Mail::to($event->query->orderModificationRequest->user->email)->send(new OrderQueryFromAdminMail($event->query));


    }
}
