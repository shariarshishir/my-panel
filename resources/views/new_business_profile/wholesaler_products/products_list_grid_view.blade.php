<div class="row product-list">
    @if($products->count() > 0)
        @foreach ($products  as $product)
        <div class="col s6 m4 l3 product_item_box">
            <div class="productBox">
                <div class="inner_productBox">
                    <a href="javascript:void(0);" onclick="editproduct('{{ $product->sku }}')">
                        <div class="imgBox">
                            @foreach($product->images as $image)
                                <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="" alt="">
                                @break
                            @endforeach
                        </div>
                        <div class="products_inner_textbox">
                            <h4><span>{{$product->name}}</span></h4>
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="product_moq">
                                        MOQ: <br> <span>{{$product->moq}}</span>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="pro_leadtime">
                                        Lead Time <br> <span>@include('new_business_profile.wholesaler_products._product_lead_time')</span> days
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
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
</div>
