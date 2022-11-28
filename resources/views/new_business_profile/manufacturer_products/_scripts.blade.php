@push('js')
    <script>

   //image upload script
    // $(function(){
    //     $('.input-images-1').imageUploader();
    // });

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

    //add manufacture product modal open
    $('.product-add-modal-trigger').click(function(){
        $("#product-add-modal-block").modal('open');
        $('#manufacture-product-upload-form')[0].reset();
        $('#product_tag').val('');
        $('#product_tag').trigger('change');
        $('#colors').val('');
        $('#colors').trigger('change');
        $('#sizes').val('');
        $('#sizes').trigger('change');
        //$(".product_upload_update_table tbody").html('');
        $('.product_upload_update_table tbody').html(productFirstHtml);
        // $('.input-images-1').html('');
        // $('.input-images-1').imageUploader();
        $('.file').val('');
        $('.overlay-image').val('');
        $('.img-thumbnail').attr('src', 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
        $('#manufacture-product-upload-errors').empty();
        $('.rm-error').html('');
        $('.select2').val('');
        $('.select2').trigger('change');
        $('.studio').hide();
        $('.raw-materials').hide();
    });

    //manufacture product upload
    $('#manufacture-product-upload-form').on('submit',function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        var url = '{{ route("manufacture.product.store") }}';
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
                    $('#errors').empty();
                    $('.rm-error').html('');
                    $('#product-add-modal-block').modal('close');
                    // $('.manufacture-product-table-data').html('');
                    // $('.manufacture-product-table-data').html(data.data);
                    html= '<div class="col s6 m4 product_item_box">';
                    html+='<div class="productBox">';
                    html+='<div class="inner_productBox">';
                    html+='<a href="javascript:void(0);" onclick="editproduct('+data.data.id+')">';
                    html+='<div class="imgBox">';
                    html+='<img src="'+data.image+'">';
                    html+= '</div>';
                    html+= '<div class="products_inner_textbox">';
                    html+='<h4><span>'+data.data.title+'</span></h4>';
                    html+='<div class="row">';
                    html+='<div class="col s6">';
                    html+='<div class="product_moq">';
                    html+='MOQ: <br> <span>'+data.data.moq+'</span>';
                    html+='</div>';
                    html+='</div>';
                    html+='<div class="col s6">';
                    html+='<div class="pro_leadtime">';
                    html+='Lead Time <br> <span>'+data.data.lead_time+'</span> days';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</a>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    console.log(data);
                    $('.product-list').prepend(html);
                    // $('.input-images-1').html('');
                    // $('.input-images-1').imageUploader();
                    swal("Done!", data.msg,"success");
                },
            error: function(xhr, status, error)
                {

                    $('.loading-message').html("");
                    $('#loadingProgressContainer').hide();
                    $('#manufacture-product-upload-errors').empty();
                    $('#manufacture-product-upload-errors').show();
                    //$("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div></div>");
                    $("#manufacture-product-upload-errors").append("<div class=''>"+error+"</div>");
                    $('.rm-error').html('');
                    $.each(xhr.responseJSON.error, function (key, item)
                    {
                        $('.'+key+'_error').html('required');
                        //$("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div></div>");
                        $("#manufacture-product-upload-errors").append("<div class=''>"+item+"</div>");

                    });

                }
        });
    });

    //edit product
    function editproduct(productId)
    {
        var url = '{{ route("manufacture.product.edit", ":slug") }}';
            url = url.replace(':slug', productId);
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
                    $('#manufacture-update-errors').empty();
                    $('.rm-error').html('');
                    $('#product-edit-modal-block input[name=edit_product_id]').val(productId);
                    $('.edit-image-block .input-images-2').html('');
                    $("#product-edit-modal-block").modal('open');
                    $(".product_upload_update_table tbody").html('');
                    $('#product-edit-modal-block .overlay-image-preview').attr("src", 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
                    $('#product-edit-modal-block .overlay-image').val('');
                     if(data.product.overlay_image){
                        var src='{{Storage::disk('s3')->url('public')}}'+'/'+data.product.overlay_image;
                        $('#product-edit-modal-block .overlay-image-preview').attr("src", src);
                        const overlay_image_delete_button='<a href="javascript:void(0);" class="btn_delete" onclick="removeManufactureOverlayImage('+data.product.id+');"><i class="material-icons">highlight_off</i></a>';
                        $('#product-edit-modal-block .remove-overlay-image').html(overlay_image_delete_button);
                    }else{
                        $('#product-edit-modal-block .remove-overlay-image').html('');
                        $('#product-edit-modal-block .overlay-image-preview').attr("src", 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
                    }

                    // dd($data.product)

                    //image
                    $.each(data.product.product_images, function (key, item)
                    {
                        var asset='{{Storage::disk('s3')->url('public')}}'+'/'+item.product_image;

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

                    // $('#product-edit-modal-block .overlay-addImage-preview').attr("src", 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
                    // $('#product-edit-modal-block .overlay-add-image').val('');
                    // if(data.product.product_add_image){
                    //     var src='{{Storage::disk('s3')->url('public')}}'+'/'+data.product.product_add_image;
                    //     $('#product-edit-modal-block .overlay-addImage-preview').attr("src", src);
                    //     const overlay_image_delete_button='<a href="javascript:void(0);" class="btn_delete" onclick="removeManufactureOverlayImage('+data.product.id+');"><i class="material-icons">highlight_off</i></a>';
                    //     $('#product-edit-modal-block .remove-overlay-image').html(overlay_image_delete_button);
                    // }else{
                    //     $('#product-edit-modal-block .remove-overlay-image').html('');
                    //     $('#product-edit-modal-block .overlay-addImage-preview').attr("src", 'https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png');
                    // }


                     // video
                    $('#product-edit-modal-block input[name=remove_video_id]').val('');
                    $('#product-edit-modal-block .edit-video-show-block').empty();
                    $('#product-edit-modal-block .edit-video-upload-block').show();
                    $('#product-edit-modal-block .edit-video-show-div').hide();
                    $('#product-edit-modal-block .uplodad_video_box').val('');

                    if(data.product.product_video){
                        $('#product-edit-modal-block .edit-video-upload-block').hide();
                        $('#product-edit-modal-block .edit-video-show-div').show();
                        var asset='{{Storage::disk('s3')->url('public')}}'+'/'+data.product.product_video.video;
                        var html='<video id="edit-video" controls autoplay width="320" height="240">';
                            html+='<source src="'+asset+'" />';
                            html+='</video>';
                            html+=' <div class="file-field uplodad_file_button_wrap">';
                            html+='<div class="btn">';
                            html+=' <span>Upload Video</span>';
                            html+='<input id="edit-uploadVideo" class="uplodad_video_box" type="file" name="video">';
                            html+='</div>';
                            html+='</div>';
                            html+='<a class="btn_delete" onclick="removeEditVideoEl('+data.product.id+');" data-id="'+data.product.product_video.id+'"><i class="material-icons dp48">highlight_off</i></a>';

                        $('#product-edit-modal-block .edit-video-show-block').append(html);
                    }
                    //product type mapping
                    $('#product-edit-modal-block .product_type_select').val(data.product.product_type_mapping_id).trigger('change');
                    if(data.product.product_type_mapping_id != null){
                        $("select[name=product_type_mapping][value=" + data.product.product_type_mapping_id + "]").prop('selected', true);
                        if(data.product.product_type_mapping_id ==1){
                            $('#product-edit-modal-block .studio').show();
                            $('#product-edit-modal-block .raw-materials').hide();
                            $('.studio-id').val(data.product.product_type_mapping_child_id).trigger('change');
                        }else{
                            $('#product-edit-modal-block .studio').hide();
                            $('#product-edit-modal-block .raw-materials').show();
                            $('#product-edit-modal-block .raw-materials-id').val(data.product.product_type_mapping_child_id).trigger('change');
                        }}
                    else{
                        $('#product-edit-modal-block .studio').hide();
                        $('#product-edit-modal-block .raw-materials').hide();
                        $('#product-edit-modal-block select[name=product_type_mapping]').prop('selected', false);
                    }
                    $('#product-edit-modal-block #edit_product_tag').val(data.product.product_tag ?? '').trigger('change');
                    $('#product-edit-modal-block input[name=title]').val(data.product.title);
                    $('#product-edit-modal-block input[name=product_code]').val(data.product.product_code);
                    $('#product-edit-modal-block input[name=price_per_unit]').val(data.product.price_per_unit);
                    $('#product-edit-modal-block .price_unit').val(data.product.price_unit).change();
                    $('#product-edit-modal-block input[name=moq]').val(data.product.moq);
                    $('#product-edit-modal-block .qty_unit').val(data.product.qty_unit).trigger('change');
                    $('#product-edit-modal-block .product-colors').val(data.product.colors).trigger('change');
                    $('#product-edit-modal-block .product-sizes').val(data.product.sizes).trigger('change');
                    tinymce.get("edit-description").setContent(data.product.product_details);
                    if (data.product.product_specification != null) {
                        tinymce.get("edit_full_specification").setContent(data.product.product_specification);
                    }
                    $('#product-edit-modal-block input[name=lead_time]').val(data.product.lead_time);

                    $('#product-edit-modal-block .gender_unit').val(data.product.gender).trigger('change');
                    $("#product-edit-modal-block select[name=gender][value=" + data.product.gender + "]").prop('selected', true);
                    $('#product-edit-modal-block .sample_availability').val(data.product.sample_availability).trigger('change');
                    $("#product-edit-modal-block select[name=sample_availability][value=" + data.product.sample_availability + "]").prop('selected', true);

                    $('#product-edit-modal-block .free_to_show').val(data.product.free_to_show).trigger('change');
                    $("#product-edit-modal-block select[name=free_to_show][value=" + data.product.free_to_show + "]").prop('selected', true);



                    $('#product-edit-modal-block input[name=product_image_label]').val(data.product.product_image_label);



                    var preloaded = data.product_images;
                    console.log(preloaded);
                    $('.edit-image-block .input-images-2').imageUploader({
                        preloaded : preloaded
                    });
                    // $('.media-list').empty();
                    // $.each(data.product.product_images,function(key, item){
                    //     var html='<div class="col s6 m4 l3 center-align">';
                    //         html+='<div class="media_upload_imgbox">';
                    //         html+='<div class="media_img">';
                    //     var img_src='{{Storage::disk('s3')->url('public')}}'+'/'+item.product_image;
                    //         html+='<img src="'+img_src+'" id="img'+item.id+'" class="img-thumbnail">';
                    //         html+='</div>';
                    //         html+='<div class="clear10"></div>';
                    //         html+='<div class="col s12 input_btn_wrap">';
                    //         html+='<div id="msg"></div>';
                    //     var img_id= "'img" + item.id + "'";
                    //         html+='<input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'+img_id+')" />';
                    //         html+='<div class="input-group my-3" style="display:block;">';
                    //         html+='<input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;" />';
                    //         html+='<div class="input-group-append">';
                    //         html+='<a class="btn_delete" href="javascript:void(0);" dataid="'+item.id+'" onclick="removeManufactureImage(this);"><i class="material-icons dp48">delete_outline</i> <span>Delete</span</a>';
                    //         html+='<button type="button" class="browse btn btn-search btn-default btn-upload-wholesaler-img" style="background:#55A860; color:#fff; display:none;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                    //         html+='</div></div></div></div></div>';
                    //          //if(key == 4){return false;}
                    //         $('.media-list').append(html);
                    // });
                    // if(data.product.product_images.length < 5){
                    //     for (var i = 1; i <= (5-data.product.product_images.length); i++) {
                    //         var x = Math.floor(Math.random() * 10)+10;
                    //         var html='<div class="col s6 m4 l3 center-align">';
                    //             html+='<div class="media_upload_imgbox">';
                    //             html+='<div class="media_img">';
                    //             html+='<img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/upload_Image_file.png" id="img'+x+'" class="img-thumbnai';
                    //             html+='</div>';
                    //             html+='<div class="clear10"></div>';
                    //             html+='<div class="col s12 input_btn_wrap">';
                    //             html+='<div id="msg"></div>';
                    //         var img_id= "'img" + x + "'";
                    //             html+='<input type="file" name="product_images[]" class="file" accept="image/*" style="display:none;" onchange="readURL(this,'+img_id+')" />';
                    //             html+='<div class="input-group my-3" style="display:block;">';
                    //             html+='<input type="text" class="form-control" disabled placeholder="Upload File" id="file"  style="display:none;" />';
                    //             html+='<div class="input-group-append">';
                    //             html+='<button type="button" class="browse btn btn-search btn-default" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                    //             html+='</div></div></div></div></div>';
                    //             $('.media-list').append(html);
                    //     }
                    // }
                },
            error: function(xhr, status, error)
                {
                    $('.loading-message').html("");
                    $('#loadingProgressContainer').hide();
                    swal("Error!", status,"error");
                }
        });
    }

    function removeManufactureImage(obj){
            var check= confirm('are you sure?');
            if(check != true){
                return false;
            }
            var single_image_id= $(obj).attr('dataid');
            var url = '{{ route("remove.manufacture.single.image", ":slug") }}';
                url = url.replace(':slug', single_image_id);
            var obj=obj;
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

                        $(obj).parent().parent().parent().parent().find('.img-thumbnail').attr('src', 'https://via.placeholder.com/380');
                        var html='<button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                        $(obj).parent().parent().find('.btn-upload-wholesaler-img').show();
                        $(obj).remove();
                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        alert(error);
                    }
            });
        }

        function readURL(input,id)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                $('#'+id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $('.overlay-image').change(function(){
        var dom = $(this).parent().parent().parent().find('.overlay-image-preview');
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

        function removeEditVideoEl(id)
        {
            // var check=confirm('are you sure?');
            // if(check == false){
            //     return false;
            // }
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
            var url = '{{ route("remove.manufacture.featured.video", ":product_id") }}';
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

        $('#manufacture-product-update-form').on('submit',function(e){
                e.preventDefault();
                tinyMCE.triggerSave();
                var productId=$('#product-edit-modal-block input[name=edit_product_id]').val();
                var url = '{{ route("manufacture.product.update", ":slug") }}';
                    url = url.replace(':slug', productId);
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
                            $('#manufacture-update-errors').empty();
                            $('.rm-error').html('');
                            $('#product-edit-modal-block').modal('close');
                            swal("Done!", data.msg,"success");
                            var preloaded=[];
                            $('.edit-image-block .input-images-2').imageUploader({
                                preloaded:preloaded
                            });
                            location.reload();
                        },
                    error: function(xhr, status, error)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            $('#manufacture-update-errors').empty();
                            $('#manufacture-update-errors').show();
                            //$("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div></div>");
                            $("#manufacture-update-errors").append("<div class=''>"+error+"</div>");
                            $('.rm-error').html('');
                            $.each(xhr.responseJSON.error, function (key, item)
                            {
                                $('.'+key+'_error').html('required');
                                //$("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div></div>");
                                $("#manufacture-update-errors").append("<div class=''>"+item+"</div>");
                            });
                        }
                });
            });

        function removeManufactureOverlayImage(id){
            var check= confirm('are you sure?');
            if(check != true){
                return false;
            }
            var url = '{{ route("remove.manufacture.overlay.image", ":product_id") }}';
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
