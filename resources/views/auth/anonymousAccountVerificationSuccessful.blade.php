@extends('layouts.app')
@section('content')
<div class="login_landing_wrap center-align">
    <div class="container">
        <div class="login_landing_inner">
            <h1>You have successfully set your password</h1>
            <ul>
                <li>You can <a href="{{route('users.showLoginForm')}}">Login </a>to your account</li>
            </ul>
            <div class="login_landing_inner_right">&nbsp;</div>
        </div>
    </div>
</div>
@endsection
