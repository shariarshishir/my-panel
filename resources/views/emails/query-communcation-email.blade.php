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
            @if ($type == 'admin')
            <p style="font-family:verdana;font-size:13px;margin:0px;line-height:normal;">Dear {{ $data->orderModificationRequest->user->name}},</p>
            <p style="font-family:verdana;font-size:13px;margin:0px;color:#000;line-height:normal;">A new order query message has received.</p>

            <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">Product name: {{$data->orderModificationRequest->product->name }}</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;"><a href="{{$data->orderModificationRequest->type == 2 ? route('ord.mod.req.index') : route('user.order.query.index') }}">To see the details please click here.</a></p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;line-height:normal;">Not sure what you see?</p>
            <p style="font-family:verdana;font-size:13px;margin:0px;padding-bottom:15px;line-height:normal;">Contact us: email: <a href="mailto:success@merchantbay.com">success@merchantbay.com</a>. Call: </p>
            <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Thank you for using Merchant Bay PTE Ltd.</p>
            @endif
            @if ($type == 'user')
            <p style="font-family:verdana;font-size:13px;margin:0px;color:#000;line-height:normal;">A new order query message has received.</p>
            <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">User name: {{ $data->orderModificationRequest->user->name }}</p>
            <p style="font-family:verdana;font-size:12px;margin:0px;color:#000;line-height:normal;">Product name: {{$data->orderModificationRequest->product->name }}</p>
            <p style="font-family:verdana;font-size:12px;color:#000;margin:0px;padding-bottom:15px;line-height:normal;"><a href="{{ route('query.show', $data->orderModificationRequest->id) }}">Click here to see the full details</a></p>

            <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;line-height:normal;">......</p>
            <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Contact: <a href="mailto:{{ $data->orderModificationRequest->user->email }}">{{ $data->orderModificationRequest->user->email }}</a>. Call:{{ $data->orderModificationRequest->user->phone }}. </p>
            <p style="font-family:verdana;font-size:12px;margin:0px;padding-bottom:15px;color:#000;line-height:normal;">Thank you</p>
            @endif

        </td>
    </tr>
</table>
