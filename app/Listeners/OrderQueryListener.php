<?php

namespace App\Listeners;

use App\Mail\OrderQueryMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderQueryNotification;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\PushNotificationTrait;

class OrderQueryListener implements ShouldQueue
{
    use PushNotificationTrait;
    public function handle($event)
    {
        $admin=Admin::find(1);
        //send push notification to admin 
        $fcmToken = $admin->fcm_token;
        $title = "New order query is requested";
        $message = "A new order query is requested by ".$event->query->user->name.".Please check the order query details";
        $action_url = route('query.edit', $event->query->id);
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        //send database notification and mail to admin
        Notification::send($admin,new OrderQueryNotification($event->query));
        Mail::to('success@merchantbay.com')->send(new OrderQueryMail($event->query));


    }
}
