@push('js')
<script>
$(document).ready(function(){

    var errCount = 0;
    var privacyCheckCount = 0;
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

    function errorCheckBoxValidation(fieldClassName)
    {
        if($(fieldClassName).is(':checked'))
        {
            privacyCheckCount = 1;
        }
        else
        {
            alert("Privacy policy is required.")
        }
    }

    $('#contact-form-data').on('submit',function(e){
        e.preventDefault();
        var url = '{{ route("front.contactus.store") }}';
        var formData = new FormData(this);
        formData.append('_token', "{{ csrf_token() }}");

        errorCheckValidation('input[name="contact_name"]');
        errorCheckValidation('input[name="contact_email"]');
        errorCheckValidation('input[name="contact_company_name"]');
        errorCheckValidation('input[name="contact_phone"]');
        errorCheckBoxValidation('input.contact_privacy');

        if(errCount == 0 && privacyCheckCount == 1)
        {
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
                    //console.log(data);
                    $('.loading-message').html("");
                    $('#loadingProgressContainer').hide();
                    $('#contact-form-data')[0].reset();
                    // swal("Your request is successful. Merchant Bay will contact you within 48 Hours. Thank You!", data.msg, "success");
                    // $(".subscribe-data-modal-wrapper-outer-block").hide();
                    //location.reload();
                    if(data.requestfrom == "subscription") {
                        var redirect_url = '{{ route("pricing.plan.success") }}';
                        window.location.href = redirect_url;
                    } else {
                        // swal("Your request is successful. Merchant Bay will contact you within 48 Hours. Thank You!", data.msg, "success");
                        // $(".subscribe-data-modal-wrapper-outer-block").hide();
                        var redirect_url = '{{ route("front.contactus.success") }}';
                        window.location.href = redirect_url;
                    }
                },
                // error: function(xhr, status, error)
                // {
                //     $('.loading-message').html("");
                //     $('#loadingProgressContainer').hide();
                // }
            });
        }

    })
})
</script>
@endpush
