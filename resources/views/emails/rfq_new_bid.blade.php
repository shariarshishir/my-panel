
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
                @if($data['supplier']=="success@merchantbay.com")
                    <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Dear Merchant Bay,</p>
                @else
                <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Dear {{ $data['supplier']->user->name}},</p>
                @endif

                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;">There is a new business opportunity:</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:25px;line-height:normal;">{{$data['bidData']->businessProfile->business_name}} has sent a new quotation,</p>
                {{-- <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-bottom: 25px;">
                    <tr>
                        @foreach(json_decode($data['bidData']->media) as $image)
                        <td style="text-align:center;"><img style="" src="{{ asset('storage/'.$image) }}" class="img-responsive" width="200px" /></td>
                        @endforeach
                    </tr>
                </table> --}}
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Offer Price:</b> {{ $data['bidData']->unit_price }}</p>
                {{-- <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Title:</b> {{ $data['bidData']->title }}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Quantity:</b> {{ $data['bidData']->quantity }}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Unit:</b> {{ $data['bidData']->unit }}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Target price:</b> $ {{ $data['bidData']->unit_price }}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;"><b>Payment method:</b> {{ $data['bidData']->payment_method }}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:25px;line-height:normal;"><b>Delivery time:</b> {{ $data['bidData']->delivery_time }}</p> --}}
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:25px;line-height:normal;">please login to your MerchantBay account and find the request in your RFQ menu.</p>
                <p style="display:block;text-align:center;margin:0px;padding-bottom:25px;line-height:normal;"><a  href="{{URL::to('/my-rfq')}}" class="button button-green">Login</a></p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">In case of any questions, please contact us: <a href="https://www.merchantbay.com" style="color:#5181ec">www.merchantbay.com</a></p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Best regards,</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">your Merchant Bay team</p>
            </td>
        </tr>
    </table>
