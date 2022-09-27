@extends('layouts.app_containerless')

@section('content')
@include('sweet::alert')

@include('wholesaler_profile.partials._profile_header')
@include('wholesaler_profile.partials._profile_list')
@include('wholesaler_profile.home.index')
@include('wholesaler_profile.partials._profile_footer')

@endsection

@include('wholesaler_profile.partials._scripts')
