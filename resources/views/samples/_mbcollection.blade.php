<div class="row samples_from_mb_collection">
    @foreach ($design_products as $product)
        <div class="col s6 m4 l3 product_item_box">
            <div class="productBox">
                <div class="inner_productBox @php echo($product->overlay_original_image) ? 'has-overlay':'' @endphp">
                    <a href="{{route('productdetails', $product->sku)}}">
                        <div class="imgBox">
                            @foreach($product->images as $key => $image)
                                <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="single-product-img" alt="" />
                            @break
                            @endforeach
                        </div>
                        <div class="products_inner_textbox">
                            <h4>
                                <span>{{ $product->name }}</span>
                            </h4>
                            <div class="row">
                                <div class="col s6">
                                    @if(isset($product->moq))
                                        <div class="product_moq"><span class="moq">MOQ:</span> {{$product->moq}} <span class="moq-unit">{{$product->product_unit}}</span></div>
                                    @endif
                                </div>
                                <div class="col s6">
                                    <div class="pro_price">
                                        <span class="price">Lead Time</span> {{getLeadTime($product)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="pagination-block-wrapper">
    <div class="col s12 center">
        {!! $design_products->appends(request()->query())->links() !!}
    </div>
</div>
