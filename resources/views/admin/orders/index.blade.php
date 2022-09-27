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
                        <li class="breadcrumb-item active">Orders </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">

	  	{{-- <div class="row" style="padding-bottom: 20px;">
			<div class="col-lg-12">
				<a href="{{route('vendor.order.create',$vendorId)}}" class="btn btn-success" style="display: none;"><i class="fas fa-plus"></i> Add New order</a>
			</div>
		</div> --}}

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <legend>Orders List</legend>
                    @if(count($collection)>0)
                    <div class="no_more_tables">
                        <table class="table table-bordered orders-table">
                            <thead class="cf">
                                <tr>
                                    <th>Order No.</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($collection as $list)
                                    <tr>
                                        <td data-title="Order No.">
                                            <a href="{{route('business.profile.order.show',['business_profile_id' => $list->business_profile_id,'order_id'=>$list->id])}}">{{$list->order_number}}</a>
                                        </td>
                                        <td data-title="Order Status" class="@switch($list->state)
                                            @case('pending')
                                                text-danger
                                                @break
                                            @case('approved')
                                                text-success
                                                @break
                                            @case('delivered')
                                                text-info
                                                @break
                                            @default

                                        @endswitch">{{ ucfirst($list->state)}}</td>
                                        <td data-title="Payment Status" class="{{$list->payment_status == 'paid' ? 'text-success' : 'text-warning'}}">{{ ucfirst($list->payment_status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    

                    @else
                        <div class="alert alert-info alert-dismissible">
                            INFO : No orders available.
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    </section>
</div>

@endsection
@push('js')
  <script>
      $('.orders-table').DataTable();
  </script>
@endpush


