
<div id="product-edit-modal-block" class="modal fullscreen-modal profile_form_modal profile_product_upload_modal">
    <div class="modal-content">

            <legend>Edit Product</legend>
            {{-- <legend class="edit_product_box">
                <span>Edit Product</span>
                <a href="" class="profileView" target="_blank" ><i class="material-icons">visibility</i></a>
            </legend> --}}
            <span style="font-size: 12px; padding-bottom: 15px; display:block;" class="text-danger">* Indicates Mandatory field</span>
            <!-- <div class="col-md-12">
                <div class="row">

                </div>
            </div> -->
            <form method="POST" action="javascript:void(0);" enctype="multipart/form-data" id="seller_product_form_update">
                @method('PUT')
                @csrf
                @if ($errors->any())
                    <div class="card-alert card red">
                        <div class="card-content white-text card-with-no-padding">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="wholesaler_edit_product_form">
                    <div class="input_field_wrap">
                        <div class="row product_type_boxwrap">
                            <div class="col s12 m6 l4 input-field">
                                <label for="product_type_mapping">Product Category Type <span class="text-danger">*</span></label>
                                <select class="select2 browser-default product_type_select" id="studio-selected" name="product_type_mapping" >
                                    <option class="selected" value="" selected="true" disabled>Choose your option</option>
                                    <option value="1">Studio</option>
                                    <option value="2">Raw Materials</option>
                                </select>
                                <span class="product_type_mapping_error text-danger error-rm"></span>
                            </div>
                            <div class="col s12 m6 l4 input-field">
                                <div class="product_type_infobox">
                                    <div class="studio">
                                        <label>Select studio</label>
                                        <select class="select2 browser-default studio-id" name="studio_id[]">
                                            <option value="" selected="true" disabled>Choose your Category</option>
                                            @php $studio_child= productTypeMapping(1); @endphp
                                            @foreach ($studio_child as $id => $title)
                                                <option value={{$id}}>{{$title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="studio_id_error text-danger error-rm"></span>
                                    </div>
                                    <div class="raw-materials" >
                                        <label>Select raw materials</label>
                                        <select class="select2 browser-default raw-materials-id" name="raw_materials_id[]">
                                            <option value="" selected="true" disabled>Choose your Category</option>
                                            @php $raw_materials_child= productTypeMapping(2); @endphp
                                            @foreach ($raw_materials_child as $id => $title)
                                                <option value={{$id}}>{{$title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="raw_materials_id_error text-danger error-rm"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m12 l4 input-field">
                                <label for="edit_product_tag">Product Tag<span class="text-danger">*</span></label>
                                <div class="multiple_select_wrap">
                                    <select name="product_tag[]" class="select2 browser-default " id="edit_product_tag" multiple>
                                        @foreach($product_tags as $product_tag)
                                            <option value="{{$product_tag->name}}">{{$product_tag->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text product_tag_err"></span>
                                    <span class="product_tag_error text-danger error-rm"></span>
                                    <span class="select2-selection__arrow" role="presentation"><b class="presentation_arrow" role="presentation"></b></span>
                                </div>
                            </div>
                        </div>{{-- product_type_boxwrap --}}
                        <div class="row input-field">
                            <div class="col s12">
                                <label for="p-edit-name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <input id="p-edit-name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus >
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="name_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="row input-field">
                            <div class="col s12">
                                <label for="p-edit-code" class="col-md-4 col-form-label text-md-right">{{ __('Product Code') }}</label>
                            </div>
                            <div class="col s12">
                                <input id="p-edit-code" type="text" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{ old('product_code') }}"  autocomplete="product_code" autofocus >
                                @error('product_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="product_code_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="input-field row">
                            <div class="col s12">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <textarea id="edit-description" class="editor edit-description" name="description" >{{old('description')}}</textarea>
                                <span class="description_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="input-field row">
                            <div class="col s12">
                                <label for="additional_description" class="col-md-4 col-form-label text-md-right">{{ __('Additional Description') }}</label>
                            </div>
                            <div class="col s12">
                                <textarea id="edit-additional-description" class="editor edit-additional-description" name="additional_description" >{{old('additional_description')}}</textarea>
                            </div>
                        </div>


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

                        <!--div class="row input-field product-upload-block edit-image-block" style="padding-top: 15px;">
                            <div class="col s12">
                                <label class="active">Image <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <div class="input-images-2" style="padding-top: .5rem;"></div>
                                <div class="image-upload-message" style="font-size: 12px; color: #000; margin-top:-10px;">Minimum image size 300 X 300</div>
                                <span class="images_error text-danger error-rm"></span>
                            </div>
                        </div-->

                        <div class="row" style="padding: 10px 0 20px;">
                            <div class="col s12 m6 l4 xl3 input-field">
                                <div class="overlay-image-div">
                                    <div class="product-upload-block">
                                        <label class="active">Featured Image</label>
                                        <div class="" id="lineitems">
                                            <div class="overlay-image-preview-block">
                                                <div class="remove-overlay-image">

                                                </div>
                                                <img class="overlay-image-preview" src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png"
                                                alt="preview image" style="max-height: 100px; margin-bottom: 10px;">
                                            </div>
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
                                <label class="active">Video</label>
                                <div class="product-upload-block">
                                    <div class="edit-video-show-div">
                                        <div class="edit-video-show-block">

                                        </div>
                                    </div>
                                    <div class="edit-video-upload-block">
                                        <div id="lineitems_video">
                                            {{-- <div class="video-image-preview-block">
                                                <video id="editvideo" width="100%" height="" controls ></video>
                                            </div>
                                            <div class="file-field uplodad_file_button_wrap">
                                                <div class="btn">
                                                    <span>Upload Image</span>
                                                    <input id="edituplodadVideo" type="file" accept="video/*" class="uplodad_video_box" name="video">
                                                </div>
                                            </div> --}}
                                            <div class="video-image-preview-block">
                                                <video id="edit-video" width="100%" height="" controls ></video>
                                            </div>
                                            <div class="file-field uplodad_file_button_wrap">
                                                <div class="btn">
                                                    <span>Upload Video</span>
                                                    <input id="edit-uploadVideo" type="file" accept="video/*" class="uplodad_video_box" name="video">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="remove_video_id"  value="">
                            </div>

                        </div>{{-- Featured Image & Video --}}
                    </div>{{-- input_field_wrap --}}

                    <div class="product-details-block">
                        <div class="row input-field">
                            <div class="col s12 m6 l3 input-field">
                                <label for="product_type">{{ __('Product Type') }} <span class="text-danger">*</span></label>
                                <select class="select2 browser-default product_type_order" name="product_type" >
                                    <option value="" selected="true" disabled>Choose your option</option>
                                    <option value="1">Fresh Order</option>
                                    <option value="2">Ready Stock</option>
                                    <option value="3">Non Clothing Item</option>
                                </select>
                            </div>
                            {{-- gender --}}
                            <div class="col s12 m6 l3 input-field">
                                <label for="gender">Gender<span class="text-danger">*</span></label>
                                <select class="select2 browser-default product_type_gender" name="gender" >
                                    <option value="" selected="true" disabled>Choose your option</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Unisex</option>
                                </select>
                                <span class="gender_error text-danger error-rm"></span>
                            </div>
                            {{-- sample availability --}}
                            <div class="col s12 m6 l3 input-field">
                                <label for="sample_availability">Sample Availability <span class="text-danger">*</span></label>
                                <select class="select2 browser-default type_sample_availability" name="sample_availability" >
                                    <option value="" selected="true" disabled>Choose your option</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <span class="sample_availability_error text-danger error-rm"></span>
                            </div>
                            <div class="col s12 m6 l3 input-field">
                                <label for="free_to_show">Free to Show</label>
                                <select class="select2 browser-default free_to_show_yes" name="free_to_show" >
                                    <option value="" selected="true" disabled>Choose Free To Show</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="fresh-rtd-attr">
                            <div class="row input-field">
                                <div class="col s12">
                                    <legend>Prices Breakdown <span class="text-danger">*</span></legend>
                                </div>
                                <div class="col s12">
                                    <div class="prices-breakdown-block">
                                        <div class="no_more_tables">
                                            <table class="fresh-order-attribute-table-block">
                                                <thead>
                                                    <tr>
                                                        <th>Qty Min</th>
                                                        <th>Qty Max</th>
                                                        <th>Price (usd)</th>
                                                        <th>Lead Time (days)</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fresh-attr-tbody">
                                                </tbody>
                                            </table>
                                            <div class="add_more_box">
                                                <a href="javascript:void(0);" class="add-more-block" onclick="addFreshOrderAttribute(this)"><i class="material-icons dp48">add</i> Add More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row input-field copyright-price">
                                <div class="col s12">
                                    <label for="copyright-price" class="col-md-4 col-form-label text-md-right">Copyright Price</label>
                                </div>
                                <div class="col s12">
                                    <input type="text" name="copyright_price" class="copyright_price_edit_val negitive-or-text-not-allowed" onchange="allowTwoDecimal('.copyright_price_edit_val')" />
                                </div>
                            </div>
                            <div class="row input-field">
                                {{-- customize --}}
                                <div class="col s12">
                                    <label>
                                        <input name="customize" type="checkbox" {{old('customize')=='on'? 'checked' : " "}} />
                                        <span>{{ __('Can be Customizable') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="ready-rtd-attr">
                            <div class="col-md-12" id="color-size-block">
                                <div class="row input-field">
                                    <div class="col s12">
                                        <legend>Available Size & Colors <span class="text-danger">*</span></legend>
                                    </div>
                                    <div class="col s12">
                                        <div class="color-and-size-block">
                                            <div class="no_more_tables">
                                                <table class="color-size-table-block striped edit-color-sizes">
                                                    <thead>
                                                        <tr>
                                                            <th>Color</th>
                                                            <th>XXS</th>
                                                            <th>XS</th>
                                                            <th>Small</th>
                                                            <th>Medium</th>
                                                            <th>Large</th>
                                                            <th>Extra Large</th>
                                                            <th>XXL</th>
                                                            <th>XXXL</th>
                                                            <th>4XXL</th>
                                                            <th>5XXL</th>
                                                            <th>6XXL</th>
                                                            <th>One Size</th>
                                                            <!-- <th>&nbsp;</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ready-attr-tbody-colors-sizes">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="add_more_box" >
                                                <a href="javascript:void(0);" class="add-more-block" onclick="addProductColorSize()"><i class="material-icons dp48">add</i> Add More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- full stock --}}
                            <div class="row input-field">
                                <div class="col s12">
                                    <label>
                                        <input name="full_stock" type="checkbox" {{old('full_stock')=='on'? 'checked' : " "}} />
                                        <span>{{ __('Sell full stock only') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="full-stock-price" style="display: none">
                                <div class="row input-field full-stock-price-block">
                                    <div class="col s12">
                                        <label for="full_stock_price" class="col-md-4 col-form-label text-md-right">Full Stock Price <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col s12">
                                        <input id="full_stock_price" type="number" step=".01" class="form-control @error('full_stock_price') is-invalid @enderror" name="full_stock_price" value="{{ old('full_stock_price') }}"  autocomplete="full_stock_price" autofocus>
                                        <span class="full_stock_price_error text-danger error-rm"></span>
                                    </div>
                                </div>
                                <div class="row input-field">
                                    <div class="col s12">
                                        <label>
                                            <input name="ready_full_stock_negotiable" type="checkbox" {{old('ready_full_stock_negotiable')=='on'? 'checked' : " "}} />
                                            <span>{{ __('Price can be Negotiable') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- end full stock --}}
                            <div class="row input-field ready-stock-prices-breakdown">
                                <div class="col s12">
                                    <legend>Prices Breakdown <span class="text-danger">*</span></legend>
                                </div>
                                <div class="col s12">
                                    <div class="prices-breakdown-block">
                                        <div class="no_more_tables">
                                            <table class="ready-order-attribute-table-block striped">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>Qty Min</th>
                                                        <th>Qty Max</th>
                                                        <th>Price (usd)</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody class='ready-attr-tbody'>
                                                </tbody>
                                            </table>
                                            <div class="add_more_box">
                                                <a href="javascript:void(0);" class="add-more-block" onclick="addReadyOrderAttribute(this)"><i class="material-icons dp48">add</i> Add More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row input-field">
                                <div class="col s12">
                                    <label for="edit_ready_stock_availability" class="col-md-4 col-form-label text-md-right">Availability <span class="text-danger">*</span></label>
                                </div>
                                <div class="col s12">
                                    <input id="edit_ready_stock_availability" type="number" class="form-control availability @error('ready_stock_availability') is-invalid @enderror" name="ready_stock_availability" value="{{ old('ready_stock_availability') }}"  autocomplete="ready_stock_availability" autofocus readonly>
                                    <span class="ready_stock_availability_error text-danger error-rm"></span>
                                </div>
                            </div>
                        </div>

                        {{-- non clothing item block --}}
                        <div class="edit-non-clothing-item-block" >
                            <div class="col-md-12" id="color-size-block">
                                <div class="row input-field">
                                    <div class="col s12">
                                        <legend>Available Size & Colors <span class="text-danger">*</span></legend>
                                    </div>
                                    <div class="col s12">
                                        <div class="color-and-size-block">
                                            <div class="no_more_tables">
                                                <table class="non-clothing-color-quantity-table-block edit-non-clothing-attr-counting">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>Color</th>
                                                            <th>Quantity</th>
                                                            <!-- <th>&nbsp;</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody class="non-clothing-color-quantity-tbody">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="add_more_box" style="padding-top: 20px">
                                                <a href="javascript:void(0);" class="add-more-block" onclick="addNonClothingAttr()"><i class="material-icons dp48">add</i> Add More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- full stock --}}
                            <div class="row input-field">
                                <div class="col s12">
                                    <label>
                                        <input name="non_clothing_full_stock" type="checkbox" {{old('non_clothing_full_stock')=='on'? 'checked' : " "}} />
                                        <span>{{ __('Sell full stock only') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="non-clothing-full-stock-price" style="display: none">
                                <div class="input-field row non-clothing-full-stock-price-block" >
                                    <div class="col s12">
                                        <label for="non_clothing_full_stock_price" class="col-md-4 col-form-label text-md-right">Full Stock Price <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col s12">
                                        <input id="non_clothing_full_stock_price" type="number" step=".01" class="form-control @error('non_clothing_full_stock_price') is-invalid @enderror" name="non_clothing_full_stock_price" value="{{ old('non_clothing_full_stock_price') }}"  autocomplete="non_clothing_full_stock_price" autofocus>
                                    </div>
                                </div>
                                <div class="input-field row" >
                                    <div class="col s12">
                                        <label>
                                            <input name="non_clothing_full_stock_negotiable" type="checkbox" {{old('non_clothing_full_stock_negotiable')=='on'? 'checked' : " "}} />
                                            <span>{{ __('Price can be Negotiable') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{-- end full stock --}}
                            <div class="input-field row non-clothing-prices-breakdown">
                                <div class="col s12">
                                    <legend>Prices Breakdown <span class="text-danger">*</span></legend>
                                </div>
                                <div class="col s12">
                                    <div class="prices-breakdown-block">
                                        <div class="no_more_tables">
                                            <table class="non-clothing-prices-breakdown-block">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>Qty Min</th>
                                                        <th>Qty Max</th>
                                                        <th>Price (usd)</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody class='edit-non-clothing-prices-breakdown-tbody'>

                                                </tbody>
                                            </table>
                                            <div class="add_more_box">
                                                <a href="javascript:void(0);" class="add-more-block" onclick="addNonClothingPriceBreakDown(this)"><i class="material-icons dp48">add</i> Add More</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="input-field row">
                                <div class="col s12 m3 l3">
                                    <label for="edit_non_clothing_availability" class="col-md-4 col-form-label text-md-right">Availability <span class="text-danger">*</span></label>
                                </div>
                                <div class="col s12 m9 l9">
                                    <input id="edit_non_clothing_availability" type="number" class="form-control availability @error('non_clothing_availability') is-invalid @enderror" name="non_clothing_availability" value="{{ old('non_clothing_availability') }}"  autocomplete="non_clothing_availability" autofocus readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row moq-unit-block">
                            <div class="row">
                                <div class="col s12 input-field">
                                    <label for="moq" class="col-md-4 col-form-label text-md-right">Minimum Order Quantity <span class="text-danger">*</span></label>
                                    <div class="moqQuantity">
                                        <input id="moq" type="number" class="form-control minimun-order-qty @error('moq') is-invalid @enderror" name="moq" value="{{ old('moq') }}"  autocomplete="moq" autofocus>
                                        <div class="productUnitBox producWholetUnitBox">
                                            <select class="select2 browser-default product_unit" name="product_unit">
                                                <option value="">Select</option>
                                                <option value="LBS/Pound">LBS / Pound</option>
                                                <option value="PCS">PCS</option>
                                                <option value="Yards">Yards</option>
                                                <option value="Feet">Feet</option>
                                                <option value="Meter">Meter</option>
                                                <option value="Ton">Ton</option>
                                                <option value="Gross">Gross</option>
                                            </select>
                                            <span class="product_unit_error text-danger error-rm"></span>
                                        </div>
                                    </div>
                                    <span  class="moq_error text-danger error-rm"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding-top: 20px;">
                            <div class="col s12">
                                <label>
                                    <input name="is_new_arrival" class="edit_is_new_arrival" type="checkbox" {{old('is_new_arrival')=='on'? 'checked' : " "}} />
                                    <span>{{ __('New Arrival') }}</span>
                                </label>
                            </div>
                            <div class="col s12">
                                <label>
                                    <input name="is_featured" class="edit_is_featured" type="checkbox" {{old('is_featured')=='on'? 'checked' : " "}}/>
                                    <span>{{ __('Featured') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <label>
                                    <input name="rel-products" type="checkbox"  {{old('rel-products')=='on'? 'checked' : " "}} />
                                    <span>Select Related Products</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-field row related-product" style="display: none;">
                            <div class="col s12 related-product" style="display: none; margin:10px 10px 15px;">
                                <label for="">Select Related Products</label>
                            </div>
                            <div class="col s12">
                                <select class="js-example-basic-multiple" name="related_products[]" multiple="multiple"></select>
                            </div>
                        </div>
                        <div class="input-field row">
                            <div class="col s12">
                                <label>
                                    <input name="published" class="edit_published" type="checkbox"  {{old('published')=='on'? 'checked' : " "}}/>
                                    <span>Published</span>
                                </label>
                            </div>
                        </div>

                        <div class="row right-align">
                            <input type="hidden" name="seller_p_edit_sku">
                            <input type="hidden" name="p_type">
                        </div>
                        <div role="">
                            <ul id="edit_errors" class="validaiton-errors" style="display: none;"></ul>
                        </div>

                        <div class="submit_btn_wrap">
                            <div class="row">
                                <div class="col s12 m6 l4 left-align"><a href="javascript:void(0);" class="modal-close btn_grBorder">Cancel</a></div>
                                <div class="col s12 m6 l8 right-align">
                                    <button type="submit" class="btn_green seller_product_create">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>  <!-- End product-details-block -->
                </div>
            </form>
        </div>
    </div>

</div>





{{-- <script>
    const input = document.getElementById('edituplodadVideo');
    const video = document.getElementById('editvideo');
    const videoSource = document.createElement('source');
    input.addEventListener('change', function() {
        const files = this.files || [];
        if (!files.length) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            videoSource.setAttribute('src', e.target.result);
            video.appendChild(videoSource);
            video.load();
            video.play();
        };
        reader.onprogress = function (e) {
            console.log('progress: ', Math.round((e.loaded * 100) / e.total));
        };
        reader.readAsDataURL(files[0]);
    });
</script> --}}
