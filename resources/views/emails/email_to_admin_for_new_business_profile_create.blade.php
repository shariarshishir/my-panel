
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
                        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0px 0px 20px 0px; margin: 0px; font-size:32px; line-height: 40px; color: #0A0A0A;">New business profile created</h1>
                        <p style="margin: 0px; padding: 8px 0 20px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                            User {{$business_profile->user->name}} created a business profile for {{$business_profile->business_name}}. Please assign success manager to verify the information.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; padding:20px 0 0; margin: 0;">
                        <div style="position: relative; display: flex; align-items: center; justify-content: center; height: 120px; padding: 0; margin: 0;">
                            <div style="position: absolute; top: 0px; left: 0px; right: 0px; bottom: 0px; height: 120px; width: 100%; padding: 0; margin: 0;">
                                <a style="margin: 0; padding: 0;" href="https://www.merchantbay.com/" title="logo" target="_blank">
                                    <img style="padding: 0; margin: 0; border-radius: 8px;" width="100%" height="100%" src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/cover_img.png" title="" alt="">
                                </a>
                            </div>
                            <div style="font-family: 'Poppins', sans-serif; color: #fff; font-size: 22px; line-height: 28px; font-weight: 600; padding: 0; margin: 0; z-index: 9;">
                                {{$business_profile->business_name}}
                            </div>
                        </div>
                        <span style="text-align: center; display: block;  padding: 30px 0 40px; margin: 0; line-height: 45px;">
                            <a target="_blank" href="{{route('business.profile.details',$business_profile->id)}}" style="background: #54A958; font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 24px; border-radius: 8px; padding: 10px 20px; margin: 0; color: #fff; text-decoration: none;">Go to profile</a>
                        </span>
                    </td>

                </tr>
                <tr>
                    <td style="text-align: center; padding: 30px; margin: 0;">
                        <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0px 0px 20px 0px; margin: 0px; font-size:22px; line-height: 35px; color: #0A0A0A;">We are here to make your sourcing easy and efficient.</h2>
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
