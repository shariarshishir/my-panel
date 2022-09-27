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
                        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0px 0px 20px 0px; margin: 0px; font-size:24px; line-height: 35px; color: #0A0A0A; text-align: center;">Thank you for using Merchant Bay</h1>
                        <p style="margin: 0px; padding: 8px 0 20px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                            An Proforma Invoice have been accepted for below RFQ.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 20px 0; margin: 0;">
                        <table style="max-width:670px; margin:0 auto; padding: 20px; text-align: left;" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="text-align: left; padding: 5px; margin: 0px; width: 30%;">&nbsp;</td>
                                <td style="text-align: left; padding: 0 0 0 20px; margin: 0px; width: 70%;">
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;"><b>RFQ Title:</b> {{ $rfqInfo['title'] }}</p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;"><b> Query:</b> For  @foreach($rfqInfo['category'] as $category) {{$category['name']}} @if(!$loop->last) , @endif  @endforeach</p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;"><b>Details:</b></p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Qty: {{$rfqInfo['quantity']}} {{$rfqInfo['unit']}}, Target Price: @if($rfqInfo['unit_price']==0) Negotiable @else $ {{$rfqInfo['unit_price']}} @endif, Deliver To: {{$rfqInfo['destination']}}, Within: {{\Carbon\Carbon::parse($rfqInfo['delivery_time'], 'UTC')->isoFormat('MMMM Do YYYY')}}, Payment Method: {{$rfqInfo['payment_method']}}</p>
                                    <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                                        <span style="text-align: center; display: block;  padding: 30px 0 40px; margin: 0; line-height: 45px;">
                                            <a target="_blank" href="{{route('proforma_invoices.show', $proformaInvoice['id'])}}" style="background: #54A958; font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 24px; border-radius: 8px; padding: 10px 20px; margin: 0; color: #fff; text-decoration: none;">Go to Admin Panel</a>
                                        </span>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td style="text-align: center; padding: 0px 0 30px; margin: 0;">
                        <p style="margin: 0; padding: 0px 0 10px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A; text-align: center;"> If you have any query please contact us</p>
                        <p style="margin: 0; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A; text-align: center;">Email: success@merchantbay.com</p>
                    </td>
                </tr>
            </table>

            <table style="background: #fff; max-width: 670px; margin:0 auto; padding: 0;" width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background: #eeeeee; text-align: center; padding: 20px 0; margin: 0;">
                        <h2 style="font-family: 'Poppins', sans-serif; font-size: 22px; line-height: 40px; margin: 0; padding: 0px; color: #0A0A0A; font-weight: 600; text-align: center;">Bring the sourcing in your pocket</h2>
                        <h6 style="font-family: 'Poppins', sans-serif; font-size: 15px; color: #0A0A0A; font-weight: 300; margin: 10px 0 20px; padding: 0px; text-align: center;">Download the App</h6>
                        <span>
                            <a href="https://apps.apple.com/us/app/merchant-bay/id1590720968" target="_blank" style="margin: 0; padding: 0;" ><img width="150" src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/new-home/app-store.png" title="App store" alt="App store"></a>
                            <a href="https://play.google.com/store/apps/details?id=com.sayemgroup.merchantbay" target="_blank" style="margin: 0; padding: 0;"><img width="150" src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/new-home/google-play.png" title="Google play" alt="Google play"></a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="background: #54a958; text-align: center; padding: 50px 20px 40px; margin: 0;">
                        <p style="font-family: 'Poppins', sans-serif; color: #fff; font-size: 12px; line-height: 20px; margin: 0px; padding: 0px; text-align: center;">MERCHANT BAY PTE LTD., 160 ROBINSON ROAD #24-09, SINGAPORE, SINGAPORE 068914 <span style="text-decoration: underline; display: block;">Unsubscribe Manage preferences</span></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>



