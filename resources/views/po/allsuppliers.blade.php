<table class="" style="border-bottom:1px solid #ccc; margin-bottom:15px;">
	<thead>
		<th></th>
		<th>Supplier Company</th>
		<th>Price</th>
		<th>Minimum Qty</th>
	</thead>
	<tbody>
        @foreach($products as $i => $product)
            <tr>
                <td>
                    <label><input type="radio" name="exampleRadios" value="{{$product->id}}"><span></span></label>
                    <input type="hidden" name="s_id" value="{{$product->businessProfile->user->id}}">
                    <input type="hidden" name="p_price" value="{{ $product->price_per_unit }}">
                    <input type="hidden" name="p_unit" value="{{ $product->moq ?? 0 }}">
                    <input type="hidden" name="s_name" value="{{$product->businessProfile->business_name }}">
                    <input type="hidden" name="s_price_unit" value="{{$product->price_unit}}">
                </td>
                <td>{{$product->businessProfile->business_name}}</td>
                <td>{{ $product->price_unit }} <span>{{ $product->price_per_unit }}</span></td>
                <td>{{ $product->moq ?? 0 }}</td>
            </tr>
        @endforeach
	</tbody>
</table>
