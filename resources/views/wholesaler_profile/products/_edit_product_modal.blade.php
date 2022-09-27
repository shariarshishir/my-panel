
<div id="product-edit-modal-block" class="modal fullscreen-modal profile_form_modal">
    <div class="modal-content">

            <legend>Edit Product</legend>
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

                    {{-- <div class="col m6 product-upload-block">
                        <div class="edit-image-preview"></div>
                        <label for="images">Product Images :</label>
                        <div class="input-group  control-group increment" >
                        Product photos (can add more than one):
                            <input type="file" id="edit_fileupload" name="images[]" data-url="/upload-edit" multiple="">
                            <br>
                            <div id="edit_files_list"></div>
                            <p id="edit_loading"></p>
                            <input type="hidden" name="file_ids" id="edit_file_ids" value="">

                        </div>
                    </div> --}}
                    <div class="input-field">
                        <div class="row">
                            <div class="col s12 m3 l3">
                                <label for="product_type_mapping">Product type mapping <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
                                <div class="radio-block">
                                    <label class="radio_box">
                                        <input class="with-gap" id="studio-checked" name="product_type_mapping" type="radio" value="1" />
                                        <span>Studio</span>
                                    </label>
                                    <label class="radio_box">
                                        <input class="with-gap"  id="raw-materials-checked" name="product_type_mapping" type="radio" value="2" />
                                        <span>Raw Materials</span>
                                    </label>
                                </div>
                            </div>
                            <span class="product_type_mapping_error text-danger error-rm"></span>
                        </div>
                        <div class="row studio" style="display: none;">
                            <div class="col s12">
                                <label>Select studio</label>
                                <select class="select2 dropdownOptions studio-id" multiple name="studio_id[]">
                                    @php $studio_child= productTypeMapping(1); @endphp
                                    @foreach ($studio_child as $id => $title)
                                        <option value={{$id}}>{{$title}}</option>
                                    @endforeach
                                </select>
                                <span class="studio_id_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="row raw-materials" style="display: none;">
                            <div class="col s12">
                                <label>Select raw materials</label>
                                <select class="select2 dropdownOptions raw-materials-id" multiple name="raw_materials_id[]">
                                    @php $raw_materials_child= productTypeMapping(2); @endphp
                                    @foreach ($raw_materials_child as $id => $title)
                                        <option value={{$id}}>{{$title}}</option>
                                    @endforeach
                                </select>
                                <span class="raw_materials_id_error text-danger error-rm"></span>
                            </div>
                        </div>
                    </div>


                    <div class="row input-field product-upload-block edit-image-block">
                        <div class="col s12 m3 l3">
                            <label class="active">Image <span class="text-danger">*</span></label>
                        </div>
                        <div class="col s12 m9 l9">
                            <div class="input-images-2" style="padding-top: .5rem;"></div>
                            <div class="image-upload-message">Minimum image size 300 X 300</div>
                            <span class="images_error text-danger error-rm"></span>
                        </div>
                    </div>
                    <div class="overlay-image-div">

                        <div class="row input-field product-upload-block">
                            <div class="col s12 m3 l3">
                                <label class="active">Overlay Image:</label>
                            </div>
                            <div class="col s12 m9 l9" id="lineitems">
                                <div class="overlay-image-preview-block">
                                    <div class="remove-overlay-image">

                                    </div>
                                    <img class="overlay-image-preview" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                    alt="preview image" style="max-height: 100px; margin-bottom: 10px;">
                                </div>
                                <input  class="uplodad_video_box overlay-image" type="file" name="overlay_image">
                            </div>
                        </div>
                    </div>

                    <div class="row input-field edit-video-show-div">
                        <div class="col s12 m3 l3">
                            <label class="active">Video: </label>
                        </div>
                        <div class="col s12 m9 l9">
                            <div class="edit-video-show-block">

                            </div>
                        </div>
                    </div>

                    <div class="row input-field edit-video-upload-block">
                        <div class="col s12 m3 l3">
                            <label class="active">Video:</label>
                        </div>
                        <div class="col s12 m9 l9" id="lineitems">
                            <input class="uplodad_video_box" type="file" name="video">
                        </div>
                    </div>

                    <input type="hidden" name="remove_video_id"  value="">
                    <div class="product-details-block">
                        <div class="row input-field">
                            <div class="col s12 m3 l3">
                                <label for="p-edit-name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
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
                            <div class="col s12 m3 l3">
                                <label for="product_type">{{ __('Product Type') }} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
                                <div class="radio-block">
                                    <label class="radio_box">
                                        <input class="with-gap" name="product_type" type="radio" value="1" id="p-type-fresh" disabled/>
                                        <span>Fresh Order</span>
                                    </label>
                                    <label class="radio_box">
                                        <input class="with-gap" name="product_type" type="radio" value="2" id="p-type-ready" disabled/>
                                        <span>Ready Stock</span>
                                    </label>
                                    <label class="radio_box">
                                        <input class="with-gap" name="product_type" type="radio" value="3" id="p-type-non-clothing" disabled/>
                                        <span>Non Clothing Item</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                         {{-- gender --}}
                        <div class="row input-field ">
                            <div class="col s12 m3 l3">
                                <label for="gender">Gender<span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
                                <div class="radio-block">
                                    <label class="radio_box">
                                        <input class="with-gap" name="gender" id="gender_male" type="radio" value="1" />
                                        <span>Male</span>
                                    </label>
                                    <label class="radio_box">
                                        <input class="with-gap" name="gender" id="gender_female" type="radio" value="2" />
                                        <span>Female</span>
                                    </label>
                                    <label class="radio_box">
                                        <input class="with-gap" name="gender" id="gender_unisex" type="radio" value="3" />
                                        <span>Unisex</span>
                                    </label>
                                </div>
                            </div>
                            <span class="gender_error text-danger error-rm"></span>
                        </div>
                        {{-- sample availability --}}
                        <div class="row input-field ">
                            <div class="col s12 m3 l3">
                                <label for="sample_availability">Sample Availability <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
                                <div class="radio-block">
                                    <label class="radio_box">
                                        <input class="with-gap" name="sample_availability" id="sample_availability_yes" type="radio" value="1" />
                                        <span>Yes</span>
                                    </label>
                                    <label class="radio_box">
                                        <input class="with-gap" name="sample_availability" id="sample_availability_no" type="radio" value="0" />
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                            <span class="sample_availability_error text-danger error-rm"></span>
                        </div>



                        <div class="row input-field">
                            <div class="col s12 m3 l3">
                                <label for="edit_product_tag">Product Tag<span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
                                <select name="product_tag[]" class="select2 browser-default " id="edit_product_tag" multiple>
                                    @foreach($product_tags as $product_tag)
                                        <option value="{{$product_tag->name}}">{{$product_tag->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text product_tag_err"></span>
                                <span class="product_tag_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="fresh-rtd-attr">
                            <div class="row input-field">
                                <div class="col s12">
                                    <label>Prices Breakdown <span class="text-danger">*</span></label>
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
                                        {{-- <div class="add_more_box" style="padding-top: 20px">
                                            <a href="javascript:void(0);" class="add-more-block" onclick="addFreshOrderAttribute()"><i class="material-icons dp48">add</i> Add More</a>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                            <div class="row input-field copyright-price">
                                <div class="col s12 m3 l3">
                                    <label for="copyright-price" class="col-md-4 col-form-label text-md-right">Copyright Price</label>
                                </div>
                                <div class="col s12 m9 l9">
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
                                        <label>Available Size & Colors <span class="text-danger">*</span></label>
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
                                    <div class="col s12 m3 l3">
                                        <label for="full_stock_price" class="col-md-4 col-form-label text-md-right">Full Stock Price <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col s12 m9 l9">
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
                                    <label>Prices Breakdown <span class="text-danger">*</span></label>
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
                                            <a href="javascript:void(0);" class="add-more-block" onclick="addReadyOrderAttribute(this)"><i class="material-icons dp48">add</i> Add More</a>

                                        </div>


                                        {{-- <div class="add_more_box" style="padding-top: 20px">
                                            <a href="javascript:void(0);" class="add-more-block" onclick="addReadyOrderAttribute()"><i class="material-icons dp48">add</i> Add More</a>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                            <div class="row input-field">
                                <div class="col s12 m3 l3">
                                    <label for="edit_ready_stock_availability" class="col-md-4 col-form-label text-md-right">Availability <span class="text-danger">*</span></label>
                                </div>
                                <div class="col s12 m9 l9">
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
                                        <label>Available Size & Colors <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col s12">
                                        <div class="color-and-size-block">
                                            <div class="no_more_tables">
                                                <table class="non-clothing-color-quantity-table-block edit-non-clothing-attr-counting striped">
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
                                    <div class="col s12 m3 m3">
                                        <label for="non_clothing_full_stock_price" class="col-md-4 col-form-label text-md-right">Full Stock Price <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col s12 m9 m9">
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
                                    <label>Prices Breakdown <span class="text-danger">*</span></label>
                                </div>
                                <div class="col s12">
                                    <div class="prices-breakdown-block">
                                        <div class="no_more_tables">
                                            <table class="non-clothing-prices-breakdown-block striped">
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
                                            <a href="javascript:void(0);" class="add-more-block" onclick="addNonClothingPriceBreakDown(this)"><i class="material-icons dp48">add</i> Add More</a>
                                        </div>


                                        {{-- <div class="add_more_box">
                                            <a href="javascript:void(0);" class="add-more-block" onclick="addNonClothingPriceBreakDown()"><i class="material-icons dp48">add</i> Add More</a>
                                        </div> --}}

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
                            <div class="col s12 m8 input-field ">
                                <label for="moq" class="col-md-4 col-form-label text-md-right">Minimum Order Quantity <span class="text-danger">*</span></label>
                                <input id="moq" type="number" class="form-control minimun-order-qty @error('moq') is-invalid @enderror" name="moq" value="{{ old('moq') }}"  autocomplete="moq" autofocus>
                                <span  class="moq_error text-danger error-rm"></span>
                            </div>
                            <div class="col s12 m4 input-field ">
                                <label for="product_unit" class="col-md-4 col-form-label text-md-right">Unit <span class="text-danger">*</span></label>
                                <select class="select2 browser-default product_unit" name="product_unit">
                                    <option value="">Select</option>
                                    <option value="LBS/Pound">LBS / Pound</option>
                                    <option value="PCS">PCS</option>
                                    <option value="Yards">Yards</option>
                                    <option value="Feet">Feet</option>
                                    <option value="Meter">Meter</option>
                                    <option value="Ton">Ton</option>
                                </select>
                                <span class="product_unit_error text-danger error-rm"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 input-field">
                                <label>
                                    <input name="is_new_arrival" class="edit_is_new_arrival" type="checkbox" {{old('is_new_arrival')=='on'? 'checked' : " "}} />
                                    <span>{{ __('New Arrival') }}</span>
                                </label>
                            </div>
                            <div class="col s12 input-field ">
                                <label>
                                    <input name="is_featured" class="edit_is_featured" type="checkbox" {{old('is_featured')=='on'? 'checked' : " "}}/>
                                    <span>{{ __('Featured') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="input-field row">
                            <div class="col s12 m3 l3">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
                                <textarea id="edit-description" class="editor edit-description" name="description" >{{old('description')}}</textarea>
                                <span class="description_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="input-field row">
                            <div class="col s12 m3 l3">
                                <label for="additional_description" class="col-md-4 col-form-label text-md-right">{{ __('Additional Description') }}</label>
                            </div>
                            <div class="col s12 m9 l9">
                                <textarea id="edit-additional-description" class="editor edit-additional-description" name="additional_description" >{{old('additional_description')}}</textarea>
                            </div>
                        </div>
                        <div class="input-field row">
                            <div class="col s12">
                                <label>
                                    <input name="rel-products" type="checkbox"  {{old('rel-products')=='on'? 'checked' : " "}} />
                                    <span>Select Related Products</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-field row related-product" style="display: none;">
                            <div class="col s12">
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
                        <div class="input-field row  right-align">
                            <input type="hidden" name="seller_p_edit_sku">
                            <input type="hidden" name="p_type">


                        </div>

                        <div role="">
                            <ul id="edit_errors" class="validaiton-errors" style="display: none;"></ul>
                        </div>

                        <div class="submit_btn_wrap">
                            <div class="row">
                                <div class="col s12 m6 l6 left-align">
                                    <button type="button" class="modal-close btn_grBorder btn-back-to-product-list">Cancel</button>
                                </div>
                                <div class="col s12 m6 l6 right-align">
                                    <button type="submit" class="btn_green btn waves-effect waves-light green ">Save</button>
                                </div>
                            </div>
                        </div>



                    </div>  <!-- End product-details-block -->




                    <!-- <div class="">
                        {{-- end non clothing item --}}
                        <div class="input-field row moq-unit-block">
                            <div class="row">

                            </div>
                        </div>
                    </div> -->


            </form>


        </div>
    </div>


    <!-- <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div> -->


</div>





