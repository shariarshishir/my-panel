@extends('layouts.app_containerless')
@section('content')
@php
$searchInput = isset($_REQUEST['search_input']) ? $_REQUEST['search_input'] : '';
@endphp
<div class="account_profile_wrapper">
    <div class="account_profile_menu">
        <div class="container">
            <div class="profile_account_desktop_menu">
                @include('new_business_profile.profile_menu')
            </div>

            <div class="profile_account_mobile_menu" style="display: none;">
                <div class="row">
                    <div class="col s12">
                        <div class="profile_account_rightbar">
                            <a onclick="openProfileAccountNav()" href="javascript:void(0);" class="btn-product-sidenav"><i class="material-icons">filter_alt</i></a>
                        </div>
                    </div>
                    <div class="col s12">
                        <ul class="collapsible">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">menu</i></div>
                                <div class="collapsible-body">
                                    @include('new_business_profile.profile_menu')
                                </div>
                            </li>
                            </ul>
                    </div>
                </div>

                <div id="profileAccountRight">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeProfileAccountNav()"><i class="material-icons">clear</i></a>

                    <div class="new_profile_account_rightsidebar_mobile">
                        @if($rfqLists)
                        <div class="new_profile_account_myrfq_details">
                            <div class="new_profile_myrfq_details_topbox">
                                <h6>RFQ ID <span>{{$rfqLists[0]['id']}}</span></h6>
                                <h5>{{$rfqLists[0]['title']}}</h5>
                                <span class="posted_time">{{date('Y-m-d', strtotime($rfqLists[0]['created_at']))}}</span>
                                @if($pageTitle == "My Queries")
                                <span class="quotation_html"><span class="quotation_label">Your submitted quotation on this RFQ:</span> $ {{$quotationOffer}} / {{$quotationOfferunit}}</span>
                                @endif

                                <div class="center-align btn_accountrfq_info">
                                    <a class="accountrfq_btn" href="javascript:void(0);" onclick="">Show More</a>
                                </div>
                                <div id="accountRfqDetailesInfoMobile" class="account_rfqDetailes_infoWrap" style="display: none;">
                                    @if($pageTitle == "My Queries")
                                    <div class="row">
                                        <div class="col s6 m6 l5">
                                            <p>Quantity <br/> <b>{{$rfqLists[0]['quantity']}} pcs</b></p>
                                            <p>Deliver to <br/> <b>{{$rfqLists[0]['destination']}}</b></p>
                                        </div>
                                        <div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>
                                        <div class="col s6 m6 l5">
                                            <p>Deliver in <br/> <b>{{ date('F j, Y',strtotime($rfqLists[0]['delivery_time'])) }}</b></p>
                                        </div>
                                    </div>
                                    @else
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
                                    @endif
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
                            <div class="rfq_review_results_wrap">
                                <div class="rfq_review_results_nav">
                                    <ul>
                                        <li  class="active message_tab_li"><a href="javascript:void(0);" class="message_tab" data-rfq_id="{{$rfqLists[0]['id']}}">Messages</a></li>
                                        <li class="quotation_tab_li"><a href="javascript:void(0);" class="quotation_tab" data-rfq_id="{{$rfqLists[0]['id']}}">Quotations</a></li>
                                    </ul>
                                </div>
                                <div class="rfq_quotation_box" style="display:none">
                                    <div class="rfq_review_results_box">

                                    </div>
                                </div>

                                <div class="rfq_message_box" >
                                    <div class="rfq_review_message_box">
                                        @if(count($chatdata)>0)
                                            @foreach($chatdata as $chat)
                                                @if( $chat['from_id'] == auth()->user()->sso_reference_id )
                                                    <div class="rfq_message_box chat-right right">
                                                        <div class="chat-text right-align">
                                                            <p><span> @php echo html_entity_decode($chat['message']); @endphp</span></p>
                                                        </div>
                                                    </div>
                                                @else
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="profile_account_innerinfo_wrap">
        <div class="container">
            <div class="account_profile_box">
                <div class="row">
                    <div class="col s12 m3 l2">
                        <div class="account_item_menu">
                            <ul>
                                <li class="profile_explore {{ Route::is('new.profile.rfqs', $alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.rfqs', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Explore</h4>
                                    </a>
                                </li>
                                <li class="profile_my_rfq {{ Route::is('new.profile.my_rfqs', $alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.my_rfqs', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>My RFQs</h4>
                                    </a>
                                </li>
                                @if($business_profile->business_type == "manufacturer" || $business_profile->business_type == "wholesaler" || $business_profile->business_type == "design_studio")
                                <li class="profile_my_rfq {{ Route::is('new.profile.all_queries', $alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.all_queries', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Queries</h4>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m9 l10">

                        <div class="profile_account_myrfq_info">
                            <div class="row">
                                <div class="@php echo($rfqLists) ? "col s12 m12 l7" : "col s12 m12 l12" @endphp">
                                    <div class="product_design_wrapper">
                                        <div class="profile_account_searchBar">
                                            <div class="row">
                                                <div class="col s12 m5 l4">
                                                    <a class="post_new" href="{{route('rfq.create')}}">
                                                        <i class="material-icons">add_circle_outline</i><span>Create New RFQ</span>
                                                    </a>
                                                </div>
                                                <div class="col s12 m7 l8">
                                                    @if($pageTitle == "My RFQs")
                                                        <form action="{{route('new.profile.search_my_rfqs',$alias)}}">
                                                            @csrf
                                                            <div class="profile_account_search">
                                                                <i class="material-icons">search</i>
                                                                <input class="profile_filter_search"  type="search" name="search_input" value="{{$searchInput}}" placeholder="Search Merchant Bay Studio/Raw Material Libraries" />
                                                                <a href="javascript:void(0);" class="reset_myrfq_filter" style="@php echo isset($_REQUEST['search_input']) ? 'display: block;' : 'display: none;' @endphp"><i class="material-icons">restart_alt</i></a>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <form action="{{route('new.profile.search_my_queries',$alias)}}">
                                                            @csrf
                                                            <div class="profile_account_search">
                                                                <i class="material-icons">search</i>
                                                                <input class="profile_filter_search"  type="search" name="search_input" value="{{$searchInput}}" placeholder="Search Merchant Bay Studio/Raw Material Libraries" />
                                                                <a href="javascript:void(0);" class="reset_myquery_filter" style="@php echo isset($_REQUEST['search_input']) ? 'display: block;' : 'display: none;' @endphp"><i class="material-icons">restart_alt</i></a>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile_account_myrfq_innerbox">

                                            <div class="row rfq_account_title_bar">
                                                <div class="col s8">
                                                    <h4>{{$pageTitle}}</h4>
                                                    @if($pageTitle == "My Queries")
                                                    <ul class="queires_type_list">
                                                        <li class="profile_my_rfq {{ Route::is('new.profile.all_queries', $alias) ? 'active' : ''}}">
                                                            <a href="{{route('new.profile.all_queries', $alias)}}">All</a>
                                                        </li>
                                                        <li class="queires_type_list_separator">/</li>
                                                        <li class="profile_my_rfq {{ Route::is('new.profile.my_queries', $alias) ? 'active' : ''}}">
                                                            <a href="{{route('new.profile.my_queries', $alias)}}">Inbox</a>
                                                        </li>
                                                    </ul>
                                                    @endif
                                                </div>
                                                <div class="col s4 right-align">
                                                    <span class="rfqView">{{count($rfqLists)}} results</span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                @if($rfqLists)
                                                    @foreach($rfqLists as $key=>$rfq)
                                                    <div class="col s12 m6">
                                                        <div class="profile_account_myrfq_box rfq_box_{{$rfq['id']}} {{$key == 0 ? 'active' : ''}}">
                                                            <h5>{{$rfq['title']}}</h5>
                                                            <span class="posted_time">{{date('Y-m-d', strtotime($rfq['created_at']))}}</span>
                                                            @if($pageTitle == "My Queries")
                                                            <div class="row">
                                                                <div class="col s6 m6 l5">
                                                                    <p>Quantity <br/> <b>{{$rfq['quantity']}} pcs</b></p>
                                                                    <p>Deliver to <br/> <b>{{$rfq['destination']}}</b></p>
                                                                </div>
                                                                <div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>
                                                                <div class="col s6 m6 l5">
                                                                    <p>Deliver in <br/> <b>{{ date('F j, Y',strtotime($rfq['delivery_time'])) }}</b></p>
                                                                </div>
                                                            </div>
                                                            <div class="account_rfq_btn_wrap" >
                                                                <div class="rfq_btn_box">
                                                                    <a href="#rfq-quotation-modal" class="btn_white rfq_btn send-quotation-button modal-trigger" data-rfq_id="{{$rfq['id']}}" style="display: inline;">Quotations</a>
                                                                    <div id="rfq-quotation-modal" class="modal modal-fixed-footer">
                                                                        <div class="modal-content" style="text-align: left;">
                                                                            <legend>{{$rfq['id']}}</legend>
                                                                            <div class="propose_price_block">
                                                                                <div class="row">
                                                                                    <div class="col s12 m6 input-field">
                                                                                        <div class="print_block">
                                                                                            <label>Offer Price ($)</label>
                                                                                            <div class="propose_price_input_block">
                                                                                                <input type="number" value="" name="offer_price" class="propose_price">
                                                                                                <input type="hidden" name="bid_businessprofilename" value="{{$business_profile->business_name}}" />
                                                                                                <input type="hidden" name="bid_businessprofileid" value="{{$business_profile->id}}" />
                                                                                                <input type="hidden" name="bid_rfqid" value="{{$rfq['id']}}" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col s12 m6 input-field">
                                                                                        <div class="uom_block">
                                                                                            <label>Price Unit</label>
                                                                                                <select name="offer_price_unit" class="propose_uom form-select form-control">
                                                                                                <option value="" selected="true" disabled="">Choose your option</option>
                                                                                                <option value="Pcs">Pcs</option>
                                                                                                <option value="Lbs">Lbs</option>
                                                                                                <option value="Gauge">Gauge</option>
                                                                                                <option value="Yard">Yards</option>
                                                                                                <option value="Kg">Kg</option>
                                                                                                <option value="Meter">Meter</option>
                                                                                                <option value="Dozens">Dozens</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
                                                                            <a href="javascript:void(0);" class="waves-effect waves-green btn-flat rfq-bid-send-trigger">Submit</a>
                                                                        </div>
                                                                    </div>
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
                                                            @else
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
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @else
                                                <div class="card-alert card cyan">
                                                    <div class="card-content white-text">
                                                        <p>No Queries are available.</p>
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
                                                        @if($pageTitle == "My RFQs" && $pageActive == "RFQ")
                                                            @for( $i=1; $i <= $noOfPages; $i++)
                                                                @php
                                                                    $r=route('new.profile.my_rfqs', $alias);
                                                                @endphp
                                                                <li class="page-item" >
                                                                    <a class="" href="{{ $r.'?page='.$i }}" {{ ($page == $i) ? 'selected="selected"':'' }} data-page="{{$i}}">{{$i}}</a>
                                                                </li>
                                                            @endfor
                                                        @elseif ($pageTitle == "My Queries" && $pageActive == "Inbox")
                                                            @for( $i=1; $i <= $noOfPages; $i++)
                                                                @php
                                                                    $r=route('new.profile.my_queries', $alias);
                                                                @endphp
                                                                <li class="page-item" >
                                                                    <a class="" href="{{ $r.'?page='.$i }}" {{ ($page == $i) ? 'selected="selected"':'' }} data-page="{{$i}}">{{$i}}</a>
                                                                </li>
                                                            @endfor
                                                        @else
                                                            @for( $i=1; $i <= $noOfPages; $i++)
                                                                @php
                                                                    $r=route('new.profile.all_queries', $alias);
                                                                @endphp
                                                                <li class="page-item" >
                                                                    <a class="" href="{{ $r.'?page='.$i }}" {{ ($page == $i) ? 'selected="selected"':'' }} data-page="{{$i}}">{{$i}}</a>
                                                                </li>
                                                            @endfor
                                                        @endif
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
                                            <h5>{{$rfqLists[0]['title']}}</h5>
                                            <span class="posted_time">{{date('Y-m-d', strtotime($rfqLists[0]['created_at']))}}</span>
                                            @if($pageTitle == "My Queries")
                                                @if($quotationOffer)
                                                <span class="quotation_html"><span class="quotation_label">Your submitted quotation on this RFQ:</span> $ {{$quotationOffer}} / {{$quotationOfferunit}}</span>
                                                @else
                                                <span class="quotation_html"><span class="quotation_label">No quotation submitted.</span></span>
                                                @endif
                                            @endif

                                            <div class="center-align btn_accountrfq_info">
                                                <a class="accountrfq_btn" href="javascript:void(0);" onclick="">Show More</a>
                                            </div>
                                            <div id="accountRfqDetailesInfo" class="account_rfqDetailes_infoWrap" style="display: none;">
                                                @if($pageTitle == "My Queries")
                                                <div class="row">
                                                    <div class="col s6 m6 l5">
                                                        <p>Quantity <br/> <b>{{$rfqLists[0]['quantity']}} pcs</b></p>
                                                        <p>Deliver to <br/> <b>{{$rfqLists[0]['destination']}}</b></p>
                                                    </div>
                                                    <div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>
                                                    <div class="col s6 m6 l5">
                                                        <p>Deliver in <br/> <b>{{ date('F j, Y',strtotime($rfqLists[0]['delivery_time'])) }}</b></p>
                                                    </div>
                                                </div>
                                                @else
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
                                                @endif
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
                                        <div class="rfq_review_results_wrap">
                                            <div class="rfq_review_results_nav">
                                                <ul>
                                                    <li  class="active message_tab_li"><a href="javascript:void(0);" class="message_tab" data-rfq_id="{{$rfqLists[0]['id']}}">Messages</a></li>
                                                    @if($pageTitle == "My Queries")
                                                    <li class="quotation_tab_li" style="display: none;"><a href="javascript:void(0);" class="my_quotation_tab" data-rfq_id="{{$rfqLists[0]['id']}}">Quotations</a></li>
                                                    @else
                                                    <li class="quotation_tab_li"><a href="javascript:void(0);" class="quotation_tab" data-rfq_id="{{$rfqLists[0]['id']}}">Quotations</a></li>
                                                    @endif
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

        </div>
    </div>
</div>
@include('new_business_profile.create_rfq_modal')
@include('new_business_profile._rfq_scripts')
@include('new_business_profile.share_modal')
@endsection
