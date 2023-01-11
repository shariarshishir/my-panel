    <div class="proforma_invoice_pdf_design_table_wrap">
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
                                    <p style="margin: 0; padding:0;"><b>{{$proforma->businessProfile->business_name ?? ""}}</b></p>
                                    <p style="margin: 0; padding:0;">{{$proforma->businessProfile->location ?? ""}}</p>
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
            <div class="no_more_tables">
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
            </div>
            @endif

            <div class="no_more_tables">
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
                                <td data-title="Place of Shipment" style="border: 1px solid #ddd; padding: 10px;">Place of Shipment</td>
                                <td data-title="Mode of Transport" style="border: 1px solid #ddd; padding: 10px;">
                                    <span>{{ $shippingDetails->shipmentType->name }}</span>
                                </td>
                                <td data-title="ace of Destination" style="border: 1px solid #ddd; padding: 10px;">
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
            </div>
            
            <div class="no_more_tables">
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
                            <td data-title="Payment Info:" style="border: none;">
                                <div class="conactInfo" style="padding: 0">
                                    <p style="padding: 0; margin: 0 0 3px 0;">Payment Within: <b><span> {{$proforma->payment_within ?? ""}} </span></b></p>
                                    <p style="padding: 0; margin: 0;">Payment Term: <b><span> {{$proforma->paymentTerm->name ?? ""}} </span></b></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
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
    