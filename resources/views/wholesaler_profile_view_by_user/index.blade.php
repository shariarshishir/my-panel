@extends('layouts.app_containerless')

@section('content')
@include('sweet::alert')

<!-- Profile section start -->
<section class="profile_bannerwrap">
	<div class="banner_overlay" @if($business_profile->business_profile_banner) style="background:url('{{Storage::disk('s3')->url('public/'.$business_profile->business_profile_banner)}}'); background-size:cover;" @endif>
		<h1>{{$business_profile->business_name}}</h1>
		<h2>In Speed We believe</h2>
        @if($business_profile->is_business_profile_verified == 1)
            <div class="erified">
                <span class="leftText">erified</span> <span class="rightText">by Merchant Bay</span>
            </div>
        @endif
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
						<div class="col s4 m6 l12 profile_left_pic_wrap">
							<div class="profile_pic center-align">
								@if($business_profile->business_profile_logo)
								    <img src="{{ Storage::disk('s3')->url('public/'.$business_profile->business_profile_logo) }}" alt="avatar" >
								@else
                                    @php
                                    $img=$business_profile->user->image ? Storage::disk('s3')->url('public/'.$business_profile->user->image) : 'images/frontendimages/no-image.png';
                                    @endphp
                                    <img src="{{asset($img)}}" alt="avatar" >
								@endif
							</div>
						</div>
						<div class="col s8 m6 l12 profile_left_address_wrap">
							<div class="office_address center-align ">
								<h3>{{$business_profile->business_name}}</h3>
								<p>@php echo ($business_profile->business_type=='manufacturer')?'Manufacturer':'Wholesaler'; @endphp, @if(isset($business_profile->industry_type)){{$business_profile->industry_type}}@endif</p>
								<h4><span class="material-icons">pin_drop</span> <span class="pro_location"> {{$business_profile->location}}</span> <img src="{{asset('images/frontendimages/new_layout_images/bd_flg.png')}}" alt="" style="display: none;" /> </h4>
							</div>
						</div>
					</div>

					@if($business_profile->is_business_profile_verified == 1)
						<div class="center-align">
							@if(Auth::guard('web')->check())
							    <a href="javascript:void(0);" class="btn_green btn_supplier" onClick="contactSupplierFromProduct({{ $business_profile->user->id }}); updateUserLastActivity('{{Auth::id()}}', '{{$business_profile->user->id}}'); sendmessage('{{$business_profile->user->id}}')">Contact supplier</a>
							@else
								<a href="javascript:void(0);" class="btn_green btn_supplier">Contact Supplier</a>
							@endif
						</div>

						<div class="addressBox">
							<span>Head Office </span><br/>
							@if($business_profile->companyOverview->address)
							<p>{{$business_profile->companyOverview->address}}</p>
							@else
							<div class="card-alert card cyan lighten-5">
								<div class="card-content cyan-text">
									<p>INFO :There is no head office address for <b>{{ucwords($business_profile->business_name)}}</b>.</p>
								</div>
							</div>
							@endif
						</div>
						<div class="addressBox">
							<span>Factory Address</span> <br/>
							@if($business_profile->companyOverview->factory_address)
							<p>{{$business_profile->companyOverview->factory_address}}</p>
							@else
							<div class="card-alert card cyan lighten-5">
								<div class="card-content cyan-text">
									<p>INFO :There is no factory address for <b>{{ucwords($business_profile->business_name)}}</b>.</p>
								</div>
							</div>
							@endif
						</div>
					@endif
				</div>
				@if($business_profile->is_business_profile_verified == 1)
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
                                        <p>INFO :There is no main products for <b>{{ucwords($business_profile->business_name)}}</b>.</p>
									</div>
								</div>
								@endif
							@endif
						@endforeach
					</div>
				</div>
				@endif
			</div>
			<!-- Container section start -->
			<div class="col s12 m7 l9 profile_contentCol">
				<div class="profile_tabNav_wrap">
					<div class="profile_tab_menu">
						<ul class="tabs">
							<li class="tab"><a href="#home">Home</a></li>
							<li class="tab @php echo ($flag==1)?'disabled':''; @endphp"><a href="#profile">Profile</a></li>
							<li class="tab @php echo ($flag==1)?'disabled':''; @endphp"><a href="#products">Products</a></li>
							<!--li class="tab col m2"><a href="#womenproducts">Women</a></li-->
							<!--li class="tab"><a href="#factorytour">Factory Tour</a></li-->
							<li class="tab @php echo ($flag==1)?'disabled':''; @endphp"><a href="#termsservice">Terms of Service</a></li>
						</ul>
					</div>
					@if($business_profile->is_business_profile_verified == 0)
						<div class="profile_not_updated">
							<span class="profile_not_updated_inner center-align">
								<div class="annaouncement_icon">&nbsp;</div>
								<p style="font-size: 25px;"> You do not have access to view this profile.</p>
								<p>Become a verified buyer to get full access of Merchant Bay.</p>
								<!-- <p> This profile will be available to view after verification. Meanwhile, <a href="#">Book a Call</a> for more information.</p> -->
							</span>

							<!-- <span class="profile_not_updated_inner">
								<div class="annaouncement_icon">&nbsp;</div>
								<p>You do not have access to view this profile.</p>
								<p>Become a verified buyer to get full access to Merchant Bay services.</p>
								<p> Please <a href="#"> Book a Call </a> for any further information. </p>
							</span> -->

							<div class="center-align">
								<a href="javascript:void(0);" class="button talk-to-us btn_green" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk To Us</a>
							</div>
						</div>
					@else
					<div id="home" class="tabcontent">
						<h3>About the Company</h3>
						<!-- company_stuff -->
						<div class="company_stuff center-align row">
							@foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
								@if($company_overview->name=='floor_space')
									<div class="col s4 m3 l2">
										<div class="company_stuff_img">
											<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory.png')}}" alt="" />
										</div>
										<div class="title">Floor Space</div>
										<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
									</div>
								@endif
								@if($company_overview->name=='no_of_machines')
									<div class="col s4 m3 l2">
										<div class="company_stuff_img">
											<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/sewing-machine.png')}}" alt="" />
										</div>
										<div class="title">No. of Machines</div>
										<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}pcs</div>
									</div>
								@endif
								@if($company_overview->name=='production_capacity')
									<div class="col s4 m3 l3">
										<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/production.png')}}" alt="" />
										<div class="title">Production Capacity</div>
										<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}pcs</div>
									</div>
								@endif
								@if($company_overview->name=='number_of_worker')
									@if(isset($company_overview->value))
										<div class="col s4 m3 l2">
											<div class="company_stuff_img">
												<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/workers.png')}}" alt="" />
											</div>
											<div class="title">No. of workers</div>
											<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
										</div>
									@endif
								@endif
								@if($company_overview->name=='number_of_female_worker')
									@if(isset($company_overview->value))
										<div class="col s4 m3 l2">
											<div class="company_stuff_img">
												<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/human.png')}}" alt="" />
											</div>
											<div class="title">No. of female workers</div>
											<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
										</div>
									@endif
								@endif
							@endforeach
						</div>
						<!-- contentBox -->
						<div class="contentBox">
                            @if($business_profile->companyOverview->about_company)
							    {{$business_profile->companyOverview->about_company}}
                            @endif
						</div>
					</div>
					<!-- Home tabcontent end -->
					<div id="profile" class="tabcontent profile_table_design">
						<div class="overview_table_wrap">
							<div class="row top_titleWrap">
								<div class="col s6 m6">
									<h3>Company Overview</h3>
								</div>
							</div>
							<div class="overview_table box_shadow overview_table_first_table">
								<table>
									<tbody>
										@if(count(json_decode($business_profile->companyOverview->data))>0)
											@foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
												<tr>
													<td>{{str_replace('_', ' ', ucfirst($company_overview->name))}}</td>
													<td class="{{$company_overview->name}}_value">{{$company_overview->value}}</td>
													@if($company_overview->status==1)
													<td><i class="material-icons {{$company_overview->name}}_status" style="color:green">check_circle</i></td>
													@else
													<td><i class="material-icons {{$company_overview->name}}_status"style="color:gray">check_circle</i></td>
													@endif
												</tr>
											@endforeach
										@else
											<div class="card-alert card cyan lighten-5">
												<div class="card-content cyan-text">
													<p>INFO : No data found.</p>
												</div>
											</div>
										@endif
									</tbody>
								</table>
							</div>
						</div>
						@if(count($business_profile->associationMemberships)>0)
							<div class="membership_wrap">
								<div class="row top_titleWrap upload_delete_wrap">
									<div class="col s6 m6">
										<h3>Association memberships</h3>
									</div>
								</div>
								<div class="row membership_textBox association-membership-block">
									@foreach($business_profile->associationMemberships as $associationMembership)
										<div class="center-align association-membership-img">
											<a href="javascript:void(0)" style="display: none;"data-id="{{$associationMembership->id}}" class="remove-association-membership"><i class="material-icons dp48">remove_circle_outline</i></a>
											<div class="imgbox"><img  src="{{ Storage::disk('s3')->url('public/'.$associationMembership->image) }}" alt=""></div>
											<p>{{$associationMembership->title}}</p>
										</div>
									@endforeach
								</div>
							</div>
						@endif

						@if(count($business_profile->pressHighlights)>0)
							<div class="pr_highlights_wrap">
								<div class="row top_titleWrap upload_delete_wrap">
									<div class="col s6 m6">
										<h3>PR Highlights</h3>
									</div>
								</div>
								<div class="row press-highlight-block">
									@foreach($business_profile->pressHighlights as $pressHighlight)
										<div class="col s6 m4 l2 paper_img press-highlight-img">
											<a href="javascript:void(0)" style="display: none;"data-id="{{$pressHighlight->id}}" class="remove-press-highlight"><i class="material-icons dp48">remove_circle_outline</i></a>
											<div class="press_img">
												<div class="press_img_box">
													<img src="{{ Storage::disk('s3')->url('public/'.$pressHighlight->image) }}" alt="" />
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@endif
					</div>
					<div id="products" class="tabcontent">
						<div id="manufacture_edit_errors"></div>
						<div class="manufacture-product-table-data">
							@include('wholesaler_profile_view_by_user._product_list')
						</div>
					</div>
					<div id="factorytour" class="tabcontent" style="display: none;">
						<div class="profile_factory_tourWrap">
							<div class="row top_titleWrap">
								<div class="col s6 m6">
									<h3>Virtual Tour</h3>
								</div>
								<div class="col s6 m6 right-align">
									<a href="javascript:void(0);">Watch on YouTube</a>
								</div>
							</div>
							<div class="factory_video_box">
								<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/video_img.png')}}" />
							</div>
							<div class="factory_imgbox_wrap video_gallery_box">
								<div class="row top_titleWrap">
									<div class="col s6 m6 gallery_navbar">
										<ul>
											<li class="active"><a href="javascript:void(0);">Factory Images</a></li>
											<li><a href="javascript:void(0);">360 Degree Images</a></li>
										</ul>
									</div>
									<div class="col s6 m6 product_view right-align"><a href="javascript:void(0);"> View all </a></div>
								</div>
								<div class="row factory_image_gallery">
									<div class="col s6 m4 l4">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory_1.jpg')}}" alt=""></div>
									</div>
									<div class="col s6 m4 l4">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory_2.jpg')}}" alt=""></div>
									</div>
									<div class="col s6 m4 l4">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory_3.jpg')}}" alt=""></div>
									</div>
									<div class="col s6 m4 l4">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory_4.jpg')}}" alt=""></div>
									</div>
									<div class="col s6 m4 l4">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory_5.jpg')}}" alt=""></div>
									</div>
									<div class="col s6 m4 l4">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory_1.jpg')}}" alt=""></div>
									</div>
								</div>
							</div>
							<div class="factory_imgbox_wrap video_gallery_box">
								<div class="row top_titleWrap">
									<div class="col s6 m6 gallery_navbar">
										<ul>
											<li><a href="javascript:void(0);">Factory Images</a></li>
											<li class="active"><a href="javascript:void(0);">360 Degree Images</a></li>
										</ul>
									</div>
									<div class="col s6 m6 product_view right-align"><a href="javascript:void(0);"> View all </a></div>
								</div>
								<div class="row 360_degree_video_gallery">
									<div class="col s12 m6 l6">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/360_degree_img1.png')}}" alt=""></div>
									</div>
									<div class="col s12 m6 l6">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/360_degree_img2.png')}}" alt=""></div>
									</div>
									<div class="col s12 m6 l6">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/360_degree_img3.png')}}" alt=""></div>
									</div>
									<div class="col s12 m6 l6">
										<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/360_degree_img4.png')}}" alt=""></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="termsservice" class="tabcontent">
						<h3>Terms of Service</h3>
						@if($business_profile->companyOverview->terms_of_service)
							<div class="terms-of-service-with-information" >
								<p>{{$business_profile->companyOverview->terms_of_service}}</p>
							</div>
						@else
							<div class="card-alert card cyan lighten-5 terms-of-service-without-information" >
								<div class="card-content cyan-text">
									<p>INFO : No terms of service added by {{$business_profile->business_name}}</p>
								</div>
							</div>
						@endif
					</div>
					@endif
				</div>
			</div>
			<!-- Container section end -->
		</div>
	</div>
</section>

@endsection

@include('wholesaler_profile_view_by_user._scripts')
