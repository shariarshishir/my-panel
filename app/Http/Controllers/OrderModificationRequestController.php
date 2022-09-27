<?php

namespace App\Http\Controllers;

use App\Models\OrderModificationComment;
use App\Models\OrderModificationRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Image;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderModification;
use App\Events\NewOrderModificationRequestEvent;
use Illuminate\Support\Facades\Storage;
use App\Notifications\QueryCommuncationNotification;
use App\Mail\QueryCommuncationMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Http\Traits\PushNotificationTrait;


class OrderModificationRequestController extends Controller
{
    use PushNotificationTrait;

    public function __construct()
    {
      $this->middleware(['auth','sso.verified']);
    }

    public function index()
    {

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

        $countOrderQueryMdf=array_count_values($orderModificationRequestIds);

        //  if(auth()->user()->user_type=='buyer'){
            $orderModificationRequest=OrderModificationRequest::where(['user_id' => auth()->user()->id, 'type' => 2])->with(['comments.replies', 'orderModification'])->get();
        // }
        // else{
        //     $orderModificationRequest=OrderModificationRequest::latest()->where('vendor_id',auth()->user()->vendor->id)->with(['comments.replies', 'orderModification'])->get();
        // }

       //return view('user.profile.orders_modification._partial_index',compact('orderModificationRequest','orderIds','orderModificationRequestIds','notifications','orderQueryProcessedIds','countOrderQueryMdf'));
       return view('my_order.orders_modification.index',compact('orderModificationRequest','orderIds','orderModificationRequestIds','notifications','orderQueryProcessedIds','countOrderQueryMdf'));


    }
    public function commentCreateShow($id)
    {

        try{
            $orderModificationRequset=OrderModificationRequest::where('id',$id)->with('comments.user')->first();

            $requestContainer=[];
            foreach(json_decode($orderModificationRequset->details) as $requestDetail){
                $html='<div class="col m12 order_reply_box">';
                $html.='<div class="row order-info-top">';
                $html.='<div class="col m12 create-date"><i class="material-icons">date_range</i>'.\Carbon\Carbon::parse($orderModificationRequset->created_at)->isoFormat("MMMM Do YYYY").'</div>';
                $html.='</div>';
                $html.='<div class="row order-info-bottom">';
                $html.='<div class="col m12 order-info-details">'.$requestDetail->details.'</div>';
                if(isset($requestDetail->image)){
                $html.='<div class="mod-detail-image col m12 order-info-image">';
                    $image= asset('storage/'.$requestDetail->image);
                    $html.='<img src="'.$image.'" alt="" >';
                $html.='</div>';
                }
                $html.='</div>';
                $html.='</div>';
                array_push($requestContainer, $html);
            }
            $container=[];
            foreach($orderModificationRequset->comments as $comment){
                     $commenter_name= $comment->user->name ?? 'Merchantbay';
                     foreach(json_decode($comment->details) as $detail){
                         $html='<div class="col m12 reply-row order_reply_box">';
                            $html.='<div class="row order-info-top">';
                            $html.='<div class="col m12 order_reply_box">';
                            $html.='<p><i class="material-icons">person</i> '.$commenter_name.'</p>';
                            $html.='<p><i class="material-icons">date_range</i> '. \Carbon\Carbon::parse($comment->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a').'</p>';
                            $html.='</div>';
                            $html.='</div>';
                            $html.='<div class="row order-info-bottom">';
                            $html.='<div class="col m12 order-info-details">'.$detail->details.'</div>';
                            if(isset($detail->image)){
                                $html.='<div class="mod-detail-image col m12 order-info-image">';
                                $image= asset('storage/'.$detail->image);
                                $html.='<img src="'.$image.'" alt="">';
                                $html.='</div>';
                            }
                            $html.='</div>';
                            $html.='</div>';
                            array_push($container, $html);
                     }
            }
            return response()->json(array(
                'success' => true,
                'data' => $orderModificationRequset,
                'comment' => $container,
                'order_request_details' => $requestContainer,
            ), 200);
       }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage().$e->getLine(),),
                500);
       }
    }


    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'prod_mod_req.details.*' => 'required',
        ],
        ['prod_mod_req.details.*.required' => 'Details are required']
        );

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }


        try{

            $product=Product::where('id',$request->product_id)->with('businessProfile')->first();
            $details=[];
            foreach($request->prod_mod_req as $key => $value)
                    {
                        foreach($value as $key2 => $value2 )
                            {
                                if($key== 'image')
                                {
                                    $filename = $value2->store('images/'.$product->businessProfile->business_name.'/products/modification_request','public');
                                    $image_resize = Image::make(public_path('storage/'.$filename));
                                    $image_resize->fit(300, 300);
                                    $image_resize->save(public_path('storage/'.$filename));
                                    $details[$key2]['image']=$filename;
                                }
                                else if($key== 'details')
                                {
                                        $details[$key2]['details']=$value2;
                                }

                            }
                    }

                    $orderModificationRequest=OrderModificationRequest::create([
                    'type'      => config('constants.order_query_type.order_query_with_modification'),
                    'user_id'   => auth()->id(),
                    'product_id'=> $product->id,
                    'business_profile_id' => $product->business_profile_id,
                    'details'   => json_encode($details),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                ]);


                event(new NewOrderModificationRequestEvent($orderModificationRequest));

                return response()->json([
                    'success' => 'Request Created Successfully!',
                    'message' => 'Done!',
                    'type' => 'success',
                ],200);
            // return response()->json(array('success' => true, 'msg' => 'Request Created Successfully'),200);
        }catch (\Exception $e) {
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
        }
    }


    public function replay( Request $request , $id)
    {

       try{
            $details=[];
            $product=Product::where('id', $request->product_id)->with('businessProfile')->first();
            foreach($request->ord_mod_replay as $key => $value)
                    {
                        foreach($value as $key2 => $value2 )
                            {
                                if($key== 'image')
                                {
                                    $filename = $value2->store('images/'.$product->businessProfile->business_name.'/products/modification_request','public');
                                    $image_resize = Image::make(public_path('storage/'.$filename));
                                    $image_resize->fit(300, 300);
                                    $image_resize->save(public_path('storage/'.$filename));
                                    $details[$key2]['image']=$filename;
                                }
                                else if($key== 'details')
                                {
                                        $details[$key2]['details']=$value2;
                                }

                            }
                    }
            $data=OrderModificationComment::create([
                'order_modification_request_id' => $id,
                'user_id'                       => auth()->id(),
                'parent_id'                     => isset($request->parent_id) ? $request->parent_id : null,
                'details'                       => json_encode($details),
                'ip_address'                    => $request->ip(),
                'user_agent'                    => $request->header('User-Agent'),
            ]);
            $admin= Admin::find(1);

            //send push notification to admin for new order modification request
            $fcmToken = $admin->fcm_token;
            $title = "New reply message for order modification request from".$data->user->name;
            $details = json_decode($data->details);
            $message = $details[0]->details;
            $action_url = route('query.show', $data->orderModificationRequest->id);
            $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

            Notification::send($admin,new QueryCommuncationNotification($data ,'user'));
            Mail::to('success@merchantbay.com')->send(new QueryCommuncationMail($data, 'user'));
            return response()->json([
                'success' => 'Request Created Successfully!',
                'message' => 'Done!',
                'type' => 'success',
            ],200);
            //return response()->json(array('success' => true, 'msg' => 'Created Successfully'),200);
       }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
            }
    }


    public function createOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ord_mod_unit_price' => 'required',
            'color_size.*'       => 'required',
            'ord_mod_total_quantity' => 'required',
            'ord_mod_total_price'    => 'required',
            // 'ord_mod_image'          => 'required',

        ],
        [   'ord_mod_unit_price.required' => 'Unit Price are required',
            'color_size.*.required'       => 'Color Size are required',
            'ord_mod_total_quantity.required' => 'Quantity are required',
            'ord_mod_total_price.required'    => 'Price are required',
            // 'ord_mod_image.required'          => 'Image are required',
        ]
        );

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        try{

            $product=Product::where('id',$request->product_id)->first();
            $colors_sizes=[];
            foreach($request->color_size as $key => $value)
                {
                    foreach($value as $key2 => $value2 )
                        {
                            if($key=='color'){
                                $colors_sizes[$key2][$key]=$value2;
                            }else{
                                $colors_sizes[$key2][$key]=(int)$value2;
                            }

                        }
                }
                if($request->hasFile('ord_mod_image'))
                {
                    $filename = $request->ord_mod_image->store('images/'.$product->vendor->vendor_name.'/products/modification_request','public');
                    $image_resize = Image::make(public_path('storage/'.$filename));
                    $image_resize->fit(300, 300);
                    $image_resize->save(public_path('storage/'.$filename));

                }
                 $data=[
                    'order_modification_request_id'   => $request->ord_mod_req_id,
                    'product_sku'=> $product->sku,
                    'name' => $product->name,
                    'image' => isset($filename) ? $filename : null,
                    'colors_sizes'   => json_encode($colors_sizes),
                    'quantity'     => $request->ord_mod_total_quantity,
                    'unit_price'     => $request->ord_mod_unit_price,
                    'total_price'     => $request->ord_mod_total_quantity * $request->ord_mod_unit_price,
                 ];
                $orderModification=OrderModification::where('order_modification_request_id', $request->ord_mod_req_id)->first();
                if($orderModification){
                    if($request->hasFile('ord_mod_image'))
                    {
                       if(Storage::exists('public/'.$orderModification->image)){
                           Storage::delete('public/'.$orderModification->image);
                       }
                    }
                    $orderModification->Update([
                        'order_modification_request_id'   => $request->ord_mod_req_id,
                        'product_sku'=> $product->sku,
                        'name' => $product->name,
                        'image'   => isset($filename) ? $filename : $orderModification->image,
                        'colors_sizes'   => json_encode($colors_sizes),
                        'quantity'     => $request->ord_mod_total_quantity,
                        'unit_price'     => $request->ord_mod_unit_price,
                        'total_price'     => $request->ord_mod_total_quantity * $request->ord_mod_unit_price,
                     ]);

                }else{
                    OrderModification::Create($data);
                }

            return response()->json(array('success' => true, 'msg' => 'Created Successfully'),200);
        }catch (\Exception $e) {
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage().$e->getLine(),),
                500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderModificationRequest  $orderModificationRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderModificationRequest $orderModificationRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderModificationRequest  $orderModificationRequest
     * @return \Illuminate\Http\Response
     */
    public function orderProposalShow($id)
    {
        try{
            $orderModification=OrderModification::where('id',$id)->with('product.images')->first();
            $checkIfOrdered=$orderModification->orderModificationRequest->state == config('constants.order_query_status.ordered') ? 1 : 0;
            return response()->json(array(
                'success' => true,
                'data' => $orderModification,
                'check_if_ordered' => $checkIfOrdered,
            ), 200);
        }catch(\Exception $e){
            return response()->json(array(
                'success' => false,
                'error' => $e->getMessage(),),
                500);
       }
    }
    //order modification proposal create form
    public function ordModProposalCreateForm($ord_mod_req_id)
    {
            try{
                $orderModification=OrderModification::where('order_modification_request_id', $ord_mod_req_id)->first();
                $data=[];
                $checkIfOrdered=0;
                if($orderModification){
                    $data=$orderModification;
                    $checkIfOrdered=$orderModification->orderItem ? 1 : 0;
                }

                return response()->json(array(
                    'success' => true,
                    'data' => $orderModification,
                    'check_if_ordered' => $checkIfOrdered,
                ), 200);
            }catch(\Exception $e){
                return response()->json(array(
                    'success' => false,
                    'error' => $e->getMessage(),),
                    500);
            }
    }



}
