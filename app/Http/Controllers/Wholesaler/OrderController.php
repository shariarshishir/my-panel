<?php

namespace App\Http\Controllers\Wholesaler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\Mail;
use App\Models\BusinessProfile;

class OrderController extends Controller
{
    public function index($alias)
   {
        $business_profile=BusinessProfile::withTrashed()->where('alias', $alias)->firstOrFail();
        if((auth()->id() == $business_profile->user_id) || (auth()->id() == $business_profile->representative_user_id))
        {
            $orders = VendorOrder::where('business_profile_id',$business_profile->id)->whereNotIn('state', ['pending','cancel'])->with(['billingAddress','shippingAddress'])->latest()->get();
            $orderApprovedNotificationIds = [];
            foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\NewOrderHasApprovedNotification')->where('read_at',null) as $notification)
            {
                array_push($orderApprovedNotificationIds,$notification->data['notification_data']);
               
            }
            return view('wholesaler_profile.orders.index',compact('orders','business_profile','orderApprovedNotificationIds'));
        }
        abort(401);

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
