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
                    <p style="font-family:verdana;font-size:13px;margin:0px;line-height:normal;">Dear {{ $product->businessProfile->user->name}},</p>
                    @if($alert_data == null)
                    <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:20px;line-height:normal;">Seems like your product {{ $product->name }} has been performing really well. However your product stock out , Please restock the product so that buyers can place orders.</p>
                    @else
                    <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:20px;line-height:normal;">Seems like your product {{ $product->name }} has been performing really well. However your current stock is less than the MOQ. Please restock the product so that buyers can place orders.</p>
                    @endif
                    <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:20px;line-height:normal;"><a href="{{URL::to('/seller-product') }}">To restock Click Here</a></p>
                    <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:20px;line-height:normal;">We are glad that your products are performing well. Add more quality products to keep business coming.</p>
                    <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Need help in updating information?</p>
                    <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:20px;line-height:normal;">email: <a href="mailto:success@merchantbay.com">success@merchantbay.com</a>. Call: </p>
                    <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Thank you for using Merchant Bay PTE Ltd.</p>
                </td>
            </tr>
        </table>

