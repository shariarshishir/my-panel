
@extends('layouts.app')


@section('content')
@include('sweet::alert')
{{-- @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif --}}

<div class="row">
    <div class="col m12">
        <div class="card card-with-padding order-confirmation-block">
            <legend>Order Confirmation</legend>
            <h4>Thank you for your order.</h4>
            @foreach ($order_number as  $list)
                <div class="confirm-order-row">
                    @if (isset($configArray['ten_percent_show_at']) && $configArray['ten_percent_show_at'] == 'frontend')
                        <div class="confirm-order-row-left-block">
                            <p>Your order number is: {{$list}}</p>
                            <p>We've received your order. You have to pay first and after that you will receive a confirmation email.</p>
                        </div>
                        <div class="confirm-order-row-right-block">
                            <a href="{{route('payment.page',$list)}}" class="btn waves-effect waves-light green">Pay Now</a>
                        </div>
                    @else
                        <div class="confirm-order-row-left-block">
                            <p>Your order number is: {{$list}}</p>
                            <p>We've received your order. We will be touch you within 24 hours.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
@section('js')


@endsection

