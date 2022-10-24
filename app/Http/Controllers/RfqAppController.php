<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\RfqApp;
use App\Models\User;
use App\Models\RfqImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use App\Events\NewRfqHasAddedEvent;
use App\Jobs\NewRfqHasAddedJob;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
Use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class RfqAppController extends Controller
{
    public function index()
    {
        $rfqList = RfqApp::get();
        dd($rfqList);

        foreach($rfqList as $list){
            $bid_user_id=[];
            if($list->bids()->exists()){
                foreach($list->bids as $user){
                    array_push($bid_user_id,$user->supplier_id);
                }
                $list['bid_user_id'] = array_unique($bid_user_id);

            }

        }

        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 6;
        $rfqLists = new \Illuminate\Pagination\LengthAwarePaginator(
            $rfqList->forPage($page, $perPage),
            $rfqList->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()],
        );
        $rfqIds=[];
        foreach(auth()->user()->unreadNotifications->where('read_at',null) as $notification){
            if($notification->type=="App\Notifications\NewRfqNotification"){
                array_push($rfqIds,$notification->data['rfq_data']['id']);
            }
        }

        return view('rfq.index',compact('rfqLists','rfqIds'));
    }



    public function store(Request $request)
    {
            foreach ($request->file('product_images') as $index=>$product_image){
                if($index == 0){
                    $image = $product_image;
                }
            }
            //dd(file_get_contents($image));
            // $response = Http::attach('attachment', file_get_contents($image), 'image.*')
            //     ->post('http://192.168.68.148:8888/api/quotation', $request->all());

        
       
        // Http::post('http://192.168.68.148:8888/api/quotation', [
        //     $request->all()
        // ]);
        // $result = Http::attach(
        //     'product_images', file_get_contents($request->product_images[0]),'photo.jpg'
        // )->post('http://192.168.68.148:8888/api/quotation', );
        $request->validate([
            'category_id' => 'required',
            'title'       => 'required',
            'quantity'    => 'required',
            'unit'        =>  'required',
            'unit_price'     => 'required',
            'payment_method' => 'required',
            'delivery_time'  => 'required',
            'destination'   => 'required',
            'short_description' => 'required',
            'full_specification' => 'required',

        ]);

        $rfqData = $request->except(['_token','captcha_token','product_images']);
        $rfqData['created_by']=auth()->id();
        $rfqData['status']='pending';
        $rfqData['rfq_from'] = "service";
        $rfqData['link'] = $this->generateUniqueLink();

        $rfq=Rfq::create($rfqData);

        if ($request->hasFile('product_images')){
            foreach ($request->file('product_images') as $index=>$product_image){

                $extension = $product_image->getClientOriginalExtension();
                if($extension=='pdf' ||$extension=='PDF' ||$extension=='doc'||$extension=='docx'|| $extension=='xlsx' || $extension=='ZIP'||$extension=='zip'|| $extension=='TAR' ||$extension=='tar'||$extension=='rar' ||$extension=='RAR'  ){

                    $path=$product_image->store('images','public');
                }
                else{
                    $path=$product_image->store('images','public');
                    $image = Image::make(Storage::get($path))->fit(555, 555)->encode();
                    Storage::put($path, $image);
                }
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$path]);
            }
        }
        $rfq = Rfq::with('images','category')->where('id',$rfq->id)->first();
        //SEND CREATED RFQ DATA TO RFQ APP
        // $response = Http::post(env('RFQ_APP_URL').'/api/quotation',[ 
        //     $rfq
        // ]);

        // if(env('APP_ENV') == 'production')
        // {
            /* code using redis-cli

            $selectedUsersToSendMail = User::where('id','<>',auth()->id())->get();
            foreach($selectedUsersToSendMail as $selectedUserToSendMail) {
                NewRfqHasAddedJob::dispatch($selectedUserToSendMail, $rfq);
            }

            $selectedUserToSendMail="success@merchantbay.com";
            NewRfqHasAddedJob::dispatch($selectedUserToSendMail, $rfq);

            */
            // $selectedUsersToSendMail = User::where('id','<>',auth()->id())->take(10)->get();
            // foreach($selectedUsersToSendMail as $selectedUserToSendMail) {
            //     event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
            // }

            $selectedUserToSendMail="success@merchantbay.com";
            event(new NewRfqHasAddedEvent($selectedUserToSendMail,$rfq));
        // }


        $msg = "Your RFQ was posted successfully.<br><br>Soon you will receive quotation from <br>Merchant Bay verified relevant suppliers.";
        return back()->with(['rfq-success'=> $msg]);

    }

    public function myRfq(Request $request)
    {
        if(isset($request->filter)){
            if($request->filter== 'all'){
                $rfqLists=Rfq::where('created_by', auth()->id())->withCount('bids')->with('images','user')->withTrashed()->latest()->paginate(6);
            }
            if($request->filter== 'active'){
                $rfqLists=Rfq::where('created_by', auth()->id())->withCount('bids')->with('images','user')->latest()->paginate(6);
            }
            if($request->filter== 'inactive'){
                $rfqLists=Rfq::where('created_by', auth()->id())->withCount('bids')->with('images','user')->onlyTrashed()->latest()->paginate(6);
            }
        }else{
            $rfqLists=Rfq::where('created_by', auth()->id())->withCount('bids')->with('images','user')->latest()->paginate(6);
        }

        $newRfqBidIds=[];
        foreach(auth()->user()->unreadNotifications->where('read_at',null) as $notification){

            if($notification->type == "App\Notifications\RfqBidNotification"){
                array_push($newRfqBidIds,$notification->data['notification_data']['id']);
            }

        }

        $newRfqBidsGroupByRfqId = DB::table('supplier_bids')
                ->whereIn('id',$newRfqBidIds)
                ->select('rfq_id', DB::raw('count(*) as total'))
                ->groupBy('rfq_id')
                ->get();
        $rfqsWithNewBid=[];
        foreach($newRfqBidsGroupByRfqId as $newRfqBidGroupByRfqId){
            array_push($rfqsWithNewBid ,$newRfqBidGroupByRfqId->rfq_id);
        }

        return view('rfq.my_rfq',compact('rfqLists','rfqsWithNewBid'));
    }

    public function delete($rfq_id)
    {
        $rfq=Rfq::findOrFail($rfq_id);
        $rfq->delete();
        \Session::flash('success', 'Rfq Successfully deleted');
        return redirect()->back();
    }

    public function active($rfq_id)
    {
        $rfq=Rfq::withTrashed()->findOrFail($rfq_id)->restore();
        \Session::flash('success', 'Rfq Successfully activited');
        return redirect()->back();
    }

    public function edit($rfq_id)
    {
        $rfq=Rfq::withTrashed()->where('id',$rfq_id)->with('images')->first();
        if(!$rfq){
            return response()->json([
                'success' => false,
                'error'  => 'id not exists',
            ],404);
        }
        $date=Carbon::parse($rfq->delivery_time)->format('Y-m-d');
        return response()->json([
            'success' => true,
            'data' => $rfq,
            'date' => $date,
        ],200);
    }

    public function update(Request $request, $rfq_id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title'       => 'required',
            'quantity'    => 'required',
            'unit'        =>  'required',
            'unit_price'     => 'required',
            'payment_method' => 'required',
            'delivery_time'  => 'required',
            'destination'   => 'required',
            'edit_rfq_id'  => 'required',
            'product_images.*' => 'max:10000',
            'short_description' => 'required',
            'full_specification' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }

        $rfq=Rfq::withTrashed()->where('id',$rfq_id)->first();
        if(!$rfq){
            return response()->json(array(
                'success' => false,
                'error' => 'rfq not exists'),
                400);
        }
        $rfq->update($request->only(['category_id','title','quantity','unit','unit_price','payment_method','delivery_time','destination','short_description','full_specification']));
        if($request->publish == true && $rfq->deleted_at){
            $rfq->restore();
        }else if($request->publish == false && !$rfq->deleted_at){
            $rfq->delete();
        }
        if ($request->hasFile('product_images')){
            foreach ($request->file('product_images') as $index=>$product_image){

                $extension = $product_image->getClientOriginalExtension();
                if($extension=='pdf' ||$extension=='PDF' ||$extension=='doc'||$extension=='docx'|| $extension=='xlsx' || $extension=='ZIP'||$extension=='zip'|| $extension=='TAR' ||$extension=='tar'||$extension=='rar' ||$extension=='RAR'  ){

                    $path=$product_image->store('images','public');


                }
                else{
                    $path=$product_image->store('images','public');
                    $image = Image::make(Storage::get($path))->fit(555, 555)->encode();
                    Storage::put($path, $image);
                }
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$path]);
            }
        }
        return response()->json([
            'success' => true,
            'msg' => 'rfq successfully updated',
        ],200);


    }

    public function singleImageDelete($rfq_image_id)
    {
            $rfq_image=RfqImage::findOrFail($rfq_image_id);
            if(Storage::exists($rfq_image->image)){
                Storage::delete($rfq_image->image);
            }
            $rfq_image->delete();
            return response()->json([
                'success' => true,
                'msg'   => 'image delete successfully',
            ],200);
    }

    public function generateUniqueLink()
    {
        do {
            $link = Str::random(20);
        } while (Rfq::where('link', $link)->first());

        return $link;
    }

    public function showRfqUsingLink($link)
    {
        $rfq=Rfq::withCount('bids')->with('user','businessProfile','category','images')->where('link',$link)->firstOrFail();

        if($rfq->bids()->exists()){
            $bid_user_id=[];
            foreach($rfq->bids as $user){
                array_push($bid_user_id,$user->supplier_id);
            }
            $rfq['bid_user_id'] = array_unique($bid_user_id);

        }

        return view('rfq.show_using_link',compact('rfq'));
    }

    public function share($rfq_id)
    {
        $rfq=Rfq::where('id',$rfq_id)->first();
        if(!$rfq){
            return response()->json(['error' => 'Record not found'],404);
        }

        if($rfq->link){
            $link=route('show.rfq.using.link',$rfq->link);
            return response()->json(['link'=> $link],200);
        }

        $link=$this->generateUniqueLink();
        $rfq->update(['link'=> $link]);
        $link=route('show.rfq.using.link',$rfq->link);
        return response()->json(['link'=> $link],200);
    }

    public function loginFromRfqShareLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rfqpassword' => 'required',
            'rfqemail' => 'required|email',
        ]);

        if ($validator->passes()) {
            // sso checking authentication
            if(env('APP_ENV') == 'production')
            {
                $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
                    'email' => $request->rfqemail,
                    'password' => $request->rfqpassword,
                ]);
                if($sso->successful()){
                    $access_token=$sso['access'];
                    $explode=explode(".",$access_token);
                    $time= base64_decode($explode[1]);
                    $decode_time=json_decode($time);
                    $get_time=$decode_time->exp;
                    $current=strtotime(date('d.m.Y H:i:s'));
                    $totalSecondsDiff = abs($get_time-$current);
                    $totalMinutesDiff = $totalSecondsDiff/60;
                    // $totalHoursDiff   = $totalSecondsDiff/60/60;
                    // $totalDaysDiff    = $totalSecondsDiff/60/60/24;
                    // $totalMonthsDiff  = $totalSecondsDiff/60/60/24/30;
                    // $totalYearsDiff   = $totalSecondsDiff/60/60/24/365;

                    // if($request->hasCookie('sso_token') !== null){
                    //     Cookie::forget('sso_token');
                    // }
                    if(Cookie::has('sso_token')){
                        Cookie::queue(Cookie::forget('sso_token'));
                    }
                   // $set_cookie=Cookie::make('sso_token', $access_token, $totalMinutesDiff);
                    Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));

                    if($request->session()->has('sso_password')){
                        $request->session()->forget('sso_password');
                    }
                    $request->session()->put('sso_password', $request->password);


                }
                else{
                    return response()->json(['msg' => 'No active account found with the given credentials']);
                }
            }


            $credentials = [
                'email' => $request->rfqemail,
                'password' => $request->rfqpassword,
            ];
            $remember_me = $request->remember == 'true' ? true : false;
            if(Auth::attempt($credentials,$remember_me))
            {
                $userId = auth()->user()->id;
                $user = User::whereId($userId)->first();
                $user->update(['last_activity' => Carbon::now(),'fcm_token'=>$request->fcm_token]);

                return response()->json(['user_id'=>$user->user_id, 'url' => url()->previous() ]);
            }
            return response()->json(['msg' => 'Wrong email or password']);

        }

        return response()->json(['error'=>$validator->errors()]);

    }

    public function create()
    {
        return view('rfq.create');
    }
}

