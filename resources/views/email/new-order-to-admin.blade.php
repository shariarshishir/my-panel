<table cellspacing="0" border="0" cellpadding="0" width="100%" style="font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A; padding: 0; margin: 0;"
>
    <tr>
        <td>
            <table style="background: #fff; max-width:670px; margin:0 auto; padding: 20px; text-align: left;" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="text-align:center; padding:0; margin: 0;">
                        <a style="margin: 0; padding: 0;" href="https://www.merchantbay.com/" title="logo" target="_blank">
                            <img style="padding: 0; margin: 0;" width="250px" src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/logo.png" title="logo" alt="logo">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 50px 0 0; margin: 0;">
                        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0px 0px 20px 0px; margin: 0px; font-size:24px; line-height: 35px; color: #0A0A0A; text-align: left;">A new order is placed</h1>
                        <p style="margin: 0px; padding: 8px 0 20px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                            A new order is placed by {{ $order->user->name }}. Please review, verify and forward the order to supplier as soon as possible. Order details...
                        </p>
                    </td>
                </tr>

                @foreach ($order->orderItems as $item )
                <tr>
                    <td style="padding: 20px 0; margin: 0;">
                        <table style="max-width:670px; margin:0 auto; padding: 20px; text-align: left;" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="text-align: left; padding: 5px; margin: 0px; width: 30%;">
                                    <img width="130px" height="auto" src="{{asset('storage').'/'.$item->product->images[0]->image}}" alt="" />
                                </td>
                                <td style="text-align: left; padding: 0 0 0 20px; margin: 0px; width: 70%;">
                                    <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0px 0px 10px 0px; margin: 0px; font-size:24px; line-height: 35px; color: #0A0A0A; text-align: left;">
                                    {{ $item->product->name }}
                                    </h3>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Order volume: {{ $item->product->quantity }} {{ $item->product->product_unit }}</p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Order Value: {{ $item->product->price }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endforeach

                <tr>
                    <td style="padding: 20px 0; margin: 0;">
                        <table style="max-width:670px; margin:0 auto; padding: 20px; text-align: left;" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="text-align: left; padding: 5px; margin: 0px; width: 30%;">&nbsp;</td>
                                <td style="text-align: left; padding: 0 0 0 20px; margin: 0px; width: 70%;">
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;"><b>Order Number</b>: {{ $order->order_number }}</p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;"><b>Billing address</b>: {{ $order->billingAddress->address }}</p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;"><b>Shipping address</b>: {{ $order->billingAddress->address }}</p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;"><b>Grand Total:</b> <span style="color: #54A958;"> {{ $order->grand_total }}</span></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="text-align: center; padding: 0; margin: 0px; width: 100%;">
                        <a href="{{route('business.profile.order.show',['business_profile_id' => $order->business_profile_id, 'order_id' => $order->id ])}}" target="_blank" style="background: #54A958;width: 92%;padding: 10px 20px;border-radius: 8px;margin: 0 auto;display: block;font-family: 'Poppins', sans-serif;font-size: 16px;color: #fff;line-height: 20px;text-decoration: none; text-align: center;">Go to admin panel</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 50px 20px 30px; margin: 0px;">
                        <p style="margin: 0; padding: 2px 0; font-family: 'Poppins', sans-serif; font-size: 14px; line-height: 24px; color: #0A0A0A; text-align: center;">To ensure better user experience, finish the review process within 24 hours.</p>
                    </td>
                </tr>
            </table>

            <table style="background: #fff; max-width: 670px; margin:0 auto; padding: 0;" width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background: #54a958; text-align: center; padding: 50px 20px 40px; margin: 0;">
                        <p style="font-family: 'Poppins', sans-serif; color: #fff; font-size: 12px; line-height: 20px; margin: 0px; padding: 0px;">MERCHANT BAY PTE LTD., 160 ROBINSON ROAD #24-09, SINGAPORE, SINGAPORE 068914 <span style="text-decoration: underline; display: block;">Unsubscribe Manage preferences</span></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


