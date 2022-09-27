<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
   public function index(Request $request)
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

        $countOrderApproved=array_count_values($orderIds);

        if(auth()->user()->user_type=='buyer'){
                $orders = VendorOrder::where('user_id',auth()->user()->id)->with(['billingAddress','shippingAddress'])->latest()->get();

            }
            else{
                $receivedOrder = VendorOrder::where('vendor_id',auth()->user()->vendor->id)->whereNotIn('state', ['pending','cancel'])->with(['billingAddress','shippingAddress'])->latest()->get();
                $givingOrder = VendorOrder::where('user_id',auth()->user()->id)->with(['billingAddress','shippingAddress'])->latest()->get();

                $orders=$receivedOrder->merge($givingOrder);
                foreach($orders as $data){
                    if($data->vendor_id == auth()->user()->id){
                        $data['order_type'] = 'received_order';
                    }else{
                        $data['order_type'] = 'giving_order';
                    }
                }
            }

        return view('user.profile.orders._partial_index',compact('orders','orderIds','orderModificationRequestIds','notifications','orderQueryProcessedIds','countOrderApproved'));
   }

   public function orderDelivered($orderNumber){

        VendorOrder::where('order_number',$orderNumber)->update(array('state' =>'deliver'));
        $vendorOrder=VendorOrder::with('user','vendor')->where('order_number',$orderNumber)->first();
        //$vendor=Vendor::with('user')->where('id',$vendorOrder->vendor_id)->first();

        Mail::send('emails.storeReviewEmail', ['vendorOrder'=>$vendorOrder], function($message) use($vendorOrder){
            $message->to($vendorOrder->user['email']);
            $message->subject('Reveiw the supplier');
        });
        Mail::send('emails.buyerReviewEmail', ['vendorOrder'=>$vendorOrder], function($message) use($vendorOrder){
            $message->to($vendorOrder->vendor->user->email);
            $message->subject('Reveiw the buyer');
        });

        return redirect()->back()->with('success','order delivered successfully');
   }

   //order type filter
   public function orderTypeFilter(Request $request)
   {
        $receivedOrder = VendorOrder::where('vendor_id',auth()->user()->vendor->id)->whereNotIn('state', ['pending','cancel'])->with(['billingAddress','shippingAddress'])->latest()->get();
        $givingOrder = VendorOrder::where('user_id',auth()->user()->id)->with(['billingAddress','shippingAddress'])->latest()->get();

        $orders=$receivedOrder->merge($givingOrder);
        foreach($orders as $data){
            if($data->vendor_id == auth()->user()->vendor->id){
                $data['order_type'] = 'received_order';
            }else{
                $data['order_type'] = 'giving_order';
            }
        }
        if($request->order_type != null){
            $filter= $orders->where('order_type', $request->order_type);
            $data=view('user.profile.orders._order_data',['orders' => $filter])->render();
            return response()->json([
                   'success' => true,
                   'data'    => $data,
            ],200);
        }
        $data=view('user.profile.orders._order_data',['orders' => $orders])->render();
            return response()->json([
                   'success' => true,
                   'data'    => $data,
            ],200);
   }



}


