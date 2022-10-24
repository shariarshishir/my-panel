@push('js')
<script>
      $('#orderQueryTable').DataTable({
         "order": [[ 0, "desc" ]],
         "columnDefs": [ {
            "targets": 0,
            "searchable": false,
            "visible" :false,
        } ]
     });
    $(document).ready(function() {
        $('.discount-type').select2();
    });

      //confirm order
      $(document).on('click', '#submitordModConfirmForm',function(e){
            e.preventDefault();
            var unit_price=  $('#add-to-cart-order-query-modal input[name=ord_mod_unit_price]').val();
            var quantity =  $('#add-to-cart-order-query-modal input[name=ord_mod_quantity]').val();
            var total_price =  $('#add-to-cart-order-query-modal input[name=ord_mod_total_price]').val();
            var sku =  $('#add-to-cart-order-query-modal input[name=ord_mod_product_sku]').val();
            var order_modification_req_id =  $('#add-to-cart-order-query-modal input[name=order_modification_req_id]').val();
            var discount_amount =  $('#add-to-cart-order-query-modal input[name=ord_mod_discount]').val();
            var product_type =  $('#add-to-cart-order-query-modal input[name=ord_req_product_type]').val();
            var url = '{{ route("add.cart") }}';
            var color_attr=[];
            // for ready stock and buy design
            if(product_type == 1 || product_type == 2)
            {
                $('.order-query-processed-color-sizes tr').each(function(idx,ele){
                    color_attr.push({'color' : $('input[name="color"]').eq(idx).val(),
                    'xxs' : Number($('input[name="xxs"]').eq(idx).val()) || 0,
                    'xs' : Number($('input[name="xs"]').eq(idx).val()) || 0,
                    'small' :Number($('input[name="small"]').eq(idx).val())  || 0,
                    'medium' : Number($('input[name="medium"]').eq(idx).val()) || 0,
                    'large' : Number($('input[name="large"]').eq(idx).val()) ||0,
                    'extra_large' : Number($('input[name="extra_large"]').eq(idx).val()) || 0,
                    'xxl' : Number($('input[name="xxl"]').eq(idx).val()) || 0,
                    'xxxl' : Number($('input[name="xxxl"]').eq(idx).val()) || 0,
                    'four_xxl' : Number($('input[name="four_xxl"]').eq(idx).val()) || 0,
                    'one_size' : Number($('input[name="one_size"]').eq(idx).val()) || 0,
                    });
                });
            }else{
                // non clothing item
                $('.order-query-processed-color-sizes tr').each(function(idx,ele){
                    color_attr.push({'color' : $('input[name="color"]').eq(idx).val(),
                    'quantity' : Number($('input[name="quantity"]').eq(idx).val()) || 0,
                    });
                });
            }


            swal({
                title: "Want to add this product into cart?",
                text: "",
                type: "info",
                showCancelButton: !0,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                        $.ajax({
                            type:'GET',
                            url: url,
                            dataType:'json',
                            data:{ sku :sku ,unit_price:unit_price,total_price:total_price, quantity:quantity,color_attr:color_attr,order_modification_req_id:order_modification_req_id,discount_amount:discount_amount},
                            success: function(data){
                                console.log(data.cartItems);
                                swal(data.message, data.success,data.type);
                                $('#cartItems').html('');
                                $("#cartItems").html(data.cartItems);
                                $('#product-details-modal').hide();
                                $('#add-to-cart-order-query-modal').modal('close');
                            }
                        });
                }
            }

            , function (dismiss) {
                return false;
            })
        });
     //show add to cart modal details
        $(document).on('click','.add-to-cart-order-query-modal', function(){
                    var id= $(this).attr('id');
                    var url = '{{ route("user.order.query.show", ":slug") }}';
                    url = url.replace(':slug', id);
                    $.ajax({
                            method: 'get',
                            processData: false,
                            contentType: false,
                            cache: false,
                            url: url,
                            beforeSend: function() {
                                $('.loading-message').html("Please wait...");
		                        $('#loadingProgressContainer').show();
                            },
                            complete: function(){
                                $('.loading-message').html("");
		                        $('#loadingProgressContainer').hide();
                            },
                            success:function(data)
                                {

                                    $('#add-to-cart-order-query-modal').modal('open');
                                    $('#add-to-cart-order-query-modal .order-query-processed-date').text(data.created_at);
                                    var status;
                                    switch(data.data.state) {
                                        case 1:
                                        status='<span class="chip lighten-5 yellow yellow-text">Pending</span>';
                                        break;
                                        case 2:
                                        status='<span class="chip lighten-5 blue blue-text">Processed</span>';
                                        break;
                                        case 3:
                                        status='<span class="chip lighten-5 green green-text">Ordered</span>';
                                        break;
                                        case 4:
                                        status='<span class="chip lighten-5 red red-text">Cancel</span>';
                                        break;
                                        default:

                                    }

                                    $('#add-to-cart-order-query-modal .order-query-processed-status').html(status);
                                    $('#add-to-cart-order-query-modal .order-query-processed-color-sizes').html('');
                                    $('#add-to-cart-order-query-modal .color-size-table-block thead').html('');
                                    if(data.data.product.product_type == 1 || data.data.product.product_type == 2){
                                        var html='<tr>';
                                            html+='<th>Color</th>';
                                            html+='<th>XXS</th>';
                                            html+='<th>XS</th>';
                                            html+='<th>Small</th>';
                                            html+='<th>Medium</th>';
                                            html+='<th>Large</th>';
                                            html+='<th>Extra Large</th>';
                                            html+='<th>XXL</th>';
                                            html+='<th>XXXL</th>';
                                            html+='<th>4XXL</th>';
                                            html+='<th>One Size</th>';
                                            // html+='<th>&nbsp;</th>';
                                            html+='<tr>';
                                        $('#add-to-cart-order-query-modal .color-size-table-block thead').html(html);
                                        $.each(JSON.parse(data.data.details),function(key, value){
                                        var html='<tr>';
                                            html+='<td data-title="Color"><input type="hidden" name="color" value="'+value.color+'">'+value.color+'</td>';
                                            html+='<td data-title="XXS"><input type="hidden" name="xxs" value="'+value.xxs+'">'+value.xxs+'</td>';
                                            html+='<td data-title="XS"><input type="hidden" name="xs" value="'+value.xs+'">'+value.xs+'</td>';
                                            html+='<td data-title="Small"><input type="hidden" name="small" value="'+value.small+'">'+value.small+'</td>';
                                            html+='<td data-title="Medium"><input type="hidden" name="medium" value="'+value.medium+'">'+value.medium+'</td>';
                                            html+='<td data-title="Large"><input type="hidden" name="large" value="'+value.large+'">'+value.large+'</td>';
                                            html+='<td data-title="Extra Large"><input type="hidden" name="extra_large" value="'+value.extra_large+'">'+value.extra_large+'</td>';
                                            html+='<td data-title="XXL"><input type="hidden" name="xxl" value="'+value.xxl+'">'+value.xxl+'</td>';
                                            html+='<td data-title="XXXL"><input type="hidden" name="xxxl" value="'+value.xxxl+'">'+value.xxxl+'</td>';
                                            html+='<td data-title="4XXl"><input type="hidden" name="four_xxl" value="'+value.four_xxl+'">'+value.four_xxl+'</td>';
                                            html+='<td data-title="One Size"><input type="hidden" name="one_size" value="'+value.one_size+'">'+value.one_size+'</td>';

                                            html+='</tr>';
                                            $('#add-to-cart-order-query-modal .order-query-processed-color-sizes').append(html);

                                        });
                                    }
                                    else{
                                        var html='<tr>';
                                            html+='<th>Color</th>';
                                            html+='<th>Quantity</th>';
                                            // html+='<th>&nbsp;</th>';
                                            html+='</tr>';
                                        $('#add-to-cart-order-query-modal .color-size-table-block thead').html(html);
                                        $.each(JSON.parse(data.data.details),function(key, value){
                                        var html='<tr>';
                                            html+='<td data-title="Color"><input type="hidden" name="color" value="'+value.color+'">'+value.color+'</td>';
                                            html+='<td data-title="Quantity"><input type="hidden" name="quantity" value="'+value.quantity+'">'+value.quantity+'</td>';
                                            html+='</tr>';
                                            $('#add-to-cart-order-query-modal .order-query-processed-color-sizes').append(html);

                                        });
                                    }

                                    if(data.data.order_modification){

                                        $('#add-to-cart-order-query-modal .order-modification-data').show();
                                        $('#add-to-cart-order-query-modal .order-query-processed-unit-price').text(data.data.order_modification.unit_price);
                                        $('#add-to-cart-order-query-modal .order-query-processed-quantity').text(data.data.order_modification.quantity);
                                        $('#add-to-cart-order-query-modal .order-query-processed-discount').text(data.data.order_modification.discount_amount ?? 0);
                                        $('#add-to-cart-order-query-modal .order-query-processed-total-price').text(data.data.order_modification.total_price);

                                        $('#add-to-cart-order-query-modal input[name=ord_mod_unit_price]').val(data.data.order_modification.unit_price);
                                        $('#add-to-cart-order-query-modal input[name=ord_mod_total_price]').val(data.data.order_modification.total_price);
                                        $('#add-to-cart-order-query-modal input[name=ord_mod_quantity]').val(data.data.order_modification.quantity);
                                        $('#add-to-cart-order-query-modal input[name=ord_mod_product_sku]').val(data.data.order_modification.product_sku);
                                        $('#add-to-cart-order-query-modal input[name=order_modification_req_id]').val(data.data.id);
                                        $('#add-to-cart-order-query-modal input[name=ord_mod_discount]').val(data.data.order_modification.discount_amount);
                                        $('#add-to-cart-order-query-modal input[name=ord_req_product_type]').val(data.data.product.product_type);
                                    }
                                    else{
                                        $('#add-to-cart-order-query-modal .order-modification-data').hide();
                                    }

                                    // order_modification_request state 3 ordered
                                    if(data.data.state == 3){
                                        $('#submitordModConfirmForm').attr("disabled", 'disabled');
                                    }
                                    else{
                                        $('#submitordModConfirmForm').attr("disabled", false);

                                    }


                                },
                            error: function(xhr, status, error)
                                {

                                    $('#errors').empty();
                                    $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                                    $.each(xhr.responseJSON.error, function (key, item)
                                    {
                                        $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                                    });

                                }
                        });
        });

//order query communcation channel model open
        $(document).on('click','.open-communication-channel', function(){
            var id=$(this).attr('id');
            var url = '{{ route("user.order.query.show.message", ":slug") }}';
            url = url.replace(':slug', id);
            $.ajax({
                    method: 'get',
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: url,
                    beforeSend: function() {
                        $('.loading-message').html("Please wait...");
		                $('#loadingProgressContainer').show();
                    },
                    complete: function(){
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                    },
                    success:function(data)
                        {
                            console.log(data)
                            $('#order-query-communication-modal').modal('open');
                            $('#order-query-communication-modal input[name=order_modification_request_id]').val(data.data.id);
                            $('#order-query-communication-modal .order-query-message-show').html(data.message);
                            if(data.data.state == 3){
                                $('#order-query-communication-modal #submit-order-query-message-form').attr("disabled", 'disabled');
                            }
                            else{
                                $('#order-query-communication-modal #submit-order-query-message-form').attr("disabled", false);

                            }
                            // $.each(JSON.parse(data.data.details),function(key, value){
                            //     var html='<div class="col m12">';
                            //         html+='<div class="row order-info-top">';
                            //         html+='<div class="col m6 created-by">&nbsp;</div>';

                            //         html+='<div class="col m6 create-date"><i class="material-icons">date_range</i></div>';
                            //         html+='</div>';
                            //         html+='<div class="row order-info-bottom">';
                            //         html+='<div class="col m6 order-info-details">'+value.details+'</div>';
                            //         if(value.image){
                            //             var image= "{{asset('storage')}}"+'/'+value.image;
                            //             html+='<div class="mod-detail-image col m6 order-info-image"><img src="'+image+'" alt="" height="250" width="250"></div>';

                            //         }
                            //         html+='</div>';
                            //         html+='</div>';
                            //         $('#order-modification-comment-modal .order-top-block').append(html);

                            // })


                        },

                    error: function(xhr, status, error)
                        {

                            $('#errors').empty();
                            $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                            $.each(xhr.responseJSON.error, function (key, item)
                            {
                                $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                            });

                        }
            });
        });

        //submit message
        $('#order-query-message-form').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var url = '{{ route("user.order.query.message.store") }}';
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                url: url,
                beforeSend: function() {
                    $('.loading-message').html("Please wait...");
		            $('#loadingProgressContainer').show();
                },
                complete: function(){
                    $('.loading-message').html("");
		            $('#loadingProgressContainer').hide();
                },
                success:function(data)
                    {
                        //toastr.success(data.msg);
                        $("#order-query-communication-modal").modal('close');
                        swal(data.message, data.success,data.type);
                        $('#pmr-errors').empty();
                        $('#order-query-message-form')[0].reset();

                    },
                error: function(xhr, status, error)
                    {
                        $('#pmr-errors').empty();
                        $("#pmr-errors").append("<li class='red-text'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#pmr-errors").append("<li class='red-text'>"+item+"</li>")
                        });
                    }
            });
        });



</script>
@endpush
