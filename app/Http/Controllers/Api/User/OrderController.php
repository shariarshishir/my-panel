<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorOrder;
use App\Models\Country;
use App\Models\VendorOrderItem;
use App\Models\UserAddress;
use App\Models\CartItem;
use App\Models\BusinessProfile;
use App\Models\OrderModificationRequest;
use DB;
use Exception;
use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Events\NewOrderHasPlacedEvent;
use stdClass;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    //received order by a store

    public function orderByBusinessProfileId($businessProfileId){
        $orders=VendorOrder::where('business_profile_id',$businessProfileId)->whereNotIn('state', ['pending','cancel'])->get();
        $businessProfile=BusinessProfile::with('user')->where('id',$businessProfileId)->first();


        $orderArray=[];

        foreach($orders as $order){
            $newFormatedOrder=new stdClass;
            $newFormatedOrder->id=$order->id;
            $newFormatedOrder->order_number=$order->order_number;
            $newFormatedOrder->business_profile_id=$order->business_profile_id;
            $newFormatedOrder->order_by=$order->user->name;
            $newFormatedOrder->email=$order->user->email;
            $newFormatedOrder->grand_total=$order->grand_total;
            $newFormatedOrder->created_at=$order->created_at;
            $newFormatedOrder->state=$order->state;
            $notifications = $businessProfile->user->unreadNotifications->where('read_at',null)->where('type','App\Notifications\NewOrderHasApprovedNotification');
            foreach($notifications as $notification)
            {
                if($notification->data['notification_data'] == $order->id){
                    $newFormatedOrder->notification_id=$notification->id;
                }else{
                    $newFormatedOrder->notification_id=NULL;
                }
            }
            array_push($orderArray,$newFormatedOrder);
           
        }


        if(count($orders)>0){
            return response()->json(array('success' => true, 'orders' => $orderArray),200);
        }
        else{
            return response()->json(array('success' => true,'orders' => $orderArray, 'message' => 'No orders found'),200);
        }

    }

    //orders placed by auth user 
    public function orderByAuthenticatedUser(){
        $orders=VendorOrder::where('user_id',auth()->user()->id)->get();

        $orderArray=[];
        $orderApprovedNotificationIds = []; 
        foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\NewOrderHasApprovedNotification')->where('read_at',null) as $notification)
        {
            array_push($orderApprovedNotificationIds,$notification->data['notification_data']);
           
        }

        foreach($orders as $order){
            $newFormatedOrder=new stdClass;
            $newFormatedOrder->id=$order->id;
            $newFormatedOrder->order_number=$order->order_number;
            $newFormatedOrder->business_profile_id=$order->business_profile_id;
            $newFormatedOrder->order_by=$order->user->name;
            $newFormatedOrder->email=$order->user->email;
            $newFormatedOrder->grand_total=$order->grand_total;
            $newFormatedOrder->created_at=$order->created_at;
            $newFormatedOrder->state=$order->state;
            $newFormatedOrder->orderApprovedNotificationIds=$orderApprovedNotificationIds;
            array_push($orderArray,$newFormatedOrder);
        }

      

        if(count($orders)>0){
            return response()->json(array('success' => true, 'orders' => $orderArray),200);

        }
        else{
            return response()->json(array('success' => true,'orders' => $orderArray, 'message' => 'No orders found'),200);

        }

    }

    public function vendorOrderByOrderId($businessProfileId,$orderId){
        $order=VendorOrder::where('business_profile_id',$businessProfileId)->where('id',$orderId)->first();
        if(count($order)>0){
            return response()->json(array('success' => true, 'orders' => $order),200);
        }
        else{
            return response()->json(array('success' => true, 'message' => 'No order found'),200);

        }
    }


    public function orderCreate(Request $request)
    {
        $response = Http::withToken($request->sso_token)->get(env('SSO_URL').'/api/auth/token/verify');
       
        if(!$response->successful()){
            return response()->json([
                'success' => 'SSO session is over!',
                'code'=>false,
                'sso_verified'=>false
            ]);
        }
        

        DB::beginTransaction();

        if(isset($request->billing_address_id)){
            $billing_address_id=$request->billing_address_id;
        }
        else{
            $request->validate([
               'billing_name'=>'required',
               'billing_company_name'=>'required',
               'billing_email'=>'required|email',
               'billing_phone'=>'required',
               'billing_address'=>'required',
               'billing_zip'=>'required',
               'billing_city'=>'required',
               'b_country'=>'required',
            ]);
            $address_id=UserAddress::create([
                'user_id' =>auth()->id(),
                'address_type' => 1,
                'name'    => $request->billing_name,
                'company_name'    => $request->billing_company_name,
                'email'   => $request->billing_email,
                'phone'   => $request->billing_phone,
                'address' => $request->billing_address,
                'zip'     => $request->billing_zip,
                'city'    => $request->billing_city,
                'country' => $request->b_country,

            ]);
            $billing_address_id=$address_id->id;
        }
        if(isset($request->shipping_address_id)){
            $shipping_address_id=$request->shipping_address_id;
        }
        else{
            $request->validate([
                'shipping_name'=>'required',
                'shipping_company_name'=>'required',
                'shipping_email'=>'required|email',
                'shipping_phone'=>'required',
                'shipping_address'=>'required',
                'shipping_zip'=>'required',
                'shipping_city'=>'required',
                's_country'=>'required',
            ]);
            $address_id=UserAddress::create([
                'user_id' =>auth()->id(),
                'address_type' => 2,
                'name'    => $request->shipping_name,
                'company_name'   => $request->shipping_company_name,
                'email'   => $request->shipping_email,
                'phone'   => $request->shipping_phone,
                'address' => $request->shipping_address,
                'zip'     => $request->shipping_zip,
                'city'    => $request->shipping_city,
                'country' => $request->s_country,

            ]);
            $shipping_address_id=$address_id->id;
        }

        try {


            $businessProfileIds=[];
            foreach($request->cartItems as $item){
                array_push($businessProfileIds,$item['business_profile_id']);
            }
            $uniqueBusinessProfileIds=array_unique($businessProfileIds);




            foreach($uniqueBusinessProfileIds as $businessProfileId){
                $sum_price=0;
                foreach($request->cartItems  as $item){
                    if($item['business_profile_id'] == $businessProfileId)
                    {
                        $sum_price=$item['unit_price']*$item['quantity']+$sum_price;
                    }
                }


                $orderNumber = IdGenerator::generate(['table' => 'vendor_orders', 'field' => 'order_number','reset_on_prefix_change' =>true,'length' => 12, 'prefix' => date('ymd')]);
                $order=VendorOrder::create([
                        'user_id'         => auth()->user()->id,
                        'business_profile_id'       => $businessProfileId,
                        'order_number'    => $orderNumber,
                        'grand_total'     => $sum_price,
                        'shipping_id'     => $shipping_address_id,
                        'billing_id'      => $billing_address_id,
                        'payment_id'      => $request['payment_id']?? 1,
                        'payment_name'    => $request['payment_name']?? '10% with merchant assistance',
                        'state'           => 'pending',
                        'payment_status'  => 'unpaid',
                        'ip_address'      => $request->ip(),
                        'user_agent'      => $request->header('User-Agent'),
                    ]);


                foreach($request->cartItems  as $item){
                    if($item['business_profile_id'] == $businessProfileId)
                    {
                        $orderItem=VendorOrderItem::create([
                            'order_id'      => $order->id,
                            'product_sku'   => $item['sku'],
                            'quantity'      => $item['quantity'],
                            'unit_price'    => $item['unit_price'],
                            'copyright_price' => $item['copyright_price'] ?? null,
                            'price'         => $item['quantity']*$item['unit_price'],
                            'colors_sizes'  => json_encode($item['color_attr']),
                            'order_modification_req_id' => $item['order_modification_req_id'] ?? null,
                        ]);
                    }
                   
                    if(isset($item['order_modification_req_id'])){
                        
                        OrderModificationRequest::where('id',$item['order_modification_req_id'])->update(['state' => 3]);
                    }
                }

            }

               
            CartItem::where('user_id',auth()->user()->id)->delete();

            event(new NewOrderHasPlacedEvent($order));
             
            DB::commit();
            return response()->json(["message"=>"Order created successfully","order"=>$order,"code"=>true],200);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(["message"=>$e->getMessage(),"order"=>$order,"code"=>false],200);
        }


    }


    public function countries(){
        $countries=Country::all();
         return response()->json(array('success' => true, 'countries' =>$countries),200);

    }


    public function orderDetails($id){
        $order=VendorOrder::with('orderItems','shippingCharge')->where('id',$id)->first();
        $orderItemArray=[];
        foreach($order->orderItems as $item){
            $newFormatedItem=new stdClass;
            $newFormatedItem->id=$item->id;
            $newFormatedItem->product_sku=$item->product_sku;
            $newFormatedItem->product_type=$item->product->product_type;
            $newFormatedItem->product_name=$item->product->name;
            $newFormatedItem->quantity=$item->quantity;
            $newFormatedItem->unit_price=$item->unit_price;
            $newFormatedItem->colors_sizes=json_decode($item->colors_sizes);
            $newFormatedItem->copyright_price=$item->copyright_price;
            array_push($orderItemArray,$newFormatedItem);
        }
        if(isset($order->shippingCharge) &&  $order->shippingCharge->status==2 ){
            $newFormatedShippingCharge=new stdClass;
            $newFormatedShippingCharge->id=$order->shippingCharge->id;
            $newFormatedShippingCharge->order_id=$order->shippingCharge->order_id;
            $newFormatedShippingCharge->forwarder_name=$order->shippingCharge->forwarder_name;
            $newFormatedShippingCharge->forwarder_address=$order->shippingCharge->forwarder_address;
            $newFormatedShippingCharge->details=json_decode($order->shippingCharge->details);
            $newFormatedShippingCharge->grand_total=$order->shippingCharge->grand_total;
            $newFormatedShippingCharge->file=$order->shippingCharge->file;
        }
        else{
            $newFormatedShippingCharge=new stdClass;
        }
      
        if($order){
            return response()->json(array('code' => true, 'order' =>$order,'orderItems'=>$orderItemArray,'billingAddress'=>$order->billingAddress,'shippingAddress'=>$order->shippingAddress,'shippingCharge'=>$newFormatedShippingCharge),200);
        }
        else{
            return response()->json(array('code' => false, 'order' =>$order),200);
        }

    }

    public function  orderApprovedNotificationMarkAsRead(Request $request){

        foreach(auth()->user()->unreadNotifications->where('type','App\Notifications\NewOrderHasApprovedNotification')->where('read_at',null) as $notification){
            if( $notification->data['notification_data'] == $request->order_id)
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
