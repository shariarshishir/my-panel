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
                        <h1 style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0px 0px 30px 0px; margin: 0px; font-size:36px; line-height: 50px; color: #0A0A0A;">A new user registration is awaiting review</h1>
                        <p style="margin: 0px; padding: 0px 0 30px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">
                            A new user registered in Merchant Bay. 
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; padding: 0 0 50px; margin: 0;" >
                        <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">User type: {{ $user->user_type }}</p>
                        <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">From: {{ $user->countryName->name ?? "" }}</p>
                        <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Company name: {{ $user->company_name }}</p>
                        <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Email: {{ $user->email }} </p>
                        <p style="margin: 0; padding: 2px 0px; font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 24px; color: #0A0A0A;">Phone: {{ $user->phone }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding: 30px 0 80px; margin: 0px;">
                        <h2 style="font-family: 'Poppins', sans-serif; font-size: 22px; line-height: 35px; margin: 0; padding: 0px 50px 30px; font-weight: 600; color: #0A0A0A;">Review the user request and give a feedback as soon as possible</h2>
                        <a href="{{route('user.show',$user->id)}}" target="_blank" style="background: #54A958; width: 92%; padding: 10px 20px; border-radius: 8px; margin: 0 auto; display: block; font-family: 'Poppins', sans-serif; font-size: 16px; color: #fff; line-height: 28px; text-decoration: none;" >Go to Admin Panel</a>
                    </td>
                </tr>

            </table>

            <table style="background: #fff; max-width:670px; margin:0 auto;" width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background: #54a958; text-align: center; padding: 50px 20px 40px; margin: 0;">
                        <p style="font-family: 'Poppins', sans-serif; color: #fff; font-size: 12px; line-height: 20px; margin: 0px; padding: 0px;">MERCHANT BAY PTE LTD., 160 ROBINSON ROAD #24-09, SINGAPORE, SINGAPORE 068914 <span style="text-decoration: underline; display: block;">Unsubscribe Manage preferences</span></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>



