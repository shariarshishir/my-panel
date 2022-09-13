<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MerchantBay Shop | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">
  <link href="{{asset('admin-assets/css/app-chat.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('admin-assets/css/admin_style.css')}}">
  <link rel="stylesheet" href="{{asset('admin-assets/css/pdf-style.css')}}" media="print">

  <!-- Google Font: Source Sans Pro -->

  <link rel="stylesheet" href="{{asset('admin-assets/css/image-uploader.min.css')}}">
  {{-- Select 2 --}}
  <link rel="stylesheet" href="{{asset('admin-assets/css/select2.min.css')}}">
  {{-- datatable --}}
  <link rel="stylesheet" href="{{ asset('admin-assets/css/datatables.min.css') }}">
  {{-- date range picker --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.0/socket.io.js" integrity="sha512-nYuHvSAhY5lFZ4ixSViOwsEKFvlxHMU2NHts1ILuJgOS6ptUmAGt/0i5czIgMOahKZ6JN84YFDA+mCdky7dD8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js" integrity="sha512-7O5pXpc0oCRrxk8RUfDYFgn0nO1t+jLuIOQdOMRp4APB7uZ4vSjspzp5y6YDtDs4VzUSTbWzBFZ/LKJhnyFOKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <style>
    .image-uploader .uploaded .uploaded-image .delete-image {
        position: absolute !important;
    }
 </style>

  @yield('css')
