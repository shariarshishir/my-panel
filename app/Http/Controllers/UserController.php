<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Vendor;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\Country;
use App\Models\VendorOrder;
use App\Models\BusinessProfile;
use App\Models\VendorReview;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Image;
use App\Events\NewUserHasRegisteredEvent;
use App\Models\OrderModificationRequest;
use DateTime;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use stdClass;


class UserController extends Controller
{

    public function create(Request $request)
    {


        if($request->user_type=='buyer'){

            $request->validate([
                'full_name' => 'required|string|max:255',
                'email'=> 'required|string|email|max:255|unique:users',
                'phone'=> 'required',
                'vendor_name'=>'nullable',
                'vendor_address'=>'nullable',
                //'password'=> 'required|string|min:8|confirmed',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
                'user_type'=>'required|string',
                'image'=>'image|max:5000',
            ]);
        }
        else{
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email'=> 'required|string|email|max:255|unique:users',
                'phone'=> 'required',
                'vendor_name'=>'required|unique:vendors',
                'vendor_address'=>'required',
                //'password'=> 'required|string|min:8|confirmed',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
                'user_type'=>'required|string',
                'image'=>'image|max:5000',
            ]);
        }


        if ($request->hasFile('image'))
        {

            $userEmail=$request->email;
            $uniqueUserName=[];
            $uniqueUserName=explode("@",$userEmail);
            $filename = $request->image->store('images/'.$uniqueUserName[0].'/profile','public');
            $image_resize = Image::make(public_path('storage/'.$filename));
            $image_resize->fit(250, 250);
            $image_resize->save(public_path('storage/'.$filename));

        }

        //Generating unique user id
        //$user_id=mt_rand(1,999999);
        $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);


        //For authenticated user
        if (Auth::check()) {
            $created_by=auth()->user()->id;
        }
        //For unauthenticated user
        else{
            $created_by=NULL;
        }


        $user = User::create([
            'user_id'=>$user_id,
            'name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
            'image'=>$filename,
            'created_by'=>$created_by,
            'updated_by'=>NULL,
        ]);

        $user=User::latest()->first();


        //After creating user will create vendor as weel as
        $date=Carbon::today()->toDateString();
        $date=Carbon::parse($date)->format('dmY');
        $number=mt_rand(0,9999999);
        $name= Str::slug($request->vendor_name,'-');
        $vendorUId='mbs-'.$name.'-'.$date.$number;

        Vendor::create([
            'user_id'=>$user->id,
            'vendor_uid' => $vendorUId,
            'vendor_name' => $request->vendor_name,
            'vendor_address' => $request->vendor_address,
            'created_by'=>$user->id,
            'updated_by'=>NULL,
        ]);
         //send user information to sso for registration
         //if(env('APP_ENV') == 'production') {
            // $sso=Http::post(env('SSO_URL').'/api/auth/signup/',[
            //     'name'  => $request->full_name,
            //     'email' => $request->email,
            //     'password' => $request->password,
            //     'company' => $request->vendor_name,
            // ]);
        // }

            // if($sso->successful()){
            //     return $sso;
            // }else if($sso->failed()){
            //     return $sso;
            // }else if($sso->clientError()){
            //     return $sso;
            // }else if($sso->serverError()){
            //     return $sso;
            // }


        // Send user information to merchantbay for registration
            // $manufacture_base_url=env('MANUFACTURE_BASE_URL');

            //     if ($request->hasFile('image')) {

            //         $image = $request->file('image');
            //         $response=Http::attach('attachment', file_get_contents($image), 'image.jpg')
            //             ->post($manufacture_base_url.'/api/register', $request->all());

            //     }else {
            //         $response= Http::post($manufacture_base_url.'/api/register', $request->all());
            //     }


        //After registration an email will send to mechant bay

        //event(new NewUserHasRegisteredEvent($user));
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
          ]);

        Mail::send('emails.emailVerificationEmail', ['token' => $token, 'user' => $user], function($message) use($request){
            $message->to($request->email);
            $message->subject('Welcome to merchant Bay Ltd');
        });

        //Check credential for authentication

        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        if(Auth::attempt($credentials))
        {
            // return redirect()->route('users.profile');
            return response()->json(['msg' => 'Registration Successfull'],200);
        }
        return response()->json(['errors'=> 'Internal Server Error'],500 );
    }



    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';
        // $manufacture_base_url=env('MANUFACTURE_BASE_URL');
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                // $response_manufacture = Http::get( $manufacture_base_url.'/api/verify', ['email' => $user->email]);
                // $response_shop = Http::post( env('SHOP_BASE_URL').'/verify-user-from-manufacture', ['email' => $user->email]);
                Auth::login($user);
                return redirect()->route('users.profile');
                $message = "Your email have been verified successfully. Please Click here to login";
            } else {
                $message = "Your email have been verified successfully.";
            }
        }

      return view('auth.verify')->with('message', $message);
    }

    public function anonymousUserAccountVerification(Request $request, $token, $encryptedAuthInfo) {

        $decryptAuthInfo = base64_decode($encryptedAuthInfo);
        $decryptAuthInfo = json_decode($decryptAuthInfo);

        $sso = Http::post(env('SSO_URL').'/api/auth/token/',[
            'email' => $decryptAuthInfo->email,
            'password' => $decryptAuthInfo->password,
        ]);

        if($sso->successful()){
            $access_token = $sso['access'];
            $explode = explode(".",$access_token);
            $time = base64_decode($explode[1]);
            $decode_time = json_decode($time);
            $get_time = $decode_time->exp;
            $get_time = strtotime(date('d.m.Y H:i:s')) + strtotime(date('d.m.Y H:i:s'));
            $current = strtotime(date('d.m.Y H:i:s'));
            $totalSecondsDiff = abs($get_time-$current);
            $totalMinutesDiff = $totalSecondsDiff/60;

            if(Cookie::has('sso_token')){
                Cookie::queue(Cookie::forget('sso_token'));
            }
            Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));

            if($request->session()->has('sso_password')){
                $request->session()->forget('sso_password');
            }
            $request->session()->put('sso_password', $decryptAuthInfo->password);
        }
        else
        {
            return response()->json(['error' => 'No active account found with the given credentials or maybe you have provided wrong email or password.'],401);
        }

        $credentials = [
            'email' => $decryptAuthInfo->email,
            'password' => $decryptAuthInfo->password,
        ];

        if(!Auth::attempt($credentials))
        {
            return  response()->json(['error' => "Wrong email or password"],401);
        }

        //return view('auth.anonymousverify')->with('message', $message);
        return view('auth.anonymousverify', compact('decryptAuthInfo'));
    }

    public function anonymousPasswordUpdate( Request $request )
    {
        //dd($request->all());
        //dd($token);
        $token = Cookie::get('sso_token');
        $ssoPasswordReset = Http::withToken($token)->post(env('SSO_URL').'/api/auth/passwordreset/',[
            'password' => $request->newpassword,
        ]);

        if($ssoPasswordReset->successful())
        {

            $verifyUser = User::where('email', $request->email)->first();
            //dd($verifyUser);
            if(!is_null($verifyUser) )
            {
                if(!$verifyUser->is_email_verified) {
                    $verifyUser->is_email_verified = 1;
                    $verifyUser->password = Hash::make($request->newpassword);
                    $verifyUser->save();
                    //Auth::login($user);
                } else {
                    return response()->json(['error' => 'Verification Process faild.'],401);
                }
            }

            if(Cookie::has('sso_token')){
                Cookie::queue(Cookie::forget('sso_token'));
            }
            if(session()->has('sso_password')){
                session()->forget('sso_password');
            }
            Auth::guard('web')->logout();

            return redirect()->route('anonymous.account.verification.successful');

        }
    }

    public function anonymousAccountVerificationSuccessful(){
        return view('auth.anonymousAccountVerificationSuccessful');
    }

    public function unverifiedAccount(){
        return view('auth.unverified');
    }

    public function resendVerificationEmail(Request $request){

        $user=User::where('email',$request->email)->first();
        if($user && $user->is_email_verified==0){
            $verifyUser = UserVerify::where('user_id', $user->id)->first();
            Mail::send('emails.emailVerificationEmail', ['token' => $verifyUser->token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });
            return redirect()->back()->with('message', 'Email verification email has sent');
        }else{
            return redirect()->back()->with('message', 'User does not exist');
        }

    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->passes()) {
            // sso checking authentication
            if(env('APP_ENV') == 'production')
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
                    return response()->json(['msg' => 'No active account found with the given credentials or maybe you have provided wrong email or password.']);
                }
            }


            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            $remember_me = $request->remember == 'true' ? true : false;
            if(Auth::attempt($credentials,$remember_me))
            {
                $userId = auth()->user()->id;
                $user = User::whereId($userId)->first();
                $user->update(['last_activity' => Carbon::now(),'fcm_token'=>$request->fcm_token]);
                return response()->json(['user_id'=>$user->user_id,'userObj'=>$user]);
            }
            return response()->json(['msg' => 'Wrong email or password']);

        }

        return response()->json(['error'=>$validator->errors()]);

    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    //user login from sso
    public function loginFromSso(Request $request)
    {
        if(!isset($request->token)){
            abort(404);
        }

        $token=$request->token;
        $decode_token= base64_decode($token);
        $json_decode_token=json_decode($decode_token);
        $access_token=$json_decode_token->access;
        $user_obj=$json_decode_token->user;
        //user loging credential
        $email=$user_obj->email;
        $password=base64_decode($user_obj->password);
        //access token
        $explode=explode(".",$access_token);
        $time= base64_decode($explode[1]);
        $decode_time=json_decode($time);
        $get_time = $decode_time->exp;
        $get_time= strtotime(date('d.m.Y H:i:s')) + strtotime(date('d.m.Y H:i:s'));
        $current=strtotime(date('d.m.Y H:i:s'));
        $totalSecondsDiff = abs($get_time-$current);
        $totalMinutesDiff = $totalSecondsDiff/60;
        //check user exists
        $user=User::where('email', $email)->first();
        if(!$user){
            $data= new stdClass();
            $data->name= $user_obj->name;
            $data->email=$email;
            $data->password=$password;
            $data->phone=$user_obj->phone;
            $data->user_type=$user_obj->user_type;
            $data->company_name=$user_obj->name;
            $data->sso_reference_id=$user_obj->id;
             $this->userRegFromSsoIfNOtExists($data);
        }

        if(Auth::attempt(['email' => $email, 'password' => $password]))
            {
                //set cookie
                if(Cookie::has('sso_token')){
                    Cookie::queue(Cookie::forget('sso_token'));
                }
                Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));
                //set password to session
                if($request->session()->has('sso_password')){
                    $request->session()->forget('sso_password');
                }
                $request->session()->put('sso_password', $password);

                return redirect()->route('users.profile');
            }
        return abort(405);

    }


    public function logout()
    {
        if(env('APP_ENV') == 'production')
        {
            if(Cookie::has('sso_token')){
                Cookie::queue(Cookie::forget('sso_token'));
            }
            if(session()->has('sso_password')){
                session()->forget('sso_password');
            }
        }

        Auth::guard('web')->logout();
        return redirect(env('SSO_URL').'?type=logout&flag=global');

    }

    public function profile()
    {

        // $source = ProductCategory::select('id', 'name', 'parent_id')->get()->toArray();
        // $inArray = array();
        // foreach($source as $key => $value)
        // {
        //     $inArray[$key] = $value;
        // }
        // $category = array();
        // $this->makeParentChildRelations($inArray, $category);

        // $vendorReviews = VendorReview::where('vendor_id', $user->vendor->id)->get();
        // $productList=Product::where('vendor_id',$user->vendor->id)->where('is_new_arrival',0)->where('is_featured',0)->where('state',1)->paginate(5);
        // $productNewArrival=Product::where('vendor_id',$user->vendor->id)->where('is_new_arrival',1)->where('state',1)->paginate(5);

        // return $orderModification;
        //check user type then fetch order with additional data  based on that user
        // if($user->user_type=='buyer'){
        //     $orders = VendorOrder::where('user_id',$user->id)->with(['billingAddress','shippingAddress'])->paginate(10);
        //     $orderModificationRequest=OrderModificationRequest::where('user_id',$user->id)->with(['comments.replies', 'orderModification.orderItem'])->get();
        // }
        // else{
        //     $orders = VendorOrder::where('vendor_id',$user->vendor->id)->whereNotIn('state', ['pending','cancel'])->with(['billingAddress','shippingAddress'])->paginate(10);
        //     $orderModificationRequest=OrderModificationRequest::where('vendor_id',$user->vendor->id)->with(['comments.replies', 'orderModification'])->get();
        // }
         //($orderIds);
        //dd(count($orderModificationRequestIds));

        // return view('user.profile.index',compact('user','category','productList','productNewArrival','productFeatured','countries','orders','flag','vendorReviews','orderModificationRequestIds','orderIds','orderModificationRequest','notifications'));

        $user=User::where('id',auth()->id())->first();
        $businessProfiles=BusinessProfile::withTrashed()->where('user_id',auth()->id())->get();
        if($businessProfiles->isEmpty())
        {
            $businessProfiles=BusinessProfile::withTrashed()->where('representative_user_id',auth()->id())->get();
        }


        $countries=Country::all();
        //$productFeatured=Product::where('vendor_id',$user->vendor->id)->where('is_featured',1)->where('state',1)->paginate(5);
        // //check whether vendor's all  information exist or not
        // if($user->user_type=='wholesaler'){
        //     if($user->vendor->vendor_name && $user->vendor->vendor_ownername && $user->vendor->vendor_address && $user->vendor->vendor_type && $user->vendor->vendor_country &&$user->vendor->vendor_totalemployees && $user->vendor->vendor_mainproduct && $user->vendor->vendor_yearest){
        //         $flag=1;
        //     }
        //     else{
        //         $flag=0;
        //     }
        // }
        // else{
        //     if($user->vendor->vendor_name && $user->vendor->vendor_ownername && $user->vendor->vendor_address && $user->vendor->vendor_type && $user->vendor->vendor_country &&$user->vendor->vendor_totalemployees  && $user->vendor->vendor_yearest){
        //         $flag=1;
        //     }
        //     else{
        //         $flag=0;
        //     }
        // }

        $flag=1;

        $notifications = auth()->user()->unreadNotifications;
       // dd($notifications);
        $orderIds=[];
        $orderModificationRequestIds=[];
        $orderApprovedNotificationIds=[];
        $orderModificationRequestNotificationIds=[];
        $orderQueryProcessedIds=[];
        foreach($notifications as $notification)
        {
            if($notification->type == "App\Notifications\NewOrderHasApprovedNotification"){
                array_push($orderIds,$notification->data['notification_data']);
            }
            else if($notification->type == "App\Notifications\QueryWithModificationToUserNotification"){
                array_push($orderModificationRequestIds,$notification->data['notification_data']);

            }
            else if($notification->type == "App\Notifications\OrderQueryFromAdminNotification"){
                array_push($orderQueryProcessedIds,$notification->data['notification_data']['order_modification_request_id']);
            }
            else if($notification->type == "App\Notifications\QueryCommuncationNotification"){
                if($notification->data['order_qurey_type'] == 2){
                    array_push($orderModificationRequestIds,$notification->data['notification_data']);
                }
                if($notification->data['order_qurey_type'] == 1){
                    array_push($orderQueryProcessedIds,$notification->data['notification_data']);
                }
            }
            elseif($notification->type == "App\Notifications\PaymentSuccessNotification"){
                array_push($orderIds,$notification->data['notification_data']);
            }
        }

        return view('user.profile.index',compact('user','countries','flag','orderModificationRequestIds','orderIds','orderQueryProcessedIds','businessProfiles'));
    }


    public function  notificationMarkAsRead(Request $request){

        foreach(auth()->user()->unreadNotifications->where('read_at',null) as $notification){
                if($notification->type == "App\Notifications\OrderQueryFromAdminNotification" && $notification->data['notification_data']['order_modification_request_id']==$request->notificationId)
                {
                    $notification->markAsRead();
                    $message="Notification mark as read successfully";
                }

                elseif($notification->type == "App\Notifications\QueryCommuncationNotification" && $notification->data['notification_data']==$request->notificationId)
                {
                    $notification->markAsRead();
                    $message="Notification mark as read successfully";
                }
                elseif($notification->type == "App\Notifications\QueryWithModificationToUserNotification" && $notification->data['notification_data']==$request->notificationId)
                {
                    $notification->markAsRead();
                    $message="Notification mark as read successfully";
                }
                elseif($notification->type == "App\Notifications\NewOrderHasApprovedNotification" && $notification->data['notification_data']==$request->notificationId)
                {
                    $notification->markAsRead();
                    $message="Notification mark as read successfully";
                }
                elseif($notification->type == "App\Notifications\ProductAvailabilityNotification" && $notification->data['notification_data']['id']==$request->notificationId)
                {
                    $notification->markAsRead();
                    $message="Notification mark as read successfully";
                }
                elseif($notification->type == "App\Notifications\PaymentSuccessNotification" && $notification->data['notification_data']==$request->notificationId)
                {
                    $notification->markAsRead();
                    $message="Notification mark as read successfully";
                }
                elseif($notification->type == "App\Notifications\NewRfqNotification" && $notification->data['rfq_data']['id']==$request->rfqId)
                {
                    $notification->markAsRead();
                    $message="Notification mark as read successfully";
                }

        }

        if(!isset($message)){
            $message="not found";
        }
        // $notification = auth()->user()->Notifications->find($request->notificationId);
        // if($notification->read_at==null){
        //     auth()->user()->unreadNotifications->where('id', $request->notificationId)->markAsRead();
        //     $message="Notification mark as read successfully";

        // }

        $unreadNotifications=auth()->user()->unreadNotifications->where('read_at',null);
        $noOfnotification=count($unreadNotifications);

        $orderModificationRequestIds=[];
        $orderApprovedNotificationIds=[];
        $orderQueryProcessedIds=[];
        foreach(auth()->user()->unreadNotifications->where('read_at',null) as $notification){
            if($notification->type=="App\Notifications\NewOrderHasApprovedNotification"){
                array_push($orderApprovedNotificationIds,$notification->data['notification_data']);
            }
            elseif($notification->type=="App\Notifications\QueryWithModificationToUserNotification"){
                array_push($orderModificationRequestIds,$notification->data['notification_data']);
            }
            elseif($notification->type == "App\Notifications\OrderQueryFromAdminNotification"){
                array_push($orderQueryProcessedIds,$notification->data['notification_data']['order_modification_request_id']);
            }
            elseif($notification->type=="App\Notifications\QueryCommuncationNotification"){
                array_push($orderModificationRequestIds,$notification->data['notification_data']);
            }
            elseif($notification->type=="App\Notifications\PaymentSuccessNotification"){
                array_push($orderApprovedNotificationIds,$notification->data['notification_data']);
            }



        }
        $newModificationRequestNotificationCount=count($orderModificationRequestIds);
        $newOrderApprovedNotificationCount=count($orderApprovedNotificationIds);
        $newOrderQueryProcessedCount= count( $orderQueryProcessedIds);


        // return response()->json(['message'=>$message,'read_at'=>$notification->read_at,'noOfnotification'=>$noOfnotification,'newModificationRequestNotificationCount'=>$newModificationRequestNotificationCount,'newOrderApprovedNotificationCount'=>$newOrderApprovedNotificationCount, 'newOrderQueryProcessedCount' => $newOrderQueryProcessedCount]);
         return response()->json(['message'=>$message,'noOfnotification'=>$noOfnotification,'newModificationRequestNotificationCount'=>$newModificationRequestNotificationCount,'newOrderApprovedNotificationCount'=>$newOrderApprovedNotificationCount, 'newOrderQueryProcessedCount' => $newOrderQueryProcessedCount]);

    }


    public function updateImage(Request $request)
    {

        $user=User::where('id',$request->user_id)->first();
        if ($request->hasFile('image'))
        {
            $userEmail=$user->email;
            $uniqueUserName=[];
            $uniqueUserName=explode("@",$userEmail);

            $s3 = \Storage::disk('s3');
            $uniqueString = generateUniqueString();
            $image_unique_file_name = uniqid().$uniqueString.'.'.$request->image->getClientOriginalExtension();
            $image_path_saved_in_db = 'images/'.$uniqueUserName[0].'/profile/'.$image_unique_file_name;
            $s3filePath = '/public/images/'.$uniqueUserName[0].'/profile/'.$image_unique_file_name;
            $s3->put($s3filePath, file_get_contents($request->image));
        }

        $user->image= $image_path_saved_in_db;
        $user->save();
        $message="Image uploaded successfully";
        return response()->json(['user'=>$user,'message'=>$message]);
    }
    //banner image update
    public function updateBanner(Request $request)
    {

        $request->validate([
            // 'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image' => 'required',
        ]);
        $user=User::where('id',auth()->id())->first();
            if($user->user_banner){
                if(Storage::exists('public/'.$user->user_banner) )
                    {
                        Storage::delete('public/'.$user->user_banner);
                    }
            }

            $userEmail=$user->email;
            $uniqueUserName=[];
            $uniqueUserName=explode("@",$userEmail);
            $folderPath = public_path('storage/'.'images/'.$uniqueUserName[0].'/banner'.'/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.png';
            $imageFullPath = $folderPath.$imageName;

            file_put_contents($imageFullPath, $image_base64);
            $filename='images/'.$uniqueUserName[0].'/banner'.'/'.$imageName;

            $user->user_banner= $filename;
            $user->save();
            $message="Banner uploaded successfully";
            return response()->json(['user'=>$user,'message'=>$message],200);
    }

    public function myShop($vendorId)
    {
        $vendor=Vendor::where('vendor_uid',$vendorId)->first();
        $productNewArrival=Product::where('vendor_id',$vendor->id)->where('is_new_arrival',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'new_arrival');
        $productFeatured=Product::where('vendor_id',$vendor->id)->where('is_featured',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'is_featured');
        return view('user.myshop.index',compact('vendor','productNewArrival','productFeatured'));
    }

    public function myShopProductsByCategory($vendorUid,$slug){

        $vendor=Vendor::where('vendor_uid',$vendorUid)->first();
        $category=ProductCategory::Where('slug',$slug)->first();
        $total_cat_id[]=$category->id;
        if($category->children()->exists()){
            foreach($category->children as $child){
                array_push($total_cat_id,$child->id);
                if($child->children()->exists()){
                    foreach($child->children as $child2){
                        array_push($total_cat_id,$child2->id);
                    }
                }
            }
        }
        $productNewArrival=Product::where('vendor_id',$vendor->id)->whereIn('product_category_id',$total_cat_id)->where('is_new_arrival',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'new_arrival');
        $productFeatured=Product::where('vendor_id',$vendor->id)->whereIn('product_category_id',$total_cat_id)->where('is_featured',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'is_featured');
        return view('user.myshop.index',compact('vendor','productNewArrival','productFeatured'));


    }

    public function myShopProductsBySubcategory($vendorUid,$category,$subcategory){

        $vendor=Vendor::where('vendor_uid',$vendorUid)->first();
        $category=ProductCategory::Where('slug',$subcategory)->first();
        $total_cat_id[]=$category->id;
        if($category->children()->exists()){
            foreach($category->children as $child){
                array_push($total_cat_id,$child->id);
            }
        }
        $productNewArrival=Product::where('vendor_id',$vendor->id)->whereIn('product_category_id',$total_cat_id)->where('is_new_arrival',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'new_arrival');
        $productFeatured=Product::where('vendor_id',$vendor->id)->whereIn('product_category_id',$total_cat_id)->where('is_featured',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'is_featured');
        return view('user.myshop.index',compact('vendor','productNewArrival','productFeatured'));


    }

    public function myShopProductsBySubSubCategory($vendorUid,$category,$subcategory,$subsubcategory){

        $vendor=Vendor::where('vendor_uid',$vendorUid)->first();
        $productCategory=ProductCategory::Where('slug',$subsubcategory)->first();
        $productNewArrival=Product::where('vendor_id',$vendor->id)->where('product_category_id',$productCategory->id)->where('is_new_arrival',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'new_arrival');
        $productFeatured=Product::where('vendor_id',$vendor->id)->where('product_category_id',$productCategory->id)->where('is_featured',1)->where('state',1)->where('sold',0)->inRandomOrder()->paginate(9,['*'], 'is_featured');
        return view('user.myshop.index',compact('vendor','productNewArrival','productFeatured'));


    }

    public function myShopProfile($vendorId)
    {
        $vendor=Vendor::where('vendor_uid',$vendorId)->first();
        return view('user.myshop.storeprofile',compact('vendor'));
    }

    public function myShopContact($vendorId)
    {
        $vendor=Vendor::where('vendor_uid',$vendorId)->first();
        return view('user.myshop.storecontact',compact('vendor'));
    }

    public function myShopReviews($vendorId)
    {
        $vendor = Vendor::where('vendor_uid', $vendorId)->first();
        $vendorReviews = VendorReview::where('vendor_id', $vendor->id)->get();
        return view('user.myshop.storereviews',compact('vendor', 'vendorReviews'));
    }

    public function showRegistrationForm($type)
    {
      $userType=$type;
      return view('auth.register',compact('userType'));
    }

    public function makeParentChildRelations(&$inArray, &$outArray, $currentParentId = 0)
    {
        if(!is_array($inArray)) {
            return;
        }

        if(!is_array($outArray)) {
            return;
        }

        foreach($inArray as $key => $tuple) {
            if($tuple['parent_id'] == $currentParentId) {
                $tuple['children'] = array();
                $this->makeParentChildRelations($inArray, $tuple['children'], $tuple['id']);
                $outArray[] = $tuple;
            }
        }
    }

    public function relatedProducts($business_profile_id)
    {
        $related_products=Product::where('business_profile_id',$business_profile_id)->get();
        return response()->json($related_products,200);
    }

     // login from merchantbay
     public function loginFromMerchantbay(Request $request)
     {
         $request->validate([
             'email' => 'required',
             'password' => 'required',
         ]);

         // sso checking authentication
         $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if($sso->successful()){
            //check user exists
            $user=User::where('email', $request->email)->first();
            if(!$user){
                 $this->userRegFromMbIfNOtExists($request);
            }
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

            if(Cookie::has('sso_token')){
                Cookie::queue(Cookie::forget('sso_token'));
            }

            Cookie::queue(Cookie::make('sso_token', $access_token, $totalMinutesDiff));


        }
        else{

           // return response()->json(['msg' => 'No active account found with the given credentials']);
           return redirect()->back()->with('message' , 'No active account found with the given credentials');
        }

         $credential=['email' => $request->email, 'password' => $request->password];
         if(Auth::guard('web')->attempt($credential)){

            if($request->session()->has('sso_password')){
                $request->session()->forget('sso_password');
            }
            $request->session()->put('sso_password', $request->password);

            return redirect()->route('home');
         }
         return redirect()->back()->with('message' , 'Something Went Wrong');
         //return response()->json(['msg' => 'something went wrong']);
     }

     public function userRegFromMbIfNOtExists(Request $request)
     {
        $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
        $user = User::create([
            'user_id'=>$user_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type == 'buyer' ? 'buyer' : 'wholesaler',
            'sso_reference_id' =>$request->sso_reference_id,
            'phone'     => $request->phone ?? null,
            'is_email_verified' => 1,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        //After creating user will create vendor as weel as
        $date=Carbon::today()->toDateString();
        $date=Carbon::parse($date)->format('dmY');
        $number=mt_rand(0,9999999);
        $name= Str::slug($request->company_name,'-');
        $vendorUId='mbs-'.$name.'-'.$date.$number;

        Vendor::create([
            'user_id'=>$user->id,
            'vendor_uid' => $vendorUId,
            'vendor_name' => $request->company_name,
            'created_by'=>$user->id,
            'updated_by'=>NULL,
        ]);
    }

    //user reg from sso if user not exists
    public function userRegFromSsoIfNOtExists($data)
    {
       $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
       $user = User::create([
           'user_id'=>$user_id,
           'name' => $data->name,
           'email' => $data->email,
           'password' => Hash::make($data->password),
           'user_type' => 'buyer',
           'sso_reference_id' =>$data->sso_reference_id,
           'phone'     => $data->phone ?? null,
           'company_name' => $data->company_name,
           'is_email_verified' => 1,
       ]);

   }


}

