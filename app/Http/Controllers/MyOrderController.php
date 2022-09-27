<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorOrder;

class MyOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = VendorOrder::where('user_id',auth()->user()->id)->with(['billingAddress','shippingAddress'])->latest()->get();
        $orderApprovedNotificationIds = [];
        foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\NewOrderHasApprovedNotification')->where('read_at',null) as $notification)
        {
            array_push($orderApprovedNotificationIds,$notification->data['notification_data']);
           
        }
        return view('my_order.orders.index',compact('orders','orderApprovedNotificationIds'));
    }
    public function  orderNotificationMarkAsRead(Request $request){

        foreach(auth()->user()->unreadNotifications->where('read_at',null) as $notification){
            if($notification->type == "App\Notifications\NewOrderHasApprovedNotification" && $notification->data['notification_data'] == $request->orderId)
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
