@extends('layouts.app')

@section('content')

@include('user.profile.partials._profile_list')

<div id="review" class="col s12">@include('user.profile.reviews.index')</div>

@endsection

@include('user.profile.partials._scripts')
