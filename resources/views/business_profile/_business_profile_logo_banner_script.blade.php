@push('js')
<script>
$('#business-profile-logo-banner-upload-form').submit(function(e) {
       e.preventDefault();
      // console.log(previousImageSrc);
       let formData = new FormData(this);
       var obj=$(this);
       //console.log(formData);
       $('#business-profile-logo-banner-upload-errors').text('');

       swal({
            title: "Want to update business profile banner and logo ?",
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
                    url: "{{route('business.profile.logo.banner.create.update')}}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response) {
                            swal(response.message);
                            $('#business_profile_logo_banner').modal('close');
                            var logo="{{Storage::disk('s3')->url('public')}}"+'/'+response.business_profile.business_profile_logo;
                            var banner="{{Storage::disk('s3')->url('public')}}"+'/'+response.business_profile.business_profile_banner;
                            console.log(banner);
                            $('.banner_overlay').css({"background": "url('"+banner+"')", "background-size" : "cover"});
                            $(".business_profile_logo img").attr('src', logo);
                            $('#business-profile-logo-banner-upload-form')[0].reset();
                        }
                    },
                    error: function(response){
                       swal(response.responseJSON.message);
                        //$('#business-profile-logo-banner-upload-errors').text(response.responseJSON.message);
                    }
                });
            }
            else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    });


</script>
@endpush
