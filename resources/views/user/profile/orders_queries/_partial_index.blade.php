@extends('layouts.app')

@section('content')

@include('user.profile.partials._profile_list')

<div id="order-query" class="col s12">@include('user.profile.orders_queries.index')</div>


@endsection

@include('user.profile.partials._scripts')
