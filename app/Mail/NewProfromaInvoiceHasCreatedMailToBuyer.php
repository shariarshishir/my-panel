<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewProfromaInvoiceHasCreatedMailToBuyer extends Mailable
{
    use Queueable, SerializesModels;

    public $proformaInvoice;
    public $rfqInfo;

    public function __construct($proformaInvoice, $rfqInfo)
    {
        $this->proformaInvoice = $proformaInvoice;
        $this->rfqInfo = $rfqInfo;

    }
    public function build()
    {
        return $this->markdown('emails.email_to_buyer_for_proforma_invoice')->subject('New Proforma Invoice For You')->with(['proformaInvoice' => $this->proformaInvoice, 'rfqInfo' => $this->rfqInfo]);
    }
}
