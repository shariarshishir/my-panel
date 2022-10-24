@extends('layouts.app')

@section('content')

@include('my_order.partials._profile_list')

<section class="ic-receive-for-quote">
    <div class="container">
        <div class="col-md-12 my-prd-hd-cont">
            <div class="row">
                <div class="col-md-10 plr0">
                    <h5 class="my-prd-hd">Pro-Forma Invoices</h5>
                </div>
                <div class="col-md-2 plr0" style="text-align: right;">
                    <a href="{{ url('/rfqorders') }}" class="btn btn-success">RFQ Order</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <!--list&product-->

                <!--prd list-->
                <div class="col-md-12" >
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th data-hide="phone" class="text-center">ID</th>
                                <th data-class="expand" class="text-center">Invoice Id</th>
                                <th data-class="expand" class="text-center"> Date</th>
                                <th data-class="expand" class="text-center"> Total Price</th>
                                <th data-hide="phone" class="text-center"> Payment Within</th>
                                <th class="text-center"> Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pos as $index => $po)
                                @php $total_price_wt = 0; @endphp
                                @foreach($po->performa_items as $item)
                                    @php $total_price_wt += $item->tax_total_price; @endphp
                                @endforeach
                                <tr class="text-center">
                                    <td>{{ $po->id }}</td>
                                    <td>
                                        {{ $po->proforma_id }}<br>
                                        @if($po->status == 1)
                                            PO ID: {{$po->po_no}}
                                        @endif
                                    </td>
                                    <td>{{ $po->proforma_date }}</td>
                                    <td><a href="javascript:void(0)" data-toggle="modal" data-target="#detailsFormModal{{ $index }}">{{ number_format($total_price_wt,2) }}</a></td>
                                    <td>{{ $po->payment_within }}</td>
                                    <td>
                                        @if($po->status == 0)
                                            <div class="status-btn">
                                                <a href="/open-proforma-single-html/{{ $po->id }}" class="btn btn-warning" style="color: #fff; width: 120px;">
                                                    PI Pending<br />
                                                    <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; View Invoice
                                                </a>
                                            </div>
                                        @endif
                                        @if($po->status == 1)
                                            <div class="status-btn">
                                                <a href="/open-proforma-single/{{ $po->id }}" class="btn btn-success" target="_blank" style="color: #fff; width: 120px;">
                                                    PO Generated<br />
                                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp; View Pdf
                                                </a>
                                            </div>
                                        @endif
                                        @if($po->status == -1)
                                            <div class="status-btn">
                                                <a href="/open-proforma-single/{{ $po->id }}" class="btn btn-danger" target="_blank" style="color: #fff; width: 120px;">
                                                    PI Rejected<br />
                                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp; View Pdf
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--/prd list-->
                <div class="col-xs-12">
                    <div class="ic-pagination">
                        <div class="col-xs-12 text-center">
                            <div class="ic-pagination">
                                {{ $pos->links('pagination.blog') }}
                            </div>
                        </div>
                    </div>
                </div>
            <!--list&product-->
            </div>
        </div>

        <div class="clear50"></div>
    </div>
</section>
@if(count($pos) > 0)
@foreach($pos as $index => $po)
@foreach($po->performa_items as $item)
    <div class="modal fade" id="detailsFormModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $index }}"  aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
           <div class="modal-content">
                <div class="modal-header modal-hdr-custum" style="background: rgb(85, 168, 96) none repeat scroll 0% 0%; border-radius: 4px 4px 0px 0px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 34px;color: #FFF;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: rgb(255, 255, 255);">{{ $po->proforma_id }}<br><small style="color: #FFF;font-size: 15px;">Item Details</small></h4>
                </div>
                <div class="modal-body modal-bdy-bdr">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 35px;">
                            <table class="table" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">Sl. No.</th>
                                        <th style="width:15%;">Item / Description</th>
                                        <th style="width:15%;">Quantity</th>
                                        <th style="width:15%;">Unit Price</th>
                                        <th style="width:15%;">Sub Total</th>
                                        <th style="width:15%;">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_price = 0; @endphp
                                    @php $total_tax_price = 0; @endphp
                                    @foreach($po->performa_items as $ik => $items)
                                        <tr>
                                            <td>{{$ik + 1}}</td>
                                            <td>
                                                {{ $item->product->title }}
                                                <p class="supplier_details" style="color: #50AA5B;">{{ $item->supplier->name }}</p>
                                            </td>
                                            <td>{{ $item->unit }}</td>
                                            <td>{{ number_format($item->unit_price, 2) }}</td>
                                            <td>{{ number_format($item->total_price, 2) }}</td>
                                            <td>{{ number_format($item->tax_total_price, 2) }} ({{ $item->tax }}% Tax)</td>
                                        </tr>
                                        @php $total_price += $item->total_price; @endphp
                                        @php $total_tax_price += $item->tax_total_price; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" align="right"><b>Total Tax</b></td>
                                        <td colspan="1" align="left">{{ number_format(($total_tax_price - $total_price), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right"><b>Total Invoice Amount</b></td>
                                        <td colspan="1" align="left">{{ number_format($total_tax_price, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

@endforeach
@endforeach
@endif
<!--Add New RFQ Modal-->
<div class="modal" id="editRFQModal">
<div class="modal-dialog modal-xl" style="width:900px;">
    <div class="modal-content">

        <!--Modal Header-->
        <div class="modal-header modal-hdr-custum" style="background:#55A860; border-radius:4px 4px 0 0;">
            <div class="col-md-11"><h4 class="modal-title" style="color:#fff;">Accept Pro-Forma Invoice <br><small style="color: #FFF;font-size: 14px;" id="invoice_id">ASDF</small></h4></div>
            <div class="col-md-1"><button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button></div>
        </div>
        <!--Modal Header-->

        <!-- Modal body -->
        <div class="modal-body modal-bdy-bdr">
            <form action="{{ action('RFQController@acceptproformainvoice') }}" class="createRfqForm" method="post" enctype="multipart/form-data">
            @csrf
                <input type="hidden" id="proforma_id" name="proforma_id">
                <div class="col-md-12" style="padding-right: 0px;">
                    <div class="col-md-12 pl0 mb15">
                        <span class="has-float-label">
                            <input type="text" class="form-control" name="po_id" required style="margin-right: 40px; padding-left: 32px;"/>
                            <label style="padding-left: 25px; color: rgb(85, 168, 96);">PO ID</label>
                            <i class="ig-new-lft" style="padding-top: 0px; z-index: 100;"><img src="images/category16.png"></i>
                        </span>
                    </div>
                    <div class="clear30"></div>
                    <div class="ic-form-btn ic-buying-req-btn text-center">
                        <button type="button" class="btn-red mr15" data-dismiss="modal"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Cancel</button>
                        <button type="submit" class="btn-green"><i class="fa fa-check-circle fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Submit</button>
                    </div>
                    <div class="clear20"></div>
                </div>
            </form>
        </div>
        <!-- Modal body -->
        <div class="clear"></div>
        <!--Modal footer-->
        <!--<div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>-->
        <!--/Modal footer-->
    </div>
</div>
</div>
<!--/Add New RFQ Modal-->



@endsection

@include('my_order.partials._scripts')
@push('js')
<script>
    function openacceptpop(pii,piid)
    {
        $('#editRFQModal').modal();
        $('#proforma_id').val(pii);
        $('#invoice_id').html(piid);
    }
</script>
@endpush

@endpush
