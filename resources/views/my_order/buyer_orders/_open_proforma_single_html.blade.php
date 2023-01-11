@extends('layouts.app')

@section('content')
<div class="main_content_wrapper invoice_container_wrap purchase_order_wrap" id="purchase_order_wrap">

    <div class="card">
        <div class="invoice_top_button_wrap">
            @if(auth()->id() == $po->buyer_id && $po->status == 0)
            <!-- <button class="btn_green" type="submit" onclick="work_trigger()" id="createRfqForm" >Accept</button> -->
            <a class="waves-effect waves-light btn_green modal-trigger"  href="#acceptOrderDetailsModal">Accept</a>
            <a class="waves-effect waves-light btn_green modal-trigger"  href="#rejectOrderDetailsModal">Reject</a>
            @endif
            <button onclick="printDiv('purchase_order_wrap');" id="printPageButtonTrigger" class="btn_green printPageButton">Print</button>
        </div>

        <div class="proforma_invoice_pdf_design_table_wrap">
            <div class="proformaInvoiceTiytle">
                <h3>Proforma Invoice</h3>
            </div>

            <table class="table table-bordered proforma_beneficiary_table">
                <thead>
                    <tr>
                        <th style="padding-top: 10px">PI No: <span>{{ $po->proforma_id }}</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="beneficiarybox">
                                <h6>Buyer Detail :</h6>
                                <div class="form-group has-feedback">
                                    <p><b> {{ $po->proFormaSignature->buyer_singature_name }}</b> </p>
                                    <p>Buyer Location</p>
                                    <p> Date: <span>{{ $po->proforma_date }}</span></p>
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
                                <th style="padding-top: 10px">Sl. No.</th>
                                <th style="padding-top: 10px">Item / Description</th>
                                <th style="padding-top: 10px">Quantity</th>
                                <th style="padding-top: 10px">Unit Price</th>
                                <th style="padding-top: 10px">Sub Total</th>
                                <!-- <th style="width:15%;">Tax</th> -->
                                <th style="padding-top: 10px">Total Price</th>
                                <!-- <th style="width:5%; text-align:center;"></th> -->
                            </tr>
                        </thead>
                        <tbody id="lineitems" class="">
                            @foreach($po->performa_items as  $key => $proFormaItem)
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
                            <td data-title="Sub Total:" colspan="2"><b>{{ number_format((float)$po->proforma_sub_total, 2, '.', '') }}</b></td>
                        </tr>
                        @if($po->proforma_commission)
                        <tr>
                            <td colspan="5" class="right-align sub_total_title" style="padding-right: 20px">Commission:</td>
                            <td data-title="Commission:" colspan="2">{{ number_format((float)$po->proforma_commission, 2, '.', '') }} %</td>
                        </tr>
                        @endif
                        @if($po->proforma_vat)
                        <tr>
                            <td colspan="5" class="right-align sub_total_title" style="padding-right: 20px">Vat:</td>
                            <td data-title="Vat:" colspan="2">{{ number_format((float)$po->proforma_vat, 2, '.', '') }} %</td>
                        </tr>
                        @endif
                        @if($po->proforma_tax)
                        <tr>
                            <td colspan="5" class="right-align sub_total_title" style="padding-right: 20px">Tax:</td>
                            <td data-title="Tax:" colspan="2">{{ number_format((float)$po->proforma_tax, 2, '.', '') }} %</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Grand Total: </b></td>
                            <td data-title="Grand Total:" colspan="2"><div><b id="proformaGrandTotal">{{ number_format((float)$po->proforma_grand_total, 2, '.', '') }}</b></div></td>
                        </tr>
                        @foreach($po->checkedMerchantAssistances as $assistance)
                        <tr>
                            <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>{{$assistance->merchantAssistance->name}}: </b></td>
                            <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{ $assistance->merchantAssistance->amount }}<b> {{ $assistance->merchantAssistance->type=='Percentage' ? '%' :'USD'}} <b></td>
                        </tr>
                        @endforeach
                        @if($po->total_invoice_amount_with_merchant_assistant)
                        <tr>
                            <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Your total order amount with merchant assistant : </b></td>
                            <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{$po->total_invoice_amount_with_merchant_assistant}} <b> USD <b></td>
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
            @if($po->forwarder_name)
                <table class="table table-bordered proforma_forward_table" style="text-align: left;">
                    <thead>
                        <tr>
                            <th style="padding-top: 10px">Forwarder Name</th>
                            <th style="padding-top: 10px">Forwarder Address</th>
                            <th style="padding-top: 10px">Payable Party</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-title="forwarder Name">
                                <span> {{$po->forwarder_name}} </span>
                            </td>
                            <td data-title="forwarder Address">
                                <span> {{$po->forwarder_address}} </span>
                            </td>
                            <td data-title="Payable Party">
                                <span> {{$po->payable_party}} </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <div class="no_more_tables">
                <table class="table table-bordered proforma_shipment_table" style="text-align: center;">
                    <thead>
                        <tr>
                            <th style="padding-top: 10px">Shipment Term</th>
                            <th style="padding-top: 10px">Place of Shipment</th>
                            <th style="padding-top: 10px">Mode of Transport</th>
                            <th style="padding-top: 10px">Place of Destination</th>
                            <th style="padding-top: 10px">UOM</th>
                            <th style="padding-top: 10px">Per UOM Price ($)</th>
                            <th style="padding-top: 10px">QTY</th>
                            <th style="padding-top: 10px">Total ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($po->proFormaShippingDetails as $shippingDetails)
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
                                        @if($po->updated_buyer_shipping_address)
                                        {{$po->updated_buyer_shipping_address}}
                                        @else
                                        {{$po->shipping_address}}
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
            

            <div class="no_more_tables">
                <table class="table proforma_advising_bank_table">
                    <thead>
                        <tr>
                            <th style="padding-top: 10px">
                                <h3>Payment Info: </h3>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="conactInfo">
                                    <p>Payment Within: <b><span> {{$po->payment_within ?? ""}} </span></b></p>
                                    <p>Payment Term: <b><span> {{$po->paymentTerm->name ?? ""}} </span></b></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            
            <table class="table proforma_terms_onditions_table">
                <thead>
                    <tr>
                        <th style="padding-top: 10px">
                            <h3>Terms & Conditions</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="terms_conditions_list buyerdata_info_admin">
                                <ul class="list-group terms-lists">
                                    @foreach($po->supplierCheckedProFormaTermAndConditions as $supplierCheckedProFormaTermAndCondition)
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
                                    @foreach(json_decode($po->condition) as $key=>$condition)
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
                        <th style="padding-top: 10px">
                            <h3>Advising Bank: </h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="conactInfo">
                                <p><b><span> {{$po->proFormaAdvisingBank->bank_name ?? ""}} </span></b></p>
                                <p><span>{{ $po->proFormaAdvisingBank->branch_name ?? "" }}</span></p>
                                <p><span> {{ $po->proFormaAdvisingBank->bank_address ?? "" }} </span></p>
                                <p>Swift code: <b> <span>{{ $po->proFormaAdvisingBank->swift_code ?? "" }}</span></b> </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="signature"><b>Authorized Signature</b></div>
        </div>



        {{-- <div class="invoice_page_header">
            <legend>
                @if($po->po_no)
                <i class="fa fa-table fa-fw "></i> Purchase Order
                @else
                <i class="fa fa-table fa-fw "></i> Pro-Forma Invoice
                @endif
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
                                <span><b>{{$po->buyer->name}} </b></span><br/>
                                <span>{{$po->buyer->email}}</span>
                            </div>
                            <div class="col s6 input-field">
                                <div class="form-group has-feedback">
                                    <label style="margin-bottom: 0; left: 0;"><b>Beneficiary</b></label>
                                    <span style="display: block">Merchantbay</span>
                                </div>
                            </div>
                        </div>

                        <div class="input-field has_feedback_wrap">
                            <div class="row">
                                <div class="col s6 m4 l3">
                                    <div class="form-group input-field has-feedback">
                                        <label>Pro-forma ID</label>
                                        <p><span>{{ $po->proforma_id }}</span></p>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group input-field has-feedback">
                                        <label>Pro-forma Date</label>
                                        <span>{{ $po->proforma_date }}</span>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group input-field has-feedback">
                                        <label>Payment Within</label>
                                        <span>{{ $po->payment_within  }}</span>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group input-field has-feedback">
                                        <label>Payment term</label>
                                        <span>{{ $po->paymentTerm->name  }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6 m4 l3">
                                    <div class="form-group input-field has-feedback">
                                        <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                        <label>Shipment Term</label>
                                        <span>{{$po->shipmentTerm->name}}</span>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group input-field has-feedback">
                                        <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                        <label>Shipping Address</label>
                                        <span> {{$po->shipping_address}} </span>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group input-field has-feedback">
                                        <label>Shipping Date</label>
                                        <span>{{ $po->shipping_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line_item_wrap buyer_shipping_details">
                            <legend>Shipping Details</legend>
                            <div class="shipping_details input-field row">
                                <div class="form-group has-feedback col s12">
                                    <label><b>Forwarder name </b></label>
                                    <span> {{ $po->forwarder_name }} </span>
                                </div>
                                <div class="form-group has-feedback col s12">
                                    <label><b>Forwarder Address </b></label>
                                    <span> {{ $po->forwarder_address }} </span>
                                </div>
                                <div class="form-group  has-feedback col s12">
                                    <label><b>Payable party </b></label>
                                    <span> {{ $po->payable_party}} </span>
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
                                            <th >QTY</th>
                                            <!-- <th style="width:15%;">Tax</th> -->
                                            <th>Total ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="shipping-details-table-body" class="input-field">
                                    @foreach($po->proFormaShippingDetails as $shippingDetails)
                                        <tr>
                                            <td data-title="Shipping Method">
                                                <span>{{ $shippingDetails->shippingMethod->name }}</span>
                                            </td>
                                            <td  data-title="Shipment Type">
                                                <span>{{ $shippingDetails->shipmentType->name }}</span>
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
                        </div>

                        <div class="line_item_wrap ">
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
                                        @foreach($po->performa_items as  $key => $proFormaItem)
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
                                            <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Total Invoice Amount: </b></td>
                                            <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount"><b>{{$totalInvoice}}<b></td>
                                        </tr>
                                        @foreach($po->checkedMerchantAssistances as $assistance)
                                        <tr style="display: none;">
                                            <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>{{$assistance->merchantAssistance->name}}: </b></td>
                                            <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{ $assistance->merchantAssistance->amount }}<b> {{ $assistance->merchantAssistance->type=='Percentage' ? '%' :'USD'}} <b></td>
                                        </tr>
                                        @endforeach
                                        @if($po->total_invoice_amount_with_merchant_assistant)
                                        <tr style="display: none;">
                                            <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Your total order amount with merchant assistant : </b></td>
                                            <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{$po->total_invoice_amount_with_merchant_assistant}} <b> USD <b></td>
                                        </tr>
                                        @endif

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="invoice_terms_conditions invoice_buyer_conditions">
                            <legend>Terms & Conditions</legend>
                            <div class="terms_conditions_list" >
                                <ul class="list-group terms-lists">
                                    @foreach($po->supplierCheckedProFormaTermAndConditions as $supplierCheckedProFormaTermAndCondition)
                                    <li class="list-group-item">
                                        <div class="input-group input-field">
                                            <label class="terms-label">
                                                <i class="material-icons"> check </i> <span>{{$supplierCheckedProFormaTermAndCondition->proFormaTermAndCondition->term_and_condition}}</span>
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <ul class="list-group terms-lists">
                                    @foreach(json_decode($po->condition) as $key=>$condition)
                                    <li class="list-group-item">
                                        <div class="input-group input-field">
                                            <label class="terms-label">
                                                <i class="material-icons"> check </i> <span>{{$condition}}</span>
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="invoice_advising_bank">
                            <legend>Advising Bank</legend>
                            <div class="row input-field">
                                <div class="col s6 m4 l3">
                                    <div class="form-group has-feedback">
                                        <label>Name of the bank</label> <br>
                                        <span> {{$po->proFormaAdvisingBank->bank_name??''}} </span>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group has-feedback">
                                        <label>Branch name</label><br>
                                        <span>{{ $po->proFormaAdvisingBank->branch_name??'' }}</span>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group has-feedback">
                                        <label>Address of the bank </label><br>
                                        <span> {{ $po->proFormaAdvisingBank->bank_address??'' }} </span>
                                    </div>
                                </div>
                                <div class="col s6 m4 l3">
                                    <div class="form-group has-feedback">
                                        <label>Swift code</label><br>
                                        <span>{{ $po->proFormaAdvisingBank->swift_code??'' }}</span>
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
                                        <span> {{ $po->proFormaSignature->buyer_singature_name ??''}} </span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <span>{{$po->proFormaSignature->buyer_singature_designation??''}}</span>
                                    </div>
                                </div>
                                <div class="col s6 input-field">
                                    <h6>Beneficiary Side</h6>
                                    <div class="form-group has-feedback">
                                        <span> {{$po->proFormaSignature->beneficiar_singature_name??''}} </span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <span> {{ $po->proFormaSignature->beneficiar_singature_designation??'' }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget -->
                @if(count($po->proFormaShippingFiles)>0)
                <div class="shipping-files shipping_attachment_wrap">
                    <legend><i class="material-icons">attach_file</i> Attachment</legend>
                    <ul>
                        @foreach($po->proFormaShippingFiles as $image)
                            <li><i class="material-icons"> insert_drive_file </i> {{ asset('storage/'.$image->shipping_details_files) }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </article>
            <!-- WIDGET END -->

        </section> --}}
        <!-- end widget grid -->

    </div>
</div>

<div class="modal reject_order_details_modal" id="rejectOrderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="rejectOrderDetailsModal"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
            <div class="modal-header modal-hdr-custum" style="background: rgb(85, 168, 96) none repeat scroll 0% 0%;">
            	<h4 class="modal-title" style="color: #fff; font-size: 14px;">
            		PO: {{ $po->proforma_id }} <br />
            		Date: {{$po->proforma_date}}
            	</h4>
            </div>
            <div class="modal-body modal-bdy-bdr">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 35px;">
                    	<form action="{{route('new.profile.profoma_orders.reject',['alias'=>$alias,'proformaId'=>$po->id])}}" class="rejectRfqForm" method="post" enctype="multipart/form-data">
                    		@csrf
                    		<div class="input-field">
	                        	<textarea name="reject_message" id="reject_message" placeholder="Please enter here the details of rejection." style="width: 100%; height: 200px; border: 1px solid #ccc; padding: 10px;"></textarea>
	                    	</div>
						    <input type="hidden" id="proforma_id" name="proforma_id" value="{{ $po->proforma_id }}">
						    <input type="hidden" id="po_id" name="po_id" value="{{ $po->id }}" />
						    <input type="hidden" id="supplier_id" name="supplier_id" value="{{ $supplierInfo->id }}" />
						    <input type="hidden" id="po_rejected_status" name="po_rejected_status" value="Rejected" />
	                        <div class="right-align">
                                <button type="submit" onclick="show_loader()" class="btn_green btn-success" id="rejectRfqForm">Submit</button>
                            </div>

                    	</form>
                    </div>
                </div>
            </div>
       </div>
       <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
      </div>
    </div>
</div>

<form action="" class="createRfqForm" method="post" enctype="multipart/form-data">
	@csrf
    <input type="hidden" id="proforma_id" name="proforma_id" value="{{ $po->proforma_id }}">
    <input type="hidden" id="po_id" name="po_id" value="{{ $po->id }}" />
    <input type="hidden" id="supplier_id" name="supplier_id" value="{{ $supplierInfo->id }}" />
    <input type="hidden" id="po_accepted_status" name="po_accepted_status" value="Accepted" />
</form>

<div class="modal accept_order_details_modal" id="acceptOrderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="acceptOrderDetailsModal"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
            <!-- <div class="modal-header modal-hdr-custum" style="background: rgb(85, 168, 96) none repeat scroll 0% 0%;">
            	<h4 class="modal-title" style="color: #fff; font-size: 14px;">
            		PO: {{ $po->proforma_id }} <br />
            		Date: {{$po->proforma_date}}
            	</h4>
            </div> -->
            <div class="modal-body modal-bdy-bdr">
                <div class="row">
                    <div class="assistance_option_wrap">
                        <h3>Want to explore Merchant Assistance options?</h3>
                        <div class="option_info">
                            <p>When you take Merchant Assistance, Merchant Bay takes all the responsibilities of your order. Merchant Bay ensures you get high quality products on time.</p>
                        </div>
                        <h4>Please select Assistance options:        </h4>
                    	<form action="{{route('new.profile.profoma_orders.accept',['alias'=>$alias,'proformaId'=>$po->id])}}" class="rejectRfqForm" method="get" enctype="multipart/form-data">
                    		@csrf
						    <input type="hidden" id="proforma_id" name="proforma_id" value="{{ $po->proforma_id }}">
                            <input type="hidden" id="total_invoice_amount" name="total_invoice_amount" value="{{$totalInvoice}}">
                            <input type="hidden" id="total_invoice_amount_with_merchant_assistant" name="total_invoice_amount_with_merchant_assistant" value="">
						    <input type="hidden" id="po_id" name="po_id" value="{{ $po->id }}" />

                                <ul>
                                    @foreach($merchantAssistances as $key=>$merchantAssistance)
                                    <li>
                                        <label>
                                            <input type="checkbox"  class="merchant-assiatance-checkbox" data-merchant_assistance_name ="{{$merchantAssistance->name}}" data-merchant_assistance_id ="{{$merchantAssistance->id}}"  data-merchant_assistance_type ="{{$merchantAssistance->type}}" data-merchant_assistance_amount = "{{$merchantAssistance->amount}}" name="merchant_assistances[{{$key}}]" value="{{$merchantAssistance->id}}"/>
                                            <span> {{$merchantAssistance->name}} </span>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>

                            <div class="order_amount" style="display: none;">Your total order amount : <b>{{$totalInvoice}}</b></div>

                            <div class="merchant-assitance-calculation" style="display: none;">

                            </div>
                            <div class="total-amount-with-merchant-assitance" style="display: none;">

                            </div>
	                        <div class="accept_submit_wrap">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <a href="javascript:void(0);" class="modal-close waves-effect waves-green btn-flat btn_grBorder">No</a>
                                    </div>
                                    <div class="col s12 m6">
                                        <button type="submit" onclick="show_loader()" class="btn_green btn-success" id="rejectRfqForm">Yes</button>
                                    </div>
                                </div>
                            </div>
                    	</form>
                    </div>
                </div>
            </div>
       </div>
       <!-- <div class="modal-footer">

      </div> -->
    </div>
</div>





@endsection

@include('my_order.buyer_orders._scripts')
@push('js')
    <script>
            var serverURL = "{{ env('CHAT_URL'), 'localhost' }}:3000";
            var socket = io.connect(serverURL);
            socket.on('connect', function(data) {
                //alert('connect');
            });

        $(document).ready(function()
        {
            $("#createRfqForm").on('click', function(e)
            {
                e.preventDefault();
                let proforma_id = $("#proforma_id").val();
                let po_id = $("#po_id").val();
                let supplier_id = $("#supplier_id").val();
                let csrftoken = $("[name=_token]").val();
                let poAcceptedStatus = $("[name=po_accepted_status]").val();

                data_json = {
                    "proforma_id": proforma_id,
                    "po_id": po_id,
                    "supplier_id": supplier_id,
                    "csrftoken": csrftoken
                }

                var url='{{route("accept.proforma.invoice")}}';
                $.ajax({
                    method: "POST",
                    url: url,
                    headers:{
                        "X-CSRF-TOKEN": csrftoken
                    },
                    data: data_json,
                    dataType:"json",

                    success: function(data){
                        //console.log(data);
                        //work_trigger();
                        var inquires_index= '{{route("po.index")}}';
                        window.location.href = inquires_index;
                        //sendAcceptedMessageToSupplier(poAcceptedStatus);
                    }

                });
            });

            $("#rejectOrderTrigger").on('click', function(e)
            {
                e.preventDefault();
                let proforma_id = $("#proforma_id").val();
                let po_id = $("#po_id").val();
                let supplier_id = $("#supplier_id").val();
                let reject_message = $("#reject_message").val();
                let csrftoken = $("[name=_token]").val();
                let poRejectedStatus = $("[name=po_rejected_status]").val();

                data_json = {
                    "proforma_id": proforma_id,
                    "po_id": po_id,
                    "supplier_id": supplier_id,
                    "reject_message": reject_message,
                    "csrftoken": csrftoken
                }
                var url ='{{route("reject.proforma.invoice")}}';
                $.ajax({
                    method: "POST",
                    url:url,
                    headers:{
                        "X-CSRF-TOKEN": csrftoken
                    },
                    data: data_json,
                    dataType:"json",

                    success: function(data){
                        //console.log(data);
                        work_trigger();
                        //sendRejectedMessageToSupplier(poRejectedStatus, reject_message);
                    }

                });
            });



            $(".merchant-assiatance-checkbox").on('click', function(e)
            {
                var type = $(this).attr("data-merchant_assistance_type");
                var amount = $(this).attr("data-merchant_assistance_amount");
                var merchantAssistanceId = $(this).attr("data-merchant_assistance_id");
                var merchantAssistanceName = $(this).attr('data-merchant_assistance_name');
                var noOfCheckedAssistance = $('.merchant-assitance-calculation').children().length;
                if(noOfCheckedAssistance == 0){
                    var totalInvoiceAmount = $('#total_invoice_amount').val();
                }
                else if(noOfCheckedAssistance > 0){
                    var totalInvoiceAmount = $('#total_invoice_amount_with_merchant_assistant').val();
                }


                if($(this).is(':checked')){
                    if(type == 'Percentage'){
                        let totalInvoiceAmount = $('#total_invoice_amount').val();
                        let latestTotalInvoiceAmountWithMerchantAssistant = $('#total_invoice_amount_with_merchant_assistant').val();
                        var totalInvoiceAmountWithMerchantAssistant = parseFloat(latestTotalInvoiceAmountWithMerchantAssistant) + (parseFloat(totalInvoiceAmount)/100)*parseFloat(amount);
                        html = '<div class="percent_amount" data-merchantAssistanceId='+merchantAssistanceId+'>'+merchantAssistanceName+'Added = '+amount+'%';
                    }
                    else{
                        var totalInvoiceAmountWithMerchantAssistant = parseFloat(totalInvoiceAmount) + parseInt(amount);
                        html = '<div class="usd_amount" data-merchantAssistanceId='+merchantAssistanceId+'>'+merchantAssistanceName+'Added = '+amount+' USD';
                    }
                    $('.merchant-assitance-calculation').append(html);
                    $('#total_invoice_amount_with_merchant_assistant').val(totalInvoiceAmountWithMerchantAssistant);
                    $('.total-amount-with-merchant-assitance').empty();
                    $('.total-amount-with-merchant-assitance').append('<div> Total with merchant assitance is :<b>'+totalInvoiceAmountWithMerchantAssistant+'</b></div>');
                }
                else{
                    $('.merchant-assitance-calculation').children().each(function( index ) {
                        var matchedMerchantAssistanceId = $( this ).attr('data-merchantAssistanceId');
                        if(type == 'Percentage'){
                            if(matchedMerchantAssistanceId == merchantAssistanceId){
                                let totalInvoiceAmount = $('#total_invoice_amount').val();
                                let latestTotalInvoiceAmountWithMerchantAssistant = $('#total_invoice_amount_with_merchant_assistant').val();
                                var totalInvoiceAmountWithMerchantAssistant = parseFloat(latestTotalInvoiceAmountWithMerchantAssistant) - (parseFloat(totalInvoiceAmount)/100)*parseFloat(amount);
                                $('#total_invoice_amount_with_merchant_assistant').val(totalInvoiceAmountWithMerchantAssistant);
                                $('.total-amount-with-merchant-assitance').empty();
                                $('.total-amount-with-merchant-assitance').append('<div> Total with merchant assitance is :<b>'+totalInvoiceAmountWithMerchantAssistant+'</b></div>');
                                $( this ).remove();
                            }
                        }
                        else{
                            if(matchedMerchantAssistanceId == merchantAssistanceId){
                                var totalInvoiceAmountWithMerchantAssistant = parseFloat(totalInvoiceAmount) - parseFloat(amount);
                                $('#total_invoice_amount_with_merchant_assistant').val(totalInvoiceAmountWithMerchantAssistant);
                                $('.total-amount-with-merchant-assitance').empty();
                                $('.total-amount-with-merchant-assitance').append('<div> Total with merchant assitance is :<b>'+totalInvoiceAmountWithMerchantAssistant+'</b></div>');
                                $( this ).remove();

                            }
                        }


                    });

                }
            });
        });

        function work_trigger()
        {
            setTimeout(function(){
                //window.location.href = "/message-center";
                var inquires_index= '{{route("po.index")}}';
                    window.location.href = inquires_index;
                // window.location.href = "/pro-forma-invoices";
            }, 1000);
            //window.location.replace("/pro-forma-invoices");
        }

        function show_loader()
        {
            $('.loading-message').html("Please Wait.");
            $('#loadingProgressContainer').show();
        }

        function sendAcceptedMessageToSupplier(status)
        {

            let message = {'message': 'Your PI have been '+status+'. To see the PI please check this URL : {{ $app->make('url')->to('/') }}/open-proforma-single-html/{{$po->id}}','from_id' : "{{Auth::user()->id}}", 'to_id' : "{{ $supplierInfo->id }}"};
            socket.emit('new message', message);

        }

        function sendRejectedMessageToSupplier(status, statusmessage)
        {
            //let message = '/open-proforma-single-html/{{$po->id}}';
            let message = {'message': 'Your PI have been '+status+'. Due to: '+statusmessage+'. To see the PI please check this URL : {{ $app->make('url')->to('/') }}/open-proforma-single-html/{{$po->id}}','from_id' : "{{Auth::user()->id}}", 'to_id' : "{{ $supplierInfo->id }}"};
            socket.emit('new message', message);

        }

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    </script>

@endpush



