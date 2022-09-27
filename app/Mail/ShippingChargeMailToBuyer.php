<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippingChargeMailToBuyer extends Mailable implements ShouldQueue
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
        return $this->markdown('emails.shipping-charge-mail-to-buyer')->subject($this->order->order_number.'Shipping Charge')->with(['order'=> $this->order]);
    }
}
