<head>
    <style>
    .btn{text-align:center;}
    .loginButton {padding: 7px 15px 8px 20px;}
    * {box-sizing: border-box;}
    </style>
    </head>
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
                <p style="font-family:verdana;font-size:13px;margin:0px;color:#000;line-height:normal;">{{ $order->user->name }} has placed an order in the Merchant Bay shop.</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;"> Order details:</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Order No: {{ $order->order_number }}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Grand Total: {{ $order->grand_total }}</p>
                <table border="1px solid black" style="border-collapse: collapse;">
                    <th style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Product Name</th>
                    <th style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Quantity</th>
                    <th style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Unit Price</th>
                    <th style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Total</th>
                    @foreach ($order->orderItems as $item )
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit_price }}</td>
                        <td>{{ $item->price }}</td>
                    </tr>
                    @endforeach

                </table>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;"><a href="{{ route('business.profile.order.show',['business_profile_id' => $order->business_profile_id, 'order_id' => $order->id ]) }}">click here to review the order.</a></p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Thank you</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Merchant Bay PTE Ltd.</p>


                {{-- <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Payment Name</b> {{ $order->payment_name }}</p>
                <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a  href="{{URL::to('/admin') }}" class="button button-green">Login</a></p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Best regards,</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">your Merchant Bay team</p> --}}
            </td>
        </tr>
    </table>
