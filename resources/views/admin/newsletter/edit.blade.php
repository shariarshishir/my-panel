@extends('layouts.admin')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Newsletter</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('newsletter.update',$newsletter->id) }}" method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('admin.newsletter.form')
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $(".upload_trigger").click(function(){
            $("#pdf_path").click();
        })

        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $(e.target).parent('div').find('.form-file-text').html(fileName)
            $(".iframe_priview").hide();
            // Inside find search element where the name should display (by Id Or Class)
        });
    })
</script>
@endsection
