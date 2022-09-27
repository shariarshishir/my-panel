@extends('layouts.vendor')
@section('content')
!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vendor </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<legend>Store Details</legend>
						<div class="row">
							<div class="col-md-6">
								<p><i class="fas fa-user"></i> {{$vendor->vendor_name}}</p>
								<p><i class="fas fa-map-marker"></i> {{$vendor->vendor_address}}</p>
								<p><i class="fas fa-envelope"></i> {{$vendor->user->email}}</p>
							</div>
							<div class="col-md-6">
								<p><a href="{{route('product.index',$vendorId)}}">Total Products:</a> {{count($products)}}</p>
								<p><a href="{{route('vendor.order.index',$vendorId)}}">Total Orders:</a> {{count($storeOrders)}}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </section>
</div>



@endsection


