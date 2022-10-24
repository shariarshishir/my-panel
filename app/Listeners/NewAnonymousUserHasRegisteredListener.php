<?php

namespace App\Listeners;


use App\Mail\NewUserRegistrationMail;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAnonymousUserRegistrationMailToUser;
use App\Http\Traits\PushNotificationTrait;

class NewAnonymousUserHasRegisteredListener implements ShouldQueue
{
    use PushNotificationTrait;
    public function handle($event)
    {
        $admin=Admin::find(1);

        //send push notification to admin for new user registration
        $fcmToken = $admin->fcm_token;
        $title = "New user has registered";
        $message = "A new user is awating for review. Please review the user request and give feedback as soon as possible";
        $action_url=route('user.show',$event->user->id);
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        //mail to admin
        Mail::to('success@merchantbay.com')->send(new NewUserRegistrationMail($event->user));

        //mail to user
        if($event->user->user_agent == "Dart"){
            Mail::send('emails.apiEmailVerificationEmail', ['token' => $event->token], function($message) use($event){
                $message->to($event->user->email);
                $message->subject('Welcome to Merchantbay');
            });
        }
        else{
            Mail::to($event->user->email)->send(new NewAnonymousUserRegistrationMailToUser($event->user, $event->token, $event->password));
        }


    }
}
