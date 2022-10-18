<div class="order_inquiries_table card">
    <div class="no_more_tables">
        <table id="po-table">
            <thead class="cf">
                <tr >
                    <th>created_at</th>
                    <th class="center-align">Image</th>
                    <th class="center-align">Order Id</th>
                    <th class="center-align">Delivery Date</th>
                    <th class="center-align">Progress</th>
                    <th class="center-align">Payment Status</th>
                    <th class="center-align">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($proforma as $index => $po )
                    @php $total_price_wt = 0; @endphp
                    @foreach($po->performa_items as $item)
                        @php $total_price_wt += $item->tax_total_price; @endphp
                    @endforeach
                    <tr>
                        <td>{{$po->created_at}}</td>
                        <td>
                            @if(isset($po->rfq_img))
                                @php
                                    $imgFullpath = explode('/', $po->rfq_img);
                                    $imgExt = end($imgFullpath);
                                @endphp
                                @if(pathinfo($imgExt, PATHINFO_EXTENSION) == 'pdf' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'PDF')
                                    <span class="pdf_icon">&nbsp;</span>
                                @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'doc' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'docx')
                                    <span class="doc_icon">&nbsp;</span>
                                @elseif(pathinfo($imgExt, PATHINFO_EXTENSION) == 'xlsx' || pathinfo($imgExt, PATHINFO_EXTENSION) == 'xls')
                                    <span class="xlsx_icon">&nbsp;</span>
                                @else
                                    <img src="{{$po->rfq_img}}" alt="" style="width: 100px;" />
                                @endif
                            @endif
                        </td>
                        <td data-title="Invoice Id">{{ $po->proforma_id }}</td>
                        <td data-title="Date">{{ $po->shipping_date }}</td>
                        <td>
                            @if($po->status == 1)
                            <span class="btn_green btn-success">Accepted</span>
                            @else
                            <span class="btn_green btn-warning pi_pending">Pending</span>
                            @endif
                        </td>  <!-- if po_no has value then show accepted or pending -->
                        <td>{{ $po->PaymentTerm->name }}</td>
                        <td data-title="Status">
                            @if($po->status == 0)
                                <div class="status-btn center-align">
                                    <a href="{{route('open.proforma.single.html', $po->id)}}" class="btn_green btn-warning pi_pending">
                                        PI Pending
                                    </a>
                                    <br />
                                    <span><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Invoice</span>
                                </div>
                            @endif
                            @if($po->status == 1)
                                <div class="status-btn center-align">
                                    <a href="{{route('open.proforma.single.html', $po->id)}}" class="btn_green btn-success" target="_blank" >
                                        PO Generated
                                    </a>
                                    <br />
                                    <span style="display: none;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp; View</span>
                                </div>
                            @endif
                            @if($po->status == -1)
                                <div class="status-btn center-align">
                                    <a href="{{route('open.proforma.single.html', $po->id)}}" class="btn_green btn-danger pi_rejected" target="_blank">
                                        PI Rejected
                                    </a>
                                    <br/>
                                    <span style="display: none;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp; View</span>
                                    <!-- <div class="revice_order_btn" style="display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;background-color: transparent;border: 1px solid #dae0e5;border-radius: 4px;color: #212529;"></div> -->
                                    <div class="revice_order_btn">
                                        @if(auth()->id() == $po->created_by)
                                            <div class="update-po-btn center-align">
                                                <a class="btn_green" href="{{route('po.edit',['toid' => $po->buyer->id, 'poid' => $po->id])}}" >
                                                    Update PO
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="rejectdetails-po-btn center-align">
                                        <a class="waves-effect waves-light btn_green modal-trigger" href="#rejectPoDetailsModal">
                                            PO rejection Causes
                                        </a>
                                    </div>
                                </div>

                                <div class="modal" id="rejectPoDetailsModal">
                                    <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                            <div class="modal-header modal-hdr-custum" style="background: rgb(85, 168, 96) none repeat scroll 0% 0%; border-radius: 4px 4px 0px 0px;">
                                                <h4 class="modal-title">
                                                    Why your PO have been rejected.
                                                </h4>
                                            </div>
                                            <div class="modal-body modal-bdy-bdr">
                                                {{ $po->reject_message }}
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#!" class="modal-close waves-effect waves-green btn-flat">close</a>
                                    </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('my_order.buyer_orders._scripts')

