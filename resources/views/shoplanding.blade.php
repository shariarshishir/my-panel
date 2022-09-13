
@extends('layouts.app_containerless')

@section('pagetitle', 'Merchant Bay, making fashion sourcing seamless through the e-supply chain platform.')
@section('title', 'Merchant Bay, making fashion sourcing seamless through the e-supply chain platform.')
@section('description', 'Merchant Bay is the best RMG sourcing platform in the world, where million of trusted suppliers are ready to serve you. You will get the best quality febrics, 3D designes, and samples as your requirements.')
@section('image', Storage::disk('s3')->url('public/frontendimages/merchantbay_logoX200.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Merchant Bay, making fashion sourcing seamless through the e-supply chain platform.')
@section('ogdescription', 'Merchant Bay is the best RMG sourcing platform in the world, where million of trusted suppliers are ready to serve you. You will get the best quality febrics, 3D designes, and samples as your requirements.')
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/merchantbay_logoX200.png'))

@section('robots', 'index, nofollow')

@section('content')
    <h1 style="display: none;">Merchant Bay, B2B fashion e-supply chain platform connecting demand directly to production and empowering SME manufacturers</h1>
    <section class="landing_page_wrapper" itemprop="mainContentOfPage">
        <!-- New Landing design start -->
        <div class="landing_intro_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 animate_home_intro_left">
                        <div class="home_intro_left" itemscope>
                            <h1 itemprop="title">Find Your Next Apparel <br/> Manufacturing Partner</h1>
                            <p itemprop="text">Connecting demand directly to production powered <br/>
                            with tech and product development support.</p>

                            <p>#SourcingMadeEasy</p>

                            <div class="quotation_request">
                                <a href="{{route('rfq.create')}}">
                                    <span class="quotation_text">Submit a Request for Quotation</span>
                                    <span class="quotation_arrow animate_quotation_arrow"><i class="material-icons">arrow_forward</i></span>
                                </a>
                            </div>

                            <!-- <div class="home_intro_right mobile_home_intro_img" itemscope style="display: none;">
                                <img itemprop="img" alt="" src="{{asset('images/frontendimages/new-home/home-intro.png')}}" />
                            </div>

                            <div class="landing_intro_button_box" itemscope>
                                <a class="btn_howWrok btn_border_black" itemprop="How we work" data-fancybox href="https://youtu.be/8z7uqq_Zqzg"><i class="material-icons"> play_circle_outline </i> How we work</a>
                                <a href="javascript:void(0);" itemprop="Talk to us" class="btn_green btn_talk" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us <i class="material-icons"> east </i></a>
                            </div> -->

                        </div>
                    </div>
                    <div class="col s12 m6 animate_home_intro_right">
                        <div class="home_intro_right" itemscope>
                            <!-- <img itemprop="img" alt="" src="{{asset('images/frontendimages/new-home/home-intro.png')}}" /> -->

                            <div class="home_intro_video_box">
                                <iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/SLcqwqr0Hr4?autoplay=1&mute=1&enablejsapi=1&rel=0&loop=1" title="Merchant Bay Explainer" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <!--iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/LevhWgMGtDA?autoplay=1&mute=1&enablejsapi=1&rel=0&loop=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe-->
                                <!-- <iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/ZvyTEE4vjZY?autoplay=1&mute=1&enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="landing_provide_wrap">
            <div class="container" itemscope>
                <h2 itemprop="title" class="landing_provide_title" >Values we provide...</h2>
                <div class="row">
                    <div class="col s12 m12 l1">&nbsp;</div>
                    <div class="col s12 m6 l5 animate_provide_items_box_left">
                        <div class="provide_items_box provide_left" itemscope>
                            <h3 class="landing_provide_innerTitle_left"><span itemprop="title">For Buyers</span></h3>
                            <ul itemscope itemtype="https://schema.org/ListItem">
                                <li itemprop="itemListElement">Find Vetted Manufacturers</li>
                                <li itemprop="itemListElement">Find Manufacturers for Low MOQ</li>
                                <li itemprop="itemListElement">Source Textiles and Accessories</li>
                                <li itemprop="itemListElement">Source with Shortest Lead Time</li>
                                <li itemprop="itemListElement">Manage Orders with Transparency</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m6 l5 animate_provide_items_box_right">
                        <div class="provide_items_box" itemscope>
                            <h3 class="landing_provide_innerTitle_right"><span itemprop="title">For Suppliers</span></h3>
                            <ul itemscope itemtype="https://schema.org/ListItem">
                                <li itemprop="itemListElement">Create and Promote Your Digital Presence</li>
                                <li itemprop="itemListElement">Create Your Digital Product Library</li>
                                <li itemprop="itemListElement">Source Raw Materials at Best Deal</li>
                                <li itemprop="itemListElement">Be Data Driven with Smart Bi Tools</li>
                                <li itemprop="itemListElement">Manage Orders with Efficiency</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m12 l1">&nbsp;</div>
                </div>
                <div class="center-align provide_btn_wrap animate_provide_btn_wrap" itemscope>
                    <a href="{{env('SSO_REGISTRATION_URL').'/?flag=global'}}" class="btn_green" itemprop="Sign up">Sign up</a>
                </div>
            </div>
        </div>

        <div class="landing_spotlight_wrap">
            <div class="landing_spotlight_top">
                <div class="container">
                    <div class="spotlight_box animate_spotlight_box" itemscope><img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/Spotlight.png')}}" alt="Spotlight" /></div>
                </div>
            </div>
            <div class="landing_spotlight_infoWrap animate_landing_spotlight_infoWrap">
                <div class="container-full-width">
                    @php
                        $spotlightCount = 0;
                    @endphp
                    @foreach($spotlightBusinessProfile as $businessProfile)
                        <div id="spotlight-{{$spotlightCount}}">
                            <div class="spotlight_overlay"></div>
                            <div class="spotlight-inside-image" itemscope>
                                @if($businessProfile->business_profile_banner)
                                <img itemprop="img" src="{{ Storage::disk('s3')->url('public/'.$businessProfile->business_profile_banner) }}" alt="Business profile banner" />
                                @else
                                <img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/spot-li.png')}}" alt="Spot list" />
                                @endif
                            </div>
                            <div class="container">
                                <div class="spotlight-inside">
                                    <div class="right-align sayel_group_logo_box" itemscope>
                                        <!--img src="{{ asset('storage/'.$businessProfile->user->image) }}" alt="" /-->
                                        @if($businessProfile->business_profile_logo)
                                        <img itemprop="img" src="{{ Storage::disk('s3')->url('public/'.$businessProfile->business_profile_logo) }}" alt="Business profile logo" />
                                        @else
                                            @php
                                                $img = $businessProfile->user->image ?'storage/'.$businessProfile->user->image : 'images/frontendimages/no-image.png';
                                            @endphp
                                            <img itemprop="img" itemprop="img" src="{{asset($img)}}" alt="avatar" />
                                        @endif
                                    </div>
                                    <div class="spotlight_inner_info" itemscope>
                                        <h3 itemprop="title">{{ $businessProfile->business_name }}</h3>
                                        <div class="spotlight_info" itemscope>
                                            <span itemprop="text">
                                                {{ \Illuminate\Support\Str::limit($businessProfile->companyOverview->about_company, 550, $end='[...]') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="right-align" itemscope>
                                        <a href="{{route('supplier.profile', $businessProfile->alias)}}" class="btn_green landing_view_profile" itemprop="View Profile">View Profile</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @php $spotlightCount++; @endphp
                    @endforeach
                </div>
            </div>
        </div>

        <div class="landing_nav_wrap">
          <div class="container">
            <div class="landing_tab_menu" itemscope>
                <ul class="spotlight_tabs" itemscope itemtype="https://schema.org/ListItem">
                    @php
                        $spotlightCount = 0;
                    @endphp
                    @foreach($spotlightBusinessProfile as $businessProfile)
                        <li class="tab" itemprop="itemListElement"><a itemprop="{{ $businessProfile->business_name }}" href="#spotlight-{{$spotlightCount}}">{{ $businessProfile->business_name }}</a></li>
                        @php $spotlightCount++; @endphp
                    @endforeach
                </ul>
            </div>
          </div>
        </div>

        <div class="mvc_produce_design_wrap">
          <div class="container">
            <div class="row">
                <div class="col s12 m6 product_video_wrap animate_product_video_wrap">
                    <div class="product_video_box" itemscope>
                        <img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/360-white.GIF')}}" alt="Animated Image" />
                    </div>
                </div>
                <div class="col s12 m6 product_video_infobox animate_product_video_infobox">
                    <div class="product_3d_info_box" itemscope>
                        <h3 itemprop="title"><span>Develop your product<br />with <span class="bold_text" >MB Studio</span></span></h3>
                        <span class="title_border">&nbsp;</span>
                        <p itemprop="text">Our 3D design service helps you to reduce lead time significantly. <br> We have a huge library of 1000+ designs ranging from outerwear <br> to underwear. Our product development team brings the design <br> to life as best valued products with our technical expertise and <br> wide sourcing network.</p>
                    </div>

                    <div class="visit_studio animate_visit_studio" itemscope >
                        <a href="{{route('product.type.mapping',['studio', 'design'])}}" itemprop="Visit Studio" class="btn_green btn_visit_studio" >Visit Studio</a>
                    </div>
                </div>

            </div>
          </div>
        </div>

        <div class="landing_sourcing_wrap">
          <div class="container">
            <div class="row">
              <div class="col s12 m6 animate_sourcing_info_box_left">
                <div class="sourcing_info_box" itemscope>
                    <h3 itemprop="title"><span> Bring the <span class="bold_text" >Sourcing</span> <br/>
                    to your <span class="bold_text">Pocket</span> </h1>
                    <span class="title_border">&nbsp;</span>
                    <p itemprop="text">Everything you need for your Apparel Business.</p>
                    <p itemprop="text"><span class="bold_text" itemprop="text">Yarn, Fabrics, Trims, Accessories, Garments </span> <br/> and many more....</p>
                </div>
                <div class="sourcing_img_box mobile_sourcing_img_box" style="display: none;" itemscope>
                    <img itemprop="img" alt="" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/sourcing-img.jpg')}}" />
                </div>
                <div class="sourcing_apps_box" itemscope>
                    <h3 itemprop="title">Download the App</h3>
                    <div class="apps_wrap" itemscope>
                        <a href="https://apps.apple.com/dk/app/merchant-bay/id1590720968?l=en" itemscope itemprop="App Store"><img class="animate-app-store" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/app-store.png')}}" itemprop="img" alt="App Store" /></a>
                        <a href="https://play.google.com/store/apps/details?id=com.sayemgroup.merchantbay" itemscope itemprop="Google Play Store"><img class="google-play-store" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/google-play.png')}}" itemprop="img" alt="Google Play Store" /></a>
                    </div>
                </div>
              </div>
              <div class="col s12 m6 animate_sourcing_info_box_right">
                    <div class="sourcing_img_box" itemscope>
                        <img alt="Sourcing Image" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/sourcing-img.png')}}" itemprop="img" />
                    </div>
              </div>
            </div>
          </div>
        </div>

        <div class="landing_tools_wrap">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 landing_tools_left animate_landing_tools_left">
                        <div class="landing_tools_img" itemscope>
                            <img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/tools-img.png')}}" alt="Tools Image" />
                        </div>
                    </div>
                    <div class="col s12 m6 landing_tools_right animate_landing_tools_right">
                        <div class="landing_tools_infobox" itemscope>
                            <h3 itemprop="title">Increase your <span class="bold_text" >Efficiency</span> <br/> with <span class="bold_text" >Smart BI Tools</span></h3>
                            <span class="title_border">&nbsp;</span>
                            <p itemprop="text">Subscribe to the Smart Order Management Dashboard and a suit of BI tools offered by Merchant Bay to make your operation data driven and transparent.</p>
                            <div class="tools_button_box animate_tools_button_box" itemscope>
                                <a href="https://tools.merchantbay.com/" class="btn_green" itemprop="Explore MB Smart Tools" target="_blank" >Explore MB Smart Tools</a>
                                <!-- <button class="btn_green request_demo">Request a Demo</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="landing_request_wrap">
            <div class="container">
                <div class="request_innter_box center-align" itemscope>
                    <h3 itemprop="title" class="landing_request_toptitle">Want to get started now?</h3>
                    <h5 itemprop="title" class="landing_request_title">Submit a request for quotation and find the best match for your sourcing need</h5>
                    <div class="landing_request_img animate_landing_request_img" itemscope>
                        <img itemprop="img" src="{{Storage::disk('s3')->url('public/frontendimages/new-home/landing-rfq.png')}}" alt="" />
                    </div>
                    <div class="request_button_box center-align" itemscope>
                        <a href="{{route('rfq.create')}}" class="btn_border_black animate_btn_border_black" itemprop="Submit RFQ">Submit RFQ</a>
                        <span class="btn_green btn_talk animate_btn_talk" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us <i class="material-icons"> east </i></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- New Landing design end -->
    </section>

@endsection
