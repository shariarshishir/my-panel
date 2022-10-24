<?php

namespace App\Listeners;

use App\Mail\ProductAvailabilityMail;
use App\Notifications\ProductAvailabilityNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Models\User;



class ProductAvailabilityListener implements ShouldQueue
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //$user=User::find($event->product->vendor->user_id);
        Notification::send($event->product->businessProfile->user,new ProductAvailabilityNotification($event->product, $event->alert_data));
        Mail::to($event->product->businessProfile->user->email)->send(new ProductAvailabilityMail($event->product, $event->alert_data));
    }
}
