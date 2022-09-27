@extends('layouts.app')

@section('content')

@include('user.profile.partials._profile_list')

<div id="order-modification" class="col s12">@include('user.profile.orders_modification.index')</div>


@endsection

@include('user.profile.partials._scripts')
