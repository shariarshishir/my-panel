<head>
    <style>
    .btn{text-align:center;}
    .loginButton {padding: 7px 15px 8px 20px;}
    * {box-sizing: border-box;}
    </style>
    </head>
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

      <p>this {{ $product->name }} product availability less than moq, please check</p>
      <table>
          <tr>
              @foreach ($alert_data as $key => $data  )
                  @foreach ($data as $key2 => $data2 )
                      {{ $key2 }} {{ $data2 }}
                  @endforeach
              @endforeach
          </tr>
      </table>
      <a  href="{{URL::to('/seller-product') }}" class="button button-green">Check</a>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 30px;">
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;">In case of any questions, please contact us: <a href="https://www.merchantbay.com" style="color:#5181ec">www.merchantbay.com</a></p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">Best regards,</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:5px;line-height:normal;">your Merchant Bay team</p>
            </td>
        </tr>
    </table>
