<?php

namespace App\Listeners;

use App\Models\Rfq;
use App\Models\Admin;
use App\Mail\NewRfqInvitationMail;
use Illuminate\Support\Facades\Mail;
use App\Providers\NewRfqHasAddedEvent;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\NewRfqNotification;
use App\Http\Traits\PushNotificationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NewRfqInvitationListener implements ShouldQueue
{
    use PushNotificationTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewRfqHasAddedEvent  $event
     * @return void
     */
    public function handle($event)
    {

        $user=$event->selectedUserToSendMail;
        $rfq=$event->rfq;
        if($user=="success@merchantbay.com"){
            $data=[
                'supplier'=>$user,
                'rfq'=>$rfq,
                'url'=>route('admin.rfq.index')
            ];
            Mail::to($user)->send(new NewRfqInvitationMail($data));
            $data_for_notifaction=[
                'supplier'=>$user,
                'rfq'=>$rfq,
                'url'=>route('admin.rfq.show', $rfq->id)
            ];
            $admin=Admin::find(1);
            Notification::send($admin,new NewRfqNotification($data_for_notifaction));
        }
        else{

            //send push notification to user for new rfq
            $fcmToken = $user->fcm_token;
            $title = "A new rfq has been posted";
            $message = "Dear, ".$user->name.", A request for quotation you may feel interested about.Please check RFQ list";
            $action_url = route('rfq.index');
            $this->pushNotificationSend($fcmToken,$title,$message,$action_url);
            $data=[
                'supplier'=>$user->name,
                'rfq'=>$rfq,
                'url'=>route('rfq.index')
            ];

            Mail::to($user->email)->send(new NewRfqInvitationMail($data));
            Notification::send($user,new NewRfqNotification($data));

        }

    }
}
