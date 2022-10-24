@extends('layouts.admin')
@section('content')

<!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Newsletters</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="padding-bottom: 20px;">
                        <div class="col-lg-12">
                            <a href="{{route('newsletter.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add Newsletter</a>
                        </div>
                    </div>
                    <div class="card admin_categories_list">
                        <legend>Newsletter List</legend>
                        @if(count($newsletters) > 0)
                            <div class="no_more_tables">
                                <table id="" class="table table-striped table-bordered table-hover blog_list_table" width="100%">
                                    <thead class="cf">
                                        <tr>
                                            <th data-hide="ID">ID</th>
                                            <th data-class="Title">Title</th>
                                            <th data-class="View Details">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($newsletters as $index => $newsletter)
                                        <tr class="text-center">
                                            <td data-title="ID">{{ $index + 1 }}</td>
                                            <td data-title="Title">
                                                <a href="{{route('newsletter.edit',$newsletter->id)}}">
                                                {{ $newsletter->title }}
                                                </a>
                                            </td>
                                            <td data-title="View Details">
                                                <a href="{{route('admin.newsletter.show',$newsletter->id)}}" class="btn btn-primary">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination">

                            </div>
                        @else
                            No Data found.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection


