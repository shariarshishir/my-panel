@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col s12">
            <div class="card card-with-padding">
                <legend>{{ __('Verify Email Message') }}</legend>
                <div class="card-body">
                    <p>{{ $message }}</p>
                    <a href="#login-register-modal" class="btn waves-effect waves-light green darken-1 login-register-btn large-screen modal-trigger">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
