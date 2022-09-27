<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AskForPaymentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order_list;

    public function __construct($order_list)
    {
        $this->order_list = $order_list;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ask_for_payment')->subject('Order Payments')->with(['orderList'=> $this->order_list]);
    }
}
