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
                        <li class="breadcrumb-item active">New User Requests </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row admin_order_list_table_wrap">
                <div class="col-md-12">
                    <div class="card">
                        <legend>{{ucfirst($type)}} Requests</legend>
                        <div class="no_more_tables">
                            <table class="table table-bordered orders-table data-table">
                                <thead class="cf">
                                    <tr>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Company Name</th>
                                        <th>Email Address</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                        <th>Created At</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                            </table>
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
       $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            order: [['4', 'desc']],
            ajax: "{{ route('new.user.request',$type) }}",
            columns: [
                // {data:'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'name'},
                {data: 'country', name: 'country'},
                {data: 'company_name', name: 'company_name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action'},
                {data: 'created_at', name:'created_at'},
                {data: 'edit', name: 'edit',  orderable: false, searchable: false},
            ]
        });
    });
  </script>
@endpush



