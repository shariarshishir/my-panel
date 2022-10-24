<div itemscope itemtype="https://schema.org/Organization">
<!-- Profile section start -->
@php
$profileEditMode = Request::get('editmode');
@endphp
<section class="profile_bannerwrap">
	<div class="banner_overlay" @if($business_profile->business_profile_banner) style="background:url('{{Storage::disk('s3')->url('public/'.$business_profile->business_profile_banner)}}; background-size:cover;" @endif>
		<h1 itemprop="legalName">{{$business_profile->business_name}}</h1>
		<h2>In Speed We believe</h2>
		@if($business_profile->is_business_profile_verified == 1)
		<div class="erified">
		<span class="leftText">erified</span> <span class="rightText">by Merchant Bay</span>
		</div>
		@endif
		<div class="edit_profile_option">
			<a href="javascript:void(0);" class="edit_wholesaler_profile_trigger"><i class="material-icons">border_color</i></a>
		</div>
	</div>
</section>
<!-- Profile section end -->

<!-- Main Container start -->
<section class="mainContainer profile_container">
	<div class="container">
		<div class="row">
			<div class="col s12 m5 l3 profile_leftCol leftCol_wrap">
				<div class="left_top">
					<div class="row">
						<div class="col s4 m6 l12 profile_left_pic_wrap business_profile_logo">
							<div class="profile_pic center-align">
								@if($business_profile->business_profile_logo)
								    <img itemprop="image" src="{{ Storage::disk('s3')->url('public/'.$business_profile->business_profile_logo) }}" alt="avatar" >
								@else
                                    @php
                                    $img=$business_profile->user->image ?'storage/'.$business_profile->user->image : 'images/frontendimages/no-image.png';
                                    @endphp
								    <img itemprop="image" src="{{asset($img)}}" alt="avatar" >
								@endif
							</div>
						</div>
                        @if(@$profileEditMode == 'enabled')
                            <a class="waves-effect waves-light btn_green modal-trigger edit_left_profile" href="#business_profile_logo_banner"><i class="material-icons">border_color</i></a>
                        @endif

						<div class="col s8 m6 l12 profile_left_address_wrap">
							<div class="office_address center-align ">
								<h3 itemprop="legalName">{{$business_profile->business_name}}</h3>
								<p>@php echo ($business_profile->business_type=='manufacturer')?'Manufacturer':'Wholesaler'; @endphp, {{$business_profile->industry_type}}</p>
								<h4><span class="material-icons">pin_drop</span><span class="pro_location" itemprop="location" itemscope itemtype="https://schema.org/Place"> {{$business_profile->location}} </span> <img src="{{asset('images/frontendimages/new_layout_images/bd_flg.png')}}" style="display: none;" alt="" /> </h4>
							</div>
						</div>
					</div>

					<div class="center-align" style="display: none;">
						<a href="#" class="btn_green btn_supplier">Contact Supplier</a>
					</div>
					<div class="addressBox">
						<span>Head Office </span><br/>
						<div id="head-office">
							@if($business_profile->companyOverview->address)
								<p itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">{{$business_profile->companyOverview->address}}</p>
							@else
							<div class="card-alert card cyan lighten-5">
								<div class="card-content cyan-text">
									INFO : No data found.
								</div>
							</div>
							@endif
						</div>
					</div>
					<div class="addressBox">
						<span>Factory Address</span> <br/>
						<div id="factory-address">
							@if($business_profile->companyOverview->factory_address)
								<p itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">{{$business_profile->companyOverview->factory_address}}</p>
							@else
							<div class="card-alert card cyan lighten-5">
								<div class="card-content cyan-text">
									INFO : No data found.
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
				<div class="left_bottom">
					<h3 class="center-align" >Main Products</h3>
					<div id="main-products">
						@foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
							@if($company_overview->name=="main_products")
								@if($company_overview->value)
									<p>{{$company_overview->value}}</p>
								@else
								<div class="card-alert card cyan lighten-5 no-info-message">
									<div class="card-content cyan-text">
										INFO : No data found.
									</div>
								</div>
								@endif
							@endif
						@endforeach
					</div>
				</div>
			</div>

			<!-- Container section start -->
			<div class="col s12 m7 l9 profile_contentCol wholesaler_profile_info_details">
				<div class="profile_tabNav_wrap"> <!-- div close in profile_footer file -->
