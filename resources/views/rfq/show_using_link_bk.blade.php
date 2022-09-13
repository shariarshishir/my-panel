@extends('layouts.app')

@section('content')

<!-- <div>
    <a class="waves-effect waves-light btn modal-trigger" href="#create-rfq-form">Create Rfq</a>
</div> -->
@include('rfq._create_rfq_form_modal')
<div id="errors">

</div>

<!-- RFQ html start -->

<div class="box_shadow_radius rfq_content_box rfg_share_boxwrap">
	<div class="rfq_info_wrap right-align rfq_top_navbar rfg_share_top_navbar">
		{{-- <ul>
			<li class="{{ Route::is('rfq.index') ? 'active' : ''}}"><a href="{{route('rfq.index')}}" class="btn_grBorder">RFQ Home</a></li>
			<li class="{{ Route::is('rfq.my') ? 'active' : ''}}"><a href="{{route('rfq.my')}}" class="btn_grBorder">My RFQs</a></li>
			<li style="display: none;"><a href="javascript:void(0);" class="btn_grBorder">Saved RFQs</a></li>
			<li>
                @auth
                    <a class="btn_grBorder modal-trigger" href="#create-rfq-form">Create RFQ</a>
                @else
                    <a href="/login" class="btn_grBorder">Create RFQ</a>
                @endauth

            </li>
		</ul> --}}
	</div>
	<!--div class="rfq_day_wrap center-align"><span>Today</span></div-->
        <div class="rfq_profile_detail rfg_share_box row">
            <div class="col s12 m3 l2 rfg_share_left">
                <div class="rfq_profile_img">
                    @if($rfq->user->image)
                    <img src="{{ asset('storage/'.$rfq->user->image) }}" alt="" />
                    @else
                    <img src="{{asset('images/frontendimages/no-image.png')}}" alt="avatar">
                    @endif
                </div>
            </div>
            <div class="col s12 m9 l10 rfq_profile_info">
                <div class="row">
                    <div class="profile_info col s12 m8 l8">
                        <h4>
                            {{ $rfq->user->name}}
                            @if(isset($rfq->businessProfile->is_business_profile_verified))
                            <img src="{{asset('images/frontendimages/new_layout_images/verified.png')}}" alt="" />
                            @endif
                        </h4>
                        <p>Merchandiser, Fashion Tex Ltd.</p>
                    </div>
                </div>


                <div class="rfq_view_detail_wrap">
                    <h5>{{$rfq->title}}</h5>
                    <span class="short_description">{{$rfq->short_description}}</span>

                    <div class="rfq_view_detail_info">
                        <h6>Query for {{$rfq->category->name}}</h6>
                        <div class="full_specification"><span class="title">Details:</span> {{$rfq->full_specification}}</div>
                        <div class="full_details">
                            <p><span class="title">Qty:</span> {{$rfq->quantity}} {{$rfq->unit}},</p>
                            @if($rfq->unit_price==0.00)
                            <p><span class="title">Target Price:</span> N/A,</p>
                            @else
                            <p><span class="title">Target Price:</span> $ {{$rfq->unit_price}},</p>
                            @endif
                            <p><span class="title">Deliver to:</span> {{$rfq->destination}},</p>
                            <p><span class="title">Within:</span> {{ date('F j, Y',strtotime($rfq->delivery_time)) }},</p>
                            <p><span class="title">Payment method:</span> {{$rfq->payment_method}}</p>
                        </div>
                    </div>
                </div>
                <!--div class="tagS">
                    <a href="javascript:void(0);"> #Sweater</a> <a href="javascript:void(0);"> #Apparel</a>
                </div-->
                @php $i=1; @endphp
                <div class="row rfq_thum_imgs left-align">
                    @if($rfq->images()->exists())
                        @foreach ($rfq->images as  $key => $rfqImage )
                            @if(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'pdf' || pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'PDF')
                                <div class="rfq_thum_img">
                                    <a href="{{ asset('storage/'.$rfqImage->image) }}" class="pdf_icon" target="_blank">&nbsp; PDF</a>
                                </div>
                            @elseif(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'doc' || pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'docx')
                                <div class="rfq_thum_img">
                                    <a href="{{ asset('storage/'.$rfqImage->image) }}" class="doc_icon" >&nbsp; DOC</a>
                                </div>
                            @elseif(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'xlsx')
                                <div class="rfq_thum_img">
                                    <a href="{{ asset('storage/'.$rfqImage->image) }}" class="xlsx_icon" >&nbsp; XLSX</a>
                                </div>
                            @elseif(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'TAR'|| pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'tar'|| pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'rar'|| pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'RAR' ||pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'zip' || pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'ZIP')
                                <div class="rfq_thum_img">
                                    <a href="{{ asset('storage/'.$rfqImage->image) }}" class="zip_icon" >&nbsp; DOC</a>
                                </div>
                            @else
                                <div class="rfq_thum_img">
                                    <a data-fancybox="gallery-{{$i}}" href="{{asset('storage/'.$rfqImage->image)}}">
                                        <img src="{{asset('storage/'.$rfqImage->image)}}" alt="" />
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>



                <div class="responses_wrap right-align">
                @auth
                    @if($rfq->user->id != auth()->id())
                        @if(isset($rfq->bid_user_id))
                            <a href="javascript:void(0);" class="bid_rfq" onclick="openBidRfqModal({{$rfq->id}})">{{ in_array(auth()->id(), $rfq->bid_user_id) ? 'Replied' : 'Replay On this RFQ' }}</a>
                        @else
                            <a href="javascript:void(0);" class="bid_rfq" onclick="openBidRfqModal({{$rfq->id}})">Reply on this RFQ</a>
                        @endif
                    @endif
                @else
                    <a class="modal-trigger" href="#from-rfq-link-login-register-modal" >Reply on this RFQ</a>
                @endauth


                    <button class="none_button btn_responses" id="rfqResponse" >
                        Responses <span class="respons_count  res_count_{{$rfq->id}}_">{{$rfq->bids_count}}</span>
                    </button>
                </div>

            </div>
        </div>
</div>
<!-- RFQ html end -->

@include('rfq._create_rfq_bid_form_modal')

<div id="from-rfq-link-login-register-modal" class="modal modal-fixed-footer" tabindex="0">
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
                    {{-- <input type="hidden" name="fcm_token" id="fcm_token" value=""> --}}
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input id="rfqemail_login" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email" class="">{{ __('E-Mail Address') }}</label>
                            <span class="text-danger error-text rfqemail_err"></span>
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
                            <input id="rfqpassword_login" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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

                    <button class="btn green waves-effect waves-light right signin-from-rfq-share-link signin" type="submit" name="log-in">
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

@endsection

@include('rfq._scripts')

@push('js')
    <script>
        $('.signin-from-rfq-share-link').click(function (e) {
        e.preventDefault();
        var email = $('#rfqemail_login').val();
        var password=$('#rfqpassword_login').val();
        var fcm_token=$('#fcm_token').val();
        var remember =$(this).closest('#from-rfq-link-login-register-modal').find('input[name="remember"]').prop('checked');
        $.ajax({
            url: "{{route('login.from.rfq.share.link')}}",
            type: "POST",
            data: {"rfqemail": email, "rfqpassword": password ,"fcm_token":fcm_token, "remember": remember, "_token": "{{ csrf_token() }}"},
            success: function (data) {
                    if($.isEmptyObject(data.error)){
                       if(data.msg){
                        //$('.error-msg').show().text(data.msg);
                        // alert(data.msg);
                        $('#rfqemail_login').addClass('invalid');
                        $('#rfqpassword_login').addClass('invalid');
                       }
                       else{
                          //console.log(data);
                         window.location.href=data.url;
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
@endpush
