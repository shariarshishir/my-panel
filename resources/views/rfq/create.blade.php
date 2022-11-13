@extends('layouts.app')
@section("style")
<style>

</style>
@endsection
@section('content')
<div id="create-rfq-form" class="rfq_detail_from_wrap create_rfq_detail_from_wrap">
    <div class="modal-content">
        <section class="ic-buying-req rfq_create_wrap">
            <div class="product_add_wrap_modal">

                <div class="new_rfq_upload_form_wrap">
                    <div class="row">
                        <div class="col s12">
                            <h1 style="margin-bottom:10px;">Request For Quotation</h1>
                            <p style="margin-bottom: 20px;">Submit an RFQ and find the best match with speed and reliability.</p>
                        </div>
                        <div class="col s12">
                        @if(isset($design_products))
                            <div class="rfq-product-you-may-also-like card">
                                <h3>You may like...</h3>
                                <div class="row">
                                    @foreach ($design_products as $design_products)
                                    <div class="col s12 m6 l3">
                                        <div class="design_studio_product">
                                            <div class="card-content">
                                                <div class="product_img">
                                                    <a href="{{route('rfq.create',[$design_products->flag, $design_products->id])}}">
                                                        @if(count($design_products->images) > 0)
                                                            <img src="{{Storage::disk('s3')->url('public/'.$design_products->images[0]['original'])}}" class="single-product-img" alt="">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="product_short_details">
                                                    <div class="product-title">
                                                        <a href="{{route('rfq.create',[$design_products->flag, $design_products->id])}}">
                                                            {{$design_products->name}}
                                                        </a>
                                                    </div>
                                                    <div class="product_price">
                                                        <div class="single-product-price-value">
                                                            @php
                                                                $count= count(json_decode($design_products->attribute));
                                                                $count = $count-2;
                                                            @endphp
                                                            <span class="price_negotiable">
                                                                @foreach (json_decode($design_products->attribute) as $k => $v)
                                                                    @if($k == 0 && $v[2] == 'Negotiable')
                                                                    {{ 'Negotiable' }}
                                                                    @endif
                                                                    @if($loop->last && $v[2] != 'Negotiable')
                                                                    <span class="nego_price">
                                                                        ${{ $v[2] }}
                                                                    </span>
                                                                    @endif
                                                                    @if($loop->last && $v[2] == 'Negotiable')
                                                                        @foreach (json_decode($design_products->attribute) as $k => $v)
                                                                                @if($k == $count)
                                                                                    ${{ $v[2]  }} {{ 'Negotiable' }}
                                                                                @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form class="update_rfq_product_upload_form createRfqForm" method="post" enctype="multipart/form-data" action="">
                            <div class="row createRfqForm_contect_wrap">
                                <div class="col s12 m12 l12 create_rfq_form_wrap">
                                    <div class="row">
                                        <div class="col s12 m6 input-field">
                                            <label>Select Product Tags <span>*</span></label>
                                            <select class="select2" id="category_id" name="category[]" multiple required >
                                                <option>Select an option</option>
                                                @foreach($product_tags as $product_tag)
                                                    <option value="{{ $product_tag->id }}">{{ $product_tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col s12 m6 input-field">
                                            <label>Title <span>*</span></label>
                                            <input type="text" class="" name="title" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <div class="">
                                                <label>Short Description <span>*</span></label>
                                                <textarea class="ig-new-rgt prd-txta short_description add_short_description" name="full_specification" required></textarea>
                                                <input type="hidden" name="short_description" value="" />
                                            </div>
                                        </div>
                                        <div class="col s12 xl6">
                                            <div class="input-field">
                                                <label>Quantity <span>*</span></label>
                                                <div class="rfqQuantity">
                                                    <input type="number" class="quantity_input" name="quantity" required/>
                                                    <select class="select2 browser-default" name="unit">
                                                        <option value="">UOM</option>
                                                        @php $units = units(); @endphp
                                                        @foreach($units as $unit=>$value)
                                                            <option value="{{$unit}}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 xl6">
                                            <div class="input-field">
                                                <div class="target_price_block">
                                                    <label>Target Price <span>*</span></label>
                                                    <div class="target_price_negotiable">
                                                        <label class="tooltipped" data-position="top" data-tooltip="Check this if you want to set negotiable price.">
                                                            <input type="checkbox" name="target_price_negotiable" class="target_price_negotiable" /> <span>Negotiable</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="rfqPrice">
                                                    <span>USD</span>
                                                    <input type="text" class="price_input" id="target_price" name="unit_price" value="" required onchange="allowTwoDecimal()" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 xl4">
                                            <div class="input-field">
                                                <label>Payment Method <span>*</span></label>
                                                <select class="select2 browser-default" name="payment_method" required >
                                                    <option>Select an option</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="card">Card</option>
                                                    <option value="Letter of Credit ( LC )">Letter of Credit ( LC )</option>
                                                    <option value="pay order">Pay Order</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="tt">TT</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col s12 xl4">
                                            <div class="input-field">
                                                <label>Destination <span>*</span></label>
                                                <input type="text" class="" name="destination" required/>
                                            </div>
                                        </div>
                                        <div class="col s12 xl4">
                                            <div class="input-field">
                                                <label>Expected Delivery Date <span>*</span></label>
                                                <input type="date" class="" name="delivery_time" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m12 l12 rfq_upload_filebox_leftBox">
                                    <div class="rfq_upload_filebox_wrap">
                                        <div class="rfq_upload_filebox center-align">
                                            <div class="rfq-document-upload" id="rfq-document-upload"></div>
                                            <div class="or"><span>OR</span></div>
                                            <a href="javascript:void(0);" class="btn_green browse_file_trigger">Browse files</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="rfq-user-system-entry-modal" class="modal update_rfq_signin_modal">
                                <div class="close">
                                    <a href="javascript:void(0);" class="modal-action modal-close">
                                        <i class="material-icons green-text text-darken-1">close</i>
                                    </a>
                                </div>
                                <div class="modal-content">
                                    <div class="user_login_info" style="display: none;">
                                        <h4>Sign in</h4>
                                        <div class="row">
                                            <div class="col s12 input-field">
                                                <label>Email address</label>
                                                <input type="email" class="" name="email" autocomplete="false"/>
                                            </div>
                                            <div class="col s12 input-field">
                                                <label>Password</label>
                                                <input type="password" class="" name="password"  autocomplete="new-password"/>
                                            </div>
                                            <div class="col s12">
                                                <div class="row">
                                                    <!--div class="col s12 m8">
                                                        <div class="captchaContent" style="margin-bottom: 15px;">
                                                            <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G" data-callback="getCaptchaResponse"></div>
                                                            <div class="messageContent" style="color: red; text-align: left;"></div>
                                                        </div>
                                                    </div-->
                                                    <div class="btn_wrap">
                                                        <button type="submit" id="page_button" style="display: none;"></button>
                                                        <div class="submit_btn_wrap right-align">
                                                            <button type="button" class="btn_green btn_rfq_post btn-green" onclick="onSubmitValidation();">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col m12">
                                                <div class="signin_or_signup_info_message" style="padding-bottom: 15px;">
                                                    <i class="material-icons dp48" style="vertical-align: middle;">info</i> Don't have an Account?
                                                </div>
                                                <div class="new_rfq_upload_form_wrap">
                                                    <a href="https://accounts.merchantbay.com" class="btn_green registration_account" style="padding: 10px;">Register</a>
                                                    <a href="javascript:void(0)" class="btn_green trigger_rfq_register" style="padding: 10px;">Submit as a Guest</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user_registration_info">
                                        <h4>Submit as a Guest</h4>
                                        <div class="row">
                                            <div class="col s12 input-field">
                                                <label>Name</label>
                                                <input type="text" class="" name="name" autocomplete="false"/>
                                            </div>
                                            <div class="col s12 input-field">
                                                <label>Email</label>
                                                <input type="email" class="" name="r_email" autocomplete="false"/>
                                            </div>
                                            <div class="col s12 input-field" style="display: none;">
                                                <label>Password</label>
                                                <input type="password" class="" name="r_password" value="@php echo generateHashPassword(); @endphp" autocomplete="new-password"/>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <label>Company Name</label>
                                                <input type="text" class="" name="r_company" autocomplete="false" />
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <label>Phone Number</label>
                                                <input type="number" class="" placeholder="+880 XXXXXXXXXX" name="r_phone" autocomplete="false" />
                                            </div>
                                            <div class="col s12">
                                                <div class="row">
                                                    <!--div class="col s12 m8">
                                                        <div class="captchaContent" style="margin-bottom: 15px;">
                                                            <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G" data-callback="getCaptchaResponse"></div>
                                                            <div class="messageContent" style="color: red; text-align: left;"></div>
                                                        </div>
                                                    </div-->
                                                    <div class="btn_wrap">
                                                        <button type="submit" id="page_button" style="display: none;"></button>
                                                        <div class="submit_btn_wrap right-align">
                                                            <button type="button" class="btn_green btn_rfq_post btn-green" onclick="onSubmitValidation();">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col m12">
                                                <div class="signin_or_signup_info_message">
                                                    <i class="material-icons dp48" style="vertical-align: middle;">info</i> Already have an account. <a href="javascript:void(0)" class="trigger_rfq_login">Sign In</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btn_rfq_post_bottom">
                                <input type="hidden" name="captcha_token" id="captcha_token" value="">
                                @if(auth()->user())
                                    <div class="ic-form-btn ic-buying-req-btn text-center" style="margin-top: 0px; margin-bottom: 14px;">
                                        <button type="submit" id="page_button" style="display: none;"></button>
                                        <div class="submit_btn_wrap center-align">
                                            <button type="button" class="btn_green btn_rfq_post btn-green right" onclick="onSubmitWithAuthUserValidation();">
                                                MATCH SUPPLIER
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn_green btn_rfq_post_next btn_rfq_post modal-trigger right" href="#rfq-user-system-entry-modal">Next <i class="material-icons">navigate_next</i></a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div> -->
</div>


@push('js')
     <script type="text/javascript">
        const alertStatus = (e) => {
            if ($(".target_price_negotiable").is(":checked"))
            {
                $("#target_price").attr("disabled", true);
                $("#target_price").attr("required", false);
                $("#target_price").addClass("disabled");
            }
            else
            {
                $("#target_price").attr("disabled", false);
                $("#target_price").attr("required", true);
                $("#target_price").removeClass("disabled");
            }
        };
        $(document).on("click", ".target_price_negotiable", alertStatus);
        //image upload script
        $(function(){
            $('.rfq-document-upload').imageUploader({
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'rfq-documents',
                label : 'Drag and Drop any product Image, Techpack, Size Chart etc here. jpeg/png/pdf/doc/xls files and size not more than 25 MB'
            });

            $(".browse_file_trigger").click(function(){
                $('.image-uploader input[type="file"]').trigger("click");
            });

            $('input[name="rfq-documents[]"]').change(function(){
                //console.log($(this)[0].files);
                $.each($(this)[0].files, function()
                {
                    console.log($(this)[0].name);
                })
            });
        });

         $(document).ready(function(){
             $(".trigger_rfq_register").click(function(){
                $(this).closest(".user_login_info").hide();
                $(".user_registration_info").show();
             })
             $(".trigger_rfq_login").click(function(){
                $(this).closest(".user_registration_info").hide();
                $(".user_login_info").show();
             });
         })

        function allowTwoDecimal() {
            var num = $("#target_price").val();
            value = parseFloat(num).toFixed(2);
            $("#target_price").val(value);
            //console.log(value);
        }

        function onSubmitWithAuthUserValidation()
        {
            var errCount = 0;
            var errorClass = 'error';


            // if ($('#category_id').val()==null || $('#category_id').val()=="Select an option")
            // {
            //     errCount++;
            //     $('#category_id').closest('.input-wrapper').addClass(errorClass);
            //     $('#category_id').addClass('invalid');
            // }
            // else
            // {
            //     $('#category_id').closest('.input-wrapper').removeClass(errorClass);
            //     $('#category_id').removeClass('invalid');
            // }

            // if ($('input[name="title"]').val()=="" || $('input[name="title"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="title"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="title"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="title"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="title"]').removeClass('invalid');
            // }

            // if ($('input[name="short_description"]').val()=="" || $('input[name="short_description"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="short_description"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="short_description"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="short_description"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="short_description"]').removeClass('invalid');
            // }

            // if ($('input[name="full_specification"]').val()=="" || $('input[name="full_specification"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="full_specification"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="full_specification"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="full_specification"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="full_specification"]').removeClass('invalid');
            // }

            // if ($('input[name="quantity"]').val()=="" || $('input[name="quantity"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="quantity"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="quantity"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="quantity"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="quantity"]').removeClass('invalid');
            // }

            // if ($('input[name="unit_price"]').val()=="" || $('input[name="unit_price"]').val()=="undefined" )
            // {
            //     errCount++;
            //     $('input[name="unit_price"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="unit_price"]').addClass('invalid');
            // }
            // else if($.isNumeric($('input[name="unit_price"]').val()) == false)
            // {
            //     errCount++;
            //     $('input[name="unit_price"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="unit_price"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="unit_price"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="unit_price"]').removeClass('invalid');
            // }

            // if ($('input[name="destination"]').val()=="" || $('input[name="destination"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="destination"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="destination"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="destination"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="destination"]').removeClass('invalid');
            // }

            // if ($('select[name="payment_method"]').val()==null || $('select[name="payment_method"]').val()=="Select an option")
            // {
            //     errCount++;
            //     $('select[name="payment_method"]').closest('.input-wrapper').addClass(errorClass);
            //     $('select[name="payment_method"]').addClass('invalid');
            // }
            // else
            // {
            //     $('select[name="payment_method"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('select[name="payment_method"]').removeClass('invalid');
            // }

            // if ($('input[name="delivery_time"]').val()=="" || $('input[name="delivery_time"]').val()=="undefined" || $('input[name="delivery_time"]').val()=="mm/dd/yyyy")
            // {
            //     errCount++;
            //     $('input[name="delivery_time"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="delivery_time"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="delivery_time"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="delivery_time"]').removeClass('invalid');
            // }

            // if ($('input[name="email"]').val()=="" && $('input[name="r_email"]').val()=="")
            // {
            //     errCount++;
            //     $('input[name="email"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="email"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="email"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="email"]').removeClass('invalid');
            // }

            // if ($('input[name="password"]').val()=="" && $('input[name="r_password"]').val()=="")
            // {
            //     errCount++;
            //     $('input[name="password"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="password"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="password"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="password"]').removeClass('invalid');
            // }

            // if ($('input[name="email"]').val()=="" && $('input[name="name"]').val()=="")
            // {
            //     errCount++;
            //     $('input[name="name"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="name"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="name"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="name"]').removeClass('invalid');
            // }



            if(errCount==0)
            {
                var short_description= $('#create-rfq-form .add_short_description').val().length;
                if($('#create-rfq-form .add_short_description').val().length > 512)
                {
                    alert('The short description character length limit is not more than 512, your given character length is '+short_description);
                    return false;
                }

                //if (grecaptcha.getResponse()==""){
                //    jQuery('.messageContent').html('Captcha Required');
                //} else {
                    $("#page_button").click();
                //}
            }
            else
            {
                alert('Please fill all the required fields.');
                //$("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            }
        }

        function onSubmitValidation()
        {
            var errCount = 0;
            var errorClass = 'error';

            // if ($('select[name="category[]"]').val()==null || $('select[name="category[]"]').val()=="Select an option")
            // {
            //     errCount++;
            //     $('select[name="category[]"]').closest('.input-field').addClass(errorClass);
            //     $('select[name="category[]"]').addClass('invalid');
            // }
            // else
            // {
            //     $('select[name="category[]"]').closest('.input-field').removeClass(errorClass);
            //     $('select[name="category[]"]').removeClass('invalid');
            // }

            // if ($('input[name="title"]').val()=="" || $('input[name="title"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="title"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="title"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="title"]').closest('.input-field').removeClass(errorClass);
            //     $('input[name="title"]').removeClass('invalid');
            // }

            // if ($('input[name="short_description"]').val()=="" || $('input[name="short_description"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="short_description"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="short_description"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="short_description"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="short_description"]').removeClass('invalid');
            // }

            // if ($('textarea[name="full_specification"]').val()=="" || $('textarea[name="full_specification"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('textarea[name="full_specification"]').closest('.input-field').addClass(errorClass);
            //     $('textarea[name="full_specification"]').addClass('invalid');
            // }
            // else
            // {
            //     $('textarea[name="full_specification"]').closest('.input-field').removeClass(errorClass);
            //     $('textarea[name="full_specification"]').removeClass('invalid');
            // }

            // if ($('input[name="quantity"]').val()=="" || $('input[name="quantity"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="quantity"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="quantity"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="quantity"]').closest('.input-field').removeClass(errorClass);
            //     $('input[name="quantity"]').removeClass('invalid');
            // }

            // if ($('input[name="unit_price"]').val()=="" || $('input[name="unit_price"]').val()=="undefined" )
            // {
            //     errCount++;
            //     $('input[name="unit_price"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="unit_price"]').addClass('invalid');
            // }
            // else if($.isNumeric($('input[name="unit_price"]').val()) == false)
            // {
            //     errCount++;
            //     $('input[name="unit_price"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="unit_price"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="unit_price"]').closest('.input-field').removeClass(errorClass);
            //     $('input[name="unit_price"]').removeClass('invalid');
            // }

            // if ($('input[name="destination"]').val()=="" || $('input[name="destination"]').val()=="undefined")
            // {
            //     errCount++;
            //     $('input[name="destination"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="destination"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="destination"]').closest('.input-field').removeClass(errorClass);
            //     $('input[name="destination"]').removeClass('invalid');
            // }

            // if ($('select[name="payment_method"]').val()==null || $('select[name="payment_method"]').val()=="Select an option")
            // {
            //     errCount++;
            //     $('select[name="payment_method"]').closest('.input-field').addClass(errorClass);
            //     $('select[name="payment_method"]').addClass('invalid');
            // }
            // else
            // {
            //     $('select[name="payment_method"]').closest('.input-field').removeClass(errorClass);
            //     $('select[name="payment_method"]').removeClass('invalid');
            // }

            // if ($('input[name="delivery_time"]').val()=="" || $('input[name="delivery_time"]').val()=="undefined" || $('input[name="delivery_time"]').val()=="mm/dd/yyyy")
            // {
            //     errCount++;
            //     $('input[name="delivery_time"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="delivery_time"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="delivery_time"]').closest('.input-field').removeClass(errorClass);
            //     $('input[name="delivery_time"]').removeClass('invalid');
            // }

            // if ($('input[name="email"]').val()=="" && $('input[name="r_email"]').val()=="")
            // {
            //     errCount++;
            //     $('input[name="email"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="email"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="email"]').closest('.input-field').removeClass(errorClass);
            //     $('input[name="email"]').removeClass('invalid');
            // }

            // if ($('input[name="password"]').val()=="" && $('input[name="r_password"]').val()=="")
            // {
            //     errCount++;
            //     $('input[name="password"]').closest('.input-wrapper').addClass(errorClass);
            //     $('input[name="password"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="password"]').closest('.input-wrapper').removeClass(errorClass);
            //     $('input[name="password"]').removeClass('invalid');
            // }

            // if ($('input[name="email"]').val()=="" && $('input[name="name"]').val()=="")
            // {
            //     errCount++;
            //     $('input[name="name"]').closest('.input-field').addClass(errorClass);
            //     $('input[name="name"]').addClass('invalid');
            // }
            // else
            // {
            //     $('input[name="name"]').closest('.input-field').removeClass(errorClass);
            //     $('input[name="name"]').removeClass('invalid');
            // }



            if(errCount==0)
            {
                var short_description= $('#create-rfq-form .add_short_description').val().length;
                if($('#create-rfq-form .add_short_description').val().length > 512)
                {
                    alert('The short description character length limit is not more than 512, your given character length is '+short_description);
                    return false;
                }

                //if (grecaptcha.getResponse()==""){
                //    jQuery('.messageContent').html('Captcha Required');
                //} else {
                    $("#page_button").click();
                //}
            }
            else
            {
                alert('Please fill all the required fields.');
                //$("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            }


        }


        $("#create-rfq-form .add_short_description").keypress(function() {
            if($(this).val().length > 512) {
                alert('The short description character length limit is not more than 512')
            } else {
                // Disable submit button
            }
        });


        $(document).ready(function(){
            var authuser = "{{auth()->user()}}";
            if(!authuser) // this code will perform when user is not authenticate. user have to input sign-in or sign-up data.
            {
                //console.log("I am hacker");
                $('.createRfqForm').on('submit',function(e){
                    e.preventDefault();
                    var formData = new FormData(this);
                    formData.append('_token', "{{ csrf_token() }}");
                    const rfq_login_check_url = "{{route('rfq.store.with.login')}}";
                    $.ajax({
                        method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        url: rfq_login_check_url,
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(response){
                            console.log(response);
                            const rfq_app_url = "{{env('RFQ_APP_URL')}}";
                            var url = rfq_app_url+'/api/quotation';
                            var alias = response.profileAlias;
                            var flag =response.flag;
                            const sso_token = "Bearer " +response.access_token;
                            var formData = new FormData();
                            var file_data = $('input[name="rfq-documents[]"]')[0].files;
                            var files = [];
                            for (let i = 0; i < file_data.length; i++) {
                                //formData.append("files", file_data[i].files[0]);
                                formData.append("files", file_data[i]);
                            }
                            formData.append("rfq_from", 'service');

                            // var formData = new FormData();
                            // var file_data = $('input[name="rfq-documents[]"]')[0].files; // for multiple files
                            // var files = [];
                            // for (let i = 0; i < $('input[name="rfq-documents[]"]').length; i++) {
                            //     formData.append("files", $('input[name="rfq-documents[]"]')[i].files[0]);
                            // }

                            var other_data = $('.createRfqForm').serializeArray();
                            var category_id=[];
                            $("#category_id :selected").each(function() {
                                category_id.push(this.value);
                            });
                            var stringCatId=category_id.toString();
                            $.each(other_data,function(key,input){
                                if(input.name != 'category[]'){
                                    formData.append(input.name,input.value);
                                }
                            });
                            formData.append('category_id', stringCatId);
                            formData.append('_token', "{{ csrf_token() }}");
                            $.ajax({
                                method: 'post',
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: formData,
                                enctype: 'multipart/form-data',
                                url: url,
                                headers: { 'Authorization': sso_token },

                                success:function(response){
                                    var rfq_id = response.data.id;
                                    $('.loading-message').html("");
                                    $('#loadingProgressContainer').show();
                                    const msg = "Your RFQ was posted successfully.<br><br>Soon you will receive quotation from <br>Merchant Bay verified relevant suppliers.";
                                    swal("Done!", msg,"success");
                                    console.log('response: =>',response);
                                    // var redirect_url = '{{ route("new.profile.my_rfqs", ":slug") }}';
                                    // redirect_url = redirect_url.replace(':slug', alias);
                                    // window.location.href = redirect_url;
                                    if(flag == 'registration'){
                                        var redirect_url = '{{ route("front.rfqpostsuccessfulbyanonymous") }}';
                                        window.location.href = redirect_url;
                                    } else {
                                        var alias = rfq_id;
                                        var redirect_url = '{{ route("rfq.matched-suppleirs", ":slug") }}';
                                        redirect_url = redirect_url.replace(':slug', alias);
                                        window.location.href = redirect_url;

                                        // var redirect_url = '{{ route("rfq.matched-suppleirs") }}';
                                        // window.location.href = redirect_url;
                                    }
                                    //window.location.href = "{{ route('rfq.my')}}";
                                },
                                error: function(xhr, status, error)
                                    {
                                    $('.loading-message').html("");
                                    $('#loadingProgressContainer').hide();
                                    swal("Error!", error,"error");
                                    }
                            });
                        },
                        error: function(xhr, status, error)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            $("#errors").empty();
                            if(xhr.status == 400){
                                $.each(xhr.responseJSON.error, function (key, item)
                                {   $("html, body").animate({
                                        scrollTop: 0
                                    }, 500);
                                    $("#errors").append("<li class='red darken-1'>"+item+"</li>")
                                });
                            }else{
                                swal("Error!", xhr.responseJSON.error,"error");
                            }
                        }
                    });
                });


            }
            else // this code will perform when user is authenticate. data will post directly to the mongo using user access_token.
            {
                //console.log(authuser);
                $('.createRfqForm').on('submit',function(e){
                    e.preventDefault();
                    const rfq_app_url = "{{env('RFQ_APP_URL')}}";
                    var url = rfq_app_url+'/api/quotation';
                    const sso_token = "Bearer " +"{{ Cookie::get('sso_token') }}";

                    var formData = new FormData();
                    var file_data = $('input[name="rfq-documents[]"]')[0].files;
                    var files = [];
                    for (let i = 0; i < file_data.length; i++) {
                        formData.append("files", file_data[i]);
                    }

                    formData.append("rfq_from", 'service');


                    var other_data = $('.createRfqForm').serializeArray();
                    var category_id=[];
                    $("#category_id :selected").each(function() {
                        category_id.push(this.value);
                    });
                    var stringCatId=category_id.toString();

                    $.each(other_data,function(key,input){
                        if(input.name != 'category[]'){
                            formData.append(input.name,input.value);
                        }
                    });

                    formData.append('category_id', stringCatId);
                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        url: url,
                        headers: { 'Authorization': sso_token },
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(response)
                        {
                            var rfq_id = response.data.id;
                            var mailTrigger = '{{ route("rfq.mailTriggerForAuthUser") }}';
                            $.ajax({
                                method: 'post',
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: formData,
                                enctype: 'multipart/form-data',
                                url: mailTrigger,
                                beforeSend: function() {},
                                success:function(response){
                                    $('.loading-message').html("");
                                    $('#loadingProgressContainer').show();
                                    //const msg = "Your RFQ was posted successfully.<br><br>Soon you will receive quotation from <br>Merchant Bay verified relevant suppliers.";
                                    //swal("Done!", msg,"success");
                                    //console.log('response::',rfq_id);
                                    //window.location.reload;
                                    var alias = rfq_id;
                                    var redirect_url = '{{ route("rfq.matched-suppleirs", ":slug") }}';
                                    redirect_url = redirect_url.replace(':slug', alias);
                                    window.location.href = redirect_url;

                                    // var redirect_url = '{{ route("rfq.matched-suppleirs") }}';
                                    // window.location.href = redirect_url;
                                }
                            })
                        },
                        error: function(xhr, status, error)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            swal("Error!", error,"error");
                        }
                    });
                });
            }

        })

</script>
@endpush





@endsection
