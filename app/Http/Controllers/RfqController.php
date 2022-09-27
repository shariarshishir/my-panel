<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rfq;
use App\Models\User;
use App\Models\Product;
use App\Models\RfqImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\NewRfqHasAddedJob;
use App\Models\BusinessProfile;
use App\Events\NewRfqHasAddedEvent;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
Use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Manufacture\Product as ManufactureProduct;


class RfqController extends Controller
{
    public function index()
    {
        $token = Cookie::get('sso_token');
        if($token) {
            $response = Http::withToken($token)->get(env('RFQ_APP_URL').'/api/quotation/filter/null/page/1/limit/10');
        } else {
            $response = Http::get(env('RFQ_APP_URL').'/api/quotation/filter/null/page/1/limit/10');
        }
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        $rfqsCount = $data['count'];

        $noOfPages = ceil($data['count']/10);
        return view('rfq.index',compact('rfqLists','noOfPages'));
    }

    public function rfqByPageNumber(Request $request)
    {
        $page = $request->page;
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/filter/null/page/'.$page.'/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        return view('rfq.rfq_list',compact('rfqLists'))->render();
    }


    public function store(Request $request)
    {
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

   /* public function myRfq(Request $request)
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
    }*/

    public function myRfq(Request $request)
    {
        $user = Auth::user();
        $token = Cookie::get('sso_token');
        $response = Http::withToken($token)
        ->get(env('RFQ_APP_URL').'/api/quotation/user/'.$user->sso_reference_id.'/filter/null/page/1/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        $rfqsCount = $data['count'];
        $noOfPages = ceil($data['count']/10);
        return view('rfq.my_rfq',compact('rfqLists','noOfPages'));
    }

    public function myRfqByPageNumber(Request $request){
        $user = Auth::user();
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/user/'.$user->sso_reference_id.'/filter/null/page/1/limit/10');
        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        return view('rfq.my_rfq_list',compact('rfqLists'))->render();
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

    public function showRfqUsingLink($link, Request $request)
    {
        if (Auth::check() && env('APP_ENV') == 'production'){
            $token= $request->cookie('sso_token');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])->get(env('RFQ_APP_URL').'/api/quotation/'.$link);
        }else{
            $response = Http::get(env('RFQ_APP_URL').'/api/quotation/'.$link);
        }

        $data = $response->json();
        $rfqLists = $data['data'] ?? [];
        return view('rfq.show_using_link',compact('rfqLists'));
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

    public function storeFromProductDetails(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'title'       => 'required',
            'rfq_quantity'    => 'required',
            'unit'        =>  'required',
            'rfq_unit_price'     => 'required',
            'payment_method' => 'required',
            'delivery_time'  => 'required',
            'destination'   => 'required',
            'short_description' => 'required',
            'full_specification' => 'required',

        ]);

        $rfqData = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'quantity' => $request->rfq_quantity,
            'unit' => $request->unit,
            'unit_price' => $request->rfq_unit_price,
            'payment_method' => $request->payment_method,
            'delivery_time' => $request->delivery_time,
            'destination' => $request->destination,
            'short_description' => $request->short_description,
            'full_specification' => $request->full_specification,
            'created_by' => auth()->id(),
            'status' => 'pending',
            'rfq_from' => "service",
            'link' => $this->generateUniqueLink(),

        ];

        $rfq=Rfq::create($rfqData);

        /*if ($request->hasFile('product_images')){
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
        }*/
        if($request->flag == 'mb'){
            $product=ManufactureProduct::with('product_images')->where('id', $request->product_id)->first();
            foreach($product->product_images  as $key => $image){
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$image->product_image]);
               if($key == 2){
                   break;
               }
            }
        }
        if($request->flag == 'shop'){
            $product=Product::with('images')->where('id', $request->product_id)->first();
            foreach($product->images  as $key => $image){
                RfqImage::create(['rfq_id'=>$rfq->id, 'image'=>$image->image]);
               if($key == 2){
                   break;
               }
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


        $msg = "Your RFQ was posted successfully.<br><br>Thank you for your request. We will get back to you with quotations within 48 hours.";
        return back()->with(['rfq-success'=> $msg]);
    }

    public function storeWithLogin(Request $request)
    {
        if(env('APP_ENV') == 'local')
        {
            return  response()->json(['error' => "change the environment.now environment is local"],401);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:r_email',
            'password' => 'required_without:r_password',
            'r_email' => 'required_without:email|unique:users,email',
            'r_password' => 'required_without:password',
            'name'      => 'required_without:email',
        ],[
            'r_email.unique' => 'The email has already been taken.'
        ]);
        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }


        if(isset($request->email) && isset($request->password))
        {
            $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
                'email' => $request->email,
                'password' => $request->password,
            ]);
            if($sso->successful()){
                $access_token=$sso['access'];
                $explode=explode(".",$access_token);
                $time= base64_decode($explode[1]);
                $decode_time=json_decode($time);
                $get_time=$decode_time->exp;
                $get_time=strtotime(date('d.m.Y H:i:s')) + strtotime(date('d.m.Y H:i:s'));
                $current=strtotime(date('d.m.Y H:i:s'));
                $totalSecondsDiff = abs($get_time-$current);
                $totalMinutesDiff = $totalSecondsDiff/60;

                if(Cookie::has('sso_token')){
                    Cookie::queue(Cookie::forget('sso_token'));
                }
                Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));

                if($request->session()->has('sso_password')){
                    $request->session()->forget('sso_password');
                }
                $request->session()->put('sso_password', $request->password);


            }
            else{
                return response()->json(['error' => 'No active account found with the given credentials or maybe you have provided wrong email or password.'],401);
            }

            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if(!Auth::attempt($credentials))
            {
                return  response()->json(['error' => "Wrong email or password"],401);
            }

            return response()->json(['access_token' =>  $access_token],200);

        }else{
            $registration_data = [
                'email' => $request->r_email,
                'password' => $request->r_password,
                'name' => $request->name,
                'company' =>'No Company',
                'user_type' => 'buyer',
                'user_flag' => 'rfq',
            ];

            $registration=Http::post(env('SSO_URL').'/api/auth/signup/',$registration_data);
            if(!$registration->successful()){
                return  response()->json(['error' => 'Registration failed, please try again'],403);
            }
            $fromSso=json_decode($registration->getBody());
            $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
            $registration_data_new_user = [
                'user_id'=>$user_id,
                'sso_reference_id' => $fromSso->id,
                'email' => $request->r_email,
                'password' => Hash::make($request->r_password),
                'name' => $request->name,
                'company_name' =>'No Company',
                'user_type' => 'buyer',
                'is_email_verified' => 1,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ];
            $new_user=User::create($registration_data_new_user);
            if(!$new_user){
                return  response()->json(['error' => 'Somethings went wrong'],403);
            }
            $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
                'email' => $request->r_email,
                'password' => $request->r_password,
            ]);
            if($sso->successful())
            {
                $access_token=$sso['access'];
                $explode=explode(".",$access_token);
                $time= base64_decode($explode[1]);
                $decode_time=json_decode($time);
                $get_time=$decode_time->exp;
                $get_time=strtotime(date('d.m.Y H:i:s')) + strtotime(date('d.m.Y H:i:s'));
                $current=strtotime(date('d.m.Y H:i:s'));
                $totalSecondsDiff = abs($get_time-$current);
                $totalMinutesDiff = $totalSecondsDiff/60;

                if(Cookie::has('sso_token')){
                    Cookie::queue(Cookie::forget('sso_token'));
                }
                Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));

                if($request->session()->has('sso_password')){
                    $request->session()->forget('sso_password');
                }
                $request->session()->put('sso_password', $request->r_password);


            }
            else{
                return response()->json(['error' => 'No active account found with the given credentials or maybe you have provided wrong email or password.'],401);
            }

            $credentials = [
                'email' => $request->r_email,
                'password' => $request->r_password,
            ];
            if(!Auth::attempt($credentials))
            {
                return  response()->json(['error' =>  "Wrong email or password"],401);
            }

            return response()->json(['access_token' =>  $access_token],200);
        }


    }

}
