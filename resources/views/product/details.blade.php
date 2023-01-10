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
        <div class="row new_design_detail_info">
            <div class="col s12 m3 new_design_detail_left">
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
                                <div class="col s12 m12 xl4 product_btn">
                                    <!--h6>SS 2023</h6-->
                                </div>
                                <div class="col s12 m12 xl8">
                                    @if($product->is_new_arrival == 1)
                                    <button class="arrival_btn">NEW ARRIVAL</button>
                                    @endif
                                </div>
                            </div>
                            <div class="product_details">
                                {!! $product->description !!}
                                @if($product->additional_description)
                                    <a class="modal-trigger" href="#show-additional-description-modal">Show More</a>
                                @endif
                            </div>
                            @if($product->product_type==2 || $product->product_type== 3)
                            <div class="margin_top">
                                <h5 class="margin_top">AVAILABLE COLORS</h5>
                                <div class="row">
                                    <div class="col s12 l10 size_wrapper colorPickerDetails">
                                        @foreach($colors_sizes as $color)
                                            @if(isset($color->color_picker))
                                            <div class="pickerColorBox">
                                                <div class="size_border color_picker_style tooltipped coloPick" style="background: {{$color->color_picker}}" data-tooltip="{{$color->color}}" data-position="top"><span class="text_center">&nbsp;</span></div>
                                            </div>
                                            @else
                                            <div class="size_border"><span class="text_center">{{$color->color}}</span></div>
                                            @endif
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
                                $cookie = Cookie::get('sso_token');
                                $cookie = base64_decode(explode(".",$cookie)[1]);
                                $cookie = json_decode(json_decode(json_encode($cookie)));
                                //$cookie->subscription_status = 1;
                            @endphp
                            @if($cookie->subscription_status == 1)
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
                                                <p>{{$item->value}}</p>
                                            </div>
                                        @endif
                                    @endif
                                    @if($item->name == "main_products")
                                        @if(isset($item->value))
                                            <div class="margin_top">
                                                <h6>MAIN PRODUCTS</h6>
                                                <p>{{$item->value}}</p>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach

                                @if(count($supplierCompanyInfo->certifications) > 0)
                                <div class="margin_top">
                                    <h6 class="margin_top">CERTIFICATES</h6>
                                    <div class="image_wrapper">
                                        <div class="cert_image"><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                        <div class="cert_image"><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                        <div class="cert_image"><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                        <div class="cert_image"><img class="image-sizing" src="./images/Gap-classic-T-shirt.webp" alt=""></div>
                                    </div>
                                </div>
                                @endif

                                <div class="row contact_supplier">
                                    <div class="col s12 m12 xl6">
                                        <!--button class="btn_contact_supplier">Contact Supplier</button-->
                                    </div>
                                    <div class="col s12 m12 xl6">
                                        <a class="btn_contact_supplier" href="{{route('supplier.profile', $product->businessProfile->alias)}}">Visit Profile</a>
                                    </div>
                                </div>
                            @else
                                <div class="non_supplierInfo_box">
                                    To see supplier information Please <a class="btn_subscribe" href="{{route('pricing.plan.form')}}">Subscribe</a>.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Column Container -->
            <div class="col s12 m6 new_design_detail_imgbox">
                <div class="new_design_product_preview_wrap">
                    <div class="product_preview_wrap">

                        <div class="product-images">
                            <div class="row">
                                <div class="col s12 m8">
                                    <div class="product-main-image">
                                        <div class="pre-loading-image-gallery"><img src="{{Storage::disk('s3')->url('public/frontendimages/ajax-search-loader-bar.gif')}}" width="80" height="80" alt="Loading"></div>
                                        <div class="product-large-image-block product_details_imgwrap" id="product-large-image-block-scrollview">
                                            @if(count($product->images)> 0)
                                                @foreach ($product->images as $image)
                                                    @if($image->is_raw_materials == 0)
                                                    <a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}">
                                                        <div class="product-bg-image" style="background-image: url({{Storage::disk('s3')->url('public/'.$image->original)}}); margin-bottom: 0px;">
                                                            @if(isset($image->image_label))
                                                                <span class="image_label">{{$image->image_label}}</span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                    @endif
                                                    <!--a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="300px"/>
                                                        <div class="click-to-zoom">
                                                            <i class="material-icons dp48">zoom_in</i>
                                                        </div>
                                                    </a-->
                                                @endforeach
                                                @foreach ($product->images as $image)
                                                    @if($image->is_raw_materials == 1)
                                                    <a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}">
                                                        <div class="product-bg-image" style="background-image: url({{Storage::disk('s3')->url('public/'.$image->original)}}); margin-bottom: 0px;"></div>
                                                    </a>
                                                    @endif
                                                    <!--a data-fancybox="gallery" href="{{Storage::disk('s3')->url('public/'.$image->original)}}">
                                                        <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="300px"/>
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
                                        <div class="col s6 m6 raw_materials_sm_imglist">
                                            @if(count($product->images)> 0)
                                                @foreach ($product->images as $image)
                                                    @if($image->is_raw_materials == 0)
                                                        <img onclick="onImageClickEvent(this);" img_id="{{$image->id}}" src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="100px" />
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col s6 m6 raw_materials_sm_imglist">
                                            @if(count($product->images)> 0)
                                                @foreach ($product->images as $image)
                                                    @if($image->is_raw_materials == 1)
                                                        <img onclick="onImageClickEvent(this);" img_id="{{$image->id}}" src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" width="100px" />
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
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
            <div class="col s12 m3 new_design_detail_right">
                @if(isset($product->video))
                <div class="new_design_detail_video_box">
                    <video controls height="245" width="300">
                        <source src="{{Storage::disk('s3')->url('public/'.$product->video->video)}}" type="video/mp4" />
                    </video>
                </div>
                @endif
                <h5 class="margin_top">{{ $product->name }}</h5>
                <div class="sweatshit_wrapper margin_top">
                    <!-- Product div -->
                    <div class="row">
                        <div class=" col s6">
                            <div class="attribute_box">
                                <P>PRODUCT CODE</P>
                                @if($product->product_code)
                                    <P class="font_weight">{{$product->product_code}}</P>
                                @else
                                    <P class="font_weight">{{$product->id}}</P>
                                @endif
                            </div>
                        </div>
                        <div class="col s6">
                            @if($product->full_stock != 1)
                            <div class="attribute_box">
                                <P>MOQ</P>
                                <P><span class="font_weight">{{ $product->moq }}</span> {{$product->product_unit}}</P>
                            </div>
                            @else
                            <div class="attribute_box">
                                <P>MOQ</P>
                                <P><span class="font_weight">{{ $product->availability }}</span> PCS</P>
                            </div>
                            @endif
                        </div>
                        <!-- Pricing  -->
                        <div class="col s6">
                            <div class="attribute_box">
                                @if($product->full_stock != 1)
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
                                @else
                                <p>PRICE</p>
                                <p>
                                    <span class="font_weight">
                                    @if($product->full_stock_negotiable == 1)
                                    Negotiable
                                    @else
                                    ${{ $product->full_stock_price }} / FULL STOCK
                                    @endif
                                    </span>
                                </p>
                                @endif

                                @if($product->full_stock != 1)
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
                                @endif
                            </div>
                        </div>

                        @if($product->product_type==1)
                        <div class="col s6">
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
                        <div class="col s6">
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
                        <div class="col s12">
                            <div class="row request_for_button_wrap">
                                <div class="col s12 m12 xl6">
                                    <a class="request_for_sample_event_trigger btn_bg_yellow" href="javascript:void(0);" data-productid="{{$product->id}}" data-productflag="{{$product->flag}}">Ask For Sample</a>
                                </div>
                                <div class="col s12 m12 xl6" style="display: none;">
                                    <a class="request_for_quotation_event_trigger btn_bg_yellow" href="javascript:void(0);" data-productid="{{$product->id}}" data-productflag="{{$product->flag}}">Request for Quotation</a>
                                </div>
                            </div>
                        </div>

                        <!--div class="col s12 m6">
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

        <!-- Modal Structure -->
        <div id="show-additional-description-modal" class="modal">
            <h5>ADDITIONAL DESCRIPTION</h5>
            {!! $product->additional_description !!}
            <div class="modal-footer">
                <a href="javascript:void(0);"
                    class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
            </div>
        </div>


    </div>

    <div class="row single-product-related-products">
        <div class="related-products col s12">
            <div class="card-with-padding">
                <legend>Recommended products for you</legend>

                @if(count($recommandProducts)>0)
                <div class="row recommendation-products related_products_slider">
                    @foreach($recommandProducts as $key=>$rProduct)

                    <!-- <div class="col s12 m3 l3"></div> -->

                    <div class="card">
                        <div class="card-content">
                            <div class="product_quick_options">
                                <a href="{{ route("mix.product.details", [$rProduct->flag, $rProduct->id]) }}" class="quick_options_link">&nbsp;</a>
                                <div class="poduct_quick_options_inside">
                                    @if(in_array($rProduct->id,$wishListShopProductsIds))
                                        <a href="javascript:void(0);" onclick="addToWishList('{{$rProduct->flag}}', '{{$rProduct->id}}', $(this));" class="product-add-wishlist active">
                                            <i class="material-icons dp48">favorite</i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" onclick="addToWishList('{{$rProduct->flag}}', '{{$rProduct->id}}', $(this));" class="product-add-wishlist">
                                            <i class="material-icons dp48">favorite</i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="product_img">
                                {{-- <a href="javascript:void();" class="overlay_hover"></a> --}}
                                @foreach($rProduct->images as $key=>$image)
                                    @if($rProduct->businessProfile()->exists())
                                        <a href="{{ route("mix.product.details", [$rProduct->flag, $rProduct->id]) }}">
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
                                    <a href="{{ route("mix.product.details", [$rProduct->flag, $rProduct->id]) }}">
                                        {{ $rProduct->name }}
                                    </a>
                                </div>
                                <div class="product_price">
                                    @include('product._product_price')

                                    @if($rProduct->availability==0 && $rProduct->product_type==2)
                                        <span class="new badge red sold-out" data-badge-caption="Sold Out" style="display: none;"></span>
                                    @endif
                                </div>
                            </div>
                            <!-- Modal Structure -->
                            <div  id="product-details-modal_{{$rProduct->sku}}" class="modal modal-fixed-footer product-details-modal" tabindex="0">
                                <div class="modal-content">
                                    <div class="row">
                                        <div class="col m6 s12 modal-product-images">
                                        @foreach($rProduct->images as $key=>$image)
                                            <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="responsive-img" alt="" />
                                        @endforeach
                                        </div>
                                        <div class="col m6 s12">
                                            <h5>{{$rProduct->name}}</h5>
                                            <span class="new badge ml-0 mr-2 pink lighten-1 rating-badge" data-badge-caption="">

                                                <i class="material-icons white-text"> star </i> <span class="rating_value">{{$averageRating}}</span>
                                            </span>
                                            <p>Availability: <span class="green-text">Available</span></p>
                                            <p class="pink-text">Free Shipping</p>
                                            <div class="border-separator"></div>
                                            <ul class="list-bullet">
                                                <li class="list-item-bullet">{{$rProduct->sku}}</li>
                                                <li class="list-item-bullet">{!! $rProduct->description !!}</li>
                                            </ul>
                                            <h5>
                                                @include('product._product_price')
                                            </h5>
                                            <input type="hidden" value="{{$rProduct->sku}}" name="sku">
                                            <a href="{{route('productdetails',$rProduct->sku)}}" class="waves-effect waves-light btn green mt-2">View Details</a>
                                            <a href="javascript:void(0);" id="wishList" data-productSku={{$rProduct->sku}} class="waves-effect waves-light btn green mt-2 wishlist-trigger">
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

        let product_images = [];
        const onImageClickEvent = (e) => {
            const selected_img_id = e?.attributes?.img_id?.value;
            const index = product_images.indexOf(Number(selected_img_id));
            // scroll to 450 * index
            const scrollView = document.getElementById('product-large-image-block-scrollview');

            if ($(window).width() < 480) {
                if(scrollView){
                    scrollView.scrollTo(0,000 * index);
                }
            }
            else if ($(window).width() < 768) {
                if(scrollView){
                    scrollView.scrollTo(0,450 * index);
                }
            }
            else if ($(window).width() >= 768 &&  $(window).width() <= 1280) {
                if(scrollView){
                    scrollView.scrollTo(0,352 * index);
                }
            }
            else if ($(window).width() > 1280 &&  $(window).width() <= 1400) {
                if(scrollView){
                    scrollView.scrollTo(0,450 * index);
                }
            }
            else if ($(window).width() > 1400 &&  $(window).width() <= 1700) {
                if(scrollView){
                    scrollView.scrollTo(0,551 * index);
                }
            }
            else  {
                // do something for huge screens
                if(scrollView){
                    scrollView.scrollTo(0,610 * index);
                }
            }
        }

        $(document).ready(function() {
            const p_imgs = @json($product->images) || [];
            p_imgs?.map(i=>{
                if(i['is_raw_materials'] == 0){
                    product_images.push(Number(i?.id));
                }
            });
            p_imgs?.map(i=>{
                if(i['is_raw_materials'] == 1){
                    product_images.push(Number(i?.id));
                }
            });

            console.log(product_images);
        });
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

        $(document).ready(function(){
            $(".request_for_sample_event_trigger").click(function(){
                var url = '{{ route("product.sample.request") }}';
                var productID = $(this).data("productid");
                var productFlag = $(this).data("productflag");

                if (confirm('Are you sure?'))
                {
                    $.ajax({
                        method: 'get',
                        data: {productID:productID, productFlag:productFlag},
                        url: url,
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(data)
                        {
                            //console.log(data);
                            // if(data.status==1){
                            //     $(".verification_trigger_from_backend").hide();
                            //     $(".unverification_trigger_from_backend").show();
                            // }
                            window.location.reload();
                        }
                    });
                }
            })

            $(".request_for_quotation_event_trigger").click(function(){
                var url = '{{ route("product.quotation.request") }}';
                var productID = $(this).data("productid");
                var productFlag = $(this).data("productflag");

                if (confirm('Are you sure?'))
                {
                    $.ajax({
                        method: 'get',
                        data: {productID:productID, productFlag:productFlag},
                        url: url,
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(data)
                        {
                            //console.log(data);
                            // if(data.status==1){
                            //     $(".verification_trigger_from_backend").hide();
                            //     $(".unverification_trigger_from_backend").show();
                            // }
                            window.location.reload();
                        }
                    });
                }
            })
        })





    </script>
@endpush


