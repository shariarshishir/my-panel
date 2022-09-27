<div id="create-rfq-form" class="modal rfq_detail_from_wrap">
    <div class="modal-content">
        <section class="ic-buying-req">
            <div class="product_add_wrap_modal">
                <!-- <div class="col-md-12 my-prd-hd-cont">
                    <div class="row">
                        <div class="col-md-12 plr0">
                            <h5 class="my-prd-hd">Request For Quote</h5>
                            <p>Submit Your Request for Quotation and let Merchant Bay source the best Supplier for you</p>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-12">
                    <div class="row">
                        <span style="font-size: 12px; color: rgb(255, 0, 0); padding-bottom: 15px; display:block;">* Indicates Mandatory field</span>
                    </div>
                </div>
                <!--Add Product Form-->
                <form action="#" class="createRfqForm " method="post" enctype="multipart/form-data">
                    <div class="rfq_detail_from">
                        <!--3-->
                        <div class="row input-field input-wrapper">
                            <div class="col s12">
                                <label>Select Product Tags <span >*</span></label>
                            </div>
                            <div class="col s12">
                                <select class="select2 browser-default" id="category_id" name="category[]"  required multiple >
                                    @foreach($product_tags as $product_tag)
                                        <option value="{{ $product_tag->id }}">{{ $product_tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row input-field input-wrapper">
                            <div class="col s12">
                                <label>Title <span>*</span></label>
                            </div>
                            <div class=" col s12 m8 l9">
                                <input type="text" class="form-control- ig-new-rgt" name="title" required/>
                            </div>
                        </div>

                        <div class="row input-field input-wrapper">
                            <div class="col s12">
                                <label>Short Description <span>*</span></label>
                            </div>
                            <div class=" col s12">
                                <textarea required class="ig-new-rgt prd-txta short_description add_short_description" style="height:88px;" name="short_description"></textarea>
                            </div>
                        </div>
                        <div class="row input-field input-wrapper">
                            <div class="col s12">
                                <label>Full Description <span>*</span></label>
                            </div>
                            <div class=" col s12">
                                <textarea class="ig-new-rgt prd-txta" style="height:88px;" name="full_specification"></textarea>
                            </div>
                        </div>

                        <div class="inpuboxt_group_wrap">
                            <div class="row">
                                <div class="col s12 m12 l6">
                                    <div class="input-field row input-wrapper">
                                        <div class="col s12">
                                            <label>Quantity <span>*</span></label>
                                        </div>
                                        <div class="col s12">
                                            <input type="number" class="form-control- ig-new-rgt" name="quantity" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col s12 m12 l6">
                                    <div class="input-field row input-wrapper">
                                        <div class="col s12">
                                            <label>Select Unit <span>*</span></label>
                                        </div>
                                        <div class="col s12">
                                            <select class="select2" name="unit" id="unit">
                                                <option value="">Select an option</option>
                                                @php $units = units(); @endphp
                                                @foreach($units as $unit=>$value)
                                                    <option value="{{$unit}}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l6">
                                    <div class="input-field row input-wrapper">
                                        <div class="col s12">
                                            <label>Target Price <span>*</span></label>
                                        </div>
                                        <div class="col s12">
                                            <input type="text" class="form-control- ig-new-rgt" id="target_price" name="unit_price" required onchange="allowTwoDecimal()" />
                                        </div>
                                    </div>
                                </div>
                                <div class=" col s12 m12 l6">
                                    <div class="input-field row input-wrapper">
                                        <div class="col s12">
                                            <label>Destination <span>*</span></label>
                                        </div>
                                        <div class="col s12">
                                            <input type="text" class="form-control- ig-new-rgt" name="destination" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l6">
                                    <div class="input-field row input-wrapper">
                                        <div class="col s12">
                                            <label>Select Payment Method <span>*</span></label>
                                        </div>
                                        <div class="col s12">
                                            <select class="select2" name="payment_method" id="payment_method" required>
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
                                </div>
                                <div class=" col s12 m12 l6">
                                    <div class="input-field row input-wrapper">
                                        <div class="col s12">
                                            <label>Expected Delivery Time <span>*</span></label>
                                        </div>
                                        <div class="col s12">
                                            <input type="date" class="form-control- ig-new-rgt" name="delivery_time" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row rfq_img_upload_wrap">
                            <div class="rfq_thumbnail_box">
                                <div class="thumbnail_img">
                                  <img src="https://via.placeholder.com/380" class="img-thumbnail" id="img1">
                                </div>
                                <div class="upload_img_box center-align">
                                    <div id="msg"></div>
                                    <input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'img1')">
                                    <div class="input-group my-3" style="display:block;">
                                      <input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;">
                                      <div class="input-group-append">
                                        <button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!--/1-->

                            <!--2-->
                            <div class="rfq_thumbnail_box">
                                <div class="thumbnail_img">
                                  <img src="https://via.placeholder.com/380" class="img-thumbnail" id="img2">
                                </div>
                                <div class="upload_img_box center-align">
                                    <div id="msg"></div>
                                    <input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'img2')">
                                    <div class="input-group my-3" style="display:block;">
                                      <input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;">
                                      <div class="input-group-append">
                                        <button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!--/2-->

                            <!--3-->
                            <div class="rfq_thumbnail_box">
                                <div class="thumbnail_img">
                                  <img src="https://via.placeholder.com/380" class="img-thumbnail" id="img3">
                                </div>
                                <div class="upload_img_box center-align">
                                    <div id="msg"></div>
                                    <input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'img3')">
                                    <div class="input-group my-3" style="display:block;">
                                      <input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;">
                                      <div class="input-group-append">
                                        <button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!--/3-->

                            <!--4-->
                            <div class="rfq_thumbnail_box">
                                <div class="thumbnail_img">
                                  <img src="https://via.placeholder.com/380" class="img-thumbnail" id="img4">
                                </div>
                                <div class="upload_img_box center-align">
                                    <div id="msg"></div>
                                    <input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'img4')">
                                    <div class="input-group my-3" style="display:block;">
                                      <input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;">
                                      <div class="input-group-append">
                                        <button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!--/4-->

                            <!--5-->
                            <div class="rfq_thumbnail_box">
                                <div class="thumbnail_img">
                                  <img src="https://via.placeholder.com/380" class="img-thumbnail" id="img5">
                                </div>
                                <div class="upload_img_box center-align">
                                    <div id="msg"></div>
                                    <input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'img5')">
                                    <div class="input-group my-3" style="display:block;">
                                      <input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;">
                                      <div class="input-group-append">
                                        <button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!--/5-->



                        </div>

                        <input type="hidden" name="captcha_token" id="captcha_token" value="">
                        <div class="clear30"></div>
                        <div class="ic-form-btn ic-buying-req-btn text-center" style="margin-top: 0px; margin-bottom: 14px;">

                        <div class="captchaContent" style="margin-top: 20px; margin-bottom: 15px;">
                            <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G" data-callback="getCaptchaResponse"></div>
                            <div class="messageContent" style="color: red; text-align: left;"></div>
                        </div>

                            {{-- <button type="button" class="btn-red mr15" onclick="location.reload();">
                                <i aria-hidden="true" class="fa fa-times-circle fa-lg"></i>&nbsp;&nbsp;Cancel
                            </button> --}}



                            <!-- <button type="button" class="btn-green" onclick="onSubmit()">
                                <i aria-hidden="true" class="fa fa-check-circle fa-lg" style="padding-right: 6px; line-height: 18px;"></i>Submit
                            </button> -->

                            <button type="submit" id="page_button" style="display: none;"></button>

                            <div class="submit_btn_wrap" style="padding-top: 30px;">
                                <div class="row">
                                    <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                                    <div class="col s12 m6 l6 right-align">
                                        <button class="btn waves-effect waves-light btn_green" type="button" name="action" onclick="onSubmit()">Submit</button>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="clear20"></div>
                        <!--/8-->


                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div> -->
</div>


@push('js')
     <script type="text/javascript">

        function allowTwoDecimal() {
            var num = $("#target_price").val();
            value = parseFloat(num).toFixed(2);
            $("#target_price").val(value);
            //console.log(value);
        }

        function readURL(input,id)
        {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
            $('#'+id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
        }

        function onSubmit()
        {
            var errCount = 0;
            var errorClass = 'error';

            if ($('#category_id').val()==null || $('#category_id').val()=="Select an option")
            {
                errCount++;
                $('#category_id').closest('.input-wrapper').addClass(errorClass);
                $('#category_id').addClass('invalid');
            }
            else
            {
                $('#category_id').closest('.input-wrapper').removeClass(errorClass);
                $('#category_id').removeClass('invalid');
            }

            if ($('input[name="title"]').val()=="" || $('input[name="title"]').val()=="undefined")
            {
                errCount++;
                $('input[name="title"]').closest('.input-wrapper').addClass(errorClass);
                $('input[name="title"]').addClass('invalid');
            }
            else
            {
                $('input[name="title"]').closest('.input-wrapper').removeClass(errorClass);
                $('input[name="title"]').removeClass('invalid');
            }

            if ($('input[name="quantity"]').val()=="" || $('input[name="quantity"]').val()=="undefined")
            {
                errCount++;
                $('input[name="quantity"]').closest('.input-wrapper').addClass(errorClass);
                $('input[name="quantity"]').addClass('invalid');
            }
            else
            {
                $('input[name="quantity"]').closest('.input-wrapper').removeClass(errorClass);
                $('input[name="quantity"]').removeClass('invalid');
            }

            if ($('input[name="unit_price"]').val()=="" || $('input[name="unit_price"]').val()=="undefined")
            {
                errCount++;
                $('input[name="unit_price"]').closest('.input-wrapper').addClass(errorClass);
                $('input[name="unit_price"]').addClass('invalid');
            }
            else
            {
                $('input[name="unit_price"]').closest('.input-wrapper').removeClass(errorClass);
                $('input[name="unit_price"]').removeClass('invalid');
            }

            if ($('input[name="destination"]').val()=="" || $('input[name="destination"]').val()=="undefined")
            {
                errCount++;
                $('input[name="destination"]').closest('.input-wrapper').addClass(errorClass);
                $('input[name="destination"]').addClass('invalid');
            }
            else
            {
                $('input[name="destination"]').closest('.input-wrapper').removeClass(errorClass);
                $('input[name="destination"]').removeClass('invalid');
            }

            if ($('select[name="payment_method"]').val()==null || $('select[name="payment_method"]').val()=="Select an option")
            {
                errCount++;
                $('select[name="payment_method"]').closest('.input-wrapper').addClass(errorClass);
                $('select[name="payment_method"]').addClass('invalid');
            }
            else
            {
                $('select[name="payment_method"]').closest('.input-wrapper').removeClass(errorClass);
                $('select[name="payment_method"]').removeClass('invalid');
            }

            if ($('input[name="delivery_time"]').val()=="" || $('input[name="delivery_time"]').val()=="undefined" || $('input[name="delivery_time"]').val()=="mm/dd/yyyy")
            {
                errCount++;
                $('input[name="delivery_time"]').closest('.input-wrapper').addClass(errorClass);
                $('input[name="delivery_time"]').addClass('invalid');
            }
            else
            {
                $('input[name="delivery_time"]').closest('.input-wrapper').removeClass(errorClass);
                $('input[name="delivery_time"]').removeClass('invalid');
            }

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

</script>
@endpush
