<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBusinessProfileHasCreatedEmailToUser extends Mailable
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
        return $this->markdown('emails.email_to_new_business_profile_creator')->subject('Business Profile Created Successfully')->with('business_profile',$this->business_profile);
    }
}
