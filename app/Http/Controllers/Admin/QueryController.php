<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderQueryFromAdminEvent;
use App\Http\Controllers\Controller;
use App\Models\OrderModificationRequest;
use App\Models\OrderModification;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderModificationComment;
use Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QueryWithModificationToUserNotification;
use App\Mail\QueryWithModificationTouserMail;
use App\Notifications\QueryCommuncationNotification;
use App\Mail\QueryCommuncationMail;
use App\Http\Traits\PushNotificationTrait;

class QueryController extends Controller
{
   use PushNotificationTrait;
   public function index($type)
   {
       $query_request_list=OrderModificationRequest::latest()->where('type',$type)->with(['user','businessProfile','product'])->get();
       return view('admin.query.index',['collection' => $query_request_list]);
   }

   public function edit($id)
   {   
       $query_request=OrderModificationRequest::where('id',$id)->with(['user','businessProfile','product','orderModification'])->first();
       return view('admin.query.edit',['collection' => $query_request]);
   }

   public function show($id)
   {
       $notifications = auth()->guard('admin')->user()->unreadNotifications->where('type', 'App\Notifications\OrderQueryNotification')->where('read_at',null);
       foreach($notifications as $notification){
           if($notification->data['notification_data']['id']==$id)
           {
               $notification->markAsRead();
           }
       }
       $query_request=OrderModificationRequest::where('id',$id)->with(['user','businessProfile','product','orderModification'])->first();
       return view('admin.query.show',['collection' => $query_request]);
   }


   public function store(Request $request)
   {

       $request->validate([
        'unit_price' => 'required',
        'color_size.*'       => 'required',
        'total_quantity' => 'required',
        'total_price'    => 'required',

       ],
       [
        'unit_price.required' => 'Unit Price are required',
        'color_size.*.required'       => 'Color Size are required',
        'total_quantity.required' => 'Quantity are required',
        'total_price.required'    => 'Total Price are required',
       ]);

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
        $orderModification=OrderModification::where('order_modification_request_id', $request->ord_mod_req_id)->first();
        $OrderModificationRequest=OrderModificationRequest::find($request->ord_mod_req_id);
        $OrderModificationRequest->update(['state' => config('constants.order_query_status.processed')]);
        if($request->hasFile('file'))
        {
            $filename = $request->file->store('images/'.$OrderModificationRequest->businessProfile->business_name.'/products/modification_request','public');
            $image_resize = Image::make(public_path('storage/'.$filename));
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('storage/'.$filename));

        }
        if($orderModification){
            $orderModification->Update([
                'colors_sizes'   => json_encode($colors_sizes),
                'quantity'     => $request->total_quantity,
                'unit_price'     => $request->unit_price,
                'discount_type'  => $request->discount_type ?? null,
                'discount'      => $request->discount?? null,
                'discount_amount' => $request->discount_amount ?? null,
                'total_price'     => $request->total_price,
                'image'           => isset($filename) ? $filename : $orderModification->image,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
             ]);

            // event(new OrderQueryFromAdminEvent($orderModification));
        }
        else{

            $data=[
                'order_modification_request_id'   => $request->ord_mod_req_id,
                'product_sku'=> $request->product_sku,
                'name' => $request->product_name,
                'colors_sizes'   => json_encode($colors_sizes),
                'quantity'     => $request->total_quantity,
                'unit_price'     => $request->unit_price,
                'discount_type'  => $request->discount_type ?? null,
                'discount'      => $request->discount?? null,
                'discount_amount' => $request->discount_amount ?? null,
                'total_price'     => $request->total_price,
                'image'           => isset($filename) ? $filename : null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ];

            $orderModification=OrderModification::Create($data);

        }

        if ($OrderModificationRequest->type ==1){
            
                //send mail and database notification using this event to buyer
                event(new OrderQueryFromAdminEvent($orderModification));
                return redirect()->route('query.request.index',1)->with('success', 'Created Successfully');
        }else{
            
                //send push notification
                $fcmToken=$orderModification->orderModificationRequest->user->fcm_token;
                $title = "Order modification request processed";
                $message = "Your order modification request has been processed.Please check your order modification request list.";
                $action_url = route('ord.mod.req.index');
                $this->pushNotificationSend($fcmToken, $title,$message,$action_url);

                Notification::send($OrderModificationRequest->user,new QueryWithModificationToUserNotification($OrderModificationRequest->id));
                Mail::to($OrderModificationRequest->user->email)->send(new QueryWithModificationTouserMail($OrderModificationRequest));
                return redirect()->route('query.request.index',2)->with('success', 'Created Successfully');
        }


   }

   public function comment(Request $request)
   {
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
            'order_modification_request_id' => $request->mod_req_id,
            'details'                       => json_encode($details),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        //send push notification to user for comment
        $fcmToken = $data->orderModificationRequest->user->fcm_token;
        $title = "New message for your order modification request";
        $details = json_decode($data->details);
        $message = $details[0]->details;
        $action_url = $data->orderModificationRequest->type == 2 ? route('ord.mod.req.index') : route('user.order.query.index') ;
        $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

        Notification::send($data->orderModificationRequest->user,new QueryCommuncationNotification($data ,'admin'));
        Mail::to($data->orderModificationRequest->user->email)->send(new QueryCommuncationMail($data, 'admin'));
        return redirect()->back()->with('success','Created Successfully');
   }

   public function editModificationRequest($id)
   {
       $query_request=OrderModificationRequest::where('id',$id)->with(['user','businessProfile','product','orderModification'])->first();
       return view('admin.query.edit_order_modification_query',['collection' => $query_request]);
   }

}
