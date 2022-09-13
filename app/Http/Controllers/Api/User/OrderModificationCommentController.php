<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Admin;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderModificationComment;
use App\Http\Traits\PushNotificationTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QueryCommuncationNotification;
use App\Mail\QueryCommuncationMail;

class OrderModificationCommentController extends Controller
{
    use PushNotificationTrait;
    public function store( Request $request)
    {
       try{
            $details=[];
            $product = Product::where('id', $request->product_id)->first();
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

                    $data=OrderModificationComment::create([
                        'order_modification_request_id' => $request->order_modification_request_id,
                        'user_id'                       => auth()->id(),
                        'parent_id'                     => isset($request->parent_id) ? $request->parent_id : null,
                        'details'                       => json_encode($details),
                        'ip_address'                    => $request->ip(),
                        'user_agent'                    => $request->header('User-Agent'),
                    ]);


            $admin= Admin::find(1);

            //send push notification to admin for new order modification request reply
            $fcmToken = $admin->fcm_token;
            $title = "New reply message for order modification request from".$data->user->name;
            $details = json_decode($data->details);
            $message = $details[0]->details;
            $action_url = route('query.show', $data->orderModificationRequest->id);
            $this->pushNotificationSend($fcmToken,$title,$message,$action_url);

            Notification::send($admin,new QueryCommuncationNotification($data ,'user'));
            Mail::to('success@merchantbay.com')->send(new QueryCommuncationMail($data, 'user'));

            return response()->json([
                'message' => 'Comment Created Successfully!',
                'code' => true,
            ],200);
       }catch(\Exception $e){
            return response()->json(array(
                'code' => false,
                'error' => $e->getMessage(),),
                500);
            }
    }
}
