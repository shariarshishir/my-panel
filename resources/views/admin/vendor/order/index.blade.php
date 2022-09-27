@extends('layouts.vendor')
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

	  	<div class="row" style="padding-bottom: 20px;">
			<div class="col-lg-12">
				<a href="{{route('vendor.order.create',$vendorId)}}" class="btn btn-success" style="display: none;"><i class="fas fa-plus"></i> Add New order</a>
			</div>
		</div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <legend>Orders List</legend>
                    @if(count($collection)>0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>Order No.</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($collection as $list)
                                <tr>
                                    <td>
                                        <a href="{{route('vendor.order.show',['vendor'=>$vendorId,'order'=>$list->id])}}">{{$list->order_number}}</a>
                                    </td>
                                    <td class="@switch($list->state)
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
                                    <td class="{{$list->payment_status == 'paid' ? 'text-success' : 'text-warning'}}">{{ ucfirst($list->payment_status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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


