<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Traits\PushNotificationTrait;
use App\Models\Admin;
use App\Notifications\NewBusinessProfileVerificationRequestNotification;

class NewBusinessProfileVerificationRequestListener implements ShouldQueue
{
    use PushNotificationTrait;
   
    public function handle($event)
    {
        $admin=Admin::find(1);

        //send push notification to admin for new businessProfile
        $fcmToken = $admin->fcm_token;
        $title = "New business profile verification request";
        $message = "A new business profile is awaiting for verification .Please assign success manager to verify information";
        $action_url = route('verification.request.index');
        
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);
        Notification::send($admin,new NewBusinessProfileVerificationRequestNotification($event->businessProfileVerificationsRequest));
    }
}
