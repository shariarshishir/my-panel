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
                    <div class="card admin_categories_list">
                        <legend>Newsletter - {{$newsletter->title}}</legend>
                        <div style="text-align: right;">
                            <a href="{{route('newsletter.edit',$newsletter->id)}}" class="btn btn-primary">Edit</a>
                            <button class="btn btn-primary copy_pdf" data-clipboard-action="copy" data-clipboard-target="#pdf_path_to_copy" data-toggle="tooltip" data-placement="top" title="Click here to copy PDF link">Copy PDF link</button>
                            <input id="pdf_path_to_copy" type="hidden" value="{{Storage::disk('s3')->url('public/'.$newsletter->pdf_path)}}" />
                        </div>
                        <div class="card-body">
                            <div class="admin_newsletter_form">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12" >
                                        <div class="form-group">
                                            <b>Title:</b> {{$newsletter->title}}
                                        </div>
                                        <div class="form-group">
                                            <b>Description:</b> {{$newsletter->description}}
                                        </div>
                                        <div class="form-group">
                                            <b>PDF File:</b>
                                            <iframe src="{{Storage::disk('s3')->url('public/'.$newsletter->pdf_path)}}" id="iframe_content" width="100%" height="800" style="border:none;"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script>
    var clipboard = new ClipboardJS('.copy_pdf');
    clipboard.on('success', function(e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        alert("copied successfully.");
        e.clearSelection();
    });
    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
</script>
@endsection
