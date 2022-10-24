<div id="non_clothing_block" class="modal modal-fixed-footer cart_fresh_order_customize_block">
    <div class="modal-content">
        <form action="{{route('cart.update')}}" method="POST">
            @csrf

            <div class="no_more_tables">
                <table class="color-size-table-block striped" width="100%" cellpadding="0" cellspacing="0">
                    <thead class="cf">
                        <tr>
                            <th>Color</th>
                            <th>Qunatity</th>
                            <!-- <th>&nbsp;</th> -->
                        </tr>
                    </thead>
                    <tbody class=" edit-non-clothing-color-quantity-block">

                    </tbody>
                </table>
            </div>
            
            <div class="add_more_colors_sizes">

            </div>

            <div class="total-price-block" style="display: none;">
                <div class="input-wrapper">
                    <label>Total Qty:</label>
                    <span class="item_total_qty"></span>
                </div>
                <div class="input-wrapper">
                    <label>Unit Price:</label>
                    <span class="item_unit_price"></span>
                </div>
                <div class="input-wrapper">
                    <label>Total Price:</label>
                    <span class="item_total_price"></span>
                </div>
            </div>
            <div class="check_copyright_price">

            </div>
            <input type="hidden" name="product_sku" value="">
            <div class="price-calculation-notification" style="display: none;">
                <div class="card-alert card cyan">
                    <div class="card-content white-text" style="padding: 10px;">
                        Please click on calculate price button. To get updated price calculation.
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="waves-effect waves-green btn-flat price-calculation">Calculate Total Price</a>
                <input type="hidden" name="cart_quantity" class="updatedStockQty" value="" />
                <input type="hidden" name="unit_price" class="updatedUnitPrice" value="" />
                <input type="hidden" name="total_price" class="updatedTotalPrice" value="" />
                <input type="hidden" name="rowId" value="" >
                <input type="hidden" name="product_type" value="" />
                <button type="submit" id="updateCartItem_readystock" class="btn waves-effect waves-light green updateCartItem_readystock" disabled="disabled" >Update</button>
                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
            </div>
        </form>
</div>
