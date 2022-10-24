@extends('layouts.admin')
@section('content')
!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">PI PO list</li>
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
                <div class="card">
                    <legend>Proforma invoice List</legend>

                    <div class="no_more_tables">
                        <table class="table table-bordered admin-proforma-table">
                            <thead>
                                <tr>
                                    <th class="text-left">RFQ Title</th>
                                    <th>Buyer Name</th>
                                    <th>Invoice Title</th>
                                    <th>Delivery Date</th>
                                    <th style="displaY: none;">RFQ ID</th>
                                    <th>PI Status</th>
                                    <th>Created Date</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proformaInvoices as $key=>$proformaInvoice)
                                    <tr>
                                        <td data-title="rfq_title" class="text-left">
                                            <a href="{{ route('admin.rfq.show', $proformaInvoice->generated_po_from_rfq) }}">{{ $proformaInvoice->rfq_title }}</a>
                                        </td>
                                        <td data-title="buyer_name">
                                            @if($proformaInvoice->updated_buyer_name)
                                            {{$proformaInvoice->updated_buyer_name}}
                                            @else
                                            {{$proformaInvoice->buyer->name}}
                                            @endif
                                        </td>
                                        <td data-title="proforma_id">
                                            {{$proformaInvoice->proforma_id}}
                                        </td>
                                        <td data-title="proforma_date">
                                            {{$proformaInvoice->proforma_date}}
                                        </td>
                                        <td data-title="rfq_id" style="displaY: none;">
                                            {{$proformaInvoice->generated_po_from_rfq}}
                                        </td>
                                        <td data-title="PI_status">
                                            @if($proformaInvoice->status == 1)
                                            <span class="accepted_po" style="color: #54A958;">Accepted</span>
                                            @elseif($proformaInvoice->status == 0)
                                            <span class="pending_po" style="color: #ffc107;">Pending</span>
                                            @else
                                            <span class="rejected_po" style="color: red;">Rejected</span>
                                            @endif
                                        </td>
                                        <td data-title="created">
                                            {{$proformaInvoice->created_at}}
                                        </td>
                                        <td data-title="Action" class="text-left">
                                            <a href="{{ route('proforma_invoices.show', $proformaInvoice->id) }}" class="btn btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @if($proformaInvoice->status == -1)
                                            <a href="{{ route('proforma_invoices.edit',[ 'buyerId' => $proformaInvoice->buyer_id,'rfqId'=>$proformaInvoice->generated_po_from_rfq,'proformaId'=>$proformaInvoice->id ]) }}" class="btn btn-default">Update</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


@endsection
@push('js')
<script>
    $('.admin-proforma-table').DataTable({
        order: [[6, 'desc']],
    });
</script>
@endpush
