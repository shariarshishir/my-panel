<div id="update-order-modification-modal_{{$item->id}}" class="create-order-modification-details-modal modal modal-fixed-footer">
    <div class="modal-content">
        <legend>Update Order</legend>
        <div role="">
            <ul id="ord-mod-create-errors"></ul>
        </div>
        <div class="row order-top-block">

        </div>
        <div class="row product-details-table-block ord-mod-create">
            <div class="col s12">
                <form action="#" method="post" name="ordModCreateForm" id="ordModCreateForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="ord-mod-unit-price" class="col-md-4 col-form-label text-md-right">Unit Price</label>
                        <input id="ord-mod-unit-price_{{$item->id}}" type="number" class="form-control @error('moq') is-invalid @enderror" name="ord_mod_unit_price" value="{{ old('ord_mod_unit_price') }}"  autocomplete="ord_mod_unit_price" autofocus>
                    </div>
                    <div class="form-group row">
                        <div class="color-and-size-block">
                            <div class="no_more_tables">
                                <table class="color-size-table-block ord-mod-color-sizes_{{$item->id}}">
                                    <thead class="cf">
                                        <tr>
                                            <th>Color</th>
                                            <th>Small</th>
                                            <th>Medium</th>
                                            <th>Large</th>
                                            <th>Extra Large</th>
                                            <!-- <th>&nbsp;</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-title="Color"><input type="text" value="" class="form-control" name="color_size[color][]" /></td>
                                            <td data-title="Small"><input type="text" value="0" class="form-control count-color-size" name="color_size[small][]" /></td>
                                            <td data-title="Medium"><input type="text" value="0" class="form-control count-color-size" name="color_size[medium][]" /></td>
                                            <td data-title="Large"><input type="text" value="0" class="form-control count-color-size" name="color_size[large][]" /></td>
                                            <td data-title="Extra Large"><input type="text" value="0" class="form-control count-color-size" name="color_size[extra_large][]" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addProductColorSize()"><i class="material-icons dp48">add</i> Add More</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="m6">
                            <label for="ord-mod-total-quantity" class="col-md-4 col-form-label text-md-right">Total Quantity</label>
                            <input id="ord-mod-total-quantity_{{$item->id}}" type="number" class="form-control @error('moq') is-invalid @enderror" name="ord_mod_total_quantity" value="{{ old('ord_mod_total_quantity') }}"  autocomplete="ord_mod_total_quantity" autofocus>
                        </div>
                        <div class="m6">
                            <label for="ord-mod-total-price" class="col-md-4 col-form-label text-md-right">Total Price</label>
                            <input id="ord-mod-total-price_{{$item->id}}" type="number" class="form-control @error('moq') is-invalid @enderror" name="ord_mod_total_price" value="{{ old('ord_mod_total_price') }}"  autocomplete="ord_mod_total_price" autofocus>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-md-4 col-form-label text-md-right">Modified Image</label>
                        <div class="col-md-6">
                            <div class="col-md-12 mb-2">
                                <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="preview image" style="max-height: 200px;">
                            </div>
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="ord_mod_image" value="{{ old('image') }}"  autocomplete="image" autofocus >
                        </div>
                    </div>
                   <input type="hidden" name="ord_mod_req_id" value="{{ $item->id }}">
                   <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                   <button type="submit" class="btn green waves-effect waves-light" id="submitordModCreateForm">Submit</button>
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
