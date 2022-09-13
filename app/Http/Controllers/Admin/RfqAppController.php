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

class RfqController extends Controller
{
    public function index(Request $request){
        
        if ($request->ajax()) {
            $data = Rfq::with('category','user')->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('title', function($row) {
                       return ucwords($row->title);
                    })
                    ->editColumn('category_id', function($row){
                        return $row->category->name;
                    })
                    ->editColumn('delivery_time', function ($row) {
                        return \Carbon\Carbon::parse($row->delivery_time)->isoFormat('MMMM Do YYYY');
                    })
                    ->editColumn('created_by', function($row){
                        return $row->user->name;
                    })
                    ->editColumn('status', function($row){
                        $ucfirst=ucfirst($row->status);
                        if($row->status== 'pending'){
                            $status= '<span class="text-danger">'.$ucfirst.'</span>';
                        }else{
                            $status= '<span class="text-primary">'.$ucfirst.'</span>';
                        }
                       return $status;
                    })
                    ->editColumn('created_at', function ($row) {
                        return \Carbon\Carbon::parse($row->created_at)->isoFormat('MMMM Do YYYY');
                    })
                    ->addColumn('details', function($row){
                        $route= route('admin.rfq.show', $row->id);
                        $action='<a href="'.$route.'">Details</a>';
                        return $action;
                    })
                    ->rawColumns(['details','status'])
                    ->make(true);
        }
        return view('admin.rfq.index');
    }

    public function show($id){
        $rfq=Rfq::with('user','bids')->findOrFail($id);
        $businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$rfq->category_id)->where('profile_verified_by_admin', '!=', 0)->get()->toArray();
        $productCategories = ProductCategory::all('id','name');
        if( env('APP_ENV') == 'production') {
            $user = "5771";
        } 
        else{
            $user = "5552";
        }
        $to_id = (string)$rfq->user->id;
        $from_user = User::find($user);
        $to_user = User::find($to_id);
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
        }
        else{
            $chatdata = [];
        }
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
        if($request->category_id && $request->profile_rating !=0){
            $businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$request->category_id)->where('profile_rating',$request->profile_rating)->where('profile_verified_by_admin', '!=', 0)->get();
        }elseif($request->category_id && $request->profile_rating ==0){
            $businessProfiles = BusinessProfile::select('id','business_name','alias','business_type')->where('business_category_id',$request->category_id)->where('profile_verified_by_admin', '!=', 0)->get();
        }
        return response()->json(['businessProfiles'=>$businessProfiles],200);
    }
}
