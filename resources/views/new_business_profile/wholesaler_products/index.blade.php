@php
    $product_type_mapping_child_id = array_key_exists('product_type_mapping_child_id', app('request')->input())?app('request')->input('product_type_mapping_child_id'): [];
    $product_tag = array_key_exists('product_tag', app('request')->input())?app('request')->input('product_tag'): [];
    $view_min_lead_time= array_key_exists('min_lead', app('request')->input())?app('request')->input('min_lead'): null;
    $view_max_lead_time= array_key_exists('max_lead', app('request')->input())?app('request')->input('max_lead'): null;
    $view_max_moq = array_key_exists('max_moq', app('request')->input())?app('request')->input('max_moq'): null;
    $view_min_moq = array_key_exists('min_moq', app('request')->input())?app('request')->input('min_moq'): null;
@endphp

@extends('layouts.app_containerless')
@section('content')
@include('new_business_profile.wholesaler_products._add_product_modal')
@include('new_business_profile.wholesaler_products._edit_product_modal')

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
                        <div class="new_profile_account_myrfq_details">
                            @include('new_business_profile._product_filter_mobile')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile_account_innerinfo_wrap">
        <div class="container">
            <div class="account_profile_box">
                <div class="row">
                    <div class="col s12 m112">
                        <div class="profile_supplier_account_product_wrap">
                            <div class="profile_account_explore_info">
                                <div class="row">
                                    <div class="col s12 m12 l9">
                                        <div class="profile_account_searchBar">
                                            <div class="row">
                                                <div class="col s12 m5 l4">
                                                    <a class="modal-trigger post_new product-add-modal-trigger" href="javascript:void(0);">
                                                        <i class="material-icons">add</i><span>Add New</span>
                                                    </a>
                                                </div>
                                                <div class="col s12 m7 l8">
                                                    <form action="{{route('new.profile.products',$alias)}}">
                                                        <div class="profile_account_search">
                                                            <i class="material-icons">search</i>
                                                            <input class="profile_filter_search" type="search" placeholder="Search Merchant Bay Studio/Raw Material Libraries" name="search"/>
                                                            <input type="hidden" name="view" value="{{request()->view}}">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile_product_view_menu">
                                            <ul>
                                                <li class="grid_view {{$view == 'grid'? 'active' : ''}}">
                                                    <a href="{{route('new.profile.products',['alias'=> $alias,'view' => 'grid','page' =>$products->currentPage()])}}" ><i class="material-icons">grid_view</i></a>
                                                </li>
                                                <li class="{{$view == 'list'? 'active' : ''}}">
                                                    <a href="{{route('new.profile.products',['alias'=> $alias,'view' => 'list','page' =>$products->currentPage()])}}" ><i class="material-icons">view_list</i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product_design_wrapper profile_account_product">
                                            @if($view == 'grid')
                                                @include('new_business_profile.wholesaler_products.products_list_grid_view')
                                            @else
                                                @include('new_business_profile.wholesaler_products.products_list_list_view')
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col s12 m12 l3 new_profile_account_rightsidebar_desktop">
                                        @include('new_business_profile._product_filter')
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

@endsection

@include('new_business_profile.wholesaler_products._scripts')
