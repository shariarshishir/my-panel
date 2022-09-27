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
              <li class="breadcrumb-item active">Product Type Mapping</li>
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
					<a href="{{route('admin.product-type-mapping.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New</a>
				</div>
			</div>
            <div class="card admin_categories_list">
				<legend>List</legend>

				<div class="no_more_tables">
					<table class="table table-bordered">
						<thead class="cf">
						<tr>
							<th>Title</th>
							<th class="text-center" style="display: none;">Action</th>
						</tr>
						</thead>
						<tbody>

							@foreach($outArray as $categoryitem)
								<tr>
									<td data-title="Product Category">
										<a href="{{ route('admin.product-type-mapping.edit', $categoryitem['id']) }}">{{$categoryitem['title']}}</a>
									</td>
                                    <td data-title="Action" class="text-center" style="display: none;">
                                        <form action="{{ route('admin.product-type-mapping.destroy', $categoryitem['id']) }}" method="POST">
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
										<td data-title="Product Category" class="sub-cat-item">
											<a href="{{ route('admin.product-type-mapping.edit', $childcategoryitem['id']) }}">- {{$childcategoryitem['title']}}</a>
										</td>
										<td data-title="Action" class="text-center" style="display: none;">
											<form action="{{ route('admin.product-type-mapping.destroy', $childcategoryitem['id']) }}" method="POST">
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
													<a href="{{ route('admin.product-type-mapping.edit', $subchildcategoryitem['id']) }}">-- {{$subchildcategoryitem['title']}}</a>
												</td>

												<td data-title="Action" class="text-center" style="display: none;">
													<form action="{{ route('admin.product-type-mapping.destroy', $subchildcategoryitem['id']) }}" method="POST">
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


