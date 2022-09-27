<div id="product-add-modal-block" class="modal fullscreen-modal wholesaler_add_product_modal profile_form_modal">
    <div class="modal-content">
        <legend>Upload Product</legend>
        <span style="font-size: 12px; padding-bottom: 15px; display:block;" class="text-danger">* Indicates Mandatory field</span>
        <!-- <div class="col-md-12">
            <div class="row">

            </div>
        </div> -->
        <form method="POST" action="javascript:void(0);" enctype="multipart/form-data" id="seller_product_form">
            @csrf
            <div class="input-field ">
                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
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
            <div class="wholesaler_add_product_form">

                {{-- <div class="row input-field product-upload-block">
                    <div class="col s12 m3 l3">
                        <label for="images">Product Images :</label>
                    </div>
                    <div class="col s12 m9 l9 control-group increment">
                        Product photos (can add more than one):
                        <input type="file" id="fileupload" name="images[]" data-url="/upload" multiple="">
                        <br>
                        <div id="files_list"></div>
                        <p id="loading"></p>
                        <input type="hidden" name="file_ids" id="file_ids" value="">
                    </div>
                </div>--}}

                <div class="input-field">
                    <div class="row">
                        <div class="col s12 m3 l3">
                            <label for="product_type_mapping">Product type mapping <span class="text-danger">*</span></label>
                        </div>
                        <div class="col s12 m9 l9">
                            <div class="radio-block">
                                <label class="radio_box">
                                    <input class="with-gap" name="product_type_mapping" type="radio" value="1" />
                                    <span>Studio</span>
                                </label>
                                <label class="radio_box">
                                    <input class="with-gap" name="product_type_mapping" type="radio" value="2" />
                                    <span>Raw Materials</span>
                                </label>
                            </div>
                        </div>
                        <span class="product_type_mapping_error text-danger error-rm"></span>
                    </div>

                    <div class="row studio" style="display: none;">
                        <div class="col s12">
                            <label>Select studio</label>
                            <select class="select2 dropdownOptions" multiple name="studio_id[]">
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
                            <select class="select2 dropdownOptions" multiple name="raw_materials_id[]">
                                @php $raw_materials_child= productTypeMapping(2); @endphp
                                @foreach ($raw_materials_child as $id => $title)
                                    <option value={{$id}}>{{$title}}</option>
                                @endforeach
                            </select>
                            <span class="raw_materials_id_error text-danger error-rm"></span>
                        </div>
                    </div>
                </div>


                <div class="row input-field product-upload-block">
                    <div class="col s12 m3 l3">
                        <label class="active">Image <span class="text-danger">*</span></label>
                    </div>
                    <div class="col s12 m9 l9">
                        <div class="input-images-1" style="padding-top: .5rem;"></div>
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
                                <img class="overlay-image-preview" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                alt="preview image" style="max-height: 100px; margin-bottom: 10px">
                            </div>
                            <input class="uplodad_video_box overlay-image" type="file" name="overlay_image">
                        </div>
                    </div>
                </div>


                <div class="row input-field product-upload-block">
                    <div class="col s12 m3 l3">
                        <label class="active">Video:</label>
                    </div>
                    <div class="col s12 m9 l9" id="lineitems">
                        <input class="uplodad_video_box" type="file" name="video">
                    </div>
                </div>
                <div class="row input-field product-details-block">
                    <div class="col s12 m3 l3">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col s12 m9 l9">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="name_error text-danger error-rm"></span>
                    </div>
                </div>

                <div class="row input-field ">
                    <div class="col s12 m3 l3">
                        <label for="product_type">{{ __('Product Type') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col s12 m9 l9">
                        <div class="radio-block">
                            <label class="radio_box">
                                <input class="with-gap" name="product_type" type="radio" value="1" checked="checked"/>
                                <span>Fresh Order</span>
                            </label>
                            <label class="radio_box">
                                <input class="with-gap" name="product_type" type="radio" value="2" />
                                <span>Ready Stock</span>
                            </label>
                            <label class="radio_box">
                                <input class="with-gap" name="product_type" type="radio" value="3" />
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
                                <input class="with-gap" name="gender" type="radio" value="1" />
                                <span>Male</span>
                            </label>
                            <label class="radio_box">
                                <input class="with-gap" name="gender" type="radio" value="2" />
                                <span>Female</span>
                            </label>
                            <label class="radio_box">
                                <input class="with-gap" name="gender" type="radio" value="3" />
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
                                <input class="with-gap" name="sample_availability" type="radio" value="1" />
                                <span>Yes</span>
                            </label>
                            <label class="radio_box">
                                <input class="with-gap" name="sample_availability" type="radio" value="0"  checked/>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <span class="sample_availability_error text-danger error-rm"></span>
                </div>


                <div class="row input-field ">
                    <div class="col s12 m3 l3">
                        <label for="product_tag">Product Tag<span class="text-danger">*</span></label>
                    </div>
                    <div class="col s12 m9 l9">
                        <select name="product_tag[]" class="select2 browser-default" id="product_tag" multiple>
                            @foreach($product_tags as $product_tag)
                                <option value="{{$product_tag->name}}">{{$product_tag->name}}</option>
                            @endforeach
                        </select>
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
                                        <thead class="cf">
                                            <tr>
                                                <th>Qty Min</th>
                                                <th>Qty Max</th>
                                                <th>Price (usd)</th>
                                                <th>Lead Time (days)</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td data-title="Qty Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value">
                                                    <span class="quantity_min_0_error text-danger error-rm"></span>
                                                </td>
                                                <td data-title="Qty Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value">
                                                    <span class="quantity_max_0_error text-danger error-rm"></span>
                                                </td>
                                                <td data-title="Price (usd)"><input name="price[]" id="price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$" >
                                                    <span class="price_0_error text-danger error-rm"></span>
                                                </td>
                                                <td data-title="Lead Time (days)"><input name="lead_time[]"  id="lead_time" type="text" class="form-control negitive-or-text-not-allowed @error('lead_time') is-invalid @enderror"  value="" placeholder="Days">
                                                    <span class="lead_0_error text-danger error-rm"></span>
                                                </td>
                                                {{-- <td><a href="javascript:void(0);" class="btn_delete" onclick="removeFreshOrderAttribute(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="add_more_box">
                                        <a href="javascript:void(0);" class="add-more-block" onclick="addFreshOrderAttribute(this)"><i class="material-icons dp48">add</i> Add More</a>
                                    </div>

                                </div>

                                {{-- <div class="add_more_box" style="padding-top: 20px">
                                     <a href="javascript:void(0);" class="add-more-block" onclick="addFreshOrderAttribute(this)"><i class="material-icons dp48">add</i> Add More</a>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="row input-field copyright-price">
                        <div class="col s12 m3 l3">
                            <label for="copyright-price" class="col-md-4 col-form-label text-md-right">Copyright Price</label>
                        </div>
                        <div class="col s12 m9 l9">
                            <input type="text" name="copyright_price" class="copyright_price_val negitive-or-text-not-allowed" onchange="allowTwoDecimal('.copyright_price_val')" />
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
                </div>{{-- fresh-rtd-attr end --}}

                <div class="stock-rtd-attr" style="display: none">
                    <div class="col-md-12" id="color-size-block">
                        <div class="row input-field ">
                            <div class="col s12">
                                <label>Available Size & Colors <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <div class="color-and-size-block">
                                    <div class="no_more_tables">
                                        <table class="color-size-table-block add-color-sizes">
                                            <thead class="cf">
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
                                            <tbody>
                                                <tr>
                                                    <td data-title="Color"><input type="text" value="" class="form-control" name="color_size[color][]" /></td>
                                                    <td data-title="XXS"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[xxs][]"/></td>
                                                    <td data-title="XS"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[xs][]" /></td>
                                                    <td data-title="Small"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[small][]" /></td>
                                                    <td data-title="Medium"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[medium][]" /></td>
                                                    <td data-title="Large"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[large][]" /></td>
                                                    <td data-title="Extra Large"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[extra_large][]" /></td>
                                                    <td data-title="XXL"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[xxl][]" /></td>
                                                    <td data-title="XXXL"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[xxxl][]" /></td>
                                                    <td data-title="4XXL"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[four_xxl][]" /></td>
                                                    <td data-title="One Size"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="color_size[one_size][]" /></td>
                                                    {{-- <td><a href="javascript:void(0);" class="btn_delete" onclick="removeProductColorSize(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="add_more_box" style="padding-top: 20px">
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
                        <div class="row input-field ">
                            <div class="col s12">
                                <label>
                                    <input name="ready_full_stock_negotiable" type="checkbox" {{old('ready_full_stock_negotiable')=='on'? 'checked' : " "}} />
                                    <span>{{ __('Price can be Negotiable') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- end full stock --}}

                    <div class="ready-stock-prices-breakdown">
                        <div class="row input-field ">
                            <div class="col s12">
                                <label>Prices Breakdown <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 prices-breakdown-block">
                                <div class="no_more_tables">
                                    <table class="ready-order-attribute-table-block">
                                        <thead class="cf">
                                            <tr>
                                                <th>Qty Min</th>
                                                <th>Qty Max</th>
                                                <th>Price (usd)</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value">
                                                    <span class="ready_quantity_min_0_error text-danger error-rm"></span>
                                                </td>
                                                <td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value">
                                                    <span class="ready_quantity_max_0_error text-danger error-rm"></span>
                                                </td>
                                                <td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$" >
                                                    <span class="ready_price_0_error text-danger error-rm"></span>
                                                </td>
                                                {{-- <td><a href="javascript:void(0);" class="btn_delete" onclick="removeReadyOrderAttribute(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a> </td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="add_more_box">
                                        <a href="javascript:void(0);" class="add-more-block" onclick="addReadyOrderAttribute(this)"><i class="material-icons dp48">add</i> Add More</a>
                                    </div>


                                </div>

                                {{-- <div class="add_more_box" style="padding-top: 20px">
                                    <a href="javascript:void(0);" class="add-more-block" onclick="addReadyOrderAttribute(this)"><i class="material-icons dp48">add</i> Add More</a>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="row input-field">
                        <div class="col s12 m3 l3">
                            <label for="ready_stock_availability" class="col-md-4 col-form-label text-md-right">Quantity Available  <span class="text-danger">*</span></label>
                        </div>
                        <div class="col s12 m9 l9">
                            <input id="ready_stock_availability" type="number" class="form-control  @error('ready_stock_availability') is-invalid @enderror" name="ready_stock_availability" value="{{ old('ready_stock_availability') }}"  autocomplete="ready_stock_availability" autofocus readonly>
                            <span class="ready_stock_availability_error text-danger error-rm"></span>
                        </div>
                    </div>
                </div> {{--stock-rtd-attr --}}

                {{--start non clothing item block --}}
                <div class="non-clothing-block" style="display: none">
                    <div class="col-md-12" id="color-size-block">
                        <div class="row input-field">
                            <div class="col s12">
                                <label>Available Size & Colors <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <div class="color-and-size-block">
                                    <div class="no_more_tables">
                                        <table class="non-clothing-color-quantity-table-block">
                                            <thead class="cf">
                                                <tr>
                                                    <th>Color</th>
                                                    <th>Quantity</th>
                                                    <!-- <th>&nbsp;</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-title="Color"><input type="text" value="" class="form-control" name="non_clothing_attr[color][]" /></td>
                                                    <td data-title="Quantity"><input type="text" value="" class="form-control count-color-size negitive-or-text-not-allowed" name="non_clothing_attr[quantity][]" /></td>
                                                </tr>
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
                    <div class="non-clothing-full-stock-price"  style="display: none">
                        <div class="row input-field non-clothing-full-stock-price-block">
                            <div class="col s12 m3 l3">
                                <label for="non_clothing_full_stock_price" class="col-md-4 col-form-label text-md-right">Full Stock Price <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12 m9 l9">
                                <input id="non_clothing_full_stock_price" type="number" step=".01" class="form-control @error('non_clothing_full_stock_price') is-invalid @enderror" name="non_clothing_full_stock_price" value="{{ old('non_clothing_full_stock_price') }}"  autocomplete="non_clothing_full_stock_price" autofocus>
                                <span class="non_clothing_full_stock_price_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="row input-field">
                            <div class="col s12">
                                <label>
                                    <input name="non_clothing_full_stock_negotiable" type="checkbox" {{old('non_clothing_full_stock_negotiable')=='on'? 'checked' : " "}} />
                                    <span>{{ __('Price can be Negotiable') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- end full stock --}}

                    <div class="row input-field non-clothing-prices-breakdown">
                        <div class="col s12">
                            <label>Prices Breakdown <span class="text-danger">*</span></label>
                        </div>
                        <div class="col s12 prices-breakdown-block">
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
                                    <tbody>
                                        <tr>
                                            <td data-title="Qty Min"><input name="non_clothing_min[]"  type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value">
                                                <span class="non_clothing_min_0_error text-danger error-rm"></span>
                                            </td>
                                            <td data-title="Qty Max"><input name="non_clothing_max[]"  type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value">
                                                <span class="non_clothing_max_0_error text-danger error-rm"></span>
                                            </td>
                                            <td data-title="Price (usd)"><input name="non_clothing_price[]" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$" >
                                                <span class="non_clothing_price_0_error text-danger error-rm"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="add_more_box">
                                    <a href="javascript:void(0);" class="add-more-block" onclick="addNonClothingPriceBreakDown(this)"><i class="material-icons dp48">add</i> Add More</a>
                                </div>

                            </div>
                            {{-- <div class="add_more_box" style="padding-top: 20px">
                                <a href="javascript:void(0);" class="add-more-block" onclick="addNonClothingPriceBreakDown()"><i class="material-icons dp48">add</i> Add More</a>
                            </div> --}}

                        </div>
                    </div>
                    <div class="row input-field">
                        <div class="col s12 m3 l3">
                            <label for="non_clothing_availability" class="col-md-4 col-form-label text-md-right">Quantity Available <span class="text-danger">*</span></label>
                        </div>
                        <div class="col s12 m9 l9">
                            <input id="non_clothing_availability" type="number" class="form-control  @error('non_clothing_availability') is-invalid @enderror" name="non_clothing_availability" value="{{ old('non_clothing_availability') }}"  autocomplete="non_clothing_availability" autofocus readonly>
                            <span class="non_clothing_availability_error text-danger error-rm"></span>
                        </div>
                    </div>
                </div>
                {{--end non clothing item block --}}

                <div class="row moq-unit-block">
                    <div class="row">
                        <div class="col s12 m6 l6 input-field">
                            <div class="col 12">
                                <label for="moq" class="col-md-4 col-form-label text-md-right">Minimum Order Quantity <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <input id="moq" type="number" class="form-control @error('moq') is-invalid @enderror" name="moq" value="{{ old('moq') }}"  autocomplete="moq" autofocus>
                                <span  class="moq_error text-danger error-rm"></span>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 input-field">
                            <div class="col 12">
                                <label for="product_unit" class="col-md-4 col-form-label text-md-right">Unit <span class="text-danger">*</span></label>
                            </div>
                            <div class="col s12">
                                <select class="select2 browser-default product_unit" name="product_unit">
                                    <option value="">Select</option>
                                    <option value="LBS/Pound">LBS/Pound</option>
                                    <option value="PCS">PCS</option>
                                    <option value="Yards">Yards</option>
                                    <option value="Feet">Feet</option>
                                    <option value="Meter">Meter</option>
                                    <option value="Ton">Ton</option>
                                </select>
                                <span class="product_unit_error text-danger error-rm"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row input-field">
                    <div class="col s12">
                        <label>
                            <input name="is_new_arrival" type="checkbox" {{old('is_new_arrival')=='on'? 'checked' : " "}} />
                            <span>{{ __('New Arrival') }}</span>
                        </label>
                    </div>
                    <div class="col s12">
                        <label>
                            <input name="is_featured" type="checkbox" {{old('is_featured')=='on'? 'checked' : " "}}/>
                            <span>{{ __('Featured') }}</span>
                        </label>
                    </div>
                </div>
                <div class="row input-field">
                    <div class="col s12 m3 l3">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col s12 m9 l9">
                        <textarea id="description" class="editor" name="description" >{{old('description')}}</textarea>
                        <span class="description_error text-danger error-rm"></span>
                    </div>
                </div>
                <div class="row input-field">
                    <div class="col s12 m3 l3">
                        <label for="additional_description" class="col-md-4 col-form-label text-md-right">{{ __('Additional Description') }}</label>
                    </div>
                    <div class="col s12 m9 l9">
                        <textarea id="additional_description" class="editor" name="additional_description" >{{old('additional_description')}}</textarea>
                    </div>
                </div>
                <div class="row input-field">
                    <div class="col s12">
                        <label>
                            <input name="rel-products" type="checkbox"  {{old('rel-products')=='on'? 'checked' : " "}} />
                            <span>Select Related Products</span>
                        </label>
                    </div>
                    <div class="col s12">
                        <label>
                            <input name="published" type="checkbox"  {{old('published')=='on'? 'checked' : " "}}/>
                            <span>Published</span>
                        </label>
                    </div>
                </div>
                <div class="row input-field related-product" style="display: none;">
                    <div class="col s12 m3 l3">
                        <label for="">Select Related Products</label>
                    </div>
                    <div class="col s12 m9 l9">
                        <select class="js-example-basic-multiple" name="related_products[]" multiple="multiple"></select>
                    </div>
                </div>

                <div role="">
                    <ul id="errors" class="validaiton-errors" style="display: none;"></ul>
                </div>

                <div class="submit_btn_wrap" style="padding-top: 30px;">
                    <div class="row">
                        <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder btn-back-to-product-list">Cancel</a></div>
                        <div class="col s12 m6 l6 right-align">
                            <button type="submit" class="btn_green seller_product_create">Save</button>
                        </div>
                    </div>
                </div>

                <!-- <div class="row input-field right-align">
                    <button type="submit" class="btn_green btn waves-effect waves-light green seller_product_create">Save</button>
                    <button type="button" class="btn_green btn modal-close waves-effect waves-light green btn-back-to-product-list">Cancel</button>
                </div> -->

            </div>{{-- wholesaler_add_product_form end --}}

        </form>
    </div>

    <!-- <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div> -->


</div>

{{-- tinymc editor file upload modal --}}
<div id="tiny-mc-file-upload-modal" class="modal modal-fixed-footer" tabindex="0">
    <div class="modal-content">
        <div class="row">
            <div class="col m6 login-block">
                <span class="text-danger error-text error-msg login-error-msg" style="display: none;"></span>
                <form method="POST" action="#" enctype="multipart/form-data" id="tiny-mc-file-upload-form">
                    @csrf
                    <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="tiny_mc_file" type="file" name="tiny_mc_file" required />
                        </div>
                        <button class="btn green waves-effect waves-light tiny-mc-file-upload" type="button" >
                            {{ __('Upload') }} <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col s12 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>

    <!-- <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat "><i class="material-icons green-text text-darken-1">close</i></a>
    </div> -->

</div>


