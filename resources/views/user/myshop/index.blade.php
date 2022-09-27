@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col s12 shop-banner-wrapper">
        <div class="shop-banner-img">
            @if(auth()->user()->user_banner)
            <img src="{{asset('storage/'.auth()->user()->user_banner)}}" id="preview-banner-before-upload" class="responsive-img" alt="Profile Banner Image" />
            @else
            <img src="{{Storage::disk('s3')->url('public/frontendimages/shop_banner.png')}}" id="preview-banner-before-upload" class="responsive-img" alt="Profile Banner Image" />
            @endif
        </div>
        <div class="shop-name">
            <i class="material-icons dp48">store</i> {{ $vendor->vendor_name }}
        </div>
    </div>
</div>

<div id="myshop" class="row">

    @include('user.myshop.storemenu')

    <div class="col m3">
        <div class="col m12 products-category-block">
            <div class="row">
                    <legend>Product Categories</legend>
                    @php
                        $segment4 = Request::segment(4);
                        $segment5 = Request::segment(5);
                        $segment6 = Request::segment(6);
                    @endphp

                    <ul>
                        @foreach($categories as $category)
                            <li class="@php echo ($category['slug'] == $segment4)?' active':''; @endphp">
                                <a href="{{route('users.categories_products',['vendorUid'=>$vendor->vendor_uid,'slug'=>$category['slug']])}}">
                                    {{$category['name']}}
                                    @if(!empty($category['children']))
                                        <span><i class="material-icons dp48">chevron_right</i></span>
                                    @endif
                                </a>
                                @if(!empty($category['children']))
                                <ul class="sub-level">
                                    @foreach($category['children'] as $childcategory)
                                        <li class="@php echo ($childcategory['slug'] == $segment5)?' active':''; @endphp">
                                            <a href="{{route('users.subcategories_products',['vendorUid'=>$vendor->vendor_uid,'category'=>$category['slug'],'subcategory'=>$childcategory['slug']])}}">
                                                {{ $childcategory['name'] }}
                                                @if(!empty($childcategory['children']))
                                                    <span><i class="material-icons dp48">chevron_right</i></span>
                                                @endif
                                            </a>
                                            @if(!empty($childcategory['children']))
                                            <ul class="sub-level">
                                                @foreach($childcategory['children'] as $childcategory2)
                                                    <li class="@php echo ($childcategory2['slug'] == $segment6)?' active':''; @endphp">
                                                        <a href="{{route('users.subcategories_products',['vendorUid'=>$vendor->vendor_uid,'category'=>$category['slug'],'subcategory'=>$childcategory2['slug']])}}">
                                                            {{ $childcategory2['name'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
            </div>
        </div>
    </div>
    <div class="col m9">
        <div class="col m12 featured-products-block">
            <div class="row">
                <legend>Featured Products</legend>
                @if(count($productFeatured) > 0)
                <div class="row">
                @foreach($productFeatured as $key=>$product)

                    <div class="col s12 m4 l4">
                        <div class="card">
                            <div class="card-content">
                                <div class="product_img">
                                    <a href="javascript:void();" class="overlay_hover"></a>
                                    @foreach($product->images as $key=>$image)
                                        @if($key==0)
                                            <img src="{{asset('storage/'.$image->image)}}" class="responsive-img" alt="" />
                                        @endif
                                    @endforeach
                                    <div class="product_quick_options">
                                        <a href="{{route('productdetails',$product->sku)}}" class="quick_options_link">&nbsp;</a>
                                        <div class="poduct_quick_options_inside">
                                            <a href="javascript:void(0);" id="favorite" data-productSku="{{$product->sku}}"class="btn waves-effect waves-light green lighten-1 product-add-wishlist">
                                                <i class="material-icons dp48">favorite</i>
                                            </a>
                                            <a href="#product-details-modal_{{$product->sku}}" class="btn waves-effect waves-light green lighten-1 product-more-details modal-trigger">
                                                <i class="material-icons dp48">remove_red_eye</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_short_details">
                                    <!--a class="waves-effect waves-light btn modal-trigger" href="#modal3">View</a-->
                                    <div class="product-title">
                                        <a href="{{route('productdetails',$product->sku)}}">{{$product->name}}</a>
                                    </div>
                                    <div class="product_price">
                                       @include('product._product_price')
                                    </div>
                                    @php  $averageRating = productRating($product->id);@endphp
                                    <div class="product_info_details">
                                        <div class="shipping_label">Free Shipping</div>
                                        <div class="rating_label">
                                            <i class="material-icons pink-text"> star </i>
                                            <span>{{$averageRating}}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Structure -->
                                <div  id="product-details-modal_{{$product->sku}}" class="modal modal-fixed-footer product-details-modal" tabindex="0">
                                    <div class="modal-content">
                                        <div class="row">
                                            <div class="col m6 s12 modal-product-images">
                                            @foreach($product->images as $key=>$image)
                                                <img src="{{ url('storage/'.$image->image) }}" class="responsive-img" alt="" />
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
                                                <!--button id="add_to_cart" data-id="{{$product->sku}}"class="btn btn-success" onclick="addToCart('{{$product->sku}}')">ADD TO CART</button-->
                                                <a href="{{route('productdetails',$product->sku)}}" class="waves-effect waves-light btn green mt-2">View Details</a>
                                                <a href="javascript:void(0);" class="waves-effect waves-light btn green mt-2 wishlist-trigger">
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
                    </div>

                @endforeach
                </div>
                    <div class="pagination-block-wrapper">
                        <div class="col s12 center">
                            {!! $productFeatured->links() !!}
                        </div>
                    </div>
                @else
                    <div class="card-alert card cyan">
                        <div class="card-content white-text">
                            <p>INFO : No featured products available.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col m12 new-products-block">
            <div class="row">
                <legend>New Products</legend>
                @if(count($productNewArrival) > 0)
                <div class="row">
                @foreach($productNewArrival as $key=>$product)

                    <div class="col s12 m4 l4">
                        <div class="card">
                            <div class="card-content">
                                <div class="product_img">
                                    <a href="javascript:void();" class="overlay_hover"></a>
                                    @foreach($product->images as $key=>$image)
                                        @if($key==0)
                                            <img src="{{asset('storage/'.$image->image)}}" class="responsive-img" alt="" />
                                        @endif
                                    @endforeach
                                    <div class="product_quick_options">
                                        <a href="{{route('productdetails',$product->sku)}}" class="quick_options_link">&nbsp;</a>
                                        <div class="poduct_quick_options_inside">
                                            <a href="javascript:void(0);" id="favorite" data-productSku="{{$product->sku}}" class="btn waves-effect waves-light green lighten-1 product-add-whishlist">
                                                <i class="material-icons dp48">favorite</i>
                                            </a>

                                            <a href="#product-details-modal_{{$product->sku}}" class="btn waves-effect waves-light green lighten-1 product-more-details modal-trigger">
                                                <i class="material-icons dp48">remove_red_eye</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_short_details">
                                    <!--a class="waves-effect waves-light btn modal-trigger" href="#modal3">View</a-->
                                    <div class="product-title">
                                        <a href="{{route('productdetails',$product->sku)}}">{{$product->name}}</a>
                                    </div>
                                    <div class="product_price">
                                        @include('product._product_price')
                                    </div>
                                    @php  $averageRating = productRating($product->id);@endphp
                                    <div class="product_info_details">
                                        <div class="shipping_label">Free Shipping</div>
                                        <div class="rating_label">
                                            <i class="material-icons pink-text"> star </i>
                                            <span>{{$averageRating}}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Structure -->
                                <div  id="product-details-modal_{{$product->sku}}" class="modal modal-fixed-footer product-details-modal" tabindex="0">
                                    <div class="modal-content">
                                        <div class="row">
                                            <div class="col m6 s12 modal-product-images">
                                            @foreach($product->images as $key=>$image)
                                                <img src="{{ url('storage/'.$image->image) }}" class="responsive-img" alt="" />
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
                                                <!--button id="add_to_cart" data-id="{{$product->sku}}"class="btn btn-success" onclick="addToCart('{{$product->sku}}')">ADD TO CART</button-->
                                                <a href="{{route('productdetails',$product->sku)}}" class="waves-effect waves-light btn green mt-2">View Details</a>
                                                <a href="javascript:void(0);" class="waves-effect waves-light btn green mt-2 wishlist-trigger">
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
                    </div>

                @endforeach
                </div>
                    <div class="pagination-block-wrapper">
                        <div class="col s12 center">
                            {!! $productNewArrival->links() !!}
                        </div>
                    </div>
                @else
                    <div class="card-alert card cyan">
                        <div class="card-content white-text">
                            <p>INFO : No new products available.</p>
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
    $(document).on("click", "#favorite" , function() {
        //console.log('hi');
        var id = $(this).attr("data-productSku");

        swal({
            title: "Want to add this product into wishlist ?",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, add it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                    $.ajax({
                        type:'GET',
                        url: "{{route('add.wishlist')}}",
                        dataType:'json',
                        data:{id :id },
                        success: function(data){
                            swal(data.message);
                        }
                    });
                }
            else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })


    });
  </script>

<script>
    $(document).on("click", "#wishList" , function() {
        //console.log('hi');
        var id = $(this).attr("data-productSku");
        swal({
            title: "Want to add this product into wishlist ?",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, add it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                $.ajax({
                    type:'GET',
                    url: "{{route('add.wishlist')}}",
                    dataType:'json',
                    data:{id :id },
                    success: function(data){
                        swal(data.message);
                    }
                });
            }
            else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })


    });
  </script>
@endpush
