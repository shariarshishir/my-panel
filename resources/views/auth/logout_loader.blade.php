@extends('layouts.app')
@section('content')
<div id="loadingProgressContainer" style="display: block !important; background: #fff;">
    <div id="loadingProgressElement">
        <img src="{{Storage::disk('s3')->url('public/frontendimages/ajax-loader-bar.gif')}}" width="150" height="150" alt="Loading">
        <div class="loading-message">Please wait...</div>
    </div>
</div>

<iframe id="logout-iframe" height="300" width="300" src="{{env('SSO_URL').'?type=logout&flag=global'}}"></iframe>

@endsection

@push('js')
<script type="text/javascript">
    document.getElementById('logout-iframe').onload = function() {
        //__doPostBack('ctl00$ctl00$bLogout','');
        window.location.replace("https://www.merchantbay.com/?type=logout&flag=global");
    }
</script>
@endpush
