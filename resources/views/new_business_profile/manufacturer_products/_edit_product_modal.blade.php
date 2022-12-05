<div id="product-edit-modal-block" class="modal profile_product_upload_modal">
    <div class="modal-content">
        <section class="ic-buying-req">
            <div class="product_add_wrap_modal">
                <div class="row">
                    <div class="title">
                        <legend>Update</legend>
                        <span style="font-size: 12px; padding-bottom: 15px; display:block;" class="text-danger">* Indicates Mandatory field</span>
                    </div>
                </div>

                <form action="" method="post" enctype="multipart/form-data" id="manufacture-product-update-form">
                    @csrf
                    <input type="hidden" name="edit_product_id">
                    <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                    {{-- product type mapping --}}
                    <div class="input_field_wrap">
                        <div class="row product_type_boxwrap">
                            <div class="col s12 m6 l4 input-field">
                                <label for="product-type">Product Category Type <span class="text-danger">*</span></label>
                                <select class="select2 browser-default product_type_select" name="product_type_mapping" >
                                    <option value="1">Studio</option>
                                    <option value="2">Raw Materials</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4 input-field">
                                <div class="product_type_infobox">
                                    <div class="studio">
                                        <label>Category Studio</label>
                                        <select class="select2 browser-default studio-id" name="studio_id[]">
                                            <option value="" selected="true" disabled>Choose your Category</option>
                                            @php $studio_child= productTypeMapping(1); @endphp
                                            @foreach ($studio_child as $id => $title)
                                                <option value={{$id}}>{{$title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text studio_id_error rm-error"></span>
                                    </div>
                                    <div class="raw-materials">
                                        <label>Category Raw Materials</label>
                                        <select class="select2 browser-default raw-materials-id" name="raw_materials_id[]">
                                            <option value="" selected="true" disabled>Choose your Category</option>
                                            @php $raw_materials_child= productTypeMapping(2); @endphp
                                            @foreach ($raw_materials_child as $id => $title)
                                                <option value={{$id}}>{{$title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text raw_materials_id_error rm-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m12 l4 input-field">
                                <label for="product_tag">Product Tags<span class="text-danger">*</span></label>
                                <div class="multiple_select_wrap">
                                    <select name="product_tag[]" class="select2 browser-default" id="edit_product_tag" multiple>
                                        @foreach($product_tags as $product_tag)
                                            <option value="{{ $product_tag->name }}">{{$product_tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="select2-selection__arrow" role="presentation"><b class="presentation_arrow" role="presentation"></b></span>
                                </div>
                                <span class="text-danger error-text product_tag_error rm-error"></span>
                            </div>
                        </div>

                        <div class="row input-field">
                            <div class="col s12">
                                <label for="producut-title">Title <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <input type="text" id="producut-title" name="title" class="form-control" placeholder="Product Title ..." >
                                <span class="text-danger error-text title_error rm-error"></span>
                            </div>
                        </div>

                        <div class="row input-field">
                            <div class="col s12">
                                <label for="producut-code">Product Code</label>
                            </div>
                            <div class="col s12">
                                <input type="text" id="producut-code" name="product_code" class="form-control" placeholder="Product Code" >
                                <span class="text-danger error-text title_error rm-error"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l6 input-field">
                                <label for="producut-quality">Price Range <span class="text-danger">*</span></label>
                                <div class="priceRange">
                                    <input type="text" name="price_per_unit" id="producut-quality" class="form-control" placeholder="ex. 5.00 - 6.00" >
                                    <span class="priceRangeUnit">
                                        <select class="select2 browser-default price_unit" name="price_unit" >
                                            <option value="" selected="true" disabled>Unit</option>
                                            <option value="BDT">BDT</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </span>
                                </div>
                                <span class="text-danger error-text price_per_unit_error rm-error"></span>
                            </div>
                            <div class="col s12 m6 l6 input-field">
                                <label for="product-moq">MOQ <span class="text-danger">*</span></label>
                                <div class="moqQuantity">
                                    <input type="number" name="moq" id="product-moq" class="form-control" placeholder="Minimum Order Quantity" >
                                    <select class="select2 browser-default qty_unit" name="qty_unit" >
                                        <option value="" selected="true" disabled>Choose your option</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Lbs">Lbs</option>
                                        <option value="Gauge">Gauge</option>
                                        <option value="Yards">Yards</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Dozens">Dozens</option>
                                    </select>
                                </div>
                                <span class="text-danger error-text moq_error rm-error"></span>
                            </div>
                        </div>

                        <div class="product_colorSizw_wrap">
                            <div class="row">
                                <div class="col s12 m6 input-field">
                                    <label for="product-colors">Color <span class="text-danger">*</span></label>
                                    <a class="waves-effect waves-light btn modal-trigger btn btn_green" href="#color-modal">Add Color</a>
                                    <div class="product_color_box multipleArrowBox">
                                        <input class="product-colors" type="text" id="picked-colors" placeholder="ex: Pentone TCX, hex color code" disabled="disabled" />
                                        <input name="colors[]" id="colors" type="hidden" />
                                        <span class="text-danger error-text colors_error rm-error"></span>
                                    </div>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <label for="product-sizes">Sizes <small>EXP: XL,XXL,...</small><span class="text-danger">*</span></label>
                                    <div class="product_size_box">
                                        <select class="select2 browser-default product-sizes" name="sizes[]" id="edit_sizes"  multiple="multiple">
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size }}">{{ ucfirst($size) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text sizes_error rm-error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-field row">
                            <div class="col s12">
                                <label for="product-desc">Product Details <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <textarea name="product_details" id="edit-description" class="form-control editor" cols="30" rows="10" placeholder="Product Details" ></textarea>
                                <span class="text-danger error-text product_details_error rm-error"></span>
                            </div>
                        </div>
                        <div class="input-field row">
                            <div class="col s12">
                                <label for="product-spec">Full specification</label>
                            </div>
                            <div class="col s12">
                                <textarea name="product_specification" id="edit_full_specification" class="form-control editor" cols="30" rows="10" placeholder="Full Specification" ></textarea>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Lead Time --}}
                            <div class="col s12 m6 l3 input-field">
                                <label for="lead_time">Lead Time <span class="text-danger">*</span></label>
                                <div class="leadTimeDays">
                                    <input type="text" name="lead_time" id="lead_time" class="form-control negitive-or-text-not-allowed" placeholder="days" >
                                    <span class="text-danger error-text lead_time_error rm-error"></span>
                                    <span class="days">Days</span>
                                </div>
                            </div>
                            {{-- gender --}}
                            <div class="col s12 m6 l3 input-field">
                                <div class="genderBox">
                                    <label for="gender">Gender<span class="text-danger">*</span></label>
                                    <span class="text-danger error-text gender_error rm-error"></span>
                                </div>
                                <select class="select2 browser-default gender_unit" name="gender">
                                    <option value="" selected="true" disabled>Select Gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Unisex</option>
                                </select>
                            </div>
                            {{-- sample availability --}}
                            <div class="col s12 m6 l3 input-field">
                                <div class="sampleAvailabilityTitle">
                                    <label for="sample_availability">Sample Availability <span class="text-danger">*</span></label>
                                    <span class="text-danger error-text sample_availability_error rm-error"></span>
                                </div>
                                <select class="select2 browser-default sample_availability" name="sample_availability">
                                    <option value="" selected="true" disabled>Select Sample Availability</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                             {{-- sample availability --}}
                             <div class="col s12 m6 l3 input-field">
                                <div class="sampleAvailabilityTitle">
                                    <label for="free_to_show">Free to Show</label>
                                </div>
                                <select class="select2 browser-default free_to_show" name="free_to_show">
                                    <option value="" selected="true" disabled>Select Free to Show</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                        </div>
                    </div>{{-- input_field_wrap --}}


                    <div class="product_upload_update_block">
                        <div class="no_more_tables">
                            <table class="product_upload_update_table">
                                <thead class="cf">
                                    <tr>
                                        <th class="uploadOverlayImage">Image</th>
                                        <th class="uploadImageLabel">Label</th>
                                        <th class="uploadImageAccessories">Is Accessories</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td data-title="Image">
                                            <div id="addImage">
                                                <div class="overlay-addImage-preview-block">
                                                    <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png" id="overlayImage" class="overlay-addImage-preview" alt="preview image">
                                                </div>
                                                <input type="hidden" name="productImg[product_image_id][]" />
                                                <div class="file-field uplodad_file_button_wrap">
                                                    <div class="btn">
                                                        <i class="material-icons">file_upload</i>
                                                        <input class="overlay-add-image" id="productaddImage" type="file" name="productImg[product_add_image][]" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-title="Image Label"><input type="text" name="productImg[product_image_label][]" value="" /></td>
                                        <td data-title="Is Accessories">
                                            <label>
                                                <input class="is_accessories_checked" type="checkbox" />
                                                <span></span>
                                                <input type="hidden" name="productImg[product_image_is_accessories][]" class="is_accessories_checked_value" value="no" />
                                            </label>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="add_more_box">
                            <a href="javascript:void(0);" class="add-more-block" onclick="addNewProductImage(this)"><i class="material-icons dp48">add</i> Add More</a>
                        </div>
                    </div>

                    {{-- <div class="row input-field product-upload-block edit-image-block" style="padding-top: 15px;">
                        <div class="col s12">
                            <label class="active">Image <span class="text-danger">*</span></label>
                        </div>
                        <div class="col s12">
                            <div class="input-images-2" style="padding-top: .5rem;"></div>
                            <div class="image-upload-message" style="font-size: 12px; color: #000; margin-top:-10px;">Minimum image size 300 X 300</div>
                            <span class="images_error text-danger error-rm"></span>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col s12 m6 l4 xl3 input-field">
                            <div class="overlay-image-div">
                                <div class="product-upload-block">
                                    <label class="active">Featured Image</label>
                                    <div class="" id="lineitems">
                                        <div class="overlay-image-preview-block">
                                            <img src="https://via.placeholder.com/80" id="overlayImage" class="overlay-image-preview" alt="preview image" style="max-height: 100px; margin-bottom: 10px">
                                        </div>
                                        <div class="remove-overlay-image"></div>
                                        <div class="file-field uplodad_file_button_wrap">
                                            <div class="btn">
                                                <span>Upload Image</span>
                                                <input  class="uplodad_video_box overlay-image" type="file" name="overlay_image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l4 xl3 input-field">
                            <label class="active">Video: </label>
                            <div class="product-upload-block">
                                <div class="edit-video-show-div">
                                    <div class="edit-video-show-block">

                                    </div>
                                </div>
                                <div class="edit-video-upload-block">
                                    <div class="" id="lineitems_video">
                                        {{-- <img class="no-video-image" src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_video_file.png" alt="" /> --}}
                                        <video id="edit-video" width="100%" height="" controls ></video>
                                    </div>
                                    <div class="file-field uplodad_video_button_wrap">
                                        <div class="btn">
                                            <span>Upload Video</span>
                                            <input id="edit-uploadVideo" class="uplodad_video_box" type="file" name="video">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="remove_video_id"  value="">
                        </div>
                    </div>

                    <div style="padding:30px 10px 0">
                        <div id="manufacture-update-errors" class="validaiton-errors" style="display: none; padding:5px 10px;"></div>
                    </div>

                    <div class="submit_btn_wrap">
                        <div class="row">
                            <div class="col s12 m6 l4 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                            <div class="col s12 m6 l8 right-align">
                                <button type="submit" class="btn_green  seller_product_create">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

</div>

<!-- Modal Structure -->
<div id="color-modal" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Product Colors</h4>
        <div class="add-product-colors">
            <table class="product_color_picker_table">
                <thead>
                    <tr>
                        <th>Color</th>
                        <th>Hexa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="product-color-item">
                        <td><input index='0' type="text" name="color_text[]" value="" onkeyup="onColorNameChange(this)"/></td>
                        <td><input index='0' type="color" name="color_hexa[]" value="" onchange="onColorSelect(this)"/></td>
                    </tr>
                </tbody>
            </table>
            <a href="javascript:void(0);" class="color-picker-save-trigger btn btn_green waves-effect waves-green">Save</a>
            <a href="javascript:void(0);" class="new-color-picker-trigger btn btn_green waves-effect waves-green" onclick="addProductColors(this)">Add More</a>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>

@push('js')
    <script>
        //add more video
        var  lineitemcontent= '<input type="file" name="videos[]"><p onclick="removeVideoEl(this);">Remove</p>';
        function addMoreVideo(obj)
            {
                $(obj).parent().append(lineitemcontent);
                // $('#lineitems').append(lineitemcontent);
            }

        function removeVideoEl(el)
        {
            $(el).prev('input').remove();
            $(el).remove();
        }

        const colors = {};
        const onColorNameChange = (e) => {
            colors[e?.attributes?.index?.value] = {'name':e?.value,'color':colors[e?.attributes?.index?.value]?.['color']||'#000000'};
        }
        const onColorSelect = (e) => {
            colors[e?.attributes?.index?.value] = {'name':colors[e?.attributes?.index?.value]?.['name']||'','color':e?.value};
        }
        const updateColorInputField = () => {
            let cols = [];
            console.log(colors);
            Object.keys(colors).map(i=>{
                if(colors[i]['name'] && colors[i]['color']){
                    cols.push(colors[i]['name']+"-"+colors[i]['color']);
                }

            })
            document.getElementById('colors').value = cols.join(',');
            document.getElementById('picked-colors').value = cols.join(',');
        }


        $(document).ready(function () {

        // //Transforms the listbox visually into a Select2.
        // $("#lstColors").select2({
        //     placeholder: "Select a Color",
        //     width: "200px"
        // });

        //Initialize the validation object which will be called on form submit.
        var validobj = $("#manufacture-product-upload-form").validate({
            onkeyup: false,
            errorClass: "myErrorClass",

            //put error message behind each form element
            errorPlacement: function (error, element) {
                var elem = $(element);
                error.insertAfter(element);
            },

            //When there is an error normally you just add the class to the element.
            // But in the case of select2s you must add it to a UL to make it visible.
            // The select element, which would otherwise get the class, is hidden from
            // view.
            highlight: function (element, errorClass, validClass) {
                var elem = $(element);
                if (elem.hasClass("select2-offscreen")) {
                    $("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
                } else {
                    elem.addClass(errorClass);
                }
            },

            //When removing make the same adjustments as when adding
            unhighlight: function (element, errorClass, validClass) {
                var elem = $(element);
                if (elem.hasClass("select2-offscreen")) {
                    $("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
                } else {
                    elem.removeClass(errorClass);
                }
            }
        });

        //If the change event fires we want to see if the form validates.
        //But we don't want to check before the form has been submitted by the user
        //initially.
        $(document).on("change", ".select2-offscreen", function () {
            if (!$.isEmptyObject(validobj.submitted)) {
                validobj.form();
            }
        });

        //A select2 visually resembles a textbox and a dropdown.  A textbox when
        //unselected (or searching) and a dropdown when selecting. This code makes
        //the dropdown portion reflect an error if the textbox portion has the
        //error class. If no error then it cleans itself up.
        $(document).on("select2-opening", function (arg) {
            var elem = $(arg.target);
            if ($("#s2id_" + elem.attr("id") + " ul").hasClass("myErrorClass")) {
                //jquery checks if the class exists before adding.
                $(".select2-drop ul").addClass("myErrorClass");
            } else {
                $(".select2-drop ul").removeClass("myErrorClass");
            }
        });
        });

        $(document).on('change','select[name=product_type_mapping]',function(){
            if ($(this).val() == 1) {
                $('.studio').show();
                $('.raw-materials').hide();
            }else if ($(this).val() == 2){
                $('.studio').hide();
                $('.raw-materials').show();
            }
        });


    </script>



@endpush
