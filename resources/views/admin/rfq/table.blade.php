@php
$proformaArr = array();
if(!empty($proformas)) {
    foreach($proformas as $proforma){
        array_push($proformaArr, $proforma['generated_po_from_rfq']);
    }
}
@endphp

    <table class="table table-bordered orders-table data-table">
        <thead class="cf">
            <tr>
                <th width="2%">Sl</th>
                <th width="5%">Date</th>
                <th width="25%">RFQ Title</th>
                <th width="15%">Buyer Email</th>
                <th width="5%">Category</th>
                <th width="5%">Quantity</th>
                <th width="5%">Target price</th>
                <th width="5%">Delivery Date</th>
                <th width="5%" style="text-align: center;">PI / PO Status</th>
            </tr>
        </thead>
        <tbody class="cf">
            @foreach($rfqs as $key=>$rfq)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ \Carbon\Carbon::parse($rfq['created_at'])->isoFormat('MMMM Do YYYY')}}</td>
                <td><a href="{{route('admin.rfq.show', $rfq['id'])}}">{{$rfq['title']}}@if($rfq['unseen_count']>0) <span class="badge badge-warning">{{ $rfq['unseen_count']}}</span>@endif</a></td>
                <td>{{ $rfq['user']['email'] }}</td>
                <td>{{$rfq['category'][0]['name']}}</td>
                <td>{{$rfq['quantity']}}</td>
                @if($rfq['unit_price']==0)
                <td>Negotiable</td>
                @else
                <td>$ {{$rfq['unit_price']}}</td>
                @endif
                <td>{{ \Carbon\Carbon::parse($rfq['delivery_time'])->isoFormat('MMMM Do YYYY')}}</td>
                <td>@php echo (in_array($rfq['id'], $proformaArr)) ? " Yes" : " No"; @endphp</td>
            </tr>
            @endforeach
        </tbody>
    </table>
