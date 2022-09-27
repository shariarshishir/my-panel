<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductAvailabilityMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $product;
    public $alert_data;
    public function __construct($product, $alert_data=null)
    {
        $this->product = $product;
        $this->alert_data = $alert_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.product_availability')->subject('Restock product!')->with(['product'=> $this->product, 'alert_data' => $this->alert_data]);
    }
}
