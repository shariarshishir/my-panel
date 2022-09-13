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
            <div class="card proforma_invoices_wrap">
                <div class="row">
                    <div class="col-md-12">

                        @include('include.admin._message')

                        <div class="widget-body p-0">
                            <form action="{{ route('proforma_invoices.store') }}" id="po-generate-form" method="post" enctype="multipart/form-data">
                            @csrf
                                <!-- <div style="padding-top: 30px;"></div> -->
                                <div class="row beneficiary_info_wrap">
                                    <!-- <div class="col s12 m6 l6"> -->
                                    <div class="col-sm-12 input-field beneficiary_address_bar">
                                        <legend class="">Create Pro-Forma Invoice </legend>
                                        <div class="row" style="margin: 0;">
                                            <div class="col-sm-12 col-md-6" id="buyerdata">
                                                <h3>Buyer</h3>
                                                <p>{{$buyer->name}}</p>
                                                <p>{{$buyer->email}}</p>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label>Beneficiary</label>
                                                    <p>Merchantbay.Ltd</p>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="selected_buyer_id" value="{{$buyer->id}}" />
                                    </div>
                                    <div class="col-sm-12" style="padding-bottom: 15px;">
                                        <div class="row" style="margin: 0;">
                                            <div class="col-sm-12 col-md-6 col-lg-2 input-field">
                                                <div class="form-group has-feedback">
                                                    <label>Pro-forma ID <span class="required_star" style="color: rgb(255, 0, 0)" >*</span> </label>
                                                    <input type="text" class="form-control" required name="po_id"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-2 input-field">
                                                <div class="form-group has-feedback">
                                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                    <label>Pro-forma Date <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                    <input type="date" class="form-control" required name="po_date"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-2 input-field">
                                                <div class="form-group has-feedback">
                                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                    <label>Payment Within <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                    <select class="form-control select2" required name="payment_within">
                                                        <option value="On Delivery">On Delivery</option>
                                                        <option value="Immediate">Immediate</option>
                                                        <option value="Within 7 Days">Within 7 Days</option>
                                                        <option value="Within 15 Days">Within 15 Days</option>
                                                        <option value="Within 30 Days">Within 30 Days</option>
                                                        <option value="Within 90 Days">Within 90 Days</option>
                                                        <option value="Within 120 Days">Within 120 Days</option>
                                                        <option value="Within 150 Days">Within 150 Days</option>
                                                        <option value="Within 180 Days">Within 180 Days</option>
                                                        <option value="Within 210 Days">Within 210 Days</option>
                                                        <option value="Within 240 Days">Within 240 Days</option>
                                                        <option value="Within 270 Days">Within 270 Days</option>
                                                        <option value="Within 300 Days">Within 300 Days</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-2 input-field">
                                                <div class="form-group has-feedback">
                                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                    <label>Payment term<span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                    <select class="form-control select2" required name="payment_term">
                                                        @foreach($paymentTerms as $paymentTerm)
                                                            <option value="{{$paymentTerm->id}}">{{$paymentTerm->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-2 input-field">
                                                <div class="form-group has-feedback">
                                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                    <label>Shipment Term <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                    <select class="form-control select2" required name="shipment_term">
                                                        @foreach($shipmentTerms as $shipmentTerm)
                                                            <option value="{{$shipmentTerm->id}}">{{$shipmentTerm->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-2 input-field">
                                                <div class="form-group has-feedback">
                                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                    <label>Shipping Address <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                    <input type="text" class="form-control" required name="shipping_address"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-2 input-field">
                                                <div class="form-group has-feedback">
                                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                    <label>Shipping Date <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                    <input type="date" class="form-control" required name="shipping_date"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="selected_buyer_id" value="{{$buyer->id}}" />
                                    <input type="hidden" name="generated_po_from_rfq" value="{{$rfqId}}" />
                                </div>
                                <div class="line_item_wrap shipping_details_wrap">
                                    <legend>Shipping Details</legend>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-4 input-field">
                                                <div class="form-group has-feedback">
                                                    <label>Forwarder name  </label>
                                                    <input type="text" class="form-control" name="forwarder_name"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-4 input-field">
                                                <div class="form-group has-feedback">
                                                    <label>Forwarder Address</label>
                                                    <input type="text" class="form-control" name="forwarder_address"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-4 input-field">
                                                <div class="form-group has-feedback">
                                                    <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:25px;"></div> -->
                                                    <label>Payable party </label>
                                                    <select class="form-control select2" name="payable_party">
                                                        <option value="Buyer">Buyer</option>
                                                        <option value="Buyer">Supplier</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <a  class="btn btn-primary btn_green" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-file-upload"></i> Attach file</a>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="no_more_tables">
                                            <table class="table shipping_details_table">
                                                <thead>
                                                    <tr>
                                                        <th>Shipping Method <span class="required_star" style="color: red;">*</span></th>
                                                        <th>Shipment Type <span class="required_star" style="color: red;">*</span></th>
                                                        <th>UOM <span class="required_star" style="color: red;">*</span></th>
                                                        <th>Per UOM Price ($)</th>
                                                        <th>QTY</th>
                                                        <!-- <th style="width:15%;">Tax</th> -->
                                                        <th>Total ($)</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="shipping-details-table-body" class="input-field">
                                                    <tr>
                                                        <td data-title="Shipping Method">
                                                            <select name="shipping_details_method[]" class="form-control select2" >
                                                                <option value="">Select</option>
                                                                @foreach($shippingMethods as $shippingMethod)
                                                                    <option value="{{ $shippingMethod->id }}">{{ $shippingMethod->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td data-title="Shipment Type">
                                                            <select  name="shipping_details_type[]" class="form-control select2">
                                                                <option value="">Select</option>
                                                                @foreach($shipmentTypes as $shipmentType)
                                                                    <option value="{{ $shipmentType->id }}">{{ $shipmentType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td data-title="UOM">
                                                            <select name="shipping_details_uom[]" class="form-control select2">
                                                                <option value="">Select</option>
                                                                @foreach($uoms as $uom)
                                                                    <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td data-title="Per UOM Price ($)">
                                                            <input type="number" name="shipping_details_per_uom_price[]" step="any" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;"  onkeyup="changeunit(this)"/>
                                                        </td>
                                                        <td data-title="QTY">
                                                            <input type="text" name="shipping_details_qty[]" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;"  onkeyup="changeunitprice(this)"/>
                                                        </td>
                                                        <td data-title="Total ($)">
                                                            <input type="text"  name="shipping_details_total[]" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;"  readonly/>
                                                        </td>
                                                        <td data-title=""><a href="javascript:void(0);" class="ic-btn4" onclick="addShippingDetails()"><i aria-hidden="true" class="fa fa-plus fa-lg"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>


                                </div>

                                <!-- Modal Structure -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attach Files</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="no_more_tables">
                                                <table class="shipment-file-upload-table-block">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Image</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input class="input-field form-control" name="shipping_details_file_names[]" id="shipping-details-title" type="text"  ></td>
                                                        <td><input class="input-field file_upload form-control" name="shipping_details_files[]" id="shipping-details-file" type="file"></td>
                                                        <td class="right-align"><a href="javascript:void(0);" class="btn_delete" onclick="removeShippingDetailsFile(this)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="add_more_box">
                                                <a href="javascript:void(0);" class="add-more-block" onclick="addShippingDetailsFile()"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button>
                                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                        </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="line_item_wrap">
                                    <legend>Line Items</legend>
                                    <div class="no_more_tables">
                                        <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                                            <thead class="cf">
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>Item / Description <span class="required_star" style="color: red;">*</span></th>
                                                    <th>Quantity <span class="required_star" style="color: red;">*</span></th>
                                                    <th>Unit Price <span class="required_star" style="color: red;">*</span></th>
                                                    <th>Sub Total <span class="required_star" style="color: red;">*</span></th>
                                                    <!-- <th style="width:15%;">Tax</th> -->
                                                    <th>Total Price </th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="lineitems" class="input-field">
                                                <tr>
                                                    <td data-title="Sl. No.">1</td>
                                                    <td data-title="Item / Description">
                                                        <input type="text" class="item_title form-control" name="item_title[]" required>
                                                        <input type="hidden" class="form-control" name="supplier[]" required/>
                                                        <input type="hidden" class="form-control" name="product[]" required/>
                                                        <input type="hidden" class="form-control" name="price_unit[]" required/>
                                                        <span class="supplier_details" style="color: #50AA5B;"></span>
                                                    </td>
                                                    <td data-title="Quantity">
                                                        <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div> -->
                                                        <input type="number" class="form-control unit" style="border:1px solid #ccc; margin-bottom:0;" name="unit[]" onkeyup="changeunit(this)" required/>
                                                    </td>
                                                    <td data-title="Unit Price">
                                                        <!-- <div style="height: 25px;width: 0px;border-left: 5px solid rgb(255, 0, 0);position: absolute;top:8px;"></div> -->
                                                        <input type="text" class="form-control unit_price" style="border:1px solid #ccc; margin-bottom:0;" name="unit_price[]" onkeyup="changeunitprice(this)" required/>
                                                    </td>
                                                    <td data-title="Sub Total">
                                                        <input type="text" class="form-control total_price" style="border:1px solid #ccc; margin-bottom:0;" name="total_price[]" readonly/>
                                                        <input type="hidden" class="taxprice" name="tax[]" value="0" />
                                                    </td>
                                                    <td data-title="Total Price"><input type="text" class="form-control tax_total_price" style="border:1px solid #ccc; margin-bottom:0;" name="tax_total_price[]" readonly/></td>
                                                    <td><a href="javascript:void(0);" class="ic-btn4" onclick="addlineitem()"><i aria-hidden="true" class="fa fa-plus fa-lg"></i></a></td>
                                                </tr>
                                            </tbody>

                                            <tr>
                                                <td colspan="5"class="grand_total_title" style="padding-right: 20px"><b>Total Invoice Amount</b></td>
                                                <td data-title="Total Invoice Amount" colspan="2" align="left" id="total_price_amount">0.00</td>
                                            </tr>

                                            <tfoot>
                                                <!--tr>
                                                    <td colspan="6" align="right"><b>Total Tax</b></td>
                                                    <td colspan="2" align="left" id="total_tax_price_amount">0.00</td>
                                                </tr-->

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="invoice_terms_conditions">
                                    <legend>Terms & Conditions</legend>
                                    <div class="terms_conditions_list">
                                        <ul class="list-group terms-lists">
                                            @foreach($proFormaTermAndConditions as $proFormaTermAndCondition)
                                            <li class="list-group-item">
                                                <div class="input-group input-field">
                                                    <label class="terms-label">
                                                        <input class="checkbox" type="checkbox"  name="fixed_terms_conditions[]" value="{{$proFormaTermAndCondition->id}}" >
                                                        <span>{{ $proFormaTermAndCondition->term_and_condition }}</span>
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="add_more_condi"><span><a href="javascript:void(0);" class="ic-btn4" onclick="addMoreTermAndCondition()"><i aria-hidden="true" class="fa fa-plus fa-lg"></i>More terms & conditions</a></span></div>

                                        <ul class="list-group terms-lists more-term-and-condition-unorder-list">
                                            <!--li class="list-group-item ">
                                                <div class="input-group input-field">
                                                    <input class="form-control" type="text"  name="terms_conditions[]" placeholder="Terms and condition" value="">
                                                </div>
                                            </li-->
                                        </ul>
                                    </div>
                                </div>

                                <div class="invoice_advising_bank">
                                    <legend>Advising Bank</legend>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-3 input-field">
                                            <div class="has-feedback">
                                                <label>Name of the bank <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                <input type="text" name="bank_name" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3 input-field">
                                            <div class="has-feedback">
                                                <label>Branch name</label>
                                                <input type="text" name="branch_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3 input-field">
                                            <div class="has-feedback">
                                                <label>Address of the bank</label>
                                                <input type="text" name="bank_address" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-3 input-field">
                                            <div class="has-feedback">
                                                <label>Swift code</label>
                                                <input type="text" name="swift_code" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="line_item_wrap invoice_signature_wrap">
                                    <div class="row input-field">
                                        <legend>Signature</legend>
                                        <div class="col-sm-12 col-md-6">
                                            <h6>Buyer Side</h6>
                                            <div class="row">
                                                <div class="col-sm-12 input-field">
                                                    <div class="form-group has-feedback">
                                                        <label>Name<span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                        <input type="text" class="form-control" required name="buyer_singature_name"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 input-field">
                                                    <div class="form-group has-feedback">
                                                        <label>Designation <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                        <input type="text" class="form-control" required name="buyer_singature_designation"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <h6>Beneficiary Side</h6>
                                            <div class="row">
                                                <div class="col-sm-12 input-field">
                                                    <div class="form-group has-feedback">
                                                        <label>Name <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                        <input type="text" class="form-control"  name="beneficiar_singature_name" required/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 input-field">
                                                    <div class="form-group has-feedback">
                                                        <label>Designation <span class="required_star" style="color: rgb(255, 0, 0)" >*</span></label>
                                                        <input type="text" class="form-control"  name="beneficiar_singature_designation" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="right invoice_submit">
                                    <button type="submit" class="btn_green btn-success submit_po_form">
                                        <i class="fa fa-send"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection


@include('admin.proforma_invoice._scripts')
