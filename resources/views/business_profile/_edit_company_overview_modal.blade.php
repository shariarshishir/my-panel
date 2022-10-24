<div id="company-overview-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <legend>
            <div class="row">
                <span class="tooltipped_title"> Company Overview</span> <a class="tooltipped" data-position="top" data-tooltip="Please mention the general information about your business. <br />This information will represent your identity in the digital space. <br />Input your values carefully. <br />Any false information is strictly prohibited."><i class="material-icons">info</i></a>
            </div>
        </legend>

        <form action="" method="POST" class="signup-form" id='alias-submit-form' enctype="multipart/form-data">
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
            <div class="row input-field" style="margin-bottom: 20px;">
                <div class="col s12 m12 l6" style="position: relative;">
                    <label style="margin: 0 0 10px 0; padding:0;">Customize Your Profile Url</label>
                    <input type="text" class="form-control input_profile_url"  name="alias" value="{{$business_profile->alias}}">
                    <button
                        style="position: absolute;
                        right: 15px;
                        bottom: 8px;
                        background: none;
                        border: none;
                        box-shadow: none;"  id="alias-submit-btn" disabled>
                        <i class="material-icons send-icon" style="color: #565856; font-size: 25px; ">send</i>
                    </button>
                </div>
                <div class="alias-loader" style="display: none;">
                    <img src="{{Storage::disk('s3')->url('public/frontendimages/spinner.gif')}}" alt="" />
                </div>
                <span class="alias-msg"></span>
            </div>
        </form>


        <div class="row">
            <div id="errors"></div>
            <form class="col s12" method="post" action="#" id="company-overview-update-form">
                @csrf
                <input type="hidden" name="company_overview_id" value="{{$business_profile->companyOverview->id}}">
                <div class="row">
                    @foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
                        <div class="input-field col s12 m6">
                            <label for="{{$company_overview->name}}">{{str_replace('_', ' ', ucfirst($company_overview->name))}}</label>
                            <input id="{{$company_overview->name}}" type="text" class="validate" name="name[{{$company_overview->name}}]" value="{{$company_overview->value}}">
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col s12 input-field">
                        <label for="address">Office Address</label>
                        <td>
                            <textarea class="address" name="address" value="{{$business_profile->companyOverview->address}}" type="text"  rows="20" cols="50">{{$business_profile->companyOverview->address ?? ''}}</textarea>
                        </td>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 input-field">
                        <label for="address">Factory Address</label>
                        <p>
                            <label>
                              <input type="checkbox" name="same_as_office_adrs" {{$business_profile->companyOverview->same_as_office_adrs == true ? 'checked' : ''}}/>
                              <span>Same as office address</span>
                            </label>
                        </p>
                        <td>
                            <textarea class="factory_address" name="factory_address" value="{{$business_profile->companyOverview->factory_address}}" type="text"  rows="20" cols="50">{{$business_profile->companyOverview->factory_address ?? ''}}</textarea>
                        </td>
                    </div>
                </div>
                <div class="row ">
                    <div class="col s12 input-field">
                        <label for="about_company">About company</label>
                        <td>
                            <textarea class="about-company" name="about_company" value="{{$business_profile->companyOverview->about_company}}" type="text" id="about-company-short-description" rows="20" cols="50">{{$business_profile->companyOverview->about_company ?? ''}}</textarea>
                        </td>
                    </div>
                </div>

                <div class="submit_btn_wrap">
                    <div class="row">
                        <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                        <div class="col s12 m6 l6 right-align">
                            <button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">&nbsp;</a>
    </div> -->
</div>

@push('js')
    <script>
         if($('input[name=same_as_office_adrs]').prop("checked") == true){
               $('.factory_address').hide();
        }
        else if($('input[name=same_as_office_adrs]').prop("checked") == false){
            $('.factory_address').show();
        }
        $(document).on('change', 'input[name=same_as_office_adrs]', function(){
            if($('input[name=same_as_office_adrs]').prop("checked") == true){
               $('.factory_address').hide();
            }
            else if($('input[name=same_as_office_adrs]').prop("checked") == false){
                $('.factory_address').show();
            }
        });

        //alias validate
        $(document).on('keyup','#company-overview-modal input[name=alias]', function(){
            var alias= this.value;
            var obj= $(this);
            var url = '{{ route("alias.existing.check") }}';
            $.ajax({
                method: 'get',
                data: {alias : alias},
                url: url,
                beforeSend: function() {
                //$('.loading-message').html("Please Wait.");
                $('.alias-loader').show();
                },
                success:function(data)
                    {
                        //$('.loading-message').html("");
		                $('.alias-loader').hide();
                        //obj.val(data.alias);
                        $('.alias-msg').text(data.msg);

                        $('.alias-msg').removeClass('text-danger').addClass('green-text');
                        $('#alias-submit-btn').prop('disabled', false);
                        $('.send-icon').css('color','#54A958');

                    },
                error: function(xhr, status, error)
                    {
                        //$('.loading-message').html("");
		                $('.alias-loader').hide();
                        //obj.val(data.alias);
                        $('.alias-msg').removeClass('green-text').addClass('text-danger');
                        $('.alias-msg').text(xhr.responseJSON.error);
                        $('#alias-submit-btn').prop('disabled', true);
                        $('.send-icon').css('color','#565856');

                    }
            });
        });

    //submit alias
    $('#alias-submit-form').on('submit',function(e){
                e.preventDefault();
                var url = '{{ route("update.alias") }}';
                var formData = new FormData(this);
                swal({
                title: "",
                text: "Want to update alias? if you update it will redirect to your profile page.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, update it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true)
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
                        //$('.loading-message').html("Please Wait.");
                        $('.alias-loader').show();
                        },
                        success:function(response)
                            {
                                //$('.loading-message').html("");
                                $('.alias-loader').hide();
                                swal("Done!", response.msg,"success");
                                window.location = response.url;
                            },
                            error: function(xhr, status, error)
                            {
                                //$('.loading-message').html("");
                                $('.alias-loader').hide();
                                $('#alias-submit-btn').prop('disabled', true);
                                $('.send-icon').css('color','#565856');
                                $('.alias-msg').addClass('text-danger');
                                $('.alias-msg').text(xhr.responseJSON.error.alias ?? xhr.responseJSON.error.business_profile_id);

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
