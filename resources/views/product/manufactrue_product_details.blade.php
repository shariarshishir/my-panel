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
                                        <div class="product-large-image-block product_details_imgwrap" style="height: 550px; background: red; overflow: auto;">
                                            @if(count($product->product_images)> 0)
                                                @foreach ($product->product_images as $image)
                                                    <div class="product-bg-image" style="background-image: url({{Storage::disk('s3')->url('public/'.$image['product_image'])}}); height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;"></div>

                                                    <!--a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image['product_image'])}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$image['product_image'])}}" class="responsive-img" width="300px"/>
                                                        <div class="click-to-zoom">
                                                            <i class="material-icons dp48">zoom_in</i>
                                                        </div>
                                                    </a-->
                                                @endforeach
                                            @endif
                                        </div>
									</div>
								</div>
								<div class="col s12 m4 product_details_right_image">
									<div class="row">
                                        <div class="col s6 m6">
                                            @if(count($product->product_images)> 0)
                                                @foreach ($product->product_images as $image)
                                                    @if($image->is_raw_materials == 0)
                                                        <img src="{{Storage::disk('s3')->url('public/'.$image['product_image'])}}" class="responsive-img" width="100px" />
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col s6 m6">
                                            @if(count($product->product_images)> 0)
                                                @foreach ($product->product_images as $image)
                                                    @if($image->is_raw_materials == 1)
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
</div>


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
