
@if(count($products)>0)
    <div class="active_grid product_boxwrap row">
        @foreach($products as $key=>$product)
            <div class="col s6 m4 l3 product_item_box">
                <div class="productBox">
                    <div class="favorite">
                        @if(in_array($product->id,$wishListShopProductsIds))
                            <a href="javascript:void(0);" onclick="addToWishList('{{$product->flag}}', '{{$product->id}}', $(this));" class="product-add-wishlist active">
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

                    <div class="inner_productBox @php echo($product->overlay_original_image) ? 'has-overlay':'' @endphp">
                        <a href="{{route('productdetails',$product->sku)}}">
                            <div class="imgBox">
                                @foreach($product->images as $key=>$image)
                                    @if($product->businessProfile()->exists())
                                        
                                        <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="single-product-img" alt="" />
                                    @else
                                        <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="single-product-img" alt="" />
                                        
                                    @endif
                                    @break
                                @endforeach

                                @if($product->overlay_original_image)
                                <img src="{{Storage::disk('s3')->url('public/'.$product->overlay_original_image)}}" class="single-product-overlay-img" alt="" style="display: none;" />
                                @endif
                            </div>

                            <div class="products_inner_textbox">
                                <!-- <a href="{{route('productdetails',$product->sku)}}"> -->
                                    <!-- <div class="priceBox row">
                                        <div class="col s12 m12 l4 apperal">
                                            <a href="{{ route("supplier.profile",$product->businessProfile->alias) }}">
                                                {{$product->product_type == 3 ? 'Non-Clothing' : 'Apparel'}}
                                            </a>
                                        </div>
                                        <div class="col s12 m12 l8 price">@include('product._product_price')</div>
                                    </div> -->
                                    <h4><span> {{ \Illuminate\Support\Str::limit($product->name, 35, '...') }} </span></h4>
                                    <div class="row">
                                        <div class="col s12 m6">
                                            @if(isset($product->moq))
                                                <div class="product_moq"><span class="moq">MOQ:</a> {{$product->moq}} <span class="moq-unit">{{$product->product_unit}}</span></div>
                                            @endif                                            
                                        </div>
                                        <div class="col s12 m6">
                                            <div class="pro_price">
                                                <span class="price">Price</span>
                                                @include('product._product_price')                                                                                       
                                            </div>
                                        </div>
                                    </div>                                    

                                    <!-- <h4><a href="{{route('productdetails',$product->sku)}}" > {{ \Illuminate\Support\Str::limit($product->name, 35, '...') }}</a></h4>

                                    @if(isset($product->moq))
                                        <div class="product_moq">MOQ: {{$product->moq}} {{$product->product_unit}}</div>
                                    @endif -->


                                    <!-- @if($product->product_type == 1)
                                        <div class="product_lead_time">Lead time:
                                            {{getLeadTime($product)}}
                                            {{-- @php
                                                $count= count(json_decode($product->attribute));
                                                $count = $count-2;
                                            @endphp
                                            @foreach (json_decode($product->attribute) as $k => $v)
                                                @if($k == 0 && $v[2] == 'Negotiable')
                                                {{$v[3]}} days
                                                @endif
                                                @if($loop->last && $v[2] != 'Negotiable')
                                                    {{ $v[3] }} days
                                                @endif
                                                @if($loop->last && $v[2] == 'Negotiable')
                                                    @foreach (json_decode($product->attribute) as $k => $v)
                                                            @if($k == $count)
                                                                {{ $v[3]  }} days
                                                            @endif
                                                    @endforeach
                                                @endif
                                            @endforeach --}}
                                        </div>
                                    @endif -->
                                <!-- </a> -->
                            </div>
                        </a>



                        

                        

                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination-block-wrapper">
        <div class="col s12 center">
            {!! $products->appends(request()->query())->links() !!}
        </div>
    </div>
@else
    <div class="card-alert card cyan">
        <div class="card-content white-text">
            <p>INFO : No products available.</p>
        </div>
    </div>
@endif
