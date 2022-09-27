<div class="product_data_table_wrap">
    <div class="no_more_tables">
        <table class="table table-striped striped bordered box_shadow_radius ">
            <thead class="cf">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Product Tag</th>
                    <th style="text-align:center;">Code</th>
                    <th style="text-align:center;">Price</th>
                    <th style="text-align:center;">MOQ</th>
                    <th style="text-align:center;">Lead Time</th>
                    <th style="text-align:center;"></th>
                </tr>
            </thead>
            <tbody id="tbbdy">
                @foreach($products as $mk => $product)
                    <tr style="cursor: pointer;" onclick="selecttr(this);">
                        <td data-title="Image">
                        @foreach($product->product_images as $image)
                            <img src="{{Storage::disk('s3')->url('public/'.$image->product_image)}}" class="single-product-img" alt="" />
                            @break
                        @endforeach
                        </td>
                        <td data-title="Product Name" style="cursor:pointer;" onClick="openviewdetails({{ $mk }}, {{ count($products) }})">
                            <span class="product_title" style="font-weight:bold; color:#55A860;">{{ $product->title }}</span>
                            <div class="clear5"></div>
                            <div class="col-md-12">
                                <div class="prd-lt-con-list">
                                    <div class="col-md-12 plr0"><h6> Colors</h6></div>
                                    <div class="col-md-12 plr0">
                                        @if(isset($product->colors))
                                            @if(in_array('Red',$product->colors))
                                                <i class="fa fa-square fa-lg red" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Blue',$product->colors))
                                                <i class="fa fa-square fa-lg blue" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Green',$product->colors))
                                                <i class="fa fa-square fa-lg green" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Black',$product->colors))
                                                <i class="fa fa-square fa-lg black" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Brown',$product->colors))
                                                <i class="fa fa-square fa-lg brown" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Pink',$product->colors))
                                                <i class="fa fa-square fa-lg pink" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Yellow',$product->colors))
                                                <i class="fa fa-square fa-lg yellow" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Orange',$product->colors))
                                                <i class="fa fa-square fa-lg orange" aria-hidden="true"></i>
                                            @endif
                                            @if(in_array('Lightblue',$product->colors))
                                                <i class="fa fa-square fa-lg lightblue" aria-hidden="true"></i>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="clear5"></div>
                            <div class="col-md-12">
                                <div class="prd-lt-con-list bbn product_size">
                                    <div class="col-md-12 plr0"><h6>Sizes</h6></div>
                                    <div class="col-md-12 plr0">
                                        @if(isset($product->sizes))
                                            @foreach($product->sizes as $size)
                                                <span>{{ $size }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-title="product_tag">
                            {{$product->product_tag ? ucwords( implode(",",$product->product_tag)) : '' }}
                        </td>
                        <td data-title="Code" style="text-align:center;cursor: pointer;" onClick="openviewdetails({{ $mk }}, {{ count($products) }})">MB-{{$product->id}}</td>
                        <td data-title="Price" style="text-align:center;cursor: pointer;" onClick="openviewdetails({{ $mk }}, {{ count($products) }})">{{ $product->price_unit }} {{ $product->price_per_unit }}</td>
                        <td data-title="MOQ" style="text-align:center;cursor: pointer;" onClick="openviewdetails({{ $mk }}, {{ count($products) }})">{{ $product->moq }} {{ $product->qty_unit }}</td>
                        <td data-title="Lead Time" style="text-align:center;cursor: pointer;" onClick="openviewdetails({{ $mk }}, {{ count($products) }})">{{ $product->lead_time }}</td>
                        <td data-title="" style="text-align:center;cursor: pointer;">
                            {{-- <a class="btn_product_edit" href="javascript:void(0);" onclick="editproduct('{{ $product->id }}')">Edit</a> | <a href="javascript:void(0);" onclick="deleteProduct('{{ $product->id }}', '{{$product->business_profile_id}}')" style="color:#ff0000;">Delete</a> --}}
                            <a class="btn_product_edit" href="javascript:void(0);" onclick="editproduct('{{ $product->id }}')">Edit</a> | <a href="javascript:void(0);" onclick="publishUnpublishProduct('{{ $product->id }}', '{{$product->deleted_at ? 0 : 1 }}', '{{$product->business_profile_id}}')" style="{{$product->deleted_at ? '#00FF00' : 'color:#ff0000;' }}">{{$product->deleted_at ? 'Publish' : 'Unpublish' }}</a>

                        </td>
                    </tr>
                @endforeach



            </tbody>
        </table>
    </div>
</div>

@push('js')
    <script>
        //seller publish unpublish product
       function publishUnpublishProduct(product_id, status, bid){
            var pid=product_id
            var status = status;
            // if(!confirm('Are You Want to Delete?')){return false;}
            var url = '{{ route("manufacture.product.publish.unpublish", [":pid", ":bid"] ) }}';
                url = url.replace(':pid', pid);
                url = url.replace(':bid', bid);
            if(status == 1){
                swal({
                    title: "Want to unpublished this product ?",
                    text: "Please ensure and then confirm!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, unpublish it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        $.ajax({
                            url: url,
                            type: "GET",
                            beforeSend: function() {
                                $('.loading-message').html("Please Wait.");
                                $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    $('.manufacture-product-table-data').html('');
                                    $('.manufacture-product-table-data').html(data.data);
                                    swal("Done!", data.msg,"success");

                                },
                                error: function(xhr, status, error)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    toastr.success(error);
                                }
                            });
                        }
                    else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            } else {
                swal({
                    title: "Want to published this product ?",
                    text: "Please ensure and then confirm!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, publish it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        $.ajax({
                            url: url,
                            type: "GET",
                            beforeSend: function() {
                                $('.loading-message').html("Please Wait.");
                                $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    $('.manufacture-product-table-data').html('');
                                    $('.manufacture-product-table-data').html(data.data);
                                    swal("Done!", data.msg,"success");
                                },
                                error: function(xhr, status, error)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    toastr.success(error);
                                }
                            });
                        }
                    else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }

        };
    </script>
@endpush

