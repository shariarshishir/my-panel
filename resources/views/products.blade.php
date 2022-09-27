
@extends('layouts.app_containerless')

@section('content')
    <div id="main">
        <div class="row">
            <div class="banner-outer-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col m3 shop-categories-wrap">
                            <div class="card card-with-padding">
                                <div class="card-content">
                                    @php
                                        $segment2 = Request::segment(2);
                                    @endphp
                                    <ul>


                                        @foreach($categories as $category)
                                        <li  class="@php echo ($category['slug'] == $segment2)?' active':''; @endphp">
                                            <a href="{{route('categories.product',$category['slug'])}}">{{$category['name']}}</a>
                                            @if(!empty($category['children']))
                                            <ul class="sub-level">
                                                <li class="parent-cat-as-heading">{{$category['name']}}</li>
                                                @foreach($category['children'] as $childcategory)
                                                    <li  class="@php echo ($childcategory['slug'] == $segment2)?' active':''; @endphp">
                                                        <a href="{{route('categories.product',$childcategory['slug'])}}">{{ $childcategory['name'] }}</a>
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
                        <div class="col m9 banner-outer">
                            <div class="slider banner-slider">
                                <ul class="slides">
                                    <li>
                                        <img src="{{Storage::disk('s3')->url('public/frontendimages/banner_img.png')}}" alt="" /> <!-- random image -->
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-key-features">
                                <div class="row">
                                    <div class="col m4">
                                        <div class="key-item green lighten-1">
                                            <a href="javascript:void(0);" class="overlay_hover"></a>
                                            <div class="key-icon">
                                                <i aria-hidden="true" class="fab fa-phoenix-framework"></i>
                                            </div>
                                            <div class="key-content">
                                                <h4>SHOP BY STORE</h4>
                                                <p>Search By Store</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m4">
                                        <div class="key-item green lighten-1">
                                            <a href="javascript:void(0);" class="overlay_hover"></a>
                                            <div class="key-icon">
                                                <i aria-hidden="true" class="fas fa-circle-notch"></i>
                                            </div>
                                            <div class="key-content">
                                                <h4>EASY RETURNS</h4>
                                                <p>Up to &amp; days</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m4">
                                        <div class="key-item green lighten-1">
                                            <a href="javascript:void(0);" class="overlay_hover"></a>
                                            <div class="key-icon">
                                                <i aria-hidden="true" class="fas fa-wallet"></i>
                                            </div>
                                            <div class="key-content">
                                                <h4>PAYMENTS</h4>
                                                <p>Credit cards available</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-area">
                <div class="container">
                    <div class="row">
                        <div class="col m3 left-column">

                            <div class="module-price-filter">
                                <h3>Price Filter</h3>
                                <div class="price-slider-wrapper">
                                    <div id="price-slider"></div>
                                </div>
                                <hr class="p-0 mb-10" style="opacity: 0.3; margin: 40px 0px 20px;">
                            </div>
                            <div class="module-color-filter">
                                <h3>Color</h3>
                                <form action="#" class="display-grid">
                                    <label class="color-item">
                                        <input type="checkbox">
                                        <span>White</span>
                                    </label>
                                    <label class="color-item">
                                        <input type="checkbox">
                                        <span>Black</span>
                                    </label>
                                    <label class="color-item">
                                        <input type="checkbox">
                                        <span>Amber</span>
                                    </label>
                                    <label class="color-item">
                                        <input type="checkbox">
                                        <span>Blue</span>
                                    </label>
                                    <label class="color-item">
                                        <input type="checkbox">
                                        <span>Green</span>
                                    </label>
                                    <label class="color-item">
                                        <input type="checkbox">
                                        <span>Pink</span>
                                    </label>
                                    <label class="color-item">
                                        <input type="checkbox">
                                        <span>Yellow</span>
                                    </label>
                                </form>
                                <hr class="p-0 mb-10" style="opacity: 0.3; margin: 20px 0px;">
                            </div>
                            <div class="module-size-filter">
                                <h3>Size</h3>
                                <form action="#" class="display-grid">
                                    <label class="size-item">
                                        <input type="checkbox">
                                        <span>XXXL</span>
                                    </label>
                                    <label class="size-item">
                                        <input type="checkbox">
                                        <span>XXL</span>
                                    </label>
                                    <label class="size-item">
                                        <input type="checkbox">
                                        <span>XL</span>
                                    </label>
                                    <label class="size-item">
                                        <input type="checkbox">
                                        <span>M</span>
                                    </label>
                                    <label class="size-item">
                                        <input type="checkbox">
                                        <span>L</span>
                                    </label>
                                    <label class="size-item">
                                        <input type="checkbox">
                                        <span>S</span>
                                    </label>
                                </form>
                                <hr class="p-0 mb-10" style="opacity: 0.3; margin: 20px 0px;">
                            </div>
                            <div class="module-rating-filter">
                                <h3>Ratings</h3>
                                <form action="#" class="display-grid">
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                    <label class="rating-item">
                                        <input type="checkbox">
                                        <span>
                                            <i class="material-icons amber-text"> star </i>
                                        </span>
                                    </label>
                                </form>
                            </div>
                            <a href="javascript:void(0);" class="waves-effect waves-block waves-light btn green lighten-1">Filter</a>
                        </div>
                        <div class="col m9 content-column">
                            <div class="row show-product-results-wrapper">
                                <div class="col s12 m12 l12 show-product-results-inside-wrapper">
                                    <div class="col s12 m6 l6 show-total-results">
                                        Showing {{($products->currentpage()-1)*$products->perpage()+1}} to {{$products->currentpage()*$products->perpage()}} of  {{$products->total()}} results
                                    </div>
                                    <div class="col s12 m6 l6 product-filters-and-views">
                                        <div class="col s6 m8 l8 sorting-filter">
                                            <select class="select2 browser-default sorting">
                                                <option value="" disabled selected>Select</option>
                                                <option value="name">Sort by Name</option>
                                                <option value="created_at">Sort by Latest</option>
                                            </select>
                                            @php
                                             $segment = Request::segment(1);
                                            @endphp
                                            <input type="hidden" value="{{ $segment }}" name="slug">
                                        </div>
                                        <div class="col s12 m4 l4 hide-on-med-and-down grid-list-filter">
                                            <a href="javascript:void(0);" class="btn btn-default btn-grid active">
                                                <i class="material-icons dp48">grid_on</i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-default btn-list">
                                                <i class="material-icons dp48">list</i>
                                            </a>
                                        </div>
                                        <div class="flanel-filter hide-on-large-only">
                                            <a href="javascript:void(0);" class="btn btn-defaultbtn waves-effect waves-light green lighten-1 filter-result-btn" onclick="openSideNavFromLeftFilterResult()">
                                                <i class="fas fa-filter"></i>
                                            </a>
                                            <div id="SideNavFromLeftFilterResult" class="sidenav-left">
                                                <a href="javascript:void(0)" class="sideNavCloseBtn" onclick="closeSideNavFromLeftFilterResult()">&times;</a>

                                                <div class="module-price-filter">
                                                    <h3>Price Filter</h3>
                                                    <div class="price-slider-wrapper">
                                                        <div id="price-slider"></div>
                                                    </div>
                                                    <hr class="p-0 mb-10" style="opacity: 0.3; margin: 40px 0px 20px;">
                                                </div>
                                                <div class="module-color-filter">
                                                    <h3>Color</h3>
                                                    <form action="#" class="display-grid">
                                                        <label class="color-item">
                                                            <input type="checkbox">
                                                            <span>White</span>
                                                        </label>
                                                        <label class="color-item">
                                                            <input type="checkbox">
                                                            <span>Black</span>
                                                        </label>
                                                        <label class="color-item">
                                                            <input type="checkbox">
                                                            <span>Amber</span>
                                                        </label>
                                                        <label class="color-item">
                                                            <input type="checkbox">
                                                            <span>Blue</span>
                                                        </label>
                                                        <label class="color-item">
                                                            <input type="checkbox">
                                                            <span>Green</span>
                                                        </label>
                                                        <label class="color-item">
                                                            <input type="checkbox">
                                                            <span>Pink</span>
                                                        </label>
                                                        <label class="color-item">
                                                            <input type="checkbox">
                                                            <span>Yellow</span>
                                                        </label>
                                                    </form>
                                                    <hr class="p-0 mb-10" style="opacity: 0.3; margin: 20px 0px;">
                                                </div>
                                                <div class="module-size-filter">
                                                    <h3>Size</h3>
                                                    <form action="#" class="display-grid">
                                                        <label class="size-item">
                                                            <input type="checkbox">
                                                            <span>XXXL</span>
                                                        </label>
                                                        <label class="size-item">
                                                            <input type="checkbox">
                                                            <span>XXL</span>
                                                        </label>
                                                        <label class="size-item">
                                                            <input type="checkbox">
                                                            <span>XL</span>
                                                        </label>
                                                        <label class="size-item">
                                                            <input type="checkbox">
                                                            <span>M</span>
                                                        </label>
                                                        <label class="size-item">
                                                            <input type="checkbox">
                                                            <span>L</span>
                                                        </label>
                                                        <label class="size-item">
                                                            <input type="checkbox">
                                                            <span>S</span>
                                                        </label>
                                                    </form>
                                                    <hr class="p-0 mb-10" style="opacity: 0.3; margin: 20px 0px;">
                                                </div>
                                                <div class="module-rating-filter">
                                                    <h3>Ratings</h3>
                                                    <form action="#" class="display-grid">
                                                        <label class="rating-item">
                                                            <input type="checkbox">
                                                            <span>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                            </span>
                                                        </label>
                                                        <label class="rating-item">
                                                            <input type="checkbox">
                                                            <span>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                            </span>
                                                        </label>
                                                        <label class="rating-item">
                                                            <input type="checkbox">
                                                            <span>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                            </span>
                                                        </label>
                                                        <label class="rating-item">
                                                            <input type="checkbox">
                                                            <span>
                                                                <i class="material-icons amber-text"> star </i>
                                                                <i class="material-icons amber-text"> star </i>
                                                            </span>
                                                        </label>
                                                        <label class="rating-item">
                                                            <input type="checkbox">
                                                            <span>
                                                                <i class="material-icons amber-text"> star </i>
                                                            </span>
                                                        </label>
                                                    </form>
                                                </div>
                                                <a href="javascript:void(0);" class="waves-effect waves-block waves-light btn green lighten-1 btn-mobile-flanel-filter">Filter</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="prodcuts-list">
                                <div class="row active_grid">
                                @if(count($products)>0)
                                    @foreach($products as $key=>$product)

                                    <div class="col s12 m4 l4">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="product_img">
                                                    <a href="javascript:void();" class="overlay_hover"></a>
                                                    @foreach($product->images as $key=>$image)
                                                        @if($key==0)
                                                            <img src="{{asset('storage/'.$image->image)}}" class="single-product-img" alt="" />
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
                                                    $ @foreach (json_decode($product->attribute) as $k => $v)
                                                        @if($loop->last)
                                                            {{ $v[2] }}
                                                        @endif
                                                    @endforeach
                                                    </div>
                                                    <div class="product_info_details">
                                                        <div class="shipping_label">Free Shipping</div>
                                                        <div class="rating_label">
                                                            <i class="material-icons pink-text"> star </i>
                                                            <span>4.5</span>
                                                        </div>
                                                    </div>
                                                    <div class="vendor_name">
                                                        <a href="{{ route('users.myshop',$product->vendor->vendor_uid) }}">{{$product->vendor->vendor_name}}</a>
                                                    </div>
                                                </div>
                                                <!-- Modal Structure -->
                                                <div  id="product-details-modal_{{$product->sku}}" class="modal modal-fixed-footer product-details-modal" tabindex="0">
                                                    <div class="modal-content">
                                                        <div class="row">
                                                            <div class="col m6 s12 modal-product-images">
                                                            @foreach($product->images as $key=>$image)
                                                                <img src="{{asset('storage/'.$image->image)}}" class="responsive-img" alt="" />
                                                            @endforeach
                                                            </div>
                                                            <div class="col m6 s12">
                                                                <h5>{{$product->name}}</h5>
                                                                <span class="new badge ml-0 mr-2 pink lighten-1 rating-badge" data-badge-caption="">
                                                                    <i class="material-icons white-text"> star </i> <span class="rating_value">4.5</span>
                                                                </span>
                                                                <p>Availability: <span class="green-text">Available</span></p>
                                                                <p class="pink-text">Free Shipping</p>
                                                                <div class="border-separator"></div>
                                                                <ul class="list-bullet">
                                                                    <li class="list-item-bullet">{{$product->sku}}</li>
                                                                    <li class="list-item-bullet">{!! $product->description !!}</li>
                                                                </ul>
                                                                <h5>$ @foreach (json_decode($product->attribute) as $k => $v)
                                                                    @if($loop->last)
                                                                        {{ $v[2] }}
                                                                    @endif
                                                                @endforeach</h5>
                                                                <input type="hidden" value="{{$product->sku}}" name="sku">
                                                                <!--button id="add_to_cart" data-id="{{$product->sku}}"class="btn btn-success" onclick="addToCart('{{$product->sku}}')">ADD TO CART</button-->
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
                                    </div>
                                    @endforeach




                                </div>
                                <div class="pagination-block-wrapper">
                                    <div class="col s12 center">
                                        {!! $products->links() !!}
                                    </div>
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
        console.log('hi');
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



