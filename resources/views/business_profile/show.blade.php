@extends('layouts.app_containerless')

@section('content')
@include('sweet::alert')

<div itemscope itemtype="https://schema.org/Organization">
<!-- Profile section start -->
<section class="profile_bannerwrap">
	<div class="banner_overlay" @if($business_profile->business_profile_banner) style="background:url('Storage::disk('s3')->url('public/'.$business_profile->business_profile_banner}}'); background-size:cover;" @endif>
		<h1>{{$business_profile->business_name}}</h1>
		<h2>In Speed We believe</h2>
		@if($business_profile->is_business_profile_verified == 1)
		<div class="erified">
		<span class="leftText">erified</span> <span class="rightText">by Merchant Bay</span>
		</div>
		@endif
		<div class="edit_profile_option">
			<a href="javascript:void(0);" class="edit_profile_trigger"><i class="material-icons">border_color</i></a>
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
						<div class="col s4 m6 l12 profile_left_pic_wrap">
							<div class=" profile_pic center-align business_profile_logo">
								@if($business_profile->business_profile_logo)
								    <img itemprop="image" src="{{ Storage::disk('s3')->url('public/'.$business_profile->business_profile_logo) }}" alt="avatar" >
								@else
								    @php
                                    $img = $business_profile->user->image ? Storage::disk('s3')->url('public/'.$business_profile->user->image) : 'asset(images/frontendimages/no-image.png)';
                                    @endphp
								    <img itemprop="image" src="{{$img}}" alt="avatar" >
								@endif
							</div>
                            <div class="change_photo edit_busniess_profile_logo_banner">
                                <a class="waves-effect waves-light btn_green modal-trigger edit_left_profile" href="#business_profile_logo_banner"><i class="material-icons">border_color</i></a>
                            </div>
						</div>
						<div class="col s8 m6 l12 profile_left_address_wrap">
							<div class="office_address center-align ">
								<h3 itemprop="legalName">{{$business_profile->business_name}}</h3>
								<p>@php echo ($business_profile->business_type=='manufacturer')?'Manufacturer':'Wholesaler'; @endphp, {{ucwords($business_profile->industry_type)}}</p>
								<h4><span class="material-icons">pin_drop</span> <span class="pro_location" itemprop="location" itemscope itemtype="https://schema.org/Place"> {{$business_profile->location}} </span> <img src="{{asset('images/frontendimages/new_layout_images/bd_flg.png')}}" style="display: none;" alt="" /> </h4>
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
			<div class="col s12 m7 l9 profile_contentCol manufacturer_profile_info_details">
				<div class="profile_tabNav_wrap">
					<div class="profile_tab_menu">
						<ul class="tabs">
							<li class="tab home-tab"><a href="#home">Home</a></li>
							<li class="tab profile-tab"><a href="#profile">Profile</a></li>
							<li class="tab products-tab"><a href="#products">Products</a></li>
							<!--li class="tab col m2"><a href="#womenproducts">Women</a></li-->
							<li class="tab factorytour-tab"><a href="#factorytour">Factory Tour</a></li>
							<li class="tab tos-tab"><a href="#termsservice">Terms of Service</a></li>
						</ul>
					</div>
					@if($business_profile->is_business_profile_verified == 0)
					<div class="profile_verification_request_block">
						@if($business_profile->businessProfileVerificationsRequest)
						<div class="card-alert card orange lighten-5">
							<div class="card-content orange-text">
								<p><i class="material-icons verification-info-icon">info_outline</i> Your request is awaiting for verification. <a href="#send-verification-request-modal" class="send-verification-request-trigger modal-trigger">Resend Request</a></p>
							</div>
						</div>
						@else
						<div class="card-alert card orange lighten-5">
							<div class="card-content orange-text">
								<p><i class="material-icons verification-info-icon">info_outline</i> Your profile is not verified. <a href="#send-verification-request-modal" class="send-verification-request-trigger modal-trigger">Send Request</a></p>
							</div>
						</div>
						@endif
					</div>
					@endif
					<div id="home" class="tabcontent">
						<h3>About the Company</h3>
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
									<div class="col s4 m3 l2">
										<div class="company_stuff_img">
											<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/workers.png')}}" alt="" />
										</div>
										<div class="title">No. of workers</div>
										<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
									</div>
								@endif
								@if($company_overview->name=='number_of_female_worker')
									<div class="col s4 m3 l2">
										<div class="company_stuff_img">
											<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/human.png')}}" alt="" />
										</div>
										<div class="title">No. of female workers</div>
										<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
									</div>
								@endif
							@endforeach
						</div>
						<!-- company_stuff -->
						<div  class="contentBox">
							<p id="about-company-information" itemprop="description">
							{{$business_profile->companyOverview->about_company}}
							</p>
						</div>
						<!-- contentBox -->
						<div class="certifications">
							<h3>Certifications</h3>
							<div class="certifications-block">
								@if(count($business_profile->certifications)>0)
									@foreach($business_profile->certifications as $certification)
									<div class="certificate_img_wrap">
										@if(pathinfo($certification->image, PATHINFO_EXTENSION) == 'pdf' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'PDF')
											<div class="certificate_img">
												<!-- <i class="fa fa-file-pdf-o" style="font-size:48px;color:red"></i>
												<br> -->
												<a href="{{ Storage::disk('s3')->url('public/'.$certification->image) }}" data-id="{{$certification->id}}" data-position="top" data-tooltip="Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}<br />Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}" class="certification_file_down tooltipped">&nbsp;</a>
											</div>
											<div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
												@if($certification->issue_date)
												<span class="issue-date">Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}</span>
												@endif
												@if($certification->expiry_date)
												<span class="expiry-date">Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}</span>
												@endif
											</div>

										@elseif(pathinfo($certification->image, PATHINFO_EXTENSION) == 'doc' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'docx' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'DOCX' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'DOC' )

											<div class="certificate_img">
												<a href="{{ Storage::disk('s3')->url('public/'.$certification->image) }}" data-id="{{$certification->id}}" data-position="top" data-tooltip="Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}<br />Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}" class="certification_doc tooltipped certification_file_down">&nbsp;</a>
											</div>
											<div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
												@if($certification->issue_date)
												<span class="issue-date">Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}</span>
												@endif
												@if($certification->expiry_date)
												<span class="expiry-date">Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}</span>
												@endif
											</div>
										@else
											@php $certification_image_src=$certification->image ?$certification->image :  $certification->default_certification->logo ; @endphp
											<div class="certificate_img"><a data-fancybox="certificate-gallery" data-caption="Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}<br />Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}" href="{{ Storage::disk('s3')->url('public/'.$certification_image_src) }}"><img  src="{{ Storage::disk('s3')->url('public/'.$certification_image_src) }}" alt=""></a></div>
											<div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
												@if($certification->issue_date)
												<span class="issue-date">Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}</span>
												@endif
												@if($certification->expiry_date)
												<span class="expiry-date">Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}</span>
												@endif
											</div>
										@endif
									</div>
									@endforeach
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>

						</div>

						<!-- certifications -->
						<div class="product_design_wrapper">
							<div class="profile_product_wrap product_wrapper">
								<div class="row top_titleWrap">
									<div class="col s6 m6">
										<h3>Main Products</h3>
									</div>
									<!--div class="col s6 m6 product_view right-align"><a href="javascript:void(0);"> View all </a></div-->
								</div>
								<div class="product_boxwrap row">
									@if(count($mainProducts)>0)
										@foreach($mainProducts as $product)
										<div class="col s6 m4 l3 product_item_box">
											<div class="productBox">
												<div class="favorite">
													<a href="javascript:void(0);" id="favorite" data-productSku="{{$product->sku}}" class="product-add-wishlist">
														<i class="material-icons dp48">favorite</i>
													</a>
												</div>
												<div class="inner_productBox">
													<a href="{{ route("mix.product.details", [$product->flag, $product->id]) }}" >
														<div class="imgBox">
															@foreach($product->product_images as $image)
																<img src="{{Storage::disk('s3')->url('public/'.$image->product_image)}}" class="single-product-img" alt="" />
																@break
															@endforeach
														</div>

														<div class="products_inner_textbox">

															<div class="row">
																<div class="col s6">
																	<h4><span>{{$product->title}}</span></h4>
																</div>
																<div class="col s6">
																	@if(isset($product->moq))
																		<div class="product_moq"><span class="moq">MOQ:</span> {{$product->moq}} <span class="moq-unit">{{ $product->qty_unit }}</span></div>
																	@endif
																</div>
															</div>

															<!-- <div class="priceBox row">
																<div class="col s12 m12 l4 apperal">
																	<a href="{{ route("supplier.profile",$product->businessProfile->alias) }}">

																	</a>
																</div>
																<div class="col s12 m12 l8 right-align price">
																	$ {{$product->price_per_unit}}/<span class="unit"> {{$product->qty_unit}}</span>
																</div>
															</div>

															<h4><a href="{{ route("mix.product.details", [$product->flag, $product->id]) }}" >{{$product->title}}</a></h4>

															@if(isset($product->moq))
																<div class="product_moq">MOQ: {{$product->moq}} {{ $product->qty_unit }}</div>
															@endif
															@if(isset($product->lead_time))
																<div class="product_lead_time">Lead time:
																	@php
																		$pattern= '/[^0-9\-]/';
																		$preg_replace= preg_replace($pattern, '', $product->lead_time);
																	@endphp
																	{{$preg_replace}} days
																</div>
															@endif -->
															{{-- <a href="{{route('mix.product.details',['flag' => $product->flag, 'id' => $product->id])}}">
																<div class="priceBox row">
																	<!-- <div class="col s12 m6 apperal"><a href="{{route('supplier.profile',$product->businessProfile->alias)}}">{{ $product->businessProfile->business_name }}</a></div> -->
																	<div class="col s12 m6 apperal">{{ $product->businessProfile->business_name }}</div>
																	<div class="price col s12 m6 right-align lead-time-value">lead time: {{$product->lead_time}}</div>
																</div>
																<h4>{{$product->title}}</h4>
																@if(isset($list->moq))
																	<div class="product_moq">MOQ: {{$list->moq}}</div>
																@endif
																@if(isset($list->lead_time))
																	<div class="product_lead_time">Lead time: {{$list->lead_time}}</div>
																@endif
															</a> --}}


														</div>
													</a>
												</div>

												<!-- <div class="priceBox row"></div>
												<h4>
													<a href="{{route('mix.product.details', ['mb', $product->id])}}">
														{{ \Illuminate\Support\Str::limit($product->title, 35, '...') }}
													</a>
												</h4>
												<div class="moq" style="display: none;">MOQ  150 <span>pcs</span></div>
												<div class="leadTime" style="display: none;">Lead time 10 <span>days</span></div> -->
											</div>

										</div>
									@endforeach
									@else
										<div class="card-alert card cyan lighten-5">
											<div class="card-content cyan-text">
												<p>INFO : No Main Products.</p>
											</div>
										</div>
									@endif
								</div>
							</div>
						</div>

						<!-- profile_product_wrap -->
						<div class="factory_imgbox_wrap">
							<h3>Factory Images</h3>

							@if(count($business_profile->companyFactoryTour)>0)
								<div class="row top_titleWrap">
									<div class="col s12 gallery_navbar">
										<ul class="tabs">
											<li class="tab col m3"><a class="active" href="#factory_show_images">Factory Images</a></li>
											<li class="tab col m3"><a href="#factory_degree_show_images">360 Degree Images</a></li>
										</ul>
									</div>
								</div>
								<div id="factory_show_images" class="factory_imgbox_innerwrap">
									<div class="row factory_image_gallery">
									@if(count($companyFactoryTour->companyFactoryTourImages)>0)
										@foreach($companyFactoryTour->companyFactoryTourImages as $image)
											<div class="col s6 m4 l4">
												<div class="imgBox">
													<a data-fancybox="factory-image-gallery" href="{{Storage::disk('s3')->url('public/'.$image->factory_image)}}">
														<img src="{{Storage::disk('s3')->url('public/'.$image->factory_image)}}" alt="">
													</a>
												</div>
											</div>
										@endforeach
									@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No Image found.</p>
										</div>
									</div>
									@endif

									</div>
								</div>
								<div id="factory_degree_show_images" class="video_gallery_box">
									<div class="row degree_360_video_gallery">
									@if(count($companyFactoryTour->companyFactoryTourLargeImages)>0)
									@foreach($companyFactoryTour->companyFactoryTourLargeImages as $image)
										<div class="col s12 m6 l6">
											<div class="imgBox">
												<a data-fancybox="factory-360image-gallery" href="{{Storage::disk('s3')->url('public/'.$image->factory_large_image)}}">
													<img src="{{Storage::disk('s3')->url('public/'.$image->factory_large_image)}}" alt="">
												</a>
											</div>
										</div>
									@endforeach
									@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No Image found.</p>
										</div>
									</div>
									@endif

									</div>
								</div>
							@else
								<div class="card-alert card cyan lighten-5">
									<div class="card-content cyan-text">
										<p>INFO : No data found.</p>
									</div>
								</div>
							@endif

						</div>
						<!-- factory_images -->
						<div class="main_buyers_wrap">
							<h3>Main Buyers</h3>
							<div class="buyers_logo_wrap row main-buyers-block">
								@if(count($business_profile->mainBuyers)>0)
								@foreach($business_profile->mainBuyers as $mainBuyers)
									<div class="col s6 m4 l3 main_buyer_box">
										<a href="javascript:void(0);"></a>
										<div class="main_buyer_img">
											<img  src="{{ Storage::disk('s3')->url('public/'.$mainBuyers->image) }}" alt="">
										</div>
										<h5>{{$mainBuyers->title}}</h5>
									</div>
								@endforeach
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>

						</div>
						<!-- main_buyers logo -->
						<div class="export_destination_wrap">
							<h3>Export Destinations</h3>
							<div class="row flag_wrap center-align export-destination-block">
								@if(count($business_profile->exportDestinations)>0)
									@foreach($business_profile->exportDestinations as $exportDestination)
										<div class="col s6 m4 l2">
											<div class="flag_innerBox">
												<div class="flag_img export-destination-img">
													<img  src="{{Storage::disk('s3')->url('public/frontendimages/flags/'.strtolower($exportDestination->country->code).'.png')}}" alt="">
												</div>
												<div class="flag_infoBox">
													<h5>{{$exportDestination->country->name}}</h5>
													<span>{{$exportDestination->short_description}}</span>
												</div>
											</div>
										</div>
									@endforeach
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif

							</div>


						</div>
						<!-- export_destination -->
					</div>
					<!-- Home tabcontent end -->
					<div id="profile" class="tabcontent profile_table_design">
						<div class="overview_table_wrap">
							<div class="row top_titleWrap">
								<div class="col s9 m7">
									<h3>Company Overview</h3>
								</div>
								@if(Auth::check())
								<div class="col s3 m5 right-align editBox">
									<button data-target="company-overview-modal" type="button" class="btn_edit btn_green_White modal-trigger">
										<span class="btn_icon"><i class="material-icons">border_color</i></span>
										<span class="btn_edit_white"> Edit</span>
									</button>
								</div>
								@endif
							</div>
							<div class="overview_table company_overview_table box_shadow">
								<table>
									<tbody>
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
									</tbody>
								</table>
							</div>
						</div>
						<div class="overview_table_wrap capacity_machineries">

                            <div class="row top_titleWrap">
								<div class="col s9 m7">
									<h3>Categories Produced</h3>
								</div>
								@if(Auth::check())
								<div class="col s3 m5 right-align editBox">
									<button type="button" data-target="categorires-produced-modal" class="btn_edit btn_green_White modal-trigger">
										<span class="btn_icon"><i class="material-icons">border_color</i></span>
										<span class="btn_edit_white"> Edit</span>
									</button>
								</div>
								@endif
							</div>
							<div class="row capacity_table">

								<!-- <div class="col s12 m6">
									<h4>Production Capacity (Annual)</h4>
									<div class="production-capacity-wrapper">
										@if(count($business_profile->productionCapacities)>0)
										<div class="overview_table box_shadow">
											<table>
												<thead>
													<tr>
														<th>Machine Type</th>
														<th>Annual Capacity</th>
														<th>&nbsp;</th>
													</tr>
												</thead>
												<tbody class="production-capacity-table-body">
													@foreach($business_profile->productionCapacities as $productionCapacity)
														<tr>
															<td>{{$productionCapacity->machine_type}}</td>
															<td>{{$productionCapacity->annual_capacity}}</td>
															@if($productionCapacity->status==1)
															<td><i class="material-icons" style="color:green">check_circle</i></td>
															@else
															<td><i class="material-icons "style="color:gray">check_circle</i></td>
															@endif
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										@else
										<div class="card-alert card cyan lighten-5">
											<div class="card-content cyan-text">
												<p>INFO : No data found.</p>
											</div>
										</div>
										@endif
									</div>
								</div> -->

								<div class="col s12 m12">
									<div class="categories_produced_wrapper">
										@if(count($business_profile->categoriesProduceds)>0)
										<div class="overview_table box_shadow">
											<div class="no_more_tables">
												<table>
													<thead class="cf" >
														<tr>
															<th>Type</th>
															<th>Percentage</th>
															<th>&nbsp;</th>
														</tr>
													</thead>
													<tbody class="categories-produced-table-body">
														@foreach($business_profile->categoriesProduceds as $categoriesProduced)
														<tr>
															<td data-title="Type">{{$categoriesProduced->type}}</td>
															<td data-title="Percentage">{{$categoriesProduced->percentage}}</td>
															@if($categoriesProduced->status==1)
															<td><i class="material-icons" style="color:green">check_circle</i></td>
															@else
															<td><i class="material-icons "style="color:gray">check_circle</i></td>
															@endif
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
										@else
											<div class="card-alert card cyan lighten-5">
												<div class="card-content cyan-text">
													<p>INFO : No data found.</p>
												</div>
											</div>
										@endif
									</div>
								</div>
							</div>
						</div>


                        <div class="row top_titleWrap">
                            <div class="col s9 m7">
                                <h3>Machinery Details</h3>
                            </div>
                            @if(Auth::check())
                            <div class="col s3 m5 right-align editBox">
                                <button type="button" data-target="machinery-details-modal" class="btn_edit btn_green_White modal-trigger">
                                    <span class="btn_icon"><i class="material-icons">border_color</i></span>
                                    <span class="btn_edit_white"> Edit</span>
                                </button>
                            </div>
                            @endif
						</div>
						<div class="overview_table_wrap machinery_table">
							<div class="machinery_table_inner_wrap">
								@if(count($business_profile->machineriesDetails)>0)
								<div class="overview_table box_shadow">
									<div class="no_more_tables">
										<table>
											<thead class="cf">
												<tr>
													<th>Machine Name</th>
													<th>Quantity</th>
													<th>&nbsp;</th>
												</tr>
											</thead>
											<tbody class="machinaries-details-table-body">
												@foreach($business_profile->machineriesDetails as $machineriesDetail)
												<tr>
													<td data-title="Machine Name">{{$machineriesDetail->machine_name}}</td>
													<td data-title="Quantity">{{$machineriesDetail->quantity}}</td>
													@if($machineriesDetail->status==1)
													<td><i class="material-icons" style="color:green">check_circle</i></td>
													@else
													<td><i class="material-icons "style="color:gray">check_circle</i></td>
													@endif
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>
						</div>

						<div class="overview_table_wrap">
							<div class="row top_titleWrap">
								<div class="col s9 m7">
									<h3>Production Flow and Manpower</h3>
								</div>
								@if(Auth::check())
								<div class="col s3 m5 right-align editBox">
									<button type="button" data-target="production-flow-and-manpower-modal" class="btn_edit btn_green_White modal-trigger">
										<span class="btn_icon"><i class="material-icons">border_color</i></span>
										<span class="btn_edit_white"> Edit</span>
									</button>
								</div>
								@endif
							</div>
							<div class="manpower_table_wrapper">
								@if(count($business_profile->productionFlowAndManpowers)>0)
								<div class="production-flow-and-manpower-table-wrapper box_shadow overview_table">
									<table class="production-flow-and-manpower-table" style="width:100%">
										<tbody class="production-flow-and-manpower-table-body">
											<!-- Html will comes from script -->
											@foreach($business_profile->productionFlowAndManpowers as $productionFlowAndManpower)
											<tr>
												<th>{{$productionFlowAndManpower->production_type}}</th>
												<td>
													<table style="width:100%; border: 0px;" border="0" cellpadding="0" cellspacing="0">
													@foreach(json_decode($productionFlowAndManpower->flow_and_manpower) as $flowAndManpower)
													<tr>
														<td>{{$flowAndManpower->name}}</td>
														<td>{{$flowAndManpower->value}}</td>
														@if($flowAndManpower->status==1)
														<td><i class="material-icons" style="color:green">check_circle</i></td>
														@else
														<td><i class="material-icons "style="color:gray">check_circle</i></td>
														@endif
													</tr>
													@endforeach
													</table>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>
						</div>

						<div class="certifications">
							<div class="row top_titleWrap upload_delete_wrap">
								<div class="col s7">
									<h3>Certifications</h3>
								</div>
								<div class="col s5 right-align editBox">
									<button type="button" data-target="certification-upload-form-modal" class="btn_upload btn_green_White modal-trigger" >
										<span class="btn_icon"><i class="material-icons">file_upload</i></span>
										<span class="btn_edit_white">Upload</span>
									</button>
									<button type="button" class="btn_delete btn_green_White delete-certification-button" >
										<span class="btn_icon"><i class="material-icons">delete</i></span>
										<span class="btn_edit_white">Delete</span>
									</button>
								</div>
							</div>
							<div class="certifications-block">
								@if(count($business_profile->certifications)>0)
									@foreach($business_profile->certifications as $certification)
									<div class="certificate_img_wrap">
										<a href="javascript:void(0)" style="display: none;" data-id="{{$certification->id}}" class="remove-certificate" ><i class="material-icons dp48">remove_circle_outline</i></a>
										@if(pathinfo($certification->image, PATHINFO_EXTENSION) == 'pdf' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'PDF')
											<div class="certificate_img">
												<a href="{{ Storage::disk('s3')->url('public/'.$certification->image) }}" data-id="{{$certification->id}}" class="certification_file_down" >&nbsp;</a>
											</div>
											<div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
												@if($certification->issue_date)
												<span class="issue-date">Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}</span>
												@endif
												@if($certification->expiry_date)
												<span class="expiry-date">Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}</span>
												@endif
											</div>
										@elseif(pathinfo($certification->image, PATHINFO_EXTENSION) == 'doc' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'docx' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'DOCX' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'DOC' )

											<div class="certificate_img">
												<a href="{{ Storage::disk('s3')->url('public/'.$certification->image) }}" data-id="{{$certification->id}}" class="certification_doc certification_file_down" >&nbsp;</a>
											</div>
											<div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
												@if($certification->issue_date)
												<span class="issue-date">Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}</span>
												@endif
												@if($certification->expiry_date)
												<span class="expiry-date">Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}</span>
												@endif
											</div>
										@else
                                        @php $certification_image_src=$certification->image ?$certification->image :  $certification->default_certification->logo ; @endphp
											<div class="certificate_img"> <img  src="{{ Storage::disk('s3')->url('public/'.$certification_image_src) }}" alt=""></div>
											<div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
												@if($certification->issue_date)
												<span class="issue-date">Issue Date: {!! date('d-m-Y', strtotime($certification->issue_date)) !!}</span>
												@endif
												@if($certification->expiry_date)
												<span class="expiry-date">Expiry Date: {!! date('d-m-Y', strtotime($certification->expiry_date)) !!}</span>
												@endif
											</div>
										@endif
									</div>
									@endforeach
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>
						</div>

						<div class="main_buyers_wrap">
							<div class="row top_titleWrap upload_delete_wrap">
								<div class="col s7">
									<h3>Main Buyers</h3>
								</div>
								<div class="col s5 right-align editBox">
									<button type="button" data-target="main-buyers-upload-form-modal" class="btn_upload btn_green_White modal-trigger" >
										<span class="btn_icon"><i class="material-icons">file_upload</i></span>
										<span class="btn_edit_white"> Upload</span>
									</button>
									<button type="button" class="btn_delete btn_green_White  delete-main-buyer-button" >
										<span class="btn_icon"><i class="material-icons">delete</i></span>
										<span class="btn_edit_white"> Delete</span>
									</button>
								</div>
							</div>
							<div class="buyers_logo_wrap row main-buyers-block">
								@if(count($business_profile->mainBuyers)>0)
									@foreach($business_profile->mainBuyers as $mainBuyers)
									<div class="col s6 m4 l3 main_buyer_box">
										<a href="javascript:void(0)" style="display: none;"data-id="{{$mainBuyers->id}}" class="remove-main-buyer"><i class="material-icons dp48">remove_circle_outline</i></a>
										<div class="main_buyer_img">
											<img  src="{{ Storage::disk('s3')->url('public/'.$mainBuyers->image) }}" alt="">
										</div>
										<h5>{{$mainBuyers->title}}</h5>
									</div>
									@endforeach
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif

							</div>

						</div>
						<div class="export_destination_wrap">
							<div class="row top_titleWrap upload_delete_wrap">
								<div class="col s7">
									<h3>Export Destinations</h3>
								</div>
								<div class="col s5 right-align editBox">
									<button type="button" data-target="export-destination-upload-form-modal" class="btn_upload btn_green_White modal-trigger" >
										<span class="btn_icon"><i class="material-icons">file_upload</i></span>
										<span class="btn_edit_white"> Upload</span>
									</button>
									<button type="button" class="btn_delete btn_green_White delete-export-destination-button" >
										<span class="btn_icon"><i class="material-icons">delete</i></span>
										<span class="btn_edit_white"> Delete</span>
									</button>
								</div>
							</div>
							<div class="flag_wrap center-align">

								<div class="flagBox export-destination-block row">
									@if(count($business_profile->exportDestinations)>0)
										@foreach($business_profile->exportDestinations as $exportDestination)
										<div class="col s6 m4 l2">
											<div class="flag_innerBox">
												<div class="flag_img export-destination-img">
													<a href="javascript:void(0)" style="display: none;"data-id="{{$exportDestination->id}}" class="remove-export-destination"><i class="material-icons dp48">remove_circle_outline</i></a>
													<img  src="{{Storage::disk('s3')->url('public/frontendimages/flags/'.strtolower($exportDestination->country->code).'.png')}}" alt="">
												</div>
												<div class="flag_infoBox">
													<h5>{{$exportDestination->country->name}}</h5>
													<span>{{$exportDestination->short_description}}</span>
												</div>
											</div>
										</div>
										@endforeach
									@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
									@endif
								</div>

							</div>

							<!-- <div class="row flag_wrap center-align">
								<div class="col s6 m4 l2 flagBox export-destination-block">
								@foreach($business_profile->exportDestinations as $exportDestination)
									<div class="flag_img export-destination-img">
										<a href="javascript:void(0)" style="display: none;"data-id="{{$exportDestination->id}}" class="remove-export-destination"><i class="material-icons dp48">remove_circle_outline</i></a>
										<img  src="{{ asset('storage/'.$exportDestination->image) }}" alt="">
									</div>
									<h5>{{$exportDestination->title}}</h5>
								@endforeach
								</div>
							</div> -->
						</div>

						<div class="overview_table_wrap overview_table_alignLeft">
							<div class="row top_titleWrap">
								<div class="col s9 m7">
									<h3>Business Terms</h3>
								</div>
								@if(Auth::check())
								<div class="col s3 m5 right-align editBox">
									<button type="button" data-target="business-term-modal" class="btn_edit btn_green_White modal-trigger" >
										<span class="btn_icon"><i class="material-icons">border_color</i></span>
										<span class="btn_edit_white"> Edit</span>
									</button>
								</div>
								@endif
							</div>
							<div class="business_terms_table_wrap">
								@if(count($business_profile->businessTerms)>0)
								<div class="overview_table box_shadow">
									<div class="no_more_tables">
										<table>
											<tbody class="business-term-table-body">
												@foreach($business_profile->businessTerms as $businessTerm)
												<tr>
													<td data-title="Term Name">{{$businessTerm->title}}</td>
													<td data-title="Quantity">{{$businessTerm->quantity}}</td>
													@if($businessTerm->status==1)
													<td><i class="material-icons" style="color:green">check_circle</i></td>
													@else
													<td><i class="material-icons "style="color:gray">check_circle</i></td>
													@endif
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>

								</div>
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>
						</div>

						<div class="overview_table_wrap overview_table_alignLeft">
							<div class="row top_titleWrap">
								<div class="col s9 m7">
									<h3>Sampling and R&D</h3>
								</div>
								@if(Auth::check())
								<div class="col s3 m5 right-align editBox">
									<button type="button" data-target="sampling-modal" class="btn_edit btn_green_White modal-trigger">
										<span class="btn_icon"><i class="material-icons">border_color</i></span>
										<span class="btn_edit_white"> Edit</span>
									</button>
								</div>
								@endif
							</div>
							<div class="sampling_table_wrapper">
								@if(count($business_profile->samplings) > 0)
								<div class="overview_table box_shadow">
									<div class="no_more_tables">
										<table>
											<tbody class="sampling-table-body">
												@foreach($business_profile->samplings as $sampling)
												<tr>
													<td data-title="Name">{{$sampling->title}}</td>
													<td data-title="Quantity">{{$sampling->quantity}}</td>
													@if($sampling->status==1)
													<td><i class="material-icons" style="color:green">check_circle</i></td>
													@else
													<td><i class="material-icons "style="color:gray">check_circle</i></td>
													@endif
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>
						</div>

						<div class="overview_table_wrap blank_overview_table_wrap">
							<div class="row top_titleWrap">
								<div class="col s9 m7">
									<h3>Special customization ability</h3>
								</div>
								@if(Auth::check())
								<div class="col s3 m5 right-align editBox">
									<button type="button" data-target="special-customization-modal" class="btn_edit btn_green_White modal-trigger">
										<span class="btn_icon" ><i class="material-icons">border_color</i></span>
										<span class="btn_edit_white" > Edit</span>
									</button>
								</div>
								@endif
							</div>
							<div class="special_customization_table_wrap">
								@if(count($business_profile->specialCustomizations) > 0)
								<div class="overview_table box_shadow">
									<div class="no_more_tables">
										<table>
											<tbody class="special-customization-table-body">
												@foreach($business_profile->specialCustomizations as $specialCustomization)
												<tr>
													<td data-title="Title">{{$specialCustomization->title}}</td>
													@if($specialCustomization->status==1)
													<td><i class="material-icons" style="color:green">check_circle</i></td>
													@else
													<td><i class="material-icons "style="color:gray">check_circle</i></td>
													@endif
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>
						</div>

						<div class="worker_welfare_wrap" style="display: none;">
							<div class="row worker_welfare_box">
								<div class="row top_titleWrap">
									<div class="col s9 m7">
										<h3>Worker welfare and CSR</h3>
									</div>
									@if(Auth::check())
									<div class="col s3 m5 right-align editBox">
										<button type="button" data-target="worker-walfare-modal" class="btn_edit btn_green_White modal-trigger" >
											<span class="btn_icon"><i class="material-icons">border_color</i></span>
											<span class="btn_edit_white" > Edit</span>
										</button>
									</div>
									@endif
								</div>

								@if($business_profile->walfare)
								<div class="col s12 m6 l6">
									@foreach(json_decode($business_profile->walfare->walfare_and_csr) as $walfareAndCsr)
								    @if($walfareAndCsr->name == 'healthcare_facility')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Healthcare Facility</span>
										<label class="radio_box col s2 m2 l2">
											<input class="with-gap health-facility-checked" name="healthcare_facility_disable"   disabled  type="radio" value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }}>
											<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
											<input class="with-gap health-facility-unchecked" name="healthcare_facility_disable"   disabled  value="0" type="radio" {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
											<span>No</span>
										</label>

									</div>
									@endif
									@if($walfareAndCsr->name == 'doctor')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">On sight Doctor</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap doctor-checked" name="doctor_disable"   type="radio" value="1" disabled {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }}>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap doctor-unchecked" name="doctor_disable"   value="0" type="radio" disabled {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
										<span>No</span>
										</label>
									</div>
									@endif
									@if($walfareAndCsr->name == 'day_care')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6 ">On sight Day Care</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap day-care-checked" name="day_care_disable" class="" type="radio" value="1" disabled {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }} >
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap day-care-unchecked" name="day_care_disable" class="" value="0" type="radio" disabled {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
										<span>No</span>
										</label>
									</div>
									@endif
									@endforeach
								</div>

								<div class="col s12 m6 l6">
									@foreach(json_decode($business_profile->walfare->walfare_and_csr) as $walfareAndCsr)
								    @if($walfareAndCsr->name == 'playground')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Playground</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap playground-checked" name="playground_disable"    type="radio" value="1" disabled {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }}>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap playground-unchecked" name="playground_disable"    value="0" type="radio" disabled {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
										<span>No</span>
										</label>
									</div>
									@endif
									@if($walfareAndCsr->name == 'maternity_leave')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Maternity Leave</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap maternity-leave-checked" name="maternity_leave_disable"  type="radio" disabled  value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }} >
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap maternity-leave-unchecked" name="maternity_leave_disable" type="radio" disabled  value="0"  {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
										<span>No</span>
										</label>
									</div>
									@endif
									@if($walfareAndCsr->name == 'social_work')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Social work</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap social-work-checked" name="social_work_disable"   type="radio" value="1" disabled {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }} >
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap social-work-unchecked" name="social_work_disable"  type="radio" value="0" disabled {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }} >
										<span>No</span>
										</label>
									</div>
									@endif
									@endforeach
								</div>
								@else
								<div class="col s12 m6 l6">
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Healthcare Facility</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap health-facility-checked" name="healthcare_facility_disable"    type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap health-facility-unchecked" name="healthcare_facility_disable"  disabled  value="0" type="radio" disabled>
										<span>No</span>
										</label>
									</div>
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">On sight Doctor</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap doctor-checked" name="doctor_disable"   type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap doctor-unchecked" name="doctor_disable"   value="0" type="radio" disabled>
										<span>No</span>
										</label>
									</div>
									<div class="welfare_box row">
										<span class="title col s8 m6 l6 ">On sight Day Care</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap day-care-checked" name="day_care_disable" class="" type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap day-care-unchecked" name="day_care_disable" class="" value="0" type="radio" disabled>
										<span>No</span>
										</label>
									</div>
								</div>
								<div class="col s12 m6 l6">
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Playground</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap playground-checked" name="playground_disable"    type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap playground-unchecked" name="playground_disable"    value="0" type="radio" disabled>
										<span>No</span>
										</label>
									</div>
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Maternity Leave</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap maternity-leave-checked" name="maternity_leave_disable"  type="radio" value="1" >
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap maternity-leave-unchecked" name="maternity_leave_disable"  type="radio" value="0" >
										<span>No</span>
										</label>
									</div>
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Social work</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap social-work-checked" name="social_work_disable"   type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap social-work-unchecked" name="social_work_disable"   type="radio" value="0"disabled >
										<span>No</span>
										</label>
									</div>
								</div>
								@endif
                            </div>


							<div class="row worker_welfare_box">
								<div class="row top_titleWrap">
									<div class="col s6 m6">
										<h3>Security and others</h3>
									</div>
									@if(Auth::check())
									<div class="col s6 m6 right-align editBox">
										<button type="button" data-target="security-modal" class="btn_edit btn_green_White modal-trigger" >
											<span class="btn_icon"><i class="material-icons">border_color</i></span>
											<span class="btn_edit_white" > Edit</span>
										</button>
									</div>
									@endif
								</div>

								@if($business_profile->security)
								<div class="col s12 m6 l6">
								    @foreach(json_decode($business_profile->security->security_and_others) as $securityAndOther)
									@if($securityAndOther->name == 'fire_exit')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Fire Exit</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="fire_exit"  class="fire-exit-checked"  type="radio" value="1" {{  ($securityAndOther->checked == "1" ? ' checked' : '') }} disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="fire_exit" class="fire-exit-unchecked"    value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} disabled>
										<span>No</span>
										</label>

									</div>
									@endif
									@if($securityAndOther->name == 'fire_hydrant')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">On sight Fire Hydrant</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="fire_hydrant"  class="fire-hydrant-checked"  type="radio" value="1" {{  ($securityAndOther->checked == "1" ? ' checked' : '') }} disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="fire_hydrant" class="fire-hydrant-unchecked"  value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} disabled>
										<span>No</span>
										</label>
									</div>
									@endif
									@if($securityAndOther->name == 'water_source')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6 ">Onsight water source</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="water_source" class="water-source-checked" type="radio" value="1" {{  ($securityAndOther->checked == "1" ? ' checked' : '') }} disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="water_source" class="water-source-unchecked" value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} disabled>
										<span>No</span>
										</label>
									</div>
									@endif
								    @endforeach
							    </div>

								<div class="col s12 m6 l6">
									@foreach(json_decode($business_profile->security->security_and_others) as $securityAndOther)
									@if($securityAndOther->name == 'protocols')
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Other protocols</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="protocols" class="protocols-checked"   type="radio" value="1" {{  ($securityAndOther->checked == "1" ? ' checked' : '') }} disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="protocols"  class="protocols-unchecked"  value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} disabled>
										<span>No</span>
										</label>
									</div>
									@endif
									@endforeach
								</div>
								@else
								<div class="col s12 m6 l6">
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Fire Exit</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="fire-exit" class="fire-exit-checked"   type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="fire-exit" class="fire-exit-unchecked"   type="radio" value="0" disabled>
										<span>No</span>
										</label>
									</div>
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">On sight Fire Hydrant</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="fire-hydrant" class="fire-hydrant-checked"   type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap"  name="fire-hydrant" class="fire-hydrant-unchecked"   type="radio" value="0" disabled>
										<span>No</span>
										</label>
									</div>
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Onsight water source</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap"  name="water-source" class="water-source-checked"   type="radio" value="1"  checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="water-source" class="water-source-unchecked"   type="radio" value="0" disabled>
										<span>No</span>
										</label>
									</div>
								</div>
								<div class="col s12 m6 l6">
									<div class="welfare_box row">
										<span class="title col s8 m6 l6">Other protocols</span>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="protocols" class="protocols-checked"   type="radio" value="1" checked="" disabled>
										<span>Yes</span>
										</label>
										<label class="radio_box col s2 m2 l2">
										<input class="with-gap" name="protocols" class="protocols-unchecked"   type="radio" value="0" disabled>
										<span>No</span>
										</label>
									</div>
								</div>
								@endif
							</div>
						</div>

						<div class="overview_table_wrap blank_overview_table_wrap">
							<div class="row top_titleWrap">
								<div class="col s9 m7">
									<h3>Sustainability commitments</h3>
								</div>
								@if(Auth::check())
								<div class="col s3 m5 right-align editBox">
									<button type="button" data-target="sustainability-commitment-modal" class="btn_edit btn_green_White modal-trigger" >
										<span class="btn_icon"><i class="material-icons">border_color</i></span>
										<span class="btn_edit_white" > Edit</span>
									</button>
								</div>
								@endif
							</div>
							<div class="sustainability_commitment_table_wrap">
								@if(count($business_profile->sustainabilityCommitments) > 0)
								<div class="overview_table box_shadow">
									<div class="no_more_tables">
										<table>
											<tbody class="sustainability-commitment-table-body">
												@foreach($business_profile->sustainabilityCommitments as $sustainabilityCommitment)
												<tr>
													<td data-title="Title">{{$sustainabilityCommitment->title}}</td>
													@if($sustainabilityCommitment->status==1)
													<td><i class="material-icons" style="color:green">check_circle</i></td>
													@else
													<td><i class="material-icons "style="color:gray">check_circle</i></td>
													@endif
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif
							</div>
						</div>

						<div class="membership_wrap">
							<div class="row top_titleWrap upload_delete_wrap">
								<div class="col s7">
									<h3>Association memberships</h3>
								</div>
								<div class="col s5 right-align editBox">
									<button type="button" data-target="association-membership-upload-form-modal" class="btn_upload btn_green_White modal-trigger">
										<span class="btn_icon"><i class="material-icons">file_upload</i></span>
										<span class="btn_edit_white" > Upload</span>
									</button>
									<button type="button" class="btn_delete btn_green_White delete-association-membership-button">
										<span class="btn_icon"><i class="material-icons">delete</i></span>
										<span class="btn_edit_white"> Delete</span>
									</button>
								</div>
							</div>
							<div class="membership_textBox association-membership-block">
								@if(count($business_profile->associationMemberships)>0)
							    @foreach($business_profile->associationMemberships as $associationMembership)
								<div class="center-align association-membership-img">
									<a href="javascript:void(0)" style="display: none;"data-id="{{$associationMembership->id}}" class="remove-association-membership"><i class="material-icons dp48">remove_circle_outline</i></a>
									<div class="imgbox"><img  src="{{ Storage::disk('s3')->url('public/'.$associationMembership->image) }}" alt=""></div>
									<p>{{$associationMembership->title}}</p>
								</div>
								@endforeach
								@else
								<div class="card-alert card cyan lighten-5">
									<div class="card-content cyan-text">
										<p>INFO : No data found.</p>
									</div>
								</div>
								@endif
							</div>
						</div>
						<div class="pr_highlights_wrap">
							<div class="row top_titleWrap upload_delete_wrap">
								<div class="col s7">
									<h3>PR Highlights</h3>
								</div>
								<div class="col s5 right-align editBox">
									<button type="button" data-target="press-highlight-upload-form-modal" class="btn_upload btn_green_White modal-trigger">
										<span class="btn_icon"><i class="material-icons">file_upload</i></span>
										<span class="btn_edit_white"> Upload</span>
									</button>
									<button type="button" class="btn_delete btn_green_White delete-press-highlight-button" >
										<span class="btn_icon"> <i class="material-icons">delete</i></span>
										<span class="btn_edit_white"> Delete</span>
									</button>
								</div>
							</div>
							<div class="row press-highlight-block">
								@if(count($business_profile->pressHighlights)>0)
								@foreach($business_profile->pressHighlights as $pressHighlight)
									<div class="col s6 m4 l2 paper_img press-highlight-img">
										<a href="javascript:void(0)" style="display: none;"data-id="{{$pressHighlight->id}}" class="remove-press-highlight"><i class="material-icons dp48">remove_circle_outline</i></a>
										<div class="press_img">
											<div class="press_img_box"><img src="{{ Storage::disk('s3')->url('public/'.$pressHighlight->image) }}" alt="" /></div>
											<h5>{{$pressHighlight->title}}</h5>
										</div>
									</div>
								@endforeach
								@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No data found.</p>
										</div>
									</div>
								@endif

							</div>
						</div>
					</div>
					<div id="products" class="tabcontent">

						<div class="add-new-product-button">
							<a href="javascript:void(0);" class="modal-trigger tooltipped product-add-modal-trigger btn waves-effect waves-light green btn_green" data-position="top" data-tooltip="add new product">
								<i class="material-icons dp48">add</i> Add New product
							</a>
						</div>
						<div id="manufacture_edit_errors"></div>
						<div class="manufacture-product-table-data">
							@include('business_profile._product_table_data')
						</div>

						<!-- <div class="profile_products_wrap">
							<div class="row top_titleWrap">
								<div class="col s6 m6">
									<h3>Main Products</h3>
								</div>
								<div class="col s6 m6 right-align editBox">
									<button class="btn_green">Add new Product</button>
								</div>
							</div>
							<div class="profile_products_gallery">
								<div class="row products_gallery_women">
									<div class="col s12 m8 l9">
										<div class="row">
											<div class="col s12 m6 l7 gallery_leftimgs">
												<div class="profile_products_imgWrap">
													<div class="gallery_img"><img src="{{asset('images/frontendimages/new_layout_images/sayem_02.jpeg')}}" alt=""/></div>
													<div class="gallery_textbox">
														<h5><span>Women's</span> Sweaters</h5>
													</div>
												</div>
												<div class="profile_products_imgWrap">
													<div class="gallery_img"><img src="{{asset('images/frontendimages/new_layout_images/sayem_01.jpg')}}" alt=""/></div>
													<div class="gallery_textbox">
														<h5><span>Women's</span> Fullsleeves</h5>
													</div>
												</div>
											</div>
											<div class="col s12 m6 l5 gallery_midimgs">
												<div class="profile_products_imgWrap">
													<div class="gallery_img"><img src="{{asset('images/frontendimages/new_layout_images/sayem_4.png')}}" alt=""/></div>
													<div class="gallery_textbox">
														<h5><span>Women's</span> Fullsleeves</h5>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col s12 m4 l3 gallery_rightimgs">
										<div class="profile_products_imgWrap">
											<div class="gallery_img"><img src="{{asset('images/frontendimages/new_layout_images/sayem_04.jpeg')}}" alt=""/></div>
											<div class="gallery_textbox">
												<h5><span>Women's</span> Sweatshirts</h5>
											</div>
										</div>
										<div class="profile_products_imgWrap">
											<div class="gallery_img"><img src="{{asset('images/frontendimages/new_layout_images/sayem_01.jpg')}}" alt=""/></div>
											<div class="gallery_textbox">
												<h5><span>Women's</span> Hoodies</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="row products_gallery_men">
									<div class="col s12 m5 l5">
										<div class="profile_products_imgWrap">
											<div class="gallery_img"><img src="{{asset('images/frontendimages/new_layout_images/sayem_02.jpeg')}}" alt=""/></div>
											<div class="gallery_textbox">
												<h5><span>Men's</span> Down Jackets</h5>
											</div>
										</div>
									</div>
									<div class="col s12 m7 l7">
										<div class="profile_products_imgWrap">
											<div class="gallery_img"><img src="{{asset('images/frontendimages/new_layout_images/best_mens_hoodies.png')}}" alt=""/></div>
											<div class="gallery_textbox">
												<h5><span>Men's</span> Hoodies</h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> -->

					</div>

					<!--  <div id="womenproducts" class="tabcontent">
						<div class="tab_navMenu">
							<ul>
								<li><a href="javascript:void(0);">Main Products</a></li>
								<li>Women's Sweaters</li>
							</ul>
						</div>
						<div class="profile_product_wrap product_wrapper">
							<div class="row top_titleWrap">
								<div class="col s6 m6">
									<h3>Women's Sweaters</h3>
								</div>
								<div class="col s6 m6 right-align editBox">
									<button class="btn_green">Add new Product</button>
								</div>
							</div>
							<div class="product_boxwrap row">
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_01.jpg')}}" alt=""></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_02.jpeg')}}" alt=""></a>
										<div class="favorite active_favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_03.jpeg')}}" alt=""></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_04.jpeg')}}"></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
							</div>
							<div class="product_boxwrap row">
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_01.jpg')}}" alt=""></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_02.jpeg')}}" alt=""></a>
										<div class="favorite active_favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_03.jpeg')}}" alt=""></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_04.jpeg')}}"></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
							</div>
							<div class="product_boxwrap row">
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_01.jpg')}}" alt=""></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_02.jpeg')}}" alt=""></a>
										<div class="favorite active_favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_03.jpeg')}}" alt=""></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
								<div class="productBox col s6 m3 l3">
									<div class="imgBox">
										<a href="javascript:void(0);"><img src="{{asset('images/frontendimages/new_layout_images/sayem_04.jpeg')}}"></a>
										<div class="favorite"><span class="material-icons">favorite</span></div>
									</div>
									<div class="priceBox row">
										<div class="col m5 s5 apperal">Apperal</div>
										<div class="price col m7 s7 right-align">$26.50 <span>/pc</span></div>
									</div>
									<h4>Winter Autumn Casual Outwear Casual Knitted Crew Neck Winter Autumn Casual Outwear Casual Knitted Crew Neck</h4>
									<div class="moq">MOQ  150 <span>pcs</span></div>
									<div class="leadTime">Lead time 10 <span>days</span></div>
								</div>
							</div>
						</div>
					</div> -->

					<div id="factorytour" class="tabcontent">
						<div class="profile_factory_tourWrap">
							@if(count($business_profile->companyFactoryTour)>0)
								<div class="right-align">
									<a href="javascript:void(0);" data-target="factory-tour-edit-modal-block" class="factory_tour_edit_modal_trigger modal-trigger btn_green">Edit Factory Tour</a>
								</div>
								@if($companyFactoryTour->virtual_tour)
									<div class="row top_titleWrap">
										<div class="col s6 m6">
											<h3>Virtual Tour</h3>
										</div>
										<!-- <div class="col s6 m6 right-align">
											<a href="javascript:void(0);">Watch on YouTube</a>
										</div> -->
									</div>
									@php
										$youTubeUrl = explode('/', $companyFactoryTour->virtual_tour);
									@endphp
									@if($youTubeUrl[3]=="embed")
									<div class="factory_video_box">
										<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$youTubeUrl[4]}}" allowfullscreen></iframe>
									</div>
									@else
									<div class="factory_video_box">
										<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$youTubeUrl[3]}}" allowfullscreen></iframe>
									</div>
									@endif
								@endif
								<!-- <div class="col s6 m6 product_view right-align"><a href="javascript:void(0);"> View all </a></div> -->
								<div class="row top_titleWrap">
									<div class="col s12 gallery_navbar">
										<ul class="tabs">
											<li class="tab col m3"><a class="active" href="#factory_images">Factory Images</a></li>
											<li class="tab col m3"><a href="#factory_degree_images">360 Degree Images</a></li>
										</ul>
									</div>
								</div>
								<div id="factory_images" class="factory_imgbox_innerwrap">
									<div class="row factory_image_gallery">
									@if(count($companyFactoryTour->companyFactoryTourImages)>0)
										@foreach($companyFactoryTour->companyFactoryTourImages as $image)
											<div class="col s6 m4 l4">
												<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/'.$image->factory_image)}}" alt=""></div>
											</div>
										@endforeach
									@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No Image found.</p>
										</div>
									</div>
									@endif

									</div>
								</div>
								<div id="factory_degree_images" class="video_gallery_box">
									<div class="row degree_360_video_gallery">
									@if(count($companyFactoryTour->companyFactoryTourLargeImages)>0)
									@foreach($companyFactoryTour->companyFactoryTourLargeImages as $image)
										<div class="col s12 m6 l6">
											<div class="imgBox"><img src="{{Storage::disk('s3')->url('public/'.$image->factory_large_image)}}" alt=""></div>
										</div>
									@endforeach
									@else
									<div class="card-alert card cyan lighten-5">
										<div class="card-content cyan-text">
											<p>INFO : No Image found.</p>
										</div>
									</div>
									@endif

									</div>
								</div>
							@else
								<div class="right-align" style="padding-bottom: 20px">
									<a href="javascript:void(0);" data-target="factory-tour-add-modal-block" class="btn_green factory_tour_modal_trigger modal-trigger">Add Factory Tours</a>
								</div>
								<div class="card-alert card cyan lighten-5">
									<div class="card-content cyan-text">
										<p>INFO : No data found.</p>
									</div>
								</div>
							@endif
						</div>
					</div>
					<div id="termsservice" class="tabcontent">
						<div class="right-align">
							<a href="javascript:void(0);" data-target="terms-of-service-modal" class="terms_of_service_modal_trigger modal-trigger btn_green">Edit Terms of service</a>
						</div>
						<h3>Terms of Service</h3>


						<div class="terms-of-service-information-block">

							@if($business_profile->companyOverview->terms_of_service)
								<div class="terms-of-service-with-information" >
									<p>{{$business_profile->companyOverview->terms_of_service}}</p>
								</div>
							@else
								<div class="card-alert card cyan lighten-5 terms-of-service-without-information" >
									<div class="card-content cyan-text">
										<p>INFO : No data found.</p>
									</div>
								</div>
							@endif
						</div>




					</div>
				</div>
			</div>
			<!-- Container section end -->
		</div>
	</div>
</section>
</div>


    @include('business_profile._edit_company_overview_modal')
    @include('business_profile._edit_capacity_and_machineries_modal')
    @include('business_profile._edit_production_flow_and_manpower_modal')
    @include('business_profile._upload_certifications_modal')
	@include('business_profile._upload_main_buyers_modal')
	@include('business_profile._upload_export_destination_modal')
	@include('business_profile._upload_association_membership_modal')
	@include('business_profile._add_business_terms_modal')
	@include('business_profile._add_sampling_modal')
	@include('business_profile._add_special_customization_modal')
	@include('business_profile._add_sustainability_commitment_modal')
	@include('business_profile._add_worker_walfare_and_csr_modal')
	@include('business_profile._add_security_modal')
	@include('business_profile._upload_press_highlight_modal')
    @include('business_profile._add_product_modal')
    @include('business_profile._edit_product_modal')
	@include('business_profile._add_factory_tour_modal')
	@include('business_profile._edit_factory_tour_modal')
	@include('business_profile._create_or_update_terms_of_service_modal')
    @include('business_profile._edit_categories_produced')
    @include('business_profile._edit_machinery_details')
	@include('business_profile._create_or_update_business_profile_verification_request')
    @include('business_profile._upload_business_profile_logo_banner')
@endsection

@include('business_profile._scripts')
@include('business_profile._business_profile_logo_banner_script')
