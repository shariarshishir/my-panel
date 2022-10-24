@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.sample-images').imageUploader({
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'product_images',
                label : 'Drag and Drop / click here to upload your samples. Size not more than 25 MB.'
            });
        })

        var errCount = 0;
        function errorCheckValidation(fieldName)
        {
            if ($(fieldName).val()=="")
            {
                errCount++;
                $(fieldName).closest('.input-field').addClass('invalid');
            }
            else
            {
                $(fieldName).closest('.input-field').removeClass('invalid');
            }
        }

        $('.sample_upload_data_form').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', "{{ csrf_token() }}");
            //console.log(formData);
            const sample_store = "{{route('sample.store')}}";

            //errorCheckValidation('input[name="supplier_name"]');
            //errorCheckValidation('input[name="supplier_email"]');
            errorCheckValidation('select[name="product_tags[]"]');
            errorCheckValidation('input[name="product_title"]');

            if(errCount==0)
            {
                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    url: sample_store,
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success:function(response) {
                        //console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();
                        swal("Error!", error,"error");
                    }
                });
            }
        });

        $('.sample_edit_data_form').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', "{{ csrf_token() }}");
            //console.log(formData);
            const sample_update = "{{route('sample.update')}}";

            // errorCheckValidation('input[name="supplier_name"]');
            // errorCheckValidation('input[name="supplier_email"]');
            // errorCheckValidation('select[name="product_tags[]"]');
            // errorCheckValidation('input[name="product_title"]');

            if(errCount==0)
            {
                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    url: sample_update,
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success:function(response) {
                        //console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();
                        swal("Error!", error,"error");
                    }
                });
            }
        });

        function editSampleProduct(product_id)
        {
            //alert(product_id);
            var sku=sku;
            var url = '{{ route("sample.edit", ":slug") }}';
                url = url.replace(':slug', product_id);

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
                success:function(response) {
                    console.log(response);
                    $('.loading-message').html("");
                    $('#loadingProgressContainer').hide();
                    $("#buyerSampleEdit").modal("open");

                    $('#buyerSampleEdit input[name="product_id"]').val(response.product.id);
                    $('#buyerSampleEdit .product_edit_supplier_name').val(response.product.supplier_name);
                    $('#buyerSampleEdit .product_edit_supplier_email').val(response.product.supplier_email);
                    $('#buyerSampleEdit .product_edit_title').val(response.product.product_title);
                    $('#buyerSampleEdit .product_edit_details').val(response.product.details);
                    //$('#product_edit_tags').val(response.product.product_tags ?? '').trigger('change');
                    var tagObj = JSON.parse(response.product.product_tags);
                    $('#product_edit_tags').val(tagObj ?? '').trigger('change');

                    $('#buyerSampleEdit .sample-images-edit').empty();
                    var preloaded = response.product_images;
                    $('#buyerSampleEdit .sample-images-edit').imageUploader({
                        preloaded: preloaded,
                        extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                        mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                        imagesInputName: 'product_images',
                        label : 'Drag and Drop / click here to upload your samples. Size not more than 25 MB.'
                    });
                },
                error: function(xhr, status, error)
                {
                    $('.loading-message').html("");
                    $('#loadingProgressContainer').hide();
                    swal("Error!", error,"error");
                }
            });
        }

    </script>
@endpush
