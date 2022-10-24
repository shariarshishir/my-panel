
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
                        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0px 0px 20px 0px; margin: 0px; font-size:32px; line-height: 40px; color: #0A0A0A;">Welcome! We're so glad you're here
                        </h1>
                        <p style="margin: 0px; padding: 8px 0 20px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                            Thank you for registering to Merchant Bay, a B2B tech-enabled platforms created as a critical channel for sales, marketing and order management of apparel.
                        </p>
                        @if((Request::wantsJson()))
                        <p style="margin: 0px; padding: 0px 0 20px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                            Your registration will be reviewed and verified within <strong> 48 hours</strong>. Meanwhile, verify your email using the following OTP
                        </p>
                        @else
                        <p style="margin: 0px; padding: 0px 0 20px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                            Your registration will be reviewed and verified within <strong> 48 hours</strong>. Meanwhile, verify your email by clicking this button
                        </p>
                        @endif
                        @if((Request::wantsJson()))
                        <span style="text-align: center; display: block;  padding: 20px 0 50px; margin: 0px; line-height: 25px;">
                            <p style="background: #54A958; font-family: 'Poppins', sans-serif; font-size: 16px; border-radius: 8px; padding: 10px 20px; display: inline-block; color: #fff; text-decoration: none;">{{$token}}</p>
                        </span>
                        @else
                        <span style="text-align: center; display: block;  padding: 20px 0 50px; margin: 0px; line-height: 25px;">
                            <a href="{{ route('user.verify',$token) }}" target="_blank" style="background: #54A958; font-family: 'Poppins', sans-serif; font-size: 16px; border-radius: 8px; padding: 10px 20px; display: inline-block; color: #fff; text-decoration: none;">Verify your account</a>
                        </span>
                        @endif
                    </td>
                </tr>
                @if(!(Request::wantsJson()))
                <tr>
                    <td style="text-align: left; padding: 0; margin: 0;">
                        <p style="margin: 0; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">If the button is not working, click the following link...</p>
                        <a style="text-decoration: underline; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;" href="https://www.merchantbay.com/" target="_blank">https://www.merchantbay.com/</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 50px 0 70px; margin: 0px;">
                        <p style="margin: 0; padding: 0px; font-weight: 600; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">If the link is not working, please contact us. </p>
                        <p style="margin: 0; padding: 0px; text-decoration: underline; color: #0A0A0A;">Email: <span style="font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">success@merchantbay.com</span>, Call: </p>
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 0; margin: 0;">
                        <ul style="margin: 0 0 0 30px; padding: 0;">
                            <li style="margin: 0px 0px 30px 0px; padding: 0px;">
                                <h5  style="margin: 0 0 5px; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600; color: #0A0A0A;">Digital profile</h5>
                                <p style="margin: 0; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Open your business profile in Merchant Bay and you will never need to maintaining websites, pdfs and documents to send your profile to the buyers. Merchant Bay supplier profile is built to serve your purpose. Build multiple business profiles, send and promote easily with one click of a button. </p>
                            </li>
                            <li style="margin: 0px 0px 30px 0px; padding: 0px;">
                                <h5 style="margin: 0 0 5px; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600; color: #0A0A0A;">Marketplace</h5>
                                <p style="margin: 0; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Merchant Bay Marketplace is the most reliable place for you to connect with local and global buyers. Showcase your products in your personal digital shop to increase the visibility of your products. Also increase your success rate by promoting your products to the buyers.</p>
                            </li>
                            <li style="margin: 0px 0px 30px 0px; padding: 0px;">
                                <h5 style="margin: 0 0 5px; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600; color: #0A0A0A;">And much more...</h5>
                                <p style="margin: 0; padding: 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Our tech enabled fashion sourcing ecosystem has much more to offer. Learn more <a href="https://www.merchantbay.com/aboutus" style="color: #0000FF; text-decoration: underline; font-size: 15px;" target="_blank"> about us</a>... </p>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 30px; margin: 0;">
                        <h2 style="font-family: 'Poppins', sans-serif; font-size: 22px; line-height: 40px; margin: 0; padding: 0px; font-weight: 600;">We are here to make your sourcing easy and efficient.</h2>
                        <span style="text-align: center; display: block;  padding: 30px 0 40px; margin: 0; line-height: 45px;">
                            <a target="_blank" href="https://www.merchantbay.com/" style="background: #54A958; font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 24px; border-radius: 8px; padding: 10px 20px; margin: 0; color: #fff; text-decoration: none;">Visit Merchant Bay</a>
                        </span>
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




