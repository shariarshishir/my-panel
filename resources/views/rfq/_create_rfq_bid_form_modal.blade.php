<div id="rfq-bid-modal" class="modal">
    <div class="modal-content">
        <form action="" method="post" enctype="multipart/form-data" id="rfq-bid-form">
            <div class="rfq_detail_from">
                @csrf
                <div id="rfq_bid_store_errors"></div>
                <div class="col-md-12">
                    <div class="row">
                        <span style="font-size: 12px; color: rgb(255, 0, 0); padding-bottom: 15px; display:block;">* Indicates Mandatory field</span>
                    </div>
                </div>
                <input type="hidden" name="rfq_id" value="">
                <div class="row input-field input-wrapper">
                    <div class="col s12 m4 l3">
                        <label for="producut-title">Select Business <span >*</span></label>
                    </div>
                    <div class=" col s12 m8 l9">
                        <select class="select2" name="business_profile_id" id="my_business_list" required>
                        </select>
                    </div>
                </div>

                <div class="row input-field input-wrapper">
                    <div class="col s12 m4 l3">
                        <label for="product-unit">Offer Price <span >*</span></label>
                    </div>
                    <div class="col s12 m8 l9">
                        <input type="text" id="product-unit" name="offer_price" class="form-control bid-price-range-value" placeholder="$ Price in USD/pc" value="" >
                        <span class="validation-error-unit-price red"></span>
                    </div>
                </div>
                <div class="row input-field input-wrapper">
                    <div class="col s12 m4 l3">
                        <label for="product-unit">Offer Unit Price <span >*</span></label>
                    </div>
                    <div class="col s12 m8 l9">
                        <select class="select2" name="offer_price_unit" id="offer_price_unit">
                            <option value="">Select an option</option>
                            @php $units = units(); @endphp
                            @foreach($units as $unit=>$value)
                                <option value="{{$unit}}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <!-- rfq_detail_from end -->

            <div class="submit_btn_wrap">
                <div class="row">
                    <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                    <div class="col s12 m6 l6 right-align">
                        <button type="submit" class="btn_green rfq-replay-submit right">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
<script type="text/javascript">

    $(document).on('change', '.bid-price-range-value', function(){
        var num = $(this).val();
        if($.isNumeric(num) == true){
            value = parseFloat(num).toFixed(2);
        }
        else{
            num=0;
            value = parseFloat(num).toFixed(2);
        }
        $(this).val(value);
    })


</script>

@endpush
