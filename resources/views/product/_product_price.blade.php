@php
    $count= count(json_decode($product->attribute));
    $count = $count-2;
@endphp
@foreach (json_decode($product->attribute) as $k => $v)
    @if($k == 0 && $v[2] == 'Negotiable')
    <span class="price_negotiable"> $ {{ 'Negotiable' }}</span>
    @endif
    @if($loop->last && $v[2] != 'Negotiable')
        ${{ $v[2] }} / <span class="unit">{{$product->product_unit}}</span> {{-- $ is the value for price unite --}}
    @endif
    @if($loop->last && $v[2] == 'Negotiable')
        @foreach (json_decode($product->attribute) as $k => $v)
                @if($k == $count)
                    ${{ $v[2]  }} {{ 'Negotiable' }} {{-- $ is the value for price unite --}}
                @endif
        @endforeach
    @endif
@endforeach