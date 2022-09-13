@extends('layouts.app')

@section('content')
@php
//echo "<pre>"; print_r($selectedproduct); echo "</pre>";
$editProductArray = array();
foreach($selectedproduct as $item)
{
	//echo "<pre>"; print_r($item->performa_items); echo "</pre>";
	$editProductArray['id'] = $item->id;
	$editProductArray['buyer_id'] = $item->buyer_id;
	$editProductArray['proforma_id'] = $item->proforma_id;
	$editProductArray['proforma_date'] = $item->proforma_date;
	$editProductArray['payment_within'] = $item->payment_within;
	$editProductArray['po_no'] = $item->po_no;
	$editProductArray['condition'] = $item->condition;
	$editProductArray['reject_message'] = $item->reject_message;
	$editProductArray['status'] = $item->status;
	$editProductArray['created_at'] = $item->created_at;
	$editProductArray['updated_at'] = $item->updated_at;

	foreach($item->performa_items as $key => $productItem)
	{
		//echo "<pre>"; print_r($productItem); echo "</pre>";
		$editProductArray['productitem'][$key]['product_id'] = $productItem->product_id;
		$editProductArray['productitem'][$key]['supplier_id'] = $productItem->supplier_id;
		$editProductArray['productitem'][$key]['created_at'] = $productItem->created_at;
		$editProductArray['productitem'][$key]['unit'] = $productItem->unit;
		$editProductArray['productitem'][$key]['unit_price'] = $productItem->unit_price;
		$editProductArray['productitem'][$key]['price_unit'] = $productItem->price_unit;
		$editProductArray['productitem'][$key]['tax'] = $productItem->tax;
		$editProductArray['productitem'][$key]['total_price'] = $productItem->total_price;
		$editProductArray['productitem'][$key]['tax_total_price'] = $productItem->tax_total_price;
	}
}
//echo "<pre>"; print_r($editProductArray); echo "</pre>";
@endphp
<div class="main_content_wrapper invoice_container_wrap">
    <div class="card">
        <div class="invoice_page_header">
            <legend class="">
                <i class="fa fa-table fa-fw "></i> Create Pro-Forma Invoice
            </legend>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- <div class="col-md-12">
                <div style="height: 25px; width: 0px; border-left: 5px solid rgb(255, 0, 0); display: inline;"></div>
                <span style="padding-left: 10px; font-size: 12px; color: rgb(255, 0, 0);">Indicates Mandatory field</span>
            </div> -->
        </div>

         <!-- widget grid -->
         <section id="widget-grid" class="pro_porma_invoice">

            <div class="row">
                <div class="col s12 m6 l6"></div>
                <div class="col s12 m6 l6"></div>
            </div>
                <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-12">
                    {{-- @include('flash::message') --}}
                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget jarviswidget-color-darken no-padding" id="wid-id-0" data-widget-editbutton="false">

                        <!-- widget content -->
                        <div class="widget-body p-0">
                            <form action="{{route('po.store')}}" method="post" >
                            @csrf
                                <!-- <div style="padding-top: 30px;"></div> -->
                                <div class="row">
                                    <!-- <div class="col s12 m6 l6"> -->
                                    <div class="col s12 m6 l5 input-field">
                                        <div class="col-md-12" style="display: none;">
                                            <div class="form-group has-feedback">
                                                <label>Select Buyer</label>
                                                <select name="buyer" id="buyerOptionsList" class="form-control" onChange="getbuyerdetails(this.value)">
                                                    <option value="">--Select Buyer--</option>
                                                    @foreach($buyers as $buyer)
                                                        <option value="{{$buyer['id']}}">{{ucfirst($buyer['name'])}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="buyerdata"></div>
                                        <input type="hidden" name="selected_buyer_id" value="{{ Request::get('toid') }}" />
                                    </div>
                                    <div class="col s12 m6 l7 input-field">
                                        <div class="form-group has-feedback">
                                            <label>Pro-forma ID <span class="required_star" style="color: rgb(255, 0, 0)" >*</span> </label>
                                            <input type="text" class="form-control" value="{{ ($editProductArray['proforma_id'] != '' ? $editProductArray['proforma_id'] : '') }}" readonly required name="po_id"/>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                            <label>Pro-forma Date <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                            <input type="date" class="form-control" value="{{ ($editProductArray['proforma_date'] != '' ? $editProductArray['proforma_date'] : '') }}"  required name="po_date"/>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                            <label>Payment Within <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                            <select class="select2" required name="payment_within">
                                                <option value="On Delivery"  {{ ($editProductArray['payment_within'] == 'On Delivery' ? 'selected="selected"' : '') }}>On Delivery</option>
                                                <option value="Immediate" {{ ($editProductArray['payment_within'] == 'Immediate' ? 'selected="selected"' : '') }}>Immediate</option>
                                                <option value="Within 7 Days" {{ ($editProductArray['payment_within'] == 'Within 7 Days' ? 'selected="selected"' : '') }}>Within 7 Days</option>
                                                <option value="Within 15 Days" {{ ($editProductArray['payment_within'] == 'Within 15 Days' ? 'selected="selected"' : '') }}>Within 15 Days</option>
                                                <option value="Within 30 Days" {{ ($editProductArray['payment_within'] == 'Within 30 Days' ? 'selected="selected"' : '') }}>Within 30 Days</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <div class="line_item_wrap">
                                    <legend>Line Items</legend>
                                    <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">Sl. No.</th>
                                                <th style="width:15%;">Item / Description</th>
                                                <th style="width:15%;">Quantity</th>
                                                <th style="width:15%;">Unit Price</th>
                                                <th style="width:15%;">Sub Total</th>
                                                <!-- <th style="width:15%;">Tax</th> -->
                                                <th style="width:15%;">Total Price</th>
                                                <th style="width:5%; text-align:center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="lineitems" class="input-field">
                                            @foreach($editProductArray['productitem'] as $key =>  $selectedProInfo)
                                                <tr>
                                                    <td data-title="">1</td>
                                                    <td>
                                                        <select class="select2" onchange="changecat(this)">
                                                            <option value="">Select Products</option>

                                                            @foreach($products as $product)
                                                                @php $productTitle = explode('_', $product) @endphp
                                                                <option {{ ($selectedProInfo['product_id'] == $productTitle[0] ? 'selected="selected"' : '') }} value="{{ $productTitle[0] }}">
                                                                {{ $productTitle[1] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="supplier[]" value="{{ $selectedProInfo['supplier_id'] }}" required/>
                                                        <input type="hidden" name="product[]" value="{{ $selectedProInfo['product_id'] }}" required/>
                                                        <input type="hidden" name="price_unit[]" value="{{ $selectedProInfo['unit_price'] }}" required/>
                                                        <span class="supplier_details" style="color: #50AA5B;"></span>
                                                    </td>
                                                    <td style="position: relative;"> <span class="required_star" style="position: absolute; top:10; right:11px;">*</span>
                                                        <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div> -->
                                                        <input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" value="{{$selectedProInfo['unit']}}" onkeyup="changeunit(this)" required/>
                                                    </td>
                                                    <td style="position: relative;"> <span class="required_star" style="position: absolute; top:10; right:11px;">*</span>
                                                        <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div> -->
                                                        <input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" value="{{$selectedProInfo['unit_price']}}"  onkeyup="changeunitprice(this)" required/>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" value="{{$selectedProInfo['total_price']}}"  readonly/>
                                                        <input type="hidden" class="taxprice" name="tax[]" value="0" />
                                                    </td>
                                                    <td><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]"  value="{{$selectedProInfo['tax_total_price']}}" readonly/></td>
                                                    @if($key == 0)
                                                        <td><a href="javascript:void(0);" class="ic-btn4" onclick="addlineitem()"><i aria-hidden="true" class="fa fa-plus fa-lg"></i></a></td>
                                                    @else
                                                        <td><a href="javascript:void(0);" class="ic-btn4red" onclick="removelineitem(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <!--tr>
                                                <td colspan="6" align="right"><b>Total Tax</b></td>
                                                <td colspan="2" align="left" id="total_tax_price_amount">0.00</td>
                                            </tr-->
                                            <tr>
                                                <td colspan="5"class="right-align"><b>Total Invoice Amount</b></td>
                                                <td colspan="2" align="left" id="total_price_amount">0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="invoice_terms_conditions">
                                    <legend>Terms & Conditions</legend>
                                    @php
                                        $conditions = json_decode($editProductArray['condition']);
                                        //echo "<pre>"; print_r($conditions); echo "</pre>";
                                    @endphp
                                    <div class="terms_conditions_list">
                                        <ul class="list-group terms-lists">
                                            <li class="list-group-item">
                                                <div class="input-group input-field">
                                                    <input type="text" class="form-control" Placeholder="Terms and Condition 1" value="{{ ($conditions[0] != '' ? $conditions[0] : '') }}" name="conditions[]" {{ ($conditions[0] != '' ? '' : 'readonly') }} >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <label>
                                                                <input type="checkbox" {{ ($conditions[0] != '' ? 'checked="checked"' : '') }} aria-label="Checkbox for following text input" onclick="$(this).parent().parent().parent().prev().prop('readonly', function(i, v) { return !v; });">
                                                                <span>Check to Edit</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group input-field">
                                                    <input type="text" class="form-control"  Placeholder="Terms and Condition 2" value="{{ ($conditions[1] != '' ? $conditions[1] : '') }}" name="conditions[]" {{ ($conditions[1] != '' ? '' : 'readonly') }} >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <label>
                                                                <input type="checkbox"  {{ ($conditions[1] != '' ? 'checked="checked"' : '') }} aria-label="Checkbox for following text input" onclick="$(this).parent().parent().parent().prev().prop('readonly', function(i, v) { return !v; });">
                                                                <span>Check to Edit</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group input-field">
                                                    <input type="text" class="form-control" Placeholder="Terms and Condition 3" value="{{ ($conditions[2] != '' ? $conditions[2] : '') }}" name="conditions[]" {{ ($conditions[2] != '' ? '' : 'readonly') }} >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <label>
                                                                <input type="checkbox" {{ ($conditions[2] != '' ? 'checked="checked"' : '') }} aria-label="Checkbox for following text input" onclick="$(this).parent().parent().parent().prev().prop('readonly', function(i, v) { return !v; });">
                                                                <span>Check to Edit</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group input-field">
                                                    <input type="text" class="form-control" Placeholder="Terms and Condition 4" value="{{ ($conditions[3] != '' ? $conditions[3] : '') }}" name="conditions[]" {{ ($conditions[3] != '' ? '' : 'readonly') }} >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <label>
                                                                <input type="checkbox" {{ ($conditions[3] != '' ? 'checked="checked"' : '') }} aria-label="Checkbox for following text input" onclick="$(this).parent().parent().parent().prev().prop('readonly', function(i, v) { return !v; });">
                                                                <span>Check to Edit</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group input-field">
                                                    <input type="text" class="form-control" Placeholder="Terms and Condition 5" value="{{ ($conditions[4] != '' ? $conditions[4] : '') }}" name="conditions[]" {{ ($conditions[4] != '' ? '' : 'readonly') }}>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <label>
                                                                <input type="checkbox" {{ ($conditions[4] != '' ? 'checked="checked"' : '') }} aria-label="Checkbox for following text input" onclick="$(this).parent().parent().parent().prev().prop('readonly', function(i, v) { return !v; });">
                                                                <span>Check to Edit</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="right">
                                    <button type="submit" class="btn_green btn-success">
                                        <i class="fa fa-send"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget -->
                </article>
                <!-- WIDGET END -->
            </div>

            <!-- end row -->

            <!-- end row -->
        </section>
        <!-- end widget grid -->

    </div>






</div>

<div class="modal" id="selectcat">
<div class="modal-dialog modal-xl" style="width:900px;">
    <div class="modal-content">

        <!--Modal Header-->
        <div class="modal-header modal-hdr-custum" style="background:#55A860; border-radius:4px 4px 0 0;">
            <div class="col-md-11"><h4 class="modal-title" style="color:#fff;"><b>Select Supplier</b></h4></div>
        </div>
        <!--Modal Header-->

        <!-- Modal body -->
        <div class="modal-body" id="modal_body">
            <!--Add Product Form-->
            <div class="col-md-12" style="margin-top: 33px;">
                <!--1-->

            </div>
            <!--/Add Product Form-->
        </div>
        <!-- Modal body -->
        <div class="clear"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal-close" >No</button>
            <button type="button" class="btn btn-danger" onclick="addsupplier()">Ok</button>
        </div>
    </div>
</div>
</div>


@endsection

@push('js')
<script>
    var serverURL = "{{ env('CHAT_URL'), 'localhost' }}:3000";
    var socket = io.connect(serverURL);
    socket.on('connect', function(data) {
        //alert('connect');
    });

    var selectedBuyerId = "{{ Request::get('toid') }}";
    //alert(selectedBuyerId);
    var allbuyer = @json($buyers);
    var unit = '';
    // var lineitemcontent = '<tr><td></td><td><select class="form-control" onchange="changecat(this)"><option value="">Select Products</option>@foreach($products as $product) @php $productTitle = explode('_', $product) @endphp <option value="{{$productTitle[1]}}">{{$productTitle[1]}}</option> @endforeach</select><input type="hidden" name="supplier[]" required/><input type="hidden" name="product[]" required/><input type="hidden" name="price_unit[]" required/><span class="supplier_details" style="color: #50AA5B;"></span></td><td style="position:relative;"><div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div><input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" onkeyup="changeunit(this)" required/></td><td style="position:relative;"><div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div><input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" onkeyup="changeunitprice(this)" required/></td><td><input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" readonly/></td><td><select class="form-control taxprice" onchange="changetaxprice(this)" name="tax[]"><option value="0">No Tax (0%)</option><option value="10">VAT (10%)</option></select></td><td><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]" readonly/></td><td><a href="javascript:void(0);" class="ic-btn4red" onclick="removelineitem(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td></tr>';
     var lineitemcontent = '<tr><td></td><td><select class="select-product" style="width: 100%" onchange="changecat(this)"><option value="">Select Products</option>@foreach($products as $product) @php $productTitle = explode('_', $product) @endphp <option value="{{$productTitle[0]}}">{{$productTitle[1]}}</option> @endforeach</select><input type="hidden" name="supplier[]" required/><input type="hidden" name="product[]" required/><input type="hidden" name="price_unit[]" required/><span class="supplier_details" style="color: #50AA5B;"></span></td><td style="position:relative;"><div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div><input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" onkeyup="changeunit(this)" required/></td><td style="position:relative;"><div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div><input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" onkeyup="changeunitprice(this)" required/></td><td><input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" readonly/><input type="hidden" class="taxprice" name="tax[]" value="0" /></td><td><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]" readonly/></td><td><a href="javascript:void(0);" class="ic-btn4red" onclick="removelineitem(this)"><i aria-hidden="true" class="fa fa-minus fa-lg"></i></a></td></tr>';
    function getbuyerdetails(id)
    {
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
    }
    if(selectedBuyerId){
        getbuyerdetails(selectedBuyerId);
    }

    function addlineitem()
    {
        $('#lineitems').append(lineitemcontent);
        $('.select-product').select2();
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

        let totalp = 0;
        let totaltax = 0;
        let $j_object = $(".tax_total_price");
        $j_object.each( function(){
            let taxp = $(this).closest("tr").find(".total_price").val() != "" ? parseFloat($(this).closest("tr").find(".total_price").val()) : 0;
            totaltax += parseFloat(parseFloat($(this).val()) - taxp);
              totalp += parseFloat($(this).val());
        });
        $('#total_price_amount').html(unit+' '+totalp.toFixed(2));
        $('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
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
        $('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
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
        $('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
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
        $('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
    }

    var selectedel = null;

    function changecat(el)
    {
        selectedel = el;
        let product = encodeURIComponent(el.value);
        $.get( "{{ env('APP_URL') }}/getsupplierbycat/"+product, function( data ) {
              $( "#modal_body" ).html( data );
        });
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
            // let product_id = $('input[name="exampleRadios"]:checked').val();
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
                $('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
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

    function sendMessageToBuyer()
    {
        let message = {'message': 'Please see the PO at {{ $app->make('url')->to('/') }}/pro-forma-invoices and let me know your comments.','from_id' : "{{Auth::user()->id}}", 'to_id' : selectedBuyerId};
        socket.emit('new message', message);
        setTimeout(function(){
            url= "{{ url('message-center')}}?uid="+selectedBuyerId;
            // window.location.href = "/message-center?uid="+selectedBuyerId;
            window.location.href =url ;
        }, 1000);
    }

    $(document).ready(function(){
        // Calculation of product price and taxes for old PO.
        let totalp = 0;
        let totaltax = 0;
        let $j_object = $(".tax_total_price");
        $j_object.each( function(){
            let taxp = $(this).closest("tr").find(".total_price").val() != "" ? parseFloat($(this).closest("tr").find(".total_price").val()) : 0;
            totaltax += parseFloat(parseFloat($(this).val()) - taxp);
              totalp += parseFloat($(this).val());
        });
        $('#total_price_amount').html(unit+' '+totalp.toFixed(2));
        $('#total_tax_price_amount').html(unit+' '+totaltax.toFixed(2));
    })
</script>
@endpush
