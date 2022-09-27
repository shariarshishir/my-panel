<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Rfq;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRfqHasBidMail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RfqBidNotification;
use App\Http\Traits\PushNotificationTrait;


class NewRfqHasBidListener  implements ShouldQueue
{
   use PushNotificationTrait;
    public function handle($event)
    {
        $supplier=$event->selectedUserToSendMail;
        $data=[
            'supplier'=>$supplier,
            'bidData'=>$event->bidData,
            'url'=>"/my-rfq"
        ];
        if($supplier=="success@merchantbay.com"){
           
            Mail::to($supplier)->send(new NewRfqHasBidMail($data));
           
        }else{

            $fcmToken = $supplier->user->fcm_token;
            $title = "new response for your RFQ";
            $message = "Dear, ".$supplier->user->name.", A supplier has reponded for your RFQ.If you are interested please let him know about your interest";
            $action_url = route('rfq.my');
            $this->pushNotificationSend($fcmToken,$title,$message,$action_url);
            
            Mail::to($supplier->user->email)->send(new NewRfqHasBidMail($data));
            Notification::send($supplier->user,new RfqBidNotification($data));

        }
        
        

    }
}
