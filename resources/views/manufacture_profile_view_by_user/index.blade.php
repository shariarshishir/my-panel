@extends('layouts.app_containerless')

@section('content')
@include('sweet::alert')

<!-- Profile section start -->
<section class="profile_bannerwrap">
	<div class="banner_overlay"  @if($business_profile->business_profile_banner) style="background:url('{{Storage::disk('s3')->url('public/'.$business_profile->business_profile_banner)}}'); background-size:cover;" @endif>
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
                                    $img=$business_profile->user->image ?'storage/'.$business_profile->user->image : 'images/frontendimages/no-image.png';
                                    @endphp
                                    <img src="{{asset($img)}}" alt="avatar" >
								@endif
							</div>
						</div>
						<div class="col s8 m6 l12 profile_left_address_wrap">
							<div class="office_address center-align ">
								<h3>{{$business_profile->business_name}}</h3>
								<p>@php echo ($business_profile->business_type=='manufacturer')?'Manufacturer':'Wholesaler'; @endphp, @if(isset($business_profile->factory_type)){{$business_profile->factory_type}}@endif</p>
								<h4><span class="material-icons">pin_drop</span> <span class="pro_location"> {{$business_profile->location}} </span> <img src="{{asset('images/frontendimages/new_layout_images/bd_flg.png')}}" style="display: none;" alt="" /> </h4>
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
									<p>INFO : There is no head office address for <b>{{ucwords($business_profile->business_name)}}</b>.</p>
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
				@endif
			</div>
			<!-- Container section start -->
			<div class="col s12 m7 l9 profile_contentCol">
				<div class="profile_tabNav_wrap">
					<div class="profile_tab_menu">
						<ul class="tabs">
							<li class="tab" ><a href="#home">Home</a></li>
							<li class="tab  @php echo ($flag==1)?'disabled':''; @endphp"><a href="#profile">Profile</a></li>
							<li class="tab  @php echo ($flag==1)?'disabled':''; @endphp"><a href="#products">Products</a></li>
							<!--li class="tab col m2"><a href="#womenproducts">Women</a></li-->
							<li class="tab  @php echo ($flag==1)?'disabled':''; @endphp"><a href="#factorytour">Factory Tour</a></li>
							<li class="tab  @php echo ($flag==1)?'disabled':''; @endphp"><a href="#termsservice">Terms of Service</a></li>
						</ul>
					</div>
					@if($business_profile->is_business_profile_verified == 0)

						<div class="profile_not_updated">
							<span class="profile_not_updated_inner center-align">
								<div class="annaouncement_icon">&nbsp;</div>
								<p style="font-size: 25px;"> You do not have access to view this profile.</p>
								<p>Become a verified buyer to get full access of Merchant Bay.</p>
							</span>

							<div class="center-align">
							<a href="javascript:void(0);" class="button talk-to-us btn_green" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk To Us</a>
							</div>
						</div>


					@else
					<div id="home" class="tabcontent">
						<h3>About the Company</h3>
						<div class="company_stuff center-align row">
                            @foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
                                @if($company_overview->name=='floor_space')
                                <div class="col s6 m3 l2">
                                    <div class="company_stuff_img">
                                        <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory.png')}}" alt="" />
                                    </div>
                                    <div class="title">Floor Space</div>
                                    <div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
                                </div>
                                @endif
                                @if($company_overview->name=='no_of_machines')
                                <div class="col s6 m3 l2">
                                    <div class="company_stuff_img">
                                        <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/sewing-machine.png')}}" alt="" />
                                    </div>
                                    <div class="title">No. of Machines</div>
                                    <div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}pcs</div>
                                </div>
                                @endif
                                @if($company_overview->name=='production_capacity')
                                <div class="col s6 m3 l2">
                                    <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/production.png')}}" alt="" />
                                    <div class="title">Production Capacity</div>
                                    <div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}pcs</div>
                                </div>
                                @endif
                                @if($company_overview->name=='number_of_worker')
                                    @if(isset($company_overview->value))
                                    <div class="col s6 m3 l2">
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
                                    <div class="col s6 m3 l2">
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


						<!-- company_stuff -->
						<div class="contentBox">
                            @if($business_profile->companyOverview->about_company)
							    {{$business_profile->companyOverview->about_company}}
                            @endif
						</div>
						<!-- contentBox -->
                        @if(count($business_profile->certifications)>0)
                            <div class="certifications">
                                <h3>Certifications</h3>
                                <div class="certifications-block">
                                    @foreach($business_profile->certifications as $certification)
                                        <div class="certificate_img_wrap">
                                            @if(pathinfo($certification->image, PATHINFO_EXTENSION) == 'pdf' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'PDF')
                                            <div class="certificate_img">
                                                <a href="{{ Storage::disk('s3')->url('public/'.$certification->image) }}" data-id="{{$certification->id}}" class="certification_file_down" >&nbsp;</a>
                                            </div>
											<div class="certificate_infoBox">
												<span class="certificate_title">{{$certification->title}}</span>
											</div>

                                            @elseif(pathinfo($certification->image, PATHINFO_EXTENSION) == 'doc' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'docx' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'DOCX' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'DOC' )

                                            <div class="certificate_img">
                                                <a href="{{ Storage::disk('s3')->url('public/'.$certification->image) }}" data-id="{{$certification->id}}" class="certification_doc certification_file_down" >&nbsp;</a>
                                            </div>
											<div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
											</div>

                                            @else
                                            @php $certification_image_src=$certification->image ? $certification->image :  $certification->default_certification->logo ; @endphp
                                            <div class="certificate_img"> <img  src="{{ Storage::disk('s3')->url('public/'.$certification_image_src) }}" alt=""></div>
                                            <div class="certificate_infoBox">
												<span class="certificate_title" >{{$certification->title}}</span>
											</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @endif
						<!-- certifications -->
                        @if(count($mainProducts)>0)
							<div class="product_design_wrapper">
								<div class="profile_product_wrap product_wrapper">
									<div class="row top_titleWrap">
										<div class="col s6 m6">
											<h3>Main Products</h3>
										</div>
									</div>
									<div class="product_boxwrap row">
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
																		<h4><span> {{$product->title}} </span></h4>
																	</div>
																	<div class="col s6">
																		@if(isset($product->moq))
																			<div class="product_moq"><span class="moq">MOQ:</span> {{$product->moq}} <span class="moq-unit">{{ $product->qty_unit }}</span></div>
																		@endif
																	</div>
																</div>
															</div>
														</a>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							</div>
                        @endif

						<!-- profile_product_wrap -->
                        @if(count($business_profile->companyFactoryTour)>0)
                            <div class="factory_imgbox_wrap">
                                <div class="row top_titleWrap">
                                    <div class="col s6 m6">
                                        <h3>Factory Images</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(count($companyFactoryTour->companyFactoryTourImages)>0)
                                        @foreach($companyFactoryTour->companyFactoryTourImages as $image)
                                            <div class="col s6 m4">
                                                <div class="imgBox" ><a href="javascript:void(0);"><img src="{{Storage::disk('s3')->url('public/'.$image->factory_image)}}" alt="" /></a></div>
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
                        @endif
						<!-- factory_images -->
                        @if(count($business_profile->mainBuyers)>0)
                            <div class="main_buyers_wrap">
                                <h3>Main Buyers</h3>
                                <div class="buyers_logo_wrap row main-buyers-block">
                                    @foreach($business_profile->mainBuyers as $mainBuyers)
                                        <div class="col s6 m4 l3 main_buyer_box">
                                            <a href="javascript:void(0);"></a>
                                            <div class="main_buyer_img">
                                                <img  src="{{ Storage::disk('s3')->url('public/'.$mainBuyers->image) }}" alt="">
                                            </div>
                                            <h5>{{$mainBuyers->title}}</h5>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
						<!-- main_buyers logo -->
                        @if(count($business_profile->exportDestinations)>0)
                            <div class="export_destination_wrap">
                                <h3>Export Destinations</h3>
                                <div class="row flag_wrap center-align export-destination-block">
									@foreach($business_profile->exportDestinations as $exportDestination)
										<div class="col s6 m4 l2">
											<div class="flag_innerBox">
												<div class="flag_img export-destination-img">
													<img  src="{{Storage::disk('s3')->url('public/frontendimages/flags/'.strtolower($exportDestination->country->code).'.png')}}" alt="">
												</div>
												<div class="flag_infoBox">
													<h5>{{$exportDestination->country->name}}</h5>
												</div>
											</div>
										</div>
									@endforeach
                                </div>
                            </div>
                        @endif
						<!-- export_destination -->
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
                        {{-- capacity and mechineries --}}

                                <div class="overview_table_wrap capacity_machineries">
                                    {{-- <div class="row top_titleWrap">
                                        <div class="col s6 m6">
                                            <h3>Capacity and Machineries</h3>
                                        </div>
                                    </div> --}}
                                    <div class="row capacity_table">
                                        @if(count($business_profile->categoriesProduceds)>0)
                                            <div class="col s12 m12">
                                                <h3>Categories Produced</h3>
                                                <div class="categories_produced_wrapper">
                                                    <div class="overview_table box_shadow">
														<div class="no_more_tables">
															<table>
																<thead class-"cf">
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
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(count($business_profile->machineriesDetails)>0)
                                    <div class="overview_table_wrap machinery_table">
                                        <h3>Machinery Details</h3>
                                        <div class="machinery_table_inner_wrap">
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
                                        </div>
                                    </div>
                                @endif



                        @if(count($business_profile->productionFlowAndManpowers)>0)
                            <div class="overview_table_wrap">
                                <div class="row top_titleWrap">
                                    <div class="col s6 m6">
                                        <h3>Production Flow and Manpower</h3>
                                    </div>

                                </div>
                                <div class="manpower_table_wrapper">
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
                                </div>
                            </div>
                        @endif


                        @if(count($business_profile->certifications)>0)
                            <div class="certifications">
                                <div class="row top_titleWrap upload_delete_wrap">
                                    <div class="col s6 m6">
                                        <h3>Certifications </h3>
                                    </div>
                                </div>

								<div class="certifications-block">
									@if(count($business_profile->certifications)>0)
										@foreach($business_profile->certifications as $certification)
										<div class="certificate_img_wrap">
											@if(pathinfo($certification->image, PATHINFO_EXTENSION) == 'pdf' || pathinfo($certification->image, PATHINFO_EXTENSION) == 'PDF')
												<div class="certificate_img">
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
                        @endif

                        @if(count($business_profile->mainBuyers)>0)
                            <div class="main_buyers_wrap">
                                <div class="row top_titleWrap upload_delete_wrap">
                                    <div class="col s6 m6">
                                        <h3>Main Buyers</h3>
                                    </div>
                                </div>
                                <div class="buyers_logo_wrap row main-buyers-block">
                                        @foreach($business_profile->mainBuyers as $mainBuyers)
                                        <div class="col s6 m4 l3 main_buyer_box">
                                            <a href="javascript:void(0)" style="display: none;"data-id="{{$mainBuyers->id}}" class="remove-main-buyer"><i class="material-icons dp48">remove_circle_outline</i></a>
                                            <div class="main_buyer_img">
                                                <img  src="{{ Storage::disk('s3')->url('public/'.$mainBuyers->image) }}" alt="">
                                            </div>
                                            <h5>{{$mainBuyers->title}}</h5>
                                        </div>
                                        @endforeach
                                </div>
                            </div>
                        @endif

                        @if(count($business_profile->exportDestinations)>0)
                            <div class="export_destination_wrap">
                                <div class="row top_titleWrap upload_delete_wrap">
                                    <div class="col s6 m6">
                                        <h3>Export Destinations</h3>
                                    </div>
                                </div>
                                <div class="flag_wrap center-align">
                                    <div class="flagBox export-destination-block row">
										@foreach($business_profile->exportDestinations as $exportDestination)
										<div class="col s6 m4 l2">
											<div class="flag_innerBox">
												<div class="flag_img export-destination-img">
													<a href="javascript:void(0)" style="display: none;"data-id="{{$exportDestination->id}}" class="remove-export-destination"><i class="material-icons dp48">remove_circle_outline</i></a>
													<img  src="{{Storage::disk('s3')->url('public/frontendimages/flags/'.strtolower($exportDestination->country->code).'.png')}}" alt="">
												</div>
												<div class="flag_infoBox">
													<h5>{{$exportDestination->country->name}}</h5>
												</div>
											</div>
										</div>
										@endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(count($business_profile->businessTerms)>0)
                            <div class="overview_table_wrap overview_table_alignLeft">
                                <div class="row top_titleWrap">
                                    <div class="col s6 m6">
                                        <h3>Business Terms</h3>
                                    </div>
                                </div>
                                <div class="business_terms_table_wrap">
                                    <div class="overview_table box_shadow">
                                        <table>
                                            <tbody class="business-term-table-body">
                                                @foreach($business_profile->businessTerms as $businessTerm)
                                                <tr>
                                                    <td>{{$businessTerm->title}}</td>
                                                    <td>{{$businessTerm->quantity}}</td>
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
                            </div>
                        @endif


                        @if(count($business_profile->samplings) > 0)
                            <div class="overview_table_wrap overview_table_alignLeft">
                                <div class="row top_titleWrap">
                                    <div class="col s6 m6">
                                        <h3>Sampling and R&D</h3>
                                    </div>
                                </div>
                                <div class="sampling_table_wrapper">
                                    <div class="overview_table box_shadow">
                                        <table>
                                            <tbody class="sampling-table-body">
                                                @foreach($business_profile->samplings as $sampling)
                                                <tr>
                                                    <td>{{$sampling->title}}</td>
                                                    <td>{{$sampling->quantity}}</td>
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
                            </div>
                        @endif


                        @if(count($business_profile->specialCustomizations) > 0)
                            <div class="overview_table_wrap blank_overview_table_wrap">
                                <div class="row top_titleWrap">
                                    <div class="col s6 m6">
                                        <h3>Special customization ability</h3>
                                    </div>
                                </div>
                                <div class="special_customization_table_wrap">
                                    <div class="overview_table box_shadow">
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
                            </div>
                        @endif




						<div class="worker_welfare_wrap" style="display: none;">
							<div class="row worker_welfare_box">
								<div class="row top_titleWrap">
									<div class="col s6 m6">
										<h3>Worker welfare and CSR</h3>
									</div>

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

                        @if(count($business_profile->sustainabilityCommitments) > 0)
                            <div class="overview_table_wrap blank_overview_table_wrap">
                                <div class="row top_titleWrap">
                                    <div class="col s6 m6">
                                        <h3>Sustainability commitments</h3>
                                    </div>
                                </div>
                                <div class="sustainability_commitment_table_wrap">
                                    <div class="overview_table box_shadow">
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
                            </div>
                        @endif

                        @if(count($business_profile->associationMemberships)>0)
                            <div class="membership_wrap">
                                <div class="row top_titleWrap upload_delete_wrap">
                                    <div class="col s6 m6">
                                        <h3>Association memberships</h3>
                                    </div>

                                </div>
                                <div class="membership_textBox association-membership-block">
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
							@include('manufacture_profile_view_by_user._product_list')
						</div>

					</div>
					<div id="factorytour" class="tabcontent">
						<div class="profile_factory_tourWrap">
							@if(count($business_profile->companyFactoryTour)>0)
								@if($companyFactoryTour->virtual_tour)
								<div class="row top_titleWrap">
									<div class="col s6 m6">
										<h3>Virtual Tour</h3>
									</div>
								</div>
								@php
									$youTubeUrl = explode('/', $companyFactoryTour->virtual_tour);
								@endphp
								<div class="factory_video_box">
									<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$youTubeUrl[3]}}" allowfullscreen></iframe>
								</div>
								@endif
								<div class="row">
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
								</div>
							@else
								<div class="card-alert card cyan lighten-5">
									<div class="card-content cyan-text">
										<p>INFO : There is no factory tour for <b>{{ucwords($business_profile->business_name)}}</b></p>
									</div>
								</div>
							@endif
						</div>
					</div>
					<div id="termsservice" class="tabcontent">
						<h3>Terms of Service</h3>
						<div class="terms-of-service-information-block">
							@if($business_profile->companyOverview->terms_of_service)
								<div class="terms-of-service-with-information" >
									<p>{{$business_profile->companyOverview->terms_of_service}}</p>
								</div>
							@else
								<div class="card-alert card cyan lighten-5 terms-of-service-without-information" >
									<div class="card-content cyan-text">
										<p>INFO : No terms of service added by {{$business_profile->business_name}}.</p>
									</div>
								</div>
							@endif
						</div>
					</div>
					@endif

				</div>
			</div>
			<!-- Container section end -->
		</div>
	</div>
</section>

@endsection

@include('manufacture_profile_view_by_user._scripts')
