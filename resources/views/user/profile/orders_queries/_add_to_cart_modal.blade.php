
<div id="add-to-cart-order-query-modal" class="confirm-order-modification-details-modal modal modal-fixed-footer">
    <div class="modal-content">
        <legend>Details</legend>
        <div class="row order-top-block">
            <div class="order-info-top col m6">
                <p >Processed At: <span class="order-query-processed-date"></span></p>
            </div>
            <div class="order-status-block col m6">
                <p >Status: <span class="order-query-processed-status"></span></p>
            </div>
        </div>
        <div class="row product-details-table-block">
            <div class="col s12">
                {{-- <form action="#" method="get" name="ordModConfirmForm" id="ordModConfirmForm" > --}}
                    @csrf

                    <div class="form-group row">
                        <div class="color-and-size-block">
                            <table class="color-size-table-block ">
                                <thead>

                                </thead>
                                <tbody class="order-query-processed-color-sizes">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row order-query-processed-price-block order-modification-data" style="display: none">
                       <p>Unit Price: $<span class="order-query-processed-unit-price"></span></p>
                       <p>Total Quantity: <span class="order-query-processed-quantity"></span></p>
                       <p>Discount Amount: $<span class="order-query-processed-discount"></span></p>
                       <p>Total Price: $<span class="order-query-processed-total-price"></span></p>

                       <input type="hidden" name="ord_mod_unit_price" value="">
                       <input type="hidden" name="ord_mod_total_price" value="">
                       <input type="hidden" name="ord_mod_quantity" value="">
                       <input type="hidden" name="ord_mod_product_sku" value="">
                       <input type="hidden" name="order_modification_req_id" value="">
                       <input type="hidden" name="ord_mod_discount" value="">
                       <input type="hidden" name="ord_req_product_type" value="">

                       <button type="submit" class="btn green waves-effect waves-light" id="submitordModConfirmForm">Add To Cart</button>
                    </div>


                    {{-- @if(!$item->orderModification->orderItem) --}}

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
