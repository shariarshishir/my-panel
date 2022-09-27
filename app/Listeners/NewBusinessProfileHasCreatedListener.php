<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Mail\NewBusinessProfileHasCreatedEmailToAdmin;
use App\Mail\NewBusinessProfileHasCreatedEmailToUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Traits\PushNotificationTrait;
use App\Models\Admin;

class NewBusinessProfileHasCreatedListener implements ShouldQueue
{
    use PushNotificationTrait;
    public function handle($event)
    {
        $admin=Admin::find(1);

        //send push notification to admin for new businessProfile
        $fcmToken = $admin->fcm_token;
        $title = "New business profile has created";
        $message = "A new business profile has created .Please assign success manager to verify information";
        $action_url=route('business.profile.details',$event->business_profile->id);
        
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        // //mail to admin after new business profile create
        Mail::to('success@merchantbay.com')->send(new NewBusinessProfileHasCreatedEmailToAdmin($event->business_profile));

        //mail to user after new business profile create
       
        Mail::to($event->business_profile->user->email)->send(new NewBusinessProfileHasCreatedEmailToUser($event->business_profile));
    }
}
