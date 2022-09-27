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
                        <li class="breadcrumb-item active">Payment Term</li>
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
                    <div class="row" style="padding-bottom: 20px;">
                        <div class="col-lg-12">
                            <a href="{{route('payment-term.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New</a>
                        </div>
                    </div>
                    @include('include.admin._message')

                    <div class="card">
                        <legend>Payment Terms List</legend>

                        <div class="no_more_tables">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($collection as $list)
                                    <tr>
                                            <td data-title="Name">
                                                <a href="{{ route('payment-term.edit', $list->id) }}">{{$list->name}}</a>
                                            </td>
                                            <td data-title="Description">
                                                {{$list->description}}
                                            </td>
                                            <td data-title="Action" class="text-center">
                                                <form action="{{ route('payment-term.destroy', $list->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure');">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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


