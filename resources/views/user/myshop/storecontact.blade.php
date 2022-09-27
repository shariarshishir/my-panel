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
        <div class="card card-with-padding">
            Contact Coming Soon...
        </div>
    </div>

</div>

@endsection
