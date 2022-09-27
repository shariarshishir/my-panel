@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-with-padding">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.create') }}" enctype="multipart/form-data" id="user_registration_submit_form">
                        @csrf

                        <div class="form-group row">
                            <label for="full_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required autocomplete="full_name" autofocus>

                                @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vendor_name" class="col-md-4 col-form-label text-md-right">{{ __('Business Name') }}</label>

                            <div class="col-md-6">
                                <input id="vendor_name" type="text" class="form-control @error('vendor_name') is-invalid @enderror" name="vendor_name" value="{{ old('vendor_name') }}"  autocomplete="vendor_name" autofocus>

                                @error('vendor_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vendor_address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="vendor_address" type="text" class="form-control @error('vendor_address') is-invalid @enderror" name="vendor_address" value="{{ old('vendor_address') }}" autocomplete="vendor_address" autofocus>

                                @error('vendor_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-field">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <small class="grey-text">Minimum 8 character</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-confirm-field">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <small class="grey-text">Minimum 8 character</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Image') }}</label>

                            <div class="col-md-6">
                                <div class="col-md-12 mb-2">
                                    <img id="preview-image-before-upload" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="preview image" style="max-width: 200px;">
                                </div>
                                <input id="image" type="file" class="form-control image-upload-trigger @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required autocomplete="image" autofocus  style="display:none;">
                                <button type="button" class="btn green waves-effect waves-light image-upload-btn">Upload Image</button>

                                <div class="col-md-12">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>

                        <div class="captchaContent" style="margin-bottom: 15px;">
                            <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G"></div>
                            <div class="messageContent" style="color: red; text-align: left;"></div>
                        </div>

                        <input type="hidden" id="user_type" name="user_type" value={{$userType}}>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="page_button" class="btn green registration-form-trigger" style="display: none;">
                                    {{ __('Submit') }}
                                </button>
                                <button type="button" class="btn green registration-form-btn" onclick="onSubmit()">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    $(document).ready(function(){
        $(".image-upload-btn").click(function(){
            $(".image-upload-trigger").click();
        });
    });

    function onSubmit()
    {
        var errCount = 0;
        var errorClass = 'error';

        if ($('input[name="full_name"]').val()=="" || $('input[name="full_name"]').val()=="undefined")
        {
            errCount++;
            $('input[name="full_name"]').closest('.form-group').addClass(errorClass);
            $('input[name="full_name"]').addClass('invalid');
        }
        else
        {
            $('input[name="full_name"]').closest('.form-group').removeClass(errorClass);
            $('input[name="full_name"]').removeClass('invalid');
        }

        if (($('input[name="email"]').val()=="" || $('input[name="email"]').val()=="undefined") && !validateEmail($('input[name="email"]').val()))
        {
            errCount++;
            $('input[name="email"]').closest('.form-group').addClass(errorClass);
            $('input[name="email"]').addClass('invalid');
        }
        else
        {
            $('input[name="email"]').closest('.form-group').removeClass(errorClass);
            $('input[name="email"]').removeClass('invalid');
        }

        if (($('input[name="phone"]').val()=="" || $('input[name="phone"]').val()=="undefined") && !validatePhone($('input[name="phone"]').val()))
        {
            errCount++;
            $('input[name="phone"]').closest('.form-group').addClass(errorClass);
            $('input[name="phone"]').addClass('invalid');
        }
        else
        {
            $('input[name="phone"]').closest('.form-group').removeClass(errorClass);
            $('input[name="phone"]').removeClass('invalid');
        }

        if ($('input[name="vendor_name"]').val()=="" || $('input[name="vendor_name"]').val()=="undefined")
        {
            errCount++;
            $('input[name="vendor_name"]').closest('.form-group').addClass(errorClass);
            $('input[name="vendor_name"]').addClass('invalid');
        }
        else
        {
            $('input[name="vendor_name"]').closest('.form-group').removeClass(errorClass);
            $('input[name="vendor_name"]').removeClass('invalid');
        }

        if ($('input[name="vendor_address"]').val()=="" || $('input[name="vendor_address"]').val()=="undefined")
        {
            errCount++;
            $('input[name="vendor_address"]').closest('.form-group').addClass(errorClass);
            $('input[name="vendor_address"]').addClass('invalid');
        }
        else
        {
            $('input[name="vendor_address"]').closest('.form-group').removeClass(errorClass);
            $('input[name="vendor_address"]').removeClass('invalid');
        }

        if ($('input[name="password"]').val()=="" || $('input[name="password"]').val()=="undefined")
        {
            errCount++;
            $('input[name="password"]').closest('.form-group').addClass(errorClass);
            $('input[name="password"]').addClass('invalid');
        }
        else
        {
            $('input[name="password"]').closest('.form-group').removeClass(errorClass);
            $('input[name="password"]').removeClass('invalid');
        }

        if ($('input[name="password_confirmation"]').val()=="" || $('input[name="password_confirmation"]').val()=="undefined")
        {
            errCount++;
            $('input[name="password_confirmation"]').closest('.form-group').addClass(errorClass);
            $('input[name="password_confirmation"]').addClass('invalid');
        }
        else
        {
            $('input[name="password_confirmation"]').closest('.form-group').removeClass(errorClass);
            $('input[name="password_confirmation"]').removeClass('invalid');
        }

        if (document.getElementById("image").files.length == 0  )
        {
            errCount++;
            $('input[name="image"]').closest('.form-group').find('.image-upload-btn').css('color' , 'red');
            $('input[name="image"]').addClass('invalid');
        }
        else
        {
            $('input[name="image"]').closest('.form-group').find('.image-upload-btn').css('color', '');
            $('input[name="image"]').removeClass('invalid');
        }

        if(errCount==0)
        {
            var serverEnv = "{{ env('APP_ENV') }}";
            if(serverEnv == 'production')
            {
                if (grecaptcha.getResponse()==""){
                    $('.messageContent').html('Captcha Required');
                } else {
                    $("#page_button").click();
                }
            }
            else
            {
                $("#page_button").click();
            }
        }
        else
        {
            alert('Please fill all the required fields.');
            //$("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        }
    }

    //submit
    $('#user_registration_submit_form').on('submit',function(e){
            e.preventDefault();
            tinyMCE.triggerSave();
            var formData = new FormData(this);
            var url = '{{ route("users.create") }}';
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
                        var url = '{{ route("users.profile") }}';
                        window.location.href=url;
                        swal("Done!", data.msg,"success");
                    },
                error: function(response)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        if(response.responseJSON.errors.full_name) {
                                alert(response.responseJSON.errors.full_name);
                            } else if(response.responseJSON.errors.email) {
                                alert(response.responseJSON.errors.email);
                            } else if(response.responseJSON.errors.phone) {
                                alert(response.responseJSON.errors.phone);
                            } else if(response.responseJSON.errors.vendor_name) {
                                alert(response.responseJSON.errors.vendor_name);
                            } else if(response.responseJSON.errors.vendor_address) {
                                alert(response.responseJSON.errors.vendor_address);
                            } else if(response.responseJSON.errors.password) {
                                alert(response.responseJSON.errors.password);
                            } else if(response.responseJSON.errors.user_type) {
                                alert(response.responseJSON.errors.user_type);
                            }else if(response.responseJSON.errors.user_type) {
                                alert(response.responseJSON.errors.user_type);
                            }else if(response.responseJSON.errors) {
                                alert(response.responseJSON.errors);
                            }
                    }
            });
    });
</script>
@endpush
