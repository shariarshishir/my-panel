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
                <p style="font-family:verdana;font-size:13px;margin:0px;line-height:normal;">Dear {{ $vendorOrder->user->name }},</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">Seems like you have completed a successful trade with {{ $vendorOrder->vendor->user->name }}. Please review the experience.</p>
                <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a href="{{route('vendor.review_form',[$vendorOrder['order_number'],$vendorOrder->vendor['vendor_uid']])}}">Click here for review store</a></p>
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:20px;color:#000;line-height:normal;">Your rating helps supplier and products to gain more visibility, trading and business relationships</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Thank you for using Merchant Bay PTE Ltd.</p>
            </td>
        </tr>
    </table>

