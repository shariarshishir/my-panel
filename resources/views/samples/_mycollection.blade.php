<div class="row">
    @foreach ($samples as $item)
    @php
        $productImg = json_decode($item['product_images']);
    @endphp
    <div class="col s12 m6 l3">
        <div class="buyer_simple_imgbox">
            <div class="imgBox">
                <img src="{{Storage::disk('s3')->url('public/sample_images/'.auth()->user()->id.'/'.$productImg[0])}}" alt="" />
            </div>
        </div>
    </div>
    @endforeach
</div>
