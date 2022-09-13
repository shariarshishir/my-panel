<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewProfromaInvoiceHasCreatedMailToBuyer;
use App\Http\Traits\PushNotificationTrait;

class NewProfromaInvoiceHasCreatedListener implements ShouldQueue
{
    use PushNotificationTrait;
    public function handle($event)
    {
        //send push notification to admin for new order modification request
        // $fcmToken = $event->proformaInvoice->buyer->fcm_token;
        // $title = "New Profroma has received";
        // $message = "A new order profroma invoice is created by ".$event->proformaInvoice->businessProfile->user->name.".Please check the PO details";
        // $action_url = route('open.proforma.single.html', $event->proformaInvoice->id);
        // $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        Mail::to($event->proformaInvoice->buyer->email)->send(new NewProfromaInvoiceHasCreatedMailToBuyer($event->proformaInvoice, $event->rfqInfo));

    }
}
