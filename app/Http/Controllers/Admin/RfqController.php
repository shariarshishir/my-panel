<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Rfq;
use App\Models\BusinessProfile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewRfqHasAddedEvent;
use App\Http\Controllers\Controller;
use App\Userchat;
use App\Models\Manufacture\ProductCategory;
use Illuminate\Support\Facades\Http;

class RfqController extends Controller
{
    public function index(Request $request){
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/filter/null/page/1/limit/10');
        $data = $response->json();
        $rfqs = $data['data'];
        $rfqsCount = $data['count'];
        return view('admin.rfq.index',compact('rfqs','rfqsCount'));
    }

    public function show($id){
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$id);
        $data = $response->json();
        $rfq = $data['data']['data'];
        //$businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$rfq['category_id'][0])->where('profile_verified_by_admin', '!=', 0)->get()->toArray();
        $businessProfiles = BusinessProfile::with('user')->where('business_category_id',$rfq['category_id'][0])->where('profile_verified_by_admin', '!=', 0)->get()->toArray();
        $productCategories = ProductCategory::all('id','name');
        if( env('APP_ENV') == 'production') {
            $user = "5771";
        } 
        else{
            $user = "5552";
        }
        $from_user = User::find($user);
        $to_user = User::where('email',$rfq['user']['email'])->first();
        $from_user_image= isset($from_user->image) ? asset('storage').'/'.$from_user->image : asset('storage/images/supplier.png');
        $to_user_image= isset($to_user->image) ? asset('storage').'/'.$to_user->image : asset('storage/images/supplier.png');
        $chats = Userchat::where('rfq_id',$id)->get();
        // if($chats->exists()){
        //     $chat = $chats->first();
        //     $chatdataAllData = $chat->chatdata;
        //     $chatdata = $chatdataAllData;
        //     foreach ($chatdataAllData as $key => $value) {
        //         $messageStr = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $value['message']);
        //         $chatdata[$key]['message'] = $messageStr;
        //     }
        // }
        // else{
        //     $chatdata = [];
        // }
        $chatdata = $chats;
        return view('admin.rfq.show', compact('rfq','businessProfiles','chatdata','from_user_image','to_user_image','user','productCategories'));
    }

    public function status($id){
        $rfq=Rfq::findOrFail($id);
        if($rfq->status == 'pending'){
            $rfq->update(['status' => 'approved']);
            if(env('APP_ENV') == 'production')
            {
                $selectedUsersToSendMail = User::where('id','<>', $rfq->created_by)->take(10)->get();
                foreach($selectedUsersToSendMail as $selectedUserToSendMail) {
                    event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
                }
            }
            return redirect()->back()->withSuccess('Rfq published successfully');
        }
        if($rfq->status == 'approved'){
            $rfq->update(['status' => 'pending']);
            return redirect()->back()->withSuccess('Rfq unpublished successfully');
        }
    }
    public function businessProfileFilter(Request $request){
        if($request->category_id && $request->profile_rating !=0)
        {
            //$businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$request->category_id)->where('profile_rating',$request->profile_rating)->where('profile_verified_by_admin', '!=', 0)->get();
            $businessProfiles = BusinessProfile::with('user')->where('business_category_id',$request->category_id)->where('profile_rating','<=',$request->profile_rating)->where('profile_verified_by_admin', '!=', 0)->orderBy('profile_rating', 'DESC')->get();
        }
        elseif($request->category_id && $request->profile_rating ==0)
        {
            //$businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$request->category_id)->where('profile_verified_by_admin', '!=', 0)->get();
            $businessProfiles = BusinessProfile::with('user')->where('business_category_id',$request->category_id)->where('profile_verified_by_admin', '!=', 0)->get();
        }
        return response()->json(['businessProfiles'=>$businessProfiles],200);
    }
}
