<?php

namespace App\Listeners;
use App\Models\Vendor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderModificationRequestNotification;
use App\Models\Admin;
use App\Mail\NewOrderModificationRequestMail;
use App\Http\Traits\PushNotificationTrait;

class NewOrderModificationRequestListener implements ShouldQueue
{
    use PushNotificationTrait;
    public function handle($event)
    {

        $admin=Admin::find(1);

        //send push notification to admin for new order modification request
        $fcmToken = $admin->fcm_token;
        $title = "New order modifcation is requested";
        $message = "A new order modification is requested by ".$event->orderModificationRequest->user->name.".Please check the order modification request details";
        $action_url = route('query.show', $event->orderModificationRequest->id);
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        Notification::send($admin,new NewOrderModificationRequestNotification($event->orderModificationRequest->id));
        Mail::to('success@merchantbay.com')->send(new NewOrderModificationRequestMail($event->orderModificationRequest));

    }
}
