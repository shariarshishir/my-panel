<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Userchat;

class MessageController extends Controller
{
    public function getchatdata(Request $request)
    {
        $user = $request->user;
        $to_id = $request->to_id;
        $from_user=User::find($user);
        // dd($from_user);
        $to_user=User::find($to_id);
        // dd($to_user);
        $from_user_image= isset($from_user->image) ? asset('storage').'/'.$from_user->image : asset('storage/images/supplier.png');
        $to_user_image= isset($to_user->image) ? asset('storage').'/'.$to_user->image : asset('storage/images/supplier.png');
        $chats = Userchat::where('participates', $user)->where('participates', $to_id);
        if($chats->exists()){
            $chat = $chats->first();
            $chatdataAllData = $chat->chatdata;
            $chatdata = $chatdataAllData;
            foreach ($chatdataAllData as $key => $value) {
                $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
                $chatdata[$key]['message'] = $messageStr;
            }
            return response()->json([
                'success' => false,
                'msg'     => 'Message sends successfully',
                'chatdata'    => $chatdata,
                'from_user_image'=>$from_user_image,
                'to_user_image'=>$to_user_image,
            ],200);
        }
        else{
            $chatdata = [];
            return response()->json([
                'success' => false,
                'msg'     => 'Message sends successfully',
                'chatdata'    => $chatdata,
                'from_user_image'=>$from_user_image,
                'to_user_image'=>$to_user_image,
            ],200);
        }
    }
    public function getSupplierChatData(Request $request)
    {
        //dd($request->all());
        return response()->json([
            'success' => false,
            'msg'     => 'Hi, Welcome To Merchantbay.',
            'rfq_id' => $request['rfq_id'],
            'business_profile_id' => $request['business_profile_id'],
        ],200);        
    }    
}
