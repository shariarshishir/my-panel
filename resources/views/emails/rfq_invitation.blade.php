
<table cellspacing="0" border="0" cellpadding="0" width="100%" style="font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A; padding: 0; margin: 0;">
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
                        @if($data['supplier']=="success@merchantbay.com")
                            <p style="margin: 0px; padding: 0px 0 10px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A; font-weight: 600;">Dear Merchant Bay,</p>
                        @else
                        <p style="margin: 0px; padding: 0px 0 10px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A; font-weight: 600;">Dear {{ $data['supplier']}},</p>
                        @endif
                        <p style="margin: 0px; padding: 8px 0 20px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                        Here is a request for quotation you might feel interested about. RFQ details are given below.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 30px 0 0 20px; margin: 0px; ">
                        @foreach($data['rfq']->images as $image)
                            <img style="margin: 0 0 30px; padding: 0;" width="250px" height="auto" src="{{ asset('storage/images/mb_mail_logo.png') }}" alt="" />
                        @endforeach
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Industry:</b> {{ $data['rfq']->category->industry }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Product Category:</b> {{ $data['rfq']->category->name }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Title:</b> {{ $data['rfq']->title }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Quantity:</b> {{ $data['rfq']->quantity }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Unit:</b> {{ $data['rfq']->unit }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Target price:</b> $ {{ $data['rfq']->unit_price }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Payment method:</b> {{ $data['rfq']->payment_method }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:25px;line-height:normal;"><b>Delivery time:</b> {{ $data['rfq']->delivery_time }}</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:25px;line-height:normal;">To reply, please login to your MerchantBay account and find the request in your RFQ menu.</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:25px;line-height:normal;">You are receiving this email because your profile information matches with the buyer's request for quotation. If you think this request does not fit to your business, please update your company profile.</p>
                        <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a  href="{{$data['url']}}" class="button button-green">Login</a></p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">In case of any questions, please contact us: <a href="https://www.merchantbay.com" style="color:#5181ec">www.merchantbay.com</a></p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Best regards,</p>
                        <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">your Merchant Bay team</p>
                    </td>
                </tr>

            </table>

            <table style="background: #fff; max-width: 670px; margin:0 auto; padding: 0;" width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background: #eeeeee; text-align: center; padding: 20px 0; margin: 0;">
                        <h2 style="font-family: 'Poppins', sans-serif; font-size: 22px; line-height: 40px; margin: 0; padding: 0px; color: #0A0A0A; text-align: center;">Bring the sourcing in your pocket</h2>
                        <h6 style="font-family: 'Poppins', sans-serif; font-size: 15px; color: #0A0A0A; font-weight: 300; margin: 10px 0 20px; padding: 0px;">Download the App</h6>
                        <span>
                            <a href="https://apps.apple.com/us/app/merchant-bay/id1590720968" target="_blank" style="margin: 0; padding: 0;" ><img width="150" src="{{ asset('storage/images/app_store.png') }}" title="App store" alt="App store"></a>
                            <a href="https://play.google.com/store/apps/details?id=com.sayemgroup.merchantbay" target="_blank" style="margin: 0; padding: 0;"><img width="150" src="{{ asset('storage/images/google_play.png') }}" title="Google play" alt="Google play"></a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="background: #54a958; text-align: center; padding: 50px 20px 40px; margin: 0;">
                        <p style="font-family: 'Poppins', sans-serif; color: #fff; font-size: 12px; line-height: 20px; margin: 0px; padding: 0px;">MERCHANT BAY PTE LTD., 160 ROBINSON ROAD #24-09, SINGAPORE, SINGAPORE 068914 <span style="text-decoration: underline; display: block;">Unsubscribe Manage preferences</span></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>






