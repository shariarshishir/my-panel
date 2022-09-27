@extends('layouts.app_containerless')
@section('content')

<div class="account_profile_wrapper">
    <div class="account_profile_menu">
        <div class="container">
            <div class="profile_account_desktop_menu">
                @include('new_business_profile.profile_menu')
            </div>
            <div class="profile_account_mobile_menu" style="display: none;">
                <div class="row">
                    <div class="col s12">
                        <div class="profile_account_rightbar">
                            <a onclick="openProfileAccountNav()" href="javascript:void(0);" class="btn-product-sidenav">&nbsp;</a>
                        </div>
                    </div>
                    <div class="col s12">
                        <ul class="collapsible">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">menu</i></div>
                                <div class="collapsible-body">
                                    @include('new_business_profile.profile_menu')
                                </div>
                            </li>
                            </ul>
                    </div>
                </div>

                <!-- <div id="profileAccountRight">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeProfileAccountNav()"><i class="material-icons">clear</i></a>
                    test
                </div> -->
            </div>
        </div>
    </div>
    <div class="profile_account_innerinfo_wrap">
        <div class="container">
            <div class="account_profile_box">
                <div class="row">
                    <div class="col s12 m3 l2">
                        <div class="account_item_menu">
                            <ul>
                                <li class="profile_insight {{ Route::is('new.profile.insights',$alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.insights', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Profile Insights</h4>
                                    </a>
                                </li>
                                <li class="profile_home {{ Route::is('new.profile.home',$alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.home', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Profile Home</h4>
                                    </a>
                                </li>
                                <li class="profile {{ Route::is('new.profile.edit',$alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.edit', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Profile</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m9 l10">
                        <div class="profile_supplier_account_home_wrap account_profile_home_content">
                            <legend>About the Company</legend>
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
                            <!-- company_stuff -->
                            <div class="contentBox">
                                @if($business_profile->companyOverview->about_company)
                                <p itemprop="description">
                                    {{$business_profile->companyOverview->about_company}}
                                </p>
                                @else
                                    <div class="card-alert card cyan lighten-5">
                                        <div class="card-content cyan-text">
                                            <p>INFO : company details is not available.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($business_profile->business_type == 'manufacturer') <!-- below content will show if business_type is manufacturer start -->
                                <!-- Certifications Start -->
                                <div class="certifications">
                                    <legend>Certifications</legend>
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
                                <!-- Certifications End -->

                                <!-- Factory Start -->
                                <div class="factory_imgbox_wrap">
                                    <legend>Factory Images</legend>
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
                                <!-- Factory End -->

                                <!-- Main Buyers Start -->
                                <div class="main_buyers_wrap">
                                    <legend>Main Buyers</legend>
                                    <div class="buyers_logo_wrap main-buyers-block row">
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
                                <!-- Main Buyers End -->

                                <!-- Export Destination Start -->
                                <div class="export_destination_wrap">
                                    <legend>Export Destinations</legend>
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
                                <!-- Export Destination End -->

                            @endif <!-- below content will show if business_type is manufacturer end -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
