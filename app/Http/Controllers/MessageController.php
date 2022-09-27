<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageCenter;
use App\Events\ProductOrder;
use App\Http\Resources\MerchantMessageResource;
use App\Http\Resources\MerchantMessagesResource;
use App\Http\Resources\SupplierMessageResource;
use App\Http\Resources\UserSessionResource;
use App\MerchantAssistanceMessage;
use App\MerchantSupplierMessage;
use App\Message;
use App\Notifications\BuyerWantToContact;
use App\Notifications\BuyerWantToContactFromProduct;
use App\Notifications\RfqBidNotification;
use App\Models\User;
use App\UserSession;
use App\Userchat;
use App\RfqApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\RfqMerchantAssistanceMessage;
use App\Http\Resources\RfqMerchantMessagesResource;
use App\Http\Resources\RfqMerchantMessageResource;
use Illuminate\Support\Facades\Http;


class MessageController extends Controller
{
    public function single_message(){
        return view('message.single');
    }

    public function send(Request $request){
        $user=Auth::user();
        event(new ProductOrder($user,$request->message));
    }

    public function message_center(){
        $user = Auth::user();
        $chatdataRfqIds = Userchat::where('to_id',$user->sso_reference_id)->orWhere('from_id',$user->sso_reference_id)->pluck('rfq_id')->toArray();
        $uniqueRfqIdsWithChatdata = array_unique($chatdataRfqIds);
        $rfqs = RfqApp::whereIn('id',$uniqueRfqIdsWithChatdata)->latest()->get();
        if(count($rfqs)>0){
            //$chatdata = Userchat::where('rfq_id',$rfqs[0]['id'])->orWhere('to_id',$user->sso_reference_id)->orWhere('from_id',$user->sso_reference_id)->get();
            $response = Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfqs[0]['id'].'/user/'.$user->sso_reference_id);
            $data = $response->json();
            $chats = $data['data']['messages'];

            //$chatdata = $chats;
            $chatdataAllData = $chats;
            $chatdata = $chatdataAllData;
            foreach ($chatdataAllData as $key => $value) {
                $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
                $chatdata[$key]['message'] = $messageStr;
                //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
            }

            if($rfqs[0]['user']['user_picture'] !=""){
                $userImage = $rfqs[0]['user']['user_picture'];
                $userNameShortForm = "";
            }else{
                $userImage = $rfqs[0]['user']['user_picture'];
                $nameWordArray = explode(" ", $rfqs[0]['user']['user_name']);
                $firstWordFirstLetter = $nameWordArray[0][0];
                $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
                $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
            }
        }else{
            $chatdata = [];
            $userImage ="";
            $nameWordArray = explode(" ", $user->name);
            $firstWordFirstLetter = $nameWordArray[0][0];
            $secorndWordFirstLetter = $nameWordArray[1][0] ??'';
            $userNameShortForm = $firstWordFirstLetter.$secorndWordFirstLetter;
        }
        if(env('APP_ENV') == 'local'){
            $adminUser = User::Find('5552');
        }else{
            $adminUser = User::Find('5771');
        }
        $adminUserImage = isset($adminUser->image) ? asset($adminUser->image) : asset('images/frontendimages/no-image.png');
        return view('message.message_center', compact('rfqs','user','chatdata','adminUser','adminUserImage','userImage','userNameShortForm'));
    }

    public function getchatdata(Request $request)
    {
        $rfq_id = $request->rfq_id;
        $user = auth()->user();
        $from_user_image =  asset('storage/images/supplier.png');
        $to_user_image =  asset('storage/images/supplier.png');
        $response =   Http::get(env('RFQ_APP_URL').'/api/messages/'.$rfq_id.'/user/'.$user->sso_reference_id);
        $data = $response->json();
        $chats = $data['data']['messages'];

        //$chatdata = $chats;
        $chatdataAllData = $chats;
        $chatdata = $chatdataAllData;
        foreach ($chatdataAllData as $key => $value) {
            $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
            $chatdata[$key]['message'] = $messageStr;
            //echo "<pre>"; print_r($chatdataAllData[$key]); exit();
        }

        return response()->json([
            'from_user_image' => $from_user_image,
            'to_user_image' => $to_user_image ,
            'chatdata' => $chatdata
        ],200);
    }

    public function message_center_selected($id)
    {
        $allusers = User::with('profile','badges','tour_photos')->where(['group_id' => Auth::id(), 'is_active' => 1])->get();
        $user=User::with('profile','badges','tour_photos')->where('id', $id)->first();
        $chats = Userchat::whereIn('participates', ["$user->id"]);
        $chatusers = [];
        if($chats->exists())
        {
            $chatdatas = $chats->get();
            $users = [];
            foreach($chatdatas as $chat)
            {
                foreach($chat->participates as $participate)
                {
                    if($participate != $user->id)
                    {
                        $users[] = $participate;
                    }
                }
            }
            $userData = User::with('profile','badges','tour_photos')->whereIn('id',$users)->get();
            $chatusers = $userData;
        }
        $buyers = [];
        $allbuyers = User::with('profile','badges','tour_photos')->where('user_type','buyer');
        if($allbuyers->exists())
        {
            foreach($allbuyers->get() as $buyer)
            {
                $data = [];
                $data['id'] = $buyer->id;
                $data['name'] = $buyer->name;
                $data['image'] = asset(!empty($buyer->profile['profile_image'])? 'storage/' .$buyer->profile['profile_image'] : "images/supplier.png");
                $buyers[] = $data;
            }
        }
        //echo '<pre>';print_r($buyers);exit;
        return view('message.message_center', compact('user','chatusers','buyers','allusers'));
    }

    public function message_center_selected_supplier($id)
    {
        return $id;
        $user=Auth::user();
        $allusers=[];
        $allusers = User::get();
        $user=User::where('id', $id)->first();

        // if($user->is_group == 1)
        // {
        //     $allusers = User::with('profile','badges','tour_photos')->where(['group_id' => Auth::id(), 'is_active' => 1])->get();
        //     $user=User::with('profile','badges','tour_photos')->where('id', $id)->first();
        // }
        $chatdatas = Userchat::all();
        $chatusers = [];
        $users = [];
        foreach($chatdatas as $chat)
        {
            if(in_array($user->id, $chat->participates))
            {
                foreach($chat->participates as $participate)
                {
                    if($participate != $user->id)
                    {
                        $users[] = $participate;
                    }
                }
            }
        }
        $userData = User::whereIn('id',$users)->get();
        $chatusers = $userData;
        $buyers = [];
        $allbuyers = User::where('user_type','buyer');
        if($allbuyers->exists())
        {
            foreach($allbuyers->get() as $buyer)
            {
                $data = [];
                $data['id'] = $buyer->id;
                $data['name'] = $buyer->name;
                $data['image'] = asset(!empty($buyer->profile['profile_image'])? 'storage/' .$buyer->profile['profile_image'] : "images/supplier.png");
                $buyers[] = $data;
            }
        }
        return view('message.message_center', compact('user','chatusers','buyers','allusers'));
    }



    public function updateuserlastactivity(Request $response)
    {
        User::where('id', $response->form_id)->update(['last_activity' => date("Y-m-d H:i:s")]);
        User::where('id', $response->to_id)->update(['last_activity' => date("Y-m-d H:i:s")]);
        return response()->json([
            'success' => $response
        ]);
    }

    public function notificationforuser(Request $response)
    {
        //$notification_form = $response->message_notification_form_id;
        $user=Auth::user();

        if ($user && in_array(\auth()->user()->user_type, ['buyer', 'both']))
        {
            $nofifySupplier = User::find($response->message_notification_to_id);
            $notification_data=[
                'title'=>'Buyer sent you a message',
                'url'=>'/message-center?uid='.$response->message_notification_form_id
            ];
            Notification::send($nofifySupplier, new BuyerWantToContact($notification_data));

            return response()->json([
                'success' => $response
            ]);

        }

        if ($user && in_array(\auth()->user()->user_type, ['supplier', 'both'])) {

            $nofifyBuyer = User::find($response->message_notification_to_id);
            $notification_data=[
                'title'=>'Supplier sent you a message',
                'url'=>'/message-center?uid='.$response->message_notification_form_id
            ];
            Notification::send($nofifyBuyer, new BuyerWantToContact($notification_data));

            return response()->json([
                'success' => $response
            ]);

        }

        $notification_data=[
            'title'=>'',
            'url'=>'/message-center'
        ];
        Notification::send($user, new BuyerWantToContact($notification_data));
    }

    public function contactwithsupplier($id)
    {
        $user = User::where('user_type', 'supplier')
            ->orWhere('user_type', 'both')
            ->where('id', $id)
            ->first();

        if ($user && in_array(\auth()->user()->user_type, ['buyer', 'both']))
        {
            $user_session = UserSession::create([
                'user1_id'=>Auth::id(),
                'user2_id'=>$user->id,
            ]);

            $message = Message::create([
                'session_id'=>$user_session->id,
                'content'=>'Hello '.$user->name
            ]);

            Chat::insert([['message_id'=>$message->id, 'user_id'=>Auth::id(),'type'=>0 ],
            ['message_id'=>$message->id, 'user_id'=>$user->id,'type'=>1 ]]);

            $notification_data=[
                'title'=>'Buyer want to contact with you',
                'url'=>'/message-center'
            ];
            Notification::send($user, new BuyerWantToContact($notification_data));

            return redirect()
                ->action('MessageController@message_center');

        }else{
            abort(404);
        }
    }

    public function contactWithSupplierFromProfile(Request $request)
    {
        /*
        $user = User::where('user_type', 'supplier')
            ->orWhere('user_type', 'both')
            ->where('id', $request->supplier_id)
            ->first();
        */

        $user = User::find($request->supplier_id);

        if ($user && in_array(\auth()->user()->user_type, ['buyer', 'both']))
        {

            $notification_data=[
                'title'=>'Buyer want to contact with you',
                'url'=>'/message-center?uid='.$request->buyer_id
            ];
            Notification::send($user, new BuyerWantToContact($notification_data));

            return response()->json([
                'success' => $request
            ]);

        } else {
            abort(404);
        }
    }

    public function contactSupplierFromProduct(Request $request)
    {
        /*
        $user = User::where('user_type', 'supplier')
            ->orWhere('user_type', 'both')
            ->where('id', $request->supplier_id)
            ->first();
        */
        //return 'notify';
        $user = User::find($request->supplier_id);

        if ($user && in_array(\auth()->user()->user_type, ['buyer', 'both']))
        {

            $notification_data=[
                'title'=>'Hello, I want to discuss more about your products',
                'url'=>'/message-center?uid='.$request->buyer_id
            ];
            //Notification::send($user, new BuyerWantToContactFromProduct($notification_data));
            Notification::send($user, new BuyerWantToContact($notification_data));

            return response()->json([
                'success' => $request
            ]);

        } else {
            abort(404);
        }
    }

    public function getUsers(){
        $from_users=UserSessionResource::collection(UserSession::select('id', 'user2_id as user_id', 'rfq_id')->where('user1_id',Auth::id())
        ->groupBy('rfq_id')
        ->orderBy('id', 'desc')->get());
        $to_users=UserSessionResource::collection(UserSession::select('id', 'user1_id as user_id', 'rfq_id')->where('user2_id',Auth::id())
        ->groupBy('rfq_id')
        ->orderBy('id', 'desc')->get());
        return $from_users->merge($to_users);
    }

    public function sendMessage(Request $request){
        if (!is_null($request->session_id)){
            $message=Message::create(['session_id'=>$request->session_id, 'content'=>$request->message]);
            Chat::insert([['message_id'=>$message->id, 'user_id'=>Auth::id(),'type'=>0 ],['message_id'=>$message->id, 'user_id'=>$request->user_id,'type'=>1 ]]);
            broadcast(new MessageCenter($request->session_id, $request->message))->toOthers();;
        }
    }

    public function sendBidReplay($supplier_id, $rfq_id)
    {
        $pre_session = UserSession::where('user1_id', Auth::id())
            ->where('user2_id', $supplier_id)
            ->where('rfq_id', $rfq_id)
            ->first();

        if ($pre_session){
            $session_id = $pre_session->id;
        }else{
            $user_session = UserSession::create([
                'user1_id'  => Auth::id(),
                'user2_id'  => $supplier_id,
                'rfq_id'    => $rfq_id,
            ]);
            $session_id = $user_session->id;
        }

        $message = Message::create([
            'session_id'=>$session_id,
            'content'=>'Bid reply from '.\auth()->user()->name
        ]);

        Chat::insert([['message_id'=>$message->id, 'user_id'=>Auth::id(),'type'=>0 ]
            ,['message_id'=>$message->id, 'user_id'=>$supplier_id,'type'=>1 ]]);

            $user = User::find($supplier_id);
            $notification_data=[
                'title'=>'New Bid reply',
                'url'=>'/message-center?uid='.$supplier_id
            ];
        Notification::send($user, new RfqBidNotification($notification_data));


        return redirect()
            ->route('sentBidReply', $supplier_id);
    }


    public function merchant_message(){
        return view('message.merchant_message');
    }

    public function rfq_merchant_message()
    {
        return view('message.rfq_merchant_message');
    }

    public function getMerchants(){
        $merchants = MerchantMessageResource::collection(MerchantAssistanceMessage::where('to',Auth::id())->groupBy('request_id')->get());

        return $merchants;
    }

    public function getRFQMerchants(){
        $rfqMerchants = RfqMerchantMessageResource::collection(RfqMerchantAssistanceMessage::where('to',Auth::id())->groupBy('request_id')->get());

        return $rfqMerchants;
    }

    public function getMessages(Request $request){
        //$messages=MerchantMessagesResource::collection(MerchantAssistanceMessage::whereIn('from',[$request->user_id, Auth::id()])->whereIn('to',[$request->user_id, Auth::id()])->orderBy('id', 'asc')->get());

        $messages=MerchantMessagesResource::collection(MerchantAssistanceMessage::where('request_id', $request->user_id)->with('user')->orderBy('id', 'asc')->get());


        return $messages;
    }

    public function supplier_message()
    {
        //session('order_info');
        //dd(session('order_info'));

        return view('message.supplier_message');
    }

    public function getSupplier()
    {
        if (Auth::user()->user_type == 'buyer'){

            $suppliers = SupplierMessageResource::collection(
                MerchantSupplierMessage::select('*', 'from as sender')
                ->where('from',Auth::id())
                ->groupBy('product_id')
                    ->orderBy('id', 'desc')
                ->get());

        }elseif (Auth::user()->user_type == 'supplier'){

            $suppliers = SupplierMessageResource::collection(
                MerchantSupplierMessage::select('from as to', 'to as from', 'product_id', 'from as sender')
                    ->Where('to', Auth::id())
                    ->groupBy('product_id')
                    ->orderBy('id', 'desc')
                    ->get());

        }
        return $suppliers;
    }
}
