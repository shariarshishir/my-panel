@push('js')
    <script>
        $(document).ready(function(){
            $('form#po-generate-form').submit(function(){
                $(this).find('.submit_po_form').prop('disabled', true);
            });
        })
        function addShippingDetails()
        {
            var shippingDetailsInputField = '<tr>';
            shippingDetailsInputField += '<td data-title="Shipping Method">';
            shippingDetailsInputField += '<select name="shipping_details_method[]" class="select-shipping-method" style="width: 100%"  >';
            shippingDetailsInputField += '<option value="">Select</option>';
            shippingDetailsInputField += '@foreach($shippingMethods as $shippingMethod)';
            shippingDetailsInputField += '<option value="{{ $shippingMethod->id }}">{{ $shippingMethod->name }}</option>';
            shippingDetailsInputField += '@endforeach';
            shippingDetailsInputField += '</select>';
            shippingDetailsInputField += '</td>';
            shippingDetailsInputField += '<td data-title="Shipment Type">';
            shippingDetailsInputField += '<select name="shipping_details_type[]" class="select-shipping-type" style="width: 100%"  >';
            shippingDetailsInputField += '<option value="">Select</option>';
            shippingDetailsInputField += '@foreach($shipmentTypes as $shipmentType)';
            shippingDetailsInputField += '<option value="{{ $shipmentType->id }}">{{ $shipmentType->name }}</option>';
            shippingDetailsInputField += '@endforeach';
            shippingDetailsInputField += '</select>';
            shippingDetailsInputField += '</td>';
            shippingDetailsInputField += '<td data-title="UOM">';
            shippingDetailsInputField += '<select name="shipping_details_uom[]" class="select-uom" style="width: 100%" >';
            shippingDetailsInputField += '<option value="">Select</option>';
            shippingDetailsInputField += '@foreach($uoms as $uom)';
            shippingDetailsInputField += '<option value="{{ $uom->id }}">{{ $uom->name }}</option>';
            shippingDetailsInputField += '@endforeach';
            shippingDetailsInputField += '</select>';
            shippingDetailsInputField += '</td>';
            shippingDetailsInputField += '<td data-title="Per UOM Price ($)"> ';
            shippingDetailsInputField += '<input type="number" class="form-control unit" step="any" style="border:1px solid #ccc; margin-bottom:0;" name="shipping_details_per_uom_price[]"  onkeyup="changeunit(this)" required/>';
            shippingDetailsInputField += '</td>';
            shippingDetailsInputField += '<td data-title="QTY">';
            shippingDetailsInputField += '<input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="shipping_details_qty[]" onkeyup="changeunitprice(this)" required/>';
            shippingDetailsInputField += '</td>';
            shippingDetailsInputField += '<td data-title="Total ($)">';
            shippingDetailsInputField += '<input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="shipping_details_total[]" readonly/>';
            shippingDetailsInputField += '</td>';
            shippingDetailsInputField += '<td><a href="javascript:void(0);" class="ic-btn4" onclick="removeShippingDetails(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td>';
            shippingDetailsInputField += '</tr>';
            $('#shipping-details-table-body').append(shippingDetailsInputField);
            $('.select-shipping-type').select2();
            $('.select-shipping-method').select2();
            $('.select-uom').select2();
        }

        function removeShippingDetails(el)
        {
            $(el).parent().parent().remove();
        }

        function addlineitem()
        {
            var lineitemcontent = '<tr><td data-title="Sl. No."></td><td data-title="Item / Description">';
            lineitemcontent  += '<input type="text" class="item_title form-control" name="item_title[]" required/>';
            lineitemcontent  +='</td><td data-title="Quantity" ><input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" onkeyup="changeunit(this)" required/></td><td data-title="Unit Price*"><input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" onkeyup="changeunitprice(this)" required/></td><td data-title="Sub Total"><input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" readonly/><input type="hidden" class="taxprice" name="tax[]" value="0" /></td><td data-title="Total Price"><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]" readonly/></td><td><a href="javascript:void(0);" class="ic-btn4" onclick="removelineitem(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td></tr>';
            $('#lineitems').append(lineitemcontent);
            for(var i = 0; i < $('#lineitems').children().length; i++)
            {
                $('#lineitems').children().eq(i).children().eq(0).html((i + 1));
            }
        }

        function removelineitem(el)
    {
        $(el).parent().parent().remove();
        for(var i = 0; i < $('#lineitems').children().length; i++)
        {
            $('#lineitems').children().eq(i).children().eq(0).html((i + 1));
        }
        let unit = "";
        let totalp = 0;
        let totaltax = 0;
        let $j_object = $(".tax_total_price");
        $j_object.each( function(){
            let taxp = $(this).closest("tr").find(".total_price").val() != "" ? parseFloat($(this).closest("tr").find(".total_price").val()) : 0;
            totaltax += parseFloat(parseFloat($(this).val()) - taxp);
            totalp += parseFloat($(this).val());
        });
        $('#total_price_amount').html(unit+' '+totalp.toFixed(2));
        //$('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
    }

    function changeunit(el)
    {
        let unit = $(el).val() != "" ? parseInt($(el).val()) : 0;
        let tax = $(el).closest("tr").find(".taxprice").val() != "" ? parseFloat($(el).closest("tr").find(".taxprice").val()) : 0;
        let unitprice = $(el).closest("tr").find(".unit_price").val() != "" ? parseFloat($(el).closest("tr").find(".unit_price").val()) : 0;
        let total = unit * unitprice;
        let taxtotal = total + (total * (tax / 100));
        $(el).closest("tr").find(".total_price").val(parseFloat(total).toFixed(2));
        $(el).closest("tr").find(".tax_total_price").val(parseFloat(taxtotal).toFixed(2));

        let totalp = 0;
        let totaltax = 0;
        let $j_object = $(".tax_total_price");
        $j_object.each( function(){
            let taxp = $(this).closest("tr").find(".total_price").val() != "" ? parseFloat($(this).closest("tr").find(".total_price").val()) : 0;
            totaltax += parseFloat(parseFloat($(this).val()) - taxp);
              totalp += parseFloat($(this).val());
        });
        $('#total_price_amount').html('    '+totalp.toFixed(2));
        //$('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
    }

    function changeunitprice(el)
    {
        let unitprice = $(el).val() != "" ? parseFloat($(el).val()) : 0;
        let unit = $(el).closest("tr").find(".unit").val() != "" ? parseFloat($(el).closest("tr").find(".unit").val()) : 0;
        let tax = $(el).closest("tr").find(".taxprice").val() != "" ? parseFloat($(el).closest("tr").find(".taxprice").val()) : 0;
        let total = unit * unitprice;
        let taxtotal = total + (total * (tax / 100));
        $(el).closest("tr").find(".total_price").val(parseFloat(total).toFixed(2));
        $(el).closest("tr").find(".tax_total_price").val(parseFloat(taxtotal).toFixed(2));

        let totalp = 0;
        let totaltax = 0;
        let $j_object = $(".tax_total_price");
        $j_object.each( function(){
            let taxp = $(this).closest("tr").find(".total_price").val() != "" ? parseFloat($(this).closest("tr").find(".total_price").val()) : 0;
            totaltax += parseFloat(parseFloat($(this).val()) - taxp);
              totalp += parseFloat($(this).val());
        });
        $('#total_price_amount').html(' '+totalp.toFixed(2));
        //$('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
    }

    function addMoreTermAndCondition()
    {
        var html  = '<li class="list-group-item ">';
            html += '<div class="input-group input-field">';
            html += '<input class="form-control" type="text"  name="terms_conditions[]" placeholder="Terms and condition" value="">';
            html +='<td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeTermAndCondition(this)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
            html += '</li>';
            $('.more-term-and-condition-unorder-list').append(html);
    }
    function removeTermAndCondition(el)
    {
        $(el).parent().remove();
    }

    function addShippingDetailsFile()
    {
        var html = '<tr>';
        html +='<td><input class="input-field form-control" name="shipping_details_file_names[]" id="shipping-details-title" type="text"  ></td>';
        html +='<td><input class="input-field form-control file_upload" name="shipping_details_files[]" id="shipping-details-file" type="file"></td>';
        html +='<td class="right-align"><a href="javascript:void(0);" class="btn_delete" onclick="removeShippingDetailsFile(this)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
        html +='</tr>';
        $('.shipment-file-upload-table-block tbody').append(html);
    }

    function removeShippingDetailsFile(el)
    {
        $(el).parent().parent().remove();
    }

    </script>
@endpush
