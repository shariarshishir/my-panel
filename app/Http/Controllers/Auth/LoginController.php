<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);
        // checking sso authentication
        if(env('APP_ENV') == 'production'){
            $this->ssoLogin($request);
        }


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    // checking sso authentication
    protected function ssoLogin(Request $request)
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
            return $this->sendFailedLoginResponse($request);
        }

    }


}
