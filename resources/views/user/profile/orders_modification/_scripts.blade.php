@push('js')
    <script>
        //  $(document).on('click', '.display-comment', function(){
        //      $(this).siblings('.mod-comment').toggle();
        //  });

        //  $(document).on('click', '.display-replay', function(){
        //     $(this).siblings('.mod-comment-replay').toggle();
        //  });
        $('#orderQueryModificationTable').DataTable({
            "order": [[ 1, "desc" ]]
        });
         $('#ordModCommentForm').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var mod_req_id=$('input[name=mod_req_id]').val();
            var url = '{{ route("order.mod.req.comment.replay",":id") }}';
                url = url.replace(':id', mod_req_id);
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                url: url,
                success:function(data)
                    {
                        //toastr.success(data.msg);
                        swal(data.message, data.success,data.type);
                        $('#ordModCommentForm')[0].reset();
                        $(".order-modification-comment-modal").modal('close');

                    },
                error: function(xhr, status, error)
                    {
                        $('#pmr-errors').empty();
                        $("#pmr-errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#pmr-errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }
            });
        });

        $(document).on('keyup','.ord-mod-color-sizes tr',function(){
            //var unit_price= $('#ord-mod-unit-price').val();
            var unit_price= $(this).closest(".ordModCreateForm").children().find(".ord-mod-unit-price").val();
             //var unit_price= $(this).closest('.ord-mod-color-sizes input[name=ord_mod_unit_price]').val();
            if(unit_price==0){alert('please provide unit price');}
            var total=0;
            var tr= $(this).closest(".ordModCreateForm").children().find('.ord-mod-color-tbody tr');
            $(tr).each(function(){
                var inputs = $(this).find('input').not(':first');
                inputs.each(function(){
                total+=Number($(this).val()) || 0; // parse and add value, if NaN then add 0
                });
            });

            $(this).closest(".ordModCreateForm").children().find('#ord-mod-total-quantity').val(total);
              var total_price=unit_price * total;
            $(this).closest(".ordModCreateForm").children().find('#ord-mod-total-price').val(total_price);

        });

    //create order
    // $(document).on('click', '#submitordModCreateForm', function(e){
    //       e.preventDefault();
    //       var form =$(this).closest(".ord-mod-create").find('.ordModCreateForm');

    //       $(form).on('submit',function(e){
    //         e.preventDefault();
    //         var formData = new FormData(this);
    //         var url = '{{ route("ord.mod.create.order") }}';
    //         formData.append('_token', "{{ csrf_token() }}");
    //         $.ajax({
    //             method: 'post',
    //             processData: false,
    //             contentType: false,
    //             cache: false,
    //             data: formData,
    //             url: url,
    //             success:function(data)
    //                 {
    //                     toastr.success(data.msg);
    //                     $('#ordModCreateForm')[0].reset();
    //                     $(".ord-mod-create table").find("tr:not(:nth-child(1))").remove();
    //                     $('#ord-mod-create-errors').empty();
    //                     $(".create-order-modification-details-modal").modal('close');


    //                 },
    //             error: function(xhr, status, error)
    //                 {
    //                     $('#ord-mod-create-errors').empty();
    //                     $("#ord-mod-create-errors").append("<li class='alert alert-danger'>"+error+"</li>")
    //                     $.each(xhr.responseJSON.error, function (key, item)
    //                     {
    //                         $("#ord-mod-create-errors").append("<li class='alert alert-danger'>"+item+"</li>")
    //                     });
    //                 }
    //         });
    //     });

    // });

    //create update order form wholesaler
    $(document).on('click','.create-order-modification-modal', function(){
        var obj=$(this);
        var mod_req_id= $(this).attr('id');

        var url = '{{ route("order.mod.proposal.create.form",":id") }}';
                url = url.replace(':id', mod_req_id);
            $.ajax({
                method: 'get',
                processData: false,
                contentType: false,
                cache: false,
                url: url,
                beforeSend: function() {
                $("body").addClass("loading");
                },
                complete: function(){
                    $("body").removeClass("loading");
                },

                success:function(data)
                    {

                        $("#create-order-modification-modal").modal('open');
                        $("#create-order-modification-modal input[name=ord_mod_req_id]").val(obj.attr('id'));
                        $("#create-order-modification-modal input[name=product_id]").val(obj.attr('product_id'));
                        if(data.check_if_ordered == 1){
                            $('#create-order-modification-modal #submitordModCreateForm').attr("disabled", 'disabled');
                        }
                        else{
                            $('#create-order-modification-modal #submitordModCreateForm').attr("disabled", false);

                        }
                        if(data.data != null){
                            $('#create-order-modification-modal input[name=ord_mod_unit_price]').val(data.data.unit_price);
                            $('#create-order-modification-modal input[name=ord_mod_total_quantity]').val(data.data.quantity);
                            $('#create-order-modification-modal input[name=ord_mod_total_price]').val(data.data.total_price);
                            $('#create-order-modification-modal .ord-mod-color-tbody').html('');
                            $.each(JSON.parse(data.data.colors_sizes),function(key, value){
                                var html='<tr>';

                                    html+='<td><input type="text" value="'+value.color+'" class="form-control" name="color_size[color][]" /></td>';
                                    html+='<td><input type="text" value="'+value.xxs+'" class="form-control count-color-size" name="color_size[xxs][]" /></td>';
                                    html+='<td><input type="text" value="'+value.xs+'" class="form-control count-color-size" name="color_size[xs][]" /></td>';
                                    html+='<td><input type="text" value="'+value.small+'" class="form-control count-color-size" name="color_size[small][]" /></td>';
                                    html+='<td><input type="text" value="'+value.medium+'" class="form-control count-color-size" name="color_size[medium][]" /></td>';
                                    html+='<td><input type="text" value="'+value.large+'" class="form-control count-color-size" name="color_size[large][]" /></td>';
                                    html+='<td><input type="text" value="'+value.extra_large+'" class="form-control count-color-size" name="color_size[extra_large][]" /></td>';
                                    html+='<td><input type="text" value="'+value.xxl+'" class="form-control count-color-size" name="color_size[xxl][]" /></td>';
                                    html+='<td><input type="text" value="'+value.xxxl+'" class="form-control count-color-size" name="color_size[xxxl][]" /></td>';
                                    html+='<td><input type="text" value="'+value.four_xxl+'" class="form-control count-color-size" name="color_size[four_xxl][]" /></td>';
                                    html+='<td><input type="text" value="'+value.one_size+'" class="form-control count-color-size" name="color_size[one_size][]" /></td>';

                                    html+='</tr>';
                                    $('#create-order-modification-modal .ord-mod-color-tbody').append(html);

                            })
                            if(data.data.image != null ){
                                var m_image= "{{asset('storage')}}"+'/'+data.data.image;
                                $('#create-order-modification-modal #preview-image-before-upload').attr('src',m_image);
                            }

                        }
                        else{
                            $('#ordModCreateForm')[0].reset();
                        }


                    },
                error: function(xhr, status, error)
                    {
                        $('#pmr-errors').empty();
                        $("#pmr-errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#pmr-errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }
            });
    });
    $('#ordModCreateForm').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var url = '{{ route("ord.mod.create.order") }}';
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                url: url,
                beforeSend: function() {
                $("body").addClass("loading");
                },
                complete: function(){
                    $("body").removeClass("loading");
                },
                success:function(data)
                    {
                        toastr.success(data.msg);
                        $('#ordModCreateForm')[0].reset();
                        $(".ord-mod-create table").find("tr:not(:nth-child(1))").remove();
                        $('#ord-mod-create-errors').empty();
                        $('#create-order-modification-modal img').attr("src", "https://www.riobeauty.co.uk/images/product_image_not_found.gif");
                        $(".create-order-modification-details-modal").modal('close');


                    },
                error: function(xhr, status, error)
                    {
                        $('#ord-mod-create-errors').empty();
                        $("#ord-mod-create-errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#ord-mod-create-errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }
            });
        });

        //confirm order
        $(document).on('click', '#submitordModConfirmForm',function(e){
            e.preventDefault();
            var unit_price=  $('.confirm-order-modification-details-modal input[name=ord_mod_unit_price]').val();
            var quantity =  $('.confirm-order-modification-details-modal input[name=ord_mod_quantity]').val();
            var sku =  $('.confirm-order-modification-details-modal input[name=ord_mod_sku]').val();
            var discount_amount =  $('.confirm-order-modification-details-modal input[name=ord_mod_discount_amount]').val();
            var total_price =  $('.confirm-order-modification-details-modal input[name=ord_mod_total_price]').val();
            var order_modification_req_id =  $('.confirm-order-modification-details-modal input[name=ord_mod_req_id]').val();
            var url = '{{ route("add.cart") }}';
            var color_attr=[];
            $('.confirm-ord-mod-color-sizes tr').each(function(idx,ele){
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

            swal({
                title: "Want to add this product into cart?",
                text: "",
                type: "info",
                showCancelButton: !0,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: !0
            }).then(function (e) {
                        $.ajax({
                            type:'GET',
                            url: url,
                            dataType:'json',
                            data:{ sku :sku ,unit_price:unit_price,quantity:quantity,total_price:total_price,discount_amount:discount_amount,color_attr:color_attr,order_modification_req_id:order_modification_req_id},
                            success: function(data){
                                console.log(data.cartItems);
                                swal("Done!", data.success,"success");
                                $('#cartItems').html('');
                                $("#cartItems").html(data.cartItems);
                                $(".confirm-order-modification-details-modal").modal('close');
                            }
                        });
                    }

            , function (dismiss) {
                return false;
            })
        });
        //create comment form
        $(document).on('click','.order-mod-comments-modal', function(){
            var id=$(this).attr('id');
            var url = '{{ route("prod.mod.req.comment.create.show", ":slug") }}';
            url = url.replace(':slug', id);
            $.ajax({
                    method: 'get',
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: url,
                    beforeSend: function() {
                    $("body").addClass("loading");
                    },
                    complete: function(){
                        $("body").removeClass("loading");
                    },
                    success:function(data)
                        {
                            console.log(data)
                            $('#order-modification-comment-modal').modal('open');
                            $('#order-modification-comment-modal input[name=mod_req_id]').val(data.data.id);
                            $('#order-modification-comment-modal input[name=product_id]').val(data.data.product_id)
                            $('#order-modification-comment-modal .order-top-block').html(data.order_request_details);
                            $('#order-modification-comment-modal .ord-mod-comments-show').html(data.comment);
                            if(data.data.state == 3){
                                $('#order-modification-comment-modal #submitProdModReqReplay').attr("disabled", 'disabled');
                            }
                            else{
                                $('#order-modification-comment-modal #submitProdModReqReplay').attr("disabled", false);

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

            //show order proposal
            $(document).on('click','.confirm-order-modification-modal', function(){
                    var id= $(this).attr('id');
                    var url = '{{ route("prod.mod.req.proposal.show", ":slug") }}';
                    url = url.replace(':slug', id);
                    $.ajax({
                            method: 'get',
                            processData: false,
                            contentType: false,
                            cache: false,
                            url: url,
                            beforeSend: function() {
                            $("body").addClass("loading");
                            },
                            complete: function(){
                                $("body").removeClass("loading");
                            },
                            success:function(data)
                                {
                                    $('#confirm-order-modification-modal').modal('open');
                                    if(data.check_if_ordered == 1){
                                        $('#confirm-order-modification-modal #submitordModConfirmForm').attr("disabled", 'disabled');
                                    }
                                    else{
                                        $('#confirm-order-modification-modal #submitordModConfirmForm').attr("disabled", false);

                                    }
                                    $('.confirm-order-modification-details-modal input[name=ord_mod_unit_price]').val(data.data.unit_price);
                                    $('.confirm-order-modification-details-modal input[name=ord_mod_quantity]').val(data.data.quantity);
                                    $('.confirm-order-modification-details-modal input[name=ord_mod_sku]').val(data.data.product_sku);
                                    $('.confirm-order-modification-details-modal input[name=ord_mod_req_id]').val(data.data.order_modification_request_id);
                                    $('.confirm-order-modification-details-modal input[name=ord_mod_total_price]').val(data.data.total_price);
                                    $('.confirm-order-modification-details-modal input[name=ord_mod_discount_amount]').val(data.data.discount_amount);
                                    $('#confirm-order-modification-modal .ord-mod-unit-price').text(data.data.unit_price);

                                    // $('#order-modification-comment-modal input[name=mod_req_id]').val(data.data.id);
                                    // $('#order-modification-comment-modal input[name=product_id]').val(data.data.product_id)
                                    $('#confirm-order-modification-modal .confirm-ord-mod-color-sizes').html('');
                                    $.each(JSON.parse(data.data.colors_sizes),function(key, value){
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
                                            html+='<td data-title="4XXL"><input type="hidden" name="four_xxl" value="'+value.four_xxl+'">'+value.four_xxl+'</td>';
                                            html+='<td data-title="One Size"><input type="hidden" name="one_size" value="'+value.one_size+'">'+value.one_size+'</td>';

                                            html+='</tr>';
                                            $('#confirm-order-modification-modal .confirm-ord-mod-color-sizes').append(html);

                                    })
                                    $('#confirm-order-modification-modal .ord-mod-total-quantity').text(data.data.quantity);
                                    $('#confirm-order-modification-modal .ord-mod-total-price').text(data.data.total_price);
                                    $('#confirm-order-modification-modal .ord-mod-discount').text(data.data.discount_amount ?? 0);

                                    if(data.data.image != null ){
                                        var m_image= "{{asset('storage')}}"+'/'+data.data.image;
                                        $('#confirm-order-modification-modal .ord-mod-mod-image').attr('src',m_image);
                                    }

                                    $.each(data.data.product.images,function(key, value){
                                          if(key==0){
                                              var p_image_first=value.image;
                                              var p_image= "{{asset('storage')}}"+'/'+p_image_first;
                                              $('#confirm-order-modification-modal .ord-mod-pre-image').attr('src',p_image);

                                          }
                                    })




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

    </script>
@endpush
