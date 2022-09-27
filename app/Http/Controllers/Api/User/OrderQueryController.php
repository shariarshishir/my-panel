<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\OrderModificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderModification;
use Illuminate\Support\Facades\Validator;
use App\Events\OrderQueryEvent;
use stdClass;


class OrderQueryController extends Controller
{
    public function index()
    {
        $orderQueries=OrderModificationRequest::with('orderModification')->where(['user_id' => auth()->id(), 'type' => 1])->get();
        $orderQueryProcessedIds=[];
        foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\OrderQueryFromAdminNotification')->where('read_at',null) as $notification){
            array_push($orderQueryProcessedIds,$notification->data['notification_data']['order_modification_request_id']);
        }
        $orderQueriesArray=[];
        if(count($orderQueries)>0){
            foreach($orderQueries as $orderQuery){

                   $newFormatedOrderQuery= new stdClass();
                   $newFormatedOrderQuery->id=$orderQuery->id;
                   $newFormatedOrderQuery->type=$orderQuery->type;
                   $newFormatedOrderQuery->user=$orderQuery->user->name;
                   $newFormatedOrderQuery->email=$orderQuery->user->email;
                   $newFormatedOrderQuery->product_id=$orderQuery->product_id;
                   $newFormatedOrderQuery->product_type=$orderQuery->product->product_type;
                   $newFormatedOrderQuery->details=json_decode($orderQuery->details);
                   $newFormatedOrderQuery->order_modification=$orderQuery->orderModification;
                   $newFormatedOrderQuery->state=$orderQuery->state;
                   $newFormatedOrderQuery->created_at=$orderQuery->created_at;
                   $newFormatedOrderQuery->updated_at=$orderQuery->updated_at;
                   $newFormatedOrderQuery->orderQueryProcessedIds=array_unique($orderQueryProcessedIds);
                   array_push($orderQueriesArray,$newFormatedOrderQuery);
            }
  

          
            return response()->json(array(
                'code' => true,
                'orderQueries' => $orderQueriesArray,
               
            ), 200);
 
        }
        else{
            return response()->json(array(
                'code' => false,
                'orderQueries'=>[]
            ),200 );
        }
    }

    public function show($orderModificationRequestId)
    {
        $orderQuery=OrderModificationRequest::where(['id' =>$orderModificationRequestId, 'type' => 1])->first();
        if($orderQuery){
            $newFormatedOrderQuery= new stdClass();
            $newFormatedOrderQuery->id=$orderQuery->id;
            $newFormatedOrderQuery->type=$orderQuery->type;
            $newFormatedOrderQuery->user=$orderQuery->user->name;
            $newFormatedOrderQuery->product_id=$orderQuery->product_id;
            $newFormatedOrderQuery->details=json_decode($orderQuery->details);
            //$newFormatedOrderQuery->state=$orderQuery->state;
            $newFormatedOrderQuery->created_at=$orderQuery->created_at;
            $newFormatedOrderQuery->updated_at=$orderQuery->updated_at;
            return response()->json(array(
                'code' => true,
                'orderQuery' => $newFormatedOrderQuery
            ), 200);

        }
        else{
            return response()->json(array(
                'code' => false,
                'orderQuery'=> $orderQuery
            ),200 );
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'product_id' => 'required',
            'business_profile_id' => 'required',
            'color_attr' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'code' => false,
            'message' => $validator->getMessageBag()),
            400);
        }
        $orderModificationRequest=OrderModificationRequest::create([
            'type'      => $request->type,
            'user_id'   => auth()->user()->id,
            'product_id'=> $request->product_id,
            'business_profile_id' => $request->business_profile_id,
            'details'   => json_encode($request->color_attr),
            'state'=> config('constants.order_query_status.pending')
        ]);

        if(env('APP_ENV') == 'production')
        {
            event(new OrderQueryEvent($orderModificationRequest));
        }

        if($orderModificationRequest){
            return response()->json(array('code' => true, 'message' => 'Order query Created Successfully','orderMordificationRequest'=> $orderModificationRequest),200);

        }else{
            return response()->json(array('code' => false, 'message' => 'Failed to create order query '),200);

        }
        
    }



    public function showOrderQueryWithModification($orderModificationtId)
    {
        
        $orderModification=OrderModification::where('id',$orderModificationtId)->with('orderModificationRequest')->first();
        if($orderModification){
            $newFormatedOrderModification= new stdClass();
            $newFormatedOrderModification->id=$orderModification->id;
            $newFormatedOrderModification->product_sku=$orderModification->product_sku;
            $newFormatedOrderModification->type=$orderModification->type;
            $newFormatedOrderModification->unit_price=$orderModification->unit_price;
            $newFormatedOrderModification->colors_sizes=json_decode($orderModification->colors_sizes);
            $newFormatedOrderModification->discount=$orderModification->discount;
            $newFormatedOrderModification->total_price=$orderModification->total_price;
            $newFormatedOrderModification->orderModificationRequest=$orderModification->orderModificationRequest;
            return response()->json(array(
                'code' => true,
                'orderModification' => $newFormatedOrderModification
            ), 200);

        }
        else{
            return response()->json(array(
                'code' => false,
                'orderModification'=> $newFormatedOrderModification
            ),200 );
        }
    }

    public function  orderQueryFromAdminNotificationMarkAsRead(Request $request){

        foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\OrderQueryFromAdminNotification')->where('read_at',null) as $notification){
            if( $notification->data['notification_data']['order_modification_request_id'] == $request->order_modification_request_id)
            {
                $notification->markAsRead();
                $unreadNotifications=auth()->user()->unreadNotifications->where('read_at',null);
                $noOfnotification=count($unreadNotifications);
                $message="Notification mark as read successfully";
                return response()->json(['code'=>true,'message'=>$message,'noOfnotification'=>$noOfnotification]);

                        
            }
            else{
                $unreadNotifications=auth()->user()->unreadNotifications->where('read_at',null);
                $noOfnotification=count($unreadNotifications);
                $message="Notification not found";
                return response()->json(['code'=>false,'message'=>$message,'noOfnotification'=>$noOfnotification]);

            }
        }
    }
}
