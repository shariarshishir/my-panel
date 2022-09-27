<?php

namespace App\Http\Controllers;
use App\Models\SubscribedUserEmail;
use Illuminate\Http\Request;

class SubscribedUserEmailController extends Controller
{
    public function subscribeForNewsletter(Request $request){

       
        $request->validate([
            'newsletter_email_address'  => 'required|email|unique:subscribed_user_emails',
        ]);
        try{
            $subscribedUserEmail=new SubscribedUserEmail();
            $subscribedUserEmail->newsletter_email_address=$request->newsletter_email_address;
            $subscribedUserEmail->ip_address = $request->ip();
            $subscribedUserEmail->user_agent = $request->header('User-Agent');
            $subscribedUserEmail->save();
            return response()->json(['message'=>'You have  successfully subscribed for newsletter ','success'=>true]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error'   => ['message' => $e->getMessage()],
            ],500);

        }

    }
}
