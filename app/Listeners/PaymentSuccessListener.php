<?php

namespace App\Listeners;

use App\Mail\PaymentSuccessMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Notifications\PaymentSuccessNotification;

class PaymentSuccessListener implements ShouldQueue
{
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        //to admin
        $admin=Admin::find(1);
        Notification::send($admin,new PaymentSuccessNotification($event->order,'admin'));
        Mail::to('no-reply@merchantbay.com')->send(new PaymentSuccessMail($event->order, 'admin'));
        //to user
        Notification::send($event->order->user,new PaymentSuccessNotification($event->order,'user'));
        Mail::to($event->order->user->email)->send(new PaymentSuccessMail($event->order, 'user'));
    }
}
