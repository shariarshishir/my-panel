<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Middleware\RateLimited;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRfqHasPublishedMail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewRfqNotification;
use App\Http\Traits\PushNotificationTrait;

class NewRfqHasPublishedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PushNotificationTrait;

    protected $selectedUserToSendMail;
    protected $rfq;
    public $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($selectedUserToSendMail, $rfq)
    {
        $this->selectedUserToSendMail = $selectedUserToSendMail;
        $this->rfq = $rfq;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user=$this->selectedUserToSendMail;
        $rfq=$this->rfq;
        if($user=="success@merchantbay.com"){
            $data=[
                'supplier'=>$user,
                'rfq'=>$rfq,
                'url'=>"/rfq"
            ];
            Mail::to($user)->send(new NewRfqHasPublishedMail($data));
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
                'url'=>"/rfq"
            ];

            Mail::to($user->email)->send(new NewRfqHasPublishedMail($data));
            Notification::send($user,new NewRfqNotification($data));

        }

    }

    public function middleware()
    {
        return [new RateLimited];
    }

}
