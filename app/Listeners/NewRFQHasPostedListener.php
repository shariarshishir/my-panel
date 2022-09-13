<?php

namespace App\Listeners;


use App\Mail\NewUserRegistrationMail;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegistrationMailToUser;
use App\Mail\NewRFQPostMailToAdmin;
use App\Mail\NewRFQPostMailToUser;
use App\Http\Traits\PushNotificationTrait;

class NewRFQHasPostedListener implements ShouldQueue
{
    use PushNotificationTrait;
    public function handle($event)
    {
        $admin=Admin::find(1);
        //send push notification to admin for new user registration
        $fcmToken = $admin->fcm_token;
        $title = "New RFQ have been posted";
        $message = "A new RFQ is awating for review. Please review the RFQ and give feedback as soon as possible";
        $action_url=route('admin.rfq.index',$event->user->id);
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        //mail to admin
        Mail::to('success@merchantbay.com')->send(new NewRFQPostMailToAdmin($event->user));

        //mail to user
        if($event->user->user_agent == "Dart"){
            Mail::send('emails.new-rfq-to-user', function($message) use($event){
                $message->to($event->user->email);
                $message->subject('Your RFQ have been posted successfully.');
            });
        }
        else{
            Mail::to($event->user->email)->send(new NewRFQPostMailToUser($event->user));
        }


    }
}
