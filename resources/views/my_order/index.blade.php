@extends('layouts.app')

@section('content')
@include('sweet::alert')

<div id="profile" class="col s12">@include('my_order.orders.index')</div>

@endsection

@include('my_order.partials._scripts')
