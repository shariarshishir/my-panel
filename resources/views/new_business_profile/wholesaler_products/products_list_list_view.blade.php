<div class="profile_product_list_view">
    @if($products->count() > 0)
        <div class="no_more_tables">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>MOQ</th>
                        <th>Lead Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products  as $product)
                        <tr  onclick="editproduct('{{ $product->sku }}')" style="cursor: pointer;">
                            <td data-title="Image">
                                @foreach($product->images as $image)
                                    <img src="{{Storage::disk('s3')->url('public/'.$image->image)}}" class="" alt="" height="60px">
                                    @break
                                @endforeach
                            </td>
                            <td data-title="Product Name">{{$product->name}}</td>
                            <td data-title="MOQ"> MOQ: <br/><span class="size-lg">{{$product->moq}}</span></td>
                            <td data-title="Lead Time"><br> <span class="size-lg">@include('new_business_profile.wholesaler_products._product_lead_time')</span> days</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
</div>
