
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
            <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Welcome to Merchant Bay Shop. We are glad to have you on board. Please verify your email address to log in.Use the following OTP.</p>
            <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><button class="button button-green">{{$token}}</button></p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">Our team is here for your support. Please contact us if you have any queries.</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">Email: success@merchantbay.com</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">Address: Uttara sector-4,Dhaka</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">We are committed to ensure best user experience.</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Best regards,</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Merchant Bay Success Team</p>
        </td>
    </tr>
</table>

