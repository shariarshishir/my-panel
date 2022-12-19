<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Contactus;
use stdClass;
use App\Events\NewContactRequestHasPostedEvent;
use App\Events\NewSubscriptionRequestHasPostedEvent;

class ContactusController extends Controller
{
    public function index()
    {
        return view('contactus.index');
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $contactData = new Contactus();
        $contactData->contact_name = $request->contact_name;
        $contactData->contact_email = $request->contact_email;
        $contactData->contact_company_name = $request->contact_company_name;
        $contactData->contact_phone = $request->contact_phone;
        $contactData->contact_message = $request->contact_message;
        $contactData->trial_priod_start_date = $request->trial_priod_start_date ?? NULL;
        $contactData->trial_priod_end_date = $request->trial_priod_end_date ?? NULL;
        $contactData->contact_subscription = $request->contact_subscription;
        $contactData->contact_subscription_plan_type = $request->contact_subscription_plan_type ?? NULL;
        $contactData->save();

        $requestFrom = "";

        if($request->contact_subscription == 0) { // mail send for contact us request
            //event(new NewContactRequestHasPostedEvent( $contactData ));
            $requestFrom = "contactus";
        }

        if($request->contact_subscription == 1) { // mail send for subscription request
            //event(new NewSubscriptionRequestHasPostedEvent( $contactData ));
            $requestFrom = "subscription";
        }

        return response()->json(["status" => 1, "requestfrom" => $requestFrom, "message" => "Data saved successfully."]);
    }

    public function contactSuccessMessageView()
    {
        return view('contactus.success');
    }
}
