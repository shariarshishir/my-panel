@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-12">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="card">
				<legend>Shop configuration</legend>
                <form method="POST" action="{{route('update.configuration',$config->id)}}" id="shop_config_form">
                    @method('patch')
                   @include('admin.config.form')
                    <button type="submit" class="btn btn-success save_config">Save</button>
                </form>
			</div>
		</section>
		<!-- /.content -->
	</div>
@endsection
