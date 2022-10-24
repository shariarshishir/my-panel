@extends('layouts.admin')
@section('content')
@php
    $divStyle = 'none';
    $product_category_request = array_key_exists('product_category', app('request')->input())?app('request')->input('product_category'): '';
    $factory_category_request = array_key_exists('factory_category', app('request')->input())?app('request')->input('factory_category'): '';
    $status = array_key_exists('status', app('request')->input())?app('request')->input('status'): '';
    $business_profile_request = array_key_exists('business_profile', app('request')->input())?app('request')->input('business_profile'): '';
    $priority= array_key_exists('priority', app('request')->input())?app('request')->input('priority'): '';
    $product_name = array_key_exists('product_name', app('request')->input())?app('request')->input('product_name'): '';
    $date = array_key_exists('datefilter', app('request')->input())?app('request')->input('datefilter'): '';
@endphp


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="admin_products_list_wrap">
        <legend>Products</legend>
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="products_list_filterBox">
                        <legend>
                            <span class="title">All products list </span>
                            <div class="filter_wrap">
                                @if($product_category_request || $factory_category_request || $status || $business_profile_request || $priority || $product_name || $date )
                                @php $divStyle = 'block'; @endphp
                                <div class="filter_by">
                                    <a href="{{route('admin.products.index')}}" class="reset_product_filter_trigger">
                                        <i class="fas fa-solid fa-spinner"></i>
                                        <span>Reset All</span>
                                    </a>
                                </div>
                                @endif
                                <div class="filter_by">
                                    <button class="product_filter_button">
                                        <i class="fas fa-solid fa-filter"></i>
                                        <span>Filter By</span>
                                    </button>
                                </div>
                               
                            </div>
                        </legend>
                        <form action="{{route('admin.products.index')}}" method="GET" class="product_filter_list" id="product_filter_form" style="display: {{$divStyle}};">
                            <div class="filter">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-select form-control" name="product_category" id="product_category" >
                                                <option value="" selected>Product Category</option>
                                                @foreach ($product_category as $pro_cat)
                                                    <option value="{{$pro_cat->id}}" {{$pro_cat->id == $product_category_request ? 'selected' : '' }}>{{$pro_cat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="clearfix"></div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-select form-control" name="factory_category" id="factory_category">
                                                <option value="">Factory Category</option>
                                                @foreach ($factory_category as $factory_cat)
                                                    <option value="{{$factory_cat->id}}" {{$factory_cat->id == $factory_category_request ? 'selected' : '' }}>{{$factory_cat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="clearfix"></div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-select form-control" name="status" id="status">
                                                <option value="">Status</option>
                                                <option value="1" {{$status == 1 ? 'selected' : ''}}>Published </option>
                                                <option value="0" {{isset($status) && $status == 0 ? 'selected' : ''}}>Unpublished</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="clearfix"></div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="datefilter" value="{{$date}}" placeholder="Uploaded Date between"/>
                                        </div>
                                    </div>
                                    <!-- <div class="clearfix"></div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-select form-control" name="business_profile" id="business_profile">
                                                <option value="">Business Profile</option>
                                                @foreach ($business_profile as  $key => $profile)
                                                    <option value="{{$key}}" {{$key == $business_profile_request ? 'selected' : ''}}>{{$profile}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="clearfix"></div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-select form-control" name="priority" id="priority">
                                                <option value="">Priority</option>
                                                <option value="1" {{$priority == 1 ? 'selected' : ''}}>High</option>
                                                <option value="2" {{$priority == 2 ? 'selected' : ''}}>Medium</option>
                                                <option value="3" {{$priority == 3 ? 'selected' : ''}}>Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="product_search">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" name="product_name" placeholder="enter product name" value="{{$product_name}}">
                                                <button class="btn_green" type="submit" onclick="this.form.submit();">search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{route('admin.products.index')}}" class="btn_green">Reset</a>
                        </form>
                    </div>
                        

                    @if(count($products)>0)
                    <div class="no_more_tables">
                        <table class="table table-bordered users-table data-table" >
                            <thead class="cf">
                                    <tr>
                                        <th>Products Name</th>
                                        <th>Business Name</th>
                                        <th>Category</th>
                                        <th>Uploaded Date</th>
                                        <th>Details</th>
                                    </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $list)
                                    <tr>
                                        <td data-title="Products Name">{{$list->flag == 'shop' ? $list->name : $list->title}}</td>
                                        <td data-title="Business Name">{{$list->businessProfile->business_name}}</td>
                                        <td data-title="Category">{{$list->category? $list->category->name : ''}}</td>
                                        <td data-title="Uploaded Date">{{\Carbon\Carbon::parse($list->created_at)->isoFormat('MMMM Do YYYY')}}</td>
                                        <td data-title="Details"><a href="{{route('admin.products.show', ['flag' => $list->flag, 'id' => $list->id])}}">Details</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else
                        <div class="alert alert-info alert-dismissible">
                            INFO : No products available.
                        </div>
                    @endif
                    Showing {{($products->currentpage()-1)*$products->perpage()+1}} to {{$products->currentpage()*$products->perpage()}} of  {{$products->total()}} results
                    {{ $products->appends(request()->query())->links() }}
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>
    </div>
    
</div>

@endsection

@push('js')
  <script>
      $(document).on('change', '#product_category, #factory_category, #status, #business_profile, #priority', function(){
                this.form.submit();
      });


    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            $('#product_filter_form').submit()
        });
        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        

    });


    $(".product_filter_button").click(function(){
        $(".product_filter_list").toggle();
    });




  </script>
@endpush

