@extends('layouts.app')

@section('content')

@include('user.profile.partials._profile_list')

<div id="orders" class="col s12">@include('user.profile.orders.index')</div>


@endsection

@include('user.profile.partials._scripts')
