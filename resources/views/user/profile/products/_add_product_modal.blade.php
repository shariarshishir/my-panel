<div id="product-add-modal-block" class="modal modal-fixed-footer fullscreen-modal">
    <div class="modal-content">
        <legend>Upload Product</legend>
        <form method="POST" action="javascript:void(0);" enctype="multipart/form-data" id="seller_product_form">
            @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div role="">
                    <ul id="errors"></ul>
                </div>
            <div class="row">
                {{-- <div class="col m6 product-upload-block">
                    <label for="images">Product Images :</label>
                    <div class="input-group  control-group increment" >
                        Product photos (can add more than one):
                        <input type="file" id="fileupload" name="images[]" data-url="/upload" multiple="">
                        <br>
                        <div id="files_list"></div>
                        <p id="loading"></p>
                        <input type="hidden" name="file_ids" id="file_ids" value="">

                    </div>
                </div> --}}
                <div class="col m6 product-upload-block">
                    <div class="input-field">
                        <label class="active">Image:</label>
                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                        <div class="image-upload-message">Minimum image size 300 X 300</div>
                </div>
                </div>

                <div class="col m6 product-details-block">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="product_type">{{ __('Product Type') }}</label>
                            <div class="radio-block">
                                <label>
                                    <input class="with-gap" name="product_type" type="radio" value="1" checked="checked"/>
                                    <span>Fresh Order</span>
                                </label>
                                <label>
                                    <input class="with-gap" name="product_type" type="radio" value="2" />
                                    <span>Ready Stock</span>
                                </label>
                                <label>
                                    <input class="with-gap" name="product_type" type="radio" value="3" />
                                    <span>Non Clothing Item</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_category_id">{{ __('Product Category') }}</label>
                            <select name="category_id" class="select2 browser-default" id="category_id">
                                <option value="" selected="true">Choose your option</option>
                                @foreach($categories as $categoryitem)
                                    <option value="{{$categoryitem['id']}}">{{$categoryitem['name']}}</option>
                                        @if(!empty($categoryitem['children'])) <!-- 1st sub level -->
                                            @foreach($categoryitem['children'] as $childcategoryitem)
                                            <option value="{{ $childcategoryitem['id'] }}"> - {{ $childcategoryitem['name'] }}</option>
                                                @if(!empty($childcategoryitem['children'])) <!-- 2nd sub level -->
                                                    @foreach($childcategoryitem['children'] as $subchildcategoryitem)
                                                    <option value="{{ $subchildcategoryitem['id'] }}"> -- {{ $subchildcategoryitem['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                @endforeach
                            </select>
                            <span class="text-danger error-text category_id_err"></span>
                        </div>

                        <div class="form-group row fresh-rtd-attr">
                            <label>Prices Breakdown</label>
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
                                                <td data-title="Qty Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>
                                                <td data-title="Qty Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>
                                                <td data-title="Price (usd)"><input name="price[]" id="price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$" ></td>
                                                <td data-title="Lead Time (days)"><input name="lead_time[]"  id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror"  value="" placeholder="Days"></td>
                                                {{-- <td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeFreshOrderAttribute(this)"><i class="material-icons dp48">remove</i></a></td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addFreshOrderAttribute()"><i class="material-icons dp48">add</i> Add More</a>
                            </div>

                            <div class="copyright-price">
                                <label for="copyright-price" class="col-md-4 col-form-label text-md-right">Copyright Price</label>
                                <input type="text" name="copyright_price" class="copyright_price_val" onchange="allowTwoDecimal('.copyright_price_val')" />

                            </div>
                            {{-- customize --}}
                            <div class="">
                                <label>
                                    <input name="customize" type="checkbox" {{old('customize')=='on'? 'checked' : " "}} />
                                    <span>{{ __('Can be Customizable') }}</span>
                                </label>
                            </div>
                        </div>

                    <div class="stock-rtd-attr" style="display: none">
                        <div class="col-md-12" id="color-size-block">
                            <div class="row">
                                <label>Available Size & Colors</label>
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
                                                    <td date-title="Color"><input type="text" value="" class="form-control" name="color_size[color][]" /></td>
                                                    <td date-title="XXS"><input type="text" value="0" class="form-control count-color-size" name="color_size[xxs][]" /></td>
                                                    <td date-title="XS"><input type="text" value="0" class="form-control count-color-size" name="color_size[xs][]" /></td>
                                                    <td date-title="Small"><input type="text" value="0" class="form-control count-color-size" name="color_size[small][]" /></td>
                                                    <td date-title="Medium"><input type="text" value="0" class="form-control count-color-size" name="color_size[medium][]" /></td>
                                                    <td date-title="Large"><input type="text" value="0" class="form-control count-color-size" name="color_size[large][]" /></td>
                                                    <td date-title="Extra Large"><input type="text" value="0" class="form-control count-color-size" name="color_size[extra_large][]" /></td>
                                                    <td date-title="XXL"><input type="text" value="0" class="form-control count-color-size" name="color_size[xxl][]" /></td>
                                                    <td date-title="XXXL"><input type="text" value="0" class="form-control count-color-size" name="color_size[xxxl][]" /></td>
                                                    <td date-title="4XXL"><input type="text" value="0" class="form-control count-color-size" name="color_size[four_xxl][]" /></td>
                                                    <td date-title="One Size"><input type="text" value="0" class="form-control count-color-size" name="color_size[one_size][]" /></td>
                                                    {{-- <td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeProductColorSize(this)"><i class="material-icons dp48">remove</i></a></td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addProductColorSize()"><i class="material-icons dp48">add</i> Add More</a>
                                </div>
                            </div>
                        </div>
                        {{-- full stock --}}
                        <div class="form-group row">
                            <label>
                                <input name="full_stock" type="checkbox" {{old('full_stock')=='on'? 'checked' : " "}} />
                                <span>{{ __('Sell full stock only') }}</span>
                            </label>
                        </div>
                        <div class="full-stock-price" style="display: none">
                            <div class="form-group row full-stock-price-block">
                                <label for="full_stock_price" class="col-md-4 col-form-label text-md-right">Full Stock Price</label>
                                <input id="full_stock_price" type="number" step=".01" class="form-control @error('full_stock_price') is-invalid @enderror" name="full_stock_price" value="{{ old('full_stock_price') }}"  autocomplete="full_stock_price" autofocus>
                            </div>
                            <div class="form-group row">
                                <label>
                                    <input name="ready_full_stock_negotiable" type="checkbox" {{old('ready_full_stock_negotiable')=='on'? 'checked' : " "}} />
                                    <span>{{ __('Price can be Negotiable') }}</span>
                                </label>
                            </div>
                        </div>


                     {{-- end full stock --}}
                        <div class="form-group row ready-stock-prices-breakdown">
                            <label>Prices Breakdown</label>
                            <div class="prices-breakdown-block">
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
                                                <td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>
                                                <td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>
                                                <td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$" ></td>
                                                {{-- <td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeReadyOrderAttribute(this)"><i class="material-icons dp48">remove</i></a></td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addReadyOrderAttribute()"><i class="material-icons dp48">add</i> Add More</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ready_stock_availability" class="col-md-4 col-form-label text-md-right">Quantity Available</label>
                            <input id="ready_stock_availability" type="number" class="form-control  @error('ready_stock_availability') is-invalid @enderror" name="ready_stock_availability" value="{{ old('ready_stock_availability') }}"  autocomplete="ready_stock_availability" autofocus readonly>
                        </div>
                    </div>


                    {{--start non clothing item block --}}

                    <div class="non-clothing-block" style="display: none">
                        <div class="col-md-12" id="color-size-block">
                            <div class="row">
                                <label>Available Size & Colors</label>
                                <div class="color-and-size-block">
                                    <div class="no_more_tables">
                                        <table class="non-clothing-color-quantity-table-block">
                                            <thead class="cf">
                                                <tr>
                                                    <th>Color</th>
                                                    <th>Quantity</th>
                                                    <!-- <td>&nbsp;</td> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-title="Color"><input type="text" value="" class="form-control" name="non_clothing_attr[color][]" /></td>
                                                    <td data-title="Quantity"><input type="text" value="0" class="form-control count-color-size check-price-range-value" name="non_clothing_attr[quantity][]" /></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addNonClothingAttr()"><i class="material-icons dp48">add</i> Add More</a>
                                </div>
                            </div>
                        </div>

                     {{-- full stock --}}
                        <div class="form-group row">
                            <label>
                                <input name="non_clothing_full_stock" type="checkbox" {{old('non_clothing_full_stock')=='on'? 'checked' : " "}} />
                                <span>{{ __('Sell full stock only') }}</span>
                            </label>
                        </div>
                        <div class="non-clothing-full-stock-price"  style="display: none">
                            <div class="form-group row  non-clothing-full-stock-price-block">
                                <label for="non_clothing_full_stock_price" class="col-md-4 col-form-label text-md-right">Full Stock Price</label>
                                <input id="non_clothing_full_stock_price" type="number" step=".01" class="form-control @error('non_clothing_full_stock_price') is-invalid @enderror" name="non_clothing_full_stock_price" value="{{ old('non_clothing_full_stock_price') }}"  autocomplete="non_clothing_full_stock_price" autofocus>
                            </div>
                            <div class="form-group row">
                                <label>
                                    <input name="non_clothing_full_stock_negotiable" type="checkbox" {{old('non_clothing_full_stock_negotiable')=='on'? 'checked' : " "}} />
                                    <span>{{ __('Price can be Negotiable') }}</span>
                                </label>
                            </div>
                        </div>

                     {{-- end full stock --}}
                        <div class="form-group row non-clothing-prices-breakdown">
                            <label>Prices Breakdown</label>
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
                                        <tbody>
                                            <tr>
                                                <td data-title="Qty Min"><input name="non_clothing_min[]"  type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>
                                                <td data-title="Qty Max"><input name="non_clothing_max[]"  type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>
                                                <td data-title="Price (usd)"><input name="non_clothing_price[]" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$" ></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addNonClothingPriceBreakDown()"><i class="material-icons dp48">add</i> Add More</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="non_clothing_availability" class="col-md-4 col-form-label text-md-right">Quantity Available</label>
                            <input id="non_clothing_availability" type="number" class="form-control  @error('non_clothing_availability') is-invalid @enderror" name="non_clothing_availability" value="{{ old('non_clothing_availability') }}"  autocomplete="non_clothing_availability" autofocus readonly>
                        </div>
                    </div>
                    {{--end non clothing item block --}}

                    <div class="form-group row moq-unit-block">
                        <div class="row">
                            <div class="col m8">
                                <label for="moq" class="col-md-4 col-form-label text-md-right">Minimum Order Quantity</label>
                                <input id="moq" type="number" class="form-control @error('moq') is-invalid @enderror" name="moq" value="{{ old('moq') }}"  autocomplete="moq" autofocus>
                            </div>
                            <div class="col m4">
                                <label for="product_unit" class="col-md-4 col-form-label text-md-right">Unit</label>
                                <select class="select2 browser-default product_unit" name="product_unit">
                                    <option value="">Select</option>
                                    <option value="LBS/Pound">LBS/Pound</option>
                                    <option value="PCS">PCS</option>
                                    <option value="Yards">Yards</option>
                                    <option value="Feet">Feet</option>
                                    <option value="Meter">Meter</option>
                                    <option value="Ton">Ton</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label>
                            <input name="is_new_arrival" type="checkbox" {{old('is_new_arrival')=='on'? 'checked' : " "}} />
                            <span>{{ __('New Arrival') }}</span>
                        </label>
                    </div>

                    <div class="form-group row">
                        <label>
                            <input name="is_featured" type="checkbox" {{old('is_featured')=='on'? 'checked' : " "}}/>
                            <span>{{ __('Featured') }}</span>
                        </label>
                    </div>


                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                        <textarea id="description" class="editor" name="description" >{{old('description')}}</textarea>
                    </div>

                    <div class="form-group row">
                        <label for="additional_description" class="col-md-4 col-form-label text-md-right">{{ __('Additional Description') }}</label>
                        <textarea id="additional_description" class="editor" name="additional_description" >{{old('additional_description')}}</textarea>
                    </div>

                    <div class="form-group row">
                        <label>
                            <input name="rel-products" type="checkbox"  {{old('rel-products')=='on'? 'checked' : " "}} />
                            <span>Select Related Products</span>
                        </label>
                    </div>

                    <div class="form-group row related-product" style="display: none;">
                        <label for="">Select Related Products</label>
                        <select class="js-example-basic-multiple" name="related_products[]" multiple="multiple">

                        </select>
                    </div>

                    <div class="form-group row">
                        <label>
                            <input name="published" type="checkbox"  {{old('published')=='on'? 'checked' : " "}}/>
                            <span>Published</span>
                        </label>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn waves-effect waves-light green seller_product_create">Save</button>
                        <button type="button" class="btn modal-close waves-effect waves-light green btn-back-to-product-list">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div>
</div>

