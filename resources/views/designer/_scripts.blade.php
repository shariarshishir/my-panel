@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            let preloaded = {!! json_encode($preloaded_image) !!};
            let portfolio_preloader_image = {!! json_encode($portfolio_preloader_image) !!};
            // certificates image upload block start
            $('.designer-certificates').imageUploader({
                preloaded: preloaded,
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'designer_certifications',
                label : 'Drag and Drop / click here to upload your certificates. Size not more than 25 MB.'
            });
            $(".browse_certificate_trigger").click(function(e){
                e.preventDefault();
                $('.image-uploader input[type="file"]').trigger("click");
            });
            // certificates image upload block end

            // portfolio image upload block start
            $('.designer-protfolio-images').imageUploader({
                preloaded: portfolio_preloader_image,
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'designer_portfolio',
                label : 'Drag and Drop / click here to upload your portfolio images.'
            });
            $(".browse_portfolio_trigger").click(function(e){
                e.preventDefault();
                $('.image-uploader input[type="file"]').trigger("click");
            });
            // portfolio image upload block end

            $('.designer-profile-image-upload-trigger').click(function(){
                $(this).next().children(".designer-profile-image-upload-trigger-alias").click();
            })

        })

        // profile data upload ajax block start
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
        // profile data upload ajax block end

        // profile portfolio data upload ajax block start
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
        // profile portfolio data upload ajax block end

        // profile photo data upload ajax block start
        var previousImageSrc = "@php echo auth()->user()->image; @endphp";
        $('#designer-upload-image-form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#designer-image-input-error').text('');

            swal({
                title: "Want to update profile picture ?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type:'POST',
                        url: "{{route('image.update')}}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (response) => {
                            if (response) {
                                swal(response.message);
                                $('.change_photo .designer-profile-image-upload-button').hide();
                                this.reset();
                                var image="{{asset('storage/')}}"+'/'+response.user.image;
                                $(".designer-profile-image-block  #designer_profile_image").attr('src', image);
                                //$(".user-block .avatar-online img").attr('src', image);
                            }
                        },
                        error: function(response){
                            $('#designer-image-input-error').text(response.responseJSON.errors.file);
                        }
                    });
                }
                else {
                    var image="{{asset('storage/')}}"+'/'+previousImageSrc;
                    $(". designer-profile-image-block  #designer_profile_image").attr('src', image);
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        });
        $(document).ready(function (e) {
            $('#designer-image-input').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#designer_profile_image').attr('src', e.target.result);
                    //$('.user-block .avatar-status img').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
                $('.designer-profile-image-upload-button').show();
            });
        });
        // profile photo data upload ajax block end

    </script>
@endpush
