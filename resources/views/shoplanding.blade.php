
@extends('layouts.app_containerless')

@section('pagetitle', 'Merchant Bay, making fashion sourcing seamless through the e-supply chain platform.')
@section('title', 'Merchant Bay, making fashion sourcing seamless through the e-supply chain platform.')
@section('description', 'Merchant Bay is the best RMG sourcing platform in the world, where million of trusted suppliers are ready to serve you. You will get the best quality febrics, 3D designes, and samples as your requirements.')
@section('image', Storage::disk('s3')->url('public/frontendimages/merchantbay_logoX200.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Merchant Bay, making fashion sourcing seamless through the e-supply chain platform.')
@section('ogdescription', 'Merchant Bay is the best RMG sourcing platform in the world, where million of trusted suppliers are ready to serve you. You will get the best quality febrics, 3D designes, and samples as your requirements.')
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/merchantbay_logoX200.png'))

@section('robots', 'index, nofollow')
@php
$searchInput = isset($_REQUEST['search_input']) ? $_REQUEST['search_input'] : '';
@endphp
@section('content')

    <div class="container">
        <div class="row">
            <div class="col m12">




                <div class="profile_account_myrfq_info">
                    <div class="row">
                        <div class="row rfq_account_title_bar">
                            <div class="col s6">
                                <h4>{{$pageTitle}}</h4>
                            </div>
                            <div class="col s6 right-align">
                                <div class="input-field select_rfq_status">
                                    <select class="select2 browser-default">
                                        <option value="0">Select Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="accepted">Accepted</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col @php echo (count($rfqLists) > 0) ? "s12 m12 l7" : "s12 m12 l12"; @endphp">
                            <div class="product_design_wrapper">
                                {{-- <div class="profile_account_searchBar">
                                    <div class="row">
                                        <div class="col s12 m5 l4">
                                            <a class="post_new" href="{{route('rfq.create')}}">
                                                <i class="material-icons">add</i><span>Post New </span>
                                            </a>
                                        </div>
                                        <div class="col s12 m7 l8">
                                            <form action="{{route('new.profile.search_my_rfqs',$alias)}}" data-hs-cf-bound="true">
                                                @csrf
                                                <div class="profile_account_search">
                                                    <i class="material-icons">search</i>
                                                    <input class="profile_filter_search" type="search" name="search_input" value="{{$searchInput}}" placeholder="Search Merchant Bay Studio/Raw Material Libraries">
                                                    <a href="javascript:void(0);" class="reset_myrfq_filter" style="@php echo isset($_REQUEST['search_input']) ? 'display: block;' : 'display: none;' @endphp"><i class="material-icons">restart_alt</i></a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="profile_account_myrfq_innerbox">
                                    {{-- <div class="row rfq_account_title_bar">
                                        <div class="col s8">
                                            <h4>{{$pageTitle}}</h4>
                                        </div>
                                        <div class="col s4 right-align">
                                            <span class="rfqView">{{count($rfqLists)}} results</span>
                                        </div>
                                    </div> --}}

                                    <div class="row">
                                        <div class="col s12 m6">
                                            <div class="profile_account_myrfq_addPost">
                                                <a class="post_new" href="{{route('rfq.create')}}">
                                                    <i class="material-icons">add_circle_outline</i>
                                                    <h6>Create bew RFQ </h6>
                                                </a>
                                            </div>
                                        </div>
                                        @if($rfqLists)
                                            @foreach($rfqLists as $key => $rfq)
                                            <div class="col s12 m6">
                                                <div class="profile_account_myrfq_box rfq_box_{{$rfq['id']}} {{$key == 0 ? 'active' : ''}}">
                                                    <div class="rfq_status_wrap">
                                                        <div class="row">
                                                            @if(isset($rfq['pi_status']) && $rfq['pi_status'] == 0)
                                                                <span class="status pending_rfq">Pending</span>
                                                            @elseif(isset($rfq['pi_status']) && $rfq['pi_status'] == -1)
                                                                <span class="status rejected_rfq">Rejected</span>
                                                            @elseif(isset($rfq['pi_status']) && $rfq['pi_status'] == 1)
                                                                <span class="status accepted_rfq">Accepted</span>
                                                            @endif
                                                            {{-- <span class="status pending_rfq">RFQ Status 1</span> --}}
                                                            <span class="more_vert">
                                                                <a class="dropdown-trigger" href="javascript:void(0);" data-target="rfqStatusDropdown"><i class="material-icons">more_vert</i></a>
                                                                <ul id="rfqStatusDropdown" class="dropdown-content rfq_status_dropdown">
                                                                    <li><a href="javascript:void(0);">Remove</a></li>
                                                                    <li><a href="javascript:void(0);">Archive</a></li>
                                                                    <li><a href="javascript:void(0);">Option</a></li>
                                                                </ul>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <h5>{{$rfq['title']}}</h5>
                                                    <span class="posted_time">{{date('Y-m-d', strtotime($rfq['created_at']))}}</span>

                                                    <div class="row">
                                                        <div class="col s6 m6 l5">
                                                            <p>Quantity <br/> <b>{{$rfq['quantity']}} pcs</b></p>
                                                            <p>Target Price <br/> <b>{{$rfq['unit_price']}} / {{$rfq['unit']}}</b></p>
                                                        </div>
                                                        <div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>
                                                        <div class="col s6 m6 l5">
                                                            <p>Deliver in <br/> <b>{{ date('F j, Y',strtotime($rfq['delivery_time'])) }}</b></p>
                                                            <p>Deliver to <br/> <b>{{$rfq['destination']}}</b></p>
                                                        </div>
                                                    </div>
                                                    <div class="account_rfq_btn_wrap" >
                                                        <div class="rfq_btn_box">
                                                            <button class="btn_white rfq_btn quotation-button" data-rfq_id="{{$rfq['id']}}">Quotations</button>
                                                            @if($rfq['unseen_quotation_count'] >0)
                                                                <span class="unseen_quotation_count_{{$rfq['id']}}" data-unseen_quotation_count="{{$rfq['unseen_quotation_count']}}">{{$rfq['unseen_quotation_count']}}</span>
                                                            @else
                                                                <span style="display:none" class="unseen_quotation_count_{{$rfq['id']}}" data-unseen_quotation_count="{{$rfq['unseen_quotation_count']}}">{{$rfq['unseen_quotation_count']}}</span>
                                                            @endif
                                                        </div>
                                                        <div class="rfq_btn_box">
                                                            <button class="btn_white rfq_btn message-button" data-rfq_id="{{$rfq['id']}}">Messages</button>
                                                            @if(($rfq['unseen_count'] - $rfq['unseen_quotation_count']) >0)
                                                                <span  class="unseen_message_count_{{$rfq['id']}}" data-unseen_message_count="{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}">{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}</span>
                                                            @else
                                                                <span style="display:none" class="unseen_message_count_{{$rfq['id']}}" data-unseen_message_count="{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}">{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="card-alert card cyan">
                                                <div class="card-content white-text">
                                                    <p>No Queries are available.</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    @if( $noOfPages > 1)
                                    @php
                                        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
                                    @endphp
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="" href="javascript:void(0);" data-page="0" tabindex="-1">Previous</a>
                                            </li>
                                            @for( $i=1; $i <= $noOfPages; $i++)
                                                @php
                                                    $r = route('home');
                                                @endphp
                                                <li class="page-item {{ ($page == $i) ? 'active':'' }}">
                                                    <a href="{{ $r.'?page='.$i }}" data-page="{{$i}}">{{$i}}</a>
                                                </li>
                                            @endfor
                                            <li class="page-item">
                                                <a class="" href="javascript:void(0);" data-page="2">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    @endif

                                </div>
                            </div>
                        </div>


                        @if($rfqLists)
                        <div class="col s12 m12 l5 new_profile_account_rightsidebar_desktop">
                            <div class="new_profile_account_myrfq_details fixed-rfq-message-bar">
                                <div class="new_profile_myrfq_details_topbox">
                                    <h6>RFQ ID <span>{{$rfqLists[0]['id']}}</span></h6>
                                    <div class="titleBox">
                                        <h5>{{$rfqLists[0]['title']}} </h5>
                                        {{-- <span class="posted_time">{{date('Y-m-d', strtotime($rfqLists[0]['created_at']))}}</span> --}}
                                        <div class="center-align btn_accountrfq_info">
                                            <a class="accountrfq_btn" href="javascript:void(0);" onclick="">Show More</a>
                                        </div>
                                        <div id="accountRfqDetailesInfo" class="account_rfqDetailes_infoWrap" style="display: none;">
                                            <div class="row">
                                                <div class="col s6 m6 l5">
                                                    <p>Quantity <br/> <b>{{$rfqLists[0]['quantity']}} pcs</b></p>
                                                    <p>Target Price <br/> <b>{{$rfqLists[0]['unit_price']}} / {{$rfqLists[0]['unit']}}</b></p>
                                                </div>
                                                <div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>
                                                <div class="col s6 m6 l5">
                                                    <p>Deliver in <br/> <b>{{ date('F j, Y',strtotime($rfqLists[0]['delivery_time'])) }}</b></p>
                                                    <p>Deliver to <br/> <b>{{$rfqLists[0]['destination']}}</b></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <p>Description <br/> <b>{{$rfqLists[0]['full_specification']}}</b></p>
                                                </div>
                                            </div>
                                            <div class="account_rfqDetailes_imgWrap">
                                                <h6>Attachments</h6>
                                                @foreach ($rfqLists[0]['images'] as $rfqImg)
                                                <a href="{{$rfqImg['image']}}" data-fancybox>
                                                <img src="{{$rfqImg['image']}}" />
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rfq_review_results_wrap">
                                    <div class="rfq_review_results_nav">
                                        <ul>
                                            <li  class="active message_tab_li"><a href="javascript:void(0);" class="message_tab" data-rfq_id="{{$rfqLists[0]['id']}}">Messages</a></li>
                                            <li class="quotation_tab_li"><a href="javascript:void(0);" class="quotation_tab" data-rfq_id="{{$rfqLists[0]['id']}}">Quotations</a></li>
                                        </ul>
                                    </div>

                                    <div class="my_rfq_quotation_box" style="display:none">
                                        <div class="my_rfq_review_results_box">
                                            My Quotation will show here.
                                        </div>
                                    </div>

                                    <div class="rfq_quotation_box" style="display:none">
                                        <div class="rfq_review_results_box">

                                        </div>
                                    </div>

                                    <div class="rfq_message_box" >
                                        <div class="rfq_review_message_box">
                                            @if(count($chatdata)>0)
                                                @foreach($chatdata as $chat)
                                                    @if( $chat['from_id'] == auth()->user()->sso_reference_id && $chat['rfq_id'] == $rfqLists[0]['id'])
                                                        <div class="rfq_message_box chat-right right">
                                                            <div class="chat-text right-align">
                                                                <p><span> @php echo html_entity_decode($chat['message']); @endphp</span></p>
                                                            </div>
                                                        </div>
                                                    @elseif($chat['to_id'] == auth()->user()->sso_reference_id && $chat['rfq_id'] == $rfqLists[0]['id'])
                                                        <div class="rfq_message_box chat-left left">
                                                            <div class="chat-text left-align">
                                                                <p><span>@php echo html_entity_decode($chat['message']); @endphp</span></p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <form>
                                            <div class="rfq_message_box_bottom">
                                                <input class="message_type_box messagebox" type="text" placeholder="Type a message..." />

                                                <div class="message_icon_box">
                                                    <i class="material-icons">sentiment_satisfied</i>
                                                    <i class="material-icons">attach_file</i>
                                                    <i class="material-icons">image</i>
                                                    <a class="btn_green send messageSendButton">send</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                    </div>
                </div>



            </div>
        </div>
    </div>

    @include('new_business_profile.create_rfq_modal')
    @include('new_business_profile._rfq_scripts')
    @include('new_business_profile.share_modal')
@endsection
