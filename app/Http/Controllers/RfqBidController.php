<?php

namespace App\Http\Controllers;

use App\Models\Rfq;
use App\Models\SupplierBid;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use App\Events\NewRfqHasBidEvent;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\supplierQuotationToBuyer;
use Illuminate\Support\Facades\Validator;

class RfqBidController extends Controller
{
    public function create($rfq_id)
    {
        $business_profile=BusinessProfile::with(['supplierQuotationToBuyer' => function($q) use ($rfq_id){
            $q->where('rfq_id', $rfq_id)->where('from_backend', 0);
        }])->where('user_id',auth()->id())->get();
        if($business_profile->isEmpty())
        {
            $business_profile=BusinessProfile::with(['supplierQuotationToBuyer' => function($q) use ($rfq_id){
                $q->where('rfq_id', $rfq_id)->where('from_backend', 0);
            }])->where('representative_user_id',auth()->id())->get();
        }

        if(count($business_profile) <= 0 ){
            return response()->json(array(
                'success' => false,
                'error' => ['errors' => 'you do not have any business']),
                401);

        }

        $bidData=[];
        foreach($business_profile as $profile){
            if($profile->supplierQuotationToBuyer()->exists()){
                foreach($profile->supplierQuotationToBuyer as $quotation){
                    $dt=['business_profile_id' => $quotation->business_profile_id, 'offer_price' => $quotation->offer_price, 'offer_price_unit' => $quotation->offer_price_unit];
                    array_push($bidData, $dt);
                    break;
                }

            }
        }

        return response()->json(array(
            'success' => true,
            'bid' =>   $bidData,
            'my_business' => $business_profile),
            200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rfq_id' => 'required',
            'business_profile_id'=>'required',
            'offer_price'=>'required',
            'offer_price_unit' => 'required',
           ]);
           if ($validator->fails())
         {
             return response()->json(array(
             'success' => false,
             'error' => $validator->getMessageBag()),
             400);
         }

            $allData=$request->only('rfq_id','business_profile_id','offer_price','offer_price_unit');
            $allData['from_backend']=false;
            $postBidApi= env('RFQ_APP_URL').'/api/supplier-quotation-to-buyer';
            $response = Http::post($postBidApi, $allData);
            return $response;

            return response()->json([
                'success' => true,
                'msg'    => 'Congratulations!!! Your Quotation has been successfully submitted. Buyer will contact you upon interest for further communication'
            ]);


    }


    public function  notificationMarkAsRead(Request $request){

        foreach(auth()->user()->unreadNotifications->where('read_at',null) as $notification){
            if($notification->type == "App\Notifications\RfqBidNotification" && $notification->data['notification_data']['rfq_id'] == $request->rfqId)
            {
                $notification->markAsRead();
                $message="Notification mark as read successfully";
            }
        }

        if(!isset($message)){
            $message="not found";
        }
        $unreadNotifications=auth()->user()->unreadNotifications->where('read_at',null);
        $noOfnotification=count($unreadNotifications);
        return response()->json(['message'=>$message,'noOfnotification'=>$noOfnotification]);

    }

}
