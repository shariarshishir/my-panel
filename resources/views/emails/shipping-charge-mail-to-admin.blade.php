
    @component('mail::message')
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="background:#f7f7f7;width:10%;padding:20px;text-align:center;"><img src="{{ asset('storage/images/mb_mail_logo.png') }}" alt="Mail Template Logo" width="100px" /></td>
                <td style="background:#23b14d;width:90%;padding:20px;text-align:center;">
                    <p style="font-family:verdana;font-size:30px;font-weight:bold;color:#fff;margin:0px;padding-bottom:5px;line-height:normal;text-align:left;">Merchant Bay Limited.</p>
                    <p style="font-family:verdana;font-size:13px;font-weight:normal;color:#fff;margin:0px;padding-bottom:5px;line-height:normal;text-transform:uppercase;text-align:left;">Sourcing Made Easy</p>
                </td>
            </tr>
    </table>
    <p>Shipping Charge</p>
    <p>Forwarder Name: {{$order->shippingCharge->forwarder_name}}</p>
    <p>Forwarder Address: {{$order->shippingCharge->forwarder_address}}</p>
    <table width="60%" cellpadding="0" cellspacing="0" border="1px" >
        <th>Shipping Method</th>
        <th>Shipmenet Type</th>
        <th>UOM</th>
        <th>Unit Price</th>
        <th>Qty</th>
        <th>Total</th>
        @foreach (json_decode($order->shippingCharge->details) as $list)
            <tr>
                <td>{{$list->shipping_method}}</td>
                <td>{{$list->shipment_type}}</td>
                <td>{{$list->uom}}</td>
                <td>{{$list->unit_price}}</td>
                <td>{{$list->qty}}</td>
                <td>{{$list->total}}</td>
            </tr>
        @endforeach
    </table>

    <p>Total : {{$order->shippingCharge->grand_total}}</p>


