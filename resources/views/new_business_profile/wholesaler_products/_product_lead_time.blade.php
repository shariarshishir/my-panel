@if($product->product_type == 1)
    @foreach (json_decode($product->attribute) as $k => $v)
        @if($loop->last)
            {{ $v[3] }}
        @endif
    @endforeach
@else

@endif
