@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            let preloaded = {!! json_encode($preloaded_image) !!};
            let portfolio_preloader_image = {!! json_encode($portfolio_preloader_image) !!};
            $('.designer-certificates').imageUploader({
                preloaded: preloaded,
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'designer_certifications',
                label : 'Drag and Drop / click here to upload your certificates. Size not more than 25 MB.'
            });

            $('.designer-protfolio-images').imageUploader({
                preloaded: portfolio_preloader_image,
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'designer_portfolio',
                label : 'Drag and Drop / click here to upload your portfolio images.'
            });
        })

        $('.designer_data_form').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', "{{ csrf_token() }}");
            //console.log(formData);
            const designer_profile_update_url = "{{route('single.designer.details.update')}}";
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                url: designer_profile_update_url,
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
        });

        $('.designer_portfolio_data_form').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', "{{ csrf_token() }}");
            //console.log(formData);
            const designer_portfolio_update_url = "{{route('single.designer.portfolio.details.update')}}";
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                url: designer_portfolio_update_url,
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
        });
    </script>
@endpush
