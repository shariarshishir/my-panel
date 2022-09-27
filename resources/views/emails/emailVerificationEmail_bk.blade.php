
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

                @if((Request::wantsJson()))
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Welcome aboard! Thank you for your registration. Please complete your registration by use the following OTP.</p>

                @else
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Welcome aboard! Thank you for your registration. Please complete your registration by clicking the email verification link below.</p>
                @endif
                @if((Request::wantsJson()))
                <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><button class="button button-green">{{$token}}</button></p>
                @else
                    <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a href="{{ route('user.verify',$token) }}">Verify Email</a></p>
                @endif
                <p style="font-family:verdana;font-size:13px;margin:0px;line-height:normal;">If the link is not working!</p>
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Contact us: email: <a href="mailto:success@merchantbay.com">success@merchantbay.com</a>. Call: </p>
                @if($user->user_type == 'wholesaler')
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Merchant Bay Shop is the most reliable place for you to connect with local and global buyers. Showcase your products in your personal digital shop to increase the visibility of your shop and products. Also increase your success rate by promoting your products to the buyers. </p>
                @else
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Merchant Bay is the most reliable way to find and manage a supplier in Bangladesh.</p>
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Source products directly from our vast supplier base. Send your inquiry through RFQ (Request For Quotation) and let our smart matching system find the best matched suppliers to quote you, along with instant quotation you will have the advantage of connecting to Verified Suppliers, and Merchandising Assistance. We are here to make your sourcing easy and efficient..</p>
                @endif
                <p style="font-family:verdana;font-size:13px;margin:0px;line-height:normal;">Thank you for using Merchant Bay PTE Ltd.</p>
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal; font-weight: bold;">Note: This is a no-reply email. So please do not reply to this email.</p>
            </td>
        </tr>
    </table>

