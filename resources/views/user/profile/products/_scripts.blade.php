@push('js')
<script>
    $(document).ready(function() {
        $('.product-add-modal-trigger').click(function(){
            $("#product-add-modal-block").modal('open');
            $('.fresh-rtd-attr').show();
            $('.stock-rtd-attr').hide();
            $('.non-clothing-block').hide();
            $('#seller_product_form')[0].reset();
            $("#product-add-modal-block table").find("tr:not(:nth-child(1))").remove();
            $('#category_id').val('');
            $('#category_id').trigger('change');
            $('#errors').empty();
            // $('.image-uploader').removeClass('has-files');
            // $('.image-uploader .uploaded').html('');
            $('.input-images-1').html('');
            $('.input-images-1').imageUploader();
            $('.full-stock-price').hide();
            $('.non-clothing-full-stock-price').hide();
            $('.ready-stock-prices-breakdown').show();
            $('#product-add-modal-block .product_unit').val('');
            $('#product-add-modal-block .product_unit').trigger('change');
        })

        $('.js-example-basic-multiple').select2();
        var url= '{{ route('seller-product.index') }}';
        var table = $('#seller-product-datatable').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            ajax:{
                    "url": url,
                    "data": function (d) {

                        d.state = $('#filter_state').val();
                        d.product_type = $('#filter_product_type').val();
                        // d.arrival = $('#filter_arrival').val();
                        // d.featured = $('#filter_featured').val();
                        d.search  =$('#dt-product-name-search').val();

                    },
                    beforeSend: function() {
                    $("body").addClass("loading");
                    },
                    complete: function(){
                        $("body").removeClass("loading");
                    },

                },

            columns: [
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'state', name: 'state'},
                {data: 'is_featured', name: 'is_featured'},
                {data: 'is_new_arrival', name: 'is_new_arrival'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        //check exists or not product list
        table.on('draw', function () {
                /* Now you can count rows */
                // setTimeout(function () {
                    var isEmpty = table.rows().count() === 0;
                    if (isEmpty)
                    {
                         $('.not-exists-seller-product-list').show();
                         $('.exists-seller-product-list').hide();
                    }
                    else
                    {
                        $('.not-exists-seller-product-list').hide();
                        $('.exists-seller-product-list').show();
                    }
                //  }, 1000);

        });
        //filter
        $(document).on( 'keyup','#dt-product-name-search', function () {
            table.draw();
             table.on('draw', function () {
                    var isEmpty = table.rows().count() === 0;
                    if (isEmpty)
                    {
                         $('.not-exists-seller-product-list').hide();
                         $('.exists-seller-product-list').show();
                    }

                });
        });
        $(document).on('change', '#filter_state, #filter_product_type',
            function () {
                table.ajax.reload();
                table.on('draw', function () {
                    var isEmpty = table.rows().count() === 0;
                    if (isEmpty)
                    {
                         $('.not-exists-seller-product-list').hide();
                         $('.exists-seller-product-list').show();
                    }

                });

        });

    });

    //add seller product
    //edit ready stock color size counting
    $(document).on('input','.add-color-sizes tr',function(){
        var tot=0;
        $('.add-color-sizes tr').each(function(){
            var inputs = $(this).find('input');
            inputs.each(function(){
             tot+=Number($(this).val()) || 0; // parse and add value, if NaN then add 0
            });
        });
        $('#ready_stock_availability').val(tot);
    });
    //edit ready stock color size counting
    $(document).on('input','.edit-color-sizes tr',function(){
        var tot=0;
        $('.edit-color-sizes tr').each(function(){
            var inputs = $(this).find('input');
            inputs.each(function(){
             tot+=Number($(this).val()) || 0;
            });
        });
        $('#edit_ready_stock_availability').val(tot);
    });

    //non clothing colorattr counting
    $(document).on('input','.non-clothing-color-quantity-table-block tr',function(){
        var tot=0;
        $('.non-clothing-color-quantity-table-block tr').each(function(){
            var inputs = $(this).find('input');
            inputs.each(function(){
            tot+=Number($(this).val()) || 0; // parse and add value, if NaN then add 0
            });
        });
        $('#non_clothing_availability').val(tot);
    });
   //edit non clothing attr counting
    $(document).on('input','.edit-non-clothing-attr-counting tr',function(){
        var tot=0;
        $('.edit-non-clothing-attr-counting tr').each(function(){
            var inputs = $(this).find('input');
            inputs.each(function(){
            tot+=Number($(this).val()) || 0; // parse and add value, if NaN then add 0
            });
        });
        $('#edit_non_clothing_availability').val(tot);
    });
    //store seller product
    $('#seller_product_form').on('submit',function(e){
            e.preventDefault();
            tinyMCE.triggerSave();
            var formData = new FormData(this);
            var url = '{{ route("seller-product.store") }}';
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: url,
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        swal("Done!", data.msg,"success");
                        $('.fresh-rtd-attr').show();
                        $('.stock-rtd-attr').hide();
                        $('#seller_product_form')[0].reset();
                        $("#product-add-modal-block table").find("tr:not(:nth-child(1))").remove();
                        // $('.modal-close').click();
                        $("#product-add-modal-block").modal('close');
                        $('#category_id').val('');
                        $('#category_id').trigger('change');
                        $('#errors').empty();
                        // $('.image-uploader').removeClass('has-files');
                        // $('.image-uploader .uploaded').html('');
                        $('.input-images-1').html('');
                        $('.input-images-1').imageUploader();
                        var table = $('#seller-product-datatable').DataTable();
                        table.ajax.reload();
                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#errors').empty();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }
            });
        });


    //edit seller product

    $(document).on('click', '.seller-edit-product',function(){

        var sku=$(this).attr('id');
        var url = '{{ route("seller-product.edit", ":slug") }}';
            url = url.replace(':slug', sku);
        $.ajax({
                method: 'get',
                processData: false,
                contentType: false,
                cache: false,
                url: url,
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        //console.log(data);
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#product-edit-modal-block').modal('open');
                        $('.edit-image-block .input-images-2').html('');
                        $('#edit_category_id').val(data.product.product_category_id);
                        $('#edit_category_id').trigger('change');
                        $('.product_unit').val(data.product.product_unit);
                        $('.product_unit').trigger('change');

                        var preloaded=data.product_image;
                        $('.edit-image-block .input-images-2').imageUploader({
                            preloaded:preloaded
                        });
                        $('#p-edit-name').val(data.product.name);
                        $('input[name=seller_p_edit_sku]').val(data.product.sku);
                        $('input[name=p_type]').val(data.product.product_type);

                        if(data.product.is_new_arrival==1){
                            $('#product-edit-modal-block .edit_is_new_arrival').prop('checked', true);
                        }
                        else{
                            $('#product-edit-modal-block .edit_is_new_arrival').prop('checked', false);
                        }
                        if(data.product.is_featured==1){
                            $('#product-edit-modal-block .edit_is_featured').prop('checked', true);
                        }
                        else{
                            $('#product-edit-modal-block .edit_is_featured').prop('checked', false);
                        }
                        if(data.product.state==1){
                            $('#product-edit-modal-block .edit_published').prop('checked', true);
                        }
                        else{
                            $('#product-edit-modal-block .edit_published').prop('checked', false);
                        }

                        //related products
                        $("#product-edit-modal-block .js-example-basic-multiple").val(null).trigger('change');
                        $('#product-edit-modal-block input[name=rel-products]').prop('checked', false);
                        $('#product-edit-modal-block .related-product').hide();
                        if(data.related_products.length != 0){
                            $('#product-edit-modal-block input[name=rel-products]').prop('checked', true);
                            $('#product-edit-modal-block .related-product').show();
                            $.ajax({
                                method: 'get',
                                processData: false,
                                contentType: false,
                                cache: false,
                                url: "{{route('users.related.products')}}",
                                success:function(data)
                                    {
                                        $('#product-edit-modal-block .js-example-basic-multiple').html('');
                                        $.each(data, function(key, value){
                                        $('#product-edit-modal-block .js-example-basic-multiple').append('<option value="'+value.id+'">'+value.name+'</option>')
                                        });

                                    },
                                error: function(xhr, status, error)
                                    {
                                        $('#edit_errors').empty();
                                        $("#edit_errors").append("<li class='alert alert-danger'>"+error+"</li>");

                                    }
                            });
                            $(document).ajaxComplete(function(){
                            $('#product-edit-modal-block .js-example-basic-multiple').select2().val(data.related_products).trigger('change');
                            });

                        }
                        //end related product
                        $('#product-edit-modal-block input[name=copyright_price]').val('');
                        if(data.product.copyright_price != null)
                        {
                            $('#product-edit-modal-block input[name=copyright_price]').val(data.product.copyright_price);
                        }
                        if(data.product.product_type==1){
                            $("#p-type-fresh").prop('checked', true);
                            $('.fresh-rtd-attr').show();
                            $('.ready-rtd-attr').hide();
                            $('.edit-non-clothing-item-block').hide();
                            $(".fresh-attr-tbody").html('');
                            $('#product-edit-modal-block .moq-unit-block').show();
                            $.each(data.attr, function (key, item)
                            {
                                var html='<tr><td data-title="Qty Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="'+item[0]+'" placeholder="Min. Value"></td><td data-title="Qty Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="'+item[1]+'" placeholder="Max. Value"></td> <td data-title="Price (usd)"><input name="price[]" id="price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="'+item[2]+'" placeholder="$" ></td><td data-title="Lead Time (days)"><input name="lead_time[]"  id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror"  value="'+item[3]+'" placeholder="Days"></td><td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeFreshOrderAttribute(this)"><i class="material-icons dp48">remove</i></a></td></tr>';
                                $(".fresh-attr-tbody").append(html);
                            });

                            if(data.product.customize == true){
                                $('#product-edit-modal-block input[name=customize]').prop('checked', true);
                            }else{
                                $('#product-edit-modal-block input[name=customize]').prop('checked', false);
                            }

                        }
                        else if(data.product.product_type==2)
                        {
                            $("#p-type-ready").prop('checked', true);
                            $('.fresh-rtd-attr').hide();
                            $('.edit-non-clothing-item-block').hide();
                            $('.ready-rtd-attr').show();
                            $('#edit_ready_stock_availability').val(data.product.availability)
                            $(".ready-attr-tbody").html('');
                            $.each(data.attr, function (key, item)
                            {
                                var html='<tr><td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="'+item[0]+'" placeholder="Min. Value"></td><td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="'+item[1]+'" placeholder="Max. Value"></td><td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="'+item[2]+'" placeholder="$" ></td><td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeReadyOrderAttribute(this)"><i class="material-icons dp48">remove</i></a></td></tr>';
                                $(".ready-attr-tbody").append(html);
                            });
                            $(".ready-attr-tbody-colors-sizes").html('');
                            $.each(data.colors_sizes, function (key,item)
                            {
                                var html= '<tr>';
                                    html+='<td data-title="Color"><div class="autocomplete"><input type="text" value="'+item.color+'" class="form-control" id="predefind-colors" name="color_size[color][]" /></div></td>';
                                    html+='<td data-title="XXS"><input type="text" value="'+item.xxs+'" class="form-control " name="color_size[xxs][]" /></td>';
                                    html+='<td data-title="XS"><input type="text" value="'+item.xs+'" class="form-control " name="color_size[xs][]" /></td>';
                                    html+='<td data-title="Small"><input type="text" value="'+item.small+'" class="form-control " name="color_size[small][]" /></td>';
                                    html+='<td data-title="Medium"><input type="text" value="'+item.medium+'" class="form-control " name="color_size[medium][]" /></td>';
                                    html+='<td data-title="Large"><input type="text" value="'+item.large+'" class="form-control " name="color_size[large][]" /></td>';
                                    html+='<td data-title="Extra Large"><input type="text" value="'+item.extra_large+'" class="form-control " name="color_size[extra_large][]" /></td>';
                                    html+='<td data-title="XXL"><input type="text" value="'+item.xxl+'" class="form-control " name="color_size[xxl][]" /></td>';
                                    html+='<td data-title="XXXL"><input type="text" value="'+item.xxxl+'" class="form-control " name="color_size[xxxl][]" /></td>';
                                    html+='<td data-title="4XXL"><input type="text" value="'+item.four_xxl+'" class="form-control " name="color_size[four_xxl][]" /></td>';
                                    html+='<td data-title="One Size"><input type="text" value="'+item.one_size+'" class="form-control " name="color_size[one_size][]" /></td>';
                                    html+='<td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeProductColorSize(this)"><i class="material-icons dp48">remove</i></a></td>';
                                    html+='</tr>';
                                 $(".ready-attr-tbody-colors-sizes").append(html);
                            });

                            //full stock
                            if(data.product.full_stock == 1){
                                $('#product-edit-modal-block input[name=full_stock]').prop('checked', true);
                                $('#product-edit-modal-block .full-stock-price').show();
                                $('#product-edit-modal-block .ready-stock-prices-breakdown').hide();
                                $('#product-edit-modal-block .moq-unit-block').hide();
                                $('#product-edit-modal-block input[name=full_stock_price]').val(data.product.full_stock_price);

                            }
                            else{
                                $('#product-edit-modal-block input[name=full_stock]').prop('checked', false);
                                $('#product-edit-modal-block .full-stock-price').hide();
                                $('#product-edit-modal-block .ready-stock-prices-breakdown').show();
                                $('#product-edit-modal-block .moq-unit-block').show();
                            }
                            if(data.product.full_stock_negotiable == true){
                                $('#product-edit-modal-block input[name=ready_full_stock_negotiable]').prop('checked', true);
                                $('#product-edit-modal-block input[name=full-stock-price-block]').hide();
                            }else
                            {
                                $('#product-edit-modal-block input[name=ready_full_stock_negotiable]').prop('checked', false);
                                $('#product-edit-modal-block input[name=full-stock-price-block]').show();
                            }

                        }
                        else{
                            $("#p-type-non-clothing").prop('checked', true);
                            $('.fresh-rtd-attr').hide();
                            $('.ready-rtd-attr').hide();
                            $('.edit-non-clothing-item-block').show();
                            $('#edit_non_clothing_availability').val(data.product.availability);
                            //color quantity
                            $(".non-clothing-color-quantity-tbody").html('');
                            $.each(data.colors_sizes, function (key, item)
                            {
                                var html = '<tr>';
                                    html += '<td data-title="Color"><input type="text" value="'+item.color+'" class="form-control" name="non_clothing_attr[color][]" /></td>';
                                    html += '<td data-title="Quantity"><input type="text" value="'+item.quantity+'" class="form-control check-price-range-value" name="non_clothing_attr[quantity][]" /></td>';
                                    html += '<td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeNonClothingAttr(this)"><i class="material-icons dp48">remove</i></a></td>';
                                    html += '</tr>';

                                $(".non-clothing-color-quantity-tbody").append(html);
                            });

                            //price break down
                            $(".edit-non-clothing-prices-breakdown-tbody").html('');
                            $.each(data.attr, function (key, item)
                            {
                                var html = '<tr>';
                                    html += '<td data-title="Qty Min"><input  name="non_clothing_min[]"  type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="'+item[0]+'" placeholder="Min. Value"></td>';
                                    html += '<td data-title="Qty Max"><input  name="non_clothing_max[]"  type="text" class="form-control check-price-range-value @error('quantity') is-invalid @enderror"  value="'+item[1]+'" placeholder="Max. Value"></td>';
                                    html += '<td data-title="Price (usd)"><input  name="non_clothing_price[]" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="'+item[2]+'" placeholder="$"></td>';
                                    html += '<td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeNonClothingPriceBreakDown(this)"><i class="material-icons dp48">remove</i></a></td>';
                                    html += '</tr>';
                                $(".edit-non-clothing-prices-breakdown-tbody").append(html);
                            });

                            //full stock
                            if(data.product.full_stock == 1){
                                $('#product-edit-modal-block input[name=non_clothing_full_stock]').prop('checked', true);
                                $('#product-edit-modal-block .non-clothing-full-stock-price').show();
                                $('#product-edit-modal-block .non-clothing-prices-breakdown').hide();
                                $('#product-edit-modal-block .moq-unit-block').hide();
                                $('#product-edit-modal-block input[name=non_clothing_full_stock_price').val(data.product.full_stock_price);
                            }
                            else{
                                $('#product-edit-modal-block input[name=non_clothing_full_stock]').prop('checked', false);
                                $('#product-edit-modal-block .non-clothing-full-stock-price').hide();
                                $('#product-edit-modal-block .non-clothing-prices-breakdown').show();
                                $('#product-edit-modal-block .moq-unit-block').show();
                            }
                            if(data.product.full_stock_negotiable == true){
                                $('#product-edit-modal-block input[name=non_clothing_full_stock_negotiable]').prop('checked', true);
                                $('#product-edit-modal-block .non-clothing-full-stock-price-block').hide();

                            }
                            else{
                                $('#product-edit-modal-block input[name=non_clothing_full_stock_negotiable]').prop('checked', false);
                                $('#product-edit-modal-block .non-clothing-full-stock-price-block').show();
                            }

                        }
                        $('.minimun-order-qty').val(data.product.moq);
                        tinymce.get("edit-description").setContent(data.product.description);
                        tinymce.get("edit-additional-description").setContent(data.product.additional_description);





                        $(".edit-image-preview").slick({
                            dots: false,
                            infinite: false,
                            speed: 500,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        });


                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#errors').empty();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });

                    }
            });
    });

    //update seller product
    $('#seller_product_form_update').on('submit',function(e){
            e.preventDefault();
            tinyMCE.triggerSave();
            var sku=$('input[name=seller_p_edit_sku]').val();
            var url = '{{ route("seller-product.update", ":slug") }}';
                url = url.replace(':slug', sku);
            var formData = new FormData(this);
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: url,
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        swal("Done!", data.msg,"success");
                        var preloaded=[];
                        $('.edit-image-block .input-images-2').imageUploader({
                            preloaded:preloaded
                        });
                        $('#edit_errors').empty();
                        $('#seller_product_form_update')[0].reset();
                        $('#select2-category_id-ca-container').html('');
                        // $('.modal-close').click();
                        $('#product-edit-modal-block').modal('close');
                        var table = $('#seller-product-datatable').DataTable();
                        table.ajax.reload();

                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#edit_errors').empty();
                        $("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div></div>");
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div></div>");
                        });

                    }
            });
        });


     //seller delete product
    // $(document).on('click', '.seller-delete-prodcut',function(){
    //     var sku=$(this).attr('id');
    //     // if(!confirm('Are You Want to Delete?')){return false;}
    //     var url = '{{ route("seller-product.destroy", ":slug") }}';
    //         url = url.replace(':slug', sku);
    //     swal({
    //         title: "Want to delete this product ?",
    //         text: "Please ensure and then confirm!",
    //         type: "warning",
    //         showCancelButton: !0,
    //         confirmButtonText: "Yes, delete it!",
    //         cancelButtonText: "No, cancel!",
    //         reverseButtons: !0
    //     }).then(function (e) {
    //         if (e.value === true) {
    //             $.ajax({
    //                 url: url,
    //                 type: "DELETE",
    //                 data: {"_token": "{{ csrf_token() }}"},
    //                 success:function(data)
    //                     {
    //                     toastr.success(data.msg);
    //                     var table = $('#seller-product-datatable').DataTable();
    //                         table.ajax.reload();

    //                     },
    //                     error: function(xhr, status, error)
    //                         {
    //                             toastr.success(error);
    //                         }
    //                 });
    //             }
    //         else {
    //             e.dismiss;
    //         }
    //     }, function (dismiss) {
    //         return false;
    //     })
    // });

    //seller publish unpublish product
    $(document).on('click', '.seller-publish-unpublish-prodcut',function(){
        var sku=$(this).attr('id');
        var status = $(this).attr('data-status');
        // if(!confirm('Are You Want to Delete?')){return false;}
        var url = '{{ route("seller.product.publish.unpublish", ":slug") }}';
            url = url.replace(':slug', sku);
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
                        success:function(data)
                            {
                                swal("Done!", data.msg,"success");
                                var table = $('#seller-product-datatable').DataTable();
                                table.ajax.reload();

                            },
                            error: function(xhr, status, error)
                            {
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
                        success:function(data)
                            {
                                swal("Done!", data.msg,"success");
                                var table = $('#seller-product-datatable').DataTable();
                                table.ajax.reload();

                            },
                            error: function(xhr, status, error)
                            {
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

    });

    //toggle product type
    $('input[type=radio][name=product_type]').change(function() {
            //buy design
            if (this.value == '1') {
                $('.stock-rtd-attr').hide();
                $('.non-clothing-block').hide();
                $('.fresh-rtd-attr').show();
                $('#product-add-modal-block .moq-unit-block').show();
                $('#product-add-modal-block input[name=full_stock]').prop('checked', false);
            }
            //ready stock
            else if(this.value == '2') {
                $('.stock-rtd-attr').show();
                $('.fresh-rtd-attr').hide();
                $('.non-clothing-block').hide();
                //'#product-add-modal-block input[name=full_stock]').prop("checked")
                if($('#product-add-modal-block input[name=full_stock]').prop("checked") == true){
                    $('#product-add-modal-block .full-stock-price').show();
                    $('#product-add-modal-block .ready-stock-prices-breakdown').hide();
                    $('#product-add-modal-block .moq-unit-block').hide();
                }
                else {
                    $('#product-add-modal-block .full-stock-price').hide();
                    $('#product-add-modal-block .ready-stock-prices-breakdown').show();
                    $('#product-add-modal-block .moq-unit-block').show();
                }

            }
           //non clothing item
            else if(this.value == '3') {
                $('.stock-rtd-attr').hide();
                $('.fresh-rtd-attr').hide();
                $('.non-clothing-block').show();
                //'#product-add-modal-block input[name=full_stock]').prop("checked")
                if($('#product-add-modal-block input[name=full_stock]').prop("checked") == true){
                    $('#product-add-modal-block .full-stock-price').show();
                    $('#product-add-modal-block .non-clothing-prices-breakdown').hide();
                    $('#product-add-modal-block .moq-unit-block').hide();
                }
                else {
                    $('#product-add-modal-block .full-stock-price').hide();
                    $('#product-add-modal-block .non-clothing-prices-breakdown').show();
                    $('#product-add-modal-block .moq-unit-block').show();
                }

            }


    });

   //image upload script
   $(function(){
     $('.input-images-1').imageUploader();
    });

   //related products
   $(document).on('change','input[name=rel-products]',function(){
        if ($(this).prop("checked") == true) {
            $('.related-product').show();
            $.ajax({
                method: 'get',
                processData: false,
                contentType: false,
                cache: false,
                url: "{{route('users.related.products')}}",
                success:function(data)
                    {
                        $('.js-example-basic-multiple').html('');
                        $.each(data, function(key, value){
                           $('.js-example-basic-multiple').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });

                    },
                error: function(xhr, status, error)
                    {
                        $('#edit_errors').empty();
                        $("#edit_errors").append("<li class='alert alert-danger'>"+error+"</li>");

                    }
            });
        }
        else{
            $('.related-product').hide();
        }
   });


   //check notificaiton for product availability
   $(document).on("click", ".notification_identifier" , function() {
    var notificationId =$(this).attr("data-notification-id") ;
    // $(this).parent().parent().remove();
    $(this).parent().remove();
    $.ajax({
        type:'GET',
        url: "{{route('notification-mark-as-read')}}",
        dataType:'json',
        data:{ notificationId :notificationId},
        success: function(data){
            //$(obj).empty();
                //$('.orderApprovedCount').html(data.newOrderApprovedNotificationCount);
                $('#noOfNotifications').html(data.noOfnotification);
        }
    });

});


//full stock
$(document).on("click", "input[name=full_stock]", function(){
    if($(this).prop("checked") == true){
       $('.full-stock-price').show();
       $('.ready-stock-prices-breakdown').hide();
       $('.moq-unit-block').hide();
    }
    else if($(this).prop("checked") == false){
       $('.full-stock-price').hide();
       $('.ready-stock-prices-breakdown').show();
       $('.moq-unit-block').show();
    }
});
//full stock negotiable
$(document).on("click", "input[name=ready_full_stock_negotiable]", function(){
    if($(this).prop("checked") == true){
       $('.full-stock-price-block').hide();
    }
    else if($(this).prop("checked") == false){
        $('.full-stock-price-block').show();
    }
});

//non clothing full stock
$(document).on("click", "input[name=non_clothing_full_stock]", function(){
    if($(this).prop("checked") == true){
       $('.non-clothing-full-stock-price').show();
       $('.non-clothing-prices-breakdown').hide();
       $('.moq-unit-block').hide();
    }
    else if($(this).prop("checked") == false){
       $('.non-clothing-full-stock-price').hide();
       $('.non-clothing-prices-breakdown').show();
       $('.moq-unit-block').show();
    }
});

//non clothing negotiable
$(document).on("click", "input[name=non_clothing_full_stock_negotiable]", function(){
    if($(this).prop("checked") == true){
       $('.non-clothing-full-stock-price-block').hide();
    }
    else if($(this).prop("checked") == false){
        $('.non-clothing-full-stock-price-block').show();
    }
});
// Prevent jQuery UI dialog from blocking focusin
$(document).on('focusin', function(e) {
  if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
    e.stopImmediatePropagation();
  }
});
//select 2 for product unit
// $("#product-add-modal-block .product_unit").select2({
//     placeholder: "Select a Unit",
//     allowClear: true
// });

//tiny mc if file not updoaded then check to remove it
$(document).on('click', '.btn-back-to-product-list', function (e) {
    e.preventDefault();
    $.ajax({
        type:'GET',
        url: '/tinymc-untracked-file-delete',
        dataType:'json',
        success: function(data){
          console.log(data)
        }
    });
});

</script>

@endpush
