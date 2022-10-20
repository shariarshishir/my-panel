
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

                <div class="profile_account_myrfq_info my_rfq_new_layout_wrapper">
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

                    <!--div class="row">
                        <div class="col s12 m4 l4">
                            <div class="profile_account_myrfq_addPost">
                                <a class="post_new" href="{{route('rfq.create')}}">
                                    <i class="material-icons">add_circle_outline</i>
                                    <h6>Create new RFQ </h6>
                                </a>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            Test 2
                        </div>
                        <div class="col s12 m4 l4">
                            Test 3
                        </div>
                    </div-->

                    <div class="row">
                        <div class="col s12 m12 l12">
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
                                        <div class="col s12 m4 l4">
                                            <div class="profile_account_myrfq_addPost">
                                                <a class="post_new" href="{{route('rfq.create')}}">
                                                    <i class="material-icons">add_circle_outline</i>
                                                    <h6>Create new RFQ </h6>
                                                </a>
                                            </div>
                                        </div>
                                        @if($rfqLists)
                                            @foreach($rfqLists as $key => $rfq)
                                            <div class="col s12 m4 l4">
                                                <div class="account_myrfq_infoBox">
                                                    <div class="top_rfq_status">
                                                        <div class="row">
                                                            <div class="col s12 m6">
                                                                <div class="rfq_status_wrap">
                                                                    @if(isset($rfq['pi_status']) && $rfq['pi_status'] == 0)
                                                                        <span class="status pending_rfq">Pending</span>
                                                                    @elseif(isset($rfq['pi_status']) && $rfq['pi_status'] == -1)
                                                                        <span class="status rejected_rfq">Rejected</span>
                                                                    @elseif(isset($rfq['pi_status']) && $rfq['pi_status'] == 1)
                                                                        <span class="status accepted_rfq">Accepted</span>
                                                                    @endif
                                                                    {{-- <span class="status pending_rfq">RFQ Status 1</span> --}}
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m6">
                                                                <div class="more_vert_wrap">
                                                                    <span class="more_vert">
                                                                        <a class="dropdown-trigger" href="javascript:void(0);" data-target="rfqStatusDropdown-{{$rfq['id']}}"><i class="material-icons">more_vert</i></a>
                                                                    </span>
                                                                    <ul id="rfqStatusDropdown-{{$rfq['id']}}" class="dropdown-content rfq_status_dropdown">
                                                                        <li><a href="javascript:void(0);">Remove</a></li>
                                                                        <li><a href="javascript:void(0);">Archive</a></li>
                                                                        <li><a href="javascript:void(0);">Option</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="profile_account_myrfq_box rfq_box_{{$rfq['id']}} {{$key == 0 ? 'active' : ''}}" data-rfq_id="{{$rfq['id']}}">
                                                        <div class="rfq_top_content">
                                                            <div class="rfq_img_content">
                                                                <div class="rfq_img_overlay"></div>
                                                                @if(isset($rfq['images'][0]['image']))
                                                                    @php
                                                                        $imgFullpath = explode('/', $rfq['images'][0]['image']);
                                                                        $imgExt = end($imgFullpath);
                                                                    @endphp
                                                                    @if(pathinfo($imgExt, PATHINFO_EXTENSION) == 'pdf' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'PDF')
                                                                        <span class="pdf_icon">&nbsp;</span>
                                                                    @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'doc' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'docx')
                                                                        <span class="doc_icon">&nbsp;</span>
                                                                    @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'xlsx' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'xls')
                                                                        <span class="xlsx_icon">&nbsp;</span>
                                                                    @else
                                                                        <center><img src="{{$rfq['images'][0]['image']}}" alt="RFQ Image" style="height: 255px;" /></center>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <h5>{{$rfq['title']}}</h5>
                                                        </div>
                                                        <span class="posted_time">
                                                            <i class="material-icons">access_time</i>
                                                            <span class="posted_time_content">Posted - {{date('M j, Y', strtotime($rfq['created_at']))}}</span>
                                                        </span>
                                                        <div class="row rfq_info_details">
                                                            <div class="col s6 m3">
                                                                <p><span class="details_label">Quantity</span> <br/> <span class="details_value"><b> {{$rfq['quantity']}} <span>{{$rfq['unit']}}</span></b></span></p>
                                                            </div>
                                                            <div class="col s6 m3">
                                                                <p><span class="details_label">Target Price</span> <br/> <span class="details_value"><b>{{$rfq['unit_price']}} / <span>{{$rfq['unit']}}</span></b></span></p>
                                                            </div>
                                                            {{-- <div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div> --}}
                                                            <div class="col s6 m3">
                                                                <p><span class="details_label">Deliver in</span> <br/> <span class="details_value"><b>{{ date('M j, Y',strtotime($rfq['delivery_time'])) }}</b></span></p>
                                                            </div>
                                                            <div class="col s6 m3">
                                                                <p><span class="details_label">Deliver to</span> <br/> <span class="details_value"><b>{{$rfq['destination']}}</b></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="account_rfq_btn_wrap row">
                                                        <div class="rfq_btn_box rfq_quotation_button_wrapper col s6 m6 l6">
                                                            <button class="btn_white rfq_btn quotation-button" data-rfq_id="{{$rfq['id']}}">Quotations</button>
                                                            @if($rfq['unseen_quotation_count'] >0)
                                                                <span class="unseen_quotation_count_{{$rfq['id']}}" data-unseen_quotation_count="{{$rfq['unseen_quotation_count']}}">{{$rfq['unseen_quotation_count']}}</span>
                                                            @else
                                                                <span style="display:none" class="unseen_quotation_count_{{$rfq['id']}}" data-unseen_quotation_count="{{$rfq['unseen_quotation_count']}}">{{$rfq['unseen_quotation_count']}}</span>
                                                            @endif
                                                        </div>
                                                        <div class="rfq_btn_box rfq_message_button_wrapper col s6 m6 l6">
                                                            <button class="btn_white rfq_btn message-button" data-rfq_id="{{$rfq['id']}}">Messages</button>
                                                            @if(($rfq['unseen_count'] - $rfq['unseen_quotation_count']) >0)
                                                                <span  class="unseen_message_count_{{$rfq['id']}}" data-unseen_message_count="{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}">{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}</span>
                                                            @else
                                                                <span style="display:none" class="unseen_message_count_{{$rfq['id']}}" data-unseen_message_count="{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}">{{$rfq['unseen_count'] - $rfq['unseen_quotation_count']}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="new_rfq_details_wrapper_outer" id="rfqDetailsRightSlider">
                                                        <div class="new_rfq_details_empty_area"></div>
                                                        <div class="new_rfq_details_inner">
                                                            <div class="close_rfq_details_box">
                                                                <a href="javascript:void(0);" class="rfq_chat_details_close_trigger btn_white">Close <i class="material-icons">close</i></a>
                                                            </div>
                                                            <h3>{{$rfq['title']}}</h3>
                                                            <p><b>Description:</b> <span>{{$rfq['short_description']}}</span></p>
                                                            <p><b>Quantity:</b> <span>{{$rfq['quantity']}} / {{$rfq['unit']}} </span></p>
                                                            <p><b>Target Price:</b> <span>{{$rfq['unit_price']}} / {{$rfq['unit']}} </span></p>
                                                            <p><b>Deliver in:</b> <span>{{ date('F j, Y',strtotime($rfq['delivery_time'])) }}</span></p>
                                                            <p><b>Deliver to:</b> <span>{{$rfq['destination']}}</span></p>
                                                            <p><b>Payment Method:</b> <span>{{$rfq['payment_method']}}</span></p>
                                                            <p><b>Category:</b> <span> @foreach ($rfq['category'] as $catItem) {{$catItem['name']}} @endforeach </span></p>
                                                            <div class="rfqImagesBox">
                                                                @if(isset($rfq['images']))
                                                                    @foreach ($rfq['images'] as $rfqDetailsImg)
                                                                        @php
                                                                            $imgFullpath = explode('/', $rfqDetailsImg['image']);
                                                                            $imgExt = end($imgFullpath);
                                                                        @endphp
                                                                        @if(pathinfo($imgExt, PATHINFO_EXTENSION) == 'pdf' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'PDF')
                                                                            <a href="{{$rfqDetailsImg['image']}}" target="_blank"><span class="pdf_icon">&nbsp;</span></a>
                                                                        @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'doc' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'docx')
                                                                            <a href="{{$rfqDetailsImg['image']}}" target="_blank"><span class="doc_icon">&nbsp;</span></a>
                                                                        @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'xlsx' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'xls')
                                                                            <a href="{{$rfqDetailsImg['image']}}" target="_blank"><span class="xlsx_icon">&nbsp;</span></a>
                                                                        @else
                                                                            <a data-fancybox="rfq-details-product-img-{{$rfq['id']}}" href="{{$rfqDetailsImg['image']}}"><img src="{{$rfqDetailsImg['image']}}" alt="RFQ Image" style="height: 255px;" /></a>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>

                                                            <div class="account_rfq_btn_wrap row">
                                                                <div class="rfq_btn_box rfq_quotation_button_wrapper col s6 m6 l6">
                                                                    <button class="btn_white rfq_btn quotation-button" data-rfq_id="{{$rfq['id']}}">Quotations</button>
                                                                    @if($rfq['unseen_quotation_count'] >0)
                                                                        <span class="unseen_quotation_count_{{$rfq['id']}}" data-unseen_quotation_count="{{$rfq['unseen_quotation_count']}}">{{$rfq['unseen_quotation_count']}}</span>
                                                                    @else
                                                                        <span style="display:none" class="unseen_quotation_count_{{$rfq['id']}}" data-unseen_quotation_count="{{$rfq['unseen_quotation_count']}}">{{$rfq['unseen_quotation_count']}}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="rfq_btn_box rfq_message_button_wrapper col s6 m6 l6">
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
                        <div class="new_profile_account_rightsidebar_desktop rfq_chat_box_wrapper" style="display: none;">
                            <div class="new_rfq_chat_details_empty_area"></div>
                            <div class="new_rfq_chat_inner">
                                <div class="close_rfq_chat_box">
                                    <a href="javascript:void(0);" class="rfq_chat_box_close_trigger btn_white">Close<i class="material-icons">close</i></a>
                                </div>
                                <div class="new_profile_account_myrfq_details fixed-rfq-message-bar">
                                    <div class="new_profile_myrfq_details_topbox">
                                        {{-- <h6>RFQ ID <span>{{$rfqLists[0]['id']}}</span></h6> --}}
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
                                                        {{-- <i class="material-icons">sentiment_satisfied</i> --}}
                                                        <i class="material-icons">attach_file</i>
                                                        {{-- <i class="material-icons">image</i> --}}
                                                        <a class="btn_green send messageSendButton">send</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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
    @include('new_business_profile._rfq_landing_scripts')
    @include('new_business_profile.share_modal')
@endsection
