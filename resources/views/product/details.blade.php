@extends('layouts.app')

@section('pagetitle', 'Merchantbay | ' . $product->name . ' product on merchantbay.com' ?? '')
@section('title', $product->name . ' product on merchantbay.com' ?? '')
@section('description', $product->name . ' product on merchantbay.com' ?? '')

@if(isset($product->images[0]->image))
    @section('image', Storage::disk('s3')->url('public/'.$product->images[0]->image) ?? "")
    @section('ogimage', Storage::disk('s3')->url('public/'.$product->images[0]->image) ?? "")
@else
    @section('image', Storage::disk('s3')->url('public/images/supplier.png') ?? "")
    @section('ogimage', Storage::disk('s3')->url('public/images/supplier.png') ?? "")
@endif
@section('ogtitle', $product->name ?? '')
@section('ogdescription', $product->name ?? '')

@section('keywords', $product->name . ' product on merchantbay.com' ?? '')
@section('robots', 'index, nofollow')

@section('content')
@include('sweet::alert')
@php
$relatedProducts = relatedProductInformation($product->id);
$productReviews = singleProductReviewInformation($product->id);
$reviewsCount = count($productReviews);
@endphp

@include('product._create_rfq_form_modal')
<input type="hidden" name="product_sku" value="{{$product->sku}}">


<div class="new_design_product_detail_wrap">
    <div class="back_to">
        <a href="{{ url()->previous() }}"> <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/back-arrow.png')}}" alt="" ></a>
    </div>
    <div class="new_design_product_detail">
    <!-- First Column Container -->
        <div class="row">
            <div class="col s12 m3">
                <div class="tabs_wrapper lab_header">
                    <!-- Tabs -->
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li class="tab col m6"><a class="active" href="#projectHighlight">PRODUCT HIGHLIGHT</a></li>
                                <li class="tab col m6"><a href="#supplierInfo">SUPPLIER INFO</a></li>
                            </ul>
                        </div>

                        <!-- First tabs contant -->
                        <div id="projectHighlight" class="col s12">
                            <div class="row tab_first_btn">
                                <div class="col s12 m4 product_btn">
                                    <!--h6>SS 2023</h6-->
                                </div>
                                <div class="col s12 m8">
                                    @if($product->is_new_arrival == 1)
                                    <button class="arrival_btn">NEW ARRIVAL</button>
                                    @endif
                                </div>
                            </div>
                            <div>
                                {!! $product->description !!}
                            </div>
                            @if($product->product_type==2 || $product->product_type== 3)
                            <div class="margin_top">
                                <h5 class="margin_top">AVAILABLE COLORS</h5>
                                <div class="row">
                                    <div class="col s12 l10 size_wrapper">
                                        @foreach($colors_sizes as $color)
                                        <div class="size_border"><span class="text_center">{{$color->color}}</span></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="margin_top">
                                <h5 class="margin_top">CUSTOMIZATION</h5>
                                <P>{{$product->customize ? "Yes" : "No"}}</P>
                            </div>
                        </div>
                        <!-- Second tabs contant -->
                        <div id="supplierInfo" class="col s12">
                            @php
                                $companyInfo = json_decode($supplierCompanyInfo->companyOverview['data']);
                                //echo "<pre>"; print_r($companyInfo); echo "</pre>";
                            @endphp
                            @foreach($companyInfo as $item)
                                @php
                                    //echo "<pre>"; print_r($item); echo "</pre>";
                                @endphp
                                @if($item->name == "year_of_establishment")
                                    @if(isset($item->value))
                                        <div class="margin_top">
                                            <h6>EXPERIENCE</h6>
                                            <p>{{date("Y") - $item->value}} Years</p>
                                        </div>
                                    @endif
                                @endif
                                @if($item->name == "number_of_worker")
                                    @if(isset($item->value))
                                        <div class="margin_top">
                                            <h6>EMPLOYEE SIZE</h6>
                                            <p>{{$item->value}} Years</p>
                                        </div>
                                    @endif
                                @endif
                                @if($item->name == "main_products")
                                    @if(isset($item->value))
                                        <div class="margin_top">
                                            <h6>MAIN PRODUCTS</h6>
                                            <p>{{$item->value}} Years</p>
                                        </div>
                                    @endif
                                @endif
                            @endforeach

                            @if(count($supplierCompanyInfo->certifications) > 0)
                            <div class="margin_top">
                                <h6 class="margin_top">CERTIFICATES</h6>
                                <div class="image_wrapper">
                                    <div><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                    <div><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                    <div><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                    <div><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                </div>
                            </div>
                            @endif

                            <div class="row contact_supplier">
                                <div class="col s12 l6">
                                    <!--button class="btn_contact_supplier">Contact Supplier</button-->
                                </div>
                                <div class="col s12 l6">
                                    <a class="btn_contact_supplier" href="{{route('supplier.profile', $product->businessProfile->alias)}}">Visit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Column Container -->
            <div class="col s12 m6">
                <div class="new_design_product_preview_wrap">
                    <div class="product_preview_wrap">

                        <div class="product-images">
                            <div class="row">
                                <div class="col s12 m8">
                                    <div class="product-main-image">
                                        <div class="pre-loading-image-gallery"><img src="{{Storage::disk('s3')->url('public/frontendimages/ajax-search-loader-bar.gif')}}" width="80" height="80" alt="Loading"></div>
                                        <div class="product-large-image-block product_details_imgwrap">
                                            @if(count($product->images)> 0)
                                                @foreach ($product->images as $image)
                                                    <div class="details_gallery_box">
                                                        <a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}">
                                                            <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="300px"/>
                                                            <div class="click-to-zoom">
                                                                <i class="material-icons dp48">zoom_in</i>
                                                                <!-- Click on image to view large size. -->
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m4 product_details_right_image">
                                    <div class="row">
                                        @if(count($product->images)> 0)
                                            @foreach ($product->images as $image)
                                                @if($image->is_raw_materials == 0)
                                                <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="100px" />
                                                @else
                                                <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="100px" />
                                                @endif
                                            @endforeach
                                        @endif
                                        {{-- <div class="col s6 details_img_list">
                                            <ul class="product-list-images-block">
                                                @if(count($product->images)> 0)
                                                    @foreach ($product->images as $image)
                                                        <li><a href="javascript:void(0);"><img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="100px" /></a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="col s6 details_img_list">
                                            <ul class="product-list-images-block">
                                                @if(count($product->images)> 0)
                                                    @foreach ($product->images as $image)
                                                        <li><a href="javascript:void(0);"><img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="100px" /></a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div> --}}

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Third Column Container-->
            <div class="col s12 m3">
                @if($product->video)
                <div>
                    <video controls height="245" width="300">
                        <source src="{{Storage::disk('s3')->url('public/'.$product->video->video)}}" type="video/mp4" />
                    </video>
                </div>
                @endif
                <h5 class="margin_top">{{ $product->name }}</h5>
                <div class="sweatshit_wrapper margin_top">
                    <!-- Product div -->
                    <div class="row">
                        <div class=" col s12 m6">
                            <div class="attribute_box">
                                <P>PRODUCT CODE</P>
                                <P class="font_weight">{{$product->id}}</P>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="attribute_box">
                                <P>MOQ</P>
                                <P><span class="font_weight">{{ $product->moq }}</span> {{$product->product_unit}}</P>
                            </div>
                        </div>
                        <!-- Pricing  -->
                        <div class="col s12 m6">
                            <div class="attribute_box">
                                <p>PRICE</p>
                                <p>
                                    <span class="font_weight">
                                        @php
                                            $count= count(json_decode($product->attribute));
                                            $count = $count-2;
                                        @endphp
                                        <span class="price_negotiable">
                                            @foreach (json_decode($product->attribute) as $k => $v)
                                                @if($k == 0 && $v[2] == 'Negotiable')
                                                {{ 'Negotiable' }}
                                                @endif
                                                @if($loop->last && $v[2] != 'Negotiable')
                                                <span class="nego_price">
                                                    ${{ $v[2] }}
                                                </span>
                                                @endif
                                                @if($loop->last && $v[2] == 'Negotiable')
                                                    @foreach (json_decode($product->attribute) as $k => $v)
                                                            @if($k == $count)
                                                                ${{ $v[2]  }} {{ 'Negotiable' }}
                                                            @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </span>
                                    </span>
                                </p>
                                <a class="modal-trigger" href="#price-breakdown-modal">View details</a>
                                <!-- Modal Structure -->
                                <div id="price-breakdown-modal" class="modal">
                                    <h5>PRICE BREAKDOWN</h5>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>MIN QTY</th>
                                                <th>MAX QTY</th>
                                                <th>PRICE $(USD)</th>
                                                @if($product->product_type==1) <th>LEAD TIME (DAYS) </th>@endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($attr as $key=>$list)
                                            <tr>
                                                <td>{{$list[0]}}</td>
                                                <td>{{$list[1]}}</td>
                                                <td>{{$list[2]}}</td>
                                                @if($product->product_type==1) <td data-title="Lead Time">{{$list[3]}} days</td>@endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="modal-footer">
                                        <a href="javascript:void(0);"
                                            class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($product->product_type==1)
                        <div class="col s12 m6">
                            <div class="attribute_box">
                                <p>LEAD TIME</p>
                                <p>
                                    @php
                                        $numItems = count($attr);
                                        $i = 0;
                                    @endphp
                                    @foreach($attr as $key=>$list)
                                        @if(++$i === $numItems)
                                            <span class="font_weight">{{$list[3]}}</span> days
                                        @endif
                                    @endforeach
                                </p>
                                <!--a href="javascript:void(0);">View details</a-->
                            </div>
                        </div>
                        @endif

                        <!-- Sample and ready stock -->
                        @if($product->sample_availability==1)
                        <div class="col s12 m6">
                            <div class="attribute_box">
                                <p>SAMPLE</p>
                                <p class="font_weight">Available</p>
                            </div>
                        </div>
                        @endif

                        <!--div class="col s12 m6">
                            <h6>READY STOCK</h6>
                            <p class="font_weight">Available</p>
                        </div-->

                        <!-- Button -->
                        <!--div class="col s12 m6">
                            <button class="btn_bg_yellow">Ask for Sample</button>
                        </div>

                        <div-- class="col s12 m6">
                            <button class="btn_bg_yellow">Buy Now</button>
                        </div-->

                    </div>

                    <!-- Quotation button -->
                    <div class="margin_top">
                        <a class="quotation_btn margin_top" href="{{route('rfq.create',[$product->flag, $product->id])}}">REQUEST FOR QUOTATION</a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <p>Recomendation product block will show here from below</p>

</div>


<div class="product_details_wrapper">
    @if ($orderModificationRequest->isNotEmpty())
    <div class="card-alert card cyan">

        <div class="card-content white-text">
            <p>INFO : You have already sent modification request for this product.</p>
        </div>
        <button style="position: absolute; top: -13px; right: 0px; color: #000;" type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    {{-- <div class="back_to">
        <a href="{{ url()->previous() }}"> <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/back-arrow.png')}}" alt="" ></a>
    </div> --}}
    <div class="single-product-details-block-wrapper">

        <div class="product_details_content_wrap">

            <div class="product_preview_info_wrap single-product-details-wrapper">
                <div class="single_product_preview_inner_info">
                    <div class="row">
                        <div class="col s12 m5 product_preview_wrap">
                            @if($product->video)
                                <div class="product-images">
                                    <div class="video_content">
                                        <div class="details_video_box">
                                            <video controls height="245" width="300">
                                                <source src="{{Storage::disk('s3')->url('public/'.$product->video->video)}}" type="video/mp4" />
                                            </video>
                                        </div>
                                    </div>
                                    <ul class="product-list-images-block">
                                        @if(count($product->images)> 0)
                                            @foreach ($product->images as $image)
                                                <li>
                                                    <a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}"><img src="{{Storage::disk('s3')->url('public/'.$image->original)}}" class="responsive-img" width="100px" /></a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <div class="product-images">
                                    <div class="product-main-image">
                                        <div class="pre-loading-image-gallery"><img src="{{Storage::disk('s3')->url('public/frontendimages/ajax-search-loader-bar.gif')}}" width="80" height="80" alt="Loading"></div>
                                        <div class="product-large-image-block product_details_imgwrap">
                                            @if(count($product->images)> 0)
                                                @foreach ($product->images as $image)
                                                    <div class="details_gallery_box">
                                                        <a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}">
                                                            <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="300px"/>
                                                            <div class="click-to-zoom">
                                                                <i class="material-icons dp48">zoom_in</i>
                                                                <!-- Click on image to view large size. -->
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if($product->overlay_original_image)
                                            <div>
                                                <center>
                                                    <a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$product->overlay_original_image)}}" class="responsive-img" width="300px"/>

                                                        <div class="click-to-zoom">
                                                            <i class="material-icons dp48">zoom_in</i>
                                                            <!-- Click on image to view large size. -->
                                                        </div>
                                                    </a>
                                                </center>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <ul class="product-list-images-block">
                                        @if(count($product->images)> 0)
                                            @foreach ($product->images as $image)
                                                <li><a href="javascript:void(0);"><img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="100px" /></a></li>
                                            @endforeach
                                        @endif
                                        @if($product->overlay_original_image)
                                                <li><a href="javascript:void(0);"><img src="{{Storage::disk('s3')->url('public/'.$product->overlay_original_image)}}" class="responsive-img" width="100px" /></a></li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col s12 m7 product_details_info_wrap">
                            <div class="row">
                                <div class="col s12">
                                    <div class="seller-store">
                                        <a href="{{route('supplier.profile', $product->businessProfile->alias)}}">{{$product->businessProfile->business_name}}</a>
                                    </div>
                                </div>

                                <!-- <div class="product_stock col s12 m6 l6 right-align">
                                    <div class="single-product-availability">Availability: <span>instock</span></div>
                                </div> -->

                            </div>
                            <div class="product_details_title_box">
                                <h1>{{ $product->name }}</h1>
                            </div>

                            <!-- <div class="row">
                                <div class="col s12 m6 l6 left-align">
                                    <div class="seller-store">
                                        <a href="{{route('supplier.profile', $product->businessProfile->alias)}}">{{$product->businessProfile->business_name}}</a>
                                        {{-- <a href="{{ route('users.myshop',$product->vendor->vendor_uid) }}"><i class="material-icons dp48">store</i> {{ $product->vendor->vendor_name }}</a> --}}
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 right-align">
                                    <button class="btn_grBorder">Full Stock only</button>
                                </div>
                            </div> -->

                            <!-- <div class="product_description">
                                {!! $product->description !!}
                            </div> -->



                            <!-- <h4>{{ $product->name }}</h4> -->
                            <div class="row single-product-details-top">
                                <div class="col s12">
                                    @if($product->availability==0 && ($product->product_type==2 || $product->product_type== 3))
                                        <span class="new badge red sold_out" data-badge-caption="Sold Out" style="height: auto; line-height: normal; font-size: 16px; padding: 5px 10px;"></span>
                                    @endif

                                    @if($product->full_stock== 1)
                                        <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label btn_grBorder full_stock" style="display: none;">Full Stock only</span>
                                    @else
                                        <div class="row">
                                            <div class="col s12 m6">
                                                <div class="single-product-moq">
                                                    MOQ: <br/> <span> {{ $product->moq }} </span><span class="unit">{{$product->product_unit}} </span>
                                                </div>
                                            </div>
                                            <div class="col s12 m6">
                                                <div class="single-product-price">
                                                    <div class="label">Price:</div>
                                                    <div class="single-product-price-value">
                                                        @php
                                                            $count= count(json_decode($product->attribute));
                                                            $count = $count-2;
                                                        @endphp
                                                        <span class="price_negotiable">
                                                            @foreach (json_decode($product->attribute) as $k => $v)
                                                                @if($k == 0 && $v[2] == 'Negotiable')
                                                                {{ 'Negotiable' }}
                                                                @endif
                                                                @if($loop->last && $v[2] != 'Negotiable')
                                                                <span class="nego_price">
                                                                    ${{ $v[2] }}
                                                                </span>
                                                                @endif
                                                                @if($loop->last && $v[2] == 'Negotiable')
                                                                    @foreach (json_decode($product->attribute) as $k => $v)
                                                                            @if($k == $count)
                                                                                ${{ $v[2]  }} {{ 'Negotiable' }}
                                                                            @endif
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-product-price">
                                            {{-- <div class="label">Price:</div> --}}
                                            <div class="single-product-price-value">
                                                {{-- @php
                                                    $count= count(json_decode($product->attribute));
                                                    $count = $count-2;
                                                @endphp
                                                <span class="price_negotiable">
                                                    @foreach (json_decode($product->attribute) as $k => $v)
                                                        @if($k == 0 && $v[2] == 'Negotiable')
                                                        {{ 'Negotiable' }}
                                                        @endif
                                                        @if($loop->last && $v[2] != 'Negotiable')
                                                        <span class="nego_price">
                                                            ${{ $v[2] }}
                                                        </span>
                                                        @endif
                                                        @if($loop->last && $v[2] == 'Negotiable')
                                                            @foreach (json_decode($product->attribute) as $k => $v)
                                                                    @if($k == $count)
                                                                        ${{ $v[2]  }} {{ 'Negotiable' }}
                                                                    @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </span> --}}
                                                <!-- <a href="javascript:void(0);" class="show_attr_trigger show_more_price_options btn_grBorder">Show more</a>
                                                <div class="col-md-12" id="attr-block" style="display: none;"> -->
                                                <div class="col-md-12" id="attr-block">
                                                    <div class="ready_order_attr_block">
                                                        <div class="no_more_tables">
                                                            <table style="border: 1px solid #ccc;" class="fresh-order-attributes">
                                                                <tr class="tr_none_mobile">
                                                                    <td>Quantity({{$product->product_unit}})</td>
                                                                    <td>Price</td>
                                                                    @if($product->product_type==1) <td>Lead Time </td>@endif
                                                                </tr>
                                                                @foreach($attr as $key=>$list)
                                                                <tr class="ready_attr_data">
                                                                    <td data-title="Quantity" class="price-range-block"><span class="min-price">{{$list[0]}}</span> <span class="price-range-separator">-</span> <span class="max-price">{{$list[1]}}</span></td>
                                                                    <td data-title="Price">{{$list[2]}}</td>
                                                                    @if($product->product_type==1) <td data-title="Lead Time">{{$list[3]}} days</td>@endif
                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td data-title="Product Code">Product Code: </td>
                                                                    <td data-title="Shop Id" >shop-{{$product->id}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td data-title="">**Any kind of customization is possible.</td>
                                                                    <td data-title="">Yes</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($product->customize == true)
                                            <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label" style="display: none">Can be Customized</span>
                                        @endif
                                    @endif

                                    <!-- <div class="single-product-review-stars">
                                        <div class="star-rating" data-score="{{$averageRating}}"></div>
                                        <span>{{$averageRating}} out of 5</span>
                                    </div> -->

                                </div>
                            </div>

                            <div class="row single-product-details-bottom">
                                <div class="col s12 m12">
                                    <div class="single-product-details" style="display: none;">
                                    {!! $product->description !!}
                                    </div>
                                    <div class="single-product-attributes">

                                        @if($product->product_type==2 || $product->product_type== 3)
                                            <div class="single-product-colors">
                                                <span>Available Colors:</span>
                                                <ul>
                                                    @foreach($colors_sizes as $color)
                                                    <li><a href="javascript:void(0);">{{$color->color}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if($product->product_type==1)
                                            <div class="single-product-add-to-cart">
                                                {{-- <div class="cart-item-block">
                                                    <button type="button" id="trigger_minus" class="trigger_minus btn green"><i class="material-icons dp48">remove</i></button>
                                                    <input type="number" name="fresh_input" class="fresh_input_value" value="0" min="1" />
                                                    <button type="button" id="trigger_plus" class="trigger_plus btn green"><i class="material-icons dp48">add</i></button>
                                                </div> --}}
                                                <div class="fresh_order_block_wrapper" style="display: none;">
                                                    <a class="waves-effect waves-light modal-trigger customaize_order_trigger" href="#fresh_order_customize_block">Customize Your Order</a>
                                                    @if(auth::check())
                                                        <a class="waves-effect waves-light modal-trigger request_order_modification_trigger" href="#product-modification-modal">Request for Modification</a>
                                                    @else
                                                        <a class="waves-effect waves-light modal-trigger request_order_modification_trigger" href="#login-register-modal">Request for Modification</a>
                                                    @endif
                                                </div>
                                                <div id="fresh_order_customize_block" class="modal modal-fixed-footer">
                                                    <div class="modal-content">

                                                        <div class="no_more_tables">
                                                            <table class="color-size-table-block striped">
                                                                <thead class="cf">
                                                                    <tr>
                                                                        <th>Color</th>
                                                                        <th>XXS</th>
                                                                        <th>XS</th>
                                                                        <th>Small</th>
                                                                        <th>Medium</th>
                                                                        <th>Large</th>
                                                                        <th>Extra Large</th>
                                                                        <th>XXL</th>
                                                                        <th>XXXL</th>
                                                                        <th>4XXL</th>
                                                                        <th>One Size</th>
                                                                        <!-- <th>&nbsp;</th> -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="cusotmize-color-size-attr-tbody">
                                                                    <tr class="tr">
                                                                        <td data-title="Color"><input class="combat" type="text" value="" name="color"/></td>
                                                                        <td data-title="XXS"><input class="combat" type="text" value="" name="xxs" /></td>
                                                                        <td data-title="XS"><input class="combat" type="text" value="" name="xs" /></td>
                                                                        <td data-title="Small"><input class="combat" type="text" value="" name="small" /></td>
                                                                        <td data-title="Medium"><input class="combat" type="text" value="" name="medium" /></td>
                                                                        <td data-title="Large"><input class="combat" type="text" value="" name="large" /></td>
                                                                        <td data-title="Extra Large"><input class="combat" type="text" value="" name="extra_large" /></td>
                                                                        <td data-title="XXL"><input class="combat" type="text" value="" name="xxl" /></td>
                                                                        <td data-title="XXXL"><input class="combat" type="text" value="" name="xxxl" /></td>
                                                                        <td data-title="4XXL"><input class="combat" type="text" value="" name="four_xxl" /></td>
                                                                        <td data-title="One Size"><input class="combat" type="text" value="" name="one_size" /></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="add_more_box" style="padding: 20px 0">
                                                            <a href="javascript:void(0);" class="add-more-block" onclick="addFreshOrderColorSize()"><i class="material-icons dp48">add</i> Add More</a>
                                                        </div>
                                                        <!-- <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addFreshOrderColorSize()"><i class="material-icons dp48">add</i> Add More</a> -->
                                                        <div class="total-price-block" style="display: none;">
                                                            <div class="input-wrapper">
                                                                <label>Total Qty:</label>
                                                                <span class="item_total_qty"></span>
                                                            </div>
                                                            <div class="input-wrapper">
                                                                <label>Unit Price: $</label>
                                                                <span class="item_unit_price"></span>
                                                            </div>
                                                            <div class="input-wrapper">
                                                                <label>Total Price: $</label>
                                                                <span class="item_total_price"></span>
                                                            </div>
                                                        </div>
                                                        <div class="price-calculation-notification" style="display: none;">
                                                            <div class="card-alert card cyan">
                                                                <div class="card-content white-text" style="padding: 10px;">
                                                                    Please click on calculate price button. To get updated price calculation.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="javascript:void(0);" class="waves-effect waves-green btn-flat price-calculation">Calculate Total Price</a>
                                                        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat update-price-btn green white-text" disabled="disabled">Update</a>
                                                        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
                                                            <i class="material-icons green-text text-darken-1">close</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($product->product_type==2)
                                            <div class="ready_stock_block_wrapper">
                                                <div class="row" style="margin-bottom: 0px;">
                                                    <div class="col m12 ready_stock left-align">
                                                        <span class="btn_grBorder badge badge pill green accent-2 mr-2 ready-to-ship-label ready_to_ship">Ready to Ship</span>
                                                        @if($product->full_stock==1)
                                                        <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label btn_grBorder full_stock">Full Stock only</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($product->availability != 0)
                                                <a class="waves-effect waves-light modal-trigger customaize_order_trigger" href="#ready_stock_order_customize_block" style="display: none;">Customize Your Order</a>
                                                @endif
                                                <div id="ready_stock_order_customize_block" class="modal modal-fixed-footer">
                                                    <div class="modal-content">
                                                        <div class="no_more_tables">
                                                            <table class="color-size-table-block-prob striped ready-stock-table-block" width="100%" cellpadding="0" cellspacing="0">
                                                                <thead class="cf">
                                                                    <tr>
                                                                        <th>Color</th>
                                                                        <th>XXS</th>
                                                                        <th>XS</th>
                                                                        <th>Small</th>
                                                                        <th>Medium</th>
                                                                        <th>Large</th>
                                                                        <th>Extra Large</th>
                                                                        <th>XXL</th>
                                                                        <th>XXXL</th>
                                                                        <th>4XXL</th>
                                                                        <th>One Size</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="cusotmize-color-size-attr-tbody">
                                                                    @if($product->full_stock == 1)
                                                                        @foreach($colors_sizes as $color)
                                                                            <tr class="tr">
                                                                                <td data-title="Color">
                                                                                    <input class="combat" type="text" value="{{$color->color}}" name="color" readonly />

                                                                                </td>
                                                                                <td data-title="XXS">
                                                                                    @if(!empty($color->xxs))
                                                                                        <input class="combat" type="text" value="{{ $color->xxs }}" name="xxs" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xxs" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="XS">
                                                                                    @if(!empty($color->xs))
                                                                                        <input class="combat" type="text" value="{{$color->xs}}" name="xs" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xs" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Small">
                                                                                    @if(!empty($color->small))
                                                                                        <input class="combat" type="text" value="{{$color->small}}" name="small" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="small" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Medium">
                                                                                    @if(!empty($color->medium))
                                                                                        <input class="combat" type="text" value="{{$color->medium}}" name="medium" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="medium" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Large">
                                                                                    @if(!empty($color->large))
                                                                                        <input class="combat" type="text" value="{{$color->large}}" name="large" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="large" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Extra Large">
                                                                                    @if(!empty($color->extra_large))
                                                                                        <input class="combat" type="text" value="{{$color->extra_large}}" name="extra_large" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="extra_large" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="XXL">
                                                                                    @if(!empty($color->xxl))
                                                                                        <input class="combat" type="text" value="{{$color->xxl}}" name="xxl" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xxl" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="XXXL">
                                                                                    @if(!empty($color->xxxl))
                                                                                        <input class="combat" type="text" value="{{$color->xxxl}}" name="xxxl" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xxxl" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="4XXL">
                                                                                    @if(!empty($color->four_xxl))
                                                                                        <input class="combat" type="text" value="{{$color->four_xxl}}" name="four_xxl" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="four_xxl" readonly />

                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="One Size">
                                                                                    @if(!empty($color->one_size))
                                                                                        <input class="combat" type="text" value="{{$color->one_size}}" name="one_size" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="one_size" readonly />

                                                                                    @endif
                                                                                </td>
                                                                            </tr>

                                                                        @endforeach
                                                                    @else
                                                                        @foreach($colors_sizes as $color)
                                                                            <tr class="tr">
                                                                                <td data-title="Color">
                                                                                    <input class="combat" type="text" value="{{$color->color}}" name="color" readonly />
                                                                                    <span class="avl-wrap">&nbsp;</span>
                                                                                </td>
                                                                                <td data-title="XXS">
                                                                                    @if(!empty($color->xxs))
                                                                                        <input class="combat" type="text" value="" name="xxs" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->xxs}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xxs" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="XS">
                                                                                    @if(!empty($color->xs))
                                                                                        <input class="combat" type="text" value="" name="xs" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->xs}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xs" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Small">
                                                                                    @if(!empty($color->small))
                                                                                        <input class="combat" type="text" value="" name="small" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->small}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="small" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Medium">
                                                                                    @if(!empty($color->medium))
                                                                                        <input class="combat" type="text" value="" name="medium" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->medium}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="medium" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Large">
                                                                                    @if(!empty($color->large))
                                                                                        <input class="combat" type="text" value="" name="large" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->large}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="large" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="Extra Large">
                                                                                    @if(!empty($color->extra_large))
                                                                                        <input class="combat" type="text" value="" name="extra_large" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->extra_large}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="extra_large" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="XXL">
                                                                                    @if(!empty($color->xxl))
                                                                                        <input class="combat" type="text" value="" name="xxl" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->xxl}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xxl" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="XXXL">
                                                                                    @if(!empty($color->xxxl))
                                                                                        <input class="combat" type="text" value="" name="xxxl" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->xxxl}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="xxxl" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="4XXL">
                                                                                    @if(!empty($color->four_xxl))
                                                                                        <input class="combat" type="text" value="" name="four_xxl" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->four_xxl}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="four_xxl" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td data-title="One Size">
                                                                                    @if(!empty($color->one_size))
                                                                                        <input class="combat" type="text" value="" name="one_size" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->one_size}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="one_size" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="total-price-block" style="display: none;">
                                                            <div class="input-wrapper">
                                                                <label>Total Qty:</label>
                                                                <span class="item_total_qty"></span>
                                                            </div>
                                                            <div class="input-wrapper">
                                                                <label>Unit Price: $</label>
                                                                <span class="item_unit_price"></span>
                                                            </div>
                                                            <div class="input-wrapper">
                                                                <label>Total Price: $</label>
                                                                <span class="item_total_price"></span>
                                                            </div>
                                                        </div>
                                                        <div class="price-calculation-notification" style="display: none;">
                                                            <div class="card-alert card cyan">
                                                                <div class="card-content white-text" style="padding: 10px;">
                                                                    Please click on calculate price button. To get updated price calculation.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($product->full_stock==1)
                                                            <div class="price-calculation-notification" >
                                                                <div class="card-alert card cyan">
                                                                    <div class="card-content white-text" style="font-size: 12px;">
                                                                        This is full stock feature Please click on calculate price button. To get updated price calculation.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="javascript:void(0);" class="waves-effect waves-green btn-flat price-calculation">Calculate Total Price</a>
                                                        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat update-price-btn green white-text" disabled="disabled">Update</a>
                                                        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
                                                            <i class="material-icons green-text text-darken-1">close</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- start non clothing type --}}
                                        @if($product->product_type==3)
                                            <div class="ready_stock_block_wrapper">
                                                <div class="row" style="margin-bottom: 0px;">
                                                    <div class="col m12">
                                                        <span class="badge badge pill green accent-2 mr-2 ready-to-ship-label btn_grBorder ready_to_ship">Ready to Ship</span>
                                                        @if($product->full_stock==1)
                                                        <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label btn_grBorder full_stock">Full Stock only</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($product->availability != 0)
                                                <a class="waves-effect waves-light modal-trigger customaize_order_trigger" href="#ready_stock_order_customize_block" style="display: none;">Customize Your Order</a>
                                                @endif
                                                <div id="ready_stock_order_customize_block" class="modal modal-fixed-footer">
                                                    <div class="modal-content">
                                                        <div class="no_more_tables">
                                                            <table class="color-size-table-block striped ready-stock-table-block" width="100%" cellpadding="0" cellspacing="0">
                                                                <thead class="cf">
                                                                    <tr>
                                                                        <th>Color</th>
                                                                        <th>Quantity</th>
                                                                        <!-- <th>&nbsp;</th> -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="cusotmize-color-size-attr-tbody">
                                                                    @if($product->full_stock == 1)
                                                                        @foreach($colors_sizes as $color)
                                                                            <tr class="tr">
                                                                                <td data-title="Color">
                                                                                    <input class="combat" type="text" value="{{$color->color}}" name="color" readonly />

                                                                                </td>
                                                                                <td data-title="Quantity">
                                                                                    @if(!empty($color->quantity))
                                                                                        <input class="combat" type="text" value="{{ $color->quantity }}" name="non_clothing_quantity" readonly/>

                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="non_clothing_quantity" readonly />

                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach($colors_sizes as $color)
                                                                            <tr class="tr">
                                                                                <td data-title="Color">
                                                                                    <input class="combat" type="text" value="{{$color->color}}" name="color" readonly />
                                                                                    <span class="avl-wrap">&nbsp;</span>
                                                                                </td>
                                                                                <td data-title="Quantity">
                                                                                    @if(!empty($color->quantity))
                                                                                        <input class="combat" type="text" value="" name="non_clothing_quantity" />
                                                                                        <span class="avl-wrap">avl:<span class="avl">{{$color->quantity}}</span></span>
                                                                                    @else
                                                                                        <input type="text" class="readonly-item" value="" name="non_clothing_quantity" readonly />
                                                                                        <span class="avl-wrap">&nbsp;</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="total-price-block" style="display: none;">
                                                            <div class="input-wrapper">
                                                                <label>Total Qty:</label>
                                                                <span class="item_total_qty"></span>
                                                            </div>
                                                            <div class="input-wrapper">
                                                                <label>Unit Price: $</label>
                                                                <span class="item_unit_price"></span>
                                                            </div>
                                                            <div class="input-wrapper">
                                                                <label>Total Price: $</label>
                                                                <span class="item_total_price"></span>
                                                            </div>
                                                        </div>
                                                        <div class="price-calculation-notification" style="display: none;">
                                                            <div class="card-alert card cyan">
                                                                <div class="card-content white-text" style="padding: 10px;">
                                                                    Please click on calculate price button. To get updated price calculation.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($product->full_stock==1)
                                                            <div class="price-calculation-notification" >
                                                                <div class="card-alert card cyan">
                                                                    <div class="card-content white-text" style="font-size: 12px;">
                                                                        This is full stock feature Please click on calculate price button. To get updated price calculation.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="javascript:void(0);" class="waves-effect waves-green btn-flat price-calculation">Calculate Total Price</a>
                                                        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat update-price-btn green white-text" disabled="disabled">Update</a>
                                                        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
                                                            <i class="material-icons green-text text-darken-1">close</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    {{-- end non clothing type --}}

                                        <div class="total-price-block" style="display: none;">
                                            <div class="input-wrapper">
                                                <label>Total Qty:</label>
                                                <span class="item_total_qty"></span>
                                            </div>
                                            <div class="input-wrapper">
                                                <label>Unit Price: $</label>
                                                <span class="item_unit_price"></span>
                                            </div>
                                            <div class="input-wrapper">
                                                <label>Total Price: $</label>
                                                <span class="item_total_price"></span>
                                            </div>
                                        </div>

                                        <div id="product-modification-modal" class="modal profile_form_modal product-modification-modal">
                                            <div class="modal-content">
                                                <legend>Write your requirement</legend>
                                                <form action="#" method="post" name="prodModReqForm" id="prodModReqForm" enctype="multipart/form-data">
                                                    @csrf
                                                    <div role="">
                                                        <ul id="pmr-errors"></ul>
                                                    </div>
                                                    <div class="prod-mod-req-content">
                                                        <div class="modification_message_box row">
                                                            <div class="col s10 m11">
                                                                <div class="input-field">
                                                                    <label for="product-modification-message" class="">Type your modification request.</label>
                                                                    <textarea id="product-modification-message" class="materialize-textarea product-modification-message" name="prod_mod_req[details][]"></textarea>
                                                                </div>
                                                                <div class="input-field">
                                                                    <label for="product-modification-image" class="product-modification-image">Upload Image</label>
                                                                    <input class="uplodad_video_box" type="file" name="prod_mod_req[image][]" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="add_more_box" style="padding-top: 20px">
                                                        <a href="javascript:void(0);" class="add-more-block" onclick="addProdModReqContent()"><i class="material-icons dp48">add</i> Add More</a>
                                                    </div>
                                                    <!-- <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addProdModReqContent()"><i class="material-icons dp48">add</i> Add More</a> -->
                                                    {{-- <input type="hidden" value="{{$product->vendor->id}}" name="vendor_id" /> --}}
                                                    <input type="hidden" value="{{$product->id}}" name="product_id" />
                                                    <!-- <button type="submit" class="btn green waves-effect waves-light" id="submitProdModReq">Submit</button> -->
                                                    <div class="submit_btn_wrap" style="padding-top: 30px;">
                                                        <div class="row">
                                                            <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-action modal-close btn_grBorder">Cancel</a></div>
                                                            <div class="col s12 m6 l6 right-align">
                                                                <button type="submit" class="btn green waves-effect waves-light" id="submitProdModReq">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- <div class="modal-footer">
                                                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat"><i class="material-icons green-text text-darken-1">close</i></a>
                                            </div> -->
                                        </div>

                                        <input type="hidden" name="quantity" value="">
                                        <input type="hidden" name="unit_price" value="">
                                        <input type="hidden" name="full_stock" value="{{ $product->full_stock }}">
                                        <input type="hidden" name="total_price" value="">
                                        <input type="hidden" name="product_type" value="{{$product->product_type}}">
                                        @if(Auth::check())
                                        <button id="add_to_cart" data-id="{{$product->sku}}"class="btn waves-effect waves-light green addToCart" onclick="addToCart('{{$product->sku}}')" disabled="disabled" style="display: none;">Add to cart</button>
                                        <button id="ask_for_price" data-id="{{$product->sku}}"class="btn waves-effect waves-light green askForPrice" onclick="askForPrice('{{$product->sku}}')" style="display: none">Ask For Price</button>
                                        @else
                                        <a href="#login-register-modal" id="add_to_cart" data-id="{{$product->sku}}"class="btn waves-effect waves-light green addToCart modal-trigger btn_grBorder" disabled="disabled" style="display: none;">Add to cart</a>
                                        @endif

                                        <a type="button" class="btn waves-effect waves-light green btn_grBorder request_quotation" href="{{route('rfq.create',[$product->flag, $product->id])}}">Request for Quotation</a>
                                    </div>
                                </div>

                                <div class="col s12 single_product_review_wrap">
                                    <span>Rating</span>
                                    <div class="row">
                                        <div class="col s12 m6 l6">
                                            <div class="single-product-review-stars">
                                                <div class="star-rating" data-score="{{$averageRating}}"></div>
                                                <span>{{$averageRating}} out of 5</span>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l6">
                                            <div class="single-product-review">
                                                <div class="single-product-write-review">
                                                    <ul>
                                                        @if(!$productReviewExistsOrNot && Auth::guard('web')->check())
                                                        <li><a class="btn_grBorder waves-effect waves-light modal-trigger" href="#product-review-modal"><i class="material-icons dp48">edit</i> Write a review</a></li>
                                                        @elseif (!$productReviewExistsOrNot && !Auth::guard('web')->check())
                                                        <li><a class="btn_grBorder waves-effect waves-light modal-trigger" href="#login-register-modal"><i class="material-icons dp48">edit</i> Write a review</a></li>
                                                        @else
                                                        @endif
                                                        <li><a href="javascript:void(0);" class="view-all-review-trigger">View all ({{$reviewsCount}}) review</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="product-review-modal" class="modal modal-fixed-footer">
                                                <div class="modal-content">
                                                    <legend>Write your review</legend>
                                                    <!--div class="overall-star-rating" data-rateit-value="3.5" data-rateit-ispreset="true" data-rateit-readonly="true"></div-->
                                                    <form action="{{route('product.review.store',$product->sku)}}" method="post" name="reviewForm" id="reviewForm">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <label>Overall : </label>
                                                                <div id="overall-star-rating" class="score"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <label>Communication : </label>
                                                                <div id="communication-star-rating" class="score"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <label>On Time Delivery : </label>
                                                                <div id="ontimedelivery-star-rating" class="score"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <label>Sample Support : </label>
                                                                <div id="samplesupport-star-rating" class="score"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <label>Product Quality : </label>
                                                                <div id="productquality-star-rating" class="score"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <label>Share your experience : </label>
                                                                <textarea id="experience" name="experience" class="experience-textarea materialize-textarea"></textarea>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="{{$product->businessProfile->id}}" name="business_profile_id" />
                                                        <input type="hidden" value="{{$product->id}}" name="product_id" />
                                                        <button type="submit" class="btn green waves-effect waves-light" id="submitReview">Submit Review</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat "><i class="material-icons green-text text-darken-1">close</i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row single-product-description-block-wrapper">
                    <div class="col s12">
                        <ul class="tabs z-depth-1">
                            <li class="tab col m4"><a class="active" href="#product-desciprtion">Product Description</a></li>
                            <li class="tab col m4"><a href="#product-additional-desciprtion">Additional Information</a></li>
                            <li class="tab col m4"><a href="#product-review" class="product-review-tab">Reviews</a></li>
                        </ul>
                    </div>
                    <div id="product-desciprtion" class="col s12">
                        <div class="card card-with-padding">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div id="product-additional-desciprtion" class="col s12">
                        <div class="card card-with-padding">
                            {!! $product->additional_description !!}
                        </div>
                    </div>
                    <div id="product-review" class="col s12">
                        <div class="card-with-padding">
                            @if($reviewsCount > 0)
                            @foreach($productReviews as $productReview)
                            <div class="review-item card">
                                <div class="row">
                                    <div class="col s12 m9">
                                        <div class="row">
                                            <div class="col s12 m6">
                                                <div class="reviewed-by row">
                                                    <div class="user-image left">
                                                        <img src="{{asset('storage/'.$productReview->image)}}" class="responsive-img" />
                                                    </div>
                                                    <div class="user-name left">
                                                        <span>Reviewd by</span> {{ $productReview->name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m6">
                                                <div class="col s12 review_info_box">
                                                    <label>Overall : </label>
                                                    <div class="star-rating" data-score="{{ $productReview->overall_rating }}"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s12">
                                                <label>Experience : </label>
                                                {{ $productReview->experience }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m3">
                                        <div class="review-info">
                                            <!-- <div class="row">
                                                <div class="col s12 review_info_box">
                                                    <label>Overall : </label>
                                                    <div class="star-rating" data-score="{{ $productReview->overall_rating }}"></div>
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <div class="col s12 review_info_box">
                                                    <label>Communication : </label>
                                                    <div class="star-rating" data-score="{{ $productReview->communication_rating }}"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12 review_info_box">
                                                    <label>On Time Delivery : </label>
                                                    <div class="star-rating" data-score="{{ $productReview->ontime_delivery_rating }}"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12 review_info_box">
                                                    <label>Sample Support : </label>
                                                    <div class="star-rating" data-score="{{ $productReview->sample_support_rating }}"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12 review_info_box">
                                                    <label>Product Quality : </label>
                                                    <div class="star-rating" data-score="{{ $productReview->product_quality_rating }}"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            @endforeach
                            @else
                                <div class="card-alert card cyan">
                                    <div class="card-content white-text">
                                        <p>INFO : Don't have any reviews</p>
                                    </div>
                                </div>
                        @endif
                        </div>
                    </div>
                </div>



            </div>

            <!-- <div class="col s12 m12 l3">
                <div class="single-product-store-information center-align">
                    <div class="card card-with-padding">
                        <h6>Company Profile</h6>
                        <div class="company_profile_details">
                            <p><b style="color:#4CAF50">Store name :</b> {{$product->businessProfile->business_name}}<p>
                            <b style="color:#4CAF50">Country / Region :</b> {{$product->businessProfile->location}}<p>
                            <b style="color:#4CAF50">Business Type :</b> Wholesaler<p>
                            {{-- <b style="color:#4CAF50">Main Products:</b> {{$product->business_profile->vendor_mainproduct}}<p>
                            <b style="color:#4CAF50">Total Employees :</b> {{$product->business_profile->vendor_totalemployees}}<p>
                            <b style="color:#4CAF50">Year Established :</b> {{$product->business_profile->vendor_yearest}}<p>
                            <b style="color:#4CAF50">Certification :</b> {{$product->business_profile->vendor_certification}}<p> --}}
                        </div>

                        @if($relatedProducts->isNotEmpty())
                        <div class="store-more-products">
                            <legend>More Products from this store</legend>
                            <div class="more-products-block">
                                <div class="row">
                                    @foreach ($relatedProducts as $item)
                                    <div class="more-product-item col s12">
                                        <div class="product_img">
                                            @foreach ($item->images as $image)
                                                <img src="{{asset('storage/'.$image->image)}}" class="responsive-img" alt="" width="100px" />
                                                @break
                                            @endforeach
                                        </div>
                                        <div class="product_short_details">
                                            <a class="waves-effect waves-light btn modal-trigger" href="#modal3">View</a>
                                            <div class="product-title">
                                                <a href="{{route('productdetails',$item->sku)}}">{{$item->name}}</a>
                                            </div>
                                            <div class="product_price">
                                                @if($item->full_stock == 1)
                                                    <span class="full-stock btn_grBorder">Full Stock</span>
                                                @else
                                                    @php
                                                        $count= count(json_decode($item->attribute));
                                                        $count = $count-2;
                                                    @endphp
                                                    $ @foreach (json_decode($item->attribute) as $k => $v)
                                                        @if($k == 0 && $v[2] == 'Negotiable')
                                                        {{ '(Negotiable)' }}
                                                        @endif
                                                        @if($loop->last && $v[2] != 'Negotiable')
                                                            {{ $v[2] }}
                                                        @endif
                                                        @if($loop->last && $v[2] == 'Negotiable')
                                                            @foreach (json_decode($product->attribute) as $k => $v)
                                                                    @if($k == $count)
                                                                        {{ $v[2]  }} {{ 'Negotiable' }}
                                                                    @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div> -->


        </div>
    </div>




    <div class="row single-product-related-products">
        <div class="related-products col s12">
            <div class="card-with-padding">
                <legend>Recommended products for you</legend>

                @if(count($recommandProducts)>0)
                <div class="row recommendation-products related_products_slider">
                    @foreach($recommandProducts as $key=>$product)

                    <!-- <div class="col s12 m3 l3"></div> -->

                    <div class="card">
                        <div class="card-content">
                            <div class="product_quick_options">
                                <a href="{{ route("mix.product.details", [$product->flag, $product->id]) }}" class="quick_options_link">&nbsp;</a>
                                <div class="poduct_quick_options_inside">
                                    @if(in_array($product->id,$wishListShopProductsIds))
                                        <a href="javascript:void(0);" onclick="addToWishList('{{$product->flag}}', '{{$product->id}}', $(this));" class="product-add-wishlist active">
                                            <i class="material-icons dp48">favorite</i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" onclick="addToWishList('{{$product->flag}}', '{{$product->id}}', $(this));" class="product-add-wishlist">
                                            <i class="material-icons dp48">favorite</i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="product_img">
                                {{-- <a href="javascript:void();" class="overlay_hover"></a> --}}
                                @foreach($product->images as $key=>$image)
                                    @if($product->businessProfile()->exists())
                                        <a href="{{ route("mix.product.details", [$product->flag, $product->id]) }}">
                                            <img src="{{Storage::disk('s3')->url('public/'.$image->image)}} " class="single-product-img" alt="" />
                                        </a>
                                    @else
                                        <a href="javascript:void(0);">
                                            <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="single-product-img" alt="" />
                                        </a>
                                    @endif
                                    {{-- <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="single-product-img" alt="" /> --}}
                                    @break
                                @endforeach

                            </div>
                            <div class="product_short_details">
                                <div class="product-title">
                                    <a href="{{ route("mix.product.details", [$product->flag, $product->id]) }}">
                                        {{ $product->name }}
                                    </a>
                                </div>
                                <div class="product_price">
                                    @include('product._product_price')

                                    @if($product->availability==0 && $product->product_type==2)
                                        <span class="new badge red sold-out" data-badge-caption="Sold Out" style="display: none;"></span>
                                    @endif
                                </div>
                            </div>
                            <!-- Modal Structure -->
                            <div  id="product-details-modal_{{$product->sku}}" class="modal modal-fixed-footer product-details-modal" tabindex="0">
                                <div class="modal-content">
                                    <div class="row">
                                        <div class="col m6 s12 modal-product-images">
                                        @foreach($product->images as $key=>$image)
                                            <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" alt="" />
                                        @endforeach
                                        </div>
                                        <div class="col m6 s12">
                                            <h5>{{$product->name}}</h5>
                                            <span class="new badge ml-0 mr-2 pink lighten-1 rating-badge" data-badge-caption="">

                                                <i class="material-icons white-text"> star </i> <span class="rating_value">{{$averageRating}}</span>
                                            </span>
                                            <p>Availability: <span class="green-text">Available</span></p>
                                            <p class="pink-text">Free Shipping</p>
                                            <div class="border-separator"></div>
                                            <ul class="list-bullet">
                                                <li class="list-item-bullet">{{$product->sku}}</li>
                                                <li class="list-item-bullet">{!! $product->description !!}</li>
                                            </ul>
                                            <h5>
                                                @include('product._product_price')
                                            </h5>
                                            <input type="hidden" value="{{$product->sku}}" name="sku">
                                            <a href="{{route('productdetails',$product->sku)}}" class="waves-effect waves-light btn green mt-2">View Details</a>
                                            <a href="javascript:void(0);" id="wishList" data-productSku={{$product->sku}} class="waves-effect waves-light btn green mt-2 wishlist-trigger">
                                                <i class="material-icons mr-3">favorite_border</i> Add to Wishlist
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat ">
                                        <i class="material-icons mr-3">close</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    @endforeach
                </div>

                @else
                <div class="card-alert card cyan">
                    <div class="card-content white-text">
                        <p>INFO : No products available.</p>
                    </div>
                </div>
                @endif


            </div>
        </div>
    </div>
</div>



@endsection
@push('js')
    <script>
        // $('input[name=fresh_input]').change(function() {
        //     var value =  $('input[name=fresh_input]').val();
        //     var product_sku= $('input[name=product_sku]').val();
        //     $.ajax({
        //     url: "{{route('fresh.order.calculate')}}",
        //     type: "POST",
        //     data: {"value": value, "product_sku": product_sku , "_token": "{{ csrf_token() }}"},
        //     success: function (data) {
        //         $('.item_total_qty').html(value);
        //         $('.item_total_price').html(data.total_price);
        //         $('input[name=quantity]').val(value);
        //         $('input[name=unit_price]').val(data.unit_price);
        //         $('.total-price-block').show();
        //         $('.addToCart').attr('disabled', false);
        //     }
        // });
        // });

        // $(".trigger_minus").click(function(){
        //     if ($(this).next().val() > 0) {
        //         //if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
        //         if ($(this).next().val() > 0) {
        //             var updatedVal = $(this).next().val(+$(this).next().val() - 1);
        //         }

        //         var value =  $('input[name=fresh_input]').val();
        //         var product_sku= $('input[name=product_sku]').val();
        //         $.ajax({
        //             url: "{{route('fresh.order.calculate')}}",
        //             type: "POST",
        //             data: {"value": value, "product_sku": product_sku , "_token": "{{ csrf_token() }}"},
        //             success: function (data) {
        //                 $('.item_total_qty').html(value);
        //                 $('.item_total_price').html(data.total_price);
        //                 $('input[name=quantity]').val(value);
        //                 $('input[name=unit_price]').val(data.unit_price);
        //                 $('.total-price-block').show();
        //                 $('.addToCart').attr('disabled', false);
        //             }
        //         });
        //     }
        //     /*
        //     if($(this).next().val() == 0) {
        //         $('.addToCart').attr('disabled', true);
        //     }
        //     */
        // });

        // $(".trigger_plus").click(function(){
        //     //$(this).prev().val(+$(this).prev().val() + 1);
        //     var updatedVal = $(this).prev().val(+$(this).prev().val() + 1);
        //     //console.log(updatedVal);

        //     var value =  $('input[name=fresh_input]').val();
        //     var product_sku= $('input[name=product_sku]').val();
        //     $.ajax({
        //         url: "{{route('fresh.order.calculate')}}",
        //         type: "POST",
        //         data: {"value": value, "product_sku": product_sku , "_token": "{{ csrf_token() }}"},
        //         success: function (data) {
        //             $('.item_total_qty').html(value);
        //             $('.item_total_price').html(data.total_price);
        //             $('input[name=quantity]').val(value);
        //             $('input[name=unit_price]').val(data.unit_price);
        //             $('.total-price-block').show();
        //             $('.addToCart').attr('disabled', false);
        //         }
        //     });
        // });

        // $(document).ready(function() {
        //     // slick slider
        //     $('.related_products_slider').slick({
        //     dots: false,
        //     infinite: false,
        //     speed: 300,
        //     slidesToShow: 3,
        //     slidesToScroll: 1,
        //     autoplay: false,
        //     autoplaySpeed: 1000,

        //     responsive: [
        //         {
        //         breakpoint: 1024,
        //         settings: {
        //             slidesToShow: 2,
        //             slidesToScroll: 1,
        //             infinite: true,
        //             dots: false
        //         }
        //         },
        //         {
        //         breakpoint: 600,
        //         settings: {
        //             slidesToShow: 1,
        //             slidesToScroll: 1
        //         }
        //         },
        //         {
        //         breakpoint: 480,
        //         settings: {
        //             slidesToShow: 1,
        //             slidesToScroll: 1
        //         }
        //         }
        //     ]
        //     });
        // });






        $(document).on('input', 'table .combat' , function() {
            $(".price-calculation-notification").show();
            var checkReadyStock=$(this).closest('table').hasClass("ready-stock-table-block");
            if(checkReadyStock){
                var inputValue = $(this).closest('td').find(".combat").val();
                var avlValue = $(this).closest('td').find(".avl").text();
                if(Number(avlValue) < Number(inputValue)){
                    $(this).closest('td').find(".combat").addClass('warning');
                    $(this).closest('td').find(".avl").css('color','red');
                    $('.total-price-block').hide();
                    $('.addToCart').attr('disabled', true);
                    $('.addToCart').hide();
                    $('.price-calculation').attr('disabled', true);
                    if($('.update-price-btn').not(':disabled')){
                        $('.update-price-btn').attr('disabled', true);
                    }
                    return false;
                }
                else{
                    $('.price-calculation').attr('disabled', false);
                    if($('.update-price-btn').is(':disabled')){
                        $('.update-price-btn').attr('disabled', false);
                    }
                    $(this).closest('td').find(".combat").removeClass('warning');
                    $(this).closest('td').find(".avl").css('color','rgba(0,0,0,0.87)');
                }
                var error=$('.ready-stock-table-block td input').hasClass("warning")
                if(error == true){
                    alert('Please check availability with quantity');
                    $('.total-price-block').hide();
                    $('.addToCart').attr('disabled', true);
                    $('.addToCart').hide();
                    $('.price-calculation').attr('disabled', true);
                    if($('.update-price-btn').not(':disabled')){
                        $('.update-price-btn').attr('disabled', true);
                    }

                }
            }

        })

        $(document).on('click', '.price-calculation' , function() {
            var tot = 0; // variable to sore sum
            var price= $('.ready_stock_price').text();
            var product_sku= $('input[name=product_sku]').val();

            $('.cusotmize-color-size-attr-tbody tr').each(function(){
                var inputs = $(this).find('input').not(':first');
                inputs.each(function(){
                    tot+=Number($(this).val()) || 0; // parse and add value, if NaN then add 0
                });
            });
            // $('table .combat').each(function() { // iterate over inputs except last
            //     tot += Number($(this).val()) || 0; // parse and add value, if NaN then add 0
            //
            // });
            $.ajax({
                url: "{{route('fresh.order.calculate')}}",
                type: "POST",
                data: {"value": tot, "product_sku": product_sku , "_token": "{{ csrf_token() }}",},
                beforeSend: function(){
				    $('.loading-message').html("Calculating the price.");
				    $('#loadingProgressContainer').show();
			    },
                success: function (data) {
                    console.log(data);
                    $('.loading-message').html("");
				    $('#loadingProgressContainer').hide();
                    $('.item_total_qty').html(tot);
                    $('.item_unit_price').html(data.unit_price);
                    $('.item_total_price').html(data.total_price);
                    $('input[name=quantity]').val(tot);
                    $('input[name=unit_price]').val(data.unit_price);
                    $('input[name=total_price]').val(data.total_price);
                    $('.total-price-block').show();
                    // if(data.total_price== 'out of range'|| data.total_price=='you must add Mimium order' ){
                    //    $('.addToCart').attr('disabled', true);
                    //    $('.update-price-btn').attr('disabled', true);
                    // }
                   if(data.flag==0){
                       $('.addToCart').attr('disabled', true);
                       $('.update-price-btn').attr('disabled', true);
                       $('.askForPrice').hide();
                    }
                    else if(data.flag==1){
                        $('.update-price-btn').attr('disabled', false);
                        $('.addToCart').hide();
                        $('.askForPrice').show();

                    }
                    else{
                       $('.addToCart').attr('disabled', false);
                       $('.update-price-btn').attr('disabled', false);
                       $('.addToCart').show();
                       $('.askForPrice').hide();
                    }


                    /*
                    if(data.total_price== 'out of range'){
                       $('.update-price-btn').attr('disabled', true);
                    }
                    else{
                       $('.update-price-btn').attr('disabled', false);
                    }
                    */
                }
            });
        });
        //product modification
        function addProdModReqContent()
        {
            var html= '<div class="modification_message_box row"><div class="col s10 m11"><div class="input-field"><label for="product-modification-message" class="">Type your modification request.</label><textarea class="materialize-textarea product-modification-message" name="prod_mod_req[details][]"></textarea></div><div class="input-field"><label for="product-modification-image" class="product-modification-image">Upload Image</label><input class="uplodad_video_box" type="file" name="prod_mod_req[image][]"></div></div><div class="col s2 m1"><a href="javascript:void(0);" class="btn_delete" onclick="removeProdModReqContent(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></div></div>';
            $(".prod-mod-req-content").append(html);
        }
        function removeProdModReqContent(el)
        {
            $(el).parent().parent().remove();
        }
        //submit request
        $('#prodModReqForm').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var url = '{{ route("prod.mod.req.store") }}';
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: url,
                success:function(data)
                    {
                        // toastr.success(data.msg);
                        swal(data.message, data.success,data.type);
                        $('#prodModReqForm')[0].reset();
                        $("#product-modification-modal").modal('close');

                    },
                error: function(xhr, status, error)
                    {
                        $('#pmr-errors').empty();
                        $("#pmr-errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#pmr-errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div>")
                        });
                    }
            });
        });


        //message center
        var serverURL = "{{ env('CHAT_URL'), 'localhost' }}:3000";
        var socket = io.connect(serverURL);
        socket.on('connect', function(data) {
        //alert('connect');
        });
        @if(Auth::check())
        function sendmessage(productId,productTitle,productCategory,productImage,createdBy)
        {
        let message = {'message': 'We are Interested in Your Product ID:ms-'+productId+' and would like to discuss More...', 'product': {'id': "MS-"+productId,'name': productTitle,'category': productCategory,'image': productImage}, 'from_id' : "{{Auth::user()->id}}", 'to_id' : createdBy};
        socket.emit('new message', message);
        setTimeout(function(){
            //window.location.href = "/message-center";
            var url = '{{ route("message.center") }}?uid='+createdBy;
                // url = url.replace(':slug', sku);
                window.location.href = url;
            // window.location.href = "/message-center?uid="+createdBy;
        }, 1000);
        }

        function updateUserLastActivity(form_id, to_id)
        {
        var form_id = form_id;
        var to_id = to_id;
        var csrftoken = $("[name=_token]").val();

        data_json = {
            "form_id": form_id,
            "to_id": to_id,
            "csrftoken": csrftoken
        }
        var url= '{{route("message.center.update.user.last.activity")}}';
        jQuery.ajax({
            method: "POST",
            url: url,
            headers:{
                "X-CSRF-TOKEN": csrftoken
            },
            data: data_json,
            dataType:"json",

            success: function(data){
                console.log(data);
            }
        });

        }

        function contactSupplierFromProduct(supplierId)
        {

        var supplier_id = supplierId;
        var csrftoken = $("[name=_token]").val();
        var buyer_id = "{{Auth::id()}}";
        data_json = {
            "supplier_id": supplier_id,
            "buyer_id": buyer_id,
            "csrftoken": csrftoken
        }
        var url='{{route("message.center.contact.supplier.from.product")}}';
        jQuery.ajax({
            method: "POST",
            url:url,
            headers:{
                "X-CSRF-TOKEN": csrftoken
            },
            data: data_json,
            dataType:"json",
            success: function(data){
                console.log(data);
            }
        });

        /*
        let message = {'message': 'Hi I would like to discuss More about your Product', 'product': null, 'from_id' : "{{Auth::user()->id}}", 'to_id' : supplierId};
        socket.emit('new message', message);
        setTimeout(function(){
            window.location.href = "/message-center?uid="+supplierId;
        }, 1000);
        */
        }

        function sendsamplemessage(productId,productTitle,productCategory,moq,qtyUnit,pricePerUnit,priceUnit,productImage,createdBy)
        {
            let message = {'message': 'We are Interested in Your Product ID:mb-'+productId+' and would like to discuss More about the Product', 'product': {'id': "MB-"+productId,'name': productTitle,'category': productCategory,'moq': moq,'price': priceUnit+" "+pricePerUnit, 'image': productImage}, 'from_id' : "{{Auth::user()->id}}", 'to_id' : createdBy};
            socket.emit('new message', message);
            setTimeout(function(){
                window.location.href = "/message-center";
            }, 1000);
        }

        @endif








    </script>
@endpush


