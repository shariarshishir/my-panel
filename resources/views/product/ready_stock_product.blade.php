
@extends('layouts.app_containerless')
@section('content')
@php
    $location = array_key_exists('location', app('request')->input())?app('request')->input('location'): '';
    $product_name = array_key_exists('product_name', app('request')->input())?app('request')->input('product_name'): '';
    $lead_minimum_range = array_key_exists('lead_minimum_range', app('request')->input())?app('request')->input('lead_minimum_range'): '';
    $lead_maximum_range = array_key_exists('lead_maximum_range', app('request')->input())?app('request')->input('lead_maximum_range'): '';
    $select_product_category= array_key_exists('product_category', app('request')->input())?app('request')->input('product_category'): '';
    $price_minimum_range = array_key_exists('price_minimum_range', app('request')->input())?app('request')->input('price_minimum_range'): '';
    $price_maximum_range = array_key_exists('price_maximum_range', app('request')->input())?app('request')->input('price_maximum_range'): '';
    $gender = array_key_exists('gender', app('request')->input())?app('request')->input('gender'): [];
    $sample_availability = array_key_exists('sample_availability', app('request')->input())?app('request')->input('sample_availability'): [];
@endphp

    <div class="mainContainer">
        <div class="container">

            <div class="products_filter_wrapper">
                <div class="productSidenav" id="productSidenav">
                    <div class="product_filter_empty_area"></div>
                    <div class="products_filter_list">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeProductNav()"><i class="material-icons">east</i></a>
                        <h3>Filter by</h3>
                        <form action="{{route('readystockproducts')}}" method="get" id="product_filter_form">
                            {{--location search  --}}
                            <div class="filter_search filter_box">
                                <h4>Location</h4>
                                <div class="filter_search_inputbox">
                                    <i class="material-icons">pin_drop</i>
                                    <input class="filter_search_input typeahead" type="text" name="location" placeholder="Type any location" value="{{$location}}">
                                    {{-- <input class="btn_green btn_search" type="submit" value="search" onclick="this.form.submit();"> --}}

                                </div>
                            </div>

                            {{--category--}}
                            <div class="filter_box filter_min_max">
                                <h4>Product Category</h4>
                                <select class="select2" name="product_category" id="product_category">
                                    <option value="">Select</option>
                                    @foreach($product_category as $category)
                                    <option value="{{$category->id}}" {{$category->id == $select_product_category ? 'selected' : ''}}>
                                        {{$category['name']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- price --}}
                            <div class="filter_box filter_min_max">
                                <h4>Price</h4>
                                <div class="price-slider-wrapper">
                                    <div class="row price-value">
                                        <input type="text" name="price_minimum_range" id="minimum_range" class="form-control filter-search-price-range" placeholder="min"  value="{{$price_minimum_range}}" />
                                        <span class="price-divider to">to</span>
                                        <input type="text" name="price_maximum_range" id="maximum_range" class="form-control filter-search-price-range" placeholder="max" value="{{$price_maximum_range}}" />
                                        <span class="price-divider"></span>
                                        {{-- <a href="javascript:void(0);"class="waves-effect waves-block waves-light btn green lighten-1 btn-filter-search-price-range filter-search-check-price-range" style="display: none;">Ok </a> --}}
                                        <input class="btn_green btn_search btn_filter_submit" type="submit" value="ok" onclick="this.form.submit();">
                                    </div>
                                </div>
                            </div>

                            {{-- gender --}}
                            <div class="filter_box">
                                <h4>Gender</h4>
                                <p>
                                    <label>
                                        <input class="btn_radio" type="checkbox" value="1"  name="gender[]" {{in_array(1, $gender) ? 'checked' : ''}}  onclick="this.form.submit();"/>
                                        <span>Male</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="btn_radio" type="checkbox" value="2"  name="gender[]" {{in_array(2, $gender) ? 'checked' : ''}}  onclick="this.form.submit();"/>
                                        <span>Female</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="btn_radio" type="checkbox" value="3"  name="gender[]" {{in_array(3, $gender) ? 'checked' : ''}} onclick="this.form.submit();"/>
                                        <span>Unisex</span>
                                    </label>
                                </p>
                            </div>

                            {{-- Sample availability --}}
                            <div class="filter_box">
                                <h4>Sample availability</h4>
                                <p>
                                    <label>
                                        <input class="btn_radio" type="checkbox" value="1"  name="sample_availability[]" {{in_array(1, $sample_availability) ? 'checked' : ''}}  onclick="this.form.submit();"/>
                                        <span>Yes</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input class="btn_radio" type="checkbox" value="0"  name="sample_availability[]" {{in_array(0, $sample_availability) ? 'checked' : ''}}   onclick="this.form.submit();"/>
                                        <span>No</span>
                                    </label>
                                </p>
                            </div>

                            <a class='btn_green btn_clear' href="{{route('readystockproducts')}}"> Reset </a>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 content-column">
                        <div class="show-product-results-wrapper products_filter_search_wrap">
                            <div class="filter_search">
                                <form action="{{route('products')}}" method="get">
                                    @if($location || $product_name || $lead_minimum_range || $lead_maximum_range || $select_product_category || $price_minimum_range || $price_maximum_range || $gender || $sample_availability)
                                    <div class="filter_by">
                                        <a href="{{route('products')}}" class="reset_product_filter_trigger btn-product-sidenav"><i class="material-icons">restart_alt</i></a>
                                        <span>Reset All</span>
                                    </div>
                                    @endif
                                    <div class="filter_by">
                                        <a onclick="openProductNav()" href="javascript:void(0);" class="btn-product-sidenav"><i class="material-icons">filter_alt</i></a>
                                        <span>Filter By</span>
                                    </div>
                                    <div class="search_inputbox_wrap">
                                        <div class="filter_search_inputbox">
                                            <i class="material-icons">search</i>
                                            <input class="filter_search_input " type="text" name="product_name" placeholder="Type product name" value="{{$product_name}}">
                                            <input class="btn_green btn_search" type="submit" value="search" onclick="">
                                        </div>
                                        <div class="show-product-results-inside-wrapper">
                                            <div class="show-total-results">
                                                Showing {{($products->currentpage()-1)*$products->perpage()+1}} to {{$products->currentpage()*$products->perpage()}} of  {{$products->total()}} results
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="product_design_wrapper">
                            <div class="product_wrapper">
                                <h3>Ready to ship Products</h3>
                                @include('product._products_list')
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

        var path = "{{ route('get.supplier.location.data') }}";
            $('input.typeahead').typeahead({
                source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {
                        return process(data);
                    });
                }
            });

        $("#product_category").change(function(){
            $('#product_filter_form').submit();
        });
    </script>
@endpush




