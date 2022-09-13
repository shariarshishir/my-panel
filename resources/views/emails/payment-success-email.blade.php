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
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 30px;">
                @if ($user_type == 'user')
                <p style="font-family:verdana;font-size:13px;margin:0px;line-height:normal;">Dear {{ $order->user->name}},</p>
                <p style="font-family:verdana;font-size:13px;margin:0px;color:#000;line-height:normal;">A new order payment has success..</p>

                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal; padding-bottom:15px;">Order No: {{$order->order_number }}</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">Order Items:</p>
                <table width="60%" cellpadding="0" cellspacing="0" border="1px">
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    @foreach ($order->orderItems as $list)
                        <tr>
                            <td>{{$list->product->name}}</td>
                            <td>{{$list->unit_price}}</td>
                            <td>{{$list->quantity}}</td>
                            <td>{{$list->price}}</td>
                        </tr>
                    @endforeach
                </table>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">Paid Amount: $ {{$order->pay_amount}}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;"><a href="{{ route('order.index') }}">To see the details please click here.</a></p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Not sure what you see?</p>
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Contact us: email: <a href="mailto:success@merchantbay.com">success@merchantbay.com</a>. Call: </p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Thank you for using Merchant Bay PTE Ltd.</p>
                @endif
                @if ($user_type == 'admin')
                <p style="font-family:verdana;font-size:13px;margin:0px;color:#000;line-height:normal;">A new order payment has received.</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">User name: {{ $order->user->name }}</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal; padding-bottom:15px;">Order No: {{$order->order_number }}</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">Order Items:</p>
                <table width="60%" cellpadding="0" cellspacing="0" border="1px">
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    @foreach ($order->orderItems as $list)
                        <tr>
                            <td>{{$list->product->name}}</td>
                            <td>{{$list->unit_price}}</td>
                            <td>{{$list->quantity}}</td>
                            <td>{{$list->price}}</td>
                        </tr>
                    @endforeach
                </table>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;padding-bottom:15px;">Paid Amount: $ {{$order->pay_amount}}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;"><a href="{{ route('business.profile.order.show',['business_profile_id' => $order->business_profile_id, 'order_id' => $order->id]) }}">Click here to see the full details</a></p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;line-height:normal;">......</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Contact User: <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>. Call:{{ $order->user->phone }}. </p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Thank you</p>
                @endif

            </td>
        </tr>
    </table>
