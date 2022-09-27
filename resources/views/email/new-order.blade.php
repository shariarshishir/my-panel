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
            <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Dear {{ $order->vendor->user->name}},</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Buyer Name:</b> {{ $order->user->name }}</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Vendor Name:</b> {{ $order->vendor->vendor_name }}</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Order number:</b> {{ $order->order_number }}</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Grand total:</b> {{ $order->grand_total }}</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Payment Name</b> {{ $order->payment_name }}</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:25px;line-height:normal;">To reply, please login to your MerchantBay account and find the request in your RFQ menu.</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:25px;line-height:normal;">You are receiving this email because your profile information matches with the buyer's request for quotation. If you think this request does not fit to your business, please update your company profile.</p>
            <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a  href="{{URL::to('/rfq-invited-supplier-login',$rfq=1) }}" class="button button-green">Login</a></p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">In case of any questions, please contact us: <a href="https://www.merchantbay.com" style="color:#5181ec">www.merchantbay.com</a></p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Best regards,</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">your Merchant Bay team</p>
        </td>
    </tr>
</table>
