@push('js')

<script>
    // var serverURL = "{{ env('CHAT_URL'), 'localhost' }}:3000";
    // var socket = io.connect(serverURL);
    // socket.on('connect', function(data) {
    //     //alert('connect');
    // });
    var selectedBuyerId = "{{ request()->route()->parameters['id'] ??$po->buyer_id }}";
    //alert(selectedBuyerId);
    var allbuyer = @json($buyers);
    var unit = '';
    // var lineitemcontent = '<tr><td></td><td><select class="select-product" style="width: 100%" onchange="changecat(this)"><option value="">Select Products</option>@foreach($products as $product) <option value="{{$product->id}}">{{$product->title}}</option> @endforeach</select><input type="hidden" name="supplier[]" required/><input type="hidden" name="product[]" required/><input type="hidden" name="price_unit[]" required/><span class="supplier_details" style="color: #50AA5B;"></span></td><td style="position:relative;"><div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div><input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" onkeyup="changeunit(this)" required/></td><td style="position:relative;"><div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div><input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" onkeyup="changeunitprice(this)" required/></td><td><input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" readonly/></td><td><select class="form-control taxprice" onchange="changetaxprice(this)" name="tax[]"><option value="0">No Tax (0%)</option><option value="10">VAT (10%)</option></select></td><td><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]" readonly/></td><td><a href="javascript:void(0);" class="ic-btn4" onclick="removelineitem(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td></tr>';
    var lineitemcontent = '<tr><td></td><td><select class="select-product product-dropdown" style="width: 100%" onchange="changecat(this)"><option value="">Select Products</option>@foreach($products as $product) <option value="{{$product->id}}">{{$product->title}}</option> @endforeach</select><input type="hidden" name="supplier[]" required/><input type="hidden" name="product[]" required/><input type="hidden" name="price_unit[]" required/><span class="supplier_details" style="color: #50AA5B;"></span></td><td><input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" onkeyup="changeunit(this)" required/></td><td><input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" onkeyup="changeunitprice(this)" required/></td><td><input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" readonly/><input type="hidden" class="taxprice" name="tax[]" value="0" /></td><td><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]" readonly/></td><td><a href="javascript:void(0);" class="ic-btn4" onclick="removelineitem(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td></tr>';
    
    

    function getbuyerdetails(id)
    {
        //alert(id);
        /*
        var buyer = {};
        for(var i = 0; i < allbuyer.length; i++)
        {
            if(id == allbuyer[i].id.toString())
            {
                buyer = allbuyer[i];
            }
        }
        if($.isEmptyObject(buyer) != true)
        {
            let html = '<h3>'+buyer.name+'</h3> <address> '+ buyer.street +'<br>'+ buyer.city +', '+ buyer.state +'<br>'+ buyer.country +', '+ buyer.zipcode +' </address>';
            $('#buyerdata').html(html);
        }
        */
        $.ajax({
            method: 'get',
            data: {selectedUserId:id},
            url: '{{ route("rfqbuyer.details") }}',
            beforeSend: function() {},
            success:function(response){
                //console.log(response.data[0]);
                var html = '<h3>'+response.data[0].name+'</h3> <address> '+ response.data[0].email +'<br>'+ response.data[0].phone +' </address>';
                $('#buyerdata').html(html);
            }
        });
    }

    function getProductListBybusinessProfileId(id)
    {
        $.ajax({
            method: 'get',
            data: {id:id},
            url: '{{ route("product_list.by_profile_id") }}',
            success:function(response){
                console.log(response.products);
                $('.product-dropdown').empty();
                $('.product-dropdown').append('<option value="">Select Products</option>');
                $.each(response.products,function(index,product){
                    $('.product-dropdown').append('<option value="'+product.id+'">'+product.title+'</option>');
                });
            }
        });
    }
    if(selectedBuyerId){
        getbuyerdetails(selectedBuyerId);
    }
    function addlineitem()
    {
        var businessProfileId= $( "#buyerOptionsList option:selected" ).val();
        $.ajax({
            method: 'get',
            data: {id:businessProfileId},
            url: '{{ route("product_list.by_profile_id") }}',
            success:function(response){
                var lineitemcontent = '<tr><td data-title="Sl. No."></td><td data-title="Item / Description">';
                lineitemcontent  += '<select class="select-product product-dropdown" style="width: 100%" onchange="changecat(this)">';
                lineitemcontent  +='<option value="">Select Products</option>';
                $.each(response.products,function(index,product){
                    lineitemcontent  += '<option value="'+product.id+'">'+product.title+'</option>';
                });
                lineitemcontent  +='</select><input type="hidden" name="supplier[]" required/><input type="hidden" name="product[]" required/><input type="hidden" name="price_unit[]" required /><span class="supplier_details" style="color: #50AA5B;"></span></td><td data-title="Quantity" ><input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" onkeyup="changeunit(this)" required/></td><td data-title="Unit Price*"><input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" onkeyup="changeunitprice(this)" required/></td><td data-title="Sub Total"><input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" readonly/><input type="hidden" class="taxprice" name="tax[]" value="0" /></td><td data-title="Total Price"><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]" readonly/></td><td><a href="javascript:void(0);" class="ic-btn4" onclick="removelineitem(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td></tr>';
                $('#lineitems').append(lineitemcontent);
                $('.select-product').select2();
                for(var i = 0; i < $('#lineitems').children().length; i++)
                {
                    $('#lineitems').children().eq(i).children().eq(0).html((i + 1));
                }
            }
        });
        

        
    }
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
        shippingDetailsInputField += '<input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="shipping_details_per_uom_price[]"  onkeyup="changeunit(this)" required/>';
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

    function removelineitem(el)
    {
        $(el).parent().parent().remove();
        for(var i = 0; i < $('#lineitems').children().length; i++)
        {
            $('#lineitems').children().eq(i).children().eq(0).html((i + 1));
        }

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
        $('#total_price_amount').html(unit+' '+totalp.toFixed(2));
        //$('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
    }

    function changetaxprice(el)
    {
        let tax = $(el).val() != "" ? parseInt($(el).val()) : 0;
        let total = $(el).closest("tr").find(".total_price").val() != "" ? parseFloat($(el).closest("tr").find(".total_price").val()) : 0;
        let taxtotal = total + (total * (tax / 100));
        $(el).closest("tr").find(".tax_total_price").val(parseFloat(taxtotal).toFixed(2));

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

    function changeunitprice(el)
    {
        let unitprice = $(el).val() != "" ? parseFloat($(el).val()) : 0;
        let unit = $(el).closest("tr").find(".unit").val() != "" ? parseInt($(el).closest("tr").find(".unit").val()) : 0;
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
        $('#total_price_amount').html(unit+' '+totalp.toFixed(2));
        //$('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
    }

    var selectedel = null;

    function changecat(el)
    {
        selectedel = el;
        let product = encodeURIComponent(el.value);
        var url = '{{ route("getsupplierbycat", ":slug") }}';
            url = url.replace(':slug', product);
        $.ajax({
            method: 'get',
            url: url,
            success:function(response){
                $( "#modal_body" ).html( response );
            }
        });
        // $.get( "{{ env('APP_URL') }}/getsupplierbycat/"+product, function( data ) {
        //       $( "#modal_body" ).html( data );
        // });
        $('#selectcat').modal('open');
    }

    function addsupplier()
    {
        if(typeof $('input[name="exampleRadios"]:checked').val() != "undefined")
        {
            let product_id = $('input[name="exampleRadios"]:checked').val();
            let supplier_id = $('input[name="exampleRadios"]:checked').closest('td').find('input[name=s_id]').val();
            let price = $('input[name="exampleRadios"]:checked').closest('td').find('input[name=p_price]').val();
            let price_unit = $('input[name="exampleRadios"]:checked').closest('td').find('input[name=s_price_unit]').val();
            let moq = $('input[name="exampleRadios"]:checked').closest('td').find('input[name=p_unit]').val();
            let radiohtml = $('input[name="exampleRadios"]:checked').closest('td').find('input[name=s_name]').val();
            // let supplier_id = $('input[name="exampleRadios"]:checked').next().val();
            // let price = $('input[name="exampleRadios"]:checked').next().next().val();
            // let price_unit = $('input[name="exampleRadios"]:checked').next().next().next().next().next().val();
            // let moq = $('input[name="exampleRadios"]:checked').next().next().next().val();
            // let radiohtml = $('input[name="exampleRadios"]:checked').next().next().next().next().val();
            let tax = $(selectedel).closest("tr").find(".taxprice").val() != "" ? parseFloat($(selectedel).closest("tr").find(".taxprice").val()) : 0;
            if(price_unit == unit || unit == '')
            {
                unit = price_unit;
                $(selectedel).closest("tr").find('input[name="supplier[]"]').val(supplier_id);
                $(selectedel).closest("tr").find('input[name="product[]"]').val(product_id);
                $(selectedel).closest("tr").find('input[name="price_unit[]"]').val(price_unit);
                $(selectedel).closest("tr").find('input[name="unit_price[]"]').val(price);
                $(selectedel).closest("tr").find('input[name="unit[]"]').val(moq);
                $(selectedel).closest("tr").find('.supplier_details').html(radiohtml);

                let total = parseInt(moq) * parseFloat(price);
                let taxtotal = total + (total * (tax / 100));
                $(selectedel).closest("tr").find(".total_price").val(parseFloat(total).toFixed(2));
                $(selectedel).closest("tr").find(".tax_total_price").val(parseFloat(taxtotal).toFixed(2));
                $( "#modal_body" ).html('');
                $("#selectcat").modal('close');

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
            else
            {
                alert('Please select same price unit product.');
            }
        }
        else
        {
            alert('Select a supplier atleast');
        }
    }
    /*
    var selectedBuyerId = 0;
    document.getElementById("buyerOptionsList").addEventListener("change", function() {
        selectedBuyerId = document.getElementById("buyerOptionsList").value;
    });
    */

    // function sendMessageToBuyer()
    // {
    //     let message = {'message': 'Please see the PO at {{ $app->make('url')->to('/') }}/pro-forma-invoices and let me know your comments.','from_id' : "{{Auth::user()->id}}", 'to_id' : selectedBuyerId};
    //     socket.emit('new message', message);
    //     setTimeout(function(){
    //         window.location.href = "/message-center?uid="+selectedBuyerId;
    //     }, 1000);
    // }

    function addShippingDetailsFile()
    {
        var html = '<tr>';
        html +='<td><input class="input-field form-control" name="shipping_details_file_names[]" id="shipping-details-title" type="text"  ></td>';
        html +='<td><input class="input-field file_upload form-control" name="shipping_details_files[]" id="shipping-details-file" type="file"></td>';
        html +='<td class="right-align"><a href="javascript:void(0);" class="btn_delete" onclick="removeShippingDetailsFile(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span> </a></td>';
        html +='</tr>';
        $('.shipment-file-upload-table-block tbody').append(html);
    }

    function removeShippingDetailsFile(el)
    {
        $(el).parent().parent().remove();
    }

    function addMoreTermAndCondition()
    {
        
                                                    
        var html  = '<li class="list-group-item ">';
            html += '<div class="input-group input-field">';
            html += '<input class="form-control" type="text"  name="terms_conditions[]" placeholder="Terms and condition" value="">';
            html +='<td><a href="javascript:void(0);" class="btn_delete" onclick="removeTermAndCondition(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span> </a></td>';
            html += '</li>';
            $('.more-term-and-condition-unorder-list').append(html);
    }
    function removeTermAndCondition(el)
    {
        $(el).parent().remove();
    }


    
    $(document).ready(function(){
            $(document).on('click', '.terms-edit-trigger' , function(){ 
                $(this).hide();
                $(this).closest(".input-group").find(".terms-label").hide();
                $(this).closest(".input-group").find(".terms-edit-field").show();
                $(this).closest(".input-group").find(".terms-save-trigger").show();
                $(this).closest(".input-group").find(".terms-cancel-trigger").show();
            });

            $(document).on('click', '.terms-cancel-trigger' , function(){
                $(this).hide();
                $(this).closest(".input-group").find(".terms-save-trigger").hide();
                $(this).closest(".input-group").find(".terms-edit-trigger").show();
                $(this).closest(".input-group").find(".terms-edit-field").hide();
                $(this).closest(".input-group").find(".terms-label").show();
            });

            $(document).on('click', '.terms-save-trigger' , function(){
                $(this).hide();
                $(this).closest(".input-group").find(".terms-cancel-trigger").hide();
                $(this).closest(".input-group").find(".terms-edit-trigger").show();
                $(this).closest(".input-group").find(".terms-edit-field").hide();
                $(this).closest(".input-group").find(".terms-label").show();

                inputVal = $(this).closest(".input-group").find(".terms-edit-value-field").val();
                $(this).closest(".input-group").find(".terms-label span").text(inputVal);
                $(this).closest(".input-group").find(".terms-label .checkbox").val(inputVal);
                
            });

        // $(".buyerOptionsList").click(function(){
        //     $.ajax({
        //     method: 'get',
        //     data: {id:id},
        //     url: '{{ route("product_list.by_profile_id") }}',
        //     success:function(response){
        //         $('.product-dropdown').empty();
        //         $('.product-dropdown').append('<option value="">Select Products</option>');
        //         $.each(response.products,function(index,product){
        //             $('.product-dropdown').append('<option value="'+product.id+'">'+product.title+'</option>');
        //         });
        //     }
        // });
        
    });
</script>

@endpush
