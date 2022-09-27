<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rfq;
use App\Models\BusinessProfile;
use App\Models\SupplierBid;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Events\NewRfqHasBidEvent;
use stdClass;

class RfqBidController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rfq_id' => 'required',
            'business_profile_id'=>'required',
            'unit_price'=>'required',
            'description' => 'required',
            'delivery_time'  => 'required',
           ]);
            if ($validator->fails())
            {
             return response()->json(array(
             'success' => false,
             'error' => $validator->getMessageBag()),
             400);
            }

            $allData=$request->only('rfq_id','business_profile_id','unit_price','description','delivery_time');
            $allData['supplier_id']=auth()->id();
            $rfq = Rfq::find($request->rfq_id);
            $bidData=SupplierBid::create($allData);

       
        //send mail to the user who had created rfq
        if(env('APP_ENV') == 'production')
        {
            $selectedUserToSendMail= $rfq;
            event(new NewRfqHasBidEvent($selectedUserToSendMail, $bidData));

            //send mail to merchantbay
            $selectedUserToSendMail="success@merchantbay.com";
            event(new NewRfqHasBidEvent($selectedUserToSendMail, $bidData));
        }
        
        if($bidData){
            return response()->json([
                'success' => true,
                'rfqBid' => $bidData,
                'msg'    => 'Congratulations!!! Your Quotation has been successfully submitted. Buyer will contact you upon interest for further communication'
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
            ],200);

        }
        

    }
    public function rfqBidsByRfqId($rfqId){
        $bids = SupplierBid::where('rfq_id',$rfqId)->get();
        $bidsArray=[];
        foreach($bids as $bid){
                $newFormatedBid = new stdClass();
                $newFormatedBid->id = $bid->id;
                $newFormatedBid->rfq_id   = $bid->rfq_id;
                $newFormatedBid->user_id = $bid->businessProfile->user->id;
                $newFormatedBid->business_profile_id = $bid->business_profile_id;
                //$newFormatedBid->user_image = $bid->businessProfile->user->image;
                //$newFormatedBid->supplier_id = $bid->supplier_id;
                $newFormatedBid->title = $bid->rfq->title;
                //$newFormatedBid->description = $bid->description;
                $newFormatedBid->description = $bid->description;
                //$newFormatedBid->media = json_decode($bid->media);
                //$newFormatedBid->quantity =$bid->quantity;
                //$newFormatedBid->unit   = $bid->unit;
                
                $newFormatedBid->rfq_unit_price   = $bid->rfq->unit_price??NULL;
                $newFormatedBid->unit_price   = $bid->unit_price;
                //$newFormatedBid->total_price   = $bid->total_price;
                //$newFormatedBid->destination   = $bid->destination;
                //$newFormatedBid->payment_method   = $bid->payment_method;
                // $newFormatedBid->destination   = $bid->destination;
                $newFormatedBid->user_name   = $bid->user->name;
                $newFormatedBid->company_name   = $bid->user->company_name;
                $newFormatedBid->created_at   = $bid->created_at;
                //$newFormatedBid->delivery_time   = $bid->delivery_time;

                array_push($bidsArray,$newFormatedBid);
        }
        if(count($bidsArray)){
            return response()->json([
                'success' => true,
                'rfqBids' => $bidsArray,
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'rfqBids' => $bidsArray,
            ],200);

        }

    }

    public function rfqBidCreatedByAuthUser(){
        
        $bids = SupplierBid::with('rfq')->where('supplier_id',auth()->user()->id)->paginate(10);
        $bidsArray=[];
        foreach($bids as $bid){
            $newFormatedBid = new stdClass();
            $newFormatedBid->id = $bid->id;
            $newFormatedBid->rfq_id   = $bid->rfq_id;
            $newFormatedBid->business_profile_id = $bid->business_profile_id;
            //$newFormatedBid->user_image = $bid->businessProfile->user->image;
            //$newFormatedBid->supplier_id = $bid->supplier_id;
            $newFormatedBid->title = $bid->rfq->title??NULL;
            //$newFormatedBid->description = $bid->description;
            //$newFormatedBid->rfq_short_description = $bid->rfq->short_description;
            //$newFormatedBid->media = json_decode($bid->media);
            //$newFormatedBid->quantity =$bid->quantity;
            //$newFormatedBid->unit   = $bid->unit;
            
            $newFormatedBid->rfq_unit_price   = $bid->rfq->unit_price??NULL;
            $newFormatedBid->unit_price   = $bid->unit_price;
            //$newFormatedBid->total_price   = $bid->total_price;
            //$newFormatedBid->destination   = $bid->destination;
            //$newFormatedBid->payment_method   = $bid->payment_method;
            // $newFormatedBid->destination   = $bid->destination;
            $newFormatedBid->user_name   = $bid->user->name;
            $newFormatedBid->company_name_of_buyer   = $bid->rfq->user->company_name;
            $newFormatedBid->created_at   = $bid->created_at;
            //$newFormatedBid->delivery_time   = $bid->delivery_time;

                array_push($bidsArray,$newFormatedBid);
        }
        if(count($bidsArray)){
            return response()->json([
                'success' => true,
                'rfqBids' => $bidsArray,
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'rfqBids' => $bidsArray,
            ],200);

        }
    }

    public function bidDetails($id){
        $bid = SupplierBid::with('rfq.images','rfq.user')->find($id);
        if($id){
            return response()->json([
                'success' => true,
                'bid' => $bid,
            ],200);
        }
        else{
            return response()->json([
                'success' => false,
                'bid' => $bid,
            ],200);

        }
        


    }

    public function newRfqBidNotificationMarkAsRead(Request $request){

            foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\RfqBidNotification')->where('read_at',null) as $notification){
                if($notification->data['notification_data']['rfq_id'] == $request->rfq_bid_id )
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
