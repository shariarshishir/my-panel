<div id="confirm-order-modification-modal" class="confirm-order-modification-details-modal modal modal-fixed-footer">
    <div class="modal-content">
        <div class="row">
            <legend>Order Details</legend>
        </div>
        <div class="row product-details-table-block">
            <div class="col s12">
                {{-- <form action="#" method="get" name="ordModConfirmForm" id="ordModConfirmForm" > --}}
                    @csrf
                    <div class="form-group row">
                        <div class="color-and-size-block">
                            <div class="no_more_tables">
                                <table class="color-size-table-block ">
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
                                    <tbody class="confirm-ord-mod-color-sizes">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:30px 15px;">
                       <p>Total Quantity: <span class="ord-mod-total-quantity"></span></p>
                       <p >Unit Price: <span class="ord-mod-unit-price"></span></p>
                       <p>Discount: <span class="ord-mod-discount"></span></p>
                       <p>Total Price:    <span class="ord-mod-total-price"></span></p>
                    </div>
                    <div class="form-group input-field row">
                        <div class="col s12 m4 l3">
                            <div class="col s12">
                                <label for="image" class="col-md-4 col-form-label text-md-right">Modified Image</label>
                            </div>
                            <div class="col s12">
                                <img class="ord-mod-mod-image" src="" alt="preview image">
                            </div>
                        </div>

                        <div class="col s12 m4 l3">
                            <div class="col s12">
                                <label for="image" class="col-md-4 col-form-label text-md-right">Original Image</label>
                            </div>
                            <div class="col s12">
                                <img class="ord-mod-pre-image" src="" alt="preview image" >
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="ord_mod_unit_price" value="">
                    <input type="hidden" name="ord_mod_quantity" value="">
                    <input type="hidden" name="ord_mod_sku" value="">
                    <input type="hidden" name="ord_mod_req_id" value="">
                    <input type="hidden" name="ord_mod_total_price" value="">
                    <input type="hidden" name="ord_mod_discount_amount" value="">

                    {{-- @if(!$item->orderModification->orderItem) --}}
                     <button type="submit" class="btn_green waves-effect waves-light" id="submitordModConfirmForm" style="padding: 8px 20px;">Add To Cart</button>
                    {{-- @endif --}}
                     {{-- </form> --}}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div>
</div>
