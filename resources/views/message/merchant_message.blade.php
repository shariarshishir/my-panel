@extends('layout.app')
@section('page_title')
    {{ 'Merchant Bay | Merchant Message' }}
@endsection

@section('secondary-navbar')
    @include('partials.secondary-navbar')
@endsection

@section('contents')
    <br/><br/>
    <section class="ic-single-product-details ic-viewd-product">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 ic-r4q-title">
                    <h2>Merchant Message</h2>
                </div>
            </div>
        
            
            <div class="row">
                <div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-10">
                    <a href="{{ action('MessageController@message_center') }}" class="btn btn-default" style="background-color:#e3e3e3; padding: 14px 76px; border-radius: 10px; font-size:16px;"><i class="glyphicon glyphicon-paperclip"></i><br/>RFQ</a> &nbsp; &nbsp;
                    <a href="{{ action('MessageController@supplier_message') }}" class="btn btn-default" style="background-color:#e3e3e3; padding: 14px 60px; border-radius: 10px; font-size:16px;"><i class="glyphicon glyphicon-gift"></i><br/>Product</a> &nbsp; &nbsp;
                    <a href="{{ action('MessageController@rfq_merchant_message') }}" class="btn btn-default" style="background-color:#e3e3e3; padding: 14px 40px; border-radius: 10px; font-size:16px;"><i class="glyphicon glyphicon-envelope"></i><br/>RFQ Merchant </a> &nbsp; &nbsp;
                    <a href="{{ action('MessageController@merchant_message') }}" class="btn btn-default" style="background-color:#55A860; padding: 14px 26px; border-radius: 10px; font-size:16px;"><i class="glyphicon glyphicon-comment"></i><br/>Product Merchant </a>
                </div>
                <div class="col-xs-12 col-md-0"></div>
            </div>
        </div>
    </section>
    
    <section class="ic-message-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="ic-message-bar-title">
                        <p>Merchant</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="ic-message-bar-title">
                        <p>Messages</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="ic-messanger-wrapper">
        <merchant-message></merchant-message>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/jquery.tinyscrollbar.min.js') }}" type="application/javascript"></script>
    <script type="application/javascript">
        // Tinyscrollbar initialize
        // $("#messenger-tab-list").tinyscrollbar();
        $(document).ready(function()
        {
            var $scrollbar = $("#messengerList");
            var $scrollbar2 = $("#icSingleMessanger");

            $scrollbar.tinyscrollbar();
            $scrollbar2.tinyscrollbar();
        });
    </script>
@endsection
