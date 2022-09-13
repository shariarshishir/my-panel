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
              <li class="breadcrumb-item active">User </li>
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
				        <legend>User Info</legend>
                        <div class="col-md-6">
                            <p>Name: {{$user->name}}</p>
                            <p>Email: {{$user->email}}</p>
                            <p>Phone: {{$user->phone}}</p>
                            <p>Company Name: {{$user->company_name ?? ''}}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card user_list_wrapper">
				        <legend>Business Lists</legend>
                            @if($user->businessProfileWithTrashed()->exists())
                                <div class="row">
                                    @foreach ($user->businessProfileWithTrashed as $profile )
                                        <div class="col-sm-12 col-md-4 col-md-4 user_list_itembox">
                                            <div class="item_list_box">
                                                <p>Business Type :
                                                    @switch($profile->business_type)
                                                        @case(1)
                                                            Manufacturer
                                                            @break
                                                        @case(2)
                                                            Wholesaler
                                                            @break
                                                        @case(3)
                                                            Design Studio
                                                            @break
                                                        @default
                                                    @endswitch
                                                </p>
                                                <p>Business Name: {{$profile->business_name}}</p>
                                                <p>location: {{$profile->location}}</p>
                                                <p>Has Representative: {{$profile->has_representative == true ? 'Yes' : 'No'}}</p>
                                                @if($profile->business_type == 1)
                                                    <p>Number Of Factories : {{$profile->number_of_factories}}</p>
                                                @elseif($profile->business_type == 2)
                                                    <p>Number Of Outlets : {{$profile->number_of_outlets}}</p>
                                                @endif

                                                <div class="enable_disable_label">
                                                    @if($profile->deleted_at)
                                                        <a href="{{route('admin.business.profile.restore', $profile->id)}}" onclick="return confirm('Are you sure?');">Active</a>
                                                    @else
                                                        <a href="{{route('admin.business.profile.delete', $profile->id)}}" onclick="return confirm('Are you sure?');">Inactive</a>
                                                    @endif
                                                </div>
                                                <a class="view_details" href="{{Route('business.profile.details', $profile->id)}}">View Details</a>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                    @endforeach

                                </div>

                            @else
                                <div class="alert alert-info" role="alert">INFO : No business available.</div>
                            @endif
                    </div>
                </div>
            </div>
      </div>
    </section>
</div>

@endsection
