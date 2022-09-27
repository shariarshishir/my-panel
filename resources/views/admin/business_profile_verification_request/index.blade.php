@extends('layouts.admin')
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
              <li class="breadcrumb-item active">Business Profile Verification</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 certification_list_wrap">
                @include('include.admin._message')
                <div class="card">
                    <legend>Request List</legend>
                    <div class="no_more_tables">
                      <table class="table table-bordered certification_table">
                          <thead class="cf">
                              <tr>
                                  <th>ID</th>
                                  <th>Business Profile Name</th>
                                  <th>Created At</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($businessProfileVerificationsRequest as $list)
                                  <tr>
                                      <td data-title="ID">{{$list->id}}</td>
                                      <td data-title="Business Profile Name">
                                        <a href="{{Route('business.profile.details', $list->business_profile_id)}}">{{$list->business_profile_name}}</a>
                                      </td>
                                      <td data-title="created_at">{{$list->created_at}}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                    </div>
                    
                </div>
                <div>
                    {{ $businessProfileVerificationsRequest->links() }}
                </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


@endsection


