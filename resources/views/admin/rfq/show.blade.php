@extends('layouts.admin')
@section('content')

@if(auth()->guard('admin')->user()->unreadNotifications)
    @foreach (auth()->guard('admin')->user()->unreadNotifications as $notification)
        @if($notification->type == "App\Notifications\NewRfqNotification")
            @if($notification->data['rfq_data']['id']== $rfq['id'])
               {{  $notification->markAsRead(); }}
            @endif
        @endif
    @endforeach
@endif

@php
    $requestUrl = Request::url();
    $requestUrl = explode("/", $requestUrl);
    $requestUrl = end($requestUrl);
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Rfq Details </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content admin_rfq_wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="rfq_admin_chat_topwrap">
                            <div class="rfq_chat_top">
                                <span class="chat_idBox">RFQ ID: <span class="rfq_id">{{$rfq['id']}}</span></span>
                                <div class="chat_top_right">
                                    <ul>
                                        @if($rfq['rfq_from']=='product')
                                            @if(isset($rfq['product_flag']) && isset($rfq['product_id']))
                                                <li><a href="{{ route('mix.product.details', [$rfq['product_flag'], $rfq['product_id']]) }}" target="_blank">View Product Details</a></li>
                                            @endif
                                        @endif

                                        @if(isset($profromaInvoice) && $profromaInvoice->status == -1)
                                        <li class="pi_rejected_status" style="color: red;">Rejected</li>
                                        @endif

                                        @if(isset($profromaInvoice) && $profromaInvoice->status == 0)
                                        <li class="pi_rejected_status" style="color: #ffc107;">PI Genarated waiting for buyer approval</li>
                                        @endif

                                        @if(isset($profromaInvoice) && $profromaInvoice->status == 1)
                                        <li class="active"><a href="{{route('proforma_invoices.show',$profromaInvoice->id)}}" class="btn_grBorder yellow_btn">View PO</a></li>
                                        @elseif(isset($profromaInvoice) && $profromaInvoice->status == -1)
                                        <li class="active"><a href="{{ route('proforma_invoices.edit',[ 'buyerId' => $buyer->id,'rfqId'=>$rfq['id'],'proformaId'=>$profromaInvoice->id ]) }}" class="btn_grBorder">Re-generate PI</a></li>
                                        @elseif(isset($profromaInvoice) && $profromaInvoice->status == 0)
                                        <li class="active"><a href="{{ route('proforma_invoices.edit',[ 'buyerId' => $buyer->id,'rfqId'=>$rfq['id'],'proformaId'=>$profromaInvoice->id ]) }}" class="btn_grBorder">Re-generate PI</a></li>
                                        <li class="active"><a href="{{route('proforma_invoices.show',$profromaInvoice->id)}}" class="btn_grBorder">View PI</a></li>
                                        @else
                                        <li class="active"><a href="{{ route('proforma_invoices.create',['buyerId' => $buyer->id,'rfqId'=>$rfq['id']]) }}" class="btn_grBorder">Generate PI</a></li>
                                        @endif

                                        <li>
                                            <form method="POST" id="rfq_status_form" action="{{route('admin.rfq.status', $rfq['id'])}}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{$rfq['status']}}">
                                                <input type="hidden" name="rfq_selected_tag_type" value="@foreach($rfq['category'] as $tag) {{$tag['name']}} @if(!$loop->last) , @endif  @endforeach" />
                                                <input type="hidden" name="rfq_selected_factory_type" value="@foreach(array_unique($factory_type_as_tag_parent) as $factorytype) {{$factorytype}} @if(!$loop->last) , @endif  @endforeach" />

                                                <div class="modal fade" id="rfq-published-type-modal" tabindex="-1" role="dialog" aria-labelledby="rfq-published-type-modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 30%;">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Please Select</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align: left;">
                                                            <h6>Published this RFQ :</h6>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="publish_type" id="publish_type1" value="only_on_tags">
                                                                <label class="form-check-label" for="exampleRadios1">
                                                                    Tags - <span style="color: #4E9C52;">@foreach($rfq['category'] as $category) {{$category['name']}} @if(!$loop->last) , @endif  @endforeach</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="publish_type" id="publish_type2" value="only_on_factories">
                                                                <label class="form-check-label" for="exampleRadios1">
                                                                    Factories - <span style="color: #4E9C52;">@foreach(array_unique($factory_type_as_tag_parent) as $factorytype) {{$factorytype}} @if(!$loop->last) , @endif  @endforeach</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="publish_type" id="publish_type3" value="on_both_type">
                                                                <label class="form-check-label" for="exampleRadios1">
                                                                    Both
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary rfq-status-form-submit-trigger">Submit</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button data-toggle="modal" data-target="#rfq-published-type-modal" class="{{ ($rfq['status'] == 'pending') ? 'btn_grBorder' : 'btn_grBorder'; }} rfq-status-trigger"  type="button" {{ ($rfq['status'] == 'pending') ? '' : 'disabled'; }}> {{ ($rfq['status'] == 'pending') ? 'Make it Published' : 'Make it Unpublished' }}</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="rfq_chat_info">
                                <div class="chat_pro_infobox">
                                    <div class="chat_info_leftWrap">
                                        <div class="chat_info_left">
                                            <div class="pro_omg">
                                                @if($rfq['user']['user_picture'])
                                                    <img src="{{ $rfq['user']['user_picture'] }}" alt="">
                                                @else
                                                    <span class="no-image-text">{{ $userNameShortForm }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="chat_info_right">
                                            <h3>{{$rfq['user']['user_name']}}</h3>
                                            <p>{{$rfq['user']['email']}}, <br/> {{$rfq['user']['phone']}}</p>
                                        </div>
                                    </div>
                                    <div class="chat_info_rightWrap">
                                        <span><i class="fa fa-clock"></i> {{ \Carbon\Carbon::parse($rfq['created_at'])->isoFormat('MMMM Do YYYY')}}</span>
                                    </div>
                                </div>
                                <div class="infoBox">
                                    <h6>{{$rfq['title']}}</h6>
                                    <p><b> Query:</b> For  @foreach($rfq['category'] as $category) {{$category['name']}} @if(!$loop->last) , @endif  @endforeach</p>
                                    <span style="display: flex;"><p><b>Details:</b></p> {!! $rfq['full_specification'] !!}</span>
                                    <p><b>Qty:</b> {{$rfq['quantity']}} {{$rfq['unit']}}, Target Price: @if($rfq['unit_price']==0) Negotiable @else $ {{$rfq['unit_price']}} @endif, Deliver To: {{$rfq['destination']}}, Within: {{\Carbon\Carbon::parse($rfq['delivery_time'], 'UTC')->isoFormat('MMMM Do YYYY')}}, Payment Method: {{$rfq['payment_method']}}</p>
                                    @if(isset($rfq['images']))
                                        <div class="rfq_image">
                                            @foreach($rfq['images'] as $image)
                                                @php
                                                    $imgFullpath = explode('/', $image['image']);
                                                    $imgExt = end($imgFullpath);
                                                @endphp
                                                @if(pathinfo($imgExt, PATHINFO_EXTENSION) == 'pdf' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'PDF')
                                                    <a href="{{ $image['image'] }}" class="pdf_icon" target="_blank">&nbsp;</a>
                                                @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'doc' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'docx')
                                                    <a href="{{ $image['image'] }}" class="doc_icon" target="_blank">&nbsp;</a>
                                                @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'xlsx' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'xls')
                                                    <a href="{{ $image['image'] }}" class="xlsx_icon" target="_blank">&nbsp;</a>
                                                @else
                                                    <a href="{{ $image['image'] }}" data-fancybox>
                                                        <img src="{{ $image['image'] }}" alt="" class="img-responsive" />
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="show-suppliers-with-unseen-message">Show Suppliers with unseen message @if($rfq['unseen_count']>0)<span class="badge badge-warning"><i class="fa fa-envelope"></i></span>@endif</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="card" id="suppliers-with-unseen-message" style="display:none">
                        <div class="matched_suppliers_wrap">
                            <div class="rfq_business_profile_list_with_unseen_messages row">

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="rfq_data_top">
                            <div class="business_profile_filter">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <h3>Matched Suppliers</h3>
                                    </div>
                                    <div class="col-sm-12 col-md-8 filter_block">
                                        <div class="factory_filter_by_title">
                                            <label>Filter by Title</label>
                                            <input type="text" class="form-control factory_filter_by_title_trigger" value="" />
                                            <a href="javascript:void(0)" class="factory_filter_by_title_cancel_trigger" style="display: none;"><i class="fa fa-times"></i></a>
                                        </div>
                                        <div class="factory_type_filter">
                                            <label>Factory Type</label>
                                            <select class="form-select form-control" name="factory_type" id="factory_type">
                                                <option value="">Select factory type</option>
                                                @foreach($product_tag as $productCategory)
                                                    <option value="{{$productCategory->name}}">{{$productCategory->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="rating_type_filter">
                                            <label>Rating</label>
                                            <select class="form-select form-control" name="profile_rating" id="profile_rating">
                                                <option value="0">All</option>
                                                <option value="5">5 star</option>
                                                <option value="4">4 star</option>
                                                <option value="3">3 star</option>
                                                <option value="2">2 star</option>
                                                <option value="1">1 star</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <ul class="supplier-selection-menu">
                                        <li class="@php echo ($requestUrl == $rfq['id'] || $requestUrl == 'all') ? "active" : ""; @endphp"><a href="{{ route('admin.rfq.show', [$rfq['id'], 'all']) }}">All</a></li>
                                        <li class="short-list-li @php echo ($requestUrl == 'short-list') ? "active" : ""; @endphp"><a href="{{ route('admin.rfq.show', [$rfq['id'], 'short-list']) }}">Short listed</a> <span class="short-list-count">{{$businessProfilesShortListed}}</span></li>
                                        <li class="selected-list-li @php echo ($requestUrl == 'selected') ? "active" : ""; @endphp"><a href="{{ route('admin.rfq.show', [$rfq['id'], 'selected']) }}">Selected</a> <span class="selected-list-count">{{$businessProfilesSelectedListed}}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="matched_suppliers_wrap">
                            <div class="rfq_business_profile_list row">
                                @if($businessProfiles)

                                    @if($requestUrl == $rfq['id'] || $requestUrl == 'all')
                                        @foreach($businessProfiles as $key=>$businessProfile)
                                        @php
                                            $activeClassName = "";
                                            if($businessProfile['profile_shortlisted'] == 1 || $businessProfile['profile_selected'] == 1) {
                                                $activeClassName = "display:none";
                                            }
                                            $className = 'no-class';
                                            if(isset($businessProfile['supplier_quotation_to_buyer']))
                                            {
                                                foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer) {
                                                    if($supplierQuotationToBuyer['rfq_id'] == $rfq['id']) {
                                                        if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id']) {
                                                            $className = 'already-sent';
                                                        }
                                                    }
                                                }
                                            }

                                        @endphp
                                        <div class="col-sm-12 col-md-6 col-lg-4 suppliersBoxWrapOuter {{$className}}" style="{{$activeClassName}}">
                                            <div class="suppliersBoxWrap">
                                                <div class="suppliers_box">
                                                    <div class="suppliers_imgBox">
                                                        <div class="imgBox">
                                                            <img src="{{Storage::disk('s3')->url('public/'.$businessProfile['user']['image'])}}" alt="" />
                                                        </div>
                                                        <!--h5>MB Pool</h5-->
                                                    </div>
                                                    <div class="suppliers_textBox">
                                                        <div class="title_box">
                                                            <h3><a href="/{{$businessProfile['alias']}}" target="_blank">{{$businessProfile['business_name']}}</a></h3>
                                                            <div class="sms_img">
                                                                @if(isset($associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]))
                                                                    <a href="javascript:void(0);" class="sms_trigger"  data-business_name ="{{$businessProfile['business_name']}}" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="{{$businessProfile['user']['sso_reference_id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-businessprofilealias="{{$businessProfile['alias']}}"><i class="fa fa-envelope"></i><span data-unseenmessagecount="{{ $associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]['count'] }}" class="sso_id_{{$businessProfile['user']['sso_reference_id']}}">{{ $associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]['count'] }} </span></a>
                                                                @else
                                                                    <a href="javascript:void(0);" class="sms_trigger"  data-business_name ="{{$businessProfile['business_name']}}" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="{{$businessProfile['user']['sso_reference_id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-businessprofilealias="{{$businessProfile['alias']}}"><i class="fa fa-envelope"></i><span style="display:none" data-unseenmessagecount="0" class="sso_id_{{$businessProfile['user']['sso_reference_id']}}"></span></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="sms_details_box">
                                                            <div class="sms_details">
                                                                Contact Person <br/>
                                                                <span>{{$businessProfile['user']['name']}}</span>
                                                            </div>
                                                            <div class="sms_details">
                                                                Contact Number <br/>
                                                                <span>{{$businessProfile['user']['phone']}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="offer_price_block_wrapper" style="@php echo ($businessProfile['supplier_quotation_to_buyer']) ? 'display: block': 'display: none'; @endphp">
                                                            <div class="offer_price_block">
                                                                @foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer)
                                                                        @if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id'] && $supplierQuotationToBuyer['from_backend'] == true)
                                                                            <span> Offered to buyer :</span> <span>$ {{$supplierQuotationToBuyer['offer_price']}}  /  {{$supplierQuotationToBuyer['offer_price_unit']}}</span>
                                                                            @break
                                                                        @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="deal_price_block">
                                                                @foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer)
                                                                        @if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id'] && $supplierQuotationToBuyer['from_backend'] == false)
                                                                            <span> Quoted by supplier :</span> <span>$ {{$supplierQuotationToBuyer['offer_price']}}  / {{$supplierQuotationToBuyer['offer_price_unit']}}</span>
                                                                            @break
                                                                        @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="add_to_short_list_element">
                                                            @php
                                                            $classActive = '';
                                                            if($rfq['short_listed_profiles'])
                                                            {
                                                                $shortlistVar = explode(",", $rfq['short_listed_profiles']);
                                                                foreach($shortlistVar as $rfqshortlistid)
                                                                {
                                                                    if($rfqshortlistid == $businessProfile['id'])
                                                                    {
                                                                        $classActive = 'checked="checked"';
                                                                    }
                                                                }
                                                            }
                                                            @endphp
                                                            <div class="form-check">
                                                                <input type="checkbox" {{$classActive}} name="add_to_short_list_check" class="form-check-input add_to_short_list_trigger" id="add_to_short_list_trigger_{{$businessProfile['id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}">
                                                                <label class="form-check-label" for="add_to_short_list_trigger_{{$businessProfile['id']}}">Add to short list</label>
                                                            </div>
                                                            <input type="hidden" name="short_list[]" class="existing_short_list_ids" value="{{ $rfq['short_listed_profiles'] }}" />
                                                            <input type="hidden" name="remove_short_list[]" class="remove_existing_short_list_ids" value="" />
                                                        </div>

                                                        <div class="add_to_short_list_element selected_element">
                                                            @php
                                                            $classSelectedActive = '';
                                                            if($rfq['selected_profile'])
                                                            {
                                                                $shortlistVar = explode(",", $rfq['selected_profile']);
                                                                foreach($shortlistVar as $rfqshortlistid)
                                                                {
                                                                    if($rfqshortlistid == $businessProfile['id'])
                                                                    {
                                                                        $classSelectedActive = 'checked="checked"';
                                                                    }
                                                                }
                                                            }
                                                            @endphp
                                                            <div class="form-check">
                                                                <input type="checkbox" {{$classSelectedActive}} name="add_to_selected_list_check" class="form-check-input add_to_selected_list_trigger" id="add_to_selected_list_trigger_{{$businessProfile['id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}">
                                                                <label class="form-check-label" for="add_to_selected_list_trigger_{{$businessProfile['id']}}">Make it selected</label>
                                                            </div>
                                                            <input type="hidden" name="selected_list[]" class="existing_selected_list_ids" value="{{ $rfq['selected_profile'] }}" />
                                                            <input type="hidden" name="remove_selected_list[]" class="remove_existing_selected_list_ids" value="" />
                                                        </div>

                                                        <div class="send_box">
                                                            <a href="javascript:void(0);" class="businessProfileModal{{$businessProfile['id']}}" data-toggle="modal" data-target="#businessProfileModal{{$businessProfile['id']}}">Send <i class="fa fa-chevron-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade businessProfileModal" id="businessProfileModal{{$businessProfile['id']}}" tabindex="-1" role="dialog" aria-labelledby="businessProfileModal{{$businessProfile['id']}}Label" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <legend>{{$businessProfile['business_name']}}</legend>
                                                            <div class="propose_price_block">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="print_block">
                                                                        <label>Offer Price ($)</label>
                                                                        <div class="propose_price_input_block">
                                                                            <input data-businessprofilename="{{$businessProfile['business_name']}}" type="number" value="" name="propose_price" class="propose_price" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="uom_block">
                                                                        <label>Price Unit</label>
                                                                        <select name="propose_uom" class="propose_uom form-select form-control">
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

                                                            <!-- <div class="separator_block"> / </div> -->

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" data-businessprofilealias="{{$businessProfile['alias']}}" data-businessprofilename="{{$businessProfile['business_name']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}" class="btn btn-primary send_offer_price_trigger">Send</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @endforeach
                                    @endif

                                    @if($requestUrl == 'short-list')
                                        @foreach($businessProfiles as $key=>$businessProfile)
                                            @if($businessProfile['profile_shortlisted']==1 && $businessProfile['profile_selected']==0)
                                                @php
                                                    $className = 'no-class';
                                                    if(isset($businessProfile['supplier_quotation_to_buyer']))
                                                    {
                                                        foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer) {
                                                            if($supplierQuotationToBuyer['rfq_id'] == $rfq['id']) {
                                                                if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id']) {
                                                                    $className = 'already-sent';
                                                                }
                                                            }
                                                        }
                                                    }

                                                @endphp
                                                <div class="col-sm-12 col-md-6 col-lg-4 suppliersBoxWrapOuter {{$className}}">
                                                    <div class="suppliersBoxWrap">
                                                        <div class="suppliers_box">
                                                            <div class="suppliers_imgBox">
                                                                <div class="imgBox">
                                                                    <img src="{{Storage::disk('s3')->url('public/'.$businessProfile['user']['image'])}}" alt="" />
                                                                </div>
                                                                <!--h5>MB Pool</h5-->
                                                            </div>
                                                            <div class="suppliers_textBox">
                                                                <div class="title_box">
                                                                    <h3><a href="/{{$businessProfile['alias']}}" target="_blank">{{$businessProfile['business_name']}}</a></h3>
                                                                    <div class="sms_img">
                                                                        @if(isset($associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]))
                                                                            <a href="javascript:void(0);" class="sms_trigger"  data-business_name ="{{$businessProfile['business_name']}}" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="{{$businessProfile['user']['sso_reference_id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-businessprofilealias="{{$businessProfile['alias']}}"><i class="fa fa-envelope"></i><span data-unseenmessagecount="{{ $associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]['count'] }}" class="sso_id_{{$businessProfile['user']['sso_reference_id']}}">{{ $associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]['count'] }} </span></a>
                                                                        @else
                                                                            <a href="javascript:void(0);" class="sms_trigger"  data-business_name ="{{$businessProfile['business_name']}}" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="{{$businessProfile['user']['sso_reference_id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-businessprofilealias="{{$businessProfile['alias']}}"><i class="fa fa-envelope"></i><span style="display:none" data-unseenmessagecount="0" class="sso_id_{{$businessProfile['user']['sso_reference_id']}}"></span></a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="sms_details_box">
                                                                    <div class="sms_details">
                                                                        Contact Person <br/>
                                                                        <span>{{$businessProfile['user']['name']}}</span>
                                                                    </div>
                                                                    <div class="sms_details">
                                                                        Contact Number <br/>
                                                                        <span>{{$businessProfile['user']['phone']}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="offer_price_block_wrapper" style="@php echo ($businessProfile['supplier_quotation_to_buyer']) ? 'display: block': 'display: none'; @endphp">
                                                                    <div class="offer_price_block">
                                                                        @foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer)
                                                                                @if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id'] && $supplierQuotationToBuyer['from_backend'] == true)
                                                                                    <span> Offered to buyer :</span> <span>$ {{$supplierQuotationToBuyer['offer_price']}}  /  {{$supplierQuotationToBuyer['offer_price_unit']}}</span>
                                                                                    @break
                                                                                @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="deal_price_block">
                                                                        @foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer)
                                                                                @if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id'] && $supplierQuotationToBuyer['from_backend'] == false)
                                                                                    <span> Quoted by supplier :</span> <span>$ {{$supplierQuotationToBuyer['offer_price']}}  / {{$supplierQuotationToBuyer['offer_price_unit']}}</span>
                                                                                    @break
                                                                                @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="add_to_short_list_element">
                                                                    @php
                                                                    $classActive = '';
                                                                    if($rfq['short_listed_profiles'])
                                                                    {
                                                                        $shortlistVar = explode(",", $rfq['short_listed_profiles']);
                                                                        foreach($shortlistVar as $rfqshortlistid)
                                                                        {
                                                                            if($rfqshortlistid == $businessProfile['id'])
                                                                            {
                                                                                $classActive = 'checked="checked"';
                                                                            }
                                                                        }
                                                                    }
                                                                    @endphp
                                                                    <div class="form-check">
                                                                        <input type="checkbox" {{$classActive}} name="add_to_short_list_check" class="form-check-input add_to_short_list_trigger" id="add_to_short_list_trigger_{{$businessProfile['id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}">
                                                                        <label class="form-check-label" for="add_to_short_list_trigger_{{$businessProfile['id']}}">
                                                                            @if($businessProfile['profile_shortlisted'])
                                                                            Remove from short list
                                                                            @else
                                                                            Add to short list
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                    <input type="hidden" name="short_list[]" class="existing_short_list_ids" value="{{ $rfq['short_listed_profiles'] }}" />
                                                                    <input type="hidden" name="remove_short_list[]" class="remove_existing_short_list_ids" value="" />
                                                                </div>

                                                                <div class="add_to_short_list_element selected_element">
                                                                    @php
                                                                    $classSelectedActive = '';
                                                                    if($rfq['selected_profile'])
                                                                    {
                                                                        $shortlistVar = explode(",", $rfq['selected_profile']);
                                                                        foreach($shortlistVar as $rfqshortlistid)
                                                                        {
                                                                            if($rfqshortlistid == $businessProfile['id'])
                                                                            {
                                                                                $classSelectedActive = 'checked="checked"';
                                                                            }
                                                                        }
                                                                    }
                                                                    @endphp
                                                                    <div class="form-check">
                                                                        <input type="checkbox" {{$classSelectedActive}} name="add_to_selected_list_check" class="form-check-input add_to_selected_list_trigger" id="add_to_selected_list_trigger_{{$businessProfile['id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}">
                                                                        <label class="form-check-label" for="add_to_selected_list_trigger_{{$businessProfile['id']}}">
                                                                            @if($businessProfile['profile_selected'])
                                                                            Remove from selected list
                                                                            @else
                                                                            Make it selected
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                    <input type="hidden" name="selected_list[]" class="existing_selected_list_ids" value="{{ $rfq['selected_profile'] }}" />
                                                                    <input type="hidden" name="remove_selected_list[]" class="remove_existing_selected_list_ids" value="" />
                                                                </div>

                                                                <div class="send_box">
                                                                    <a href="javascript:void(0);" class="businessProfileModal{{$businessProfile['id']}}" data-toggle="modal" data-target="#businessProfileModal{{$businessProfile['id']}}">Send <i class="fa fa-chevron-circle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade businessProfileModal" id="businessProfileModal{{$businessProfile['id']}}" tabindex="-1" role="dialog" aria-labelledby="businessProfileModal{{$businessProfile['id']}}Label" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <legend>{{$businessProfile['business_name']}}</legend>
                                                                    <div class="propose_price_block">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-md-6">
                                                                            <div class="print_block">
                                                                                <label>Offer Price ($)</label>
                                                                                <div class="propose_price_input_block">
                                                                                    <input data-businessprofilename="{{$businessProfile['business_name']}}" type="number" value="" name="propose_price" class="propose_price" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6">
                                                                            <div class="uom_block">
                                                                                <label>Price Unit</label>
                                                                                <select name="propose_uom" class="propose_uom form-select form-control">
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

                                                                    <!-- <div class="separator_block"> / </div> -->

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" data-businessprofilealias="{{$businessProfile['alias']}}" data-businessprofilename="{{$businessProfile['business_name']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}" class="btn btn-primary send_offer_price_trigger">Send</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if($requestUrl == 'selected')
                                        @foreach($businessProfiles as $key=>$businessProfile)
                                            @if($businessProfile['profile_selected']==1)
                                                @php
                                                    $className = 'no-class';
                                                    if(isset($businessProfile['supplier_quotation_to_buyer']))
                                                    {
                                                        foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer) {
                                                            if($supplierQuotationToBuyer['rfq_id'] == $rfq['id']) {
                                                                if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id']) {
                                                                    $className = 'already-sent';
                                                                }
                                                            }
                                                        }
                                                    }

                                                @endphp
                                                <div class="col-sm-12 col-md-6 col-lg-4 suppliersBoxWrapOuter {{$className}}">
                                                    <div class="suppliersBoxWrap">
                                                        <div class="suppliers_box">
                                                            <div class="suppliers_imgBox">
                                                                <div class="imgBox">
                                                                    <img src="{{Storage::disk('s3')->url('public/'.$businessProfile['user']['image'])}}" alt="" />
                                                                </div>
                                                                <!--h5>MB Pool</h5-->
                                                            </div>
                                                            <div class="suppliers_textBox">
                                                                <div class="title_box">
                                                                    <h3><a href="/{{$businessProfile['alias']}}" target="_blank">{{$businessProfile['business_name']}}</a></h3>
                                                                    <div class="sms_img">
                                                                        @if(isset($associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]))
                                                                            <a href="javascript:void(0);" class="sms_trigger"  data-business_name ="{{$businessProfile['business_name']}}" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="{{$businessProfile['user']['sso_reference_id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-businessprofilealias="{{$businessProfile['alias']}}"><i class="fa fa-envelope"></i><span data-unseenmessagecount="{{ $associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]['count'] }}" class="sso_id_{{$businessProfile['user']['sso_reference_id']}}">{{ $associativeArrayUsingIDandCount[$businessProfile['user']['sso_reference_id']]['count'] }} </span></a>
                                                                        @else
                                                                            <a href="javascript:void(0);" class="sms_trigger"  data-business_name ="{{$businessProfile['business_name']}}" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="{{$businessProfile['user']['sso_reference_id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-businessprofilealias="{{$businessProfile['alias']}}"><i class="fa fa-envelope"></i><span style="display:none" data-unseenmessagecount="0" class="sso_id_{{$businessProfile['user']['sso_reference_id']}}"></span></a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="sms_details_box">
                                                                    <div class="sms_details">
                                                                        Contact Person <br/>
                                                                        <span>{{$businessProfile['user']['name']}}</span>
                                                                    </div>
                                                                    <div class="sms_details">
                                                                        Contact Number <br/>
                                                                        <span>{{$businessProfile['user']['phone']}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="offer_price_block_wrapper" style="@php echo ($businessProfile['supplier_quotation_to_buyer']) ? 'display: block': 'display: none'; @endphp">
                                                                    <div class="offer_price_block">
                                                                        @foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer)
                                                                                @if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id'] && $supplierQuotationToBuyer['from_backend'] == true)
                                                                                    <span> Offered to buyer :</span> <span>$ {{$supplierQuotationToBuyer['offer_price']}}  /  {{$supplierQuotationToBuyer['offer_price_unit']}}</span>
                                                                                    @break
                                                                                @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="deal_price_block">
                                                                        @foreach($businessProfile['supplier_quotation_to_buyer'] as $supplierQuotationToBuyer)
                                                                                @if($supplierQuotationToBuyer['business_profile_id'] == $businessProfile['id'] && $supplierQuotationToBuyer['from_backend'] == false)
                                                                                    <span> Quoted by supplier :</span> <span>$ {{$supplierQuotationToBuyer['offer_price']}}  / {{$supplierQuotationToBuyer['offer_price_unit']}}</span>
                                                                                    @break
                                                                                @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                @if($businessProfile['profile_selected'] == 0)
                                                                <div class="add_to_short_list_element">
                                                                    @php
                                                                    $classActive = '';
                                                                    if($rfq['short_listed_profiles'])
                                                                    {
                                                                        $shortlistVar = explode(",", $rfq['short_listed_profiles']);
                                                                        foreach($shortlistVar as $rfqshortlistid)
                                                                        {
                                                                            if($rfqshortlistid == $businessProfile['id'])
                                                                            {
                                                                                $classActive = 'checked="checked"';
                                                                            }
                                                                        }
                                                                    }
                                                                    @endphp
                                                                    <div class="form-check">
                                                                        <input type="checkbox" {{$classActive}} name="add_to_short_list_check" class="form-check-input add_to_short_list_trigger" id="add_to_short_list_trigger_{{$businessProfile['id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}">
                                                                        <label class="form-check-label" for="add_to_short_list_trigger_{{$businessProfile['id']}}">
                                                                            @if($businessProfile['profile_shortlisted'])
                                                                            Remove from short list
                                                                            @else
                                                                            Add to short list
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                    <input type="hidden" name="short_list[]" class="existing_short_list_ids" value="{{ $rfq['short_listed_profiles'] }}" />
                                                                    <input type="hidden" name="remove_short_list[]" class="remove_existing_short_list_ids" value="" />
                                                                </div>
                                                                @endif

                                                                <div class="add_to_short_list_element selected_element">
                                                                    @php
                                                                    $classSelectedActive = '';
                                                                    if($rfq['selected_profile'])
                                                                    {
                                                                        $shortlistVar = explode(",", $rfq['selected_profile']);
                                                                        foreach($shortlistVar as $rfqshortlistid)
                                                                        {
                                                                            if($rfqshortlistid == $businessProfile['id'])
                                                                            {
                                                                                $classSelectedActive = 'checked="checked"';
                                                                            }
                                                                        }
                                                                    }
                                                                    @endphp
                                                                    <div class="form-check">
                                                                        <input type="checkbox" {{$classSelectedActive}} name="add_to_selected_list_check" class="form-check-input add_to_selected_list_trigger" id="add_to_selected_list_trigger_{{$businessProfile['id']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}">
                                                                        <label class="form-check-label" for="add_to_selected_list_trigger_{{$businessProfile['id']}}">
                                                                            @if($businessProfile['profile_selected'])
                                                                            Remove from selected list
                                                                            @else
                                                                            Make it selected
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                    <input type="hidden" name="selected_list[]" class="existing_selected_list_ids" value="{{ $rfq['selected_profile'] }}" />
                                                                    <input type="hidden" name="remove_selected_list[]" class="remove_existing_selected_list_ids" value="" />
                                                                </div>

                                                                <div class="send_box">
                                                                    <a href="javascript:void(0);" class="businessProfileModal{{$businessProfile['id']}}" data-toggle="modal" data-target="#businessProfileModal{{$businessProfile['id']}}">Send <i class="fa fa-chevron-circle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade businessProfileModal" id="businessProfileModal{{$businessProfile['id']}}" tabindex="-1" role="dialog" aria-labelledby="businessProfileModal{{$businessProfile['id']}}Label" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <legend>{{$businessProfile['business_name']}}</legend>
                                                                    <div class="propose_price_block">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-md-6">
                                                                            <div class="print_block">
                                                                                <label>Offer Price ($)</label>
                                                                                <div class="propose_price_input_block">
                                                                                    <input data-businessprofilename="{{$businessProfile['business_name']}}" type="number" value="" name="propose_price" class="propose_price" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6">
                                                                            <div class="uom_block">
                                                                                <label>Price Unit</label>
                                                                                <select name="propose_uom" class="propose_uom form-select form-control">
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

                                                                    <!-- <div class="separator_block"> / </div> -->

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" data-businessprofilealias="{{$businessProfile['alias']}}" data-businessprofilename="{{$businessProfile['business_name']}}" data-businessprofileid="{{$businessProfile['id']}}" data-rfqid="{{$rfq['id']}}" class="btn btn-primary send_offer_price_trigger">Send</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                @else
                                    <div class="alert alert-info" style="width: 100%;"><p>No profile found</p></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 buyer-message-card">
                    <div class="message_header">
                        {{$rfq['user']['user_name']}}
                    </div>
                    <div class="chatting_app_wrapper">
                        <div class="chat-application">
                            <div class="app-chat">
                                <div class="content-area content-right">
                                    <div class="app-wrapper">
                                        <div class="card card card-default scrollspy border-radius-6 fixed-width">
                                            <div class="card-content chat-content p-0">
                                                <!-- Content Area -->
                                                <div class="chat-content-area animate fadeUp">
                                                    <!-- Chat content area -->
                                                    <div class="chat-area ps ps--active-y">
                                                        <div class="chats">
                                                            <div class="chats-box chat_messagedata" id="messagedata" data-buyerid="{{$rfq['sso_reference_id']}}" >
                                                            @if($chatdata)
                                                                @foreach($chatdata as $chat)
                                                                    @if($chat['from_id'] == $user)
                                                                    <div class="chat chat-right">
                                                                        <div class="chat-avatar">
                                                                            <a class="avatar">
                                                                                <img src='{{$from_user_image}}' class="circle" alt="avatar">
                                                                            </a>
                                                                        </div>
                                                                        <div class="chat-body left-align">
                                                                            <div class="chat-text">
                                                                                <p>
                                                                                @php echo html_entity_decode($chat['message']); @endphp
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div class="chat chat-left">
                                                                        <div class="chat-avatar">
                                                                            <a class="avatar">
                                                                                @if( $to_user_image != "" )
                                                                                    <img src='{{$to_user_image}}' class="circle" alt="avatar">
                                                                                @else
                                                                                    <span>{{$userNameShortForm}}</span>
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="chat-body left-align">
                                                                            <div class="chat-text">
                                                                                <p>@php echo html_entity_decode($chat['message']); @endphp </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            </div>
                                                        </div>
                                                        <div class="ps__rail-x" style="">
                                                            <div class="ps__thumb-x" tabindex="0" style=""></div>
                                                        </div>
                                                        <div class="ps__rail-y" style="">
                                                            <div class="ps__thumb-y" tabindex="0" style=""></div>
                                                        </div>
                                                    </div>
                                                    <!--/ Chat content area -->
                                                    <!-- Chat footer <-->
                                                    <div class="chat-footer">
                                                        <form action="javascript:void(0);" class="chat-input">
                                                            <input type="text" placeholder="Type message here.." id="messagebox" class="message mb-0">
                                                            <a class="btn_green send messageSendButton">Send <i class="fa fa-chevron-circle-right"></i> </a>
                                                        </form>
                                                    </div>
                                                    <!--/ Chat footer -->
                                                </div>
                                                <!--/ Content Area -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<div id="dialog-form" title="Message Box" style="display: none;">
    <div class="dialog-form-box">
        <div class="chat-content-area animate fadeUp">
            <div class="chat-area supplier-chat-area ps ps--active-y">
                <div class="chats">
                    <div class="supplier-chats-box chat_messagedata" id="supplier-messagedata" data-supplierid="">
                    </div>
                </div>
                <div class="ps__rail-x" style="">
                    <div class="ps__thumb-x" tabindex="0" style=""></div>
                </div>
                <div class="ps__rail-y" style="">
                    <div class="ps__thumb-y" tabindex="0" style=""></div>
                </div>
            </div>
        </div>
    </div>
    <div class="dialog-form-button">
        <input type="hidden" class="dialouge_box_rfq_id" name="dialouge_box_rfq_id" value=""/>
        <input type="hidden" class="dialouge_box_from_id" name="dialouge_box_from_id" value=""/>
        <input type="hidden" class="dialouge_box_to_id" name="dialouge_box_to_id" value=""/>
        <input type="hidden" class="dialouge_box_business_profile_id" name="dialouge_box_business_profile_id" value=""/>
        <input type="hidden" class="dialouge_box_business_profile_alias" name="dialouge_box_business_profile_alias" value=""/>
        <input type="text" placeholder="Type message here.."  class="message mb-0 dialouge_box_message_content">
        <input type="button" class="btn btn_green messageSendToUser" value="Send" />
    </div>
</div>

@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        //function enter_chat(a){var e=$(".message").val();if(""!=e){var t='<div class="chat-text"><p>'+e+"</p></div>";$(".chat:last-child .chat-body").append(t),$(".message").val(""),$(".chat-area").scrollTop($(".chat-area > .chats").height())}}
        $(document).ready(function() {
            var envMode = "{{ env('APP_ENV') }}";
            var fromId;
            if(envMode == 'production') {
                fromId = '5771';
            } else{
                fromId = '5552';
            }

            $(".rfq-status-form-submit-trigger").click(function(){

                if( $('input[name="publish_type"]').is(':checked') )
                {
                    var cnfrm = confirm('Are you sure?');
                    if(cnfrm != true)
                    {
                        return false;
                    }
                    //alert("Radio Button Is checked!");
                    $('#rfq_status_form').submit();
                }
                else
                {
                    alert("Please Select an option where you want to publish this RFQ.");
                }

            })

            //var shortListedIds= new Array();
            $(".add_to_short_list_trigger").click(function(){
                var businessProfileId = $(this).data("businessprofileid");
                var rfqId = $(this).data("rfqid");
                var from_short_list = "from_short";

                if ($(this).is(':checked')) {

                    if (confirm('Are you sure? You want to add this profile in short list'))
                    {
                        var boxHtml = $(this).closest(".suppliersBoxWrapOuter");
                        var shortListCount = $(".short-list-count").text();

                        var existing_list = $(".existing_short_list_ids").val();
                        existing_list = existing_list.concat(',' + businessProfileId);
                        $(".existing_short_list_ids").val(existing_list);

                        var remove_existing_list = $(".remove_existing_short_list_ids").val();
                        remove_existing_list = remove_existing_list.replace(businessProfileId, '');
                        $(".remove_existing_short_list_ids").val(remove_existing_list);

                        var url = "{{route('admin.rfq.profile.shortlist')}}";
                        $.ajax({
                            method: 'get',
                            dataType: 'json',
                            data: {rfqId:rfqId, shortList: existing_list, removeShortList: remove_existing_list, requestForm: from_short_list},
                            enctype: 'multipart/form-data',
                            url: url,
                            beforeSend: function() {
                                // $('.loading-message').html("Please Wait.");
                                // $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                            {
                                boxHtml.remove();
                                shortListCount = parseInt(shortListCount)+1;
                                $(".short-list-count").text(shortListCount);
                                // $('.loading-message').html("");
                                // $('#loadingProgressContainer').hide();
                                //window.location.reload();
                            }
                        });
                    }

                } else {

                    if (confirm('Are you sure? You want to remove this profile in short list'))
                    {
                        var boxHtml = $(this).closest(".suppliersBoxWrapOuter");
                        var shortListCount = $(".short-list-count").text();

                        var existing_list = $(".existing_short_list_ids").val();
                        existing_list = existing_list.replace(businessProfileId, '');
                        $(".existing_short_list_ids").val(existing_list);

                        var remove_existing_list = $(".remove_existing_short_list_ids").val();
                        remove_existing_list = remove_existing_list.concat(',' + businessProfileId);
                        $(".remove_existing_short_list_ids").val(remove_existing_list);

                        var url = "{{route('admin.rfq.profile.shortlist')}}";
                        $.ajax({
                            method: 'get',
                            dataType: 'json',
                            data: {rfqId:rfqId, shortList: existing_list, removeShortList: remove_existing_list, requestForm: from_short_list},
                            enctype: 'multipart/form-data',
                            url: url,
                            beforeSend: function() {
                                // $('.loading-message').html("Please Wait.");
                                // $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                            {
                                boxHtml.remove();
                                shortListCount = parseInt(shortListCount)-1;
                                $(".short-list-count").text(shortListCount);
                                // $('.loading-message').html("");
                                // $('#loadingProgressContainer').hide();
                                //window.location.reload();
                            }
                        });
                    }

                }

                // var boxHtml = $(this).closest(".suppliersBoxWrapOuter").html();
                // $(".selected-profile-card-outer").show();
                // $(".selected-profile-wrap-inside").append('<div class="col-sm-12 col-md-6 col-lg-4 suppliersBoxWrapOuter no-class">'+boxHtml+'</div>');


            })

            //var selectedListedIds= new Array();
            $(".add_to_selected_list_trigger").click(function(){
                var businessProfileId = $(this).data("businessprofileid");
                var rfqId = $(this).data("rfqid");
                var from_selected_list = "from_selected";

                if ($(this).is(':checked')) {

                    if (confirm('Are you sure? You want to add this profile in selected list'))
                    {
                        var boxHtml = $(this).closest(".suppliersBoxWrapOuter");
                        var selectedListCount = $(".selected-list-count").text();

                        var existing_selected_list = $(".existing_selected_list_ids").val();
                        existing_selected_list = existing_selected_list.concat(',' + businessProfileId);
                        $(".existing_selected_list_ids").val(existing_selected_list);

                        var remove_existing_selected_list = $(".remove_existing_selected_list_ids").val();
                        remove_existing_selected_list = remove_existing_selected_list.replace(businessProfileId, '');
                        $(".remove_existing_selected_list_ids").val(remove_existing_selected_list);

                        var url = "{{route('admin.rfq.profile.shortlist')}}";
                        $.ajax({
                            method: 'get',
                            dataType: 'json',
                            data: {rfqId:rfqId, selectedList: existing_selected_list, removeSelectedList: remove_existing_selected_list, requestForm: from_selected_list},
                            enctype: 'multipart/form-data',
                            url: url,
                            beforeSend: function() {
                                // $('.loading-message').html("Please Wait.");
                                // $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                            {
                                boxHtml.remove();
                                selectedListCount = parseInt(selectedListCount)+1;
                                $(".selected-list-count").text(selectedListCount);
                                // $('.loading-message').html("");
                                // $('#loadingProgressContainer').hide();
                                //window.location.reload();
                            }
                        });
                    }

                } else {

                    if (confirm('Are you sure? You want to remove this profile in selected list'))
                    {
                        var boxHtml = $(this).closest(".suppliersBoxWrapOuter");
                        var selectedListCount = $(".selected-list-count").text();

                        var existing_selected_list = $(".existing_selected_list_ids").val();
                        //existing_selected_list = existing_selected_list.concat(',' + businessProfileId);
                        existing_selected_list = existing_selected_list.replace(businessProfileId, '');
                        $(".existing_selected_list_ids").val(existing_selected_list);

                        var remove_existing_selected_list = $(".remove_existing_selected_list_ids").val();
                        remove_existing_selected_list = remove_existing_selected_list.concat(',' + businessProfileId);
                        $(".remove_existing_selected_list_ids").val(remove_existing_selected_list);

                        var url = "{{route('admin.rfq.profile.shortlist')}}";
                        $.ajax({
                            method: 'get',
                            dataType: 'json',
                            data: {rfqId:rfqId, selectedList: existing_selected_list, removeSelectedList: remove_existing_selected_list, requestForm: from_selected_list},
                            enctype: 'multipart/form-data',
                            url: url,
                            beforeSend: function() {
                                // $('.loading-message').html("Please Wait.");
                                // $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                            {
                                boxHtml.remove();
                                selectedListCount = parseInt(selectedListCount)-1;
                                $(".selected-list-count").text(selectedListCount);
                                // $('.loading-message').html("");
                                // $('#loadingProgressContainer').hide();
                                //window.location.reload();
                            }
                        });
                    }
                }
            })

            $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
            var selectedValues = [];
            var serverURL = "{{ env('CHAT_URL') }}?userId="+fromId;
            var socket = io.connect(serverURL);
            socket.on('connect', function(data) {
                console.log("Socket Connect successfully.");
            });

            $(document).on("change", ".propose_price", function(){
                var price = $(this).val();
                //var price_unit = $(this).closest(".business_profile_name").children(".propose_uom").val();
                if(price != ''){
                    url = "{{ $app->make('url')->to('/') }}/"+$(this).data('alias');
                    selectedValues.push("<a href='"+url+"'><b>"+$(this).data("businessprofilename")+"</b></a>" + " Offers - $"+$(this).val()+"/ Pcs");
                }
            });


            $(document).on('change', '#factory_type', function(){
                var category_id = $( "#factory_type option:selected" ).val();
                var profile_rating = $( "#profile_rating option:selected" ).val();
                var rfq_id ="{{$rfq['id']}}";
                console.log(category_id);
                console.log(profile_rating);
                if( category_id !=''){
                    $.ajax({
                        method: 'get',
                        data: {category_id:category_id,profile_rating:profile_rating, rfq_id:rfq_id},
                        url: '{{ route("admin.rfq.business.profiles.filter") }}',
                        success:function(response){
                            console.log(response.businessProfiles);
                            if(response.businessProfiles.length >0){
                                $('.rfq_business_profile_list').empty();
                                response.businessProfiles.forEach((item, index)=>{
                                    console.log(item);

                                    var  className = 'no-class';
                                    var  display  = 'display:none';
                                    var offered_to_buyer = ' ';
                                    var deal_with_supplier=' ';
                                    if(item.supplier_quotation_to_buyer.length > 0){
                                        className = 'already-sent';
                                        display  = 'display:block';
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if(i.from_backend == true){
                                                offered_to_buyer ='<span>Offered to buyer :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }

                                        });
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if( i.from_backend == false){
                                                deal_with_supplier ='<span>Quoted by supplier :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }
                                        });
                                    }
                                    var html = '<div class="col-sm-12 col-md-6 col-lg-4"'+className+'>';
                                    html += '<div class="suppliersBoxWrap">';
                                    html += '<div class="suppliers_box">';
                                    html += '<div class="suppliers_imgBox">';
                                    html += '<div class="imgBox">';
                                    //let image = "{{asset('storage')}}"+'/'+item.user.image;
                                    let image = "{{Storage::disk('s3')->url('public')}}"+'/'+item.user.image;
                                    html += '<img src="'+image+'" alt="" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="suppliers_textBox">';
                                    html += '<div class="title_box">';
                                    html += '<h3><a target="_blank" href=/'+item.alias+'>'+item.business_name+'</a></h3>';
                                    html += '<div class="sms_img">';
                                    if(response.associativeArrayUsingIDandCount[item.user.sso_reference_id]){
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span data-unseenmessagecount="'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'" class="sso_id_'+item.user.sso_reference_id+'">'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'</span></a>';
                                    }else{
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span style="display: none" data-unseenmessagecount="0"  class="sso_id_'+item.user.sso_reference_id+'"></span></a>';
                                    }
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="sms_details_box">';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Person <br/>';
                                    html += '<span>'+item.user.name+'</span>';
                                    html += '</div>';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Number <br/>';
                                    html += '<span>'+item.user.phone+'</span>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="offer_price_block_wrapper" style=" ' + display + ' ">';
                                    html += '<div class="offer_price_block">';
                                    html +=  offered_to_buyer;
                                    html += '</div>';
                                    html += '<div class="deal_price_block">';
                                    html +=  deal_with_supplier;
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="send_box">';
                                    html += '<a href="javascript:void(0);" class="businessProfileModal'+item.id+'" data-toggle="modal" data-target="#businessProfileModal'+item.id+'">Send <i class="fa fa-chevron-circle-right"></i></a>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal fade businessProfileModal" id="businessProfileModal'+item.id+'" tabindex="-1" role="dialog" aria-labelledby="businessProfileModal'+item.id+'Label" aria-hidden="true">';
                                    html += '<div class="modal-dialog" role="document">';
                                    html += '<div class="modal-content">';
                                    html += '<div class="modal-body">';
                                    html += '<legend>'+item.business_name+'</legend>';
                                    html += '<div class="propose_price_block">';

                                    html += '<div class="row">';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="print_block">';
                                    html += '<label>Offer Price ($)</label>';
                                    html += '<div class="propose_price_input_block">';
                                    html += '<input data-businessprofilename="'+item.business_name+'" type="number" value="" name="propose_price" class="propose_price" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="uom_block">';
                                    html += '<label>Price Unit</label>';
                                    html += '<select name="propose_uom" class="propose_uom form-select form-control">';
                                    html += '<option value="" selected="true" disabled="">Choose your option</option>';
                                    html += '<option value="Pcs">Pcs</option>';
                                    html += '<option value="Lbs">Lbs</option>';
                                    html += '<option value="Gauge">Gauge</option>';
                                    html += '<option value="Yard">Yards</option>';
                                    html += '<option value="Kg">Kg</option>';
                                    html += '<option value="Meter">Meter</option>';
                                    html += '<option value="Dozens">Dozens</option>';
                                    html += '</select>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal-footer">';
                                    html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                                    html += '<button type="button" data-businessprofilealias="'+item.alias+'" data-businessprofilename="'+item.business_name+'" data-businessprofileid="'+item.id+'" data-rfqid="{{$rfq['id']}}" class="btn btn-primary send_offer_price_trigger">Send</button>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    $('.rfq_business_profile_list').append(html);
                                })
                            }else{
                                $('.rfq_business_profile_list').empty();
                                var html = '<div class="alert alert-info" style="width: 100%;">';
                                html += '<p>No Profile found</p>';
                                html += '</div>';
                                $('.rfq_business_profile_list').append(html);
                            }
                        }
                    });
                }
            });

            $(document).on('click', '.show-suppliers-with-unseen-message', function(){

                var profile_rating = $( "#profile_rating option:selected" ).val();
                var rfq_id ="{{$rfq['id']}}";
                    $.ajax({
                        method: 'get',
                        data: {rfq_id:rfq_id},
                        url: '{{ route("admin_rfq_business_profiles_with_unseen_message") }}',
                        success:function(response){
                            console.log(response.businessProfiles);
                            if(response.businessProfiles.length >0){
                                $('.rfq_business_profile_list_with_unseen_messages').empty();
                                response.businessProfiles.forEach((item, index)=>{
                                    var  className = 'no-class';
                                    var  display  = 'display:none';
                                    var offered_to_buyer = ' ';
                                    var deal_with_supplier=' ';
                                    if(item.supplier_quotation_to_buyer.length > 0){
                                        className = 'already-sent';
                                        display  = 'display:block';
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if(i.from_backend == true){
                                                offered_to_buyer ='<span>Offered to buyer :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }

                                        });
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if( i.from_backend == false){
                                                deal_with_supplier ='<span>Quoted by supplier :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }
                                        });
                                    }
                                    var html = '<div class="col-sm-12 col-md-6 col-lg-4"'+className+'>';
                                    html += '<div class="suppliersBoxWrap">';
                                    html += '<div class="suppliers_box">';
                                    html += '<div class="suppliers_imgBox">';
                                    html += '<div class="imgBox">';
                                    //let image = "{{asset('storage')}}"+'/'+item.user.image;
                                    let image = "{{Storage::disk('s3')->url('public')}}"+'/'+item.user.image;
                                    html += '<img src="'+image+'" alt="" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="suppliers_textBox">';
                                    html += '<div class="title_box">';
                                    html += '<h3><a target="_blank" href=/'+item.alias+'>'+item.business_name+'</a></h3>';
                                    html += '<div class="sms_img">';
                                    if(response.associativeArrayUsingIDandCount[item.user.sso_reference_id]){
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span data-unseenmessagecount="'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'" class="sso_id_'+item.user.sso_reference_id+'">'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'</span></a>';
                                    }else{
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span style="display:none" data-unseenmessagecount="0" class="sso_id_'+item.user.sso_reference_id+'"></span></a>';
                                    }
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="sms_details_box">';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Person <br/>';
                                    html += '<span>'+item.user.name+'</span>';
                                    html += '</div>';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Number <br/>';
                                    html += '<span>'+item.user.phone+'</span>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="offer_price_block_wrapper" style=" ' + display + ' ">';
                                    html += '<div class="offer_price_block">';
                                    html +=  offered_to_buyer;
                                    html += '</div>';
                                    html += '<div class="deal_price_block">';
                                    html +=  deal_with_supplier;
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="send_box">';
                                    html += '<a href="javascript:void(0);" class="businessProfileModal'+item.id+'" data-toggle="modal" data-target="#businessProfileModal'+item.id+'">Send <i class="fa fa-chevron-circle-right"></i></a>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal fade businessProfileModal" id="businessProfileModal'+item.id+'" tabindex="-1" role="dialog" aria-labelledby="businessProfileModal'+item.id+'Label" aria-hidden="true">';
                                    html += '<div class="modal-dialog" role="document">';
                                    html += '<div class="modal-content">';
                                    html += '<div class="modal-body">';
                                    html += '<legend>'+item.business_name+'</legend>';
                                    html += '<div class="propose_price_block">';
                                    html += '<div class="row">';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="print_block">';
                                    html += '<label>Offer Price ($)</label>';
                                    html += '<div class="propose_price_input_block">';
                                    html += '<input data-businessprofilename="'+item.business_name+'" type="number" value="" name="propose_price" class="propose_price" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="uom_block">';
                                    html += '<label>Price Unit</label>';
                                    html += '<select name="propose_uom" class="propose_uom form-select form-control">';
                                    html += '<option value="" selected="true" disabled="">Choose your option</option>';
                                    html += '<option value="Pcs">Pcs</option>';
                                    html += '<option value="Lbs">Lbs</option>';
                                    html += '<option value="Gauge">Gauge</option>';
                                    html += '<option value="Yard">Yards</option>';
                                    html += '<option value="Kg">Kg</option>';
                                    html += '<option value="Meter">Meter</option>';
                                    html += '<option value="Dozens">Dozens</option>';
                                    html += '</select>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal-footer">';
                                    html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                                    html += '<button type="button" data-businessprofilealias="'+item.alias+'" data-businessprofilename="'+item.business_name+'" data-businessprofileid="'+item.id+'" data-rfqid="{{$rfq['id']}}" class="btn btn-primary send_offer_price_trigger">Send</button>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    $('.rfq_business_profile_list_with_unseen_messages').append(html);
                                })
                            }else{
                                $('.rfq_business_profile_list_with_unseen_messages').empty();
                                var html = '<div class="alert alert-info" style="width: 100%;">';
                                html += '<p>No Profile found</p>';
                                html += '</div>';
                                $('.rfq_business_profile_list_with_unseen_messages').append(html);
                            }
                            $("#suppliers-with-unseen-message").show();
                        }
                    });
            });

            $(document).on('change', '#profile_rating', function(){
                var category_id = $( "#factory_type option:selected" ).val();
                var profile_rating = $( "#profile_rating option:selected" ).val();
                var rfq_id ="{{$rfq['id']}}";
                    $.ajax({
                        method: 'get',
                        data: {category_id:category_id,profile_rating:profile_rating,rfq_id:rfq_id},
                        url: '{{ route("admin.rfq.business.profiles.filter") }}',
                        success:function(response){
                            console.log(response.businessProfiles);
                            if(response.businessProfiles.length >0){
                                $('.rfq_business_profile_list').empty();
                                response.businessProfiles.forEach((item, index)=>{
                                    var  className = 'no-class';
                                    var  display  = 'display:none';
                                    var offered_to_buyer = ' ';
                                    var deal_with_supplier=' ';
                                    if(item.supplier_quotation_to_buyer.length > 0){
                                        className = 'already-sent';
                                        display  = 'display:block';
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if(i.from_backend == true){
                                                offered_to_buyer ='<span>Offered to buyer :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }

                                        });
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if( i.from_backend == false){
                                                deal_with_supplier ='<span>Quoted by supplier :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }
                                        });
                                    }
                                    var html = '<div class="col-sm-12 col-md-6 col-lg-4"'+className+'>';
                                    html += '<div class="suppliersBoxWrap">';
                                    html += '<div class="suppliers_box">';
                                    html += '<div class="suppliers_imgBox">';
                                    html += '<div class="imgBox">';
                                    //let image = "{{asset('storage')}}"+'/'+item.user.image;
                                    let image = "{{Storage::disk('s3')->url('public')}}"+'/'+item.user.image;
                                    html += '<img src="'+image+'" alt="" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="suppliers_textBox">';
                                    html += '<div class="title_box">';
                                    html += '<h3><a target="_blank" href=/'+item.alias+'>'+item.business_name+'</a></h3>';
                                    html += '<div class="sms_img">';
                                    if(response.associativeArrayUsingIDandCount[item.user.sso_reference_id]){
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span data-unseenmessagecount="'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'" class="sso_id_'+item.user.sso_reference_id+'">'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'</span></a>';
                                    }else{
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span style="display:none" data-unseenmessagecount="0" class="sso_id_'+item.user.sso_reference_id+'"></span></a>';
                                    }
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="sms_details_box">';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Person <br/>';
                                    html += '<span>'+item.user.name+'</span>';
                                    html += '</div>';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Number <br/>';
                                    html += '<span>'+item.user.phone+'</span>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="offer_price_block_wrapper" style=" ' + display + ' ">';
                                    html += '<div class="offer_price_block">';
                                    html +=  offered_to_buyer;
                                    html += '</div>';
                                    html += '<div class="deal_price_block">';
                                    html +=  deal_with_supplier;
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="send_box">';
                                    html += '<a href="javascript:void(0);" class="businessProfileModal'+item.id+'" data-toggle="modal" data-target="#businessProfileModal'+item.id+'">Send <i class="fa fa-chevron-circle-right"></i></a>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal fade businessProfileModal" id="businessProfileModal'+item.id+'" tabindex="-1" role="dialog" aria-labelledby="businessProfileModal'+item.id+'Label" aria-hidden="true">';
                                    html += '<div class="modal-dialog" role="document">';
                                    html += '<div class="modal-content">';
                                    html += '<div class="modal-body">';
                                    html += '<legend>'+item.business_name+'</legend>';
                                    html += '<div class="propose_price_block">';
                                    html += '<div class="row">';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="print_block">';
                                    html += '<label>Offer Price ($)</label>';
                                    html += '<div class="propose_price_input_block">';
                                    html += '<input data-businessprofilename="'+item.business_name+'" type="number" value="" name="propose_price" class="propose_price" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="uom_block">';
                                    html += '<label>Price Unit</label>';
                                    html += '<select name="propose_uom" class="propose_uom form-select form-control">';
                                    html += '<option value="" selected="true" disabled="">Choose your option</option>';
                                    html += '<option value="Pcs">Pcs</option>';
                                    html += '<option value="Lbs">Lbs</option>';
                                    html += '<option value="Gauge">Gauge</option>';
                                    html += '<option value="Yard">Yards</option>';
                                    html += '<option value="Kg">Kg</option>';
                                    html += '<option value="Meter">Meter</option>';
                                    html += '<option value="Dozens">Dozens</option>';
                                    html += '</select>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal-footer">';
                                    html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                                    html += '<button type="button" data-businessprofilealias="'+item.alias+'" data-businessprofilename="'+item.business_name+'" data-businessprofileid="'+item.id+'" data-rfqid="{{$rfq['id']}}" class="btn btn-primary send_offer_price_trigger">Send</button>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    $('.rfq_business_profile_list').append(html);
                                })
                            }else{
                                $('.rfq_business_profile_list').empty();
                                var html = '<div class="alert alert-info" style="width: 100%;">';
                                html += '<p>No Profile found</p>';
                                html += '</div>';
                                $('.rfq_business_profile_list').append(html);
                            }
                        }
                    });
            });

            $(".business_profile_list_trigger_from_backend").click(function(){

                var from_user_image = "{{$from_user_image}}";
                var to_user_image = "{{$to_user_image}}";
                if(selectedValues.length > 0){
                    var html = '<b>Our Suggested Profiles</b><br />';
                    selectedValues.forEach(function(value){
                        html += value + "<br />";
                    });
                    let message = {'message': html, 'image': "", 'from_id' : fromId, 'to_id' : "{{$rfq['user']['user_id']}}", 'rfq_id': "{{$rfq['id']}}",'factory':true,'product': null};
                    socket.emit('new message', message);
                    var from_user_image = "{{$from_user_image}}";
                    var to_user_image = "{{$to_user_image}}";
                    var msgHtml = '<div class="chat chat-right">';
                    msgHtml += '<div class="chat-avatar">';
                    msgHtml += '<a class="avatar">';
                    msgHtml += '<img src="'+from_user_image+'" class="circle" alt="avatar">';
                    msgHtml += '</a>';
                    msgHtml += '</div>';
                    msgHtml += '<div class="chat-body left-align">';
                    msgHtml += '<div class="chat-text">';
                    msgHtml += '<p>'+html+'</p>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
                    $('.chats-box').append(msgHtml);
                    $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
                    $('#businessProfileListByCategoryModal').modal('hide');
                    $('#send_suggested_profiles_to_buyer')[0].reset();
                    $("#factory_type option[value={{$rfq['category'][0]['id']}}]").attr('selected', 'selected');
                    $("#factory_type option[value=0]").attr('selected', 'selected');
                    var businessProfiles = @json($businessProfiles);
                    if( businessProfiles.length >0 ){
                        $('.rfq_business_profile_list').empty();
                        businessProfiles.forEach((item, index)=>{
                            var html ='<div class="business_profile_name">';
                            html+='<div class="form-check">';
                            html+='<label class="form-check-label" for="flexCheckDefault">';
                            html+='<p>'+item.business_name+'</p>';
                            if( item.business_type == 1 ){
                                html+='<p>Manufacturer</p>';
                            }else if( item.business_type == 2){
                                html+='<p>Wholesaler</p>';
                            }
                            html+='<p>Rating: 5 Star</p>';
                            html+='<p>Total Order: 100</p>';
                            html+='</label>';
                            html+='</div>';
                            html+='<div class="propose_price_block">';
                            html+='<div class="print_block">';
                            html+='<label>Offer Price $</label>';
                            html+='<div class="propose_price_input_block">';
                            html+='<input data-businessprofilename="" type="number" value="" name="propose_price" class="propose_price" />';
                            html+='</div>';
                            html+='</div>';
                            html+='<div class="separator_block"> / </div>';
                            html+='<div class="uom_block">';
                            html+='<label>Price Unit</label>';
                            html+='<select name="propose_uom" class="propose_uom form-select form-control">';
                            html+='<option value="" selected="true" disabled="">Choose your option</option>';
                            html+='<option value="Pcs">Pcs</option>';
                            html+='<option value="Lbs">Lbs</option>';
                            html+='<option value="Gauge">Gauge</option>';
                            html+='<option value="Yard">Yards</option>';
                            html+='<option value="Kg">Kg</option>';
                            html+='<option value="Meter">Meter</option>';
                            html+='<option value="Dozens">Dozens</option>';
                            html+='</select>';
                            html+='</div>';
                            html+='</div>';
                            html+='</div>';
                            $('.rfq_business_profile_list').append(html);
                        })
                    }else{
                        $('.rfq_business_profile_list').empty();
                        var html = '<div class="alert alert-info" style="width: 100%;">';
                        html += '<p>No Profile found</p>';
                        html += '</div>';
                        $('.rfq_business_profile_list').append(html);
                    }
                    swal({  icon: 'success',  title: 'Success !!',  text: 'Proposal Sent successfully!',buttons: false});
                }
                else{
                    alert('Enter offer price first');
                }
            })

            $(document).on("click", ".send_offer_price_trigger", function(){
                var business_profile_id = $(this).data("businessprofileid");
                var alias = $(this).data("businessprofilealias");
                var businessName = $(this).data("businessprofilename");
                var businessProfileNameWithUrl = '<a href="/'+alias+'">'+businessName+'</a>';
                var html = businessProfileNameWithUrl+" offers $"+$(this).closest(".modal-content").find(".propose_price").val()+" / "+$(this).closest(".modal-content").find(".propose_uom").val();
                let message = {'message': html, 'image': "", 'from_id' : fromId, 'to_id' : "{{$rfq['user']['user_id']}}",'business_profile_id': business_profile_id ,'business_profile_alias':alias, 'rfq_id': "{{$rfq['id']}}",'factory':true,'product': null};
                socket.emit('new message', message);

                $(this).closest(".businessProfileModal").modal("hide");
                var offer_price = $(this).closest(".modal-dialog").find(".propose_price").val();
                var offer_price_unit = $(this).closest(".modal-dialog").find(".propose_uom").val();
                var rfq_id = $(this).data("rfqid");
                var rfq_owner_email = "{{$rfq['user']['email']}}";
                var offerHtml = "<span>Offered to buyer :</span> <span>$"+offer_price+" / "+offer_price_unit+"</span>";
                $(this).closest(".col-sm-12").find(" .offer_price_block_wrapper ").show();
                $(this).closest(".col-sm-12").find(" .offer_price_block ").html(offerHtml);
                $(this).closest(".col-sm-12").removeClass('no-class').addClass("already-sent");
                $.ajax({
                    method: 'get',
                    data: {rfq_id:rfq_id, rfq_owner_email:rfq_owner_email, business_profile_id:business_profile_id, offer_price:offer_price, offer_price_unit:offer_price_unit},
                    url: '{{ route("admin.rfq.supplier.quotation.to.buyer") }}',
                    success:function(response){
                        console.log(response);
                    }
                });
            });

            $("#modal_close_button").click(function(){
                $('#send_suggested_profiles_to_buyer')[0].reset();
                $("#factory_type option[value={{$rfq['category'][0]['id']}}]").attr('selected', 'selected');
                $("#factory_type option[value=0]").attr('selected', 'selected');
                var businessProfiles = @json($businessProfiles);
                if( businessProfiles.length >0 ){
                    $('.rfq_business_profile_list').empty();
                    businessProfiles.forEach((item, index)=>{
                        var html ='<div class="business_profile_name">';
                        html+='<div class="form-check">';
                        html+='<label class="form-check-label" for="flexCheckDefault">';
                        html+='<p>'+item.business_name+'</p>';
                        if( item.business_type == 1 ){
                            html+='<p>Manufacturer</p>';
                        }else if( item.business_type == 2){
                            html+='<p>Wholesaler</p>';
                        }
                        html+='<p>Rating: 5 Star</p>';
                        html+='<p>Total Order: 100</p>';
                        html+='</label>';
                        html+='</div>';
                        html+='<div class="propose_price_block">';
                        html+='<div class="print_block">';
                        html+='<label>Offer Price</label>';
                        html+='<div class="propose_price_input_block">';
                        html+='$ <input data-businessprofilename="" type="number" value="" name="propose_price" class="propose_price" />';
                        html+='</div>';
                        html+='</div>';
                        html+='<div class="separator_block"> / </div>';
                        html+='<div class="uom_block">';
                        html+='<label>Price Unit</label>';
                        html+='<select name="propose_uom" class="propose_uom form-select form-control">';
                        html+='<option value="" selected="true" disabled="">Choose your option</option>';
                        html+='<option value="Pcs">Pcs</option>';
                        html+='<option value="Lbs">Lbs</option>';
                        html+='<option value="Gauge">Gauge</option>';
                        html+='<option value="Yard">Yards</option>';
                        html+='<option value="Kg">Kg</option>';
                        html+='<option value="Meter">Meter</option>';
                        html+='<option value="Dozens">Dozens</option>';
                        html+='</select>';
                        html+='</div>';
                        html+='</div>';
                        html+='</div>';
                        $('.rfq_business_profile_list').append(html);
                    })
                }else{
                    $('.rfq_business_profile_list').empty();
                    var html = '<div class="alert alert-info" style="width: 100%;">';
                    html += '<p>No Profile found</p>';
                    html += '</div>';
                    $('.rfq_business_profile_list').append(html);
                }
            });

            $('#messagebox').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    //event.preventDefault();
                    var msg = $('#messagebox').val();
                    let message = {'message': msg, 'image': "", 'from_id' : fromId, 'to_id' : "{{$rfq['user']['user_id']}}",'rfq_id': "{{$rfq['id']}}",'business_profile_id': "{{$buyerBusinessProfile['id']}}" ,'business_profile_alias':"{{$buyerBusinessProfile['alias']}}",'factory':false, 'product': null};
                    socket.emit('new message', message);
                    $('#messagebox').val('');
                    $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
                }
            });



            $('.messageSendButton').click(function(){
                //event.preventDefault();
                var msg = $('#messagebox').val();
                let message = {'message': msg, 'image': "", 'from_id' : fromId, 'to_id' : "{{$rfq['user']['user_id']}}",'rfq_id': "{{$rfq['id']}}",'business_profile_id': "{{$buyerBusinessProfile['id']}}" ,'business_profile_alias':"{{$buyerBusinessProfile['alias']}}",'factory':false, 'product': null};
                socket.emit('new message', message);
                $('#messagebox').val('');
                $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
            });

            socket.on('new message', function(data) {
                var userNameShortForm = "{{$userNameShortForm}}";
                var from_user_image = "{{$from_user_image}}";
                var to_user_image = "{{$to_user_image}}";
                var supplierId = $(document).children().find('#supplier-messagedata').attr("data-supplierid");
                var buyerId = $('#messagedata').data('buyerid');

                if( data.rfq_id == "{{$rfq['id']}}" && fromId == data.from_id )
                {
                    var msgHtml = '<div class="chat chat-right">';
                    msgHtml += '<div class="chat-avatar">';
                    msgHtml += '<a class="avatar">';
                    msgHtml += '<img src="'+from_user_image+'" class="circle" alt="avatar">';
                    msgHtml += '</a>';
                    msgHtml += '</div>';
                    msgHtml += '<div class="chat-body left-align">';
                    msgHtml += '<div class="chat-text">';
                    msgHtml += '<p>'+data.message+'</p>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
                    if( supplierId  && supplierId == data.to_id){
                        $('.supplier-chats-box').append(msgHtml);
                        $(".supplier-chat-area").animate({ scrollTop:$('#supplier-messagedata').prop("scrollHeight")});
                    }
                    if( buyerId && buyerId == data.to_id ){
                        $('.chats-box').append(msgHtml);
                        $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
                    }

                }
                else if(data.rfq_id == "{{$rfq['id']}}" && fromId != data.from_id)
                {
                    var msgHtml = '<div class="chat chat-left">';
                    msgHtml += '<div class="chat-avatar">';
                    msgHtml += '<a class="avatar">';
                    if( supplierId  && supplierId == data.from_id ){
                        var imageSource = $('.active_supplier_image').attr('src');
                        var supplierNameShortForm = $('.active_messaging_supplier_name_short_form').text();
                        if(imageSource != ""){
                            msgHtml += '<img src="'+imageSource+'" class="circle" alt="avatar">';
                        }else{
                            msgHtml += '<span>'+supplierNameShortForm+'</span>'
                        }

                    }
                    if( buyerId == data.from_id ){
                        if(to_user_image != ""){
                            msgHtml += '<img src="'+to_user_image+'" class="circle" alt="avatar">';
                        }else{
                            msgHtml += '<span>'+userNameShortForm+'</span>'
                        }
                    }
                    msgHtml += '</a>';
                    msgHtml += '</div>';
                    msgHtml += '<div class="chat-body left-align">';
                    msgHtml += '<div class="chat-text">';
                    msgHtml += '<p>'+data.message+'</p>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
                    var message_count_span = '.sso_id_'+data.from_id;
                    var no_of_unseen_message = $(message_count_span).data('unseenmessagecount');
                    console.log(no_of_unseen_message);
                    console.log(typeof(no_of_unseen_message));
                    if(no_of_unseen_message == 0){
                        $(message_count_span).show();
                        $(message_count_span).text(parseInt( no_of_unseen_message == '' ? '0' : no_of_unseen_message)+1);
                        $(message_count_span).data('unseenmessagecount',parseInt(no_of_unseen_message)+1);
                    }else{
                        $(message_count_span).empty();
                        $(message_count_span).text('');
                        $(message_count_span).text(parseInt(no_of_unseen_message)+1);
                        $(message_count_span).data('unseenmessagecount',parseInt(no_of_unseen_message)+1);
                    }

                    if( supplierId  && supplierId == data.from_id ){

                        $('.supplier-chats-box').append(msgHtml);
                        $(".supplier-chat-area").animate({ scrollTop:$('#supplier-messagedata').prop("scrollHeight")});
                    }
                    if( buyerId == data.from_id ){
                        $('.chats-box').append(msgHtml);
                        $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
                    }

                }

                if(fromId != data.from_id ){
                    jQuery.ajax({
                        type : "get",
                        data : {'rfq_id':data.rfq_id},
                        url : "{{route('send_firebase_push_notification_to_admin_for_rfq_message')}}",
                        success : function(response){
                        }
                    });
                }
            });

            dialog = $( "#dialog-form" ).dialog({
                autoOpen: false,
                height: 400,
                width: 350,
                modal: true,
                buttons: {
                    //Send: messageSendToUser
                },
                close: function( event, ui ) {
                    $('#supplier-messagedata').attr('data-supplierid', "");
                }
            });

            $(document).on("click",".sms_trigger", function() {
                var rfq_id = $(this).data("rfqid");
                var business_profile_id = $(this).data("businessprofileid");
                var business_profile_alias = $(this).data("businessprofilealias");
                var business_name = $(this).data("business_name");
                var sso_reference_id = $(this).data('sso_reference_id');
                var envMode = "{{ env('APP_ENV') }}";
                $('#dialog-form').dialog({title: business_name});
                $('.dialouge_box_rfq_id').val(rfq_id);
                $('.dialouge_box_from_id').val(fromId);
                $('.dialouge_box_business_profile_id').val(business_profile_id);
                $('.dialouge_box_business_profile_alias').val(business_profile_alias);
                $('.dialouge_box_to_id').val(sso_reference_id);
                $('#supplier-messagedata').attr('data-supplierid',sso_reference_id);
                $('.supplier-chats-box').empty();
                jQuery.ajax({
                    type : "get",
                    data : {'rfq_id':rfq_id,'admin_id':fromId,'supplier_id':sso_reference_id,'business_name':business_name},
                    url : "{{route('getchatdata.by.supplierid')}}",
                    success : function(response){
                        console.log(response);
                        response.chatdata.forEach((item, index)=>{
                            if(item.rfq_id == "{{$rfq['id']}}" && fromId == item.from_id)
                            {
                                var msgHtml = '<div class="chat chat-right">';
                                msgHtml += '<div class="chat-avatar">';
                                msgHtml += '<a class="avatar">';
                                msgHtml += '<img src="'+response.adminUserImage+'" class="circle" alt="avatar">';
                                msgHtml += '</a>';
                                msgHtml += '</div>';
                                msgHtml += '<div class="chat-body left-align">';
                                msgHtml += '<div class="chat-text">';
                                msgHtml += '<p>'+item.message+'</p>';
                                msgHtml += '</div>';
                                msgHtml += '</div>';
                                msgHtml += '</div>';
                                $('.supplier-chats-box').append(msgHtml);
                            }
                            else if(item.rfq_id == "{{$rfq['id']}}" && fromId != item.from_id)
                            {
                                var msgHtml = '<div class="chat chat-left">';
                                msgHtml += '<div class="chat-avatar">';
                                msgHtml += '<a class="avatar">';
                                if(response.supplierImage != ""){
                                    msgHtml += '<img src="'+response.supplierImage+'" class="circle active_supplier_image" alt="avatar">';
                                }else{
                                    msgHtml += '<span class="active_messaging_supplier_name_short_form">'+response.supplierNameShortForm+'</span>'
                                }
                                msgHtml += '</a>';
                                msgHtml += '</div>';
                                msgHtml += '<div class="chat-body left-align">';
                                msgHtml += '<div class="chat-text">';
                                msgHtml += '<p>'+item.message+'</p>';
                                msgHtml += '</div>';
                                msgHtml += '</div>';
                                msgHtml += '</div>';
                                $('.supplier-chats-box').append(msgHtml);
                            }
                        })
                        var message_count_span = '.sso_id_'+sso_reference_id;
                        $(message_count_span).text('');
                        $(message_count_span).data('unseenmessagecount',0);
                        $(message_count_span).hide();
                        dialog.dialog("open");

                    }
                });


            });

            $(".messageSendToUser").click(function(){
                var msgText = $('.dialouge_box_message_content').val();
                var rfqId = $('.dialouge_box_rfq_id').val();
                var fromId = $('.dialouge_box_from_id').val();
                var toId = $('.dialouge_box_to_id').val();
                var business_profile_id = $('.dialouge_box_business_profile_id').val();
                var business_profile_alias = $('.dialouge_box_business_profile_alias').val();
                let message = {'message': msgText, 'image': "", 'from_id' : fromId, 'to_id' : toId,'business_profile_id':business_profile_id,'business_profile_alias':business_profile_alias,'rfq_id': rfqId,'factory':false, 'product': null};
                socket.emit('new message', message);
                $('.dialouge_box_message_content').val('');
            });
            $('.dialouge_box_message_content').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    //event.preventDefault();
                    var msgText = $('.dialouge_box_message_content').val();
                    var rfqId = $('.dialouge_box_rfq_id').val();
                    var fromId = $('.dialouge_box_from_id').val();
                    var toId = $('.dialouge_box_to_id').val();
                    var business_profile_id = $('.dialouge_box_business_profile_id').val();
                    var business_profile_alias = $('.dialouge_box_business_profile_alias').val();
                    let message = {'message': msgText, 'image': "", 'from_id' : fromId, 'to_id' : toId,'business_profile_id':business_profile_id,'business_profile_alias':business_profile_alias,'rfq_id': rfqId,'factory':false, 'product': null};
                    socket.emit('new message', message);
                    $('.dialouge_box_message_content').val('');
                    $(".supplier-chat-area").animate({ scrollTop:$('#supplier-messagedata').prop("scrollHeight")});
                }
            });


            //send proforma link for buyer if exists
            var invoice_url_for_buyer='{{$proforma_invoice_url_for_buyer ?? ''}}';
            var url_exists= '{{$url_exists}}';
            if(url_exists == true){
                //var msg = invoice_url_for_buyer;
                if(is_env == "production")
                {
                    var msg = invoice_url_for_buyer;
                    var msg = msg.replace("www.merchantbay.com", "www.app.merchantbay.com/my-panel");
                }
                else
                {
                    var msg = invoice_url_for_buyer;
                }

                let message = {'message': msg, 'image': "", 'from_id' : fromId, 'to_id' : "{{$rfq['user']['user_id']}}",'rfq_id': "{{$rfq['id']}}",'factory':false, 'product': null};
                socket.emit('new message', message);
                $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
            }

            $(".factory_filter_by_title_trigger").change(function(){
                var search_title = $(this).val();
                var rfq_id = "{{$rfq['id']}}";
                console.log(search_title);

                if( search_title !='')
                {
                    $.ajax({
                        method: 'get',
                        data: {search_title:search_title, rfq_id:rfq_id},
                        url: '{{ route("admin.rfq.business.profiles.filter.by.title") }}',
                        success:function(response){
                            console.log(response.businessProfiles);
                            $(".factory_filter_by_title_cancel_trigger").show();
                            if(response.businessProfiles.length >0)
                            {
                                $('.rfq_business_profile_list').empty();
                                response.businessProfiles.forEach((item, index)=>{
                                    console.log(item);

                                    var  className = 'no-class';
                                    var  display  = 'display:none';
                                    var offered_to_buyer = ' ';
                                    var deal_with_supplier=' ';
                                    if(item.supplier_quotation_to_buyer.length > 0){
                                        className = 'already-sent';
                                        display  = 'display:block';
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if(i.from_backend == true){
                                                offered_to_buyer ='<span>Offered to buyer :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }

                                        });
                                        item.supplier_quotation_to_buyer.forEach((i, idx)=>{
                                            if( i.from_backend == false){
                                                deal_with_supplier ='<span>Quoted by supplier :</span> <span>$'+i.offer_price+' / '+i.offer_price_unit+'</span>';
                                                return false;
                                            }
                                        });
                                    }
                                    var html = '<div class="col-sm-12 col-md-6 col-lg-4"'+className+'>';
                                    html += '<div class="suppliersBoxWrap">';
                                    html += '<div class="suppliers_box">';
                                    html += '<div class="suppliers_imgBox">';
                                    html += '<div class="imgBox">';
                                    //let image = "{{asset('storage')}}"+'/'+item.user.image;
                                    let image = "{{Storage::disk('s3')->url('public')}}"+'/'+item.user.image;
                                    html += '<img src="'+image+'" alt="" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="suppliers_textBox">';
                                    html += '<div class="title_box">';
                                    html += '<h3><a target="_blank" href=/'+item.alias+'>'+item.business_name+'</a></h3>';
                                    html += '<div class="sms_img">';
                                    if(response.associativeArrayUsingIDandCount[item.user.sso_reference_id]){
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span data-unseenmessagecount="'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'" class="sso_id_'+item.user.sso_reference_id+'">'+response.associativeArrayUsingIDandCount[item.user.sso_reference_id]['count']+'</span></a>';
                                    }else{
                                        html += '<a href="javascript:void(0);" class="sms_trigger" data-business_name ="'+item.business_name+'" data-rfqid="{{$rfq['id']}}" data-sso_reference_id="'+item.user.sso_reference_id+'" data-businessprofileid="'+item.id+'" data-businessprofilealias="'+item.alias+'"><i class="fa fa-envelope"></i><span style="display: none" data-unseenmessagecount="0"  class="sso_id_'+item.user.sso_reference_id+'"></span></a>';
                                    }
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="sms_details_box">';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Person <br/>';
                                    html += '<span>'+item.user.name+'</span>';
                                    html += '</div>';
                                    html += '<div class="sms_details">';
                                    html += 'Contact Number <br/>';
                                    html += '<span>'+item.user.phone+'</span>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="offer_price_block_wrapper" style=" ' + display + ' ">';
                                    html += '<div class="offer_price_block">';
                                    html +=  offered_to_buyer;
                                    html += '</div>';
                                    html += '<div class="deal_price_block">';
                                    html +=  deal_with_supplier;
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="send_box">';
                                    html += '<a href="javascript:void(0);" class="businessProfileModal'+item.id+'" data-toggle="modal" data-target="#businessProfileModal'+item.id+'">Send <i class="fa fa-chevron-circle-right"></i></a>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal fade businessProfileModal" id="businessProfileModal'+item.id+'" tabindex="-1" role="dialog" aria-labelledby="businessProfileModal'+item.id+'Label" aria-hidden="true">';
                                    html += '<div class="modal-dialog" role="document">';
                                    html += '<div class="modal-content">';
                                    html += '<div class="modal-body">';
                                    html += '<legend>'+item.business_name+'</legend>';
                                    html += '<div class="propose_price_block">';

                                    html += '<div class="row">';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="print_block">';
                                    html += '<label>Offer Price ($)</label>';
                                    html += '<div class="propose_price_input_block">';
                                    html += '<input data-businessprofilename="'+item.business_name+'" type="number" value="" name="propose_price" class="propose_price" />';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="col-sm-12 col-md-6">';
                                    html += '<div class="uom_block">';
                                    html += '<label>Price Unit</label>';
                                    html += '<select name="propose_uom" class="propose_uom form-select form-control">';
                                    html += '<option value="" selected="true" disabled="">Choose your option</option>';
                                    html += '<option value="Pcs">Pcs</option>';
                                    html += '<option value="Lbs">Lbs</option>';
                                    html += '<option value="Gauge">Gauge</option>';
                                    html += '<option value="Yard">Yards</option>';
                                    html += '<option value="Kg">Kg</option>';
                                    html += '<option value="Meter">Meter</option>';
                                    html += '<option value="Dozens">Dozens</option>';
                                    html += '</select>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '<div class="modal-footer">';
                                    html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                                    html += '<button type="button" data-businessprofilealias="'+item.alias+'" data-businessprofilename="'+item.business_name+'" data-businessprofileid="'+item.id+'" data-rfqid="{{$rfq['id']}}" class="btn btn-primary send_offer_price_trigger">Send</button>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    html += '</div>';
                                    $('.rfq_business_profile_list').append(html);
                                })
                            }
                            else
                            {
                                $('.rfq_business_profile_list').empty();
                                var html = '<div class="alert alert-info" style="width: 100%;">';
                                html += '<p>No Profile found</p>';
                                html += '</div>';
                                $('.rfq_business_profile_list').append(html);
                            }
                        }
                    });
                }
            });

            $(".factory_filter_by_title_cancel_trigger").click(function(){
                $(".factory_filter_by_title_trigger").val("");
                window.location.reload();
            })

        });

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 180) {
                $(".buyer-message-card").css({"position": "fixed", "top": "0px", "right": "0px", "max-width": "22%"});
            } else {
                $(".buyer-message-card").css({"position": "inherit", "top": "inherit", "right": "inherit", "max-width": "25%"});
            }
        });


    </script>
@endpush
