<!-- Footer section start -->
<footer class="footer_wrap">
	<div class="footer_bottomWrap">
		<div class="container">
			<div class="row">
				<div class="col m6 l6 footer_left_bottom">
					<div class="addressWrap">
						<div class="copyright_text">
							<h3>Merchant Bay</h3>
							<p>&copy 2019-2020 <br /> <span>All rights reserved.</span></p>
						</div>
						<div class="addressBox">
							<h4>Office Address:</h4>
							<p>Meem Tower, <br/ >
								Floor: 8, House: 18, <br />
								Road: 12, Sector: 6, <br />
								Uttara, Dhaka.
							</p>
						</div>
						<a href="https://www.google.com/maps/place/Merchant+Bay+Office/@23.8710895,90.3987335,17z/data=!3m1!4b1!4m5!3m4!1s0x3755c59804b59f57:0xa5156d3fe206198c!8m2!3d23.8710846!4d90.4009222" target="_blank" class="btn_direct btn_grBorder">Get Direction</a>
					</div>
				</div>
				<div class="col m6 l6 footer_right_bottom">
					<div class="footer_buttonWrap right-align">
                        <form method="post" id="newsletter_signup_form">
                            @csrf
                            <input type="text" id="newsletter_email_address" class="industry_textbox" placeholder="Get the latest Industry Insights" required/>
                            <button type="submit" id="newsletter_signup" class="btn_lightgr btn_email"> <img src="{{asset('images/frontendimages/new_layout_images/email.png')}}" alt="" />Email</button>
                        </form>
					</div>
					<div class="row">
						<div class="col s12 m6 l4 help_menu">
							<ul>
								<li><a href="{{route('front.tools')}}">Tools</a></li>
								<li><a href="{{route('suppliers')}}">Suppliers</a></li>
								<li><a href="{{route('rfq.index')}}">RFQ</a></li>
								<li><a href="{{route('industry.blogs')}}">Blogs/Insights</a></li>
								<li><a href="{{route('front.policy')}}">Policies</a></li>
								<li style="display: none;"><a href="javascript:void(0);">Helps</a></li>
							</ul>
						</div>
						<div class="col s12 m6 l4 product_menu">
							<h4>Products</h4>
							<ul>
								<li><a href="{{route('buydesignsproducts')}}">Designs</a></li>
								<li style="display: none;"><a href="javascript:void(0);">New Arrivals</a></li>
								<li><a href="{{route('readystockproducts')}}">Ready to Ship</a></li>
								<li><a href="{{route('low.moq')}}">Low MOQ</a></li>
								<li><a href="{{route('customizable')}}">Customizablee</a></li>
								<li><a href="{{route('shortest.lead.time')}}">Shortest Lead Time</a></li>
							</ul>
						</div>
						<div class="col s12 m6 l4 info_menu">
							<ul>
								<li><a href="{{route('front.aboutus')}}">About us</a></li>
								<li><a href="mailto:success@merchantbay.com">Contact us</a></li>
								<li style="display: none;"><a href="javascript:void(0);">Tutorials</a></li>
								<li style="display: none;"><a href="javascript:void(0);">Submit a dispute</a></li>
							</ul>
							<div class="socialWrap">
								<h4>Follow us on</h4>
								<a href="https://www.facebook.com/merchantbaybd"> <img src="{{asset('images/frontendimages/new_layout_images/facebook.png')}}" alt="" /></a>
								<a href="https://twitter.com/merchantbay_com"><img src="{{asset('images/frontendimages/new_layout_images/twitter.png')}}" alt="" /></a>
								<a href="https://www.linkedin.com/company/merchantbay"><img src="{{asset('images/frontendimages/new_layout_images/linkedin.png')}}" alt="" /></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- Footer section end -->

<div id="login-register-modal" class="modal modal-fixed-footer" tabindex="0">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m4 l5 registration-block">
                <div class="company-logo">
                    <img src="{{asset('images/frontendimages/merchantbay_logoX200.png')}}" alt="Merchant Bay Logo" />
                </div>
                <div class="registration-content">
                    <p>Not Yet Registered ?</p>
                    {{-- Want to be a <a href="{{route('user.register', 'buyer')}}">Buyer</a> or <a href="{{route('user.register', 'wholesaler')}}">Wholesaler</a> --}}
                    <a href="{{env('SSO_REGISTRATION_URL').'/?flag=global'}}" > Click here to Register</a>
                </div>
            </div>
            <div class="col s12 m8 l7 login-block">
                <span class="text-danger error-text error-msg login-error-msg" style="display: none;"></span>
                <form method="POST" action="#">
                    @csrf
                    <input type="hidden" name="fcm_token" id="fcm_token" value="">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input id="email_login" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email" class="">{{ __('E-Mail Address') }}</label>
                            <span class="text-danger error-text email_err"></span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 password-block-wrap">
                            <i class="material-icons prefix">lock_outline</i>
                            <input id="password_login" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <label for="password" class="">{{ __('Password') }}</label>
                            <span class="text-danger error-text password_err"></span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <a href="javascript:void(0);" id="show-password"><i class="material-icons">visibility</i></a>
                            <a href="javascript:void(0);" id="hide-password" style="display: none;"><i class="material-icons">visibility_off</i></a>
                        </div>
                    </div>

                    <div class="row remember-me-block">
                        <div class="input-field col s12">
                            <label>
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked="checked"' : '' }} />
                                <span>{{ __('Remember Me') }}</span>
                            </label>
                        </div>
                    </div>

                    <button class="btn green waves-effect waves-light right signin" type="submit" name="log-in">
                        {{ __('Sign In') }} <i class="material-icons right">send</i>
                    </button>
                    {{-- @if (Route::has('password.request'))
                        <a class="btn green right btn-forgot-password" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif --}}
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat "><i class="material-icons green-text text-darken-1">close</i></a>
    </div>
</div>

@if (Session::has('business_profile_create_permission'))
    <script>
        swal("",'{!!session::get("business_profile_create_permission")!!}',"warning");
    </script>
@endif
@if (Session::has('success'))
    <script>
        swal("Done!",'{!!session::get("success")!!}',"success");
    </script>
@endif
@if (Session::has('rfq-success'))
    <script>
        swal("Congratulations!",'{!!session::get("rfq-success")!!}',"success");
    </script>
@endif
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>

<!-- Material JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" integrity="sha512-NiWqa2rceHnN3Z5j6mSAvbwwg3tiwVNxiAQaaSMSXnRRDh5C2mk/+sKQRw8qjV1vN4nf8iK2a0b048PnHbyx+Q==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js" integrity="sha512-EnXkkBUGl2gBm/EIZEgwWpQNavsnBbeMtjklwAa7jLj60mJk932aqzXFmdPKCG6ge/i8iOCK0Uwl1Qp+S0zowg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js" integrity="sha512-igVQ7hyQVijOUlfg3OmcTZLwYJIBXU63xL9RC12xBHNpmGJAktDnzl9Iw0J4yrSaQtDxTTVlwhY730vphoVqJQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
{{-- <script src="{{asset('js/select2.full.min.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.material.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.material.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/jquery.raty.min.js" integrity="sha512-82+rXsrLf7WAylMdkaH5lWdNXWC0xHUKB41bmUCMICDHy/qpMZqpo4fQlBRJ5h1oSCqFOwKTWC4u2+vR2fblFw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/jquery.raty.min.css" integrity="sha512-XsO5ywONBZOjW5xo5zqAd0YgshSlNF+YlX39QltzJWIjtA4KXfkAYGbYpllbX2t5WW2tTGS7bmR0uWgAIQ8JLQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('upload-js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{asset('upload-js/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('upload-js/jquery.fileupload.js')}}"></script>
<script src="{{asset('js/image-uploader.min.js')}}"></script>
{{-- pagination js --}}
{{--<script  src="{{asset('js/pagination.js')}}" ></script> --}}
{{-- twbs pagination --}}
<script src="{{asset('js/twbsPagination.js')}}"></script>
{{-- jquery ui --}}
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}


<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
{{-- croper js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
{{-- jasny-bootstrap --}}
<script src="{{asset('js/jasny-bootstrap.js')}}"></script>
{{-- typehead js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<!--script src="{{asset('js/bootstrap3-typeahead.min.js')}}"></script-->

@stack('js')
<script>
    // Prevent jQuery UI dialog from blocking focusin
    $(document).on('focusin', function(e) {
        if ($(e.target).closest('input[aria-controls="select2-vendor_country-results"]').length) {
            e.stopImmediatePropagation();
        }
    });
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 180) {
            $(".top-header").addClass("hide-on-scroll");
            $(".middle-header").addClass("hide-on-scroll");
            $(".main-header").addClass("fixed");
        } else {
            $(".top-header").removeClass("hide-on-scroll");
            $(".middle-header").removeClass("hide-on-scroll");
            $(".main-header").removeClass("fixed");
        }
    });


</script>

<script>
    $(document).on('change', '.price-value', function(){
        var num = $(this).val();
        value = parseFloat(num).toFixed(2);
        $(this).val(value);
    })

    $(document).on('change', '.price-range-value', function(){
        var num = $(this).val();
        if($.isNumeric(num) == true){
            value = parseFloat(num).toFixed(2);
        }
        else{
            value = 'Negotiable';
        }
        $(this).val(value);
    })

    $(document).on('change', '.check-price-range-value', function(){
        var num = $(this).val();
        if($.isNumeric(num) == false){
           alert('Please Provide a Numeric Value');
        }
    })

    $(document).ready(function () {
        //$(".ready_attr_data:last-child .price-range-block").children(".price-range-separator").html("&le;");
        $(".ready_attr_data:last-child .price-range-block").children(".max-price").append(" (+ More)");
        $("#show-password").click(function(){
            $(this).hide();
            $("#hide-password").show();
            $("#password_login").prop("type", "text");
        });
        $("#hide-password").click(function(){
            $(this).hide();
            $("#show-password").show();
            $("#password_login").prop("type", "password")
        });
        var currentflow = 1;
        $('#horizontalmarque').children().eq(0).css('display', 'table-row');
        setInterval(function() {
            if(currentflow == $('#horizontalmarque').children().length)
            {
                currentflow = 1;
            }
            else
            {
                for(var i = 0; i < $('#horizontalmarque').children().length; i++)
                {
                    if((i + 1) == currentflow)
                    {
                        $('#horizontalmarque').children().eq(i).css('display', 'table-row');
                    }
                    else
                    {
                        $('#horizontalmarque').children().eq(i).css('display', 'none');
                    }
                }
                currentflow += 1;
            }
        }, 5000);
    });
    $('.product-large-image-block').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.product-list-images-block'
    });
    $('.product-list-images-block').slick({
        dots: false,
        speed: 500,
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.product-large-image-block',
        focusOnSelect: true
    });
    $('.related-products-block').slick({
        dots: false,
        infinite: false,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1
    });
    $('.modal-product-images').slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1
    });
    $('.recommendation-products').slick({
        dots: false,
        infinite: false,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1
    });

    // slick slider
    $('.product_slider').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 1000,

        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            add: function (e, data) {
                $('#loading').text('Uploading...');
                data.submit();
            },
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                    if ($('#file_ids').val() != '') {
                        $('#file_ids').val($('#file_ids').val() + ',');
                    }
                    $('#file_ids').val($('#file_ids').val() + file.fileID);
                });
                $('#loading').text('');
            }
        });
    });
</script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    $( document ).ready(function() {
        var firebaseConfig = {
            apiKey: "AIzaSyAnarX9u8kFVklreePU_UUeHE2BmCVVRs4",
            authDomain: "merchant-bay-service.firebaseapp.com",
            projectId: "merchant-bay-service",
            storageBucket: "merchant-bay-service.appspot.com",
            messagingSenderId: "789211877611",
            appId: "1:789211877611:web:006bb3073632a306daeeae",
            measurementId: "G-M5LLMK2G5S"
        };


        // Initialize Firebase
        if (!firebase.apps.length) {
            firebase.initializeApp(firebaseConfig);
        }else {
            firebase.app(); // if already initialized, use that one
        }
        const messaging = firebase.messaging();

        messaging.requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (fcm_token) {
                var fcm_token = fcm_token;
                $("#fcm_token").val(fcm_token);

            }).catch(function (error) {
                //alert(error);
            });

        });
        function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {
            $('.'+key+'_err').text(value);
            });
        }
        //This code recieve message from server /your app and print message to console if same tab is opened as of project in browser
        messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
            data:{
                time:  new Date(Date.now()).toString(),
                click_action: payload.notification.click_action
            }
        };
        new Notification(noteTitle, noteOptions);
    });
</script>

<script>
    $('.signin').click(function (e) {
        e.preventDefault();
        var email = $('#email_login').val();
        var password=$('#password_login').val();
        var fcm_token=$('#fcm_token').val();
        var remember =$(this).closest('#login-register-modal').find('input[name="remember"]').prop('checked');
        $.ajax({
            url: "{{route('users.login')}}",
            type: "POST",
            data: {"email": email, "password": password ,"fcm_token":fcm_token, "remember": remember, "_token": "{{ csrf_token() }}"},
            success: function (data) {
                    if($.isEmptyObject(data.error)){
                       if(data.msg){
                        //$('.error-msg').show().text(data.msg);
                        alert(data.msg);
                        $('#email_login').addClass('invalid');
                        $('#password_login').addClass('invalid');
                       }
                       else{
                          //console.log(data);
                        var url = '{{ route("users.profile") }}';
                        window.location.href=url;
                       }
                    }
                    else{
                        printErrorMsg(data.error);
                    }
            }
        });
    });
    function printErrorMsg (msg) {
        $.each( msg, function( key, value ) {
          $('.'+key+'_err').text(value);
        });
    }
</script>
<script>
    // @if(Session::has('success'))
    //     //toastr.success("{{Session::get('success')}}");
    //     var toastHTML= "{{Session::get('success')}}";
    //     M.toast({html: toastHTML, classes:'toast-success'});
    // @endif

    // @if(Session::has('error'))
    //     //toastr.error("{{Session::get('error')}}");
    //     var toastHTML= "{{Session::get('error')}}";
    //     M.toast({html: toastHTML, classes:'toast-error'});
    // @endif

    // @if(Session::has('info'))
    //     //toastr.info("{{ Session::get('info') }}");
    //     var toastHTML= "{{Session::get('info')}}";
    //     M.toast({html: toastHTML, classes:'toast-info'});
    // @endif

    // @if(Session::has('warning'))
    //    // toastr.warning("{{ Session::get('warning') }}");
    //    var toastHTML= "{{Session::get('warning')}}";
    //     M.toast({html: toastHTML, classes:'toast-warning'});
    // @endif
  </script>
  <script>
    function addProductColorSize()
    {
    let totalChild = $('.color-size-table-block tbody').children().length;
    var html = '<tr>';
    html += '<td data-title="Color"><input type="text" value="" class="form-control" name="color_size[color][]" /></td>';
    html += '<td data-title="XXS"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[xxs][]" /></td>';
    html += '<td data-title="XS"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[xs][]" /></td>';
    html += '<td data-title="Small"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[small][]" /></td>';
    html += '<td data-title="Medium"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[medium][]" /></td>';
    html += '<td data-title="Large"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[large][]" /></td>';
    html += '<td data-title="Extra Large"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[extra_large][]" /></td>';
    html += '<td data-title="XXL"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[xxl][]" /></td>';
    html += '<td data-title="XXXL"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[xxxl][]" /></td>';
    html += '<td data-title="4XXL"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[four_xxl][]" /></td>';
    html += '<td data-title="One Size"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="color_size[one_size][]" /></td>';
    html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeProductColorSize(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
    html += '</tr>';
    $('.color-size-table-block tbody').append(html);
    }
    function removeProductColorSize(el)
    {
        $(el).parent().parent().remove();
    }


    function addFreshOrderAttribute(el)
    {
        var count=$(el).closest('.no_more_tables').find('.fresh-order-attribute-table-block tbody').children('tr').length;
        //let totalChild = $('.color-size-table-block tbody').children().length;
        var html = '<tr>';
        html += '<td data-title="Qty Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"><span class="quantity_min_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td data-title="Qty Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"><span class="quantity_max_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td data-title="Price (usd)"><input name="price[]" id="price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$"><span  class="price_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td data-title="Lead Time (days)"><input name="lead_time[]" id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror"  value="" placeholder="Days"><span  class="lead_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeFreshOrderAttribute(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
        html += '</tr>';
        $('.fresh-order-attribute-table-block tbody').append(html);
    }
    function removeFreshOrderAttribute(el)
    {
        $(el).parent().parent().remove();
    }

    function addReadyOrderAttribute(el)
    {
        var count=$(el).closest('.no_more_tables').find('.ready-order-attribute-table-block tbody').children('tr').length;
        let totalChild = $('.color-size-table-block tbody').children().length;
        var html = '<tr>';
        html += '<td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"><span class="ready_quantity_min_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"><span class="ready_quantity_max_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$"><span  class="ready_price_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeFreshOrderAttribute(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
        html += '</tr>';
        $('.ready-order-attribute-table-block tbody').append(html);
    }
    function removeReadyOrderAttribute(el)
    {
        $(el).parent().parent().remove();
    }

    // non clothing item
    function addNonClothingAttr()
    {
    let totalChild = $('.non-clothing-color-quantity-table-block tbody').children().length;
    var html = '<tr>';
    html += '<td data-title="Color"><input type="text" value="" class="form-control" name="non_clothing_attr[color][]" /></td>';
    html += '<td data-title="Quantity"><input type="text" value="" class="form-control negitive-or-text-not-allowed" name="non_clothing_attr[quantity][]" /></td>';
    html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeNonClothingAttr(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td>';
    html += '</tr>';
    $('.non-clothing-color-quantity-table-block tbody').append(html);
    }
    function removeNonClothingAttr(el)
    {
        $(el).parent().parent().remove();
    }


    function addNonClothingPriceBreakDown(el)
    {
        var count=$(el).closest('.no_more_tables').find('.non-clothing-prices-breakdown-block tbody').children('tr').length;
        let totalChild = $('.non-clothing-prices-breakdown-block tbody').children().length;
        var html = '<tr>';
        html += '<td data-title="Qty Min"><input  name="non_clothing_min[]"  type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"><span class="non_clothing_min_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td data-title="Qty Max"><input  name="non_clothing_max[]"  type="text" class="form-control negitive-or-text-not-allowed @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"><span class="non_clothing_max_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td data-title="Price (usd)"><input  name="non_clothing_price[]" type="text" class="form-control price-range-value @error('price') is-invalid @enderror"  value="" placeholder="$"><span class="non_clothing_price_'+count+'_error text-danger error-rm"></span></td>';
        html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeNonClothingPriceBreakDown(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
        html += '</tr>';
        $('.non-clothing-prices-breakdown-block tbody').append(html);
    }
    function removeNonClothingPriceBreakDown(el)
    {
        $(el).parent().parent().remove();
    }

    //end non clothing item

  </script>

  <script>

       $(document).ready(function() {
            var editor_config = {
                path_absolute : "/",
                selector: 'textarea.editor',
                relative_urls : 0,
                remove_script_host : 0,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | myCustomToolbarButton bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                setup: function (editor) {
                    editor.ui.registry.addButton('myCustomToolbarButton', {
                    text: '<div class="pdf-upload-icon">pdf</div>',
                    onAction: function (_) {
                       $('#tiny-mc-file-upload-modal').modal('open');
                       $('#tiny-mc-file-upload-form')[0].reset();
                       $(document).one('click', '.tiny-mc-file-upload', function (e) {
                            e.preventDefault();
                            var formData= new FormData(document.getElementById('tiny-mc-file-upload-form'));
                            formData.append('_token', "{{ csrf_token() }}");

                            $.ajax({
                                url: "{{route('tinymc.file.upload')}}",
                                type: "POST",
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: formData,
                                beforeSend: function() {
                                    $('.loading-message').html("Please Wait.");
                                    $('#loadingProgressContainer').show();
                                },
                                success: function (data) {
                                    var html='<a href="'+data.fileName+'" target="_blank" class="tinymc-uploaded-file">'+data.originalFileName+'</a>';
                                    editor.insertContent(html);
                                    $('#tiny-mc-file-upload-modal').modal('close');
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                }
                            });
                       });

                    }
                    });
                },
                /* enable title field in the Image dialog*/
                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                /*
                    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                    images_upload_url: 'postAcceptor.php',
                    here we add custom filepicker only to Image dialog
                */
                file_picker_types: 'image',
                /* and here's our custom image picker*/
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    /*
                    Note: In modern browsers input[type="file"] is functional without
                    even adding it to the DOM, but that might not be the case in some older
                    or quirky browsers like IE, so you might want to add it to the DOM
                    just in case, and visually hide it. And do not forget do remove it
                    once you do not need it anymore.
                    */

                    input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {
                        /*
                        Note: Now we need to register the blob in TinyMCEs image blob
                        registry. In the next release this part hopefully won't be
                        necessary, as we are looking to handle it internally.
                        */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                    };

                    input.click();
                },
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            };

            function applyMCE() {
                tinymce.init(editor_config);
            }

            applyMCE();
        });
  </script>

  <script>
  //sorting
    $(document).on('change','.sorting', function(){
        var value= $(this).val();
        // var pageUrl = $(location).attr("href");
        // var segments = pageUrl.split( '/' );
        // var action = segments[4];
        var slug =$('input[name=slug]').val();
        if($('.sorting_category_id').val()){
            var cat_id=$('.sorting_category_id').val();
        }
        else{
            var cat_id= null;
        }
        var url = '{{ route("sorting", [":value" , ":slug" , ":cat_id"] )}}';
            url = url.replace(':value', value);
            url = url.replace(':slug', slug);
            url = url.replace(':cat_id', cat_id);
        $.ajax({
            method: 'get',
            processData: false,
            contentType: false,
            cache: false,
            url: url,
            beforeSend: function() {
                $("body").addClass("loading");
            },
            complete: function(){
                $("body").removeClass("loading");
            },
            success:function(data)
                {

                    $('.prodcuts-list').html('');
                    $('.prodcuts-list').html(data.data);
                },
            error: function(xhr, status, error)
                {
                    $('#errors').empty();
                    $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                    $.each(xhr.responseJSON.error, function (key, item)
                    {
                        $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                    });
                }
        });

    });
  </script>

  <script>
//live search by product name or vendor name
$("#searchOption").change(function(){
    $('#search-results-wrapper').hide();
    if($(this).val() == "product"){
        $(".search_input").val("").attr("placeholder", "Search for ...");
    }
    else if($(this).val() == "vendor"){
        $(".search_input").val("").attr("placeholder", "Search for ...");
    }
    else if($(this).val() == "all"){
        $(".search_input").val("").attr("placeholder", "Example: Baby Sweaters, T-Shirts, Viscose, Radiant Sweaters etc.");
    }
});
$(document).on("keyup",".search_input",function(){

    if($(this).val().length == 0){
        $("#search-results-wrapper").hide();
    }
    if($(this).val().length > 2)
    {
        var is_env = "{{ env('APP_ENV') }}";
        var url;
        var searchInput = $(this).val();
        var selectedSearchOption = $("#searchOption").children("option:selected").val();
        $("#system_search .search_type").val(selectedSearchOption);
        var post_url = '{{ route("live.search") }}';
        $.ajax({
            type:'GET',
            url: post_url,
            dataType:'json',
            data:{ searchInput:searchInput,selectedSearchOption:selectedSearchOption},
            beforeSend: function() {
                //$('.loading-search-message').html("Searching please Wait.");
                //$('#search-results').html("Searching please Wait.");
                //$('#search-results').show();
                $("#search-results-wrapper").show();
            },
            success: function(response)
            {
                //console.log(response.averageRatings);
                //$('.loading-message').html("");
                //$('#loadingProgressContainer').hide();
                $("#loadingSearchProgressContainer").hide();
                var html="";
                var nohtml = "";
                if(is_env == 'production'){
                    url  = window.location.origin+'/global';
                } else {
                    url  = window.location.origin;
                }

                if(response.resultCount > 0)
                {
                    console.log(response.data);
                    if(response.searchType=='all' && response.data.length > 0)
                    {
                        //html+='<a href="javascript:void(0)" class="close-search-modal-trigger"><i class="material-icons dp48">cancel</i></a>';
                        for(var i=0; i<response.data.length; i++)
                        {
                            if(response.data[i].name && response.data[i].business_profile_id) // product for wholesaler
                            {
                                html += '<div class="product-item">';
                                html += '<a href="'+url+'/product/'+response.data[i].sku+'/details" class="overlay_hover">&nbsp;</a>';
                                $.each(response.data[i].images,function(key,item){
                                    if(key==0){
                                        var url = window.location.origin;
                                        // var image=url+'/storage/'+item.image;
                                        var image="{{asset('storage/')}}"+'/'+item.image;
                                        html += '<div class="product-img"><img src="'+image+'"></div>';
                                    }
                                })
                                html += '<div class="product-short-intro">';
                                html += '<h4>'+response.data[i].name+'</h4>';
                                html += '<div class="details"><p>MOQ: '+response.data[i].moq+'</p></div>';
                                html += '<div class="search-item-tag">Single Product</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                            else if(response.data[i].title && response.data[i].business_profile_id) // product for manufacturer
                            {
                                html += '<div class="product-item">';
                                html += '<a href="'+url+'/product/details/mb/'+response.data[i].id+'" class="overlay_hover">&nbsp;</a>';
                                $.each(response.data[i].product_images,function(key,item){
                                    if(key==0){
                                        var url  = window.location.origin;
                                        // var image=url+'/storage/'+item.image;
                                        var image = "{{asset('storage/')}}"+'/'+item.product_image;
                                        html += '<div class="product-img"><img src="'+image+'"></div>';
                                    }
                                })
                                html += '<div class="product-short-intro">';
                                html += '<h4>'+response.data[i].title+'</h4>';
                                html += '<div class="details"><p>MOQ: '+response.data[i].moq+'</p></div>';
                                html += '<div class="search-item-tag">Single Product</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                            else if(response.data[i].title && response.data[i].slug) // list for blog
                            {
                                html += '<div class="product-item">';
                                html += '<a href="'+url+'/press-room/details/'+response.data[i].slug+'" class="overlay_hover">&nbsp;</a>';
                                var image = "{{asset('storage/')}}"+'/'+response.data[i].feature_image;
                                html += '<div class="product-img"><img src="'+image+'"></div>';
                                html += '<div class="product-short-intro">';
                                html += '<h4>'+response.data[i].title+'</h4>';
                                html += '<div class="details"><p>'+response.data[i].details.substring(0, 100)+'</p></div>';
                                html += '<div class="search-item-tag">Blog</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                            else // list for supplier
                            {
                                var image;
                                var profile_url="{{route('supplier.profile', ':slug')}}";
                                    profile_url=profile_url.replace(':slug', response.data[i].alias);
                                html += '<div class="product-item">';
                                html += '<a href="'+profile_url+'" class="overlay_hover">&nbsp;</a>';
                                if(response.data[i].user.image)
                                {
                                image = "{{asset('storage/')}}"+'/'+response.data[i].user.image;
                                }
                                else
                                {
                                image = "{{asset('images/frontendimages/no-image.png')}}";
                                }
                                html += '<div class="product-img"><img src="'+image+'"></div>';
                                html += '<div class="product-short-intro">';
                                html += '<h4>'+response.data[i].business_name+'</h4>';
                                html += '<div class="details"><p>'+response.data[i].industry_type+'</p></div>';
                                html += '<div class="search-item-tag">Supplier Profile</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                        }
                        $('#search-results').html(html);
                        $('#search-results').show();
                    }
                    else if(response.searchType=='product' && response.data.length > 0)
                    {
                        $('.product-item').html(nohtml);
                        //html+='<a href="javascript:void(0)" class="close-search-modal-trigger"><i class="material-icons dp48">cancel</i></a>';
                        for(var i=0; i<response.data.length; i++)
                        {
                            //console.log(response.data[i]);
                            if(response.data[i].name) // product for wholesaler
                            {
                                html+='<div class="product-item">';
                                html+= '<a href="'+url+'/product/'+response.data[i].sku+'/details" class="overlay_hover">&nbsp;</a>';
                                $.each(response.data[i].images,function(key,item){
                                    if(key==0){
                                        var url  = window.location.origin;
                                        // var image=url+'/storage/'+item.image;
                                        var image="{{asset('storage/')}}"+'/'+item.image;
                                        html+='<div class="product-img"><img src="'+image+'"></div>';
                                    }
                                })
                                html+= '<div class="product-short-intro">';
                                html+= '<h4>'+response.data[i].name+'</h4>';
                                html+= '<div class="details"><p>MOQ: '+response.data[i].moq+'</p></div>';
                                html += '<div class="search-item-tag">Single Product</div>';
                                html+= '</div>';
                                html+= '</div>';
                            }
                            else // product for manufacturer
                            {
                                html+='<div class="product-item">';
                                html+= '<a href="'+url+'/product/details/mb/'+response.data[i].id+'" class="overlay_hover">&nbsp;</a>';
                                $.each(response.data[i].product_images,function(key,item){
                                    if(key==0){
                                        var url  = window.location.origin;
                                        // var image=url+'/storage/'+item.image;
                                        var image="{{asset('storage/')}}"+'/'+item.product_image;
                                        html+='<div class="product-img"><img src="'+image+'"></div>';
                                    }
                                })
                                html+= '<div class="product-short-intro">';
                                html+= '<h4>'+response.data[i].title+'</h4>';
                                html+= '<div class="details"><p>MOQ: '+response.data[i].moq+'</p></div>';
                                html += '<div class="search-item-tag">Single Product</div>';
                                html+= '</div>';
                                html+= '</div>';
                            }
                        }
                        $('#search-results').html(html);
                        $('#search-results').show();
                    }
                    else if(response.searchType=='vendor' && response.data.length > 0)
                    {
                        //console.log(response.data);
                        $('.vendor-info').html(nohtml);
                        //html+='<a href="javascript:void(0)" class="close-search-modal-trigger"><i class="material-icons dp48">cancel</i></a>';
                        for(var i=0;i<response.data.length;i++){
                            var profile_url="{{route('supplier.profile', ':slug')}}";
                                profile_url=profile_url.replace(':slug', response.data[i].alias);
                            html+='<div class="vendor-info">';
                            html+= '<a href="'+profile_url+'" class="overlay_hover">&nbsp;</a>';
                            html+= '<h4>'+response.data[i].business_name+'</h4>';
                            html+= '<div class="details"><p>'+response.data[i].location+'</p></div>';
                            html += '<div class="search-item-tag">Supplier Profile</div>';
                            html+= '</div>';
                            }
                        $('#search-results').html(html);
                        $('#search-results').show();
                    }
                }
                else
                {
                    if(response.searchType=='all')
                    {
                        $('#search-results').show();
                        $('#search-results').html("No information found regarding your search keyword.").show();
                    }
                    else if(response.searchType=='product')
                    {
                        $('#search-results').show();
                        $('#search-results').html("No product found regarding your search keyword.").show();
                    }
                    else if(response.searchType=='vendor')
                    {
                        $('#search-results').show();
                        $('#search-results').html("No manufacturer found regarding your search keyword.").show();
                    }
                    //$('#search-results').html(nohtml).hide();
                }
            }

        });
    }
});

//filter search
    // $( "#price_range" ).slider({
    // 		range: true,
    // 		min: 1,
    // 		max: 70000,
    // 		slide:function(event, ui){
    // 			$("#minimum_range").val(ui.values[0]);
    // 			$("#maximum_range").val(ui.values[1]);

    // 		}
    // 	});
    // $('.filter-search-form').on('submit',function(e){
        $('.filter-search-price-range').on('change',function(){
             $('.btn-filter-search-price-range').show();
            //  if(!$(this).val() != "" )
            //  {
            //     $('.btn-filter-search-price-range').hide();
            //  }else{
            //     $('.btn-filter-search-price-range').show();
            //  }

        });
        $('.filter-search-check-price-range').on('click',function(e){
            e.preventDefault();
            var product_type=$('input[name=filter_search_product_type').val();
            var minimum_value=$('input[name=minimum_range]').val();
            var maximum_value=$('input[name=maximum_range]').val();
            var search_category_id=$('input[name=filter_search_category_id]').val();
            var product_type_category_id=$('input[name=filter_search_product_type_cat_id]').val();

            var color = [];
            $.each($("input[name='color']:checked"), function(){
                // $(this).prop('checked', true);
                color.push($(this).val());
            });
            var size = [];
            $.each($("input[name='size']:checked"), function(){
                size.push($(this).val());
            });
            var rating = [];
            $.each($("input[name='rating']:checked"), function(){
                rating.push($(this).val());
            });
            var url = '{{ route("filter.search") }}';
            $.ajax({
                method: 'get',
                data: {color: color,size: size,rating: rating, product_type:product_type, minimum_value: minimum_value, maximum_value: maximum_value, search_category_id:search_category_id, product_type_category_id:product_type_category_id},
                url: url,
                beforeSend: function() {
                    $("body").addClass("loading");
                },
                complete: function(){
                    $("body").removeClass("loading");
                },
                success:function(data)
                    {
                     $('.prodcuts-list').html('');
                     $('.prodcuts-list').html(data.data);
                    },
                error: function(xhr, status, error)
                    {
                        $('#errors').empty();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }

            });
        });
        $('.filter-search-check').on('change',function(e){
            e.preventDefault();
            var product_type=$('input[name=filter_search_product_type').val();
            var minimum_value=$('input[name=minimum_range]').val();
            var maximum_value=$('input[name=maximum_range]').val();
            var search_category_id=$('input[name=filter_search_category_id]').val();
            var product_type_category_id=$('input[name=filter_search_product_type_cat_id]').val();

            var color = [];
            $.each($("input[name='color']:checked"), function(){
                // $(this).prop('checked', true);
                color.push($(this).val());
            });
            var size = [];
            $.each($("input[name='size']:checked"), function(){
                size.push($(this).val());
            });
            var rating = [];
            $.each($("input[name='rating']:checked"), function(){
                rating.push($(this).val());
            });
            var url = '{{ route("filter.search") }}';
            $.ajax({
                method: 'get',
                data: {color: color,size: size,rating: rating, product_type:product_type, minimum_value: minimum_value, maximum_value: maximum_value, search_category_id:search_category_id, product_type_category_id:product_type_category_id},
                url: url,
                beforeSend: function() {
                    $("body").addClass("loading");
                },
                complete: function(){
                    $("body").removeClass("loading");
                },
                success:function(data)
                    {
                     $('.prodcuts-list').html('');
                     $('.prodcuts-list').html(data.data);
                    },
                error: function(xhr, status, error)
                    {
                        $('#errors').empty();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }

            });
    });

    $(document).on("click",".close-search-modal-trigger",function(){
        $(this).closest("#search-results-wrapper").hide();
        $(".search_input").val("");
    });

    //switch to manufacturers
    $(document).on('click', '.submit-to-manufacturers', function (e) {
        e.preventDefault();
        $('.loading-message').html("Please Wait.");
        $('#loadingProgressContainer').show();
        $('#submit-to-manufacturers-form').submit();
    });


    function addToCart($sku)
{
    var sku=$sku;
    var unit_price=  $('input[name=unit_price]').val();
    var quantity =  $('input[name=quantity]').val();
    var total_price=  $('input[name=total_price]').val();
    var full_stock= $('input[name=full_stock]').val();
    var product_type =$('input[name=product_type]').val();
    var color_attr= [];
    //var check_value=$('input[name="color"]').val();
    if(product_type== 1 || product_type == 2)
    {
        $('.tr').each(function(idx,ele){
            color_attr.push({'color' :$('input[name="color"]').eq(idx).val(),
                            'xxs' : Number($('input[name="xxs"]').eq(idx).val()) || 0,
                            'xs' : Number($('input[name="xs"]').eq(idx).val()) || 0,
                            'small' :Number($('input[name="small"]').eq(idx).val())  || 0,
                            'medium' : Number($('input[name="medium"]').eq(idx).val()) || 0,
                            'large' : Number($('input[name="large"]').eq(idx).val()) ||0,
                            'extra_large' : Number($('input[name="extra_large"]').eq(idx).val()) || 0,
                            'xxl' : Number($('input[name="xxl"]').eq(idx).val()) || 0,
                            'xxxl' : Number($('input[name="xxxl"]').eq(idx).val()) || 0,
                            'four_xxl' : Number($('input[name="four_xxl"]').eq(idx).val()) || 0,
                            'one_size' : Number($('input[name="one_size"]').eq(idx).val()) || 0,
                            });
            });
    }
    if(product_type == 3)
    {
        $('.tr').each(function(idx,ele){
            color_attr.push({'color' :$('input[name="color"]').eq(idx).val(),
                            'quantity' : Number($('input[name="non_clothing_quantity"]').eq(idx).val()) || 0,
                            });
            });
    }


    var url = '{{ route("add.cart") }}';
    swal({
        title: "Want to add this product into cart?",
        text: "",
        type: "info",
        showCancelButton: !0,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {

                // if(check_value){
                //     $('.tr').each(function(idx,ele){
                //     color_attr.push({'color' : $('input[name="color"]').eq(idx).val(),
                //                     'small' : $('input[name="small"]').eq(idx).val(),
                //                     'medium' : $('input[name="medium"]').eq(idx).val(),
                //                     'large' : $('input[name="large"]').eq(idx).val(),
                //                     'extra_large' : $('input[name="extra_large"]').eq(idx).val(),
                //                     });
                //     });
                // }

                $.ajax({
                    type:'GET',
                    url: url,
                    dataType:'json',
                    data:{ sku :sku ,unit_price:unit_price,total_price:total_price,quantity:quantity,color_attr:color_attr,full_stock: full_stock},
                    success: function(data){
                        //console.log(data.cartItems);
                        swal(data.message, data.success,data.type);
                        $('#cartItems').html('');
                        $("#cartItems").html(data.cartItems);
                        $('#product-details-modal').hide();
                    }
                });
            }
            // else {
            //     e.dismiss;
            // }
    }, function (dismiss) {
        return false;
    })
}

//askforprice
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function askForPrice($sku)
{
    var sku=$sku;
    var business_profile_id=  $('input[name=business_profile_id]').val();
    var product_id=  $('input[name=product_id]').val();
    var product_type =$('input[name=product_type]').val();
    var type = 1;
    var color_attr= [];

    if(product_type == 1 || product_type == 2)
    {
        $('.tr').each(function(idx,ele){
            color_attr.push({'color' :$('input[name="color"]').eq(idx).val(),
                            'xxs' : Number($('input[name="xxs"]').eq(idx).val()) || 0,
                            'xs' : Number($('input[name="xs"]').eq(idx).val()) || 0,
                            'small' :Number($('input[name="small"]').eq(idx).val())  || 0,
                            'medium' : Number($('input[name="medium"]').eq(idx).val()) || 0,
                            'large' : Number($('input[name="large"]').eq(idx).val()) ||0,
                            'extra_large' : Number($('input[name="extra_large"]').eq(idx).val()) || 0,
                            'xxl' : Number($('input[name="xxl"]').eq(idx).val()) || 0,
                            'xxxl' : Number($('input[name="xxxl"]').eq(idx).val()) || 0,
                            'four_xxl' : Number($('input[name="four_xxl"]').eq(idx).val()) || 0,
                            'one_size' : Number($('input[name="one_size"]').eq(idx).val()) || 0,
                            });
        });
    }
    if(product_type == 3)
    {
        $('.tr').each(function(idx,ele){
            color_attr.push({'color' :$('input[name="color"]').eq(idx).val(),
                            'quantity' : Number($('input[name="non_clothing_quantity"]').eq(idx).val()) || 0,
                            });
        });
    }

    var url = '{{ route("user.order.query.store") }}';
    swal({
        title: "Want to query about this product?",
        text: "",
        type: "info",
        showCancelButton: !0,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {

                $.ajax({
                    type:'POST',
                    url: url,
                    dataType:'json',
                    data:{ sku :sku ,business_profile_id:business_profile_id,product_id:product_id,color_attr:color_attr,type:type},
                    success: function(data){
                        console.log(data.cartItems);
                        swal("Done!", data.msg,"success");
                        $('#product-details-modal').hide();
                    }
                });
        }

    }, function (dismiss) {
        return false;
    })
}
// $(window).on('load', function() {
//     var selectedSearchOption = $("#searchOption").children("option:selected").val();
//     $("#system_search .search_type").val(selectedSearchOption);
// })

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 180) {
            $(".header_wrap").addClass("fixed");
        } else {
            $(".header_wrap").removeClass("fixed");
        }
        //swal(error[0],"Please try again", "error");
    });

    $('#newsletter_signup_form').on('submit',function(e){
        e.preventDefault();
        let newsletter_email_address = $('#newsletter_email_address').val();
        var url = '{{ route("newsletter.subscribe") }}';
        $.ajax({
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "newsletter_email_address":newsletter_email_address,
            },
            url: url,

            success:function(response){

                $('#newsletter_signup_form')[0].reset();
                swal("Done!", response.message,"success");
            },
            error:function (response) {
                var error = response.responseJSON.errors.newsletter_email_address;
                swal(error[0],"Please try again", "error");

            }
        });
    });


  </script>




<script>
    function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    }
</script>

<script>
    $('.subnev_arrow').on('click', function() {
        $(this).toggleClass('active');
    });
</script>
<script>
    $(document).on("click", ".order-modification-request" , function() {
    var notificationId =$(this).attr("data-order-modification-request-notification-id") ;
    var obj=$(this).closest('tr').find('.newOrder');
    $.ajax({
        type:'GET',
        url: "{{route('notification-mark-as-read')}}",
        dataType:'json',
        data:{ notificationId :notificationId},
        success: function(data){
            obj.remove();
            $('.orderModificationCount').html(data.newModificationRequestNotificationCount);
            // $('#noOfNotifications').html(data.noOfnotification);
            $('.noticication_counter').text(data['noOfnotification']);
        }
    });

});

$(document).on("click", "#notification_identifier" , function() {
    var notificationId =$(this).attr("data-notification-id") ;
    var obj=$(this).closest('tr').find('.newOrder');
    $.ajax({
        type:'GET',
        url: "{{route('notification-mark-as-read')}}",
        dataType:'json',
        data:{ notificationId :notificationId},
        success: function(data){
            $(obj).remove();
                $('.orderApprovedCount').html(data.newOrderApprovedNotificationCount);
                // $('#noOfNotifications').html(data.noOfnotification);
                $('.noticication_counter').text(data['noOfnotification']);
        }
    });

});





//order query notification
$(document).on("click", ".order-query-notification" , function() {
    var notificationId =$(this).attr("data-notification-id") ;
    var obj=$(this).closest('tr').find('.newOrder');
    $.ajax({
        type:'GET',
        url: "{{route('notification-mark-as-read')}}",
        dataType:'json',
        data:{ notificationId :notificationId},
        success: function(data){
            obj.remove();
            $('.orderQueryProcessedCount').html(data.newOrderQueryProcessedCount);
           // $('#noOfNotifications').html(data.noOfnotification);
            $('.noticication_counter').text(data['noOfnotification']);
        }
    });

});


//profile active inactive
$(".profile_enable_disable_trigger input[type=checkbox]").change(function() {
            if($(this).is(":checked")) {
                var obj = $(this);
                var b_profile_id=$(this).attr('bpid');
                var restore_url = '{{ route("business.profile.restore", ":slug") }}';
                    restore_url = restore_url.replace(':slug', b_profile_id);
                    swal({
                    title: "Want to restore this profile ?",
                    text: "Please ensure and then confirm!",
                    type: "success",
                    showCancelButton: !0,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    reverseButtons: !0
                })
                .then((willRestore) => {
                    if (willRestore.value === true) {
                        $.ajax({
                            url: restore_url,
                            type: "GET",
                            beforeSend: function() {
                                $('.loading-message').html("Please Wait.");
                                $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    obj.closest('.profile_enable_disable_trigger').find('.enable_disable_label').text('Published');
                                    obj.closest('.profile_enable_disable_trigger').find('.enable_disable_label').addClass('teal white-text text-darken-2');
                                    swal("Done!", data.msg,"success");
                                },
                                error: function(xhr, status, error)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    obj.prop('checked',false);
                                    swal("Oops...!", xhr.responseJSON.msg,"warning");

                                }
                        });
                    }
                    else {
                        $(this).prop('checked',false);
                        willRestore.dismiss;
                    }
                });

            }

            else {
                var obj = $(this);
                var b_profile_id=$(this).attr('bpid');
                var delete_url = '{{ route("business.profile.delete", ":slug") }}';
                    delete_url = delete_url.replace(':slug', b_profile_id);
                swal({
                    title: "Want to disable this profile?",
                    text: "(All products of this profile will be unpublish!)",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    reverseButtons: !0
                })
                .then((willDelete) => {
                    if (willDelete.value === true) {
                        $.ajax({
                            url: delete_url,
                            type: "GET",
                            beforeSend: function() {
                                $('.loading-message').html("Please Wait.");
                                $('#loadingProgressContainer').show();
                            },
                            success:function(data)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    obj.closest('.profile_enable_disable_trigger').find('.enable_disable_label').text('Unpublished');
                                    obj.closest('.profile_enable_disable_trigger').find('.enable_disable_label').removeClass('teal white-text text-darken-2');
                                    swal("Done!", data.msg,"success");
                                },
                                error: function(xhr, status, error)
                                {
                                    $('.loading-message').html("");
		                            $('#loadingProgressContainer').hide();
                                    obj.prop('checked',true);
                                    swal("Oops...!", xhr.responseJSON.msg,"warning");

                                }
                        });
                    }
                    else {
                        $(this).prop('checked',true);
                        willDelete.dismiss;
                    }
                });

            }
        });


//add to wishlist function
function addToWishList(flag, id, obj){

    var id = id;
    var flag= flag;
    var obj = obj;
    swal({
        title: "Want to add this product into wishlist ?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, add it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {
                $.ajax({
                    type:'GET',
                    url: "{{route('add.wishlist')}}",
                    dataType:'json',
                    data:{id : id, flag : flag },
                    beforeSend: function() {
                                $('.loading-message').html("Please Wait.");
                                $('#loadingProgressContainer').show();
                            },
                    success: function(data){
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        obj.addClass('active');
                        swal(data.message);
                    },
                    error: function(xhr, status, error){
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        swal(xhr.responseJSON.message);
                    }
                });
            }
        else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    })
}

</script>

