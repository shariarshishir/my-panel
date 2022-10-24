@yield('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Purchase Order</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
/*Common Css*/
@font-face {
  font-family: 'Roboto';
  src: url('http://fonts.googleapis.com/css?family=Roboto') format('truetype');
}
*{
	padding: 0;
	margin: 0;
	border: 0;
	outline: none;
	text-decoration: none;
	list-style: none;
}
body {
	font-size:14px;
	line-height: 22px;
	overflow-x: hidden;
	font-family:Arial, Helvetica, sans-serif;
}
h1, h2, h3, h4, h5, h6 {
	margin: 0;
}
p {
	margin: 0;
}
ul, label {
	margin: 0;
	padding: 0;
}
.tablecontainer{
	width:600px;
	margin:0 auto;
}

#tbl1 {background-color:#999;}

</style>
<body>

<div class="tablecontainer">
	<table style="width:100%;">
		<tr>
			<td style="background-color:#F3FFF4;">
				<table style="width:100%;">
					<tr>
						<td style="width:5%">&nbsp;</td>
						<td colspan="3" style="width:60%; font-size:24px; font-weight:bold; color:#53AB57; padding:30px 0 5px 0; text-transform:uppercase; vertical-align: top;">Purchase Order</td>
						<!--td style="width:35%; padding: 30px;">
							@if($po->status == 0)
							<a href="javascript:void(0);" onClick="submitacceptform()" class="btn btn-success">Accept</a> &nbsp;
							<a href="javascript:void(0);" class="btn btn-danger">Reject</a>
							@endif
						</td-->
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td style="color:#53AB57; font-size:11px; font-weight:bold;">DATE</td>
						<td>&nbsp;</td>
						<td style="color:#000; font-size:11px;">{{$po->proforma_date}}</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td style="color:#53AB57; font-size:11px; font-weight:bold;">PO #</td>
						<td>&nbsp;</td>
						<td style="color:#000; font-size:11px;">{{$po->proforma_id}}</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
						<td style="height:3px;"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td style="font-size:14px; font-weight:bold;">Payment Due</td>
						<td>&nbsp;</td>
						<td style="font-size:14px; font-weight:bold;">{{$po->payment_within}}</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="height:10px;"></td>
						<td style="height:10px;"></td>
						<td style="height:10px;"></td>
						<td style="height:10px;"></td>
						<td style="height:10px;"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width:100%;">
					<tr>
						<td colspan="4" style="height:15px;"></td>
					</tr>
					<tr>
						<td style="width:5%">&nbsp;</td>
						<td style="width:45%">
							<table style="width:100%; font-size:11px;">
								<tr>
									<td style="color:#53AB57; font-size:14px; padding:0.1%; font-weight:bold;">Vendor</td>
								</tr>
								<tr>
									<td style="font-weight: 500; font-size: 22px">{{$supplierInfo->name}}</td>
								</tr>
								<tr>
									<td>
										<p>Phone: {{ $supplierInfo->phone}}</p> 
										<p>Email: {{ $supplierInfo->email }}</p>								
									</td>
								</tr>
							</table>
						</td>
						<td style="width:45%">
							<table style="width:100%; font-size:11px;">
								<tr>
									<td style="color:#53AB57; font-size:14px; padding:0.1%; font-weight:bold;">Buyer</td>
								</tr>
								<tr>
									<td style="color:#000; padding:0.1%; font-size:18px;">{{$po->buyer->name}}</td>
								</tr>
								<tr>
									<td style="color:#000; padding:0.1%;">
										@if(@$po->buyer->company_name)
										<p>Company Name: {{ @$po->buyer->company_name }}</p> 
										@endif
										@if(@$po->buyer->country)
										<p>Country: {{ @$po->buyer->country }}</p>
										@endif
									</td>
								</tr>
								<tr>
									<td style="color:#000; padding:0.1%;">
										<p>Phone: {{ @$po->buyer->phone}}</p> 
										<p>Email: {{ @$po->buyer->email }}</p>
									</td>
								</tr>
							</table>
						</td>
						<td style="width:5%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4" style="height:15px;"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width:100%;">
					<tr>
						<td style="width:2%; background-color:#53AB57; color:#fff; padding:1%; font-weight:bold;">Sl.</td>
						<td style="width:22%; background-color:#53AB57; color:#fff; padding:1%; font-weight:bold;">Product Category</td>
						<td style="width:22%; background-color:#53AB57; color:#fff; padding:1%; font-weight:bold;">Unit Price</td>
						<td style="width:22%; background-color:#53AB57; color:#fff; padding:1%; font-weight:bold; text-align;center;">QTY</td>
						<td style="width:22%; background-color:#53AB57; color:#fff; padding:1%; font-weight:bold;">Total Price</td>
					</tr>
					@php $total_price = 0; @endphp
                    @php $total_tax_price = 0; @endphp
                    @php $price_unit = 'USD'; @endphp;
                    @if(Auth::user()->id == $po->buyer->id)
	                    @foreach($po->performa_items as $ik => $item)
							<tr>
								<td style="border-bottom:1px solid #ddd; padding:1%;">{{$ik + 1}}</td>
								<td style="border-bottom:1px solid #ddd; padding:1%;">{{ $item->product->title }}</td>
								<td style="border-bottom:1px solid #ddd; padding:1%; text-align:center;">
									USD {{ number_format($item->unit_price, 2) }}
									<span style="display:block;font-size:10px;color:#999;">Vat included.</span>
								</td>
								<td style="border-bottom:1px solid #ddd; padding:1%; text-align;center;">{{ $item->unit }}</td>
								<td style="border-bottom:1px solid #ddd; padding:1%;">{{$item->price_unit}} {{ number_format($item->total_price, 2) }}</td>
							</tr>
							@php $price_unit = $item->price_unit; @endphp;
							@php $total_price += $item->total_price; @endphp
	                        @php $total_tax_price += $item->tax_total_price; @endphp
	                    @endforeach
	                @else
	                	@foreach($po->performa_items as $ik => $item)
	                	@if(in_array($item->supplier->id, $users))
							<tr>
								<td style="border-bottom:1px solid #ddd; padding:1%;">{{$ik + 1}}</td>
								<td style="border-bottom:1px solid #ddd; padding:1%;">{{ $item->product->title }}</td>
								<td style="border-bottom:1px solid #ddd; padding:1%; text-align:center;">
									{{$price_unit}} {{ number_format($item->unit_price, 2) }}
									<span style="display:block;font-size:10px;color:#999;">Vat & Tax included.</span>
								</td>
								<td style="border-bottom:1px solid #ddd; padding:1%; text-align;center;">{{ $item->unit }}</td>
								<td style="border-bottom:1px solid #ddd; padding:1%;">{{$price_unit}} {{ number_format($item->total_price, 2) }}</td>
							</tr>
							@php $total_price += $item->total_price; @endphp
	                        @php $total_tax_price += $item->tax_total_price; @endphp
	                    @endif
	                    @endforeach
	                @endif
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="background-color:#53AB57; color:#fff; padding:1%; font-weight:bold;">&nbsp;</td>
						<td style="background-color:#53AB57; color:#fff; padding:1%; font-weight:bold;">SUBTOTAL</td>
						<td style="background-color:#53AB57; color:#fff; padding:1%; font-weight:bold;">{{$price_unit}} {{ number_format($total_price, 2) }}</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="background-color:#40874C; color:#fff; padding:1%; font-weight:bold;">Total Invoice Amount</td>
						<td style="background-color:#40874C; color:#fff; padding:1%; font-weight:bold;">{{$price_unit}} {{ number_format($total_tax_price, 2) }}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="height:15px;"></td>
		</tr>
		<tr>
			<td style="height:25px;"></td>
		</tr>
		<tr>
			<td style="padding:1% 0 1% 5%;"><h3 style="font-size:15px; font-weight:bold; border-bottom:3px solid #000; padding-bottom:5px;">Terms & Conditions</h3></td>
		</tr>
		<tr>
			<td style="height:5px;"></td>
		</tr>
		@php $ti = 1; @endphp
		@foreach(json_decode($po->condition) as $t)
		@if($t != '')
			<tr>
				<td style="padding:1% 0 0.5% 5%;">{{ $ti }}. {{$t}}</td>
			</tr>
			@php $ti += 1; @endphp
		@endif
		@endforeach
		<tr>
			<td style="height:15px;"></td>
		</tr>
		<tr>
			<td style="background-color:#53AB57;">
				<table style="width:100%;">
					<tr>
						<td style="height:15px;"></td>
					</tr>
					<tr>
						<td style="color:#fff; font-size:18px; font-weight:bold; text-align:center; padding:0.5%;">If you have any questions, please contact</td>
					</tr>
					<tr>
						<td style="color:#fff; font-size:13px; font-weight:bold; text-align:center; padding:0.5%;">Merchant Bay, +880-2-09611677345, info@merchantbay.com.com</td>
					</tr>
					<tr>
						<td style="height:15px;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

</body>
</html>
