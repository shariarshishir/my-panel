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
                        <div class="profile_supplier_account_home_wrap">
                            <h3>Profile Edit</h3>

                            <!-- Company overview block start -->
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
                            <!-- Company overview block end -->

                            @if($business_profile->business_type == 'manufacturer') <!-- below content will show if business_type is manufacturer start -->
                                <!-- Categories Produced block start -->
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
                                <!-- Categories Produced block end -->

                                <!-- Machinery Details block start -->
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
                                <!-- Machinery Details block end -->

                                <!-- Production Flow and Manpower block start -->
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
                                <!-- Production Flow and Manpower block end -->

                                <!-- Certifications block start -->
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
                                <!-- Certifications block end -->

                                <!-- Factory Tour block start -->
                                <div class="profile_factory_tourWrap">
                                    @if(count($business_profile->companyFactoryTour)>0)
                                        <a href="javascript:void(0);" data-target="factory-tour-edit-modal-block" class="factory_tour_edit_modal_trigger modal-trigger btn_green">Edit Factory Tour</a>
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
                                            <div id="factory_images" class="factory_imgbox_innerwrap col m12">
                                                <div class="row factory_image_gallery">
                                                @if(count($companyFactoryTour->companyFactoryTourImages)>0)
                                                    @foreach($companyFactoryTour->companyFactoryTourImages as $image)
                                                        <div class="col s6 m4 l4">
                                                            <div class="imgBox"><a href="{{Storage::disk('s3')->url('public/'.$image->factory_image)}}" data-fancybox><img src="{{Storage::disk('s3')->url('public/'.$image->factory_image)}}" alt=""></a></div>
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
                                            <div id="factory_degree_images" class="video_gallery_box col m12">
                                                <div class="row degree_360_video_gallery">
                                                @if(count($companyFactoryTour->companyFactoryTourLargeImages)>0)
                                                @foreach($companyFactoryTour->companyFactoryTourLargeImages as $image)
                                                    <div class="col s12 m6 l6">
                                                        <div class="imgBox"><a href="{{Storage::disk('s3')->url('public/'.$image->factory_large_image)}}" data-fancybox><img src="{{Storage::disk('s3')->url('public/'.$image->factory_large_image)}}" alt=""></a></div>
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
                                        <a href="javascript:void(0);" data-target="factory-tour-add-modal-block" class="btn_green factory_tour_modal_trigger modal-trigger">Add Factory Tours</a>
                                        <legend>Factory Tour</legend>
                                        <div class="card-alert card cyan lighten-5">
                                            <div class="card-content cyan-text">
                                                <p>INFO : No data found.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- Factory Tour block end -->

                                <!-- Main Buyers block start -->
                                <div class="main_buyers_wrap main_buyers_profileEdit">
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
                                <!-- Main Buyers block end -->

                                <!-- Export Destinations block start -->
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
                                </div>
                                <!-- Export Destinations block end -->

                                <!-- Business Terms block start -->
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
                                <!-- Business Terms block end -->

                                <!-- Sampling and R&D block start -->
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
                                <!-- Sampling and R&D block end -->

                                <!-- Special customization ability block start -->
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
                                <!-- Special customization ability block end -->

                                <!-- Sustainability commitments block start -->
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
                                <!-- Sustainability commitments block end -->

                            @endif <!-- below content will show if business_type is manufacturer end -->

                            <!-- Association memberships block start -->
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
                            <!-- Association memberships block end -->

                            <!-- PR Highlights block start -->
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
                            <!-- PR Highlights block end -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    @include('new_business_profile.business_profileinfo_edit._edit_company_overview_modal')
    @include('new_business_profile.business_profileinfo_edit._edit_categories_produced')
    @include('new_business_profile.business_profileinfo_edit._edit_machinery_details')
    @include('new_business_profile.business_profileinfo_edit._edit_production_flow_and_manpower_modal')
    @include('new_business_profile.business_profileinfo_edit._edit_factory_tour_modal')

    @include('new_business_profile.business_profileinfo_edit._upload_certifications_modal')
    @include('new_business_profile.business_profileinfo_edit._upload_main_buyers_modal')
    @include('new_business_profile.business_profileinfo_edit._upload_export_destination_modal')

    @include('new_business_profile.business_profileinfo_edit._add_business_terms_modal')
    @include('new_business_profile.business_profileinfo_edit._add_sampling_modal')
    @include('new_business_profile.business_profileinfo_edit._add_special_customization_modal')
    @include('new_business_profile.business_profileinfo_edit._add_sustainability_commitment_modal')
    @include('new_business_profile.business_profileinfo_edit._add_factory_tour_modal')

    @include('new_business_profile.business_profileinfo_edit._upload_association_membership_modal')
    @include('new_business_profile.business_profileinfo_edit._upload_press_highlight_modal')

@endsection

@include('new_business_profile._profilescripts')
