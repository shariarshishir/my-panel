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

                    <tr onclick="editproduct('{{ $product->id }}')" style="cursor: pointer;">
                        <td data-title="Image">
                            @foreach($product->product_images as $image)
                                <img src="{{Storage::disk('s3')->url('public/'.$image->product_image)}}" height="60px" class="" alt="">
                            @break
                            @endforeach
                        </td>
                        <td data-title="Product Name">{{$product->title}}</td>
                        <td data-title="MOQ"> MOQ: <br/><span class="size-lg">{{$product->moq}}</span></td>
                        <td data-title="Lead Time"><span class="size-lg">{{$product->lead_time}}</span> days</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-block-wrapper">
            <div class="col s12 center">
                {!! $products->withQueryString()->links() !!}
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
