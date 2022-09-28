@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.sample-images').imageUploader({
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'product_images',
                label : 'Drag and Drop / click here to upload your certificates. Size not more than 25 MB.'
            });

            $('.sample-images-edit').imageUploader({
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'product_images',
                label : 'Drag and Drop / click here to upload your certificates. Size not more than 25 MB.'
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

            errorCheckValidation('input[name="supplier_name"]');
            errorCheckValidation('input[name="supplier_email"]');
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
            const sample_edit = "{{route('sample.edit')}}";

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
                    url: sample_edit,
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

    </script>
@endpush
