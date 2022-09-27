
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
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;">Dear {{ $user->name }},</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;"> Welcome aboard! Thank you for your registration. Please complete your registration by clicking
                    the email verification link below.</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;"> If the link is not working!
                    Contact us: email: success@merchantbay.com. Call: </p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;"> Merchant Bay is the most reliable way to find and manage a supplier in Bangladesh.

                </p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;"> Source products directly from our vast supplier base. Send your inquiry through RFQ (Request For Quotation) and let our smart matching system find the best matched suppliers to quote you, along with instant quotation you will have the advantage of connecting to Verified Suppliers, and Merchandising Assistance. We are here to make your sourcing easy and efficient..

                </p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;"> Thank you for using Merchant Bay PTE Ltd.

                </p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;"> Note: This is a no-reply email. So please do not reply to this email.

                </p>


                <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a  href="{{URL::to('/login') }}" class="button button-green">Login</a></p>
            </td>
        </tr>
    </table>

