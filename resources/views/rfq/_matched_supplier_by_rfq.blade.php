@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="row">
                <h4>{{$rfq['title']}}</h4>
                <div class="col s12 m2">
                    <label>Product Type</label>
                    {{$rfq['industry']}}
                </div>
                <div class="col s12 m2">
                    <label>Product Tags</label>
                    @foreach($rfq['category'] as $tag)
                        {{$tag['name']}}
                    @endforeach
                </div>
                <div class="col s12 m2">
                    <label>Quantity</label>
                    {{$rfq['quantity']}}
                </div>
                <div class="col s12 m2">
                    <label>Target Price</label>
                    {{$rfq['unit_price']}}
                </div>
                <div class="col s12 m2">
                    <label>Delivery In</label>
                    {{$rfq['delivery_time']}}
                </div>
                <div class="col s12 m2">
                    <label>Delivery To</label>
                    {{$rfq['destination']}}
                </div>
            </div>
        </div>
        <div class="rfq_new_layout_match_supplier_with_rfq">
            <div class="match_supplier_rfq_single_wrapper">
                <div class="row single_wraper_gapping">

                    @foreach($businessProfiles as $businessProfile)
                    <div class="col s12 m4 matched_supplier_item">
                        <!-- new -->
                        <div class="match_supplier_rfq_single_content">
                            <div class="input-field">
                                <label>
                                    <input type="checkbox" name="remember">
                                    <span></span>
                                </label>
                            </div>
                            <div class="match_supplier_rfq_single_content_inner_part">

                                <!-- First div part -->
                                <div class="row sparkle_part">
                                    <div class="col s12 m3 image_width_wrap">
                                        <img class="image_width" src='https://s3.ap-southeast-1.amazonaws.com/service.products/public/{{$businessProfile['business_profile_logo']}}' alt="">
                                    </div>
                                    <div class="col s12 m5 sparkle_knit">
                                        <h3>{{$businessProfile['business_name']}}</h3>
                                        <p>{{$businessProfile['location']}}</p>
                                    </div>
                                    <div class="col s12 m4 middle_wrap">
                                        <div class="">
                                            @if($businessProfile['profile_verified_by_admin'] == 1)
                                            <i class="material-icons">check_circle</i>
                                            @else
                                            <i class="material-icons">close_circle</i>
                                            @endif
                                        </div>
                                        <div class="icon_wrap">
                                            <p>@foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                                @if($data->name == 'year_of_establishment')    
                                                    <h5>{{date("Y")-$data->value}}+</h5>
                                                @endif
                                            @endforeach</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Second div part -->
                                <div class="middle_part_image_wrapper">
                                    <h6>Certification:</h6>
                                    <div class="inner_content_image">
                                    @foreach($businessProfile['certifications'] as $cert)
                                    <img class="" src='https://s3.ap-southeast-1.amazonaws.com/service.products/public/{{$cert['image']}}' alt="">
                                    @endforeach
                                </div>
                                </div>
                                <!-- Third div part -->
                                <div class="main_product_wrap">
                                    <h6>Main Products:</h6>
                                    <div class="row main_product_inner">
                                    <div class="col s12 m10">
                                        @foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                            @if($data->name == 'main_products')    
                                                <h5>{{$data->value}}</h5>
                                            @endif
                                        @endforeach
                                    </div>
                                        <div class="col s12 m2 chatbox_wrap">
                                            <img src="./images/chat-img.png" alt=""> <span>5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
@endsection