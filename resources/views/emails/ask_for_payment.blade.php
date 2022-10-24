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
    <p>Order Items</p>
    <table width="60%" cellpadding="0" cellspacing="0" border="1px" >
        <th>Product Name</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Price</th>
        @foreach ($orderList->orderItems as $list)
            <tr>
                <td>{{$list->product->name}}</td>
                <td>{{$list->unit_price}}</td>
                <td>{{$list->quantity}}</td>
                <td>{{$list->price}}</td>
            </tr>
        @endforeach
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">

        <tr>
            <td style="padding: 30px;">
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Total Amount: $ {{$orderList->grand_total}}</p>
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Payable Amount(10% with merchant assistance): $ {{$orderList->grand_total*0.1}}</p>
                <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a href="{{ route('payment.page', $orderList->order_number) }}">Pay Now</a></p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">Our team is here for your support. Please contact us if you have any queries.</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">Email: success@merchantbay.com</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">Address: Uttara sector-4,Dhaka</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">We are committed to ensure best user experience.</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Best regards,</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Merchant Bay Success Team</p>
            </td>
        </tr>
    </table>

