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
                    <div class="col-md-6">
                    <legend>New User Requests</legend>
                        <p>User type: {{$user->is_supplier == true ? "Supplier" : "Buyer"}}</p>
                        <p>From : {{$user->countryName ? $user->countryName->name : ''}}</p>
                        <p>Email : {{$user->email}}</p>
                        <p>Phone: {{$user->phone}}</p>
                        <p>Company name: {{$user->company_name}}</p>
                    </div>

                    <div class="col-md-6">
                        <form method="post" action="{{route('new.user.request.update',$user->id)}}">
                            @method('put')
                            @csrf
                            <button type="submit" class="btn  btn-sm {{$user->is_email_verified== false ? 'btn-success' : 'btn-danger'}}" onclick="return confirm('are you sure?');">{{$user->is_email_verified== false ? 'Active' : 'Inactive'}}</button>
                        </form>
                    </div>
            </div>

        </div>
    </section>
</div>

@endsection
@push('js')

@endpush



