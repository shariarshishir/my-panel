@php
    $product_type_mapping_child_id = array_key_exists('product_type_mapping_child_id', app('request')->input())?app('request')->input('product_type_mapping_child_id'): [];
    $product_tag = array_key_exists('product_tag', app('request')->input())?app('request')->input('product_tag'): [];
    $view_min_lead_time = array_key_exists('min_lead', app('request')->input())?app('request')->input('min_lead'): null;
    $view_max_lead_time = array_key_exists('max_lead', app('request')->input())?app('request')->input('max_lead'): null;
    $view_max_moq = array_key_exists('max_moq', app('request')->input())?app('request')->input('max_moq'): null;
    $view_min_moq = array_key_exists('min_moq', app('request')->input())?app('request')->input('min_moq'): null;
    $searchInput = isset($_REQUEST['search_input']) ? $_REQUEST['search_input'] : '';
@endphp

@php $studio_child= productTypeMapping(1); @endphp
@php $raw_materials_child= productTypeMapping(2); @endphp

@extends('layouts.app_containerless')
@section('content')

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
                        @include('new_business_profile._rfq_filter_mobile')
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
                                <li class="profile_my_rfq {{ Route::is('new.profile.all_queries', $alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.all_queries', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Queries</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m9 l10">
                        <div class="profile_account_explore_info">
                            <div class="row">
                                <div class="col s12 m12 l9">
                                    <div class="profile_account_searchBar">
                                        <div class="row">
                                            <div class="col s12 m5 l4">
                                                <a class="open-create-rfq-modal post_new" href="{{route('rfq.create')}}">
                                                    <i class="material-icons">add</i><span>Post New</span>
                                                </a>
                                            </div>
                                            <div class="col s12 m7 l8">
                                                <div class="col s12 m10">
                                                    <form action="{{route('new.profile.search_rfqs',$alias)}}">
                                                        @csrf
                                                        <div class="profile_account_search">
                                                            <i class="material-icons">search</i>
                                                            <input class="profile_filter_search" type="search" name="search_input" value="{{$searchInput}}" placeholder="Search Merchant Bay Studio/Raw Material Libraries" />
                                                            <a href="javascript:void(0);" class="reset_rfq_filter" style="@php echo isset($_REQUEST['search_input']) ? 'display: block;' : 'display: none;' @endphp"><i class="material-icons">restart_alt</i></a>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col s12 m2 explore-rfq-products-menu">
                                                    <a class="dropdown-trigger explore-rfq-products-menu-trigger" itemprop="Products" href="javascript:void(0);" data-target="explore-rfq-products">
                                                        <i class="material-icons right">filter_alt</i> <span>Explore More</span>
                                                    </a>
                                                    <ul id="explore-rfq-products" class="dropdown-content subNav" itemscope itemtype="https://schema.org/ListItem">
                                                        <li itemprop="itemListElement">
                                                            <a class="" itemprop="Products" href="javascript:void(0);" data-target="">Studio<i class="material-icons right">arrow_drop_down</i></a>
                                                            <ul id="" class="sub_dropdown" itemscope itemtype="https://schema.org/ListItem">
                                                                @foreach ($studio_child as $id => $title)
                                                                    <li itemprop="itemListElement"><a itemprop={{ucwords(str_replace("_", " ",$title))}} href="{{route('product.type.mapping',['studio', $title])}}" >{{ucwords(str_replace("_", " ",$title))}}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                        <li itemprop="itemListElement">
                                                            <a class="" itemprop="Products" href="javascript:void(0);" data-target="">Raw Materials<i class="material-icons right">arrow_drop_down</i></a>
                                                            <ul id="" class="sub_dropdown" itemscope itemtype="https://schema.org/ListItem">
                                                                @foreach ($raw_materials_child as $id => $title)
                                                                    <li itemprop="itemListElement"><a itemprop={{ucwords(str_replace("_", " ",$title))}} href="{{route('product.type.mapping',['raw_materials', $title])}}" >{{ucwords(str_replace("_", " ",$title))}}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product_design_wrapper profile_account_rfqproduct">
                                        @if($business_profile->business_type == 'manufacturer')
                                            <div class="row product-list">
                                                @if($products->count() > 0)
                                                    @foreach ($products  as $product)
                                                    <div class="col s6 m4 product_item_box">
                                                        <div class="productBox">
                                                            <div class="inner_productBox">
                                                                <a href="{{route('mix.product.details', [$product->flag, $product->id])}}">
                                                                    <div class="imgBox">
                                                                        @foreach($product->product_images as $image)
                                                                            <img src="{{Storage::disk('s3')->url('public/'.$image->product_image)}}" class="" alt="">
                                                                            @break
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="products_inner_textbox">
                                                                        <h4><span>{{$product->title}}</span></h4>
                                                                        <div class="row">
                                                                            <div class="col s12 m6">
                                                                                <div class="product_moq">
                                                                                    MOQ: <br> <span>{{$product->moq}}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col s12 m6">
                                                                                <div class="pro_leadtime">
                                                                                    Lead Time <br> <span>{{$product->lead_time}}</span> days
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="pagination-block-wrapper">
                                                        <div class="col s12 center">
                                                            {!! $products->withQueryString()->links() !!}
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
                                        @else
                                            <div class="row product-list">
                                                @if($products->count() > 0)
                                                    @foreach ($products  as $product)
                                                    <div class="col s6 m4 product_item_box">
                                                        <div class="productBox">
                                                            <div class="inner_productBox">
                                                                <a href="{{route('mix.product.details', [$product->flag, $product->id])}}">
                                                                    <div class="imgBox">
                                                                        @foreach($product->images as $image)
                                                                            <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="" alt="">
                                                                            @break
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="products_inner_textbox">
                                                                        <h4><span>{{$product->name}}</span></h4>
                                                                        <div class="row">
                                                                            <div class="col s12 m6">
                                                                                <div class="product_moq">
                                                                                    MOQ: <br> <span>{{$product->moq}}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col s12 m6">
                                                                                <div class="pro_leadtime">
                                                                                    Lead Time <br> <span>@include('new_business_profile.wholesaler_products._product_lead_time')</span> days
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="pagination-block-wrapper">
                                                        <div class="col s12 center">
                                                            {!! $products->appends(request()->query())->links() !!}
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
                                        @endif
                                    </div>
                                </div>
                                <div class="col s12 m12 l3 new_profile_account_rightsidebar_desktop">
                                    @include('new_business_profile._rfq_filter')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('new_business_profile.create_rfq_modal')
@include('new_business_profile.share_modal')
@endsection
@push('js')
<script>
$(document).ready(function(){

    $(".reset_rfq_filter").click(function(){
        location.href = "{{route('new.profile.rfqs', $alias)}}";
    });

})
</script>
@endpush
