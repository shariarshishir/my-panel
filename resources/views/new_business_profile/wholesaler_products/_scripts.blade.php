@push('js')
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    var productFirstHtml = '<tr>';
    productFirstHtml += '<td data-title="Image" class="uploadOverlayImage">';
    productFirstHtml += '<div id="addImage">';
    productFirstHtml += '<div class="overlay-addImage-preview-block">';
    productFirstHtml += '<img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png" id="overlayImage" class="overlay-addImage-preview" alt="preview image">';
    productFirstHtml += '</div>';
    productFirstHtml += '<input type="hidden" name="productImg[product_image_id][]" />';
    productFirstHtml += '<div class="file-field uplodad_file_button_wrap">';
    productFirstHtml += '<div class="btn">';
    productFirstHtml += '<i class="material-icons">file_upload</i>';
    productFirstHtml += '<input class="overlay-add-image" id="productaddImage" type="file" name="productImg[product_add_image][]" />';
    productFirstHtml += '</div>';
    productFirstHtml += '</div>';
    productFirstHtml += '</div>';
    productFirstHtml += '</td>';
    productFirstHtml += '<td data-title="Image Label" class="uploadImageLabel"><input type="text" name="productImg[product_image_label][]" /></td>';
    productFirstHtml += '<td data-title="Is Accessories" class="uploadImageAccessories">';
    productFirstHtml += '<label>';
    productFirstHtml += '<input class="is_accessories_checked" type="checkbox" />';
    productFirstHtml += '<span></span>';
    productFirstHtml += '<input type="hidden" name="productImg[product_image_is_accessories][]" class="is_accessories_checked_value" value="no" />';
    productFirstHtml += '</label>';
    productFirstHtml += '</tr>';

    $('.product-add-modal-trigger').click(function(){
        $("#product-add-modal-block").modal('open');
        $('.fresh-rtd-attr').show();
        $('.stock-rtd-attr').hide();
        $('.non-clothing-block').hide();
        $('#seller_product_form')[0].reset();
        $("#product-add-modal-block table").find("tr:not(:nth-child(1))").remove();
        $('#product_tag').val('');
        $('#product_tag').trigger('change');
        $('#errors').empty();
        // $('.image-uploader').removeClass('has-files');
        // $('.image-uploader .uploaded').html('');

        //$('.input-images-1').html('');
        //$('.input-images-1').imageUploader();

        $('.full-stock-price').hide();
        $('.non-clothing-full-stock-price').hide();
        $('.ready-stock-prices-breakdown').show();
        $('#product-add-modal-block .product_unit').val('');
        //$(".product_upload_update_table tbody").html('');
        $('.product_upload_update_table tbody').html(productFirstHtml);
        $('#product-add-modal-block .product_unit').trigger('change');
        $('.error-rm').html('');
        $('.select2').val('');
        $('.select2').trigger('change');
        $('.studio').hide();
        $('.raw-materials').hide();
        $('#product-add-modal-block .overlay-image-preview').attr("src", 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
    })


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

    var price_breakdown_array=['quantity_min','quantity_max','price','lead','ready_quantity_min','ready_quantity_max','ready_price','non_clothing_min','non_clothing_max','non_clothing_price',];
    //store seller product
    $('#seller_product_form').on('submit',function(e){
            e.preventDefault();
            tinyMCE.triggerSave();
            var formData = new FormData(this);
            var url = '{{ route("wholesaler.product.store") }}';
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
                        $('#errors').empty();
                        // $('.image-uploader').removeClass('has-files');
                        // $('.image-uploader .uploaded').html('');

                        // $('.input-images-1').html('');
                        // $('.input-images-1').imageUploader();

                        location.reload();
                        // var table = $('#seller-product-datatable').DataTable();
                        // table.ajax.reload();
                    },
                error: function(xhr, status, error)
                    {
                       console.log(xhr.responseJSON.error);

                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#errors').empty();
                        $('#errors').show();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>");
                        $('.error-rm').html('');
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $.each(price_breakdown_array, function(k,array_item){
                                priceBreakDownValidation(key, array_item);
                            });

                            $('.'+key+'_error').html('required');

                            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }
            });
        });

      function priceBreakDownValidation(errorItem , compareItem ){
            if(compareItem == 'lead'){
                if(errorItem.split('_')[0] == compareItem){
                    var key = errorItem.split('.')[1];
                    $('.'+compareItem+'_'+key+'_error').html('required');
                }
            }else{
                if(errorItem.split('.')[0] == compareItem){
                    var key = errorItem.split('.')[1];
                    $('.'+compareItem+'_'+key+'_error').html('required');
                }
            }

      }
    //edit seller product

    function editproduct(sku){
        var sku=sku;
        var url = '{{ route("wholesaler.product.edit", ":slug") }}';
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
                        console.log(data.product.images);

                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#product-edit-modal-block').modal('open');
                        $('.error-rm').html('');
                        $('#edit_errors').empty();
                        $('.edit-image-block .input-images-2').html('');
                        $('#edit_product_tag').val(data.product.product_tag ?? '');
                        $('#edit_product_tag').trigger('change');
                        $('.product_unit').val(data.product.product_unit);
                        $('.product_unit').trigger('change');
                        $(".product_upload_update_table tbody").html('');
                        //product type mapping
                        $('#product-edit-modal-block .product_type_select').val(data.product.product_type_mapping_id).trigger('change');
                        if(data.product.product_type_mapping_id != null){
                            if(data.product.product_type_mapping_id ==1){
                                $('.studio').show();
                                $('.raw-materials').hide();
                                $("#studio-checked").prop('checked', true);
                                $('.studio-id').val(data.product.product_type_mapping_child_id).trigger('change');
                            }else{
                                $('.studio').hide();
                                $('.raw-materials').show();
                                $("#raw-materials-checked").prop('checked', true);
                                $('.raw-materials-id').val(data.product.product_type_mapping_child_id).trigger('change');
                            }
                        }else{
                            $('.studio').hide();
                            $('.raw-materials').hide();
                            $('#product-edit-modal-block select[name=product_type_mapping]').prop('selected', false);
                        }

                        if(data.product.overlay_original_image){
                            var src='{{Storage::disk('s3')->url('public')}}'+'/'+data.product.overlay_original_image;
                            $('#product-edit-modal-block .overlay-image-preview').attr("src", src);
                            const overlay_image_delete_button='<a href="javascript:void(0);" class="btn_delete" onclick="removeWholesalerOverlayImage('+data.product.id+');"><i class="material-icons">highlight_off</i></a>';
                            $('#product-edit-modal-block .remove-overlay-image').html(overlay_image_delete_button);
                        }else{
                            $('#product-edit-modal-block .remove-overlay-image').html('');
                            $('#product-edit-modal-block .overlay-image-preview').attr("src", 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
                        }

                        //image
                        $.each(data.product.images, function (key, item)
                        {
                            var asset='{{Storage::disk('s3')->url('public')}}'+'/'+item.image;
                            var label;
                            var isRawMaterial;

                            if(item.image_label == null){
                                label = '';
                            }else{
                                label= item.image_label;
                            }


                            //     if(item.is_raw_material==1){
                            //     $('#product-edit-modal-block .is_accessories_checked').prop('checked', true);
                            // }
                            // else{
                            //     $('#product-edit-modal-block .edit_is_new_arrival').prop('checked', false);
                            // }


                            if(item.is_raw_materials == 1){
                                isRawMaterial = 'checked';
                            }else{
                                isRawMaterial= '';
                            }
                            var html = '<tr>';
                            html += '<td data-title="Image" class="uploadOverlayImage">';
                            html += '<div id="addImage">';
                            html += '<div class="overlay-addImage-preview-block">';
                            html += '<img src="'+asset+'" id="overlayImage" class="overlay-addImage-preview" alt="preview image">';
                            html += '</div>';
                            html += '<input type="hidden" name="productImg[product_image_id][]" value="'+item.id+'" />';
                            html += '<div class="file-field uplodad_file_button_wrap">';
                            html += '<div class="btn">';
                            html += '<i class="material-icons">file_upload</i>';
                            html += '<input class="overlay-add-image" id="productaddImage" type="file" name="productImg[product_add_image][]" />';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</td>';
                            html += '<td data-title="Image Label" class="uploadImageLabel"><input type="text" value="'+label+'" name="productImg[product_image_label][]" /></td>';
                            html += '<td data-title="Is Accessories" class="uploadImageAccessories">';
                            html += '<label>';
                            html += '<input class="is_accessories_checked" type="checkbox" '+isRawMaterial+' />';
                            html += '<span></span>';
                            html += '<input type="hidden" name="productImg[product_image_is_accessories][]" class="is_accessories_checked_value" value="'+isRawMaterial+'" />';
                            html += '</label>';
                            html += '<a class="btn_delete" href="javascript:void(0);" onclick="removeProductRow(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span</a></td>';
                            html += '</tr>';
                            $(".product_upload_update_table tbody").append(html);
                        });

                        // video
                        $('#product-edit-modal-block input[name=remove_video_id]').val('');
                        $('#product-edit-modal-block .edit-video-upload-block').show();
                        $('#product-edit-modal-block .edit-video-show-block').html('');
                        $('#product-edit-modal-block .edit-video-show-div').hide();
                        if(data.product.video){
                                $('#product-edit-modal-block .edit-video-upload-block').hide();
                                $('#product-edit-modal-block .edit-video-show-div').show();
                                var asset='{{Storage::disk('s3')->url('public')}}'+'/'+data.product.video.video;
                                var html='<video id="edit-video" controls autoplay width="320" height="240">';
                                    html+='<source src="'+asset+'" />';
                                    html+='</video>';
                                    html+=' <div class="file-field uplodad_file_button_wrap">';
                                    html+='<div class="btn">';
                                    html+=' <span>Upload Video</span>';
                                    html+='<input id="edit-uploadVideo" accept="video/*" class="uplodad_video_box" type="file" name="video">';
                                    html+='</div>';
                                    html+='</div>';
                                    html+='<a class="btn_delete" onclick="wholesalerRemoveEditVideoEl('+data.product.id+');" data-id="'+data.product.video.id+'"><i class="material-icons">highlight_off</i></a>';

                                $('#product-edit-modal-block .edit-video-show-block').append(html);
                        }

                        $('#product-edit-modal-block .product_type_order').val(data.product.product_type_mapping_id).trigger('change');
                        $('#product-edit-modal-block .product_type_gender').val(data.product.gender).trigger('change');
                        $("#product-edit-modal-block select[name=gender][value=" + data.product.gender + "]").prop('selected', true);
                        $('#product-edit-modal-block .type_sample_availability').val(data.product.sample_availability).trigger('change');
                        $("#product-edit-modal-block select[name=sample_availability][value=" + data.product.sample_availability + "]").prop('selected', true);

                        $('#product-edit-modal-block .free_to_show_yes').val(data.product.free_to_show).trigger('change');
                        $("#product-edit-modal-block select[name=free_to_show][value=" + data.product.free_to_show + "]").prop('selected', true);

                        var preloaded=data.product_image;
                        $('.edit-image-block .input-images-2').imageUploader({
                            preloaded:preloaded
                        });
                        $('#p-edit-name').val(data.product.name);
                        $('#p-edit-code').val(data.product.product_code);
                        $('input[name=seller_p_edit_sku]').val(data.product.sku);
                        $('input[name=p_type]').val(data.product.product_type);
                        //gender
                        if(data.product.gender ){
                            if(data.product.gender == 1){
                                $("#gender_male").prop('selected', true);
                            }else if(data.product.gender == 2){
                                $("#gender_female").prop('selected', true);
                            }else if(data.product.gender == 3){
                                $("#gender_unisex").prop('selected', true);
                            }

                        }else{
                            $('#product-edit-modal-block select[name=gender]').prop('selected', false);
                        }

                        //sample_availability
                        if(data.product.sample_availability == 1){
                            $('#product-edit-modal-block #sample_availability_yes').prop('selected', true);
                        }else{
                            $('#product-edit-modal-block #sample_availability_no').prop('selected', true);
                        }

                        if(data.product.free_to_show == 1){
                            $('#product-edit-modal-block #free_to_show_yes').prop('selected', true);
                        }else{
                            $('#product-edit-modal-block #free_to_show_no').prop('selected', true);
                        }

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
                            var business_profile_id='{{$business_profile->id}}';
                            var url = '{{ route("users.related.products", ":business_profile_id") }}';
                            url = url.replace(':business_profile_id', business_profile_id);
                            $.ajax({
                                method: 'get',
                                processData: false,
                                contentType: false,
                                cache: false,
                                url: url,
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
                                var html='<tr><td data-title="Qty Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror" value="'+item[0]+'" placeholder="Min. Value"><span class="quantity_min_'+key+'_error text-danger error-rm"></span></td><td data-title="Qty Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="'+item[1]+'" placeholder="Max. Value"><span class="quantity_max_'+key+'_error text-danger error-rm"></span></td> <td data-title="Price (usd)"><input name="price[]" id="price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="'+item[2]+'" placeholder="$" ><span  class="price_'+key+'_error text-danger error-rm"></span></td><td data-title="Lead Time (days)"><input name="lead_time[]"  id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror"  value="'+item[3]+'" placeholder="Days"><span  class="lead_'+key+'_error text-danger error-rm"></span></td><td><a href="javascript:void(0);" class="btn_delete" onclick="removeFreshOrderAttribute(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a> </td></tr>';
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
                                var html='<tr><td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="'+item[0]+'" placeholder="Min. Value"><span class="ready_quantity_min_'+key+'_error text-danger error-rm"></span></td><td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="'+item[1]+'" placeholder="Max. Value"><span class="ready_quantity_max_'+key+'_error text-danger error-rm"></span></td><td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="'+item[2]+'" placeholder="$" ><span  class="ready_price_'+key+'_error text-danger error-rm"></span></td><td><a href="javascript:void(0);" class="btn_delete" onclick="removeReadyOrderAttribute(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td></tr>';
                                $(".ready-attr-tbody").append(html);
                            });
                            $(".ready-attr-tbody-colors-sizes").html('');
                            $.each(data.colors_sizes, function (key,item)
                            {
                                var html= '<tr>';
                                    html+='<td data-title="Color"><div class="autocomplete"><input type="text" value="'+item.color+'" class="form-control" id="predefind-colors" name="color_size[color][]" /></div></td>';
                                    html+='<td data-title="XXS"><input type="text" value="'+item.xxs+'" class="form-control negitive-or-text-not-allowed" name="color_size[xxs][]" /></td>';
                                    html+='<td data-title="XS"><input type="text" value="'+item.xs+'" class="form-control negitive-or-text-not-allowed" name="color_size[xs][]" /></td>';
                                    html+='<td data-title="Small"><input type="text" value="'+item.small+'" class="form-control negitive-or-text-not-allowed" name="color_size[small][]" /></td>';
                                    html+='<td data-title="Medium"><input type="text" value="'+item.medium+'" class="form-control negitive-or-text-not-allowed" name="color_size[medium][]" /></td>';
                                    html+='<td data-title="Large"><input type="text" value="'+item.large+'" class="form-control negitive-or-text-not-allowed" name="color_size[large][]" /></td>';
                                    html+='<td data-title="Extra Large"><input type="text" value="'+item.extra_large+'" class="form-control negitive-or-text-not-allowed" name="color_size[extra_large][]" /></td>';
                                    html+='<td data-title="XXL"><input type="text" value="'+item.xxl+'" class="form-control negitive-or-text-not-allowed" name="color_size[xxl][]" /></td>';
                                    html+='<td data-title="XXXL"><input type="text" value="'+item.xxxl+'" class="form-control negitive-or-text-not-allowed" name="color_size[xxxl][]" /></td>';
                                    html+='<td data-title="4XXL"><input type="text" value="'+item.four_xxl+'" class="form-control negitive-or-text-not-allowed" name="color_size[four_xxl][]" /></td>';
                                    html+='<td data-title="5XXL"><input type="text" value="'+item.five_xxl+'" class="form-control negitive-or-text-not-allowed" name="color_size[five_xxl][]" /></td>';
                                    html+='<td data-title="6XXL"><input type="text" value="'+item.six_xxl+'" class="form-control negitive-or-text-not-allowed" name="color_size[six_xxl][]" /></td>';
                                    html+='<td data-title="One Size"><input type="text" value="'+item.one_size+'" class="form-control negitive-or-text-not-allowed" name="color_size[one_size][]" /></td>';
                                    html+='<td><a href="javascript:void(0);" class="btn_delete" onclick="removeProductColorSize(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
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
                                    html += '<td data-title="Quantity"><input type="text" value="'+item.quantity+'" class="form-control negitive-or-text-not-allowed" name="non_clothing_attr[quantity][]" /></td>';
                                    html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeNonClothingAttr(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
                                    html += '</tr>';

                                $(".non-clothing-color-quantity-tbody").append(html);
                            });

                            //price break down
                            $(".edit-non-clothing-prices-breakdown-tbody").html('');
                            $.each(data.attr, function (key, item)
                            {
                                var html = '<tr>';
                                    html += '<td data-title="Qty Min"><input  name="non_clothing_min[]"  type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="'+item[0]+'" placeholder="Min. Value"><span class="non_clothing_min_'+key+'_error text-danger error-rm"></span></td>';
                                    html += '<td data-title="Qty Max"><input  name="non_clothing_max[]"  type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="'+item[1]+'" placeholder="Max. Value"><span class="non_clothing_max_'+key+'_error text-danger error-rm"></span></td>';
                                    html += '<td data-title="Price (usd)"><input  name="non_clothing_price[]" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="'+item[2]+'" placeholder="$"><span class="non_clothing_price_'+key+'_error text-danger error-rm"></span></td>';
                                    html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeNonClothingPriceBreakDown(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
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
                        swal('error!',status,'error');
                        // $('#errors').empty();
                        // $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        // $.each(xhr.responseJSON.error, function (key, item)
                        // {
                        //     $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        // });

                    }
            });
    };

    //update seller product
    $('#seller_product_form_update').on('submit',function(e){
            e.preventDefault();
            tinyMCE.triggerSave();
            var sku=$('input[name=seller_p_edit_sku]').val();
            var url = '{{ route("wholesaler.product.update", ":slug") }}';
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
                        // var table = $('#seller-product-datatable').DataTable();
                        // table.ajax.reload(null, false);
                        location.reload();
                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#edit_errors').empty();
                        $('#edit_errors').show();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        // $("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div></div>");
                        // $.each(xhr.responseJSON.error, function (key, item)
                        // {
                        //     $("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div></div>");
                        // });


                        $('.error-rm').html('');
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $.each(price_breakdown_array, function(k,array_item){
                                priceBreakDownValidation(key, array_item);
                            });
                            $('.'+key+'_error').html('required');

                            $("#edit_errors").append("<li class='alert alert-danger'>"+item+"</li>")
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
        var url = '{{ route("wholesaler.product.publish.unpublish", ":slug") }}';
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
        // $('input[type=radio][name=product_type]').change(function() {}
        $('select[name=product_type]').change(function() {
            //buy design
            if (this.value == '1') {
                $('.stock-rtd-attr').hide();
                $('.non-clothing-block').hide();
                $('.fresh-rtd-attr').show();
                $('#product-add-modal-block .moq-unit-block').show();
                $('#product-add-modal-block select[name=full_stock]').prop('selected', false);
            }
            //ready stock
            else if(this.value == '2') {
                $('.stock-rtd-attr').show();
                $('.fresh-rtd-attr').hide();
                $('.non-clothing-block').hide();
                //'#product-add-modal-block input[name=full_stock]').prop("checked")
                if($('#product-add-modal-block select[name=full_stock]').prop("selected") == true){
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
                if($('#product-add-modal-block select[name=full_stock]').prop("selected") == true){
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
    // $(function(){
    //     $('.input-images-1').imageUploader();
    // });

   //related products
   $(document).on('change','input[name=rel-products]',function(){
        if ($(this).prop("checked") == true) {
            var business_profile_id='{{$business_profile->id}}';
            var url = '{{ route("users.related.products", ":business_profile_id") }}';
            url = url.replace(':business_profile_id', business_profile_id);
            $('.related-product').show();
            $.ajax({
                method: 'get',
                processData: false,
                contentType: false,
                cache: false,
                url: url,
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
//    $(document).on("click", ".notification_identifier" , function() {
//         var notificationId =$(this).attr("data-notification-id") ;
//         // $(this).parent().parent().remove();
//         $(this).parent().remove();
//         $.ajax({
//             type:'GET',
//             url: '/notification-mark-as-read',
//             dataType:'json',
//             data:{ notificationId :notificationId},
//             success: function(data){
//                 //$(obj).empty();
//                     //$('.orderApprovedCount').html(data.newOrderApprovedNotificationCount);
//                     $('#noOfNotifications').html(data.noOfnotification);
//             }
//         });

//     });


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
    $business_profile_id= $('input[name=business_profile_id]').val();
    var url = '{{ route("tinymc.untracked.file.delete", ":slug") }}';
        url = url.replace(':slug', $business_profile_id);
    $.ajax({
        type:'GET',
        url: url,
        dataType:'json',
        success: function(data){
          console.log(data)
        }
    });
});

//add more video

    function wholesalerRemoveEditVideoEl(id)
    {
        // var remove_video_id=[];
        // $(el).prev('video').remove();
        // $(el).remove();
        // remove_video_id.push($(el).attr('data-id'));
        // $('#product-edit-modal-block input[name=remove_video_id]').val(JSON.stringify(remove_video_id));
        // $('#product-edit-modal-block .edit-video-upload-block').show();
        // $('#product-edit-modal-block .edit-video-show-div').hide();


        var check= confirm('are you sure?');
        if(check != true){
            return false;
        }
        var url = '{{ route("remove.wholesaler.featured.video", ":product_id") }}';
            url = url.replace(':product_id', id);
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
                $('.loading-message').html("");
                $('#loadingProgressContainer').hide();
                $('#product-edit-modal-block .edit-video-upload-block').show();
                $('#product-edit-modal-block .edit-video-show-div').hide();
            },
            error: function(xhr, status, error)
            {
                $('.loading-message').html("");
                $('#loadingProgressContainer').hide();
                alert(error + '. Please try again');
            }
        });
    }

    $(document).ready(()=>{
        $('.overlay-image').change(function(){
        var dom = $(this).parent().parent().parent().find('.overlay-image-preview');
            var obj = $(this);
            const file = this.files[0];
            console.log(file);
            if (file){
            let reader = new FileReader();
            reader.onload = function(event){

                dom.attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
            }
        });
    });

    $(document).on('change','select[name=product_type_mapping]',function(){
        if ($(this).val() == 1) {
            $('.studio').show();
            $('.raw-materials').hide();
            $('.category').hide();
        }else if ($(this).val() == 2){
            $('.studio').hide();
            $('.raw-materials').show();
            $('.category').hide();
        }else {
            $('.category').show();
        }
    });

    function removeWholesalerOverlayImage(id){
        var check= confirm('are you sure?');
        if(check != true){
            return false;
        }
        var url = '{{ route("remove.wholesaler.overlay.image", ":product_id") }}';
            url = url.replace(':product_id', id);
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
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();
                        $('#product-edit-modal-block .remove-overlay-image').html('');
                        $('#product-edit-modal-block .overlay-image-preview').attr("src", 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();
                        alert(error + '. Please try again');
                    }
            });
    }


    // $(document).ready(function (e) {
    //     $('#over-lay-image').change(function(){
    //         let reader = new FileReader();
    //         reader.onload = (e) => {
    //         $('#profile_image').attr('src', e.target.result);
    //         $('.user-block .avatar-status img').attr('src', e.target.result);
    //     }
    //     reader.readAsDataURL(this.files[0]);
    //         $('.profile-image-upload-button').show();

    //     });

    // });

</script>
<script>
    const input = document.getElementById('uplodadVideo');
    const video = document.getElementById('video');
    const videoSource = document.createElement('source');
    input.addEventListener('change', function() {
        const files = this.files || [];
        if (!files.length) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            videoSource.setAttribute('src', e.target.result);
            video.appendChild(videoSource);
            video.load();
            video.play();
        };
        reader.onprogress = function (e) {
            console.log('progress: ', Math.round((e.loaded * 100) / e.total));
        };
        reader.readAsDataURL(files[0]);
    });

    // Edit Video upload
    const editInput = document.getElementById('edit-uploadVideo');
    const editVideo = document.getElementById('edit-video');
    const editVideoSource = document.createElement('source');
    editInput.addEventListener('change', function() {
        const files = this.files || [];
        if (!files.length) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            editVideoSource.setAttribute('src', e.target.result);
            editVideo.appendChild(editVideoSource);
            editVideo.load();
            editVideo.play();
        };
        reader.onprogress = function (e) {
            console.log('progress: ', Math.round((e.loaded * 100) / e.total));
        };
        reader.readAsDataURL(files[0]);
    });
</script>

<script>
    function addNewProductImage()
    {
        let totalChild = $('.product_upload_update_table tbody').children().length;
        var html = '<tr>';
        html += '<td data-title="Image" class="uploadOverlayImage">';
        html += '<div id="addImage">';
        html += '<div class="overlay-addImage-preview-block">';
        html += '<img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png" id="overlayImage" class="overlay-addImage-preview" alt="preview image">';
        html += '</div>';
        html += '<input type="hidden" name="productImg[product_image_id][]" />';
        html += '<div class="file-field uplodad_file_button_wrap">';
        html += '<div class="btn">';
        html += '<i class="material-icons">file_upload</i>';
        html += '<input class="overlay-add-image" id="productaddImage" type="file" name="productImg[product_add_image][]" />';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</td>';
        html += '<td data-title="Image Label" class="uploadImageLabel"><input type="text" name="productImg[product_image_label][]" /></td>';
        html += '<td data-title="Is Accessories" class="uploadImageAccessories">';
        html += '<label>';
        html += '<input class="is_accessories_checked" type="checkbox" />';
        html += '<span></span>';
        html += '<input type="hidden" name="productImg[product_image_is_accessories][]" class="is_accessories_checked_value" value="no" />';
        html += '</label>';
        html += '<a class="btn_delete" href="javascript:void(0);" onclick="removeProductRow(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span</a></td>';
        html += '</tr>';
        $('.product_upload_update_table tbody').append(html);
    }


    $(document).on("change", '.overlay-add-image', function(){
    var dom = $(this).parent().parent().parent().find('.overlay-addImage-preview');
        var obj = $(this);
        const file = this.files[0];
        if (file){
        let reader = new FileReader();
        reader.onload = function(event){
            dom.attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
        }
    });

    function removeProductRow(el)
    {
        $(el).parent().parent().remove();
    }

    $(document).on("click", ".is_accessories_checked", function(){
        if($(this).is(':checked'))
        {
            $(this).closest("label").children(".is_accessories_checked_value").val('yes');
            $(this).closest("td.uploadImageAccessories").prev("td.uploadImageLabel").children("input").attr("disabled", true);
        } else {
            $(this).closest("label").children(".is_accessories_checked_value").val('no');
            $(this).closest("td.uploadImageAccessories").prev("td.uploadImageLabel").children("input").attr("disabled", false);
        }
    })


</script>

@endpush
