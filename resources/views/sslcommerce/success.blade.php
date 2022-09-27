
@extends('layouts.app_containerless')

@section('content')
    <div id="main">
        <div class="row">
            <div class="main-content-area">
                <div class="container">
                    <div class="card">
                        <div class="card-content order-successful-payment-wrap">
                            <h4>Your payment is successfully done</h4>
                            {{-- @if(count($order_number) > 0)
                                <legend>Others Order Due for Payment</legend>
                                @foreach ($order_number as  $list)
                                <div class="confirm-order-row">
                                    <div class="confirm-order-row-left-block">
                                        <p>Your order number is: {{$list}}</p>
                                        <p>We've received your order. You have to pay first and after that you will receive a confirmation email.</p>
                                    </div>
                                    <div class="confirm-order-row-right-block">
                                        <a href="{{route('payment.page',$list)}}" class="btn waves-effect waves-light green">Pay Now</a>
                                    </div>
                                </div>
                                @endforeach
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

