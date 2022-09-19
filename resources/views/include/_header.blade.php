<!-- Header section start  -->
@php $studio_child= productTypeMapping(1); @endphp
@php $raw_materials_child= productTypeMapping(2); @endphp
<section class="header_wrap sticky_header" itemscope>
	<div class="container" itemscope>
		<!-- Desktop header start -->
		<header class="header_dasktop" itemscope>
			<div class="row header_innrer" itemscope>
				<div class="col m3 logo" itemscope><a href="{{route('home')}}" itemprop="Merchantbay Home"><img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/logo.png')}}" alt="logo" /></a></div>
				<div class="col m5 mainnav_wrap" itemscope>
					<nav class="mainNav" itemscope style="display: none;">
						<ul class="left hide-on-med-and-down" itemscope itemtype="https://schema.org/ListItem">
                            <li itemprop="itemListElement"><a itemprop="Pricing" href="javascript:void(0);">Pricing</a></li>
							<li itemprop="itemListElement"><a href="{{route('new_rfq.index')}}" class="{{ Route::is('new_rfq.index') ? 'active' : ''}}">RFQ</a></li>
							<li itemprop="itemListElement"><a itemprop="Insights" href="javascript:void(0);">Insights</a></li>
							<li itemprop="itemListElement" class="item_whyus">
								<span class="dropdown-trigger parent-li-item" itemprop="Why Us" data-target="whyus-system-links">Why Us<i class="material-icons right">arrow_drop_down</i></span>

								<ul id="whyus-system-links" class="dropdown-content subNav" itemscope itemtype="https://schema.org/ListItem">
									<li itemprop="itemListElement"><a href="{{route('front.howwework')}}" itemprop="How we work" class="{{ Route::is('front.howwework') ? 'active' : ''}}">How we work</a></li>
									<li itemprop="itemListElement"><a itemprop="About Us" href="{{route('front.aboutus')}}">About us</a></li>
									<li itemprop="itemListElement"><a itemprop="About Us" href="{{route('front.faq')}}">FAQ</a></li>
									<li itemprop="itemListElement"><a href="{{route('industry.blogs')}}" itemprop="Blog" class="{{ Route::is('industry.blogs') ? 'active' : ''}}">Blogs</a></li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>


				<div class="col m4 top_right " itemscope>
					<div class="user-block" itemscope>
						@if(env('APP_ENV') == 'production')
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
                                    @if(auth()->user()->user_type == "designer")
									<li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" itemprop="Merchantbay Profile" href="{{ route('single.designer.details', auth()->user()->id) }}"><i class="material-icons">person_outline</i> Profile</a>
									</li>
                                    @else
                                    <li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" itemprop="Merchantbay Profile" href="{{ route('users.profile') }}"><i class="material-icons">person_outline</i> Profile</a>
									</li>
                                    @endif
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
							@endif

						@else
							@if(Auth::guard('web')->check())
								<a href="javascript:void(0);" itemscope class="dropdown-trigger waves-effect waves-block waves-light" data-target="profile-dropdown">
									<span class="avatar-status avatar-online" itemprop="Merchantbay User avatar">
										@if(auth()->user()->image)
										<img src="{{Storage::disk('s3')->url('public/'.auth()->user()->image) }}" itemprop="img" alt="avatar">
										@else
										<img src="{{Storage::disk('s3')->url('public/frontendimages/no-image.png')}}" itemprop="img" alt="avatar">
										@endif
									</span>
								</a>
								<ul id="profile-dropdown" class="dropdown-content card" itemscope itemtype="https://schema.org/ListItem">
                                    @if(auth()->user()->user_type == "designer")
									<li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" itemprop="Merchantbay Profile" href="{{ route('single.designer.details', auth()->user()->id) }}"><i class="material-icons">person_outline</i> Profile</a>
									</li>
                                    @else
                                    <li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" itemprop="Merchantbay Profile" href="{{ route('users.profile') }}"><i class="material-icons">person_outline</i> Profile</a>
									</li>
                                    @endif
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
							@endif

						@endif
					</div>

					<a href="javascript:void(0);" itemprop="Subscribe" type="button" class="btn_profile btn_green">
					    Subscribe
					</a>

				</div>
			</div>
		</header>
		<!-- Desktop header end -->

		<!-- Mobile header -->
		<header class="mobile_header" itemscope>
			<div class="col m2 logo center-align" itemscope>
				<a href="{{route('home')}}" itemprop="Logo"><img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/logo.png')}}" alt="logo" /></a>
			</div>
			<div class="row" itemscope>
				<div class="col s2 mainNav_mobile_wrap" itemscope>
					<span onclick="openNav()" itemprop="Menu Trigger" class="btn-sidenav-left"><i class="material-icons">menu</i></span>
					<div id="mySidenav" class="mySidenav" itemscope>
						<div class="mainNav_mobile_wrap_overlay" onclick="closeNav()" >&nbsp;</div>
						<div class="mainNav_mobile_wrap_inner">
							<span class="closebtn" itemprop="Close Nav" onclick="closeNav()"><i class="material-icons right">keyboard_backspace</i></span>
							<ul itemscope itemtype="https://schema.org/ListItem">
								<li>
									<span class="mobile-parent-li-item" itemprop="Explore" onclick="mobileNavExplore()">Explore <span class="subnev_arrow"><i class="material-icons right">keyboard_arrow_down</i></span></span>
									<ul id="explore-products-mobile" class="subNav" itemscope itemtype="https://schema.org/ListItem" style="display: none">
										<li itemprop="itemListElement">
											<span class="mobile-sub-parent-li-item" itemprop="Studio" onclick="mobileNavStudio()">Studio <span class="subnev_arrow"><i class="material-icons right">keyboard_arrow_down</i></span></span>
											<!-- Dropdown Structure -->
											<ul id="studio-system-links-mobile" class="dropdown-subNav-mobile" itemscope itemtype="https://schema.org/ListItem" style="display: none;">
												@foreach ($studio_child as $id => $title)
													<li itemprop="itemListElement"><a itemprop={{ucwords(str_replace("_", " ",$title))}} href="{{route('product.type.mapping',['studio', $title])}}" >{{ucwords(str_replace("_", " ",$title))}}</a></li>
												@endforeach
											</ul>
										</li>
										<li itemprop="itemListElement">
											<span class="mobile-sub-parent-li-item" itemprop="Products" onclick="mobileNavRawMaterials()">Raw Material <span class="subnev_arrow"><i class="material-icons right">keyboard_arrow_down</i></span></span>
											<!-- Dropdown Structure -->
											<ul id="rawMaterials-system-links-mobile" class="dropdown-subNav-mobile" itemscope itemtype="https://schema.org/ListItem" style="display: none;">
												@foreach ($raw_materials_child as $id => $title)
													<li itemprop="itemListElement"><a itemprop={{ucwords(str_replace("_", " ",$title))}} href="{{route('product.type.mapping',['raw_materials', $title])}}" >{{ucwords(str_replace("_", " ",$title))}}</a></li>
												@endforeach
											</ul>
										</li>
										<li itemprop="itemListElement"><a itemprop="Suppliers" class="{{ Route::is('suppliers') ? 'active' : ''}}" href="{{route('suppliers')}}">Suppliers</a></li>
									</ul>
								</li>
								<li><a href="{{route('new_rfq.index')}}" class="{{ Route::is('new_rfq.index') ? 'active' : ''}}">RFQ</a></li>
								<li itemprop="itemListElement"><a href="https://app.merchantbay.com/">M Factory</a></li>
								<li itemprop="itemListElement">
									<span onclick="mobileNavWhyUs()" class="mobile-parent-li-item" itemprop="Why Us">Why Us <span class="subnev_arrow"><i class="material-icons right">keyboard_arrow_down</i></span></span>
									<ul id="whyus-system-links-mobile" class="subNav" itemscope itemtype="https://schema.org/ListItem" style="display: none;">
										<li itemprop="itemListElement"><a href="{{route('front.howwework')}}" itemprop="How we work" class="{{ Route::is('front.howwework') ? 'active' : ''}}">How we work</a></li>
										<li itemprop="itemListElement"><a itemprop="About Us" href="{{route('front.aboutus')}}">About us</a></li>
										<li itemprop="itemListElement"><a itemprop="FAQ" href="{{route('front.faq')}}">FAQ</a></li>
										<li itemprop="itemListElement"><a href="{{route('industry.blogs')}}" itemprop="Blog" class="{{ Route::is('industry.blogs') ? 'active' : ''}}">Blogs</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col s10 right-align mobile_top_right" itemscope>

					<div class="user-block user-block-mobile mobile_top_icon_box" itemscope>
						@if(env('APP_ENV') == 'production')
							@if(Auth::guard('web')->check() && Cookie::has('sso_token'))
								<a href="javascript:void(0);" class="dropdown-trigger waves-effect waves-block waves-light" data-target="profile-dropdown-mobile" itemscope>
									<span class="avatar-status avatar-online" itemprop="Merchantbay Profile Image">
										@if(auth()->user()->image)
										<img src="{{Storage::disk('s3')->url('public/'.auth()->user()->image) }}" itemprop="img" alt="avatar">
										@else
										<img src="{{Storage::disk('s3')->url('public/frontendimages/no-image.png')}}" itemprop="img" alt="avatar">
										@endif
									</span>
								</a>
								<ul id="profile-dropdown-mobile" class="dropdown-content profile_dropdown_mobile card" itemscope itemtype="https://schema.org/ListItem">
									<li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" href="{{ route('users.profile') }}" itemprop="Profile"><i class="material-icons">person_outline</i> Profile</a>
									</li>
									<li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" href="{{env('SSO_URL').'/profile'}}" itemprop="Settings"><i class="material-icons">settings</i> Settings</a>
									</li>
									<li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" href="{{ route('logout') }}" itemprop="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">keyboard_tab</i> Logout</a>
									</li>
								</ul>
								<form id="logout-form" itemscope action="{{ route('users.logout') }}" method="POST">
									@csrf
								</form>
							@else
								<a href="#login-register-modal" itemprop="Login" class="btn_login_mobile modal-trigger">
									<span class="material-icons">login</span>
								</a>
							@endif

							@else
								@if(Auth::guard('web')->check())
								<a href="javascript:void(0);" itemscope class="dropdown-trigger waves-effect waves-block waves-light" data-target="profile-dropdown-mobile">
									<span class="avatar-status avatar-online" itemprop="Merchantbay Profile Image">
										@if(auth()->user()->image)
										<img src="{{Storage::disk('s3')->url('public/'.auth()->user()->image) }}" itemprop="img" alt="avatar">
										@else
										<img src="{{Storage::disk('s3')->url('public/frontendimages/no-image.png')}}" itemprop="img" alt="avatar">
										@endif
									</span>
								</a>
								<ul id="profile-dropdown-mobile" class="dropdown-content card" itemscope itemtype="https://schema.org/ListItem">
									<li tabindex="0" itemprop="itemListElement">
										<a class="grey-text text-darken-1" itemprop="Profile" href="{{ route('users.profile') }}"><i class="material-icons">person_outline</i> Profile</a>
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
									<a href="#login-register-modal" itemprop="Login" class="btn_login_mobile modal-trigger">
										<span class="material-icons">login</span>
									</a>
							@endif

						@endif
					</div>

					<!-- @if(auth()->user())
						<div class="notifications_icon_wrap mobile_top_icon_box">
							<a href="javascript:void(0);">
								<i class="material-icons">notifications</i>
								<span id="" class="noticication_counter">{{count($userNotifications)}}</span>
							</a>
						</div>
						<ul>
							@foreach($userNotifications as $notification)
							<li class="">
								@if($notification->type == 'App\Notifications\NewOrderHasPlacedNotification')
								<a href="{{route('vendor.order.show.notification',['businessProfile'=>$notification->data['order']['business_profile_id'],'order'=>$notification->data['order']['order_number'],'notification'=>$notification->id])}}">
									<i class="fas fa-envelope mr-2"></i>
									<div class="admin-notification-content">
									<div class="admin-notification-title">{{$notification->data['title']}}</div>
									<div class="text-muted text-sm">{{$notification->created_at}}</div>
									</div>
								</a>
								@elseif ($notification->type == 'App\Notifications\OrderQueryNotification' )
								<a href="{{ url($notification->data['url']) }}" >
									<i class="fas fa-envelope mr-2"></i>
									<div class="admin-notification-content">
									<div class="admin-notification-title">{{$notification->data['title']}}</div>
									<div class="text-muted text-sm">{{$notification->created_at}}</div>
									</div>
								</a>
								@elseif ($notification->type == 'App\Notifications\NewOrderModificationRequestNotification' )
								<a href="{{ $notification->data['url'] }}" >
									<i class="fas fa-envelope mr-2"></i>
									<div class="admin-notification-content">
									<div class="admin-notification-title">{{$notification->data['title']}}</div>
									<div class="text-muted text-sm">{{$notification->created_at}}</div>
									</div>
								</a>
								@elseif ($notification->type == 'App\Notifications\QueryCommuncationNotification' )
								<a href="{{ $notification->data['url'] }}" >
									<i class="fas fa-envelope mr-2"></i>
									<div class="admin-notification-content">
									<div class="admin-notification-title">{{$notification->data['title']}}</div>
									<div class="text-muted text-sm">{{$notification->created_at}}</div>
									</div>
								</a>
								@elseif ($notification->type == 'App\Notifications\PaymentSuccessNotification')
								<a href="{{ $notification->data['url'] }}" >
									<i class="fas fa-envelope mr-2"></i>
									<div class="admin-notification-content">
									<div class="admin-notification-title">{{$notification->data['title']}}</div>
									<div class="text-muted text-sm">{{$notification->created_at}}</div>
									</div>
								</a>
								@elseif ($notification->type =='App\Notifications\NewRfqNotification')
								<a href="{{ $notification->data['url'] }}" >
									<i class="fas fa-envelope mr-2"></i>
									<div class="admin-notification-content">
									<div class="admin-notification-title">{{$notification->data['title']}}</div>
									<div class="text-muted text-sm">{{$notification->created_at}}</div>
									</div>
								</a>
								@elseif ($notification->type =='App\Notifications\RfqBidNotification')
								<a href="{{ $notification->data['url'] }}" >
									<i class="fas fa-envelope mr-2"></i>
									<div class="admin-notification-content">
									<div class="admin-notification-title">{{$notification->data['title']}}</div>
									<div class="text-muted text-sm">{{$notification->created_at}}</div>
									</div>
								</a>
								@endif
							</li>
							@endforeach

							<div class="dropdown-divider"></div>
								<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
							</div>

						</ul>
						<div class="header_message_box mobile_top_icon_box">
							<a href="{{route('message.center')}}">
								<i class="material-icons">message</i>
								<span class="sms_counter ">0</span>
							</a>
						</div>
					@endif -->



					<div class="mobile_notification_wrap" itemscope>
						@if(auth()->user())
							<div class="notifications_icon_wrap mobile_top_icon_box mobile_notifications_icon_wrap" itemscope>
								<a href="javascript:void(0);" class="dropdown-trigger" data-target="countdown-dropdown-mobile" itemprop="User Notification">
									<i class="material-icons">notifications</i>
									<!-- <span id="" class="noticication_counter">{{count($userNotifications)}}</span> -->
									@if(count($userNotifications) > 0)
									<span id="" class="noticication_counter">{{ count($userNotifications) }}</span>
									@endif
								</a>
							</div>

							<ul id="countdown-dropdown-mobile" class="card dropdown-content" itemscope itemtype="https://schema.org/ListItem">
								@if(count($userNotifications)>0)
								<li itemprop="itemListElement" class="">
									@foreach($userNotifications as $notification)
										@if($notification->type == 'App\Notifications\NewOrderHasPlacedNotification')
										<a itemprop="New Order Place Notification" href="{{route('vendor.order.show.notification',['businessProfile'=>$notification->data['order']['business_profile_id'],'order'=>$notification->data['order']['order_number'],'notification'=>$notification->id])}}" class="dropdown-item">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif($notification->type == 'App\Notifications\NewOrderHasApprovedNotification')
										<a itemprop="New Order Approve Notification" href="{{ url($notification->data['url']) }}" class="dropdown-item">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif ($notification->type == 'App\Notifications\OrderQueryNotification' )
										<a href="{{ url($notification->data['url']) }}" itemprop="Order Query Notification" class="dropdown-item">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif ($notification->type == 'App\Notifications\OrderQueryFromAdminNotification' )
										<a href="{{ url($notification->data['url']) }}" itemprop="Order Query From Admin Notification">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>

										@elseif ($notification->type == 'App\Notifications\NewOrderModificationRequestNotification' )
										<a href="{{ url($notification->data['url']) }}" class="dropdown-item" itemprop="New Order Modification Request Notification">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif ($notification->type == 'App\Notifications\QueryCommuncationNotification' )
										<a href="{{ url($notification->data['url']) }}" class="dropdown-item" itemprop="Query Communication Notification">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif ($notification->type == 'App\Notifications\QueryWithModificationToUserNotification')
										<a href="{{ url($notification->data['url']) }}" class="dropdown-item" itemprop="Query With Modification To User Notification">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif ($notification->type == 'App\Notifications\PaymentSuccessNotification')
										<a href="{{ url($notification->data['url']) }}" class="dropdown-item" itemprop="Payment Success Notification">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
												<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
												<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif ($notification->type =='App\Notifications\NewRfqNotification')
										<a href="{{ url($notification->data['url']) }}" class="dropdown-item" itemprop="New RFQ Notification">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
											<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
											<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@elseif ($notification->type =='App\Notifications\RfqBidNotification')
										<a href="{{ url($notification->data['url']) }}" class="dropdown-item" itemprop="RFQ Bid Notification">
											<i class="fas fa-envelope mr-2"></i>
											<div class="admin-notification-content" itemscope>
											<div class="admin-notification-title" itemprop="{{$notification->data['title']}}">{{$notification->data['title']}}</div>
											<div class="text-muted text-sm" itemprop="Create Date" datetime="{{$notification->created_at}}">{{$notification->created_at}}</div>
											</div>
										</a>
										@endif
									@endforeach
								</li>
								@else
								<li itemprop="itemListElement" class="no-notifications">
									No notifications
								</li>
								@endif
							</ul>

							<div class="header_message_box mobile_top_icon_box" itemscope>
								<a href="{{route('message.center')}}" itemprop="Message Center">
									<i class="material-icons">message</i>
									@if($messageCenterNotifications['count'] > 0)
									<span class="sms_counter">{{ $messageCenterNotifications['count'] }}</span>
									@endif
								</a>
							</div>

						@endif
					</div>

					<div class="mobile_top_icon_box" itemscope>
						<a href="{{route('business.profile.create')}}" itemprop="Join MB Pool" type="button" class="btn_joinpool_mobile">
							<span class="material-icons"> add </span>
						</a>
						<!-- <a href="{{route('business.profile.create')}}" itemprop="My Profile" type="button" class="btn_profile_mobile">
							<span class="material-icons"> add </span>
						</a> -->
					</div>

					<button class="header_search_bar">
						<i class="material-icons dp48">search</i>
					</button>

				</div>
			</div>
		</header>
		<!-- Mobile header end -->

		<div class="banner_search" itemscope style="display: none;">
			@php
				$searchType= request()->get('search_type');
			@endphp
			<div class="module-search">
				<select id="searchOption" class="select2 browser-default select-search-type">
					<option value="all" name="search_key" {{ $searchType=="all" ? 'selected' : '' }}>All</option>
					<option value="product" name="search_key" {{ $searchType=="product" ? 'selected' : '' }}>Products</option>
					<option value="vendor"  name="search_key" {{ $searchType=="vendor" ? 'selected' : '' }}>Manufacturers</option>
				</select>
				<form name="system_search" action="{{route('onsubmit.search')}}" id="system_search" method="get">
					@if(Route::is('onsubmit.search'))
					<input type="text" placeholder="Example: Baby Sweaters, T-Shirts, Viscose, Radiant Sweaters etc." value="{{$searchInputValue}}" class="search_input"  name="search_input"/>
					@else
					<input type="text" placeholder="Example: Baby Sweaters, T-Shirts, Viscose, Radiant Sweaters etc." value="" class="search_input"  name="search_input"/>
					@endif
					<input type="hidden" name="search_type" class="search_type" value="" />
					<button class="btn waves-effect waves-light green darken-1 search-btn" type="submit" ><i class="material-icons dp48">search</i></button>
				</form>
				<div id="search-results-wrapper" style="display: none;">
					<div id="loadingSearchProgressContainer">
						<div id="loadingSearchProgressElement">
							<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/loading-gray.gif')}}" width="128" height="15" alt="Loading">
							<div class="loading-message" style="display: none;">Loading...</div>
						</div>
					</div>
					<span class="close-search-modal-trigger"><i class="material-icons dp48">cancel</i></span>
					<div id="search-results" style="display: none;"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Header section end -->

@if(auth()->user())
<div id="mainSidenav" class="mainSidenav">
	<span class="btn_mainSidenav" id="btn_mainSidenav" onclick="openClose()"><i class="material-icons">arrow_forward</i></span>
	<ul>
		<li class="myRfqs{{ Route::is('home') ? ' active' : ''}}">
			<a class="tooltipped" data-position="right" data-tooltip="My RFQs" href="{{route('home')}}">
                <span>My RFQs</span>
            </a>
		</li>
		<li class="myOrders{{ Route::is('po.myorders') ? ' active' : ''}}">
			<a class="tooltipped" data-position="right" data-tooltip="My Orders" href="{{route('po.myorders')}}">
                <span>My Orders</span>
            </a>
		</li>
		<li class="mySupplyChain">
			<a class="tooltipped" data-position="right" data-tooltip="My Supply Chain" href="javascript:void(0);">
                <span>My Supply Chain</span>
            </a>
		</li>
		<li class="designStudio">
			<a class="tooltipped" data-position="right" data-tooltip="Design Studio" href="{{route('product.type.mapping',['studio', 'design'])}}">
                <span>Design Studio</span>
            </a>
		</li>
        <li class="designers{{ Route::is('designers') ? ' active' : ''}}">
			<a class="tooltipped" data-position="right" data-tooltip="Designers" href="{{route('designers')}}">
                <span>Designers</span>
            </a>
		</li>
        <li class="rawMaterials">
			<a class="tooltipped" data-position="right" data-tooltip="Raw Materials" href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">
                <span>Raw Materials</span>
            </a>
		</li>
        <li class="suppliers{{ Route::is('suppliers') ? ' active' : ''}}">
			<a class="tooltipped" data-position="right" data-tooltip="Suppliers" href="{{route('suppliers')}}">
                <span>Suppliers</span>
            </a>
		</li>
        <li class="messages{{ Route::is('message.center') ? ' active' : ''}}">
			<a class="tooltipped" data-position="right" data-tooltip="Messages" href="{{route('message.center')}}">
                <span>Messages</span>
            </a>
		</li>
        <li class="samples">
			<a class="tooltipped" data-position="right" data-tooltip="Samples" href="javascript:void(0);">
                <span>Samples</span>
            </a>
		</li>
        <li class="oms">
			<a class="tooltipped" data-position="right" data-tooltip="OMS" href="javascript:void(0);">
                <span>OMS</span>
            </a>
		</li>
	</ul>
</div>
@endif
