<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippingChargeMailToAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;

    public function __construct($order)
    {
        $this->order = $order;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    //     ->attach(public_path('pdf/sample.pdf'), [
    //         'as' => 'sample.pdf',
    //         'mime' => 'application/pdf',
    //    ])
        if(isset($this->order->shippingCharge->file)){
            return $this->markdown('emails.shipping-charge-mail-to-admin')->attach(public_path('storage/'.$this->order->shippingCharge->file))->subject($this->order->order_number.'Shipping Charge')->with(['order'=> $this->order]);
        }else{
            return $this->markdown('emails.shipping-charge-mail-to-admin')->subject($this->order->order_number.'Shipping Charge')->with(['order'=> $this->order]);
        }
    }
}
