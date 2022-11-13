@extends('layouts.app')

@section('pagetitle', 'Merchantbay | ' . $product->title . ' product on merchantbay.com' ?? '')
@section('title', $product->title . ' product on merchantbay.com' ?? '')
@section('description', $product->title . ' product on merchantbay.com' ?? '')

@if(isset($product->product_images[0]['product_image']))
    @section('image', Storage::disk('s3')->url('public/'.$product->product_images[0]['product_image']) ?? "")
    @section('ogimage', Storage::disk('s3')->url('public/'.$product->product_images[0]['product_image']) ?? "")
@else
    @section('image', Storage::disk('s3')->url('public/images/supplier.png') ?? "")
    @section('ogimage', Storage::disk('s3')->url('public/images/supplier.png') ?? "")
@endif
@section('ogtitle', $product->title ?? '')
@section('ogdescription', $product->title ?? '')

@section('keywords', $product->title . ' product on merchantbay.com' ?? '')
@section('robots', 'index, nofollow')

@section('content')
@include('sweet::alert')


<div class="new_design_product_detail_wrap">
	<div class="back_to">
		<a href="{{ url()->previous() }}">
            <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/back-arrow.png')}}" alt="" />
        </a>
	</div>
    @php
        //echo "<pre>"; print_r($product); echo "</pre>";
    @endphp
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
								<li class="tab col m6"><a href="#supplierInfo" class="">SUPPLIER INFO</a></li>
								<li class="indicator" style="left: 0px; right: 156px;"></li>
							</ul>
						</div>
						<!-- First tabs contant -->
						<div id="projectHighlight" class="col s12 active" style="display: block;">
							<div class="row tab_first_btn">
								<div class="col s12 m4 product_btn">
									<!--h6>SS 2023</h6-->
								</div>
								<div class="col s12 m8">
									<button class="arrival_btn">NEW ARRIVAL</button>
								</div>
							</div>
							<div>
								{!! $product->product_details !!}
							</div>

                            @php
                                $colors = $product->colors ?? [];
                                $sizes = $product->sizes ?? [];
                            @endphp

                            @if( !empty($colors) && is_array($colors) )
                                <div class="margin_top">
                                    <h5 class="margin_top">AVAILABLE COLORS</h5>
                                    <div class="row">
                                        <div class="col s12 l10 size_wrapper">
                                            @foreach($colors as $color)
                                            <div class="size_border"><span class="text_center">{{ strtolower($color) }}</span></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if( !empty($sizes) && is_array($sizes) )
                                <div class="margin_top">
                                    <h5 class="margin_top">AVAILABLE SIZES</h5>
                                    <div class="row">
                                        <div class="col s12 l10 size_wrapper">
                                            @foreach($sizes as $size)
                                                <div class="size_border"><span class="text_center">{{ strtoupper($size) }}</span></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

							<div class="margin_top">
								<h5 class="margin_top">CUSTOMIZATION</h5>
								<p>Yes</p>
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
                                    @foreach ($supplierCompanyInfo->certifications as $certificateItem)
                                    <div><img class="image-sizing" src="{{Storage::disk('s3')->url('public/'.$certificateItem->image.'')}}" alt=""></div>
                                    @endforeach
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
										<div class="pre-loading-image-gallery" style="display: none;"><img src="https://s3.ap-southeast-1.amazonaws.com/development.service.products/public/frontendimages/ajax-search-loader-bar.gif" width="80" height="80" alt="Loading"></div>
                                        <div class="product-large-image-block product_details_imgwrap">
                                            @if(count($product->product_images)> 0)
                                                @foreach ($product->product_images as $image)
                                                    <div class="details_gallery_box">
                                                        <a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image['product_image'])}}">
                                                            <img src="{{Storage::disk('s3')->url('public/'.$image['product_image'])}}" class="responsive-img" width="300px"/>
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
                                        @if(count($product->product_images)> 0)
                                            @foreach ($product->product_images as $image)
                                                @if($image->is_raw_materials == 0)
                                                <img src="{{Storage::disk('s3')->url('public/'.$image['product_image'])}}" class="responsive-img" width="100px" />
                                                @else
                                                <img src="{{Storage::disk('s3')->url('public/'.$image['product_image'])}}" class="responsive-img" width="100px" />
                                                @endif
                                            @endforeach
                                        @endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Third Column Container-->
			<div class="col s12 m3">
                @if($product->product_video->video)
                <div>
                    <video controls height="245" width="300">
                        <source src="{{Storage::disk('s3')->url('public/'.$product->product_video->video)}}" type="video/mp4" />
                    </video>
                </div>
                @endif
				<h5 class="margin_top">{{ $product->title }}</h5>
				<div class="sweatshit_wrapper margin_top">
					<!-- Product div -->
					<div class="row">
						<div class=" col s12 m6">
							<div class="attribute_box">
								<p>PRODUCT CODE</p>
								<p class="font_weight">mb-{{ $product->id }}</p>
							</div>
						</div>
						<div class="col s12 m6">
							<div class="attribute_box">
								<p>MOQ</p>
								<p><span class="font_weight">{{ $product->moq }}</span> {{ $product->qty_unit }}</p>
							</div>
						</div>
						<!-- Pricing  -->
						<div class="col s12 m6">
							<div class="attribute_box">
								<p>PRICE</p>
								<p>
									<span class="font_weight">
                                        <span class="price_negotiable">
                                            <span class="nego_price">
                                                {{$product->price_unit}} {{$product->price_per_unit}}
                                            </span>
                                        </span>
									</span>
								</p>
							</div>
						</div>
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





    <!-- <div class="row"> -->
    <section class="manufactrue_product_details_top">
        <div class="manufactrue_product_details_inner">
            <div class="row ic-breadcrumb product_category_bar">
                <div class="category_nav">
                    <a class="dropdown-trigger" href="#!" data-target="categories_dropdown">
                        <i class="material-icons left">dashboard</i> Categories<i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <ul id="categories_dropdown" class="dropdown-content subNav" tabindex="0" style="">
                        <li tabindex="0"><a href="#">{{ $product->product_tag ? ucwords(implode(',',$product->product_tag)) : ''}}</a></h3>
                    </ul>
                </div>
            </div>
            <div class="back_to">
                <a  href="{{ url()->previous() }}"> <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/back-arrow.png')}}" alt="" ></a>
            </div>
        </div>
    </section>

    <section class="ic-single-product-details manufactrue_product_details_wrap product_details_wrapper">
        <div class="manufactrue_product_details_inner">
            <div class="ic-pg-container">
                <div class="s12 product_preview_info_wrap">
                    <div class="single_product_preview_inner_info">
                        <div class="row">
                                <div class="col s12 m5 product_preview_wrap">
                                    @if(isset($product->product_video->video))
                                        <div class="simpleLens-gallery-container" id="ic-gallery">
                                            <div class="video_content">
                                                <div class="details_video_box">
                                                    <video controls height="245" width="300">
                                                        <source src="{{Storage::disk('s3')->url('public/'.$product->product_video->video)}}" type="video/mp4" />
                                                    </video>
                                                </div>
                                            </div>
                                            <div class="simpleLens-thumbnails-container">
                                                @foreach($product->product_images as $product_image)
                                                    <a href="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}" data-fancybox="gallery" class="simpleLens-thumbnail-wrapper"
                                                        data-lens-image="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}"
                                                        data-big-image="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}" style="width:80px !important; height:80px !important; margin-top:4px;" id="smallImages[]" />
                                                    </a>
                                                @endforeach
                                                @if($product->overlay_image)
                                                    <a href="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}" data-fancybox="gallery" class="simpleLens-thumbnail-wrapper"
                                                        data-lens-image="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}"
                                                        data-big-image="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}" style="width:80px !important; height:80px !important; margin-top:4px;" id="smallImages[]" />
                                                    </a>
                                                @endif
                                                @php $productImage = (!empty($product->product_images[0]->product_image))? Storage::disk('s3')->url('public/'.$product_image['product_image']):Storage::disk('s3')->url('images/supplier.png'); @endphp
                                            </div>
                                        </div>
                                    @else
                                        <div class="simpleLens-gallery-container" id="ic-gallery">
                                            @if(isset($product->product_images[0]['product_image']) && !is_null($product->product_images[0]['product_image']))
                                                <div class="simpleLens-container">
                                                    <div class="simpleLens-big-image-container">
                                                        <div class="details_gallery_box">
                                                            <a class="simpleLens-lens-image" data-lens-image="{{Storage::disk('s3')->url('public/'.$product->product_images[0]['product_image'])}}">
                                                                <img id="largeImage" src="{{Storage::disk('s3')->url('public/'.$product->product_images[0]['product_image'])}}" class="simpleLens-big-image" width="380px" height="320px">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="simpleLens-thumbnails-container">
                                                @foreach($product->product_images as $product_image)
                                                    <a href="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}" data-fancybox="gallery" class="simpleLens-thumbnail-wrapper"
                                                        data-lens-image="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}"
                                                        data-big-image="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$product_image['product_image'])}}" style="width:80px !important; height:80px !important; margin-top:4px;" id="smallImages[]" />
                                                    </a>
                                                @endforeach
                                                @if($product->overlay_image)
                                                    <a href="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}" data-fancybox="gallery" class="simpleLens-thumbnail-wrapper"
                                                        data-lens-image="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}"
                                                        data-big-image="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}" style="width:80px !important; height:80px !important; margin-top:4px;" id="smallImages[]" />
                                                    </a>
                                                @endif
                                                @php $productImage = (!empty($product->product_images[0]->product_image))? Storage::disk('s3')->url('public/'.$product->product_images[0]->product_image) : Storage::disk('s3')->url('images/supplier.png'); @endphp
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col s12 m7 product_details_info_wrap">

                                    <div class="row">
                                        <div class="col s12">
                                            <div class="seller-store">
                                                <h3><a href="#">{{ $product->product_tag ? ucwords(implode(',',$product->product_tag)) : ''}}</a></h3>
                                            </div>
                                        </div>

                                        <!-- <div class="product_stock col s12 m6 l6 right-align">
                                            <div class="single-product-availability">Availability: <span>instock</span></div>
                                        </div> -->
                                    </div>

                                    <div class="ic-pg-container">
                                        <div class="col-md-5 col-sm-12 ic-product-infobox">
                                            <div class="ic-product-details">
                                                {{-- <form id="productOrderForm" action="{{ route('orders.placeing', $product->id) }}" method="POST" style="padding:10px 15px"> --}}
                                                    <h1 class="ic-product-title">{{ $product->title }}</h1>
                                                    <table class="table table-bordered-less">
                                                        <tbody>
                                                            <tr>
                                                                <th>Product Code</th>
                                                                <th>:</th>
                                                                <td>mb-{{ $product->id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Price per Unit</th>
                                                                <th>:</th>
                                                                <td>{{$product->price_unit}} {{$product->price_per_unit}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Lead Time</th>
                                                                <th>:</th>
                                                                <td>{{ $product->lead_time }} days</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Min Quantity</th>
                                                                <th>:</th>
                                                                <td>{{ $product->moq }} {{ $product->qty_unit }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>**Any kind of customization is possible.</th>
                                                                <th>:</th>
                                                                <td>Yes</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    @php
                                                        $colors = $product->colors ?? [];
                                                        $sizes = $product->sizes ?? [];
                                                    @endphp

                                                    @if( !empty($colors) && is_array($colors) )
                                                        <div class="mycolorwrapper">
                                                            <h3>Colors: <span id="mycolorboxColor">&nbsp;</span></h3>
                                                            <div class="mycolorboxs">
                                                                @foreach($colors as $color)
                                                                <label class="mycolorbox">
                                                                    <span class="mycolorbox-color">{{ strtolower($color) }}</span>
                                                                    <!-- <span class="mycolorbox-color" style="background-color:{{ strtolower($color) }}; border: 1px solid {{ strtolower($color) }}">{{ strtolower($color) }}</span> -->
                                                                </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if( !empty($sizes) && is_array($sizes) )
                                                        <div class="mysizewrapper">
                                                            <h3>Sizes</h3>
                                                            <div class="mysizeboxs">

                                                                <div id="mysizeboxPanel" class="mysizebox-panel">
                                                                    @foreach($sizes as $size)
                                                                        <div class="mysizebox" data-size="{{ $size }}">
                                                                            <span>{{ strtoupper($size) }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif


                                                {{-- </form> --}}

                                                {{-- contactSupplierModal --}}
                                                <div id="contactSupplierModal" class="modal">
                                                    <form class="contact-supplier-form" id="contactSupplierForm" action="" method="POST">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <h2>Send Query</h2>
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="name" placeholder="Name*" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="email" class="form-control" name="email" placeholder="Email Address*" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="address" placeholder="Address*" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
                                                            <button type="submit" class="btn btn-success">SEND</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                            {{-- <button type="button" class="ic-btn btn_green" onClick="contactSupplierFromProduct({{ $product->businessProfile->user->id}}); updateUserLastActivity('{{Auth::id()}}', '{{$product->businessProfile->user->id}}'); sendmessage('{{$product->id}}','{{$product->title}}','{{preg_replace('/[^A-Za-z0-9\-]/','',$product->category['name'])}}','{{$product->moq}}','{{$product->qty_unit}}','{{$product->price_per_unit}}','{{$product->price_unit}}','@if(!empty(@$product->product_images[0]->product_image)){{ asset('storage/' .$product->product_images[0]->product_image) }} @else{{ asset('images/supplier.png') }} @endif','{{$product->businessProfile->user->id}}')">Send Query</button> --}}
                                            <a type="button" class="btn waves-effect waves-light green btn_grBorder request_quotation" href="{{route('rfq.create',[$product->flag, $product->id])}}">Request for Quotation</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>


                    <section class="single-product-description-block-wrapper product_details_tab_wrap">
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs">
                                    <li class="tab col s4"><a class="active"  href="#product-details">Product Details</a></li>
                                    <li class="tab col s4"><a href="#company-profile">Company Profile</a></li>
                                    <li class="tab col s4" style="display: none;"><a href="#factory-tour">Factory Tour</a></li>
                                </ul>
                            </div>
                            <div id="product-details" class="col s12">
                                <div class="card product_details_tab">
                                    <h3>Overview</h3>
                                    <div class="ic-tabcontent-tbl ic-hz">
                                        <h4>Product Details</h4>
                                        {!! $product->product_details !!}
                                    </div>
                                    <div class="ic-tabcontent-tbl ic-hz">
                                        <h4>Full Specification</h4>
                                        {!! $product->product_specification !!}
                                    </div>
                                </div>
                            </div>
                            <div id="company-profile" class="col s12">
                                <div class="card product_details_tab">
                                    <h3>Basic information <span class="ic-verified"><i class="icofont icofont-check"></i> Verified</span></h3>
                                    <div class="ic-dbl-tbl">
                                        <div class="ic-company-tbl ic-hz">
                                            <table>
                                                <tr>
                                                    <td>Company Name:</td>
                                                    <td>{{ $product->businessProfile->business_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Business type:</td>
                                                    <td>
                                                        @if($product->businessProfile)
                                                            @switch($product->businessProfile->business_type)
                                                                @case(1)
                                                                    Manufacturer
                                                                    @break
                                                                @case(2)
                                                                    Wholesaler
                                                                    @break
                                                                @case(3)
                                                                    Design Studio
                                                                    @break

                                                                @default
                                                            @endswitch
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Main products:</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Annual Revenue:</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Top 3 Markets:</td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="ic-company-tbl ic-right-tbls ic-hz">
                                            <table>
                                                <tr>
                                                    <td>Location:</td>
                                                    <td>{{ $product->businessProfile ? $product->businessProfile->location : '' }}</td>

                                                </tr>
                                                <tr>
                                                    <td>Total Employees:</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Year Established:</td>
                                                    <td class="ic-primary"></td>

                                                </tr>
                                            </table>
                                        </div>
                                        <div class="ic-hr-devider"></div>
                                    </div>
                                    <span class="com_detalts" >Comapny Details</span>

                                    <div class="ic-product-detail">
                                        <div class="ic-product-overview">
                                            <div class="ic-product-description">
                                                <div class="ic-s-product-desc">

                                                </div>
                                            </div>
                                            <div class="ic-p-overview-video company-profile-intro-video" style="background-image:">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="factory-tour" class="col s12">
                                <div class="card product_details_tab">
                                    <h3>Overview</h3>
                                    <div class="ic-factory-flex">
                                        <div class="ic-ff-left">
                                            <h4>Factory tour photos</h4>
                                        </div>
                                        <div class="ic-ff-right">

                                        </div>
                                    </div>
                                    <div class="ic-factory-flex">
                                        <div class="ic-ff-left">
                                            <h4>Factory &amp; machinery detail</h4>
                                        </div>
                                        <div class="ic-ff-right">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>

                <!-- <div class="col s12 m12 l3 product_preview_right center-align">
                    <div id="place_order_buttons" class="ic-place-order right-align">
                        {{-- <a href="{{ route('wishlist.store',[$product->id,'product']) }}" class="ic-btn" style="margin-right:10px"><i class="fa fa-heart-o"></i></a> --}}

                        @if( !empty($colors) && is_array($colors) && !empty($sizes) && is_array($sizes) )
                            @csrf

                            <input type="hidden" id="total_qty2" name="quantity" value="0">
                            {{-- <button type="button" class="ic-btn js__btn" data-toggle="modal" data-target="#productOrderModal" disabled>Place order</button> --}}

                        @else

                            {{-- <a href="#" class="ic-btn" data-toggle="modal" data-target="#product-order"></a> --}}
                            {{-- <a href="{{ action('ProductController@contactSupplier', $product->id) }}" class="ic-btn">Place order</a> --}}


                        @endif
                        <br/>

                    </div>
                    {{-- send request sample --}}
                    <div class="preview_right_infobox">
                        <div class="samplebox">
                            <h3>Company Detail</h3>
                            <div class="requestbox">
                                {{-- <a class="modal-trigger" href="javascript:void(0);">Request Sample</a> --}}
                                <p>contact for order customization or bulk volume rate-</p>
                            </div>
                            <form class="sampleformbox" id="requestSampleForm" action="" method="POST">
                                @csrf
                                <div class="modal" id="requestSampleForm">
                                    <div class="modal-content">
                                        <h5>Request Sample</h5>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Name*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email Address*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="address" placeholder="Address*" required>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="sample_details" rows="3" placeholder="Sample details"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">SEND</button>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#!" class="modal-close waves-effect waves-green btn-flat">cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="right_view_details">
                            <div class="row" style="height:90px; background-image: url({{ asset('images/single-product-logo-background.jpg') }}); background-repeat: no-repeat;">
                                <div class="col-md-12">
                                    @if(isset($supplier->profile->company_logo))
                                        <img src="{{ asset('storage/'.$supplier->profile->company_logo) }}" width="30%" height="70px" alt="Missing" style="border-radius: 190px; margin-top:50px; margin-left:90px;" />
                                    @endif
                                </div>
                            </div>

                            <p class="text-center" style="font-size: 16px; font-weight:bold;"><span style=" color: #333333;"> {{ @$supplier->profile->company_name }}</span></p>

                            <p class="text-center">{{ @$supplier->profile->company_info['city'] }}, {{ @$supplier->profile->company_info['country'] }}</p>

                            <div class="ic-badges" style="padding-left: 16px;">
                                {{-- @foreach($supplier->badges as $badge)
                                    <p><img src="{{ asset('storage/'.$badge->badge['image']) }}" alt="right" style="width:40px;">
                                    {{ $badge->badge->name }}</p>
                                @endforeach --}}
                            </div>


                            <br/><br/>
                            <span class="col-md-3"></span>
                            @if(!empty($product->business_profile_id))
                                <a href="{{ route('supplier.profile', $product->businessProfile->alias) }}" class="text-center ic-primary">View Company Profile</a>
                            @else
                                <a href="javascript:void(0);" class="text-center ic-primary">View Company Profile</a>
                            @endif
                        </div>
                    </div>
                </div> -->




            </div> <!-- row ic-pg-container emd -->
        </div>
    </section>

{{-- product details, company profile, factory tour --}}
    <!-- <section class="single-product-description-block-wrapper product_details_tab_wrap">
        <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s3"><a class="active"  href="#product-details">Product Details</a></li>
                <li class="tab col s3"><a href="#company-profile">Company Profile</a></li>
                <li class="tab col s3"><a href="#factory-tour">Factory Tour</a></li>
              </ul>
            </div>
            <div id="product-details" class="col s12">
                <div class="card product_details_tab">
                    <h3>Overview</h3>
                    <div class="ic-tabcontent-tbl ic-hz">
                        <h4>Product Details</h4>
                        {!! $product->product_details !!}
                    </div>
                    <div class="ic-tabcontent-tbl ic-hz">
                        <h4>Full Specification</h4>
                        {!! $product->product_specification !!}
                    </div>
                </div>
            </div>
            <div id="company-profile" class="col s12">
                <div class="card product_details_tab">
                    <h3>Basic information <span class="ic-verified"><i class="icofont icofont-check"></i> Verified</span></h3>
                    <div class="ic-dbl-tbl">
                        <div class="ic-company-tbl ic-hz">
                            <table>
                                <tr>
                                    <td>Company Name:</td>
                                    <td>{{ $product->businessProfile->business_name}}</td>

                                </tr>
                                <tr>
                                    <td>Business type:</td>
                                    <td>
                                        @if($product->businessProfile)
                                            @switch($product->businessProfile->business_type)
                                                @case(1)
                                                    Manufacture
                                                    @break
                                                @case(2)
                                                    Wholesaler
                                                    @break
                                                @case(3)
                                                    Design Studio
                                                    @break

                                                @default
                                            @endswitch
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td>Main products:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Total Annual Revenue:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Top 3 Markets:</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="ic-company-tbl ic-right-tbls ic-hz">
                            <table>
                                <tr>
                                    <td>Location:</td>
                                    <td>{{ $product->businessProfile ? $product->businessProfile->location : '' }}</td>

                                </tr>
                                <tr>
                                    <td>Total Employees:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Year Established:</td>
                                    <td class="ic-primary"></td>

                                </tr>
                            </table>
                        </div>
                        <div class="ic-hr-devider"></div>
                    </div>
                    <span class="com_detalts" >Comapny Details</span>

                    <div class="ic-product-detail">
                        <div class="ic-product-overview">
                            <div class="ic-product-description">
                                <div class="ic-s-product-desc">

                                </div>
                            </div>
                            <div class="ic-p-overview-video company-profile-intro-video" style="background-image:">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="factory-tour" class="col s12">
                <div class="card product_details_tab">
                    <h3>Overview</h3>
                    <div class="ic-factory-flex">
                        <div class="ic-ff-left">
                            <h4>Factory tour photos</h4>
                        </div>
                        <div class="ic-ff-right">

                        </div>
                    </div>
                    <div class="ic-factory-flex">
                        <div class="ic-ff-left">
                            <h4>Factory &amp; machinery detail</h4>
                        </div>
                        <div class="ic-ff-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    @include('product._create_rfq_form_modal')
@endsection


@push('js')
    <script>

var serverURL = "{{ env('CHAT_URL'), 'localhost' }}:3000";
        var socket = io.connect(serverURL);
        socket.on('connect', function(data) {
        //alert('connect');
        });
        @if(Auth::check())
        function sendmessage(productId,productTitle,productCategory,moq,qtyUnit,pricePerUnit,priceUnit,productImage,createdBy)
        {
        let message = {'message': 'We are Interested in Your Product ID:mb-'+productId+' and would like to discuss More...', 'product': {'id': "MB-"+productId,'name': productTitle,'category': productCategory,'moq': moq,'price': priceUnit+" "+pricePerUnit, 'image': productImage}, 'from_id' : "{{Auth::user()->id}}", 'to_id' : createdBy};
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
