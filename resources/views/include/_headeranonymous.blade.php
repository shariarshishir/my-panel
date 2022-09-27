<!-- Header section start  -->
@php $studio_child= productTypeMapping(1); @endphp
@php $raw_materials_child= productTypeMapping(2); @endphp
<section class="header_wrap sticky_header" itemscope>
	<div class="container" itemscope>
		<!-- Desktop header start -->
		<header class="header_dasktop" itemscope>
			<div class="row header_innrer" itemscope>
				<div class="col m3 logo" itemscope><a href="{{route('home')}}" itemprop="Merchantbay Home"><img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/logo.png')}}" alt="logo" /></a></div>



                @if(Auth::guard('web')->check() && Cookie::has('sso_token'))
                <a itemprop="Merchantbay Profile" href="javascript:void(0);" class="dropdown-trigger waves-effect waves-block waves-light" data-target="profile-dropdown">
                    <span class="avatar-status avatar-online" itemprop="Merchantbay User avatar">
                        @if(auth()->user()->image)
                        <img src="{{Storage::disk('s3')->url('public/'.auth()->user()->image) }}" alt="avatar" itemprop="img">
                        @else
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/no-image.png')}}" alt="avatar" itemprop="img">
                        @endif
                    </span>
                </a>
                <ul id="profile-dropdown" class="dropdown-content" itemscope itemtype="https://schema.org/ListItem">
                    <li tabindex="0" itemprop="itemListElement">
                        <a class="grey-text text-darken-1" itemprop="Merchantbay Profile" href="{{ route('users.profile') }}"><i class="material-icons">person_outline</i> Profile</a>
                    </li>
                    <li tabindex="0" itemprop="itemListElement">
                        <a class="grey-text text-darken-1" itemprop="Settings" href="{{env('SSO_URL').'/profile'}}"><i class="material-icons">settings</i> Settings</a>
                    </li>
                    <li tabindex="0" itemprop="itemListElement">
                        <a class="grey-text text-darken-1" itemprop="Logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">keyboard_tab</i> Logout</a>
                    </li>
                </ul>
                <form id="logout-form" itemscope action="{{ route('users.logout') }}" method="POST">
                    @csrf
                </form>
            @else
                <a href="#login-register-modal" itemprop="Login / Register" class="btn_logRegi btn_white modal-trigger">Login / Register</a>
            @endif

			</div>
		</header>
		<!-- Desktop header end -->


	</div>




</section>



<!-- Header section end -->



