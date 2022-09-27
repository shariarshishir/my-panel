@extends('layouts.app_anonymous')
@section('content')
<div class="welcome_wrap center-align">
    <div class="welcome_inner_wrap">
        <img class="logo-img" src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/logo.png" />
        <div class="welcome_inner">
            <h1>Welcome to the Merchant Bay</h1>
            <h5>Set your password to access your account</h5>
            <form method="POST" action="{{ route('anonymous.password.update') }}" onsubmit="return checkPasswordMatch()">
                @csrf
                <div class="row input-field">
                    <div class="col s12 m4 l3">
                        <label class="fs-xl" for="email">Email Address</label>
                    </div>
                    <div class="col s12 m8 l9">
                        <input type="text" name="user_email" class="form-control fs-xl" disabled="disabled" value="{{$decryptAuthInfo->email}}">
                    </div>
                </div>
                <div class="row input-field">
                    <div class="col s12 m4 l3">
                        <label class="fs-xl" for="password">Password</label>
                    </div>
                    <div class="col s12 m8 l9">
                        <input id="setpassword" name="newpassword" value="" placeholder="Enter your Password" type="password">
                        <span id="message"></span>
                    </div>
                </div>
                <div class="row input-field">
                    <div class="col s12 m4 l3">
                        <label class="fs-xl" for="confirmPassword">Retype-Password</label>
                    </div>
                    <div class="col s12 m8 l9">
                        <input id="confirmPassword" name="confirmPassword" value="" placeholder="Re-enter your Password" type="password">
                        <span id="notMatch"></span>
                    </div>
                </div>
                <input type="hidden" name="email" value="{{$decryptAuthInfo->email}}" />
                <input type="hidden" name="oldpassword" value="{{$decryptAuthInfo->password}}" />
                <div class="welcome_submit right">
                    <button class="btn_green btn_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function checkPasswordMatch(){

        let setPassword = document.getElementById('setPassword').value;
        let confirmPassword = document.getElementById('confirmPassword').value;
        let message = document.getElementById('message');

        if(setPassword == "" && confirmPassword == "") {
            document.getElementById('message').innerHTML='Please fill password';
            return false;
        }

        if(setPassword != "" && confirmPassword == "") {
            document.getElementById('message').innerHTML='';
            document.getElementById('notMatch').innerHTML='Please fill confirm password';
            return false;
        }

        if(setPassword == "" && confirmPassword != "") {
            document.getElementById('message').innerHTML='Please fill password';
            document.getElementById('notMatch').innerHTML='';
            return false;
        }

        if(setPassword!=confirmPassword)
        {
            document.getElementById('notMatch').innerHTML='Password did not match';
            return false;
        }

    }
</script>
@endpush
