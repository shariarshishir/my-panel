@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Details </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content admin_rfq_wrapper">
      <div class="container-fluid">
        @if($product->flag == 'shop')
            @include('admin.products._shop_product_details')
        @else
            @include('admin.products._mb_product_details')
        @endif
      </div>
    </section>
</div>

@endsection

@include('admin.products._scripts')
