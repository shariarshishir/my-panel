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
              <li class="breadcrumb-item active">Vendors </li>
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
				      <legend>Vendor List</legend>

              <div class="no_more_tables">
                @if(count($users)>0)
                  <table class="table table-bordered">
                      <thead class="cf">
                              <tr>
                                <th>Business Name </th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>&nbsp;</th>
                              </tr>
                      </thead>
                      <tbody>

                          @foreach($users as $user)
                          <tr>

                              <td data-title="Business Name" class="center">
                                  <a href="{{route('vendor.show',$user->vendor->id)}}">{{$user->vendor->vendor_name}}</a>
                              </td>
                              <td data-title="User Name">
                                  {{$user->name}}
                              </td>

                              <td data-title="Email" class="center">
                                  {{$user->email}}
                              </td>

                              <td data-title="Address">
                                  {{$user->vendor->vendor_address}}
                              </td>

                              <td data-title="Action">
                                <form action="{{ route('vendor.destroy', $user->vendor->id) }}" method="POST" onsubmit="return confirm('Are You Confirm ?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-eye-slash"></i>
                                  </button>
                                </form>
                              </td>

                          </tr>
                          @endforeach

                      </tbody>
                  </table>
                  @else
                  <div class="alert alert-info" role="alert">INFO : No vendors available.</div>
                  @endif
              </div>
                

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>



@endsection
