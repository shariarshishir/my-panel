@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <section class="content order-details-block">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Details</h3>
                </div>
                <div class="row order-top-block">
                    <div class="col-md-6">
                        <p>Date: {{ \Carbon\Carbon::parse($collection->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</p>
                        <p>Status:
                            @include('admin.query._partial_status')
                        </p>
                    </div>
                    {{-- @if($vendorOrder->state=='pending')
                        <div class="col-md-4 order-proceed-btn">
                            <a href="{{ route('order.updateby.admin',$vendorOrder->id) }}" class="btn btn-success">Proceed</a>
                        </div>
                    @endif --}}

                </div>
                <div class="row order-address-block">
                    <div class="billing-address-block col-md-6">
                        <h4><i class="fas fa-address-card"></i> Buyer Info</h4>
                        <p>{{$collection->user->name}}</p>
                        <p>{{$collection->user->email}}</p>
                        <p>{{$collection->user->phone}}</p>
                        {{-- <p>{{$collection->user->vendor->vendor_address}}</p> --}}
                    </div>
                    <div class="shipping-address-block col-md-6">
                        <h4><i class="fas fa-briefcase"></i> Vendor Info</h4>
                        <p>{{$collection->businessProfile->user->name}}</p>
                        <p>{{$collection->businessProfile->user->email}}</p>
                        <p>{{$collection->businessProfile->user->phone}}</p>
                        <p>{{$collection->businessProfile->location}}</p>
                    </div>
                </div>

                <div class="border-separator"></div>
                <div class="row product-details-table-block ">
                    <div class="col s12">
                        @if($collection->type == config('constants.order_query_type.order_query'))
                            @if($collection->orderModification)
                                @include('admin.query._update_form')
                            @else
                                @include('admin.query._create_form')
                            @endif
                        @endif
                        @if($collection->type == config('constants.order_query_type.order_query_with_modification'))
                            @if($collection->orderModification)
                                @include('admin.query._update_query_modification_form')
                            @else
                                @include('admin.query._create_query_modification_form')
                            @endif
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
<script>

    function calcualteTotalQuantity()
      {
            var total=0;
            $('table tr').each(function(){
                var inputs = $(this).find('input').not(':first');
                inputs.each(function(){
                total+=Number($(this).val()) || 0; // parse and add value, if NaN then add 0
                });
            });
            $('#total-quantity').val(total);
      }

      function calculateTotalPrice()
      {
        var unit_price= $('#unit-price').val();
        var total_quantity= $('#total-quantity').val();
        var total_price = unit_price*total_quantity;
        $('#total-price').val(parseFloat(total_price).toFixed(2));

      }
      $(document).on('keyup','table tr',function(){
        calcualteTotalQuantity();
        calculateTotalPrice();
        var type_val= $("#discount-type option:selected" ).attr('value');
        var get_discount= $('#discount').val();
        if(type_val != null && get_discount != 0){
            // alert('works');
            calculateDiscount();
        }

      });
      $(document).on('keyup', '#unit-price', function(){
        calculateTotalPrice();
        var type_val= $("#discount-type option:selected" ).attr('value');
        var get_discount= $('#discount').val();
        if(type_val != null && get_discount != 0){
            calculateDiscount();
        }
      });

      $(document).on('keyup', '#discount', function(){
        calculateDiscount();
      });

      $("select#discount-type").change(function(){
        calculateDiscount();
    });


    function  calculateDiscount()
    {
        var type_val= $("#discount-type option:selected" ).attr('value');
        //var check_type= $("#discount-type" ).is(':selected');
        var get_discount= $('#discount').val();
        var unit_price= $('#unit-price').val();
        var total_quantity= $('#total-quantity').val();
        var get_total_price = unit_price*total_quantity;
        if(!type_val){
            alert('Please select discount type');
            return false;
        }
        if(get_total_price == 0){
            alert('Empty Total Price');
            return false;
        }
        if(get_discount == 0){
            $('#discount-amount').val('');
            $('#total-price').val(parseFloat(get_total_price).toFixed(2));
            alert('Empty Discount Value');
            return false;
        }
        // check type 1 is amount 2 is persentence
        if(type_val==1){
           var total_price= get_total_price - get_discount;
           var discount = get_discount;
        }
        if(type_val==2){
            var persentence= get_discount/100;
            var discount=get_total_price*persentence;
            var total_price= get_total_price - discount;

        }

        $('#discount-amount').val(parseFloat(discount).toFixed(2))
        $('#total-price').val(parseFloat(total_price).toFixed(2));
    }

    function addColorSize()
    {
        let totalChild = $('.color-size-table-block tbody').children().length;
        var html = '<tr>';
        html += '<td data-title="Color"><input type="text" value="" class="form-control" name="color_size[color][]" /></td>';
        html += '<td data-title="XXS"><input type="text" value="0" class="form-control " name="color_size[xxs][]" /></td>';
        html += '<td data-title="XS"><input type="text" value="0" class="form-control " name="color_size[xs][]" /></td>';
        html += '<td data-title="Small"><input type="text" value="0" class="form-control " name="color_size[small][]" /></td>';
        html += '<td data-title="Medium"><input type="text" value="0" class="form-control " name="color_size[medium][]" /></td>';
        html += '<td data-title="Large"><input type="text" value="0" class="form-control " name="color_size[large][]" /></td>';
        html += '<td data-title="Extra Large"><input type="text" value="0" class="form-control " name="color_size[extra_large][]" /></td>';
        html += '<td data-title="XXL"><input type="text" value="0" class="form-control " name="color_size[xxl][]" /></td>';
        html += '<td data-title="XXXL"><input type="text" value="0" class="form-control " name="color_size[xxxl][]" /></td>';
        html += '<td data-title="4XXL"><input type="text" value="0" class="form-control " name="color_size[four_xxl][]" /></td>';
        html += '<td data-title="One Size"><input type="text" value="0" class="form-control " name="color_size[one_size][]" /></td>';
        html += '<td><a href="javascript:void(0);" class="btn waves-effect waves-light red remove-color-size-block" onclick="removeProductColorSize(this)"><i class="fas fa-minus-circle">Remove</i></a></td>';
        html += '</tr>';
        $('.color-size-table-block tbody').append(html);
    }
    function removeProductColorSize(el)
    {
        $(el).parent().parent().remove();

    }

    $(document).on('change', '.price-value', function(){
        var num = $(this).val();
        value = parseFloat(num).toFixed(2);
        $(this).val(value);
    })
    //remove-color-size-block
    $(document).on('click', '.remove-color-size-block', function(){
        calcualteTotalQuantity();
        calculateTotalPrice();
        var type_val= $("#discount-type option:selected" ).attr('value');
        var get_discount= $('#discount').val();
        if(type_val != null && get_discount != 0){
            // alert('works');
            calculateDiscount();
        }
    });
</script>
@endpush


