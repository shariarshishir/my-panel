
@extends('layouts.admin')
@section('content')
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-12">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		@if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
		<!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row admin_order_query_list">
                    <div class="col-md-12">
                        <div class="card">
                            <legend>Query List</legend>
                            <div class="no_more_tables">
                                @if(count($collection)>0)
                                <table class="table table-bordered query-table">
                                    <thead class="cf">
                                        <tr>
                                            <th>SN</th>
                                            <th>Requested User</th>
                                            <th>Product Name</th>
                                            <th>Store Name</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($collection as $key=>$list)
                                            <tr>
                                                <td data-title="SN">{{ ++$key }}</td>
                                                <td data-title="Requested User">{{ $list->user->name }}</td>
                                                <td data-title="Product Name">{{ $list->product->name}}</td>
                                                <td data-title="Store Name">{{ $list->businessProfile->business_name }}</td>
                                                <td data-title="Created At">{{ \Carbon\Carbon::parse($list->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                                                <td data-title="Status">
                                                    @switch($list->state)
                                                        @case(1)
                                                        <span class="text-danger">Pending</span>
                                                            @break
                                                        @case(2)
                                                            <span class="text-info">Processed</span>
                                                            @break
                                                        @case(3)
                                                            <span class="text-success">Ordered</span>
                                                                @break
                                                        @case(4)
                                                            Cancel
                                                            @break
                                                        @default

                                                    @endswitch
                                                </td>
                                                <td data-title="Action">
                                                    <a href="{{ route('query.show', $list->id) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i> view
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @else
                                    <div class="card-alert card cyan">
                                        <div class="card-content white-text">
                                            <p>INFO : No Query available.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('js')
  <script>
      $('.query-table').DataTable();
  </script>
@endpush

