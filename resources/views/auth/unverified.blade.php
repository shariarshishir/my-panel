@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-with-padding">
                <legend class="card-header">{{ __('Email Verification') }}</legend>

                <div class="card-body email_verification_info" style="text-align:center;">
                    <p>You need to confirm your account. We have sent you an activation link. Please check your email.</p>
                    <p>If you want to resend the activation link plesae <a href="javascript:void(0);" id="resend-email-validtion">click here</a></p>
                </div>
                <div id="resend-email-verification-form" style="display:none">
                    <div class="card-alert card cyan">
                        <div class="card-content white-text">
                            <p>INFO : Please provide your email address that you have used for the registration.</p>
                        </div>
                    </div>                
                    <form  action="{{route('resend.verification_email')}}" method="post">
                        <div class="input-field verification_email_wrap">
                            <label for="email">Email</label>
                            <div class="verification_email">
                                <i class="material-icons prefix">email</i>
                                <input type="text" name="email">
                                <button class="btn green email_send darken-1 waves-effect waves-light" type="submit">
                                    Submit 
                                    {{-- <i class="material-icons right">send</i> --}}
                                </button> 
                            </div>                       
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
