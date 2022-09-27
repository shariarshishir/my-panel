<section class="ic-buying-req">
    <div class="product_add_wrap_modal">
        <div class="row">
            <div class="col-xs-12 title">
                <legend>Upload Product</legend>
                <span style="font-size: 12px; padding-bottom: 15px; display:block;" class="text-danger">* Indicates Mandatory field</span>
                <!-- <p>Upload your new product</p> -->
                <!-- <div class="col-md-12">
                    <div class="row">

                    </div>
                </div> -->
            </div>
        </div>
        <input type="hidden" name="edit_product_id" value="{{$product->id}}" >
        {{-- <div class="row"> --}}
        {{-- product type mapping --}}
        <div class="input-field">
            <div class="row">
                <div class="col s12 m3 l3">
                    <label for="gender">Product Type Mapping<span class="text-danger">*</span></label>
                    <span class="text-danger error-text product_type_mapping_error rm-error"></span>
                </div>
                <div class="col s12 m9 l9">
                    <div class="radio-block">
                        <label class="radio_box">
                            <input class="with-gap" name="product_type_mapping" type="radio" value="1" {{$product->product_type_mapping_id == 1 ? 'checked' : ''}}/>
                            <span>Studio</span>
                        </label>
                        <label class="radio_box">
                            <input class="with-gap" name="product_type_mapping" type="radio" value="2" {{$product->product_type_mapping_id == 2 ? 'checked' : ''}}/>
                            <span>Raw Materials</span>
                        </label>
                    </div>
                </div>
            </div>
            @php $none= 'style=display:none';@endphp
            <div class="row studio" {{$product->product_type_mapping_id == 1 ? '' : $none}} >
                <div class="col s12">
                    <label>Select studio</label>
                    <select  class="select2 dropdownOptions " multiple name="studio_id[]">
                        @php $studio_child= productTypeMapping(1); @endphp
                        @foreach ($studio_child as $id => $title)
                            <option value={{$id}} {{isset($product->product_type_mapping_child_id) &&  in_array($id, $product->product_type_mapping_child_id) ? 'selected' : ''}}>{{$title}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text studio_id_error rm-error"></span>
                </div>
            </div>
            <div class="row raw-materials" {{$product->product_type_mapping_id == 2 ? '' : $none}}>
                <div class="col s12">
                    <label>Select raw materials</label>
                    <select class="select2 dropdownOptions " multiple name="raw_materials_id[]">
                        @php $raw_materials_child= productTypeMapping(2); @endphp
                        @foreach ($raw_materials_child as $id => $title)
                            <option value={{$id}} {{isset($product->product_type_mapping_child_id) &&  in_array($id, $product->product_type_mapping_child_id) ? 'selected' : ''}}>{{$title}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text raw_materials_id_error rm-error"></span>
                </div>
            </div>
        </div>



        <div class="form-group row input-field">
            <div class="col s12 m3 l3">
                <label for="product_tag">Product Tag <span class="text-danger">*</span></label>
            </div>
            <div class="col s12 m9 l9">
                <select name="product_tag[]" class="select2 browser-default" id="product_tag" multiple>
                    @foreach($product_tags as $product_tag)
                        <option value="{{ $product_tag->name }}" {{isset($product->product_tag) &&  in_array($product_tag->name, $product->product_tag) ? 'selected' : ''}}>{{ucwords($product_tag->name)}}</option>
                    @endforeach
                </select>
                <span class="text-danger error-text product_tag_error rm-error"></span>
            </div>
        </div>
        {{-- <div class="row input-field">
            <div class="col s12 m3 l3">
                <label for="product-cat" class="select-icon">Product subcategory</label>
            </div>
            <div class="col s12 m9 l9">
                <select class="form-control appearance-none" name="product_subcategory_id" id="product_subcategory"></select>
            </div>
        </div>
        </div> --}}

        <div class="row input-field">
            <div class="col s12 m3 l3">
                <label for="producut-title">Title <span class="text-danger">*</span></label>
            </div>
            <div class="col s12 m9 l9">
                <input type="text" id="producut-title" name="title" value="{{$product->title}}" class="form-control" placeholder="Product Title ..." >
                <span class="text-danger error-text title_error rm-error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6 input-field">
                <div class="col s12">
                    <label for="producut-quality">Price Range <span class="text-danger">*</span></label>
                </div>
                <div class="col s12">
                    <input type="text" name="price_per_unit" value="{{$product->price_per_unit}}" id="producut-quality" class="form-control" placeholder="ex. 5.00 - 6.00">
                    <span class="text-danger error-text price_per_unit_error rm-error"></span>
                </div>
            </div>
            <div class="col s12 m6 l6 input-field">
                <div class="col s12">
                    <label for="price_unit">Price Unit <span class="text-danger">*</span></label>
                </div>
                <div class="col s12">
                    <select class="select2 browser-default price_unit" name="price_unit">
                        <option value="BDT" {{($product->price_unit == 'BDT') ? 'selected' : ''}}>BDT</option>
                        <option value="USD" {{($product->price_unit == 'USD') ? 'selected' : ''}}>USD</option>
                    </select>
                    <span class="text-danger error-text price_unit_error rm-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6 input-field">
                <div class="col s12">
                    <label for="product-moq">MOQ <span class="text-danger">*</span></label>
                </div>
                <div class="col s12">
                    <input type="number" name="moq" value="{{ $product->moq }}" id="product-moq" class="form-control" placeholder="Minimum Order Quantity">
                    <span class="text-danger error-text moq_error rm-error"></span>
                </div>
            </div>
            <div class="col s12 m6 l6 input-field">
                <div class="col s12">
                    <label for="qty_unit">Qty Unit <span class="text-danger">*</span></label>
                </div>
                <div class="col s12">
                    <select class="select2 browser-default qty_unit" name="qty_unit">
                        <option value="Pcs" {{($product->qty_unit == 'Pcs') ? 'selected' : ''}}>Pcs</option>
                        <option value="Lbs" {{($product->qty_unit == 'Lbs') ? 'selected' : ''}}>Lbs</option>
                        <option value="Gauge" {{($product->qty_unit == 'Gauge') ? 'selected' : ''}}>Gauge</option>
                        <option value="Yards" {{($product->qty_unit == 'Yards') ? 'selected' : ''}}>Yards</option>
                        <option value="Kg" {{($product->qty_unit == 'Kg') ? 'selected' : ''}}>Kg</option>
                        <option value="Meter" {{($product->qty_unit == 'Meter') ? 'selected' : ''}}>Meter</option>
                        <option value="Dozens" {{($product->qty_unit == 'Dozens') ? 'selected' : ''}}>Dozens</option>
                    </select>
                    <span class="text-danger error-text qty_unit_error rm-error"></span>
                </div>
            </div>
        </div>

        <div class="row input-field">
            <div class="col s12 m3 l3">
                <label for="product-colors">Colors <small>EXP: Red,Blue,...</small> </label>
            </div>
            <div class="col s12 m9 l9">
                <select class="select2 browser-default product-colors" name="colors[]" multiple>

                        @foreach ($colors as $color)
                            <option value="{{ $color }}" {{isset($product->sizes) && (in_array($color, $product->colors))?'selected':'' }}>{{ ucfirst($color) }}</option>
                        @endforeach

                </select>
                <span class="text-danger error-text colors_error rm-error"></span>
            </div>
        </div>
        <div class="row input-field">
            <div class="col s12 m3 l3">
                <label for="product-sizes">Sizes <small>EXP: XL,XXL,...</small> </label>
            </div>
            <div class="col s12 m9 l9">
                <select class="select2 browser-default product-sizes" name="sizes[]"  multiple="multiple">

                        @foreach ($sizes as $size)
                                <option value="{{ $size }}" {{ isset($product->sizes) && (in_array($size, $product->sizes))?'selected':'' }}>{{ ucfirst($size) }}</option>
                        @endforeach

                </select>
                <span class="text-danger error-text sizes_error rm-error"></span>
            </div>
        </div>
        <div class="row input-field">
            <div class="col s12 m3 m3">
                <label for="product-desc">Product Details <span class="text-danger">*</span></label>
            </div>
            <div class="col s12 m9 l9">
                <textarea name="product_details" id="product-desc" class="form-control editor" cols="30" rows="10" placeholder="Product Details" >{!! $product->product_details !!}</textarea>
                <span class="text-danger error-text product_details_error rm-error"></span>
            </div>
        </div>
        <div class="row input-field">
            <div class="col s12 m3 l3">
                <label for="product-spec">Full specification <span class="text-danger">*</span></label>
            </div>
            <div class="col s12 m9 l9">
                <textarea name="product_specification" id="product-spec" class="form-control editor" cols="30" rows="10" placeholder="Full Specification" >{!! $product->product_specification !!}</textarea>
                <span class="text-danger error-text product_specification_error rm-error"></span>
            </div>
        </div>
        <div class="row input-field">
            <div class="col s12 m3 l3">
                <label for="lead_time">Lead time (days) <span class="text-danger">*</span></label>
            </div>
            <div class="col s12 m9 l9">
                <input type="text" name="lead_time" value="{{ $product->lead_time }}" id="lead_time" class="form-control negitive-or-text-not-allowed" placeholder="days">
                <span class="text-danger error-text lead_time_error rm-error"></span>
            </div>
        </div>

        {{-- gender --}}
        <div class="row input-field ">
            <div class="col s12 m3 l3">
                <label for="gender">Gender<span class="text-danger">*</span></label>
                <span class="text-danger error-text gender_error rm-error"></span>
            </div>
            <div class="col s12 m9 l9">
                <div class="radio-block">
                    <label class="radio_box">
                        <input class="with-gap" name="gender" type="radio" value="1" {{$product->gender == 1 ? 'checked' : ''}} />
                        <span>Male</span>
                    </label>
                    <label class="radio_box">
                        <input class="with-gap" name="gender" type="radio" value="2"  {{$product->gender == 2 ? 'checked' : ''}}/>
                        <span>Female</span>
                    </label>
                    <label class="radio_box">
                        <input class="with-gap" name="gender" type="radio" value="3" {{$product->gender == 3 ? 'checked' : ''}}/>
                        <span>Unisex</span>
                    </label>
                </div>
            </div>
        </div>
        {{-- sample availability --}}
        <div class="row input-field ">
            <div class="col s12 m3 l3">
                <label for="sample_availability">Sample Availability <span class="text-danger">*</span></label>
                <span class="text-danger error-text sample_availability_error rm-error"></span>
            </div>
            <div class="col s12 m9 l9">
                <div class="radio-block">
                    <label class="radio_box">
                        <input class="with-gap" name="sample_availability" type="radio" value="1" {{$product->sample_availability == 1 ? 'checked' : ''}}/>
                        <span>Yes</span>
                    </label>
                    <label class="radio_box">
                        <input class="with-gap" name="sample_availability" type="radio" value="0" {{$product->sample_availability == 0 ? 'checked' : ''}}/>
                        <span>No</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="product_media_wrap row">
            <div class="col s12 input-field">
                <label for="product-upload">
                    <span>Media</span><span class="text-danger">*</span>
                </label>
            </div>
            <div class="center-align row profile_edit_img">
                @foreach($product->product_images as $key => $product_image)
                    <!--1-->
                    <div class="col s6 m2 l2 center-align">
                        <div class="media_img">
                            <img src="{{Storage::disk('s3')->url('public/'.$product_image->product_image)}}" id="img{{ $product_image->id }}" class="img-thumbnail">
                        </div>
                        <div class="clear10"></div>
                        <div class="col s12">
                            <div id="msg"></div>
                            <input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'img{{ $product_image->id }}')" />
                            <div class="input-group my-3" style="display:block;">
                                <input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;" />
                                <div class="input-group-append">
                                    <a href="javascript:void(0);" dataid="{{$product_image->id}}" onclick="removeManufactureImage(this);">remove</a>
                                    <button type="button" class="browse btn btn-search btn-default btn-upload-wholesaler-img" style="background:#55A860; color:#fff; display:none;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($key == 4) @break @endif
                    <!--/1-->
                @endforeach
                @if(count($product->product_images) < 5)
                    @for($i = 1; $i <= (5 - count($product->product_images)); $i++)
                        @php $rand = rand();@endphp
                        <div class="col s6 m2 l2 center-align">
                            <div class="media_img">
                                <img src="https://via.placeholder.com/80" id="img{{ $rand }}" class="img-thumbnail">
                            </div>
                            <div class="clear10"></div>
                            <div class="col s12">
                            <div id="msg"></div>
                                <input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'img{{ $rand }}')" />
                                <div class="input-group my-3" style="display:block;">
                                    <input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;" />
                                    <div class="input-group-append">
                                        <button type="button" class="browse btn btn-search btn-default" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif

            </div>

            <div class="overlay-image-div">
                <div class="row input-field product-upload-block">
                    <div class="col s12 m3 l3">
                        <label class="active">Overlay Image:</label>
                    </div>
                    <div class="col s12 m9 l9" id="lineitems">
                        <div class="overlay-image-preview-block overlay-img-div">
                            @if( $product->overlay_image )
                                <a href="javascript:void(0);" class="btn_delete rm-overlay-btn" onclick="removeManufactureOverlayImage({{$product->id}});"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a>
                                <img class="overlay-image-preview" src="{{Storage::disk('s3')->url('public/'.$product->overlay_image)}}"
                                alt="preview image" style="max-height: 150px;">
                            @else
                                <img class="overlay-image-preview" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                alt="preview image" style="max-height: 100px; margin-bottom: 10px;">
                            @endif
                        </div>
                        <input class="uplodad_video_box overlay-image" type="file" name="overlay_image">
                    </div>
                </div>
            </div>

            @if($product->product_video)

                <div class="row input-field video_upload_block">
                    <div class="col s12 m3 l3">
                        <label class="active">Video: </label>
                    </div>
                    <div class="col s12 m9 l9">
                        <div class="edit-video-show-block">
                            <video controls autoplay height="240" width="340"><source src="{{Storage::disk('s3')->url('public/video/'.$product->businessProfile->business_name.'/'.$product->product_video->video)}}" /></video><a class="btn_delete" onclick="manufactureRemoveEditVideoEl(this)" data-id="{{$product->product_video->id}}"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a>
                        </div>
                    </div>
                </div>

                    <!-- <div>
                        <center>
                            <video controls autoplay height="240" width="340"><source src="{{asset('storage/'.$product->product_video->video)}}" /></video><p onclick="manufactureRemoveEditVideoEl(this)" data-id="{{$product->product_video->id}}">remove</p>
                        </center>
                    </div> -->
            @endif
             {{-- video --}}
             <div class="row input-field manufacture-product-upload-block"  {{$product->product_video ? 'style=display:none' :'' }}>
                <div class="col s12 m3 l3">
                    <label class="active">Video:</label>
                </div>
                <div class="col s12 m9 l9" id="lineitems">
                    <input class="uplodad_video_box" type="file" name="video">
                </div>
            </div>
            <!-- <div class="col s12 submit_wrap right-align">
                <button type="submit" class="btn waves-effect waves-light green seller_product_create btn_green">Update</button>
                <button type="button" class="btn modal-close waves-effect waves-light green btn-back-to-product-list btn_green">Cancel</button>
            </div> -->
            <div id="manufacture-update-errors" style="display: none;"></div>
            <div class="submit_btn_wrap">
                <div class="row">
                    <div class="col s12 m6 l4 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                    <div class="col s12 m6 l8 right-align">
                        <button type="submit" class="seller_product_create btn_green">Update</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


