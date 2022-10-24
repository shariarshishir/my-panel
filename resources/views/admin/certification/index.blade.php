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
              <li class="breadcrumb-item active">Certification</li>
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
                <div class="row" style="padding-bottom: 20px;">
                    <div class="col-lg-12">
                        <a href="{{route('admin.certification.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New</a>
                    </div>
                </div>
                @include('include.admin._message')
                <div class="card">
                    <legend>Certification List</legend>
                    <div class="no_more_tables">
                      <table class="table table-bordered certification_table">
                          <thead class="cf">
                              <tr>
                                  <th>ID</th>
                                  <th>Certification programs</th>
                                  <th>Provider</th>
                                  <th>Nation</th>
                                  <th>About</th>
                                  <th>Logo</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($collection as $list)
                                  <tr>
                                      <td data-title="ID">{{$list->id}}</td>
                                      <td data-title="Certification programs">{{$list->certification_programs}}</td>
                                      <td data-title="Provider">{{$list->provider}}</td>
                                      <td data-title="Nation">{{$list->nation}}</td>
                                      <td data-title="About">{{$list->about}}</td>
                                      <td data-title="Logo"><img src="{{asset('storage/'.$list->logo)}}" alt="logo"></td>
                                      <td data-title="Action"><a href="{{route('admin.certification.edit', $list->id)}}">Edit</a></td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                    </div>
                    
                </div>
                <div>
                    {{ $collection->links() }}
                </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


@endsection


