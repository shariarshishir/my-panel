@extends('layouts.app')
@section('style')
<style>
.block3d-wrapper {
    width: 950px;
    margin: 0 auto;
}
</style>
@endsection

@section('content')
<div class="block3d-wrapper">
<center><img src="{{Storage::disk('s3')->url('public/frontendimages/3d_studio_banner.jpeg')}}" alt="3d-Studio"></center>
</div>
@endsection
