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
    <div class="col m12">
        <div class="col m12 card card-with-padding">
            <legend>Store Profile</legend>
            <div>
                {{$vendor->user->images}}
                <p><b>Store name:</b> {{$vendor->vendor_name}}</p>
                <p><b>Country / Region:</b> {{$vendor->vendor_country}}</p>
                <p><b>Business Type:</b> {{$vendor->vendor_type}}</p>
                @php  $mainProduct= singleProductInformation($vendor->vendor_mainproduct); @endphp
                 <p><b>Main Products:</b>@if(isset($mainProduct->name)) {{$mainProduct->name}} @endif</p>
                <p><b>Total Employees</b> {{$vendor->vendor_totalemployee}}</p>
                <p><b>Year Established:</b> {{$vendor->vendor_yearest}}</p>
                <p><b>Certification:</b> {{$vendor->vendor_certification}}</p>
            </div>
        </div>
    </div>

</div>

@endsection
