<div id="rfq-user-system-entry-modal" class="modal update_rfq_signin_modal">
    <div class="close">
        <a href="javascript:void(0);" class="modal-action modal-close">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div>
    <div class="modal-content">
        <div class="user_login_info" style="display: none;">
            <h4>Sign in</h4>
            <div class="row">
                <div class="col s12 input-field">
                    <label>Email address</label>
                    <input type="email" class="" name="email" autocomplete="false"/>
                </div>
                <div class="col s12 input-field">
                    <label>Password</label>
                    <input type="password" class="" name="password"  autocomplete="new-password"/>
                </div>
                <div class="col s12">
                    <div class="row">
                        <!--div class="col s12 m8">
                            <div class="captchaContent" style="margin-bottom: 15px;">
                                <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G" data-callback="getCaptchaResponse"></div>
                                <div class="messageContent" style="color: red; text-align: left;"></div>
                            </div>
                        </div-->
                        <div class="btn_wrap">
                            <button type="submit" id="page_button" style="display: none;"></button>
                            <div class="submit_btn_wrap right-align">
                                <button type="button" class="btn_green btn_rfq_post btn-green" onclick="onSubmitValidation();">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col m12">
                    <div class="signin_or_signup_info_message" style="padding-bottom: 15px;">
                        <i class="material-icons dp48" style="vertical-align: middle;">info</i> Don't have an Account?
                    </div>
                    <div class="new_rfq_upload_form_wrap">
                        <a href="https://accounts.merchantbay.com" class="btn_green registration_account" style="padding: 10px;">Register</a>
                        <a href="javascript:void(0)" class="btn_green trigger_rfq_register" style="padding: 10px;">Submit as a Guest</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="user_registration_info">
            <h4>Submit as a Guest</h4>
            <div class="row">
                <div class="col s12 input-field">
                    <label>Name</label>
                    <input type="text" class="" name="name" autocomplete="false"/>
                </div>
                <div class="col s12 input-field">
                    <label>Email</label>
                    <input type="email" class="" name="r_email" autocomplete="false"/>
                </div>
                <div class="col s12 input-field" style="display: none;">
                    <label>Password</label>
                    <input type="password" class="" name="r_password" value="@php echo generateHashPassword(); @endphp" autocomplete="new-password"/>
                </div>
                <div class="col s12 m6 input-field">
                    <label>Company Name</label>
                    <input type="text" class="" name="r_company" autocomplete="false" />
                </div>
                <div class="col s12 m6 input-field">
                    <label>Phone Number</label>
                    <input type="number" class="" placeholder="+880 XXXXXXXXXX" name="r_phone" autocomplete="false" />
                </div>
                <div class="col s12">
                    <div class="row">
                        <!--div class="col s12 m8">
                            <div class="captchaContent" style="margin-bottom: 15px;">
                                <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G" data-callback="getCaptchaResponse"></div>
                                <div class="messageContent" style="color: red; text-align: left;"></div>
                            </div>
                        </div-->
                        <div class="btn_wrap">
                            <button type="submit" id="page_button" style="display: none;"></button>
                            <div class="submit_btn_wrap right-align">
                                <button type="button" class="btn_green btn_rfq_post btn-green" onclick="onSubmitValidation();">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col m12">
                    <div class="signin_or_signup_info_message">
                        <i class="material-icons dp48" style="vertical-align: middle;">info</i> Already have an account. <a href="javascript:void(0)" class="trigger_rfq_login">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
     <script type="text/javascript">
        const alertStatus = (e) => {
            if ($(".target_price_negotiable").is(":checked"))
            {
                $("#target_price").attr("disabled", true);
                $("#target_price").attr("required", false);
                $("#target_price").addClass("disabled");
            }
            else
            {
                $("#target_price").attr("disabled", false);
                $("#target_price").attr("required", true);
                $("#target_price").removeClass("disabled");
            }
        };
        $(document).on("click", ".target_price_negotiable", alertStatus);
        //image upload script
        $(function(){
            $('.rfq-document-upload').imageUploader({
                extensions: ['.jpg', '.jpeg', '.JPG', '.JPEG', '.png', '.PNG', '.gif', '.GIF', '.svg', '.SVG', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.pdf', '.PDF'],
                mimes : ['image/jpg', 'image/jpeg', 'image/JPG', 'image/JPEG', 'image/png', 'image/PNG', 'image/gif', 'image/GIF', 'image/svg+xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                imagesInputName: 'rfq-documents',
                label : 'Drag and Drop any product Image, Techpack, Size Chart etc here. jpeg/png/pdf/doc/xls files and size not more than 25 MB'
            });

            $(".browse_file_trigger").click(function(){
                $('.image-uploader input[type="file"]').trigger("click");
            });

            $('input[name="rfq-documents[]"]').change(function(){
                //console.log($(this)[0].files);
                $.each($(this)[0].files, function()
                {
                    console.log($(this)[0].name);
                })
            });
        });

         $(document).ready(function(){
             $(".trigger_rfq_register").click(function(){
                $(this).closest(".user_login_info").hide();
                $(".user_registration_info").show();
             })
             $(".trigger_rfq_login").click(function(){
                $(this).closest(".user_registration_info").hide();
                $(".user_login_info").show();
             });
         })

        function allowTwoDecimal() {
            var num = $("#target_price").val();
            value = parseFloat(num).toFixed(2);
            $("#target_price").val(value);
            //console.log(value);
        }

        function onSubmitWithAuthUserValidation()
        {
            var errCount = 0;
            var errorClass = 'error';

            if(errCount==0)
            {
                var short_description= $('#create-rfq-form .add_short_description').val().length;
                if($('#create-rfq-form .add_short_description').val().length > 512)
                {
                    alert('The short description character length limit is not more than 512, your given character length is '+short_description);
                    return false;
                }

                //if (grecaptcha.getResponse()==""){
                //    jQuery('.messageContent').html('Captcha Required');
                //} else {
                    $("#page_button").click();
                //}
            }
            else
            {
                alert('Please fill all the required fields.');
                //$("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            }
        }

        function onSubmitValidation()
        {
            var errCount = 0;
            var errorClass = 'error';

            if(errCount==0)
            {
                var short_description= $('#create-rfq-form .add_short_description').val().length;
                if($('#create-rfq-form .add_short_description').val().length > 512)
                {
                    alert('The short description character length limit is not more than 512, your given character length is '+short_description);
                    return false;
                }

                //if (grecaptcha.getResponse()==""){
                //    jQuery('.messageContent').html('Captcha Required');
                //} else {
                    $("#page_button").click();
                //}
            }
            else
            {
                alert('Please fill all the required fields.');
                //$("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            }


        }


        $("#create-rfq-form .add_short_description").keypress(function() {
            if($(this).val().length > 512) {
                alert('The short description character length limit is not more than 512')
            } else {
                // Disable submit button
            }
        });


        $(document).ready(function(){
            var authuser = "{{auth()->user()}}";
            if(!authuser) // this code will perform when user is not authenticate. user have to input sign-in or sign-up data.
            {
                //console.log("I am hacker");
                $('.createRfqForm').on('submit',function(e){
                    e.preventDefault();
                    var formData = new FormData(this);
                    formData.append('_token', "{{ csrf_token() }}");
                    const rfq_login_check_url = "{{route('rfq.store.with.login')}}";
                    $.ajax({
                        method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        url: rfq_login_check_url,
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(response){
                            console.log(response);
                            const rfq_app_url = "{{env('RFQ_APP_URL')}}";
                            var url = rfq_app_url+'/api/quotation';
                            var alias = response.profileAlias;
                            var flag =response.flag;
                            const sso_token = "Bearer " +response.access_token;
                            var formData = new FormData();
                            var file_data = $('input[name="rfq-documents[]"]')[0].files;
                            var files = [];
                            for (let i = 0; i < file_data.length; i++) {
                                //formData.append("files", file_data[i].files[0]);
                                formData.append("files", file_data[i]);
                            }
                            formData.append("rfq_from", 'service');

                            // var formData = new FormData();
                            // var file_data = $('input[name="rfq-documents[]"]')[0].files; // for multiple files
                            // var files = [];
                            // for (let i = 0; i < $('input[name="rfq-documents[]"]').length; i++) {
                            //     formData.append("files", $('input[name="rfq-documents[]"]')[i].files[0]);
                            // }

                            var other_data = $('.createRfqForm').serializeArray();
                            var category_id=[];
                            $("#category_id :selected").each(function() {
                                category_id.push(this.value);
                            });
                            var stringCatId=category_id.toString();
                            $.each(other_data,function(key,input){
                                if(input.name != 'category[]'){
                                    formData.append(input.name,input.value);
                                }
                            });
                            formData.append('category_id', stringCatId);
                            formData.append('_token', "{{ csrf_token() }}");
                            $.ajax({
                                method: 'post',
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: formData,
                                enctype: 'multipart/form-data',
                                url: url,
                                headers: { 'Authorization': sso_token },

                                success:function(response){
                                    var rfq_id = response.data.id;
                                    $('.loading-message').html("");
                                    $('#loadingProgressContainer').hide();
                                    const msg = "Your RFQ was posted successfully.<br><br>Soon you will receive quotation from <br>Merchant Bay verified relevant suppliers.";
                                    swal("Done!", msg,"success");
                                    console.log('response: =>',response);
                                    // var redirect_url = '{{ route("new.profile.my_rfqs", ":slug") }}';
                                    // redirect_url = redirect_url.replace(':slug', alias);
                                    // window.location.href = redirect_url;
                                    if(flag == 'registration'){
                                        var redirect_url = '{{ route("front.rfqpostsuccessfulbyanonymous") }}';
                                        window.location.href = redirect_url;
                                    } else {
                                        var alias = rfq_id;
                                        var redirect_url = '{{ route("rfq.matched-suppleirs", ":slug") }}';
                                        redirect_url = redirect_url.replace(':slug', alias);
                                        window.location.href = redirect_url;

                                        // var redirect_url = '{{ route("rfq.matched-suppleirs") }}';
                                        // window.location.href = redirect_url;
                                    }
                                    //window.location.href = "{{ route('rfq.my')}}";
                                },
                                error: function(xhr, status, error)
                                    {
                                    $('.loading-message').html("");
                                    $('#loadingProgressContainer').hide();
                                    swal("Error!", error,"error");
                                    }
                            });
                        },
                        error: function(xhr, status, error)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            $("#errors").empty();
                            if(xhr.status == 400){
                                $.each(xhr.responseJSON.error, function (key, item)
                                {   $("html, body").animate({
                                        scrollTop: 0
                                    }, 500);
                                    $("#errors").append("<li class='red darken-1'>"+item+"</li>")
                                });
                            }else{
                                swal("Error!", xhr.responseJSON.error,"error");
                            }
                        }
                    });
                });


            }
            else // this code will perform when user is authenticate. data will post directly to the mongo using user access_token.
            {
                //console.log(authuser);
                $('.createRfqForm').on('submit',function(e){
                    e.preventDefault();
                    const rfq_app_url = "{{env('RFQ_APP_URL')}}";
                    var url = rfq_app_url+'/api/quotation';
                    const sso_token = "Bearer " +"{{ Cookie::get('sso_token') }}";

                    var formData = new FormData();
                    var file_data = $('input[name="rfq-documents[]"]')[0].files;
                    var files = [];
                    for (let i = 0; i < file_data.length; i++) {
                        formData.append("files", file_data[i]);
                    }

                    formData.append("rfq_from", 'service');


                    var other_data = $('.createRfqForm').serializeArray();
                    var category_id=[];
                    $("#category_id :selected").each(function() {
                        category_id.push(this.value);
                    });
                    var stringCatId=category_id.toString();

                    $.each(other_data,function(key,input){
                        if(input.name != 'category[]'){
                            formData.append(input.name,input.value);
                        }
                    });

                    formData.append('category_id', stringCatId);
                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        method: 'post',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        url: url,
                        headers: { 'Authorization': sso_token },
                        beforeSend: function() {
                            $('.loading-message').html("Please Wait.");
                            $('#loadingProgressContainer').show();
                        },
                        success:function(response)
                        {
                            var rfq_id = response.data.id;
                            var mailTrigger = '{{ route("rfq.mailTriggerForAuthUser") }}';
                            $.ajax({
                                method: 'post',
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: formData,
                                enctype: 'multipart/form-data',
                                url: mailTrigger,
                                beforeSend: function() {},
                                success:function(response){
                                    $('.loading-message').html("");
                                    $('#loadingProgressContainer').hide();
                                    const msg = "Your RFQ was posted successfully.<br><br>Soon you will receive quotation from <br>Merchant Bay verified relevant suppliers.";
                                    swal("Done!", msg,"success");
                                    console.log('response::',rfq_id);
                                    //window.location.reload;
                                    var alias = rfq_id;
                                    var redirect_url = '{{ route("rfq.matched-suppleirs", ":slug") }}';
                                    redirect_url = redirect_url.replace(':slug', alias);
                                    window.location.href = redirect_url;

                                    // var redirect_url = '{{ route("rfq.matched-suppleirs") }}';
                                    // window.location.href = redirect_url;
                                }
                            })
                        },
                        error: function(xhr, status, error)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            swal("Error!", error,"error");
                        }
                    });
                });
            }

        })

</script>
@endpush