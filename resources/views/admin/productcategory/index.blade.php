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
					<a href="{{route('product-categories.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New product Category</a>
				</div>
			</div>
            <div class="card admin_categories_list">
				<legend>Categories List</legend>

				<div class="no_more_tables">
					<table class="table table-bordered">
						<thead class="cf">
						<tr>
							<th>Image</th>
							<th>Product Category Name</th>
							<th>Status</th>
							<th class="text-center" style="display: none;">Action</th>
						</tr>
						</thead>
						<tbody>

							@foreach($outArray as $categoryitem)
								<tr>
									<td data-title="Image">
										@if(isset($categoryitem->image))
										<img id="preview-image" src="{{asset('storage/'.$categoryitem['image'])}}"
											alt="preview image">
										@else
										<img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
											alt="preview image">
										@endif
									</td>
									<td data-title="Product Category">
										<a href="{{ route('product-categories.edit', $categoryitem['id']) }}">{{$categoryitem['name']}}</a>
									</td>
									<td data-title="Status" class="center">
										@if($categoryitem['status']==1)
											<span class="badge badge-success">Published </span>
										@else
											<span class="badge badge-danger">Unpublished</span>
										@endif
									</td>
									<td data-title="Action" class="text-center" style="display: none;">
										<form action="{{ route('product-categories.destroy', $categoryitem['id']) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger btn-sm">
												<i class="fas fa-trash"></i>
											</button>
										</form>
									</td>
								</tr>
								@if(!empty($categoryitem['children'])) <!-- 1st sub level -->
									@foreach($categoryitem['children'] as $childcategoryitem)
									<tr>
										<td data-title="Image">
										@if(isset($childcategoryitem->image))
										<img id="preview-image" src="{{asset('storage/'.$childcategoryitem['image'])}}"
											alt="preview image">
										@else
										<img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
											alt="preview image" >
										@endif
										</td>
										<td data-title="Product Category" class="sub-cat-item">
											<a href="{{ route('product-categories.edit', $childcategoryitem['id']) }}">- {{$childcategoryitem['name']}}</a>
										</td>
										<td class="center" data-title="Status">
											@if($childcategoryitem['status']==1)
												<span class="badge badge-success">Published </span>
											@else
												<span class="badge badge-danger">Unpublished</span>
											@endif
										</td>
										<td data-title="Action" class="text-center" style="display: none;">
											<form action="{{ route('product-categories.destroy', $childcategoryitem['id']) }}" method="POST">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger btn-sm">
													<i class="fas fa-trash"></i>
												</button>
											</form>
										</td>
									</tr>
										@if(!empty($childcategoryitem['children'])) <!-- 2nd sub level -->
											@foreach($childcategoryitem['children'] as $subchildcategoryitem)
											<tr>
												<td data-title="ID" class="second-sub-cat-item">
													<a href="{{ route('product-categories.edit', $subchildcategoryitem['id']) }}">-- {{$subchildcategoryitem['name']}}</a>
												</td>
												<td data-title="Status" class="center">
													@if($subchildcategoryitem['status']==1)
														<span class="badge badge-success">Published </span>
													@else
														<span class="badge badge-danger">Unpublished</span>
													@endif
												</td>
												<td data-title="Action" class="text-center" style="display: none;">
													<form action="{{ route('product-categories.destroy', $subchildcategoryitem['id']) }}" method="POST">
														@csrf
														@method('DELETE')
														<button type="submit" class="btn btn-danger btn-sm">
															<i class="fas fa-trash"></i>
														</button>
													</form>
												</td>
											</tr>
											@endforeach
										@endif
									@endforeach
								@endif
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


