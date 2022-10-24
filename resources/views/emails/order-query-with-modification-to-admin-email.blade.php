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
                <p style="font-family:verdana;font-size:13px;margin:0px;color:#000;line-height:normal;">A new order query to Merchant Bay Shop.</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">User name: {{ $data->user->name }}</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">Product name: {{ $data->product->name }}</p>
                <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;"><a href="{{ route('query.show', $data->id) }}">Click here to see the full details</a></p>

                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;line-height:normal;">......</p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Contact: <a href="mailto:{{ $data->user->email }}">{{ $data->user->email }}</a>. Call:{{ $data->user->phone }}. </p>
                <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Thank you</p>
            </td>
        </tr>
    </table>
