@extends('layouts.app')
@section('content')
@include('sweet::alert')
<section class="content cart_content_wrap main_content_wrapper">
    <div class="container-fluid">
       @if(count($addToCartItems) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card card-with-padding">
                    <legend>Cart List</legend>

                    <div class="cart-wrapper">
                        <div class="no_more_tables">
                            @foreach($addToCartItems as $key=>$itemByVendorId)
                            <table class="shop_table shop_table_responsive cart_table striped">
                                <thead class="cf">
                                    <tr>
                                        <th class="product-thumbnail">Product Image</th>
                                        <th class="product-name">Product Name</th>
                                        <th class="product-name">Business Name</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Subtotal</th>
                                        <th class="product-remove">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($itemByVendorId as $item)
                                        @csrf
                                        <tr class="cart_item" data-vendorId="{{$item->business_profile_id}}">

                                            <td data-title="Product Image" class="product-thumbnail" style="width: 140px;">
                                                <a href="#"><img height="80px"  width="80px" src="{{URL::asset('storage/'.$item->image)}}" class="" alt="" loading="lazy"/></a>
                                            </td>

                                            <td data-title="Product Name" class="product-name" data-title="Product" style="width: 250px;">
                                                <div style="color: #4CAF50;">{{$item->name}}</div>
                                                @if($item->full_stock==1)
                                                <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label">Full Stock</span>
                                                @elseif(isset($item->order_modification_req_id))
                                                <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label">Modified</span>
                                                @endif
                                                @if($item->deleted_at)
                                                    <span class="badge badge pill red accent-2 mr-2 ready-to-ship-label">Product not available</span>
                                                @endif
                                            </td>
                                            <td data-title="Business Name" class="product-name" data-title="Product" style="width: 160px;">
                                                @php  $business_profile= businessProfileInfo($item->business_profile_id); @endphp
                                                <div style="color: #4CAF50;">{{ $business_profile->business_name }}</div>
                                            </td>

                                            <td data-title="Price" class="product-price" data-title="Price" style="width: 100px; ">
                                                <span class="price-currencySymbol">${{ number_format($item->unit_price, 2) }}</span>
                                            </td>

                                            <td data-title="Quantity" class="product-quantity" data-title="Quantity" style="width:450px;">
                                                <div class="quantity">
                                                    <label class="screen-reader-text" for="quantity_609789500c73f">&nbsp;</label>
                                                    <input type="number" id="quantity" class="input-text qty text" step="1" min="0" max="" name="cart_quantity" value="{{$item->quantity}}" title="Qty" size="4" placeholder="" inputmode="numeric" disabled="disabled" />
                                                    @if($item->full_stock==1 || isset($item->order_modification_req_id) )
                                                    {{-- <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label">Full Stock</span> --}}
                                                    {{-- @elseif(isset($item->order_modification_req_id)) --}}
                                                    {{-- <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label">Modified</span> --}}
                                                    @else
                                                        @if(!$item->deleted_at)
                                                            <a class="waves-effect waves-light cart_item_edit" href="javascript:void(0);" id="{{$item->id}}">Edit Item</a>
                                                        @endif
                                                    @endif
                                                    @if($item->product_type==1)
                                                        {{-- <a href="javascript:void(0);" class="edit_fresh_order_item">Edit Item</a>
                                                        <a href="javascript:void(0);" class="cancel_edit_fresh_order_item" style="display: none;">Cancel</a> --}}
                                                        <div class="fresh_stock_block_wrapper">
                                                            <button type="submit" id="updateCartItem_freshorder" class="btn waves-effect waves-light green" style="display: none;">Update</button>
                                                                @if($item->copyright_price && !isset($item->order_modification_req_id) )
                                                                    @if(!in_array($item->product_sku,$orderedItem))
                                                                        {{-- <label class="tooltipped copyright-checkbox" data-position="top" data-tooltip="Copyright price is {{ $item->copyright_price }}. Please check this box if you want to buy the copyright<br /> of this product. This price will add to your total price of this product."> --}}
                                                                            {{-- <input name="copyright_price" type="checkbox" cartrowid="{{ $item->id }}" @if($item->copyright==true) checked @endif/> --}}
                                                                            <div class="switch">
                                                                                <label>
                                                                                    <span class="tooltipped" data-position="top"  data-tooltip="If you buy with copyright,no one will be able to buy it.Copyright price is {{ $item->copyright_price }}. <br> This price will add to your total price of this product."><i class="material-icons dp48">live_help</i></span>
                                                                                    <input type="checkbox" name="copyright_price" cartrowid="{{ $item->id }}"  @if($item->copyright==true) checked @endif/>
                                                                                    {{ __('Want to buy with copyright?') }}
                                                                                    <span class="lever"></span>
                                                                                </label>
                                                                            </div>
                                                                            {{-- <span>{{ __('Want to buy with copyright?') }}</span> --}}
                                                                            {{-- <span class="tooltipped" data-position="top"  data-tooltip="If you buy with copyright,no one will be able to buy it.Copyright price is {{ $item->copyright_price }}. <br> This price will add to your total price of this product."><i class="material-icons dp48">live_help</i></span> --}}
                                                                        {{-- </label> --}}
                                                                    @endif

                                                                @endif
                                                        </div>
                                                    @endif


                                                </div>
                                            </td>

                                            <td data-title="Subtotal" class="product-subtotal" data-title="Subtotal" style="width: 100px;">
                                                <span class="price-amount">
                                                    <bdi><span class="price-currencySymbol">${{ number_format($item->total_price, 2) }}</span>
                                                        @if (isset($item->discount_amount))
                                                            <span class="tooltipped" data-position="top" data-tooltip="Discount Amount {{ $item->discount_amount }}"><i class="material-icons dp48">live_help</i></span>
                                                    @endif
                                                    </bdi>
                                                </span>
                                            </td>
                                            <td data-title="Action" class="product-remove" style="width: 100px;">
                                                <a href="{{route('cart.delete',$item->id)}}" class="btn_delete" aria-label="Remove this item" data-cartRowId="{{$item->id}}" data-product_sku="{{$item->product_sku}}"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a>
                                            </td>
                                        </tr>
                                        {{-- <input type="hidden" name="rowId" value="{{$item->cart_row_id}}" >
                                        <input type="hidden" name="product_type" value="{{ $item->product_type }}" /> --}}
                                    </form>
                                @endforeach
                                </tbody>
                            </table>
                            @endforeach
                        </div>

                        <div class="cart-collaterals row">
                            <div class="cart_totals ">
                                <legend>Cart totals</legend>
                                <div class="no_more_tables">
                                    <table cellspacing="0" class="shop_table shop_table_responsive">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th class="empty_td">Subtotal</th>
                                                <td data-title="Subtotal">
                                                    <span class="price-amount">
                                                        <bdi><span class="price-currencySymbol">$</span>{{ number_format($cartData->sum('total_price'), 2) }}</bdi>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <th class="empty_td">Total</th>
                                                <td data-title="Total">
                                                    <strong>
                                                        <span class="price-amount amount">
                                                            <bdi><span class="price-currencySymbol">$</span>{{ number_format($cartData->sum('total_price'), 2) }}</bdi>
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <br>
                                <div class="proceed-to-checkout">
                                    <a href="{{route('cart.checkout')}}" class="btn_green waves-effect waves-light green">Proceed to checkout</a>
                                </div>
                            </div>
                        </div>
                   </div>
              </div>
        </div>
       @else
       <div class="row">
            <div class="col-md-12">
                <div class="card card-with-padding empty-cart-content">
                    <legend>your cart is empty</legend>
                    <img src="{{Storage::disk('s3')->url('public/frontendimages/empty_cart_icon.png')}}" alt="empty cart" />
                </div>
            </div>
        </div>
       @endif

    </div>
</div>
@include('user.cart._cart_order_customize_block')
@include('user.cart._edit_non_clothing')
@endsection

@push('js')
<script>
    $(document).on('click','.cart_item_edit',function(){
        var id= $(this).attr('id');
        var url = '{{ route("cart.update.modal", ":slug") }}';
            url = url.replace(':slug', id);
            $.ajax({
                method: 'get',
                processData: false,
                contentType: false,
                cache: false,
                url: url,
                beforeSend: function() {
				    $('.loading-message').html("Please Wait.");
				    $('#loadingProgressContainer').show();
                },

                success:function(data)
                    {
                        $('.loading-message').html("");
				        $('#loadingProgressContainer').hide();
                        if(data.data.product_type == 1 || data.data.product_type == 2 )
                        {
                            $('#cart_item_customize_block').modal('open');
                        }
                        //non clothing block
                        if(data.data.product_type == 3)
                        {
                            $('#non_clothing_block').modal('open');
                            $("#non_clothing_block .edit-non-clothing-color-quantity-block").html('');
                            $.each(JSON.parse(data.product.colors_sizes), function (key,item)
                            {
                                $.each(JSON.parse(data.data.color_attr), function (key2,item2){

                                    if(key==key2)
                                    {
                                        var html= '<tr class="tr">';

                                            html+='<td data-title="Color"><input type="text" class="form-control" value="'+item2.color+'" id="predefind-colors" name="color_size[color][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';
                                            if(item.quantity !=0 || item2.quantity !=0){
                                                html+='<td data-title="Cuantity"><input class="form-control combat" type="text" value="'+item2.quantity+'"  name="color_size[quantity][]" /> <span class="avl-wrap">avl:<span class="avl">'+item.quantity+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="Quantity"><input  type="text"  class="form-control readonly-item" name="color_size[quantity][]" readonly/> <span class="avl-wrap">&nbsp;</span></td>';

                                            }


                                            html+='</tr>';
                                            $("#non_clothing_block .edit-non-clothing-color-quantity-block").append(html);
                                    }

                                });


                            });
                        }


                        //end non clothing block
                        $("#cart_item_customize_block .colors-sizes").html('');
                        if(data.data.product_type==2)
                        {

                            $.each(JSON.parse(data.product.colors_sizes), function (key,item)
                            {
                                $.each(JSON.parse(data.data.color_attr), function (key2,item2){



                                    if(key==key2)
                                    {

                                        var html= '<tr class="tr">';

                                            html+='<td data-title="Color"><input type="text" class="form-control" value="'+item2.color+'" id="predefind-colors" name="color_size[color][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';
                                            if(item.xxs !=0 || item2.xxs !=0){
                                                html+='<td data-title="XXS"><input class="form-control combat" type="text" value="'+item2.xxs+'"  name="color_size[xxs][]" /> <span class="avl-wrap">avl:<span class="avl">'+item.xxs+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="XXS"><input  type="text"  class="form-control readonly-item" name="color_size[xxs][]" readonly/> <span class="avl-wrap">&nbsp;</span></td>';

                                            }
                                            if(item.xs !=0 || item2.xs !=0){
                                                html+='<td data-title="XS"><input class="form-control combat" type="text" value="'+item2.xs+'"  name="color_size[xs][]" /><span class="avl-wrap">avl:<span class="avl">'+item.xs+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="XS"><input  type="text"  class="form-control readonly-item" name="color_size[xs][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';
                                            }
                                            if(item.small !=0 || item2.small !=0){
                                                html+='<td data-title="Small"><input class="form-control combat" type="text" value="'+item2.small+'"  name="color_size[small][]" /> <span class="avl-wrap">avl:<span class="avl">'+item.small+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="Small"><input  type="text"  class="form-control readonly-item" name="color_size[small][]" readonly/><span class="avl-wrap">&nbsp;</span> </td>';

                                            }
                                            if(item.medium !=0 || item2.medium !=0) {
                                                html+='<td data-title="Medium"><input class="form-control combat" type="text" value="'+item2.medium+'"  name="color_size[medium][]" /><span class="avl-wrap">avl:<span class="avl">'+item.medium+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="Medium"><input  type="text"  class="form-control readonly-item" name="color_size[medium][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';
                                            }
                                            if(item.large !=0 || item2.large !=0){
                                                html+='<td data-title="Large"><input class="form-control combat" type="text" value="'+item2.large+'"  name="color_size[large][]" /> <span class="avl-wrap">avl:<span class="avl">'+item.large+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="Large"><input  type="text"  class="form-control readonly-item" name="color_size[large][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';

                                            }
                                            if(item.extra_large !=0 || item2.extra_large !=0){
                                                html+='<td data-title="Extra Large"><input class="form-control combat" type="text" value="'+item2.extra_large+'"  name="color_size[extra_large][]" /><span class="avl-wrap">avl:<span class="avl">'+item.large+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="Extra Large"><input  type="text"  class="form-control readonly-item" name="color_size[extra_large][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';
                                            }
                                            if(item.xxl !=0 || item2.xxl !=0){
                                                html+='<td data-title="XXL"><input class="form-control combat" type="text" value="'+item2.xxl+'"  name="color_size[xxl][]" /> <span class="avl-wrap">avl:<span class="avl">'+item.xxl+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="XXL"><input  type="text"  class="form-control readonly-item" name="color_size[xxl][]" readonly/><span class="avl-wrap">&nbsp;</span> </td>';

                                            }
                                            if(item.xxxl !=0 || item2.xxxl !=0){
                                                html+='<td data-title="XXXL"><input class="form-control combat" type="text" value="'+item2.xxxl+'"  name="color_size[xxxl][]" /><span class="avl-wrap">avl:<span class="avl">'+item.xxxl+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="XXXL"><input  type="text"  class="form-control readonly-item" name="color_size[xxxl][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';
                                            }
                                            if(item.four_xxl !=0 || item2.four_xxl !=0){
                                                html+='<td data-title="4XXL"><input class="form-control combat" type="text" value="'+item2.four_xxl+'"  name="color_size[four_xxl][]" /> <span class="avl-wrap">avl:<span class="avl">'+item.four_xxl+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="4XXL"><input  type="text"  class="form-control readonly-item" name="color_size[four_xxl][]" readonly/><span class="avl-wrap">&nbsp;</span> </td>';

                                            }
                                            if(item.one_size !=0 || item2.one_size !=0){
                                                html+='<td data-title="One Size"><input class="form-control combat" type="text" value="'+item2.one_size+'"  name="color_size[one_size][]" /><span class="avl-wrap">avl:<span class="avl">'+item.one_size+'</span></span></td>';
                                            }else{
                                                html+='<td data-title="One Size"><input  type="text"  class="form-control readonly-item" name="color_size[one_size][]" readonly/><span class="avl-wrap">&nbsp;</span></td>';
                                            }

                                            html+='</tr>';
                                            $("#cart_item_customize_block .colors-sizes").append(html);
                                    }

                                });


                            });
                        }
                        if(data.data.product_type==1)
                        {
                            $.each(JSON.parse(data.data.color_attr), function (key,item)
                            {
                                var html= '<tr>';

                                html+='<td data-title="Color"><input type="text" value="'+item.color+'" id="predefind-colors" name="color_size[color][]" /></td>';
                                html+='<td data-title="XXS"><input class="combat" type="text" value="'+item.xxs+'" class="form-control " name="color_size[xxs][]" /></td>';
                                html+='<td data-title="XS"><input class="combat" type="text" value="'+item.xs+'" class="form-control " name="color_size[xs][]" /></td>';
                                html+='<td data-title="Small"><input class="combat" type="text" value="'+item.small+'" class="form-control " name="color_size[small][]" /></td>';
                                html+='<td data-title="Medium"><input class="combat" type="text" value="'+item.medium+'" class="form-control " name="color_size[medium][]" /></td>';
                                html+='<td data-title="Large"><input class="combat" type="text" value="'+item.large+'" class="form-control " name="color_size[large][]" /></td>';
                                html+='<td data-title="Extra Large"><input class="combat" type="text" value="'+item.extra_large+'" class="form-control " name="color_size[extra_large][]" /></td>';
                                html+='<td data-title="XXL"><input class="combat" type="text" value="'+item.xxl+'" class="form-control " name="color_size[xxl][]" /></td>';
                                html+='<td data-title="XXXL"><input class="combat" type="text" value="'+item.xxxl+'" class="form-control " name="color_size[xxxl][]" /></td>';
                                html+='<td data-title="4XXL"><input class="combat" type="text" value="'+item.four_xxl+'" class="form-control " name="color_size[four_xxl][]" /></td>';
                                html+='<td data-title="One Color"><input class="combat" type="text" value="'+item.one_size+'" class="form-control " name="color_size[one_size][]" /></td>';
                                html+='</tr>';
                                $("#cart_item_customize_block .colors-sizes").append(html);
                            });
                        }
                        $("#cart_item_customize_block .add_more_colors_sizes").html('');
                       if(data.data.product_type==1){
                         var add_more='<a href="javascript:void(0);" class="cart_add_more" onclick="addFreshOrderColorSizeInCart()"><i class="material-icons dp48">add</i> Add More</a>';
                         $("#cart_item_customize_block .add_more_colors_sizes").html(add_more);
                         $('.check_copyright_price').html('');
                         if(data.data.copyright== true){
                             var copyright_check= '<label><input type="checkbox" name="copyright_price" checked="checked" onclick="return false;"/><span>Copyright price</span></label>';
                             $('.check_copyright_price').html(copyright_check);
                         }
                       }
                       $('input[name=rowId]').val(data.data.id);
                       $('input[name=product_type]').val(data.data.product_type);
                       $('input[name=product_sku]').val(data.data.product_sku);
                       $('.total-price-block .item_total_qty').html(data.data.quantity);
                       $('.total-price-block .item_total_price').html(data.data.total_price);
                       $('.total-price-block .item_unit_price').html(data.data.unit_price);
                       $('.total-price-block').show();
                       $('.updateCartItem_readystock').attr('disabled', true);
                       $(".updatedStockQty").val('');
                       $(".updatedUnitPrice").val('');

                    },
                error: function(xhr, status, error)
                    {

                        $('#errors').empty();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });

                    }
            });
    });

//copyrite price update
$(document).on('click', '.cart-wrapper input[name=copyright_price]',function(){
    if ($(this).prop('checked')==true){
       var checked= 1;
    }
    else{
        var checked= 0;
    }
    var cart_row_id=$(this).attr('cartrowid');
    //var cookie_identifier= "@php echo Session::get('cookie_identifier'); @endphp";

    $.ajax({
            method: 'get',
            url: "{{ route('copyright.price') }}",
            data: {checked:checked, cart_row_id:cart_row_id},
            beforeSend: function() {
                $('.loading-message').html("Calculating the price.");
                $('#loadingProgressContainer').show();
            },
            success:function(data)
                {
                    location.reload();
                },
            error: function(xhr, status, error)
                {
                    $('#errors').empty();
                    $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                    $.each(xhr.responseJSON.error, function (key, item)
                    {
                        $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                    });
                }
    });
});

//fresh order color metrics
function addFreshOrderColorSizeInCart()

{
    var html = '<tr class="tr">';
        html+='<td data-title="Color"><input type="text" id="predefind-colors" name="color_size[color][]" /></td>';
        html+='<td data-title="XXS"><input class="combat" type="text"  class="form-control " name="color_size[xxs][]" /></td>';
        html+='<td data-title="XS"><input class="combat" type="text"  class="form-control " name="color_size[xs][]" /></td>';
        html+='<td data-title="Small"><input class="combat" type="text"  class="form-control " name="color_size[small][]" /></td>';
        html+='<td data-title="Medium"><input class="combat" type="text"  class="form-control " name="color_size[medium][]" /></td>';
        html+='<td data-title="Large"><input class="combat" type="text"  class="form-control " name="color_size[large][]" /></td>';
        html+='<td data-title="Extra Large"><input class="combat" type="text"  class="form-control " name="color_size[extra_large][]" /></td>';
        html+='<td data-title="XXL"><input class="combat" type="text"  class="form-control " name="color_size[xxl][]" /></td>';
        html+='<td data-title="XXXL"><input class="combat" type="text"  class="form-control " name="color_size[xxxl][]" /></td>';
        html+='<td data-title="4XXL"><input class="combat" type="text"  class="form-control " name="color_size[four_xxl][]" /></td>';
        html+='<td data-title="One Size"><input class="combat" type="text"  class="form-control " name="color_size[one_size][]" /></td>';
        html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeFreshOrderColorSizeInCart(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
        html += '</tr>';
    $('#cart_item_customize_block tbody').append(html);
}
function removeFreshOrderColorSizeInCart(el)
{
    $(el).parent().parent().remove();
}
//check product price and quantity range
        $(document).on('input', 'table .combat' , function() {
            var checkProductType=$(' input[name=product_type]').val();
                if(checkProductType==2 || checkProductType == 3)
                {
                    var inputValue = $(this).closest('td').find(".combat").val();
                    var avlValue = $(this).closest('td').find(".avl").text();
                    if(Number(avlValue) < Number(inputValue)){
                        $(this).closest('td').find(".combat").addClass('warning');
                        $(this).closest('td').find(".avl").css('color','red');
                        $('.total-price-block').hide();
                        //$('.updateCartItem_readystock').attr('disabled', true);
                        $('.price-calculation').attr('disabled', true);
                        if($('.updateCartItem_readystock').not(':disabled')){
                            $('.updateCartItem_readystock').attr('disabled', true);
                        }
                        return false;
                    }
                    else{
                        $('.price-calculation').attr('disabled', false);
                        // if($('.updateCartItem_readystock').is(':disabled')){
                        //     $('.updateCartItem_readystock').attr('disabled', false);
                        // }
                        $(this).closest('td').find(".combat").removeClass('warning');
                        $(this).closest('td').find(".avl").css('color','rgba(0,0,0,0.87)');
                    }
                    var error=$('#cart_item_customize_block td input').hasClass("warning")
                    if(error == true){
                        alert('Please check availability with quantity');
                        $('.total-price-block').hide();
                        $('.price-calculation').attr('disabled', true);
                        if($('.updateCartItem_readystock').not(':disabled')){
                            $('.updateCartItem_readystock').attr('disabled', true);
                        }

                    }
                }
        })

        $(document).on('click', '.price-calculation' , function() {
            var tot = 0;
            var product_sku= $('#cart_item_customize_block input[name=product_sku]').val();
            var tot = 0;
            $("table .combat").each(function () {
                var get_textbox_value = $(this).val();
                if ($.isNumeric(get_textbox_value)) {
                    tot += parseFloat(get_textbox_value);
                    }

            });
            $.ajax({
                url: "{{route('fresh.order.calculate')}}",
                type: "POST",
                data: {"value": tot, "product_sku": product_sku , "_token": "{{ csrf_token() }}"},
                beforeSend: function() {
				    $('.loading-message').html("Calculating the price.");
				    $('#loadingProgressContainer').show();
                },
                success: function (data) {
                    $('.loading-message').html("");
				    $('#loadingProgressContainer').hide();
                    $('.item_total_qty').html(tot);
                    $('.item_total_price').html(data.total_price);
                    $(".updatedStockQty").val(tot);
                    $(".updatedUnitPrice").val(data.unit_price);
                    $(".updatedTotalPrice").val(data.total_price);
                    $('.item_unit_price').html(data.unit_price);
                    $('.total-price-block').show();
                    // if(data.total_price== 'out of range'){
                    //    $('.updateCartItem_readystock').attr('disabled', true);
                    // }
                    // else{
                    //    $('.updateCartItem_readystock').attr('disabled', false);
                    // }
                    if(data.flag==0){
                        $('.updateCartItem_readystock').attr('disabled', true);
                    }
                    else if(data.flag==1){
                        $('.updateCartItem_readystock').attr('disabled', true);

                    }
                    else{
                        $('.updateCartItem_readystock').attr('disabled', false);
                    }

                }
            });
        });


</script>
@endpush
