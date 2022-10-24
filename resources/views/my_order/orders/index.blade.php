@extends('layouts.app')

@section('content')

@include('my_order.partials._profile_list')

<div id="orders" class="col s12">@include('my_order.orders._partial_index')</div>


@endsection

@include('my_order.partials._scripts')
