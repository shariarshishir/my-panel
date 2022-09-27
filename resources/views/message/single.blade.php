@extends('layout.app')

@section('page_title')
    {{ 'Merchant Bay | Message' }}
@endsection

@section('style')
    <script src="{{ mix('js/app.js') }}" defer></script>
    <style>
        .icSingleMessanger{
            height: 100px;
            overflow-y: scroll;
        }
    </style>
@endsection

@section('contents')
    <section class="ic-single-product-details ic-viewd-product">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 ic-r4q-title">
                    <h2>Messege center</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="ic-message-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ic-message-bar-title">
                        <p>Messenger</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ic-messanger-wrapper">
        <div class="container">
            <div class="row ic-messanger-row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane singleMessageWrap active" id="1">
                            <div id="icSingleMessanger" v-chat-scroll>
                                <div class="viewport">
                                    <div class="ic-receiver-sender-col">
                                        <div class="ic-sender">
                                            <span class="ic-messenger-fig">
                                                <img src="{{ asset('images/sender.png') }}" title="" alt="">
                                            </span>
                                            <span class="ic-messenger-speech">Test Message</span>
                                        </div>
                                    </div>
                                    {{--<div class="ic-receiver-sender-col">--}}
                                        {{--<single-message v-for="message,index in chat.messages" :key="message.index" :user=chat.users[index] :message="message" :user_type=chat.user_types[index]></single-message>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                            <div class="ic-meesge-box" id="">
                                <form action="#" @submit.prevent="send">
                                    {{--<input type="text" placeholder="Type your message here..." v-model="message">--}}
                                    <textarea name="" cols="30" rows="3" placeholder="Type your message here..."></textarea>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{--<script src="{{ asset('js/jquery.tinyscrollbar.min.js') }}" type="application/javascript"></script>--}}
    {{--<script type="application/javascript">--}}
        {{--// Tinyscrollbar initialize--}}
        {{--// $("#messenger-tab-list").tinyscrollbar();--}}
        {{--$(document).ready(function()--}}
        {{--{--}}
            {{--var $scrollbar = $("#messengerList");--}}
            {{--var $scrollbar2 = $("#icSingleMessanger");--}}

            {{--$scrollbar.tinyscrollbar();--}}
            {{--$scrollbar2.tinyscrollbar();--}}
        {{--});--}}
    {{--</script>--}}
@endsection
