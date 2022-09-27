<?php

namespace App\Http\Controllers;

use App\Models\OrderModificationRequest;
use Illuminate\Http\Request;
use App\Models\OrderModificationComment;
use Illuminate\Support\Facades\Validator;
use App\Events\OrderQueryEvent;
use Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QueryCommuncationNotification;
use App\Mail\QueryCommuncationMail;
use App\Http\Traits\PushNotificationTrait;
use Illuminate\Support\Facades\Auth;

class QueryController extends Controller
{
    use PushNotificationTrait;
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_business_id=[];
        if($user->businessProfile()->exists()){
            foreach($user->businessProfile as $profile){
                array_push($user_business_id, $profile->id);
            }
        }
        if($user->businessProfileForRepresentative()->exists()){
            array_push($user_business_id, $user->businessProfileForRepresentative->id);
        }

       $giving=OrderModificationRequest::where(['user_id' => auth()->id(), 'type' => 1])->get();
       foreach($giving as $g){
        $g['queries_type'] = 'giving';
       }
       //return $giving;
       $received=OrderModificationRequest::whereIn('business_profile_id', $user_business_id)->where('type', 1)->get();

       foreach($received as $r){
        $r['queries_type'] = 'received';
       }
       $orderQueries = $giving->merge($received);

       if(isset($request->business_id)){
            $orderQueries = $orderQueries->where('business_profile_id' , $request->business_id)->where('queries_type', 'received');
            $orderQueries->all();
        }

       $notifications = auth()->user()->unreadNotifications;
       $orderIds=[];
       $orderModificationRequestIds=[];
       $orderApprovedNotificationIds=[];
       $orderModificationRequestNotificationIds=[];
       $orderQueryProcessedIds=[];
       foreach($notifications as $notification)
       {
            if($notification->type == "App\Notifications\NewOrderHasApprovedNotification"){
                array_push($orderIds,$notification->data['notification_data']);
            }
            else if($notification->type == "App\Notifications\QueryWithModificationToUserNotification"){
                array_push($orderModificationRequestIds,$notification->data['notification_data']);

            }
            else if($notification->type == "App\Notifications\OrderQueryFromAdminNotification"){
                array_push($orderQueryProcessedIds,$notification->data['notification_data']['order_modification_request_id']);
            }
            else if($notification->type == "App\Notifications\QueryCommuncationNotification"){
                if($notification->data['order_qurey_type'] == 2){
                    array_push($orderModificationRequestIds,$notification->data['notification_data']);
                }
                if($notification->data['order_qurey_type'] == 1){
                    array_push($orderQueryProcessedIds,$notification->data['notification_data']);
                }
            }
            elseif($notification->type == "App\Notifications\PaymentSuccessNotification"){
                array_push($orderIds,$notification->data['notification_data']);
            }
       }
       $countOrderQuery=array_count_values($orderQueryProcessedIds);


    //    return view('user.profile.orders_queries._partial_index',compact('orderQueries','orderIds','orderModificationRequestIds','notifications','orderQueryProcessedIds','countOrderQuery'));
       return view('my_order.orders_queries.index',compact('orderQueries','orderIds','orderModificationRequestIds','notifications','orderQueryProcessedIds','countOrderQuery'));


    }

    public function show($ord_mod_id)
    {


        try{
            //$orderModification=OrderModification::where('id',$ord_mod_id)->with('orderModificationRequest')->first();
            $orderModification=OrderModificationRequest::where('id',$ord_mod_id)->with(['orderModification', 'product'])->first();
            //$checkIfOrdered=$orderModification->orderItem ? 1 : 0;
            $created_at= \Carbon\Carbon::parse($orderModification->created_at)->isoFormat('MMMM Do YYYY , h:mm:ss a');
            return response()->json(array(
                'success' => true,
                'data' => $orderModification,
                'created_at' => $created_at,
                // 'check_if_ordered' => $checkIfOrdered,
            ), 200);
        }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
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
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        $orderModificationRequest=OrderModificationRequest::create([
            'type'      => $request->type,
            'user_id'   => auth()->id(),
            'product_id'=> $request->product_id,
            'business_profile_id' => $request->business_profile_id,
            'details'   => json_encode($request->color_attr),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        event(new OrderQueryEvent($orderModificationRequest));

        return response()->json(array('success' => true, 'msg' => 'Request created successfully. Please check "My Orders" from your profile to get more update about your query.'),200);
    }
    //show communication model
    public function showMessage($order_query_request_id)
    {

        try{
            $orderModificationRequset=OrderModificationRequest::where('id',$order_query_request_id)->with('comments.user')->first();
            $container=[];
            foreach($orderModificationRequset->comments as $comment){
                     $commenter_name= $comment->user->name ?? 'Merchantbay';
                     foreach(json_decode($comment->details) as $detail){
                        $html='<div class="col m12 reply-row">';
                        $html.='<div class="col m12 reply-row-inner">';
                        $html.='<div class="row order-info-top">';
                        $html.='<div class="col m6"><span class="order_inquiry_icon"><i class="material-icons">person</i> '.$commenter_name.'</span></div>';
                        $html.='<div class="col m6" style="text-align: right;"><span class="order_inquiry_icon"><i class="material-icons">date_range</i> '. \Carbon\Carbon::parse($comment->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a').'</span></div>';
                        $html.='</div>';
                        $html.='<div class="row order-info-bottom">';
                        $html.='<div class="col m12 order-info-details">'.$detail->details.'</div>';
                        if(isset($detail->image)){
                            $html.='<div class="mod-detail-image col m12 order-info-image">';
                            $image= asset('storage/'.$detail->image);
                            $html.='<img src="'.$image.'" alt="" height="250" width="250">';
                            $html.='</div>';
                        }
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        array_push($container, $html);
                    }

            }
            return response()->json(array(
                'success' => true,
                'data' => $orderModificationRequset,
                'message' => $container,
            ), 200);
       }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
       }
    }

    //store message
    public function storeMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'order_modification_request_id' => 'required',
           'details' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }

        $details=[];
        $details[0]['details']=$request->details;
        if($request->hasFile('image')){
            $orderModificationRequset=OrderModificationRequest::where('id',$request->order_modification_request_id)->with(['product','businessProfile'])->first();
            $filename = $request->image->store('images/'.$orderModificationRequset->businessProfile->business_name.'/products/modification_request','public');
            $image_resize = Image::make(public_path('storage/'.$filename));
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('storage/'.$filename));
            $details[0]['image']=$filename;
        }

        $data=OrderModificationComment::create([
            'order_modification_request_id' => $request->order_modification_request_id,
            'user_id'                       => auth()->id(),
            'details'                       => json_encode($details),
            'ip_address'                    => $request->ip(),
            'user_agent'                    => $request->header('User-Agent'),
        ]);
        $admin= Admin::find(1);
        //send push notification to admin for order query request message from user
        $fcmToken =  $admin->fcm_token;
        $title = "New message for your order modification request";
        $details = json_decode($data->details);
        $message = $details[0]->details;
        $action_url = route('query.show', $data->orderModificationRequest->id);
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        //send db notification to admin
        Notification::send($admin,new QueryCommuncationNotification($data ,'user'));
        Mail::to('success@merchantbay.com')->send(new QueryCommuncationMail($data, 'user'));
        return response()->json([
            'success' => 'Request Created Successfully!',
            'message' => 'Done!',
            'type' => 'success',
        ],200);
    }
}
