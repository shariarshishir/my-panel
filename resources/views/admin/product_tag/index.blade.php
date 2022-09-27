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
              <li class="breadcrumb-item active">Product Tag</li>
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
					<a href="{{route('admin.product-tag.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New</a>
				</div>
			</div>
            <div class="card admin_categories_list">
				<legend>List</legend>

				<div class="no_more_tables">
					<table class="table table-bordered" id="datatable-product-tag">
						<thead class="cf">
						<tr>
							<th>Tag Name</th>
                            <th>Tag Factory Types</th>
							<th class="text-center" style="display: none;">Action</th>
						</tr>
						</thead>
						<tbody>

							@foreach($product_tag as $item)
								<tr>
									<td data-title="Product Tag">
										<a href="{{ route('admin.product-tag.edit', $item->id) }}">{{$item->name}}</a>
									</td>
                                    <td>@if($item->tagMapping) @foreach ($item->tagMapping as $tag){{$tag->name}} @if(!$loop->last) , @endif @endforeach @endif</td>
									<td data-title="Action" class="text-center" style="display: none;">
										<form action="{{ route('admin.product-tag.destroy', $item->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('are you sure?');">
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

@push('js')
<script>
    $('#datatable-product-tag').DataTable();
</script>
@endpush


