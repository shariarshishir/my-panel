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
              <li class="breadcrumb-item active">Users </li>
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
				    <legend>Users List</legend>
                <div class="no_more_tables">
                      <table class="table table-bordered users-table data-table" >
                          <thead class="cf">
                                  <tr>
                                      <th>User Name</th>
                                      <th>Email</th>
                                      <th>Created Date</th>
                                  </tr>
                          </thead>
                      </table>
                </div>

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
            ajax: "{{ route('users.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
            ]
        });


    });
  </script>
@endpush
