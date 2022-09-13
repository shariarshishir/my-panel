<div class="product_design_wrapper">
    @if($business_profile->manufactureProducts()->exists())
    <div class="product_boxwrap">
        @foreach($business_profile->manufactureProducts as $key=>$product)
            <div class="col s6 m4 l3 product_item_box">
                <div class="productBox">
                    <div class="favorite">
                        @if(in_array($product->id,$wishListMfProductsIds))
                            <a href="javascript:void(0);" onclick="addToWishList('{{$product->flag}}', '{{$product->id}}', $(this));"  class="product-add-wishlist active">
                                <i class="material-icons dp48">favorite</i>
                            </a>
                        @else
                            <a href="javascript:void(0);" onclick="addToWishList('{{$product->flag}}', '{{$product->id}}', $(this));" class="product-add-wishlist">
                                <i class="material-icons dp48">favorite</i>
                            </a>
                        @endif
                    </div>
                    <div class="inner_productBox">
                        <a href="{{ route("mix.product.details", [$product->flag, $product->id]) }}" >
                            <div class="imgBox">
                                @foreach($product->product_images as $key=>$image)
                                    <img src="{{Storage::disk('s3')->url('public/'.$image->product_image)}}" class="single-product-img" alt="" />
                                    @break
                                @endforeach
                            </div>

                            <div class="products_inner_textbox">
                                <!-- <div class="priceBox row">
                                    <div class="col s12 m12 l4 apperal">

                                    </div>
                                    <div class="col s12 m12 l8 right-align price">
                                        $ {{$product->price_per_unit}}/<span class="unit"> {{$product->qty_unit}}</span>
                                    </div>
                                </div> -->

                                <div class="row">
                                    <div class="col s6">
                                        <h4><span> {{$product->title}} </span></h4>
                                    </div>
                                    <div class="col s6">
                                        @if(isset($product->moq))
                                            <div class="product_moq"><span class="moq">MOQ:</span> {{$product->moq}} <span class="moq-unit">{{ $product->qty_unit }}</span></div>
                                        @endif
                                    </div>
                                </div>

                                <!-- <h4><a href="{{ route("mix.product.details", [$product->flag, $product->id]) }}" >{{$product->title}}</a></h4>
                                @if(isset($product->moq))
                                    <div class="product_moq">MOQ: {{$product->moq}} {{ $product->qty_unit }}</div>
                                @endif -->
                                <!-- @if(isset($product->lead_time))
                                    <div class="product_lead_time">Lead time:
                                        @php
                                            $pattern= '/[^0-9\-]/';
                                            $preg_replace= preg_replace($pattern, '', $product->lead_time);
                                        @endphp
                                        {{$preg_replace}} days
                                    </div>
                                @endif -->
                                {{-- <a href="{{route('mix.product.details',['flag' => $product->flag, 'id' => $product->id])}}">
                                    <div class="priceBox row">
                                        <!-- <div class="col s12 m6 apperal"><a href="{{route('supplier.profile',$product->businessProfile->alias)}}">{{ $product->businessProfile->business_name }}</a></div> -->
                                        <div class="col s12 m6 apperal">{{ $product->businessProfile->business_name }}</div>
                                        <div class="price col s12 m6 right-align lead-time-value">lead time: {{$product->lead_time}}</div>
                                    </div>
                                    <h4>{{$product->title}}</h4>
                                    @if(isset($list->moq))
                                        <div class="product_moq">MOQ: {{$list->moq}}</div>
                                    @endif
                                    @if(isset($list->lead_time))
                                        <div class="product_lead_time">Lead time: {{$list->lead_time}}</div>
                                    @endif
                                </a> --}}
                            </div>
                        </a>



                        <!-- <div class="priceBox row"></div>
                        <h4>
                            <a href="{{route('mix.product.details', ['mb', $product->id])}}">
                                {{ \Illuminate\Support\Str::limit($product->title, 35, '...') }}
                            </a>
                        </h4>
                        <div class="moq" >MOQ  150 <span>pcs</span></div>
                        <div class="leadTime">Lead time 10 <span>days</span></div> -->


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
</div>


