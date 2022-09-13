<!DOCTYPE html>
<html>
<head>
  @include('include.admin._head')
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
  <style type="text/css">
#loadingProgressContainer {
    background: rgba(255, 255, 255, 0.9) repeat;
    display: none;
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 99999;
}
#loadingProgressElement {
    left: 50%;
    position: fixed;
    top: 20%;
    text-align: center;
    transform: translate(-50%, -20%);
}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div id="loadingProgressContainer" style="display: none;">
    <div id="loadingProgressElement">
        <img src="{{Storage::disk('s3')->url('public/frontendimages/ajax-loader-bar.gif')}}" width="150" height="150" alt="Loading">
        <div class="loading-message">Loading...</div>
    </div>
</div>  
<div class="wrapper">

  <!-- Navbar -->
    @include('include.admin._header')
    
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('include.admin._leftsidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
 
   @include('include.admin._footer')
</div>
<!-- ./wrapper -->
 

@include('include.admin._javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  @if(Session::has('success'))
      toastr.success("{{Session::get('success')}}");
  @endif

  @if(Session::has('error'))
      toastr.error("{{Session::get('error')}}");
  @endif

  @if(Session::has('info'))
      toastr.info("{{ Session::get('info') }}");
  @endif

  @if(Session::has('warning'))
  
      toastr.warning("{{ Session::get('warning') }}");
  @endif
</script>
</body>
</html>
