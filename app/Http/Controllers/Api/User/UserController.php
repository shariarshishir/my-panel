<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\UserVerify;
use App\Models\BusinessProfile;
use App\Models\CompanyOverview;
use App\Models\OrderModificationRequest;
use Illuminate\Support\Facades\Hash;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Image;
use App\Events\NewUserHasRegisteredEvent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function importBusinessProfiles()
    {
        //$usersArr = array('akh@merchantbay.com','maisha@merchantbay.com','fabric@merchantbay.com','classic@merchantbay.com','dalim@merchantbay.com','alamin@merchantbay.com','sonali@merchantbay.com','nadia@merchantbay.com','fahima@merchantbay.com','rabbi@merchantbay.com','mehek@merchantbay.com','shahjalal@merchantbay.com','bestfriend@merchantbay.com','Silver@merchantbay.com','alifa@merchantbay.com','perplex@merchantbay.com','sorif@merchantbay.com','nahar@merchantbay.com','amz@merchantbay.com','handz@merchantbay.com','jalil@merchantbay.com','lithe@merchantbay.com','mamuni@merchantbay.com','ndknit@merchantbay.com','orange@merchantbay.com','pcapparels@merchantbay.com','uturn@merchantbay.com','sawda@merchantbay.com','rafiknit@merchantbay.com','rjfahion@merchantbay.com','gmx@merchanbay.com','union@merchantbay.com','atlanta@merchantbay.com','abapparels@merchantbay.com','orchid@merchantbay.com','sunbird@merchantbay.com');
        $users = User::whereIn('email', ['akh@merchantbay.com','maisha@merchantbay.com','fabric@merchantbay.com','classic@merchantbay.com','dalim@merchantbay.com','alamin@merchantbay.com','sonali@merchantbay.com','nadia@merchantbay.com','fahima@merchantbay.com','rabbi@merchantbay.com','mehek@merchantbay.com','shahjalal@merchantbay.com','bestfriend@merchantbay.com','Silver@merchantbay.com','alifa@merchantbay.com','perplex@merchantbay.com','sorif@merchantbay.com','nahar@merchantbay.com','amz@merchantbay.com','handz@merchantbay.com','jalil@merchantbay.com','lithe@merchantbay.com','mamuni@merchantbay.com','ndknit@merchantbay.com','orange@merchantbay.com','pcapparels@merchantbay.com','uturn@merchantbay.com','sawda@merchantbay.com','rafiknit@merchantbay.com','rjfahion@merchantbay.com','gmx@merchanbay.com','union@merchantbay.com','atlanta@merchantbay.com','abapparels@merchantbay.com','orchid@merchantbay.com','sunbird@merchantbay.com','jmknitwear@merchantbay.com'])->get();

        foreach($users as $user) {
            $business_profile_data=[
                'business_name' => $user->company_name,
                'alias'   => $this->createAlias($user->company_name),
                'user_id'       => $user->id,
                'business_type' => 'manufacturer', // forcefully set Manufacturer type
                'has_representative'=> 1,
                'industry_type' => 'apparel',
            ];
            $business_profile = BusinessProfile::create($business_profile_data);
            //$companyOverview = $this->createCompanyOverview($request, $business_profile->id);
        }

        $usersWithProfiles = User::with('businessProfile')->whereIn('email', ['akh@merchantbay.com','maisha@merchantbay.com','fabric@merchantbay.com','classic@merchantbay.com','dalim@merchantbay.com','alamin@merchantbay.com','sonali@merchantbay.com','nadia@merchantbay.com','fahima@merchantbay.com','rabbi@merchantbay.com','mehek@merchantbay.com','shahjalal@merchantbay.com','bestfriend@merchantbay.com','Silver@merchantbay.com','alifa@merchantbay.com','perplex@merchantbay.com','sorif@merchantbay.com','nahar@merchantbay.com','amz@merchantbay.com','handz@merchantbay.com','jalil@merchantbay.com','lithe@merchantbay.com','mamuni@merchantbay.com','ndknit@merchantbay.com','orange@merchantbay.com','pcapparels@merchantbay.com','uturn@merchantbay.com','sawda@merchantbay.com','rafiknit@merchantbay.com','rjfahion@merchantbay.com','gmx@merchanbay.com','union@merchantbay.com','atlanta@merchantbay.com','abapparels@merchantbay.com','orchid@merchantbay.com','sunbird@merchantbay.com','jmknitwear@merchantbay.com'])->get();

        return response()->json(['usersWithProfiles'=>$usersWithProfiles, 'code'=>'True'],200);
    }

    public function index()
    {
        $users=User::where('is_email_verified',1)->all();
        return response()->json(['users'=>$users,'code'=>'True'],200);
    }

    public function show($userId)
    {
        $user = User::with('businessProfile')->where('id',$userId)->where('is_email_verified',1)->first();
        $totalWishlist=count($user->productWishlist);
        $totalOrderPlacedByUser = count($user->vendorOrder);
        $orderQueries = OrderModificationRequest::where(['user_id' => $userId, 'type' => 1])->get();
        $orderModifications = OrderModificationRequest::where(['user_id' => $userId, 'type' => 2])->get();
        $totalOrderQueries = count($orderQueries);
        $totalOrderModifications = count($orderModifications);
        if(isset($user))
        {
            return response()->json(['user'=>$user,'totalWishlist'=>$totalWishlist,'totalOrderPlacedByUser'=>$totalOrderPlacedByUser,'totalOrderQueries'=>$totalOrderQueries,'totalOrderModifications'=>$totalOrderModifications,'message'=>'user found','code'=>'True'],200);
        }
        else
        {
            $totalWishlist = [];
            $totalOrderQueries = [];
            $totalOrderModifications = [];

            return response()->json(['user'=>$user,'totalWishlist'=>$totalWishlist,'totalOrderQueries'=>$totalOrderQueries,'totalOrderModifications'=>$totalOrderModifications,'message'=>'user not found','code'=>"False"],200);
        }

    }


    //store user from merchant bay

    public function storeUserFromMerchantBay(Request $request,$userType)
    {
        $data=json_decode($request->form_data);
        //return response()->json(dd($data));
        $userExistOrNot = User::where('email',$data->email)->first();
        if(!$userExistOrNot){

            if($request->hasFile('profile_image'))
            {
                $userEmail=$data->email;
                $uniqueUserName=[];
                $uniqueUserName=explode("@",$userEmail);
                $filename = $request->profile_image->store('images/'.$uniqueUserName[0].'/profile','public');
                $image_resize = Image::make(public_path('storage/'.$filename));
                $image_resize->fit(250, 250);
                $image_resize->save(public_path('storage/'.$filename));
            }

           // generating unique user id uisng id generattor package
            $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
            if($userType == 'buyer'){
                $data->is_group = 0;
            }

            $user = User::create([
                    'user_id'=>$user_id,
                    'name' => $data->uname,
                    'email' => $data->email,
                    'phone' => $data->contact_info->telephone_no,
                    'user_type' => $userType,
                    'password' => Hash::make($data->password),
                    'user_from_manufacture' => 1,
                    'is_email_verified' => 0,
                    'image'=>$filename,
                    'created_by'=>NULL,
                    'updated_by'=>NULL,
                ]);

            $token=$user->createToken('merchantbayshop')->plainTextToken;
            $user=User::latest()->first();

            //after creating user will create vendor as well as
            $date=Carbon::today()->toDateString();
            $date=Carbon::parse($date)->format('dmY');
            $number=mt_rand(0,9999999);
            $name= Str::slug($data->company_name,'-');
            $vendorUId='mbs-'.$name.'-'.$date.$number;

            $vendor = Vendor::create([
                'user_id'=>$user->id,
                'vendor_uid' => $vendorUId,
                'vendor_name' => $data->company_name,
                'vendor_address' =>($data->is_group==1) ? NULL : (($userType=='buyer') ? ($data->contact_info->street.' '.$data->contact_info->city.' '.$data->contact_info->region) : ($data->company_info->address.' '.$data->company_info->country)),
                'created_by'=>$user->id,
                'updated_by'=>NULL,
            ]);


            $email_verification_OTP = mt_rand(100000,999999);

            UserVerify::create([
                'user_id' => $user->id,
                'token' => $email_verification_OTP
              ]);


           //event(new NewUserHasRegisteredEvent($user));

            // Mail::send('emails.apiEmailVerificationEmail', ['token' => $email_verification_OTP], function($message) use($request){
            //     $message->to($request->email);
            //     $message->subject('Welcome to Merchantbay Shop');
            // });

            if($vendor && $user){
                return response()->json(array('user'=>$user,'token'=>$email_verification_OTP,'auth_token'=>$token,'message' => 'User Created Successfully','code'=>'True'),200);
            }
            else{
                return response()->json(array('user'=>$user,'token'=>$email_verification_OTP,'message' => 'There is somthing wrong','code'=>False),204);
            }

        }
        else{

            return response()->json([
                'error' => 'User already exists',
                'code' =>204
            ]);

        }

    }

    //registration from sso for app user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'company_name' => 'required',
            'sso_reference_id' =>'required',
            'phone'           => 'required',
            'country'=>'required'
        ]);
        $checkExistingUser=User::Where('email', $request->email)->first();
        if($checkExistingUser){
            return response()->json('user already exists', 403);
        }

        $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
        $user = User::create([
            'user_id'=>$user_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'buyer',
            'sso_reference_id' =>$request->sso_reference_id,
            'ip_address' => $request->ip(),
            'user_agent' => 'Dart',
            'phone'     => $request->phone,
            'company_name' => $request->company_name,
            'country' => $request->country,
            'designation'       => $request->designation,
            'business_type'     => $request->business_type,
            'company_website'   => $request->company_website,
            'linkedin_profile'  => $request->linkedin_profile,
            'is_supplier'  => $request->user_type == 'supplier' ? 1 : 0,
        ]);
        //if($request->user_type == 'buyer'){
            $business_profile_data=[
                'business_name' => $request->company_name,
                'alias'   => $this->createAlias($request->company_name),
                'user_id'       => $user->id,
                'business_type' => $request->business_type, // forcefully set Manufacturer type
                'has_representative'=> 1,
                'industry_type' => 'apparel',
            ];
            $business_profile=BusinessProfile::create($business_profile_data);
            $companyOverview=$this->createCompanyOverview($request,$business_profile->id);
        //}

        $email_verification_OTP = mt_rand(100000,999999);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $email_verification_OTP
          ]);
        $token=$user->createToken('merchantbayshop')->plainTextToken;
        event(new NewUserHasRegisteredEvent($user, $email_verification_OTP));


        if($user){
            return response()->json(array('user'=>$user,'token'=>$email_verification_OTP,'auth_token'=>$token,'message' => 'User Created Successfully','code'=>'True'),200);
        }
        else{
            return response()->json(array('user'=>$user,'token'=>$email_verification_OTP,'message' => 'There is somthing wrong','code'=>False),204);
        }


    }



    public function storeBk(Request $request)
    {

        if($request->user_type=='buyer')
        {
            $this->validateRequestForBuyer();
        }
        else
        {
            $this->validateRequestForWholesaler();
        }

        if($request->hasFile('image'))
        {
            $userEmail=$request->email;
            $uniqueUserName=[];
            $uniqueUserName=explode("@",$userEmail);
            $filename = $request->image->store('images/'.$uniqueUserName[0].'/profile','public');
            $image_resize = Image::make(public_path('storage/'.$filename));
            $image_resize->fit(250, 250);
            $image_resize->save(public_path('storage/'.$filename));
        }

        //generating unique user id uisng id generattor package
        $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);

        //for authenticated user
        if (Auth::check())
        {
            $created_by=auth()->user()->id;
        }

        //for unauthenticated user
        else
        {
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
        $token=$user->createToken('merchantbayshop')->plainTextToken;
        //$user=User::latest()->first();


        //after creating user will create vendor as weel as
        $date=Carbon::today()->toDateString();
        $date=Carbon::parse($date)->format('dmY');
        $number=mt_rand(0,9999999);
        $name= Str::slug($request->vendor_name,'-');
        $vendorUId='mbs-'.$name.'-'.$date.$number;

        $vendor = Vendor::create([
            'user_id'=>$user->id,
            'vendor_uid' => $vendorUId,
            'vendor_name' => $request->vendor_name,
            'vendor_address' => $request->vendor_address,
            'created_by'=>$user->id,
            'updated_by'=>NULL,
        ]);
        $email_verification_OTP = mt_rand(100000,999999);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $email_verification_OTP
          ]);

      //  event(new NewUserHasRegisteredEvent($user));

        Mail::send('emails.apiEmailVerificationEmail', ['token' => $email_verification_OTP], function($message) use($request){
            $message->to($request->email);
            $message->subject('Welcome to Merchantbay Shop');
        });

        if($vendor && $user){
            return response()->json(array('user'=>$user,'token'=>$email_verification_OTP,'auth_token'=>$token,'message' => 'User Created Successfully','code'=>'True'),200);
        }
        else{
            return response()->json(array('user'=>$user,'token'=>$email_verification_OTP,'message' => 'There is somthing wrong','code'=>False),204);
        }


    }

    public function verifyAccount($userId,$token)
    {
        $verifyUser = UserVerify::where('user_id',$userId)->where('token', $token)->first();
        $user=User::where('id',$userId)->first();
        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->is_email_verified) {

                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your email have been verified successfully. Please Click here to login";
            } else {
                $message = "Your email have been verified successfully.";
            }
            return response()->json(array('message' =>  $message,'code'=>'True','user'=>$user),200);
        }else{
            return response()->json(array('message' =>  $message,'code'=>'false','user'=>$user),200);

        }

    }

    public function resendVerificationEmail(Request $request){

        $user=User::where('email',$request->email)->first();
        $message="Email verfication mail has resent successfully";
        if($user && $user->is_email_verified==0){

            $verifyUser = UserVerify::where('user_id', $user->id)->first();
            Mail::send('emails.apiEmailVerificationEmail', ['token' => $verifyUser->token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });
            return response()->json(array('message' => $message,'code'=>'True'),200);
        }
        else{
            return response()->json(array('message' => "User not registered",'code'=>'false'),200);
        }

    }

    //delete single user by uisng unique user id
    public function destroy($userId)
    {
        $user = User::where('id',$userId)->first();
        if(isset($user)){
            $user->delete();
            return response()->json(array('message' => 'User Deleted Successfully','code'=>'True'),200);

        }else{
            return response()->json(array('message' => 'User Not found','code'=>'False'),204);

        }


    }

   //validate buyer registration from
    private function validateRequestForBuyer()
    {
        return request()->validate([
            'full_name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users',
            'phone'=> 'required',
            'vendor_name'=>'nullable',
            'vendor_address'=>'nullable',
            'password'=> 'required|string|min:8|confirmed',
            'user_type'=>'required|string',
            'image'=>'image|max:5000',
        ]);
    }

    //validate wholesaler registration from
    private function validateRequestForWholesaler()
    {
        return request()->validate([
            'full_name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users',
            'phone'=> 'required',
            'vendor_name'=>'required|unique:vendors',
            'vendor_address'=>'required',
            'password'=> 'required|string|min:8|confirmed',
            'user_type'=>'required|string',
            'image'=>'image|max:5000',
        ]);
    }

    public function login(Request $request){

        request()->validate([

            'email'=> 'required',
            'password'=> 'required',

        ]);
        if(env('APP_ENV') == 'production')
        {
            $sso=Http::post(env('SSO_URL').'/api/auth/token/',[
                'email' => $request->email,
                'password' => $request->password,
            ]);

        }

        if($sso->successful()){

            $user = User::where('email',$request->email)->first();
            $message = "Email verfication mail has resent successfully";
            $token=$user->createToken('merchantbayshop')->plainTextToken;
            if($user && $user->is_email_verified == 0 && Hash::check($request->password, $user->password)){

                $verifyUser = UserVerify::where('user_id', $user->id)->first();
                $email_verification_OTP = $email_verification_OTP = mt_rand(100000,999999);
                $verifyUser = UserVerify::where('user_id',$verifyUser->user_id)->update([
                    'user_id' => $user->id,
                    'token' => $email_verification_OTP
                ]);
                $verifyUser = UserVerify::where('user_id', $user->id)->first();

                Mail::send('emails.apiEmailVerificationEmail', ['token' => $verifyUser->token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Email Verification Mail');
                });
                return response()->json(array('message' => $message,'auth_token'=> $token,'sso_token'=>$sso['access'],'code'=>'True','user'=>$user),200);
                // return response()->json(array('message' => $message,'auth_token'=> $token,'code'=>'True','user'=>$user),200);
            }
            elseif($user && $user->is_email_verified == 1 && Hash::check($request->password, $user->password)){

                $user->update(['last_activity' => Carbon::now(),'fcm_token'=>$request->fcm_token]);
                return response()->json(['message'=>"Login successful",'user'=>$user,'auth_token'=> $token,'sso_token'=>$sso['access'],'code'=>"True"],201);
                // return response()->json(['message'=>"Login successful",'user'=>$user,'auth_token'=> $token,'code'=>"True"],201);

            }
            else{

                return response()->json(['message' => 'Wrong email or password','code'=>'False' ,'user'=>$user],401);

            }

        }
        else{

            return response()->json(['message' => 'Wrong email or password','code'=>'False'],401);

        }


    }

    //login without sso from app
    // public function login(Request $request){

    //     request()->validate([

    //         'email'=> 'required',
    //         'password'=> 'required',

    //     ]);

    //     $user = User::where('email',$request->email)->first();
    //     $message = "Email verfication mail has resent successfully";
    //     $token=$user->createToken('merchantbayshop')->plainTextToken;
    //     if($user && $user->is_email_verified == 0 && Hash::check($request->password, $user->password)){

    //         $verifyUser = UserVerify::where('user_id', $user->id)->first();
    //         $email_verification_OTP = $email_verification_OTP = mt_rand(100000,999999);
    //         $verifyUser = UserVerify::where('user_id',$verifyUser->user_id)->update([
    //             'user_id' => $user->id,
    //             'token' => $email_verification_OTP
    //         ]);
    //         $verifyUser = UserVerify::where('user_id', $user->id)->first();

    //         Mail::send('emails.apiEmailVerificationEmail', ['token' => $verifyUser->token], function($message) use($request){
    //             $message->to($request->email);
    //             $message->subject('Email Verification Mail');
    //         });
    //         return response()->json(array('message' => $message,'auth_token'=> $token,'code'=>'True','user'=>$user),200);
    //     }
    //     elseif($user && $user->is_email_verified == 1 && Hash::check($request->password, $user->password)){
    //         return response()->json(['message'=>"Login successful",'user'=>$user,'auth_token'=> $token,'code'=>"True"],201);
    //     }
    //     else{
    //         return response()->json(['message' => 'Wrong email or password','code'=>'False' ,'user'=>$user],401);
    //     }

    // }





    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json(['message'=>"Logout successful",'code'=>"true"],200);

    }


    public function updateImage(Request $request)
    {

        $user=User::where('id',$request->user_id)->first();
        if ($request->hasFile('image'))
        {
            $userEmail=$user->email;
            $uniqueUserName=[];
            $uniqueUserName=explode("@",$userEmail);
            $filename = $request->image->store('images/'.$uniqueUserName[0].'/profile','public');
            $image_resize = Image::make(public_path('storage/'.$filename));
            $image_resize->fit(250, 250);
            $image_resize->save(public_path('storage/'.$filename));
        }

        $user->image= $filename;
        $user->save();
        $message="Image uploaded successfully";
        return response()->json(['user'=>$user,'message'=>$message,'code'=>true],200);
    }

    public function verifyUserFromManufacture(Request $request){

        $user = User::where('email',$request->email)->first();
        if($user->is_email_verified == 1){
            return response()->json(['message' => 'already this email varified']);
        }
        if( $user ){
             $user->is_email_verified = 1;
             $user->save();
             return response()->json(['message'=>'user verified successfully'],200);
        }
        else{
             return response()->json(['message'=>'user verification failed'],204);
        }

    }
    //email verify
    public function emailVerify(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response()->json(['message'=>'user not exists'],404);
        }
        if($user->is_email_verified == 1){
            return response()->json(['message' => 'already this email have varified'],409);
        }
        $user->is_email_verified = 1;
        $user->save();
        return response()->json(['message'=>'user verified successfully'],200);

    }
    // user registration from sso
    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            // 'user_type' => 'required',
            'company_name' => 'required',
            'sso_reference_id' =>'required',
            //'phone'           => 'required',
            //'country'=>'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(array(
            'success' => false,
            'error' => $validator->getMessageBag()),
            400);
        }
        $checkExistingUser = User::Where('email', $request->email)->first();

        if($checkExistingUser){
            return response()->json('user already exists', 403);
        }
        $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
        $user = User::create([
            'user_id'=>$user_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'sso_reference_id' =>$request->sso_reference_id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'phone'     => $request->phone ?? null,
            'company_name' => $request->company_name,
            'country' => $request->country ?? null,
            'designation'       => $request->designation,
            'business_type'     => $request->business_type,
            'company_website'   => $request->company_website,
            'linkedin_profile'  => $request->linkedin_profile,
            'is_supplier'  => $request->user_type == 'supplier' ? 1 : 0,

        ]);
        // if($request->user_type == 'buyer'){
        //     $business_profile_data=[
        //         'business_name' => $request->company_name,
        //         'alias'   => $this->createAlias($request->company_name),
        //         'user_id'       => $user->id,
        //         'business_type' => 2, // forcefully set Manufacturer type
        //         'has_representative'=> 1,
        //         'industry_type' => 'apparel',
        //     ];
        //     $business_profile=BusinessProfile::create($business_profile_data);
        //     $companyOverview=$this->createCompanyOverview($request,$business_profile->id);
        // }

        // if user registration successful then we will create a business profile for the new user.
        $business_profile_data=[
            'business_name' => $user['company_name'],
            'alias'   => $this->createAlias($user['company_name']),
            'user_id'       => $user['id'],
            'profile_type'       => $request->user_type,
            'business_type' => $request->business_type, // set dynamic user type from sso response data.
            'has_representative'=> 1, // no representative
            'industry_type' => 'apparel',
        ];
        $business_profile = BusinessProfile::create($business_profile_data);
        $this->createCompanyOverview($request, $business_profile->id);

        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);
        if(env('APP_ENV') == 'production' && $request->user_flag == 'global')
        {
            event(new NewUserHasRegisteredEvent($user, $token));
        }

        return response()->json(['msg' => 'user created successfully'], 200);
    }


    public function removeSpecialCharacterFromAlais($alias)
    {
        $lowercase=strtolower($alias);
        $pattern= '/[^A-Za-z0-9\-]/';
        $preg_replace= preg_replace($pattern, '-', $lowercase);
        $single_hypen= preg_replace('/-+/', '-', $preg_replace);
        $alias= $single_hypen;
        return $alias;
    }


    public function createAlias($name)
    {
        $alias=$this->removeSpecialCharacterFromAlais($name);
        return $this->checkExistsAlias($alias);
    }

    public function checkExistsAlias($alias)
    {
        $check_exists=BusinessProfile::where('alias', $alias)->first();
        if($check_exists){
            $create_array= explode('-',$alias);
            $last_key=array_slice($create_array,-1,1);
            $last_key_string=implode(' ',$last_key);
            if(is_numeric($last_key_string)){
                $last_key_string++;
                array_pop($create_array);
                array_push($create_array,$last_key_string);
            }else{
                array_push($create_array,1);
            }
            $alias=implode("-",$create_array);
            return $this->checkExistsAlias($alias);

        }
        return $alias;
    }

    //company overview data
    public function createCompanyOverview(Request $request, $profile_id)
    {
        $name=['annual_revenue','number_of_worker','number_of_female_worker','trade_license_number','year_of_establishment','opertaing_hours','shift_details','main_products'];
        $value=[null,null,null,null,null,null,null,null,null];
        $data=[];
        foreach($name as $key => $value2){
            array_push($data,['name' => $value2, 'value' => $value[$key], 'status' => 0]);
        }
        $companyOverview=CompanyOverview::create([
            'business_profile_id' => $profile_id,
            'data'        => json_encode($data),
        ]);
        return $companyOverview;

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

        }
        return response()->json(["message"=>"notification marked as read successfully ","code"=>true],200);
    }

       //profile update from sso
        public function profileUpdate(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'email'   => 'required',
            ]);

            if($validator->fails()){
                return response()->json(array(
                'success' => false,
                'error' => $validator->getMessageBag()->toArray()),
                400);
            }

            $user=User::where('email', $request->email)->first();
            if($user){
                if(isset($request->password)){
                    $user->update([
                        'password' => bcrypt( $request->password),
                    ]);
                }
                $result = $user->update([
                    'name' => $request->name ?? $user->name,
                    'phone' => $request->phone ?? $user->phone,
                    'company_name' => $request->company ?? $user->company_name
                ]);
                if($result){
                    return response()->json([
                        'success' => true,
                        'message' =>'Profile updated successfully',
                        200]);
                }
                else{
                    return response()->json([
                        'success' => false,
                        'message' =>'Internal server error',
                        500]);

                }

            }
            else{
                return response()->json([
                    'success' => false,
                    'error' => 'user does not exit',
                    404]);
            }
        }


}
