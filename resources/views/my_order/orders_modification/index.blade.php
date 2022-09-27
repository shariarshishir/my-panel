@extends('layouts.app')

@section('content')

@include('my_order.partials._profile_list')

<div id="order-modification" class="col s12">@include('my_order.orders_modification._partial_index')</div>


@endsection

@include('my_order.partials._scripts')
