@extends('layouts.app')

@section('content')
@include('sweet::alert')

<div id="profile" class="col s12 profile_information_wrap">@include('user.profile.user_info.index')</div>

@endsection

@include('user.profile.partials._scripts')