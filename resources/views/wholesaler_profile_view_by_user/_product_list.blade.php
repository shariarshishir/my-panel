@if($business_profile->wholesalerProducts()->exists())
<div class="product_design_wrapper row">
    @foreach($business_profile->wholesalerProducts as $key=>$product)
        <div class="col s6 m6 l4 product_item_box">
            <div class="productBox">
                <div class="favorite">
                    @if(in_array($product->id,$wishListShopProductsIds))
                        <a href="javascript:void(0);" onclick="addToWishList('{{$product->flag}}', '{{$product->id}}', $(this));"  class="product-add-wishlist active">
                            <i class="material-icons dp48">favorite</i>
                        </a>
                    @else
                        <a href="javascript:void(0);" onclick="addToWishList('{{$product->flag}}', '{{$product->id}}', $(this));" class="product-add-wishlist">
                            <i class="material-icons dp48">favorite</i>
                        </a>
                    @endif
                </div>
                @if($product->availability==0 && ($product->product_type==2 || $product->product_type==3))
                    <div class="sold-out">Sold Out</div>
                @endif
                <div class="inner_productBox">
                    <a href="{{route('productdetails',$product->sku)}}">
                        <div class="imgBox">
                            @foreach($product->images as $key=>$image)
                                <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="single-product-img" alt="" />
                                @break
                            @endforeach
                        </div>

                        <div class="products_inner_textbox">
                            {{-- <div class="priceBox row">
                                <div class="col s12 m12 l4 apperal">

                                </div>
                                <div class="col s12 m12 l8 right-align price">
                                    $ {{$product->price_per_unit}}/<span class="unit"> {{$product->qty_unit}}</span>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col s6">
                                    <h4><span> {{ $product->name }} </span></h4>
                                </div>
                                <div class="col s6">
                                    <div class="product_moq"><span class="moq">MOQ:</span> {{$product->moq}} <span class="moq-unit">{{ $product->qty_unit }}</span></div>
                                </div>
                            </div>

                            {{-- @if(isset($product->moq))
                                <div class="product_moq"><span class="moq">MOQ:</span> {{$product->moq}} <span class="moq-unit">{{ $product->qty_unit }}</span></div>
                            @endif  --}}

                            {{-- @if(isset($product->lead_time))
                                <div class="product_lead_time">Lead time:
                                    @php
                                        $pattern= '/[^0-9\-]/';
                                        $preg_replace= preg_replace($pattern, '', $product->lead_time);
                                    @endphp
                                    {{$preg_replace}} days
                                </div>
                            @endif --}}

                        </div>
                    </a>



                </div>
            </div>
        </div>
    @endforeach
</div>
{{-- <div class="pagination-block-wrapper">
    <div class="col s12 center">
        {!! $products->links() !!}
    </div>
</div> --}}
@else
<div class="card-alert card cyan lighten-5">
    <div class="card-content cyan-text">
        <p>INFO : There is no product for <b>{{ucwords($business_profile->business_name)}}</p>
    </div>
</div>
@endif

