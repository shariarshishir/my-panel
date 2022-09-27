@extends('layouts.app')

@section('content')

@include('user.profile.partials._profile_list')

@if( auth()->user()->user_type!='buyer' )
 <div id="products" class="col s12">@include('user.profile.products.index')</div>
@endif


@endsection

@include('user.profile.partials._scripts')
