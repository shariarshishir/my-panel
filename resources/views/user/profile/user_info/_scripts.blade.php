@push('js')
  <script>
      $(document).ready(function(){
        $(document).on("submit","#store_info_update_form",function(e){
                e.preventDefault();
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                var url = '{{ route("seller.store.update") }}';
                $.ajax({
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    url: url,
                    success: function (response) {
                        console.log(response);
                        if(response.code!=401){
                            if(response.code==500){$('.msg').text(response.msg); return false;}
                                if(response.code==200){
                                    swal("Done!", response.success,"success");
                                    $('#error_div ul').empty();
                                    //if any vendor information does not exist show warning
                                    if((response.msg.user.user_type == 'wholesaler')){

                                        if((response.msg.vendor_ownername !=null) && (response.msg.vendor_name!=null) && (response.msg.vendor_address!=null)  &&  (response.msg.vendor_country!=null) && (response.msg.vendor_type!=null) &&  (response.msg.vendor_totalemployees!=null) &&  (response.msg.vendor_yearest!=null) &&  (response.msg.vendor_certification!=null)    && (response.msg.vendor_mainproduct!=null)){
                                            $(".store-update-warning").hide();
                                        }
                                        else{
                                            $(".store-update-warning").show();
                                        }
                                    }
                                    else{
                                        if((response.msg.vendor_ownername !=null) && (response.msg.vendor_name!=null) && (response.msg.vendor_address!=null)  &&  (response.msg.vendor_country!=null) && (response.msg.vendor_type!=null) &&  (response.msg.vendor_totalemployees!=null) &&  (response.msg.vendor_yearest!=null) &&  (response.msg.vendor_certification!=null)){
                                            $(".store-update-warning").hide();
                                        }
                                        else{
                                            $(".store-update-warning").show();
                                        }
                                    }


                                    //if vendor main product does not exist show warning
                                    if((response.msg.user.user_type == 'wholesaler')){

                                        if((response.main_product.name!=null) && (response.msg.vendor_mainproduct!=null)){
                                            $(".main-product-warning").hide();
                                        }
                                        else{
                                            $(".store-update-warning").show();
                                        }

                                    }

                                    $('#vendor_name').html(response.msg.vendor_name);
                                    $('#vendor_ownername').html(response.msg.vendor_ownername);
                                    $('#vendor_address').html(response.msg.vendor_address);
                                    // $("#vendor_country option[data-value='" + response.msg.vendor_country +"']").attr("selected","selected");
                                    $("#vendor_country").html(response.msg.vendor_country);
                                    $('#vendor_type').html(response.msg.vendor_type);
                                    $('#vendor_totalemployees').html(response.msg.vendor_totalemployees);
                                    $('#vendor_yearest').html(response.msg.vendor_yearest);
                                    // $('#vendor_certification').html(response.msg.vendor_certification);
                                    if((response.msg.user.user_type == 'wholesaler' )){

                                        $('.vendor_mainproduct').html(response.main_product.name);
                                        $("#vendor_mainproduct option[data-value='" + response.msg.vendor_mainproduct +"']").attr("selected","selected");
                                    }
                                    $('.msg').text('Updated Successfull');
                                    $(".modal").modal('close');

                                }
                        }
                        else{
                            $('#error_div ul').empty();
                            $.each(response.msg, function( key, value ) {

                                $('.custom-errors').append('<li class="red">'+value+'</li>');
                            });
                        }

                    }
                });
        });



    });

  </script>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.profile-image-upload-trigger').click(function(){
        $(this).next().children(".profile-image-upload-trigger-alias").click();
    })

    var previousImageSrc = "@php echo $user->image; @endphp";

   $('#upload-image-form').submit(function(e) {
       e.preventDefault();
      // console.log(previousImageSrc);
       let formData = new FormData(this);
       //console.log(formData);
       $('#image-input-error').text('');

       swal({
            title: "Want to update profile picture ?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, add it!",
            cancelButtonText: "No, cancel!",
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
                        $('.change_photo .profile-image-upload-button').hide();
                        this.reset();
                        var image="{{asset('storage/')}}"+'/'+response.user.image;
                        $(".profile-image-block  #profile_image").attr('src', image);
                        $(".user-block .avatar-online img").attr('src', image);

                        }
                    },
                    error: function(response){
                        $('#image-input-error').text(response.responseJSON.errors.file);
                    }
                });
            }
            else {
                var image="{{asset('storage/')}}"+'/'+previousImageSrc;
                $(".profile-image-block  #profile_image").attr('src', image);
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    });

</script>

<script type="text/javascript">

    $(document).ready(function (e) {


       $('#image-input').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          $('#profile_image').attr('src', e.target.result);
          $('.user-block .avatar-status img').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);
        $('.profile-image-upload-button').show();

       });

    });

    </script>

@endpush
