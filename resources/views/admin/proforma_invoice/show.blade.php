@extends('layouts.admin')
@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">PI-PO</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @include('include.admin._message')
                    <div class="main_content_wrapper invoice_container_wrap">

                        <div class="card">
                            <div class="invoice_top_button_wrap">
                                @if($po->status == -1)
                                    <div class="proforma_status_block">
                                        <p>Proforma Status <span style="color: red;">Rejected.</span></p>
                                        <ul>
                                            <li><a href="{{ route('proforma_invoices.edit',[ 'buyerId' => $po->buyer_id,'rfqId'=>$po->generated_po_from_rfq,'proformaId'=>$po->id ]) }}">Update proforma invoice</a></li>
                                            <li class="proforma_status_li_separator">|</li>
                                            <li><a href="{{ route('admin.rfq.show', $po->generated_po_from_rfq) }}" target="_blank">RFQ Details</a></li>
                                            <li class="proforma_status_li_separator">|</li>
                                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#updateBuyerInfoModal">Edit Buyer information</a></li>
                                        </ul>
                                    </div>
                                @endif
                                @if($po->status == 1)
                                    <div class="proforma_status_block">
                                        <p>Proforma Status <span style="color: #55a860;">Accepted.</span></p>
                                        <ul>
                                            <li><a href="{{ route('admin.rfq.show', $po->generated_po_from_rfq) }}" target="_blank">RFQ Details</a></li>
                                            <li class="proforma_status_li_separator">|</li>
                                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#updateBuyerInfoModal">Edit Buyer information</a></li>
                                        </ul>
                                    </div>
                                @endif
                                @if($po->status == 0)
                                    <div class="proforma_status_block">
                                        <p>Proforma Status <span style="color: #ffc107;">Pending.</span></p>
                                        <ul>
                                            <li><a href="{{ route('proforma_invoices.edit',[ 'buyerId' => $po->buyer_id,'rfqId'=>$po->generated_po_from_rfq,'proformaId'=>$po->id ]) }}" target="_blank">Re-generate PI</a></li>
                                            <li class="proforma_status_li_separator">|</li>
                                            <li><a href="{{ route('admin.rfq.show', $po->generated_po_from_rfq) }}" target="_blank">RFQ Details</a></li>
                                            <li class="proforma_status_li_separator">|</li>
                                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#updateBuyerInfoModal">Edit Buyer information</a></li>
                                        </ul>
                                    </div>
                                @endif

                                @if($po->status == 1)
                                <button onclick="printDiv('purchase_order_wrap');" id="printPageButtonTrigger" class="btn_green printPageButton">Print PO</button>
                                @else
                                <button onclick="printDiv('purchase_order_wrap');" id="printPageButtonTrigger" class="btn_green printPageButton">Print</button>
                                @endif

                                <!-- Modal Structure -->
                                <div class="modal fade" id="updateBuyerInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateBuyerInfoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateBuyerInfoModalLabel">Update buyer information</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" id="update-buyer-info-form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-12 input-field">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" value="{{$po->updated_buyer_name ?? ""}}" name="updated_buyer_name"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 input-field">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="text" class="form-control" value="{{$po->updated_buyer_email ?? ""}}" name="updated_buyer_email"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 input-field">
                                                            <div class="form-group">
                                                                <label>Shipping Address</label>
                                                                <input type="text" class="form-control" value="{{$po->updated_buyer_shipping_address ?? ""}}" name="updated_buyer_shipping_address"/>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="updated_proforma_id" value="{{$po->id}}" />
                                                        <div class="col-sm-12 input-field">
                                                            <button type="button" class="btn btn-secondary update_buyer_info_trigger">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="invoice_page_header">
                                <legend>
                                    <i class="fa fa-table fa-fw "></i> Purchase Order
                                </legend>
                            </div>

                            <!-- widget grid -->
                            <section id="widget-grid" class="pro_porma_invoice">
                                <!-- NEW WIDGET START -->
                                <article class="">
                                    <div class="jarviswidget jarviswidget-color-darken no-padding" id="wid-id-0" data-widget-editbutton="false">
                                        <!-- widget content -->
                                        <div class="widget-body">
                                            <div class="buyerdata_info_admin">
                                                <div class="row buyerdata_info_top">
                                                    <div class="col col-md-6" id="buyerdata">
                                                        <span>
                                                            <b>
                                                                @if($po->updated_buyer_name)
                                                                {{$po->updated_buyer_name}}
                                                                @else
                                                                {{$po->buyer->name}}
                                                                @endif
                                                            </b>
                                                        </span><br/>
                                                        <span>
                                                            @if($po->updated_buyer_email)
                                                            {{$po->updated_buyer_email}}
                                                            @else
                                                            {{$po->buyer->email}}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="col col-md-6">
                                                        <div class="form-group has-feedback">
                                                            <label style="margin-bottom: 0;"><b>Beneficiary</b></label>
                                                            <span style="display: block">Merchantbay</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="has_feedback_wrap">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                                            <div class="form-group has-feedback">
                                                                <label>Pro-forma ID</label>
                                                                <p><span>{{ $po->proforma_id }}</span></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                                            <div class="form-group has-feedback">
                                                                <label>Pro-forma Date</label>
                                                                <span>{{ $po->proforma_date }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                                            <div class="form-group has-feedback">
                                                                <label>Payment Within</label>
                                                                <span>{{ $po->payment_within  }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                                            <div class="form-group has-feedback">
                                                                <label>Payment term</label>
                                                                <span>{{ $po->paymentTerm->name  }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                                            <div class="form-group has-feedback">
                                                                <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                                <label>Shipment Term</label>
                                                                <span>{{$po->shipmentTerm->name}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                                            <div class="form-group has-feedback">
                                                                <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                                <label>Shipping Address</label>
                                                                <span>
                                                                    @if($po->updated_buyer_shipping_address)
                                                                    {{$po->updated_buyer_shipping_address}}
                                                                    @else
                                                                    {{$po->shipping_address}}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                                            <div class="form-group has-feedback">
                                                                <label>Shipping Date</label>
                                                                <span>{{ $po->shipping_date }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="line_item_wrap buyer_shipping_details">
                                                <legend>Shipping Details</legend>
                                                <div class="buyerdata_info_admin">
                                                    <div class="shipping_details row">
                                                        <div class="has-feedback col col-sm-12">
                                                            <label><b>Forwarder name </b></label>
                                                            <span> {{ $po->forwarder_name }} </span>
                                                        </div>
                                                        <div class="has-feedback col col-sm-12">
                                                            <label><b>Forwarder Address </b></label>
                                                            <span> {{ $po->forwarder_address }} </span>
                                                        </div>
                                                        <div class="has-feedback col col-sm-12">
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
                                                            <tbody id="shipping-details-table-body" class="">
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
                                            </div>

                                            <div class="line_item_wrap">
                                                <legend>Line Items</legend>
                                                <div class="buyerdata_info_admin">
                                                    <div class="no_more_tables">
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
                                                                <td colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><b>Total Invoice Amount: </b></td>
                                                                <td data-title="Total Invoice Amount:" colspan="2" id="total_price_amount"><b>{{$totalInvoice}}<b></td>
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
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invoice_terms_conditions invoice_buyer_conditions">
                                                <legend>Terms & Conditions</legend>
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
                                            </div>

                                            <div class="invoice_advising_bank">
                                                <legend>Advising Bank</legend>
                                                <div class="buyerdata_info_admin">
                                                    <div class="row">
                                                        <div class="col col-sm-6 col-md-4 col-lg-3">
                                                            <div class="has-feedback">
                                                                <label>Name of the bank</label> <br>
                                                                <span> {{$po->proFormaAdvisingBank->bank_name ?? ""}} </span>
                                                            </div>
                                                        </div>
                                                        <div class="col col-sm-6 col-md-4 col-lg-3">
                                                            <div class="has-feedback">
                                                                <label>Branch name</label><br>
                                                                <span>{{ $po->proFormaAdvisingBank->branch_name ?? "" }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col col-sm-6 col-md-4 col-lg-3">
                                                            <div class="has-feedback">
                                                                <label>Address of the bank </label><br>
                                                                <span> {{ $po->proFormaAdvisingBank->bank_address ?? "" }} </span>
                                                            </div>
                                                        </div>
                                                        <div class="col col-sm-6 col-md-4 col-lg-3">
                                                            <div class="has-feedback">
                                                                <label>Swift code</label><br>
                                                                <span>{{ $po->proFormaAdvisingBank->swift_code ?? "" }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="line_item_wrap buyer_signature">
                                                <legend>Signature</legend>
                                                <div class="buyerdata_info_admin">
                                                    <div class="row">
                                                        <div class="col col-sm-6">
                                                            <h6>Buyer Side</h6>
                                                            <div class="has-feedback">
                                                                <span> {{ $po->proFormaSignature->buyer_singature_name }} </span>
                                                            </div>
                                                            <div class="has-feedback">
                                                                <span>{{$po->proFormaSignature->buyer_singature_designation}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col col-sm-6">
                                                            <h6>Beneficiary Side</h6>
                                                            <div class="has-feedback">
                                                                <span> {{$po->proFormaSignature->beneficiar_singature_name}} </span>
                                                            </div>
                                                            <div class="has-feedback">
                                                                <span> {{ $po->proFormaSignature->beneficiar_singature_designation }} </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- end widget content -->

                                    </div>
                                    <!-- end widget -->

                                    <div class="shipping-files shipping_attachment_wrap">
                                        <legend><i class="fa fa-regular fa-link"></i> Attachment</legend>
                                        <ul>
                                            @foreach($po->proFormaShippingFiles as $image)
                                                <li><i class="fa fa-regular fa-file"></i> {{ asset('storage/'.$image->shipping_details_files) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </article>
                                <!-- WIDGET END -->

                            </section>
                            <!-- end widget grid -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="purchase_order_wrap" id="purchase_order_wrap" style="display: none;">
        <div class="pdf-header-wrapper" style="padding: 30px 0px 20px;" >
            <img src="{{asset('admin-assets/img/pdf-logo.png')}}" alt="Merchantbay Logo" class="pdf_logo" style="width: 200px;" >
        </div>
        <div class="pdf-body-wrapper">
            <table class="table">
                <tbody>
                    <tr>
                        <td style="padding: 0; margin: 0;">
                            <p style="color: #54A958; font-size: 18px; margin-top: 15px; margin-bottom: 15px"><b>Beneficiary</b></p>
                            <p style="font-size: 14px; line-height: 22px; margin: 0;"><b>Merchant Bay</b> <br/>
                            Email: info@merchantbay.com <br/>
                            House#27, Sector#6, Uttara, Dhaka, Bangladesh <br/>
                            Ph: +880 9611-677345 <br/>
                            www.merchantbay.com </p>
                        </td>
                        <td style="padding: 0; margin: 0;">
                            <p style="color: #54A958; font-size: 18px; margin-top: 15px; margin-bottom: 15px"><b>Buyer Detail</b></p>
                            <p style="font-size: 14px; line-height: 22px">
                                <b>
                                    @if($po->updated_buyer_name)
                                    {{$po->updated_buyer_name}}
                                    @else
                                    {{$po->buyer->name}}
                                    @endif
                                </b><br/>
                                @if($po->updated_buyer_email)
                                {{$po->updated_buyer_email}}
                                @else
                                {{$po->buyer->email}}
                                @endif
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table">
                <thead style="background: #ddd;">
                    <tr style="border: none; padding: 0; 0; margin: 0;">
                        <th style="border: none; padding: 0; margin: 0;" width: 100% ><h6 style="padding: 0; margin: 0; font-size: 16px; line-height: 22px;"><i class="fa fa-table fa-fw "></i> Purchase Order</h6></th>
                    </tr>
                </thead>
            </table>
            <table class="table" style="margin-bottom:20px; border-bottom: 1px solid #ddd">
                <tbody>
                    <tr>
                        <td style="padding: 5px 10px 5px 0; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Date</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->proforma_date }}</b></p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Payment term</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->paymentTerm->name  }}</b></p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Forwarder Name:</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->forwarder_name }}</b></p></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px 5px 0; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">PO ID:</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->proforma_id }}</b></p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Shipment Term</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{$po->shipmentTerm->name}}</b></p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Forwarder Address:</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->forwarder_address }}</b></p></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px 5px 0; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Payment Due:</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->payment_within  }}</b></p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Shipping Address</p></td>
                        <td style="padding: 5px 10px; margin: 0;">
                            <p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">
                                @if($po->updated_buyer_shipping_address)
                                <b>{{$po->updated_buyer_shipping_address}}</b>
                                @else
                                <b>{{$po->shipping_address}}</b>
                                @endif

                            </p>
                        </td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Shipping Charge:</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->payable_party}}</b></p></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px 5px 0; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Shipping Date:</p></td>
                        <td style="padding: 5px 10px; margin: 0;" colspan="5"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{ $po->shipping_date  }}</b></p></td>
                    </tr>
                </tbody>
            </table>

            <table class="table" style="border: none; margin-top: 20px;">
                <thead style="background: #ddd;">
                    <tr style="border: none; padding-top: 0; padding-bottom: 0; margin: 0;">
                        <th style="border: none; padding: 0; margin: 0;" width: 100% ><h6 style="margin: 0; padding:0; font-size: 16px; line-height: 22px;"> <img src="{{asset('admin-assets/img/pdf-list.png')}}" alt="Line Items" style="width: 15px; margin-right: 5px;" > Line Items</h6></th>
                    </tr>
                </thead>
            </table>

            <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                <thead class="cf">
                    <tr>
                        <th style="padding: 5px 10px 5px 0; margin: 0; background-color: #ddd;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Sl. No.</p></th>
                        <th style="padding: 5px 10px; margin: 0; background-color: #ddd;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0; white-space: nowrap;">Item / Description </p></th>
                        <th style="padding: 5px 10px; margin: 0; background-color: #ddd;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Quantity</p></th>
                        <th style="padding: 5px 10px; margin: 0; background-color: #ddd;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Unit Price</p></th>
                        <th style="padding: 5px 10px; margin: 0; background-color: #ddd;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Sub Total</p></th>
                        <!-- <th style="width:15%;">Tax</th> -->
                        <th style="padding: 5px 10px; margin: 0; background-color: #ddd;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Total Price</p></th>
                        <!-- <th style="width:5%; text-align:center;"></th> -->
                    </tr>
                </thead>
                <tbody id="lineitems" class="">
                    @foreach($po->performa_items as  $key => $proFormaItem)
                    <tr>
                        <td style="padding: 5px 10px 5px 0; margin: 0;" data-title="Sl. No."><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> {{$key+1 }}</p></td>
                        <td style="padding: 5px 10px; margin: 0;" data-title="Item / Description">
                            <span><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> {{ $proFormaItem->item_title }}</p></span>
                        </td>
                        <td style="padding: 5px 10px; margin: 0;" data-title="Quantity">
                            <span><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $proFormaItem->unit }}</p></span>
                        </td>
                        <td style="padding: 5px 10px; margin: 0;" data-title="Unit Price">
                            <span><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $proFormaItem->unit_price }}</p></span>
                        </td>
                        <td style="padding: 5px 10px; margin: 0;" data-title="Sub Total">
                            <span><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $proFormaItem->total_price }}</p></span>
                        </td>
                        <td style="padding: 5px 10px; margin: 0;" data-title="Total Price">
                            <span><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $proFormaItem->tax_total_price }}</p></span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tr>
                    <td style="padding: 5px 10px; margin: 0; text-align: right; font-size: 15px; line-height: 22px;" colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>Total Invoice Amount: </b></p></td>
                    <td style="padding: 5px 10px; margin: 0; font-size: 15px; line-height: 22px;" data-title="Total Invoice Amount:" colspan="2" id="total_price_amount"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{$totalInvoice}}<b></p></td>
                </tr>
                @foreach($po->checkedMerchantAssistances as $assistance)
                <tr>
                    <td style="padding: 5px 10px; margin: 0; text-align: right; font-size: 15px; line-height: 22px;" colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>{{$assistance->merchantAssistance->name}}: </b></p></td>
                    <td style="padding: 5px 10px; margin: 0; font-size: 15px; line-height: 22px;" data-title="Total Invoice Amount:" colspan="2" id="total_price_amount"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $assistance->merchantAssistance->amount }}<b> {{ $assistance->merchantAssistance->type=='Percentage' ? '%' :'USD'}} <b></p></td>
                </tr>
                @endforeach
                @if($po->total_invoice_amount_with_merchant_assistant)
                <tr>
                    <td style="padding: 5px 10px; margin: 0; text-align: right; font-size: 15px; line-height: 22px;" colspan="5" class="right-align grand_total_title" style="padding-right: 20px"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b>Your total order amount with merchant assistant : </b></p></td>
                    <td style="padding: 5px 10px; margin: 0; font-size: 15px; line-height: 22px;" data-title="Total Invoice Amount:" colspan="2" id="total_price_amount">{{$po->total_invoice_amount_with_merchant_assistant}} <p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"><b> USD <b></p></td>
                </tr>
                @endif
            </table>

            <table class="table" style="border: none; margin: 20px 0 10px; ">
                <thead style="background: #ddd;">
                    <tr style="border: none; padding: 0; margin: 0;">
                        <th style="border: none; padding: 0; margin: 0;" width: 100% ><h6 style="margin: 0; padding:0; font-size: 16px; line-height: 22px;"> <img src="{{asset('admin-assets/img/terms-conditions.png')}}" alt="Terms Conditions" style="width: 20px;  " > Terms & Conditions</h6></th>
                    </tr>
                </thead>
            </table>
            <table class="table" style="border: none;">
                <tbody style="border: none;">
                    <tr style="border: none; padding-top: 0; padding-bottom: 0; margin: 0;">
                        <td style="padding: 5px 10px; margin: 0; border: none;">
                            <ul class="list-group terms-lists" style="padding: 0; margin: 0; border: none;">
                                @foreach($po->supplierCheckedProFormaTermAndConditions as $supplierCheckedProFormaTermAndCondition)
                                <li class="list-group-item" style="padding:0; margin: 0; border: none;">
                                    <p style="font-size: 13px; line-height: 22px; margin: 0; padding: 0;"> <i class="fa fa-light fa-check" style="margin-right: 7px"></i> {{$supplierCheckedProFormaTermAndCondition->proFormaTermAndCondition->term_and_condition}}</p>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="list-group terms-lists" style="padding: 0; margin: 0; border: none;">
                                @foreach(json_decode($po->condition) as $key=>$condition)
                                <li class="list-group-item" style="padding: 0; margin: 0; border: none;">
                                    <p style="font-size: 13px; line-height: 22px; margin: 0; padding: 0;"> <i class="fa fa-light fa-check" style="margin-right: 7px"></i> {{$condition}}</p>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table" style="border: none; margin: 0px; padding:0;">
                <thead style="background: #ddd; margin: 0px; padding:0;">
                    <tr style="border: none; padding: 0; margin: 0;">
                        <th style="border: none; padding: 0; margin: 0;" width: 100% ><h6 style="margin: 0 0 10px; padding:0; font-size: 16px; line-height: 22px;"> <img src="{{asset('admin-assets/img/advising-bank.png')}}" alt="Advising Bank" style="width: 20px;  " > Advising Bank</h6></th>
                    </tr>
                </thead>
            </table>
            <table class="table" style="margin-bottom:30px; border-bottom: 1px solid #ddd">
                <thead style="background: #ddd;">
                    <tr>
                        <th style="padding: 5px 10px 5px 0; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> Name of the bank</p></th>
                        <th style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> Branch name</p></th>
                        <th style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> Address of the bank</p></th>
                        <th style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> Swift code</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 5px 10px 5px 0; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{$po->proFormaAdvisingBank->bank_name ?? ""}} </p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $po->proFormaAdvisingBank->branch_name ?? "" }} </p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $po->proFormaAdvisingBank->bank_address ?? "" }}</p></td>
                        <td style="padding: 5px 10px; margin: 0;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $po->proFormaAdvisingBank->swift_code ?? "" }}</p></td>
                    </tr>

                </tbody>
            </table>

            <table class="table" style="border: none; margin: 0; padding: 0;">
                <thead style="background: #ddd;">
                    <tr style="border: none; padding-top: 0; padding-bottom: 0; margin: 0;">
                        <th style="border: none; padding: 0; margin: 0;" width: 100% ><h6 style="margin: 0 0 10px; padding:0; font-size: 16px; line-height: 22px;"> <img src="{{asset('admin-assets/img/signatories.png')}}" alt="Signature" style="width: 20px;  " > Signature</h6></th>
                    </tr>
                </thead>
            </table>

            <table class="table" style="margin: 0px; padding: 0; border-top: 1px solid #ddd;">
                <thead style="background: #ddd;">
                    <tr>
                        <th style="padding: 10px 10px 40px 0; margin: 0; border: none;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> Buyer Side</p></th>
                        <th style="padding: 10px 10px 40px; margin: 0; border: none;"><p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">Beneficiary Side</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 5px 10px 5px 0; margin: 0; border: none;">
                            <div class="has-feedback">
                                <p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;"> {{ $po->proFormaSignature->buyer_singature_name }} </p>
                            </div>
                            <div class="has-feedback">
                                <p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{$po->proFormaSignature->buyer_singature_designation}}</p>
                            </div>
                        </td>
                        <td style="padding: 5px 10px; margin: 0; border: none;">
                            <div class="has-feedback">
                                <p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{$po->proFormaSignature->beneficiar_singature_name}}</p>
                            </div>
                            <div class="has-feedback">
                                <p style="font-size: 14px; line-height: 22px; margin: 0; padding: 0;">{{ $po->proFormaSignature->beneficiar_singature_designation }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>


            <table class="table" style="margin:30px 0 0; padding: 0; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
                <tbody>
                    <tr>
                        <td style="padding: 20px 10px 10px; margin: 0; border: none; text-align: center;">
                            <p style="font-size: 14px; line-height: 26px;">If you have any questions, please contact Merchant Bay. <br/>
                            Phone: +880-2-09611677345, Email: info@merchantbay.com</p>
                        </td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>

</div>


@endsection

@push('js')
<script>
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

$(document).ready(function(){
    $(".update_buyer_info_trigger").click(function(){
        //alert("I am here");
        var updatedBuyerName = $('input[name="updated_buyer_name"]').val();
        var updatedBuyerEmail = $('input[name="updated_buyer_email"]').val();
        var updatedBuyerShippingAddress = $('input[name="updated_buyer_shipping_address"]').val();
        var updatedBuyerProformaId = $('input[name="updated_proforma_id"]').val();

        $.ajax({
            method: 'POST',
            data: { updated_buyer_name:updatedBuyerName, updated_buyer_email:updatedBuyerEmail, updated_buyer_shipping_address:updatedBuyerShippingAddress, updated_proforma_id:updatedBuyerProformaId, "_token":"{{ csrf_token() }}"},
            url: '{{route('proforma_invoices.update.buyer.info')}}',
            beforeSend: function() {
                //$('.loading-message').html("Please Wait.");
                //$('#loadingProgressContainer').show();
            },
            success:function(response){
                //$('.loading-message').html("");
                //$('#loadingProgressContainer').hide();
                $("#updateBuyerInfoModal").modal("hide");
                location.reload();
                //swal("Done!", response.message, "success");
            }
        });
    })
})
</script>
@endpush


