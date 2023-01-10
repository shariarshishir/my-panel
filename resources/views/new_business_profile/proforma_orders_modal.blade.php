@if(($proforma->status != -1 && $proforma->status != 1))
<a href="{{route('new.profile.profoma_orders.accept',['alias'=>$alias,'proformaId'=>$proforma->id])}}" class="waves-effect waves-light btn_green po_accept_trigger">Accept</a>
<a href="javascript:void(0);" class="waves-effect waves-light btn_green po_reject_trigger">Reject</a>
@endif
<a href="javascript:void(0);" class="waves-effect waves-light btn_green po_print_trigger" onclick="printDiv('proforma-print-block');">
    <i class="fa fa-print fa-fw " aria-hidden="true"></i> Print
</a>
<div class="invoice_top_button_wrap"></div>


<div class="proforma_invoice_pdf_design_table_wrap">
    <div class="proformaInvoiceTiytle">
        <h3>Proforma Invoice</h3>
    </div>

    <table class="table table-bordered proforma_beneficiary_table">
        <thead>
            <tr>
                <th>PI No: <span>{{ $proforma->proforma_id }}</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-sm-12 col-md-12">
                    <div class="beneficiarybox">
                        <h6>Buyer Detail :</h6>
                        <div class="form-group has-feedback">
                            <p><b>Business Profile Name</b></p>
                            <p>Location</p>
                            <p> Date: <span>{{ $proforma->proforma_date }}</span></p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="buyerdata_info_admin">
        <div class="no_more_tables">
            <table class="table table-bordered proforma_item_info_table" style="text-align: center; border-bottom:1px solid #ccc; margin-bottom:15px;">
                <thead class="cf">
                    <tr>
                        <th>Sl. No.</th>
                        <th>Item / Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Sub Total</th>
                        <!-- <th style="width:15%;">Tax</th> -->
                        <th>Total Price</th>
                        <!-- <th style="width:5%; text-align:center;"></th> -->
                    </tr>
                </thead>
                <tbody id="lineitems" class="">
                    @foreach($proforma->performa_items as  $key => $proFormaItem)
                        <tr>
                            <td data-title="Sl. No.">{{$key+1 }}</td>
                            <td data-title="Item / Description">
                                <span>{{ $proFormaItem->item_title }}</span>
                            </td>
                            <td data-title="Quantity">
                                <span>{{ $proFormaItem->unit }}</span>
                            </td>
                            <td data-title="Unit Price">
                                <span>{{ $proFormaItem->unit_price }}</span>
                            </td>
                            <td data-title="Sub Total">
                                <span>{{ $proFormaItem->total_price }}</span>
                            </td>
                            <td data-title="Total Price">
                                <span>{{ $proFormaItem->tax_total_price }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="padding-right: 20px"><b>Sub Total: </b></td>
                    <td data-title="Sub Total:" colspan="2"><b>{{ number_format((float)$proforma->proforma_sub_total, 2, '.', '') }}</b></td>
                </tr>
                @if($proforma->proforma_commission)
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="padding-right: 20px">Commission:</td>
                    <td data-title="Commission:" colspan="2">{{ number_format((float)$proforma->proforma_commission, 2, '.', '') }} %</td>
                </tr>
                @endif
                @if($proforma->proforma_vat)
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="padding-right: 20px">Vat:</td>
                    <td data-title="Vat:" colspan="2">{{ number_format((float)$proforma->proforma_vat, 2, '.', '') }} %</td>
                </tr>
                @endif
                @if($proforma->proforma_tax)
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="padding-right: 20px">Tax:</td>
                    <td data-title="Tax:" colspan="2">{{ number_format((float)$proforma->proforma_tax, 2, '.', '') }} %</td>
                </tr>
                @endif
                <tr>
                    <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Grand Total: </b></td>
                    <td data-title="Grand Total:" colspan="2"><div><b id="proformaGrandTotal">{{ number_format((float)$proforma->proforma_grand_total, 2, '.', '') }}</b></div></td>
                </tr>
                @foreach($proforma->checkedMerchantAssistances as $assistance)
                <tr>
                    <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>{{$assistance->merchantAssistance->name}}: </b></td>
                    <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{ $assistance->merchantAssistance->amount }}<b> {{ $assistance->merchantAssistance->type=='Percentage' ? '%' :'USD'}} <b></td>
                </tr>
                @endforeach
                @if($proforma->total_invoice_amount_with_merchant_assistant)
                <tr>
                    <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Your total order amount with merchant assistant : </b></td>
                    <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{$proforma->total_invoice_amount_with_merchant_assistant}} <b> USD <b></td>
                </tr>
                @endif
                <tr>
                    <td colspan="6" style="text-align: left;">In Word:
                        <b><span id="totalResultFront"></span></b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @if($proforma->forwarder_name)
        <table class="table table-bordered proforma_forward_table" style="text-align: left;">
            <thead>
                <tr>
                    <th>Forwarder Name</th>
                    <th>Forwarder Address</th>
                    <th>Payable Party</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-title="forwarder Name">
                        <span> {{$proforma->forwarder_name}} </span>
                    </td>
                    <td data-title="forwarder Address">
                        <span> {{$proforma->forwarder_address}} </span>
                    </td>
                    <td data-title="Payable Party">
                        <span> {{$proforma->payable_party}} </span>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    <div class="no_more_tables">
        <table class="table table-bordered proforma_shipment_table" style="text-align: center;">
            <thead>
                <tr>
                    <th>Shipment Term</th>
                    <th>Place of Shipment</th>
                    <th>Mode of Transport</th>
                    <th>Place of Destination</th>
                    <th>UOM</th>
                    <th>Per UOM Price ($)</th>
                    <th>QTY</th>
                    <th>Total ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proforma->proFormaShippingDetails as $shippingDetails)
                    <tr>
                        <td data-title="Shipment Term">
                            <span>{{ $shippingDetails->shippingMethod->name }}</span>
                        </td>
                        <td data-title="Place of Shipment">Merchant Bay Ltd.</td>
                        <td data-title="Mode of Transport">
                            <span>{{ $shippingDetails->shipmentType->name }}</span>
                        </td>
                        <td data-title="Place of Destination">
                            <span>
                                @if($proforma->updated_buyer_shipping_address)
                                {{$proforma->updated_buyer_shipping_address}}
                                @else
                                {{$proforma->shipping_address}}
                                @endif
                            </span>
                        </td>
                        <td data-title="UOM">
                            <span>{{ $shippingDetails->uom->name }} </span>
                        </td>
                        <td data-title="Per UOM Price ($)">
                            <span>{{ $shippingDetails->shipping_details_per_uom_price }}</span>
                        </td>
                        <td data-title="QTY">
                            <span>{{ $shippingDetails->shipping_details_qty }}</span>
                        </td>
                        <td data-title="Total ($)">
                            <span>{{ $shippingDetails->shipping_details_total }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <table class="table proforma_advising_bank_table">
        <thead>
            <tr>
                <th>
                    <h3>Payment Info: </h3>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-title="Payment Info:">
                    <div class="conactInfo">
                        <p>Payment Within: <b><span> {{$proforma->payment_within ?? ""}} </span></b></p>
                        <p>Payment Term: <b><span> {{$proforma->paymentTerm->name ?? ""}} </span></b></p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table proforma_terms_onditions_table">
        <thead>
            <tr>
                <th>
                    <h3>Terms & Conditions</h3>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-title="Terms & Conditions">
                    <div class="terms_conditions_list buyerdata_info_admin">
                        <ul class="list-group terms-lists">
                            @foreach($proforma->supplierCheckedProFormaTermAndConditions as $supplierCheckedProFormaTermAndCondition)
                            <li class="list-group-item">
                                <div class="input-group">
                                    <label class="terms-label">
                                        <i class="fa fa-light fa-check"></i> <span>{{$supplierCheckedProFormaTermAndCondition->proFormaTermAndCondition->term_and_condition}}</span>
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <ul class="list-group terms-lists">
                            @foreach(json_decode($proforma->condition) as $key=>$condition)
                            <li class="list-group-item">
                                <div class="input-group">
                                    <label class="terms-label">
                                        <i class="fa fa-light fa-check"></i> <span>{{$condition}}</span>
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table proforma_advising_bank_table">
        <thead>
            <tr>
                <th>
                    <h3>Advising Bank: </h3>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-title="Advising Bank:">
                    <div class="conactInfo">
                        <p><b><span> {{$proforma->proFormaAdvisingBank->bank_name ?? ""}} </span></b></p>
                        <p><span>{{ $proforma->proFormaAdvisingBank->branch_name ?? "" }}</span></p>
                        <p><span> {{ $proforma->proFormaAdvisingBank->bank_address ?? "" }} </span></p>
                        <p>Swift code: <b> <span>{{ $proforma->proFormaAdvisingBank->swift_code ?? "" }}</span></b> </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="signature"><b>Authorized Signature</b></div>
</div>



{{-- <div class="invoice_page_header">
    <legend>
        <i class="fa fa-table fa-fw " aria-hidden="true"></i> Pro-Forma Invoice
    </legend>
</div>
<!-- widget grid -->
<section id="widget-grid" class="pro_porma_invoice">
    <!-- NEW WIDGET START -->
    <article class="">
        <div class="jarviswidget jarviswidget-color-darken no-padding" id="wid-id-0" data-widget-editbutton="false">
            <!-- widget content -->
            <div class="widget-body p-0">
                <div class="row buyerdata_info_top">
                    <div class="col s6 input-field" id="buyerdata">
                        <span><b> {{$proforma->buyer->name}} </b></span><br>
                        <span> {{$proforma->buyer->email}} </span>
                    </div>
                </div>
                <div class="input-field has_feedback_wrap">
                    <div class="row">
                        <div class="col s6 m4 l2">
                            <div class="form-group input-field has-feedback">
                                <label>Pro-forma ID</label>
                                <p><span>{{$proforma->proforma_id}}</span></p>
                            </div>
                        </div>
                        <div class="col s6 m4 l2">
                            <div class="form-group input-field has-feedback">
                                <label>Pro-forma Date</label>
                                <span>{{$proforma->proforma_date}}</span>
                            </div>
                        </div>
                        <div class="col s6 m4 l2">
                            <div class="form-group input-field has-feedback">
                                <label>Payment Within</label>
                                <span>{{$proforma->payment_within}}</span>
                            </div>
                        </div>
                        <div class="col s6 m4 l2">
                            <div class="form-group input-field has-feedback">
                                <label>Payment term</label>
                                <span>{{$proforma->paymentTerm->name}}</span>
                            </div>
                        </div>
                        <div class="col s6 m4 l2">
                            <div class="form-group input-field has-feedback">
                                <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                <label>Shipment Term</label>
                                <span>{{$proforma->shipmentTerm->name}}</span>
                            </div>
                        </div>
                        <div class="col s6 m4 l2">
                            <div class="form-group input-field has-feedback">
                                <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                <label>Shipping Address</label>
                                <span> {{$proforma->shipping_address}} </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line_item_wrap buyer_shipping_details">
                    <legend>Shipping Details</legend>
                    <div class="shipping_details input-field row">
                        <div class="form-group has-feedback col s12">
                            <label><b>Forwarder name </b></label>
                            <span> {{$proforma->forwarder_name}} </span>
                        </div>
                        <div class="form-group has-feedback col s12">
                            <label><b>Forwarder Address </b></label>
                            <span> {{$proforma->forwarder_address}} </span>
                        </div>
                        <div class="form-group  has-feedback col s12">
                            <label><b>Payable party </b></label>
                            <span> {{$proforma->payable_party}} </span>
                        </div>
                    </div>
                    <div class="shipping_details_table no_more_tables">
                        <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                            <thead class="cf">
                                <tr>
                                    <th>Shipping Method</th>
                                    <th>Shipment Type</th>
                                    <th>UOM</th>
                                    <th>Per UOM Price ($)</th>
                                    <th>QTY</th>
                                    <!-- <th style="width:15%;">Tax</th> -->
                                    <th>Total ($)</th>
                                </tr>
                            </thead>
                            <tbody id="shipping-details-table-body" class="input-field">
                                @foreach($proforma->proFormaShippingDetails as $item)
                                <tr>
                                    <td data-title="Shipping Method">
                                        <span>
                                            {{ $item->shippingMethod->name }}</option>
                                        </span>
                                    </td>
                                    <td data-title="Shipment Type">
                                        <span>{{ $item->shipmentType->name }}</span>
                                    </td>
                                    <td data-title="UOM">
                                        <span>{{ $item->uom->name }}</span>
                                    </td>
                                    <td data-title="Per UOM Price ($)">
                                        <span>{{ $item->shipping_details_per_uom_price }}</span>
                                    </td>
                                    <td data-title="QTY">
                                        <span>{{ $item->shipping_details_qty }}</span>
                                    </td>
                                    <td data-title="Total ($)">
                                        <span>{{ $item->shipping_details_total }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="line_item_wrap">
                    <legend>Line Items</legend>
                    <div class="col s12">
                        <div class="no_more_tables line_item_table_wrap">
                            <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                                <thead class="cf">
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Item / Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Sub Total</th>
                                        <!-- <th style="width:15%;">Tax</th> -->
                                        <th>Total Price</th>
                                        <!-- <th style="width:5%; text-align:center;"></th> -->
                                    </tr>
                                </thead>
                                <tbody id="lineitems" class="input-field">
                                @php $totalInvoiceAmount = 0; @endphp
                                @foreach($proforma->performa_items as $key=>$item)
                                    <tr>
                                        <td data-title="Sl. No.">{{$key+1}}</td>
                                        <td data-title="Item / Description">
                                            <span>{{$item->item_title}}</span>
                                        </td>
                                        <td data-title="Quantity">
                                            <span>{{$item->unit}}</span>
                                        </td>
                                        <td data-title="Unit Price">
                                            <span>{{$item->unit_price}}</span>
                                        </td>
                                        <td data-title="Sub Total">
                                            <span>{{$item->total_price}}</span>
                                        </td>
                                        <td data-title="Total Price">
                                            <span>{{$item->tax_total_price}}</span>
                                        </td>
                                    </tr>
                                    @php $totalInvoiceAmount = $item->tax_total_price + $totalInvoiceAmount ; @endphp
                                @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Total Invoice Amount: </b></td>
                                        <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount"><b>{{$totalInvoiceAmount}}<b></b></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="invoice_terms_conditions invoice_buyer_conditions">
                    <legend>Terms &amp; Conditions</legend>
                    <div class="terms_conditions_list">
                        <ul class="list-group terms-lists">
                            @foreach($proforma->supplierCheckedProFormaTermAndConditions as $key=>$item)
                            <li class="list-group-item">
                                <div class="input-group input-field">
                                    <label class="terms-label">
                                    <i class="material-icons"> check </i> <span>{{$item->proFormaTermAndCondition->term_and_condition}}</span>
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <ul class="list-group terms-lists">
                        </ul>
                    </div>
                </div>
                <div class="invoice_advising_bank">
                    <legend>Advising Bank</legend>
                    <div class="row input-field">
                        <div class="col s6 m4 l3">
                            <div class="form-group has-feedback">
                                <label>Name of the bank</label> <br>
                                <span> {{ $proforma->proFormaAdvisingBank->bank_name}} </span>
                            </div>
                        </div>
                        <div class="col s6 m4 l3">
                            <div class="form-group has-feedback">
                                <label>Branch name</label><br>
                                <span>{{ $proforma->proFormaAdvisingBank->branch_name}}</span>
                            </div>
                        </div>
                        <div class="col s6 m4 l3">
                            <div class="form-group has-feedback">
                                <label>Address of the bank </label><br>
                                <span> {{ $proforma->proFormaAdvisingBank->bank_address}} </span>
                            </div>
                        </div>
                        <div class="col s6 m4 l3">
                            <div class="form-group has-feedback">
                                <label>Swift code</label><br>
                                <span>{{ $proforma->proFormaAdvisingBank->swift_code}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line_item_wrap buyer_signature">
                    <legend>Signature</legend>
                    <div class="row">
                        <div class="col s6 input-field">
                            <h6>Buyer Side</h6>
                            <div class="form-group has-feedback">
                                <span> {{ $proforma->proFormaSignature->buyer_singature_name }} </span>
                            </div>
                        </div>
                        <div class="col s6 input-field">
                            <h6>Beneficiary Side</h6>
                            <div class="form-group has-feedback">
                                <span>{{ $proforma->proFormaSignature->beneficiar_singature_name}} </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end widget content -->
        </div>
        <!-- end widget -->
    </article>
    <!-- WIDGET END -->
</section> --}}
<!-- end widget grid -->

<div id="proforma-print-block" style="display: none;">

    <div class="pdf-header-wrapper" style="padding: 30px 0px 0;" >
        <table class="table proforma_address_table" style="border: 1px solid #ddd; margin-bottom: 25px">
            <tbody>
                <tr>
                    <td width="85px;">
                        <div class="logoImg" style="padding: 0; margin: 0;">
                            <img src="{{Storage::disk('s3')->url('public/frontendimages/merchantbay_logoX200.png')}}" alt="Merchant Bay Logo" class="pdf_logo" style="width: 50px; padding: 0; margin: 0;" />
                        </div>
                    </td>
                    <td>
                        <div class="addressBar" style="padding:0; margin: 0;">
                            <h3 style="padding: 0; margin: 0; font-size: 16px; linline-height: normal; color: #000; font-weight: 600;"><span style="padding: 0; margin: 0;">Merchant Bay</span></h3>
                            <p style="margin: 0; padding:0;">Meem Tower, Floor: 8, House: 18, Road: 12, Sector: 6, Uttara, Dhaka.</p>
                        </div>
                    </td>
                    <td>
                        <div class="conactInfo" style="padding: 10px 0 0" >
                            <p style="padding: 0; margin: 0 0 3px 0;">Tel: <b>01302-699567</b></p>
                            <p style="padding: 0; margin: 0;">Email: <b>success@merchantbay.com</b></p>
                            {{-- <p>Fax: <b>5000000, 5000000</b></p> --}}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="proformaInvoiceTiytle">
        <h3 style="text-align: center; font-weight: 600; text-transform: uppercase; margin: 0 0 20px; font-size: 16px; padding: 0;">Proforma Invoice</h3>
    </div>
    <table class="table table-bordered proforma_beneficiary_table" style="border: 1px solid #ddd; margin-bottom: 15px;">
        <thead>
            <tr>
                <th style="padding: 10px;">PI No: <span>{{ $proforma->proforma_id }}</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 10px;">
                    <div class="beneficiarybox">
                        <h6 style="font-size: 14px; line-height: normal;">Buyer Detail :</h6>
                        <div class="beneficiaryInfo">
                            <p style="margin: 0; padding:0;"><b> {{ $proforma->proFormaSignature->buyer_singature_name }}</b></p>
                            <p style="margin: 0; padding:0;"><span>Buyer Location</span></p>
                            <p style="margin: 0; padding:0;"> Date: <span>{{ $proforma->proforma_date }}</span></p>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="buyerdata_info_admin" style="padding: 0; margin: 0;">
        <div class="no_more_tables" style="margin-bottom: 15px; padding: 0">
            <table class="table table-bordered proforma_item_info_table" style="text-align: center; margin: 0 0 15px; border: 1px solid #ddd; overflow: inherit;">
                <thead class="cf">
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 10px;">Sl. No.</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Item / Description</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Quantity</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Unit Price</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Sub Total</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Total Price</th>
                    </tr>
                </thead>
                <tbody id="lineitems" class="">
                    @foreach($proforma->performa_items as  $key => $proFormaItem)
                        <tr>
                            <td data-title="Sl. No." style="border: 1px solid #ddd; padding: 10px;">{{$key+1 }}</td>
                            <td data-title="Item / Description" style="border: 1px solid #ddd; padding: 10px;">
                                <span>{{ $proFormaItem->item_title }}</span>
                            </td>
                            <td data-title="Quantity" style="border: 1px solid #ddd; padding: 10px;">
                                <span>{{ $proFormaItem->unit }}</span>
                            </td>
                            <td data-title="Unit Price" style="border: 1px solid #ddd; padding: 10px;">
                                <span>{{ $proFormaItem->unit_price }}</span>
                            </td>
                            <td data-title="Sub Total" style="border: 1px solid #ddd; padding: 10px;">
                                <span>{{ $proFormaItem->total_price }}</span>
                            </td>
                            <td data-title="Total Price" style="border: 1px solid #ddd; padding: 10px;">
                                <span>{{ $proFormaItem->tax_total_price }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="border: 1px solid #ddd; padding: 10px 20px 10px 10px;"><b>Sub Total: </b></td>
                    <td data-title="Sub Total:" colspan="2"><b>{{ number_format((float)$proforma->proforma_sub_total, 2, '.', '') }}</b></td>
                </tr>
                @if($proforma->proforma_commission)
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="border: 1px solid #ddd; padding: 10px 20px 10px 10px;">Commission:</td>
                    <td data-title="Commission:" colspan="2">{{ number_format((float)$proforma->proforma_commission, 2, '.', '') }} %</td>
                </tr>
                @endif
                @if($proforma->proforma_vat)
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="border: 1px solid #ddd; padding: 10px 20px 10px 10px;">Vat:</td>
                    <td data-title="Vat:" colspan="2">{{ number_format((float)$proforma->proforma_vat, 2, '.', '') }} %</td>
                </tr>
                @endif
                @if($proforma->proforma_tax)
                <tr>
                    <td colspan="5" class="right-align sub_total_title" style="border: 1px solid #ddd; padding: 10px 20px 10px 10px;">Tax:</td>
                    <td data-title="Tax:" colspan="2">{{ number_format((float)$proforma->proforma_tax, 2, '.', '') }} %</td>
                </tr>
                @endif
                <tr>
                    <td colspan="5" class="right-align grand_total_title" style="border: 1px solid #ddd; padding: 10px 20px 10px 10px;"><b>Grand Total: </b></td>
                    <td data-title="Grand Total:" colspan="2"><div><b id="proformaGrandTotal">{{ number_format((float)$proforma->proforma_grand_total, 2, '.', '') }}</b></div></td>
                </tr>
                @foreach($proforma->checkedMerchantAssistances as $assistance)
                <tr>
                    <td colspan="5" class="right-align grand_total_title" style="border: 1px solid #ddd; padding: 10px 20px 10px 10px;"><b>{{$assistance->merchantAssistance->name}}: </b></td>
                    <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{ $assistance->merchantAssistance->amount }}<b> {{ $assistance->merchantAssistance->type=='Percentage' ? '%' :'USD'}} <b></td>
                </tr>
                @endforeach
                @if($proforma->total_invoice_amount_with_merchant_assistant)
                <tr>
                    <td colspan="5" class="right-align grand_total_title" style="border: 1px solid #ddd; padding: 10px 20px 10px 10px;"><b>Your total order amount with merchant assistant : </b></td>
                    <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount" style="border: 1px solid #ddd; padding: 10px;">{{$proforma->total_invoice_amount_with_merchant_assistant}} <b> USD <b></td>
                </tr>
                @endif
                <tr>
                    <td colspan="6" style="text-align: left; border: 1px solid #ddd; padding: 10px;">In Word:
                        <b><span id="totalResultPdfFront"></span></b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @if($proforma->forwarder_name)
    <table class="table table-bordered proforma_forward_table" style="text-align: left; margin-bottom: 15px; border: 1px solid #ddd;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px;">Forwarder Name</th>
                <th style="border: 1px solid #ddd; padding: 10px;">Forwarder Address</th>
                <th style="border: 1px solid #ddd; padding: 10px;">Payable Party</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-title="forwarder Name" style="border: 1px solid #ddd; padding: 10px;">
                    <span> {{ $proforma->forwarder_name }} </span>
                </td>
                <td data-title="forwarder Address" style="border: 1px solid #ddd; padding: 10px;">
                    <span> {{ $proforma->forwarder_address }} </span>
                </td>
                <td data-title="Payable Party" style="border: 1px solid #ddd; padding: 10px;">
                    <span> {{ $proforma->payable_party}} </span>
                </td>
            </tr>
        </tbody>
    </table>
    @endif
    <table class="table table-bordered proforma_shipment_table" style="text-align: center; border: 1px solid #ddd; margin-bottom: 15px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 10px;">Shipment Term</th>
                <th style="border: 1px solid #ddd; padding: 10px;">Place of Shipment</th>
                <th style="border: 1px solid #ddd; padding: 10px;">Mode of Transport</th>
                <th style="border: 1px solid #ddd; padding: 10px;">Place of Destination</th>
                <th style="border: 1px solid #ddd; padding: 10px;">UOM</th>
                <th style="border: 1px solid #ddd; padding: 10px;">Per UOM Price ($)</th>
                <th style="border: 1px solid #ddd; padding: 10px;">QTY</th>
                <th style="border: 1px solid #ddd; padding: 10px;">Total ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proforma->proFormaShippingDetails as $shippingDetails)
                <tr>
                    <td data-title="Shipment Term" style="border: 1px solid #ddd; padding: 10px;">
                        <span>{{ $shippingDetails->shippingMethod->name }}</span>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 10px;">Place of Shipment</td>
                    <td data-title="Mode of Transport" style="border: 1px solid #ddd; padding: 10px;">
                        <span>{{ $shippingDetails->shipmentType->name }}</span>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 10px;">
                        <span>
                            @if($proforma->updated_buyer_shipping_address)
                            {{$proforma->updated_buyer_shipping_address}}
                            @else
                            {{$proforma->shipping_address}}
                            @endif
                        </span>
                    </td>
                    <td data-title="UOM" style="border: 1px solid #ddd; padding: 10px;">
                        <span>{{ $shippingDetails->uom->name }} </span>
                    </td>
                    <td data-title="Per UOM Price ($)" style="border: 1px solid #ddd; padding: 10px;">
                        <span>{{ $shippingDetails->shipping_details_per_uom_price }}</span>
                    </td>
                    <td data-title="QTY" style="border: 1px solid #ddd; padding: 10px;">
                        <span>{{ $shippingDetails->shipping_details_qty }}</span>
                    </td>
                    <td data-title="Total ($)" style="border: 1px solid #ddd; padding: 10px;">
                        <span>{{ $shippingDetails->shipping_details_total }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table proforma_advising_bank_table" style="border: 1px solid #ddd; margin-bottom: 15px;">
        <thead style="border: none">
            <tr style="border: none">
                <th style="border: 1px solid #ddd; padding: 10px;">
                    <h3 style="font-size: 14px; color: #000; margin: 0; font-weight: 600;">Payment Info: </h3>
                </th>
            </tr>
        </thead>
        <tbody style="border: none">
            <tr style="border: none">
                <td style="border: none;">
                    <div class="conactInfo" style="padding: 0">
                        <p style="padding: 0; margin: 0 0 3px 0;">Payment Within: <b><span> {{$proforma->payment_within ?? ""}} </span></b></p>
                        <p style="padding: 0; margin: 0;">Payment Term: <b><span> {{$proforma->paymentTerm->name ?? ""}} </span></b></p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table proforma_terms_onditions_table" style="border: 1px solid #ddd; margin-bottom: 15px">
        <thead style="border: none">
            <tr style="border: none">
                <th style="border: 1px solid #ddd; padding: 10px;"><span style="font-size: 14px; color: #000; margin: 0; font-weight: 600;">Terms & Conditions</span></th>
            </tr>
        </thead>
        <tbody style="border: none">
            <tr style="border: none">
                <td style="border: none; padding: 5px; 0 0">
                    <div class="terms_conditions_list buyerdata_info_admin" style="padding: 0; margin: 0">
                        <ul class="list-group terms-lists" style="padding: 5px 5px 0; margin: 0;">
                            @foreach($proforma->supplierCheckedProFormaTermAndConditions as $supplierCheckedProFormaTermAndCondition)
                            <li class="list-group-item" style="padding: 5px 0; margin: 0; border: none;">
                                <div class="input-group" style="margin: 0; padding:0">
                                    <label class="terms-label" style="font-weight: 400;">
                                        <i class="fa fa-light fa-check" style="margin-right: 5px;"></i> <span>{{$supplierCheckedProFormaTermAndCondition->proFormaTermAndCondition->term_and_condition}}</span>
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <ul class="list-group terms-lists" style="padding: 12px 5px 0; margin: 0;">
                            @foreach(json_decode($proforma->condition) as $key=>$condition)
                            <li class="list-group-item" style="padding: 0; margin: 0; border: none;">
                                <div class="input-group" style="margin: 0; padding:0">
                                    <label class="terms-label" style="font-weight: 400;">
                                        <i class="fa fa-light fa-check" style="margin-right: 5px;"></i> <span>{{$condition}}</span>
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table proforma_advising_bank_table" style="border: 1px solid #ddd; margin-bottom: 15px;">
        <thead style="border: none">
            <tr style="border: none">
                <th style="border: 1px solid #ddd; padding: 10px;">
                    <span style="font-size: 14px; color: #000; margin: 0; font-weight: 600;">Advising Bank: </span>
                </th>
            </tr>
        </thead>
        <tbody style="border: none">
            <tr style="border: none">
                <td style="border: none">
                    <div class="conactInfo" style="padding: 5px;">
                        <p style="padding: 0; margin: 0 0 3px 0;"><b><span> {{$proforma->proFormaAdvisingBank->bank_name ?? ""}} </span></b></p>
                        <p style="padding: 0; margin: 0 0 3px 0;"><span>{{ $proforma->proFormaAdvisingBank->branch_name ?? "" }}</span></p>
                        <p style="padding: 0; margin: 0 0 3px 0;"><span> {{ $proforma->proFormaAdvisingBank->bank_address ?? "" }} </span></p>
                        <p style="padding: 0; margin: 0;">Swift code: <b> <span>{{ $proforma->proFormaAdvisingBank->swift_code ?? "" }}</span></b> </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="signature" style="padding: 60px 10px 0px; margin: 0;"><b>Authorized Signature</b></div>
</div>
    
    
    {{-- <div class="invoice_page_header">
        <legend>
            <i class="fa fa-table fa-fw " aria-hidden="true"></i> Pro-Forma Invoice
        </legend>
    </div>
    <!-- widget grid -->
    <section id="widget-grid" class="pro_porma_invoice">
        <!-- NEW WIDGET START -->
        <article class="">
            <div class="jarviswidget jarviswidget-color-darken no-padding" id="wid-id-0" data-widget-editbutton="false">
                <!-- widget content -->
                <div class="widget-body p-0">
                    <div class="row buyerdata_info_top">
                        <div class="col s6 input-field" id="buyerdata">
                            <span><b> {{$proforma->buyer->name}} </b></span><br>
                            <span> {{$proforma->buyer->email}} </span>
                        </div>
                    </div>
                    <div class="input-field has_feedback_wrap">
                        <div class="row">
                            <div class="col s6 m4 l2">
                                <div class="form-group input-field has-feedback">
                                    <label>Pro-forma ID</label>
                                    <p><span>{{$proforma->proforma_id}}</span></p>
                                </div>
                            </div>
                            <div class="col s6 m4 l2">
                                <div class="form-group input-field has-feedback">
                                    <label>Pro-forma Date</label>
                                    <span>{{$proforma->proforma_date}}</span>
                                </div>
                            </div>
                            <div class="col s6 m4 l2">
                                <div class="form-group input-field has-feedback">
                                    <label>Payment Within</label>
                                    <span>{{$proforma->payment_within}}</span>
                                </div>
                            </div>
                            <div class="col s6 m4 l2">
                                <div class="form-group input-field has-feedback">
                                    <label>Payment term</label>
                                    <span>{{$proforma->paymentTerm->name}}</span>
                                </div>
                            </div>
                            <div class="col s6 m4 l2">
                                <div class="form-group input-field has-feedback">
                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                    <label>Shipment Term</label>
                                    <span>{{$proforma->shipmentTerm->name}}</span>
                                </div>
                            </div>
                            <div class="col s6 m4 l2">
                                <div class="form-group input-field has-feedback">
                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                    <label>Shipping Address</label>
                                    <span> {{$proforma->shipping_address}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line_item_wrap buyer_shipping_details">
                        <legend>Shipping Details</legend>
                        <div class="shipping_details input-field row">
                            <div class="form-group has-feedback col s12">
                                <label><b>Forwarder name </b></label>
                                <span> {{$proforma->forwarder_name}} </span>
                            </div>
                            <div class="form-group has-feedback col s12">
                                <label><b>Forwarder Address </b></label>
                                <span> {{$proforma->forwarder_address}} </span>
                            </div>
                            <div class="form-group  has-feedback col s12">
                                <label><b>Payable party </b></label>
                                <span> {{$proforma->payable_party}} </span>
                            </div>
                        </div>
                        <div class="shipping_details_table no_more_tables">
                            <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                                <thead class="cf">
                                    <tr>
                                        <th>Shipping Method</th>
                                        <th>Shipment Type</th>
                                        <th>UOM</th>
                                        <th>Per UOM Price ($)</th>
                                        <th>QTY</th>
                                        <!-- <th style="width:15%;">Tax</th> -->
                                        <th>Total ($)</th>
                                    </tr>
                                </thead>
                                <tbody id="shipping-details-table-body" class="input-field">
                                    @foreach($proforma->proFormaShippingDetails as $item)
                                    <tr>
                                        <td data-title="Shipping Method">
                                            <span>
                                                {{ $item->shippingMethod->name }}</option>
                                            </span>
                                        </td>
                                        <td data-title="Shipment Type">
                                            <span>{{ $item->shipmentType->name }}</span>
                                        </td>
                                        <td data-title="UOM">
                                            <span>{{ $item->uom->name }}</span>
                                        </td>
                                        <td data-title="Per UOM Price ($)">
                                            <span>{{ $item->shipping_details_per_uom_price }}</span>
                                        </td>
                                        <td data-title="QTY">
                                            <span>{{ $item->shipping_details_qty }}</span>
                                        </td>
                                        <td data-title="Total ($)">
                                            <span>{{ $item->shipping_details_total }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="line_item_wrap">
                        <legend>Line Items</legend>
                        <div class="col s12">
                            <div class="no_more_tables line_item_table_wrap">
                                <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                                    <thead class="cf">
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Item / Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Sub Total</th>
                                            <!-- <th style="width:15%;">Tax</th> -->
                                            <th>Total Price</th>
                                            <!-- <th style="width:5%; text-align:center;"></th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="lineitems" class="input-field">
                                    @php $totalInvoiceAmount = 0; @endphp
                                    @foreach($proforma->performa_items as $key=>$item)
                                        <tr>
                                            <td data-title="Sl. No.">{{$key+1}}</td>
                                            <td data-title="Item / Description">
                                                <span>{{$item->item_title}}</span>
                                            </td>
                                            <td data-title="Quantity">
                                                <span>{{$item->unit}}</span>
                                            </td>
                                            <td data-title="Unit Price">
                                                <span>{{$item->unit_price}}</span>
                                            </td>
                                            <td data-title="Sub Total">
                                                <span>{{$item->total_price}}</span>
                                            </td>
                                            <td data-title="Total Price">
                                                <span>{{$item->tax_total_price}}</span>
                                            </td>
                                        </tr>
                                        @php $totalInvoiceAmount = $item->tax_total_price + $totalInvoiceAmount ; @endphp
                                    @endforeach
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Total Invoice Amount: </b></td>
                                            <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount"><b>{{$totalInvoiceAmount}}<b></b></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="invoice_terms_conditions invoice_buyer_conditions">
                        <legend>Terms &amp; Conditions</legend>
                        <div class="terms_conditions_list">
                            <ul class="list-group terms-lists">
                                @foreach($proforma->supplierCheckedProFormaTermAndConditions as $key=>$item)
                                <li class="list-group-item">
                                    <div class="input-group input-field">
                                        <label class="terms-label">
                                        <i class="material-icons"> check </i> <span>{{$item->proFormaTermAndCondition->term_and_condition}}</span>
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="list-group terms-lists">
                            </ul>
                        </div>
                    </div>
                    <div class="invoice_advising_bank">
                        <legend>Advising Bank</legend>
                        <div class="row input-field">
                            <div class="col s6 m4 l3">
                                <div class="form-group has-feedback">
                                    <label>Name of the bank</label> <br>
                                    <span> {{ $proforma->proFormaAdvisingBank->bank_name}} </span>
                                </div>
                            </div>
                            <div class="col s6 m4 l3">
                                <div class="form-group has-feedback">
                                    <label>Branch name</label><br>
                                    <span>{{ $proforma->proFormaAdvisingBank->branch_name}}</span>
                                </div>
                            </div>
                            <div class="col s6 m4 l3">
                                <div class="form-group has-feedback">
                                    <label>Address of the bank </label><br>
                                    <span> {{ $proforma->proFormaAdvisingBank->bank_address}} </span>
                                </div>
                            </div>
                            <div class="col s6 m4 l3">
                                <div class="form-group has-feedback">
                                    <label>Swift code</label><br>
                                    <span>{{ $proforma->proFormaAdvisingBank->swift_code}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line_item_wrap buyer_signature">
                        <legend>Signature</legend>
                        <div class="row">
                            <div class="col s6 input-field">
                                <h6>Buyer Side</h6>
                                <div class="form-group has-feedback">
                                    <span> {{ $proforma->proFormaSignature->buyer_singature_name }} </span>
                                </div>
                            </div>
                            <div class="col s6 input-field">
                                <h6>Beneficiary Side</h6>
                                <div class="form-group has-feedback">
                                    <span>{{ $proforma->proFormaSignature->beneficiar_singature_name}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget content -->
            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->
    </section> --}}



<script>
        function intToEnglish(number)
        {
            var NS = [
                { value: 10000000, str: "Crore" },
                { value: 100000, str: "Lakh" },
                { value: 1000, str: "Thousand" },
                { value: 100, str: "Hundred" },
                { value: 90, str: "Ninety" },
                { value: 80, str: "Eighty" },
                { value: 70, str: "Seventy" },
                { value: 60, str: "Sixty" },
                { value: 50, str: "Fifty" },
                { value: 40, str: "Forty" },
                { value: 30, str: "Thirty" },
                { value: 20, str: "Twenty" },
                { value: 19, str: "Nineteen" },
                { value: 18, str: "Eighteen" },
                { value: 17, str: "Seventeen" },
                { value: 16, str: "Sixteen" },
                { value: 15, str: "Fifteen" },
                { value: 14, str: "Fourteen" },
                { value: 13, str: "Thirteen" },
                { value: 12, str: "Twelve" },
                { value: 11, str: "Eleven" },
                { value: 10, str: "Ten" },
                { value: 9, str: "Nine" },
                { value: 8, str: "Eight" },
                { value: 7, str: "Seven" },
                { value: 6, str: "Six" },
                { value: 5, str: "Five" },
                { value: 4, str: "Four" },
                { value: 3, str: "Three" },
                { value: 2, str: "Two" },
                { value: 1, str: "One" }
            ];
            var result = '';
            for (var n of NS) {
                if (number >= n.value) {
                if (number <= 99) {
                    result += n.str;
                    number -= n.value;
                    if (number > 0) result += ' ';
                } else {
                    var t = Math.floor(number / n.value);
                    // console.log(t);
                    var d = number % n.value;
                    if (d > 0) {
                        return intToEnglish(t) + ' ' + n.str + ' ' + intToEnglish(d);
                    } else {
                        return intToEnglish(t) + ' ' + n.str;
                    }

                }
                }
            }
            return result;
        }

        function getNumber(abc)
        {
            numbers = []
            console.log(abc)
            numbers = String(abc).split(".")
            const res = intToEnglish(numbers[0])+ " Taka" + " And " + intToEnglish(numbers[1]) + " Poisa"
            return res
        }
        console.log();
        document.getElementById("totalResultFront").innerHTML = getNumber(document.getElementById("proformaGrandTotal").innerHTML);
        document.getElementById("totalResultPdfFront").innerHTML = getNumber(document.getElementById("proformaGrandTotal").innerHTML);
</script>
