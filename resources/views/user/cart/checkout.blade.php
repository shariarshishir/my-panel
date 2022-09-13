@extends('layouts.app')
@section('content')
<section class="content checkout_content_wrap main_content_wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-with-padding">
                    <legend>Cart List</legend>
                    @if ($errors->any())

                        <div class="card-alert card red">
                            <div class="card-content white-text">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <!-- /.card-header -->
            <form action="{{route('cart.order')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col s12">
                        <div class="cart-wrapper">
                            <div class="no_more_tables">
                                <table class="shop_table shop_table_responsive cart_table" cellspacing="0">
                                    <thead class="cf">
                                    <tr>
                                        <th class="product-thumbnail">Product Image</th>
                                        <th class="product-name">Product Name</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($cartData as $cartItem)

                                        <tr class="cart_item" data-vendorId="{{$cartItem->business_profile_id}}">

                                            <td data-title="Product Image" class="product-thumbnail">
                                                <a href="#"><img height="80px"  width="80px" src="{{URL::asset('storage/'.$cartItem->image)}}" class="" alt="" loading="lazy"/></a>
                                            </td>
                                            <td data-title="Product Name" class="product-name" data-title="Product">
                                                <div style="color: #4CAF50;">{{$cartItem->name}}</div>
                                                @if($cartItem->full_stock==1)
                                                    <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label">Full Stock</span>
                                                    @elseif(isset($cartItem->order_modification_req_id))
                                                    <span class="badge badge pill blue accent-2 mr-2 ready-to-ship-label">Modified</span>
                                                @endif
                                            </td>
                                            <td data-title="Price" class="product-price" data-title="Price">
                                                <span class="price-currencySymbol">${{ number_format($cartItem->unit_price, 2) }}</span>
                                            </td>
                                            <td data-title="Quantity" class="product-quantity" data-title="Quantity">
                                                <span class="price-currencySymbol">{{$cartItem->quantity}}</span>
                                                @if ($cartItem->full_stock == 1)
                                                <span class="tooltipped" data-position="top" data-tooltip="Full Stock"><i class="material-icons dp48">live_help</i></span>
                                                @endif
                                            </td>
                                            <td data-title="Subtotal" class="product-subtotal" data-title="Subtotal">
                                                <span class="price-amount">
                                                    <bdi><span class="price-currencySymbol">${{ number_format($cartItem->total_price, 2) }}</span></bdi>
                                                    @if($cartItem->copyright==true)
                                                        <span class="tooltipped" data-position="top" data-tooltip="Copyright price is {{ number_format($cartItem->copyright_price, 2) }}"><i class="material-icons dp48">live_help</i></span>
                                                    @endif
                                                    @if (isset($cartItem->discount_amount))
                                                        <span class="tooltipped" data-position="top" data-tooltip="Discount Amount {{ $cartItem->discount_amount }}"><i class="material-icons dp48">live_help</i></span>
                                                    @endif
                                                </span>
                                            </td>

                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row checkout_address_block_wrap">
                    <div class="col m6 billing_and_shipping_address_block">
                        <div class="billing_address_block">
                            <legend>Billing Address</legend>

                            <div class="row billing_adrs_new" >
                                <div class="input-field col s12">
                                    <label for="name" class="">Name</label>
                                    <input type="text" placeholder="" id="name" name="billing_name" value="{{auth()->user()->name}}"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="company_name" class="">Company Name</label>
                                    <input type="text" placeholder="" id="billing_company_name" name="billing_company_name" value="{{auth()->user()->company_name}}"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="b_country" class="">Select Your Country</label>
                                    <select class="select2 browser-default" name="b_country" id="b_country">
                                        <option value="" disabled selected>Select Your Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->name}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12">
                                    <label for="billing_city" class="">City</label>
                                    <input type="text" placeholder="" id="billing_city" name="billing_city" />
                                </div>
                                <div class="input-field col s12">
                                    <label for="billing_address" class="">Address</label>
                                    <input type="text" placeholder="" id="billing_address" name="billing_address" value=""/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="billing_zip" class="">Zip</label>
                                    <input type="text" placeholder="" id="billing_zip" name="billing_zip" />
                                </div>
                                <div class="input-field col s12">
                                    <label for="billing_email" class="">Email</label>
                                    <input type="email" placeholder="" id="billing_email" name="billing_email"  value="{{auth()->user()->email}}"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="billing_phone" class="">phone</label>
                                    <input type="text" placeholder="" id="billing_phone" name="billing_phone" value="{{auth()->user()->phone}}"/>
                                </div>
                                @if(count($billing_address)!=0)
                                <div class="input-field col s12">
                                    <a href="javascript:void(0);" class="previous_adrs">Previous Address</a>
                                </div>
                                @endif
                            </div>

                            <div class="billing_adrs" style="display: none;">
                                <div class="input-field">
                                    <label for="billing_address_id" class="">Select Billing Address</label>
                                    <select class="select2 browser-default " name="billing_address_id" id="billing_adrs_select">
                                        <option value="" disabled selected>Select</option>
                                        @foreach($billing_address as $address)
                                        <option value="{{$address->id}}">{{$address->name}}-{{$address->address}}</option>
                                        @endforeach
                                    </select>
                                    <a href="javascript:void(0);" class="add_new_billing_adrs"> <i class="material-icons dp48">add</i> Add New</a>
                                </div>
                            </div>
                        </div>
                        <legend>Shipping Address</legend>
                            <div>
                                <p>
                                    <label>
                                      <input type="checkbox" name="same_as_billing_adrs"/>
                                      <span>Same as billing address</span>
                                    </label>
                                  </p>
                            </div>
                        <div class="shipping_address_block">
                            <div class="input-field">
                                <div class="shipping_adrs" style="@if(count($shipping_address)==0) display:none; @endif">
                                    <label for="shipping_adres_select" class="">Select Shipping Address</label>
                                    <select class="select2 browser-default" name="shipping_address_id" id="shipping_adres_select" >
                                        <option value="" disabled selected>Select</option>
                                        @foreach($shipping_address as $address)
                                        <option value="{{$address->id}}">{{$address->name}}-{{$address->address}}</option>
                                        @endforeach
                                    </select>
                                    <!-- <a href="javascript:void(0);" class="add_new_shipping_adrs">Add New</a> -->
                                    <a href="javascript:void(0);" class="add_new_shipping_adrs"> <i class="material-icons dp48">add</i> Add New</a>
                                </div>
                            </div>

                            <div class="row shipping_adrs_new"  style="@if(count($shipping_address)!=0) display:none; @endif" >
                                <div class="input-field col s12">
                                    <label for="name" class="">Name</label>
                                    <input type="text" placeholder="" id="shipping_name" name="shipping_name" value="{{auth()->user()->name}}"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="shipping_company_name" class="">Company Name</label>
                                    <input type="text" id="shipping_company_name" placeholder="" name="shipping_company_name" value="{{auth()->user()->company_name}}"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="s_country" class="">Select Your Country</label>
                                    <select class="select2 browser-default" name="s_country">
                                        <option value="" disabled selected>Select Your Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12">
                                    <label for="shipping_city" class="">City</label>
                                    <input type="text" placeholder="" id="shipping_city" name="shipping_city" />
                                </div>
                                <div class="input-field col s12">
                                    <label for="address" class="">Address</label>
                                    <input type="text" placeholder="" id="shipping_address" name="shipping_address" value=""/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="address" class="">Zip</label>
                                    <input type="text" placeholder="" id="shipping_zip" name="shipping_zip" />
                                </div>
                                <div class="input-field col s12">
                                    <label for="shipping_email" class="">Email</label>
                                    <input type="email" placeholder="" id="shipping_email" name="shipping_email" value="{{auth()->user()->email}}"/>
                                </div>
                                <div class="input-field col s12">
                                    <label for="shipping_phone" class="">phone</label>
                                    <input type="text" placeholder="" id="shipping_phone" name="shipping_phone" value="{{auth()->user()->phone}}"/>
                                </div>
                                @if(count($shipping_address)!=0)
                                <div class="input-field col s12">
                                    <a href="javascript:void(0);" class="previous_adrs_shipping">Previous Address</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col m6">
                        <div id="order_review" class="checkout-review-order">
                            <table class="shop_table checkout-review-order-table">
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cartData as $cartcartItem)
                                    <tr class="cart_item">
                                        <td class="product-name">
                                            {{$cartcartItem->name}}&nbsp;<strong class="product-quantity">×&nbsp;{{$cartcartItem->quantity}}</strong>
                                            <input type="hidden" name="product_sku[]" id="" value="{{$cartcartItem->id}}">
                                            <input type="hidden" name="product_qty[]" id="" value="{{$cartcartItem->quantity}}">
                                            <input type="hidden" name="product_vendor[]" id="" value="{{$cartcartItem->vendor_id}}">
                                        </td>
                                        <td class="product-total">
                                            <span class="price-amount amount">
                                                <bdi><span class="price-currencySymbol">$</span>{{ number_format($cartcartItem->total_price, 2) }}</bdi>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td>
                                            <span class="price-amount amount">
                                                <bdi><span class="price-currencySymbol">$</span>{{ number_format($cartData->sum('total_price'), 2) }}</bdi>
                                                <input type="hidden" name="sub_total" value="{{ number_format($cartData->sum('total_price'), 2) }}">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="shipping-totals shipping">
                                        <th>Shipping</th>
                                        <td data-title="Shipping">
                                        <ul id="shipping_method" class="shipping-methods">
                                            <li>
                                                <input type="hidden" name="shipping_method[0]" data-index="0" id="shipping_method_0_free_shipping1" value="free_shipping:1" class="shipping_method">
                                                <label for="shipping_method_0_free_shipping1">Free shipping</label>
                                            </li>
                                        </ul>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td>
                                            <strong>
                                                <span class="price-amount amount">
                                                    <bdi><span class="price-currencySymbol">$</span>{{ number_format($cartData->sum('total_price'), 2) }}</bdi>
                                                    <input type="hidden" name="total" value="{{ number_format($cartData->sum('total_price'), 2) }}">
                                                </span>
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div id="payment" class="checkout-payment">

                                @if (isset($configArray['ten_percent_show_at']) && $configArray['ten_percent_show_at'] == 'frontend')
                                    <label for="payment_method" class="">Payment Method</label>
                                    <ul>
                                        <li>
                                            <label>
                                                <input class="with-gap" name="payment_id" value="1" type="radio" checked />
                                                <span>10% with merchant assistance</span>
                                            </label>
                                        </li>
                                        {{-- <li>
                                            <label>
                                                <input class="with-gap" name="payment_id" value="0" type="radio" />
                                                <span>Throughout the PO</span>
                                            </label>
                                        </li> --}}
                                    </ul>
                                @endif


                                <div class="form-row place-order">
                                    <div class="terms-and-conditions-wrapper">
                                        <div class="privacy-policy-text"><p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="javascript:void(0);" class="privacy-policy-link">privacy policy</a>.</p></div>
                                    </div>
                                    <div class="captchaContent" style="margin-bottom: 15px;">
                                        <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G"></div>
                                        <div class="messageContent" style="color: red; text-align: left;"></div>
                                    </div>
                                    <button type="button" class="submit_order btn_green" name="checkout_place_order" id="place_order" value="Place order" data-value="Place order">Place order</button>
                                    <button type="submit" id="page_button" style="display: none;">Place order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
  <script>
      $('.previous_adrs').click(function(){
              $('.billing_adrs_new').hide();
              $('.billing_adrs').show();
              $('select#billing_adrs_select').attr('required',1);
     });
     $('.add_new_billing_adrs').click(function(){
              $('.billing_adrs').hide();
              $('.billing_adrs_new').show();
              $('select#billing_adrs_select').removeAttr('required');
     });
     $('.add_new_shipping_adrs').click(function(){
              $('.shipping_adrs').hide();
              $('.shipping_adrs_new').show();
              $('#shipping_adres_select').removeAttr('required');
     });
     $('.previous_adrs_shipping').click(function(){
              $('.shipping_adrs').show();
              $('.shipping_adrs_new').hide();
              $('#shipping_adres_select').attr('required',1);
     });

     //same as billing address
     $('input[name=same_as_billing_adrs]').click(function(){
            if($(this).prop("checked") == true){
                $('.shipping_address_block').hide();
                $('#shipping_adres_select').removeAttr('required');
            }
            else if($(this).prop("checked") == false){
                // $('#shipping_adres_select').attr('required',1);
                $('.shipping_address_block').show();
            }
        });
    // if($('input[name=same_as_billing_adrs]').prop('checked') == true){
    //    alert('test');
    // }
    $(".submit_order").click(function()
    {
        var errCount = 0;
        var errorClass = 'error';
        // Billing data validation start
       var billingAdrsSelVal= $('#billing_adrs_select option:selected').val();
        if (billingAdrsSelVal){
             errCount = 0;
        }
        else{
                if ($('#name').val()=="" || $('#name').val()=="undefined")
                {
                    errCount++;
                    $('#name').closest('.input-field').addClass(errorClass);
                    $('#name').addClass('invalid');
                }
                else
                {
                    $('#name').closest('.input-field').removeClass(errorClass);
                    $('#name').removeClass('invalid');
                }

                if ($('#billing_company_name').val()=="" || $('#billing_company_name').val()=="undefined")
                {
                    errCount++;
                    $('#billing_company_name').closest('.input-field').addClass(errorClass);
                    $('#billing_company_name').addClass('invalid');
                }
                else
                {
                    $('#billing_company_name').closest('.input-field').removeClass(errorClass);
                    $('#billing_company_name').removeClass('invalid');
                }

                if ($('select[name="b_country"]').val()==null || $('select[name="b_country"]').val()=="Select an option")
                {
                    errCount++;
                    $('select[name="b_country"]').closest('.input-field').addClass(errorClass);
                    $('select[name="b_country"]').addClass('invalid');
                }
                else
                {
                    $('select[name="b_country"]').closest('.input-field').removeClass(errorClass);
                    $('select[name="b_country"]').removeClass('invalid');
                }

                if ($('#billing_city').val()=="" || $('#billing_city').val()=="undefined")
                {
                    errCount++;
                    $('#billing_city').closest('.input-field').addClass(errorClass);
                    $('#billing_city').addClass('invalid');
                }
                else
                {
                    $('#billing_city').closest('.input-field').removeClass(errorClass);
                    $('#billing_city').removeClass('invalid');
                }

                if ($('#billing_address').val()=="" || $('#billing_address').val()=="undefined")
                {
                    errCount++;
                    $('#billing_address').closest('.input-field').addClass(errorClass);
                    $('#billing_address').addClass('invalid');
                }
                else
                {
                    $('#billing_address').closest('.input-field').removeClass(errorClass);
                    $('#billing_address').removeClass('invalid');
                }

                if ($('#billing_zip').val()=="" || $('#billing_zip').val()=="undefined")
                {
                    errCount++;
                    $('#billing_zip').closest('.input-field').addClass(errorClass);
                    $('#billing_zip').addClass('invalid');
                }
                else
                {
                    $('#billing_zip').closest('.input-field').removeClass(errorClass);
                    $('#billing_zip').removeClass('invalid');
                }

                if ($('#billing_email').val()=="" || $('#billing_email').val()=="undefined")
                {
                    errCount++;
                    $('#billing_email').closest('.input-field').addClass(errorClass);
                    $('#billing_email').addClass('invalid');
                }
                else
                {
                    $('#billing_email').closest('.input-field').removeClass(errorClass);
                    $('#billing_email').removeClass('invalid');
                }

                if ($('#billing_phone').val()=="" || $('#billing_phone').val()=="undefined")
                {
                    errCount++;
                    $('#billing_phone').closest('.input-field').addClass(errorClass);
                    $('#billing_phone').addClass('invalid');
                }
                else
                {
                    $('#billing_phone').closest('.input-field').removeClass(errorClass);
                    $('#billing_phone').removeClass('invalid');
                }

            }

        // Billing data validation end

        // Shipping data validation start
        var shippingAdrsSelVal= $('#shipping_adres_select option:selected').val();
        if (shippingAdrsSelVal || $('input[name=same_as_billing_adrs]').prop('checked') == true ){
             errCount = 0;
        }
        else{
                if ($('#shipping_name').val()=="" || $('#shipping_name').val()=="undefined")
                {
                    errCount++;
                    $('#shipping_name').closest('.input-field').addClass(errorClass);
                    $('#shipping_name').addClass('invalid');
                }
                else
                {
                    $('#shipping_name').closest('.input-field').removeClass(errorClass);
                    $('#shipping_name').removeClass('invalid');
                }

                if ($('#shipping_company_name').val()=="" || $('#shipping_company_name').val()=="undefined")
                {
                    errCount++;
                    $('#shipping_company_name').closest('.input-field').addClass(errorClass);
                    $('#shipping_company_name').addClass('invalid');
                }
                else
                {
                    $('#shipping_company_name').closest('.input-field').removeClass(errorClass);
                    $('#shipping_company_name').removeClass('invalid');
                }

                if ($('select[name="s_country"]').val()==null || $('select[name="s_country"]').val()=="Select an option")
                {
                    errCount++;
                    $('select[name="s_country"]').closest('.input-field').addClass(errorClass);
                    $('select[name="s_country"]').addClass('invalid');
                }
                else
                {
                    $('select[name="s_country"]').closest('.input-field').removeClass(errorClass);
                    $('select[name="s_country"]').removeClass('invalid');
                }

                if ($('#shipping_city').val()=="" || $('#shipping_city').val()=="undefined")
                {
                    errCount++;
                    $('#shipping_city').closest('.input-field').addClass(errorClass);
                    $('#shipping_city').addClass('invalid');
                }
                else
                {
                    $('#shipping_city').closest('.input-field').removeClass(errorClass);
                    $('#shipping_city').removeClass('invalid');
                }

                if ($('#shipping_address').val()=="" || $('#shipping_address').val()=="undefined")
                {
                    errCount++;
                    $('#shipping_address').closest('.input-field').addClass(errorClass);
                    $('#shipping_address').addClass('invalid');
                }
                else
                {
                    $('#shipping_address').closest('.input-field').removeClass(errorClass);
                    $('#shipping_address').removeClass('invalid');
                }

                if ($('#shipping_zip').val()=="" || $('#shipping_zip').val()=="undefined")
                {
                    errCount++;
                    $('#shipping_zip').closest('.input-field').addClass(errorClass);
                    $('#shipping_zip').addClass('invalid');
                }
                else
                {
                    $('#shipping_zip').closest('.input-field').removeClass(errorClass);
                    $('#shipping_zip').removeClass('invalid');
                }

                if ($('#shipping_email').val()=="" || $('#shipping_email').val()=="undefined")
                {
                    errCount++;
                    $('#shipping_email').closest('.input-field').addClass(errorClass);
                    $('#shipping_email').addClass('invalid');
                }
                else
                {
                    $('#shipping_email').closest('.input-field').removeClass(errorClass);
                    $('#shipping_email').removeClass('invalid');
                }

                if ($('#shipping_phone').val()=="" || $('#shipping_phone').val()=="undefined")
                {
                    errCount++;
                    $('#shipping_phone').closest('.input-field').addClass(errorClass);
                    $('#shipping_phone').addClass('invalid');
                }
                else
                {
                    $('#shipping_phone').closest('.input-field').removeClass(errorClass);
                    $('#shipping_phone').removeClass('invalid');
                }
            }
        // Shipping data validation end

        if(errCount==0)
        {
            var serverEnv = "{{ env('APP_ENV') }}";
            if(serverEnv == 'production')
            {
                if (grecaptcha.getResponse()==""){
                    $('.messageContent').html('Captcha Required');
                } else {
                    $("#page_button").click();
                }
            }
            else
            {
                $("#page_button").click();
            }
        }
        else
        {
            alert('Please fill all the required fields.');
            //$("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        }
    });

  </script>
@endpush





