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
              <li class="breadcrumb-item active">Categories</li>
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
					<a href="{{route('blogs.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Blog</a>
				</div>
			</div>
            <div class="card admin_categories_list">
				        <legend>Categories List</legend>
                <div class="no_more_tables">
                  <table id="" class="table table-striped table-bordered table-hover blog_list_table" width="100%">
                      <thead class="cf">
                          <tr>
                              <th data-hide="phone" class="text-center">ID</th>
                              <th data-class="expand" class="text-center"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Title</th>
                              <th data-hide="phone, tablet" class="text-center"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Feature image</th>
                              <th data-hide="phone, tablet" class="text-center"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Created by</th>
                              <th class="text-center"><i class="fa fa-fw fa-calendar text-blue hidden-md hidden-sm hidden-xs"></i> Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($blogs as $index=>$blog)
                          <tr class="text-center">
                              <td data-title="ID">{{ $index+1 }}</td>
                              <td data-title="Title">{{ $blog->title }}</td>
                              <td data-title="Feature image"><img class="img-fluid" src="{{Storage::disk('s3')->url('public/'.$blog->feature_image)}}"></td>
                              <td data-title="Created by">{{ $blog->created_user['name'] }}</td>
                              <td data-title="Action" class="text-center"> 
                                  <a class="btn btn-success btn-xs" href="{{route('blogs.edit',$blog->id)}}">Edit</a>
                                  <form action="{{route('blogs.destroy',$blog->id)}}" method="post" style="display: inline">
                                      @csrf
                                      @method('DELETE')
                                      <button class="btn btn-danger btn-xs" name="remove_item" type="submit">Delete</button>
                                  </form>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
                
                <div class="pagination">
                    {{ $blogs->links() }}
                </div>


           </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


@endsection


