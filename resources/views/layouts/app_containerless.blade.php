<!DOCTYPE html>
<html lang="en">
<head>
@include('include._head')
</head>
<body itemscope="" itemtype="https://schema.org/WebPage">
{{-- For loader --}}
<div class="overlay"></div>
<div id="loadingProgressContainer" style="display: none;">
    <div id="loadingProgressElement">
        <img src="{{Storage::disk('s3')->url('public/frontendimages/ajax-loader-bar.gif')}}" width="150" height="150" alt="Loading">
        <div class="loading-message">Loading...</div>
    </div>
</div>
{{-- end loader --}}
<!-- Header -->
@include('include._header')
<!-- /.Header -->

<!-- Content Wrapper. Contains page content -->
<div id="main" itemprop="mainEntity">
  <div class="row">
      @yield('content')
  </div>
</div>
<!-- /.content-wrapper -->

<!-- Header -->
@include('include._footer')
@yield('style')
<!-- /.Header -->
<script type=“text/javascript”>
_linkedin_partner_id = “3577772";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script><script type=“text/javascript”>
(function(l) {
if (!l){window.lintrk = function(a,b){window.lintrk.q.push([a,b])};
window.lintrk.q=[]}
var s = document.getElementsByTagName(“script”)[0];
var b = document.createElement(“script”);
b.type = “text/javascript”;b.async = true;
b.src = “https://snap.licdn.com/li.lms-analytics/insight.min.js”;
s.parentNode.insertBefore(b, s);})(window.lintrk);
</script>
 
<noscript>
<img height=“1" width=“1” style=“display:none;” alt=“” src=“https://px.ads.linkedin.com/collect/?pid=3577772&fmt=gif” />
</noscript>
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/20602192.js"></script>
<!-- End of HubSpot Embed Code --> 
</body>
</html>
