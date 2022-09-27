<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorOrder;
use App\Models\VendorOrderItem;
use Exception;
use Illuminate\Http\Request;
use App\Events\NewOrderHasApprovedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\AskForPaymentMail;
use App\Models\ShipmentType;
use App\Models\ShippingMethod;
use App\Models\UOM;
use App\Http\Traits\PushNotificationTrait;

class OrderController extends Controller
{
    use PushNotificationTrait;

    //orders for business profle and user
    public function index($business_profile_id)
    {
       $collection=VendorOrder::Where('business_profile_id',$business_profile_id)->latest()->paginate(10);
       return view('admin.orders.index',compact('collection','business_profile_id'));
    }

    public function show($business_profile_id,$order_id)
    {
        $vendorOrder=VendorOrder::where('business_profile_id',$business_profile_id)->where('id',$order_id)->with(['billingAddress','shippingAddress','orderItems','shippingCharge'])->first();
        $shippingMethod=ShippingMethod::pluck('name');
        $shipMentType=ShipmentType::pluck('name');
        $uom=UOM::pluck('name');

        return view('admin.orders.show',compact('vendorOrder','shippingMethod','shipMentType','uom'));

    }
    //end orders for business profle and user

    public function orderList()
    {
       $collection=VendorOrder::latest()->paginate(10);
       return view('admin.order.index',compact('collection'));
    }

    public function create($vendorId)
    {
       return view('admin.vendor.order.create',compact('vendorId'));
    }

    public function  store(Request $request,$vendorId)
    {
        $request->validate([
            'order_number' => 'required',

        ]);
        try{
           VendorOrder::create([
               'order_number' => $request->order_number,
               'vendor_id'    => $vendorId,
           ]);
           return redirect()->route('vendor.order.index',$vendorId)->withSuccess('Order Created Successfully');
        }catch(Exception $e)
        {
          return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function edit($vendorId,$order_id)
    {
        $order=VendorOrder::where('id',$order_id)->first();
        return view('admin.vendor.order.edit',compact('order','vendorId'));

    }

    public function showFromNotifaction($businessProfileId,$order_number,$notificationId)
    {
        auth()->guard('admin')->user()->unreadNotifications->where('id', $notificationId)->markAsRead();
        $vendorOrder=VendorOrder::where('business_profile_id',$businessProfileId)->where('order_number',$order_number)->with(['billingAddress','shippingAddress','orderItems','shippingCharge'])->first();
        $orderItems=VendorOrderItem::where('order_id',$vendorOrder->id)->get();
        $shippingMethod=ShippingMethod::pluck('name');
        $shipMentType=ShipmentType::pluck('name');
        $uom=UOM::pluck('name');
        $businessProfileId = $businessProfileId;
        return view('admin.vendor.order.show',compact('businessProfileId','orderItems','vendorOrder','shippingMethod','shipMentType','uom'));

    }

    public function showVendorOrderNotifactionFromFrontEnd($vendorId,$order_number,$notificationId){
        auth()->user()->unreadNotifications->where('id', $notificationId)->markAsRead();
        $order=VendorOrder::where('order_number',$order_number)->with(['billingAddress','shippingAddress','orderItems'])->first();
        return view('user.profile.order_details',compact('order'));

    }

    public function update($vendorId,$order_id,Request $request)
    {
          $request->validate([
              'order_number' => 'required',
          ]);

          try{
             VendorOrder::where('id',$order_id)->update([
                'order_number' => $request->order_number,
             ]);
             return redirect()->route('vendor.order.index',$vendorId)->withSuccess('Order Updated Successfully');
          }catch(Exception $e)
          {
            return redirect()->back()->withErrors($e->getMessage());
          }
    }

    public function destroy($vendorId,$order_id)
    {
        try{
            $order=VendorOrder::where('id',$order_id)->first();
            $order->orderItems()->delete();
            $order->delete();
            return redirect()->route('vendor.order.index',$vendorId)->withSuccess('Order Deleted Successfully');
        }catch(Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function OrderUpdateByAdmin($id)
    {
        try{
            $vendorOrder=VendorOrder::find($id);
            if($vendorOrder->state == 'approved'){
                return redirect()->back()->withSuccess('Order Already Approved');
            }
            $vendorOrder->update(['state' => 'approved','approved_by_admin'=> Auth::guard('admin')->user()->id]);
            $vendorOrder=VendorOrder::with('orderItems.product.images')->find($id);
            event(new NewOrderHasApprovedEvent($vendorOrder));
            return redirect()->back()->withSuccess('Order Status Updated Successfully');
        }catch(\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    //change status to delivered
    public function statusToDelivered($id)
    {
        try{
            $vendorOrder=VendorOrder::find($id);
            if($vendorOrder->state == 'delivered'){
                return redirect()->back()->withSuccess('Order Already Delivered');
            }
            $vendorOrder->update(['state' => 'delivered',]);
           // event(new NewOrderHasApprovedEvent($vendorOrder));
            return redirect()->back()->withSuccess('Order Status Updated Successfully');
        }catch(\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function OrderAskPayment($order_no)
    {
        $orderList=VendorOrder::where('order_number', $order_no)->first();
        if($orderList){

            Mail::to($orderList->user->email)->send(new AskForPaymentMail($orderList));
            // Mail::send('emails.ask_for_payment', ['orderList' => $orderList], function($message) use($orderList){
            //     $message->to($orderList->user->email);
            //     $message->subject('Order Payments');
            // });
            return redirect()->back()->withSuccess('Mail Send to User Successfully');
        }
        return redirect()->back()->withErrors('Somethings Went Worng');
    }



}
