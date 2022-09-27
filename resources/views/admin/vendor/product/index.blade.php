@extends('layouts.vendor')
@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	  	<div class="row" style="padding-bottom: 20px;">
			<div class="col-lg-12">
				<a href="{{route('product.create',$vendorId)}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New product</a>
			</div>
		</div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
				<legend>Products List</legend>
                 @if(count($products)>0)
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Product sku </th>
                      <th>Status</th>
                      <th>Parent</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>

                    @foreach($products as $product)
                        <tr>

                        <td>
                            <a href="{{route('product.edit',['vendor'=>$vendorId,'product'=>$product->sku])}}">{{$product->name}}</a>
                        </td>
                        <td>{{$product->sku}}</td>
                        <td class="center">
                                @if($product->state==1)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-danger">Unpublished</span>
                                @endif
                        </td>
                        <td class="center">
                                @if($product->is_fatured==1)
                                    <span class="badge badge-success">Yes </span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                        </td>
                        <td>
                            <form action="{{route('product.destroy',['vendor'=>$vendorId,'product'=>$product->sku])}}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                  </tbody>
                </table>

                @else
                <div class="alert alert-info alert-dismissible">
                  INFO : No products available.
                </div>
                @endif

            </div>
          </div>
        </div>
      </div>
    </section>
</div>

@endsection


