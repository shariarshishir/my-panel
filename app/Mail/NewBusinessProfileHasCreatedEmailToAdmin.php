<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBusinessProfileHasCreatedEmailToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $business_profile;
    public function __construct($business_profile)
    {
        $this->business_profile = $business_profile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email_to_admin_for_new_business_profile_create')->subject('New Business Profile Created')->with('business_profile',$this->business_profile);
    }
}
