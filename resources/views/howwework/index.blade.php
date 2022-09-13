@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | How We Work')
@section('title', 'Merchant Bay | How We Work')
@section('description', 'B2B Fashion E-Sourcing Platform that helps you source any design and any quantity from Bangladesh. For Buyers, We connect you to vetted manufacturers and help manage your orders with quality control, shipping and secured payments. Manufacturers can sign up to set up their profiles to join MB Pool and we will reach out for verification process.')
@section('image', Storage::disk('s3')->url('public/frontendimages/How-We-Work.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Merchant Bay | How We Work')
@section('ogdescription', 'B2B Fashion E-Sourcing Platform that helps you source any design and any quantity from Bangladesh. For Buyers, We connect you to vetted manufacturers and help manage your orders with quality control, shipping and secured payments. Manufacturers can sign up to set up their profiles to join MB Pool and we will reach out for verification process.')
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/How-We-Work.png'))

@section('robots', 'index, nofollow')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div id="how_we_work">
        <div class="switch_buttons">
            <div class="switch_button_container">
                <div class="switch_button_wrapper">
                    <h1 class="animate_how_work">How Merchant Bay works</h1>
                    <ul class="document_tabs">
                        <li class="tab animate_document_tab_left"><a class="active" href="#brands">BRANDS</a></li>
                        <li class="tab animate_document_tab_right"><a href="#manufacturers">MANUFACTURERS</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container" id="brands">
            <div class="page_title">
                <div class="title_and_tags">
                    <h2 class="animate_title_and_tags">Start or Scale Your Clothing Brand <br/>
                        with Modern Sourcing Solution</h2>
                    <ul>
                        <li class="px-20 animate_tag_left">Fast</li>
                        <li class="px-20 animate_tag_top">Reliable</li>
                        <li class="px-20 animate_tag_right">Traceable</li>
                    </ul>
                </div>
            </div>
            <div class="steps_section py-50">
                <div class="steps_box">
                    <div class="row">
                        <div class="col l3 animate_icon_box_one">
                            <div class="icon_box">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/sign-up.svg')}}" alt="icon"
                                    style="transform: translate(15px, 15px);" />
                            </div>
                        </div>
                        <div class="col l9">
                            <div class="count_and_details">
                                <div class="count animate_icon_count_box_one">
                                    <div class="count_number">
                                        <span>1</span>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div class="details animate_icon_details_box_one">
                                    <h3>Sign up as Buyer</h3>
                                    <p class="show-read-more">Start with signing up as a buyer. It does not take more than 30 seconds. We will get in touch within 24 hours to know your requirements and brand visions better.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="steps_box">
                    <div class="row">
                        <div class="col l3 animate_icon_box_two">
                            <div class="icon_box">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/rfq.svg')}}" alt="icon"
                                    style="transform: translate(15px, 15px);" />
                            </div>
                        </div>
                        <div class="col l9">
                            <div class="count_and_details">
                                <div class="count animate_icon_count_box_two">
                                    <div class="count_number">
                                        <span>2</span>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div class="details animate_icon_details_box_two">
                                    <h3>Post a Request for quotation (RFQ)</h3>
                                    <p class="show-read-more">We are enabling you to get hassle free direct access to production in Bangladesh RMG industry. You just send us a simple request for quotation and we will take it forward. Request for quotation is a simple form which only contains the most important high-level information about your sourcing. We will present you with multiple quotations from top matched suppliers within 48 hours.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="steps_box">
                    <div class="row">
                        <div class="col l3 animate_icon_box_three">
                            <div class="icon_box">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/manufacturer.svg')}}" alt="icon"
                                    style="transform: translate(15px, 15px);" />
                            </div>
                        </div>
                        <div class="col l9">
                            <div class="count_and_details">
                                <div class="count animate_icon_count_box_three">
                                    <div class="count_number">
                                        <span>3</span>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div class="details animate_icon_details_box_three">
                                    <h3>Select the best fit manufacturer</h3>
                                    <p class="show-read-more">Select the best match. You can evaluate suppliers by certifications, capacity, years in operation, brands they previously worked for etc. All manufacturers with Merchant Bay are pre vetted and reliable. Merchant Bay will assist you in having a mutual agreement with trade assurance and quickly generate a industry standard purchase order. Now, your order is on the roll.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="steps_box">
                    <div class="row">
                        <div class="col l3 animate_icon_box_four">
                            <div class="icon_box">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/escrow-pay.svg')}}" alt="icon"
                                    style="transform: translate(15px, 15px);" />
                            </div>
                        </div>
                        <div class="col l9">
                            <div class="count_and_details">
                                <div class="count animate_icon_count_box_four">
                                    <div class="count_number">
                                        <span>4</span>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div class="details animate_icon_details_box_four">
                                    <h3>Pay securely via escrow</h3>
                                    <p class="show-read-more">Merchant Bay offers a secure payment account between you and your supplier. After you complete your payment for the proposal, a percentage is paid to the manufacturer immediately, leaving the second part on hold until the job is completed in full. We can also assist you in working with letter of credit or deferred payment terms as well in the long run.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="steps_box">
                    <div class="row">
                        <div class="col l3 animate_icon_box_five">
                            <div class="icon_box">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/product-development.svg')}}" alt="icon"
                                    style="transform: translate(0px, 5px);" />
                            </div>
                        </div>
                        <div class="col l9">
                            <div class="count_and_details">
                                <div class="count animate_icon_count_box_five">
                                    <div class="count_number">
                                        <span>5</span>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div class="details animate_icon_details_box_five">
                                    <h3>Become the integral part of the product development</h3>
                                    <p class="show-read-more">You can develop a design or tech pack in collaboration with our designers and run your product development with our expert technical development team. Our product development team incorporate your feedbacks to create the best version of your vision. Proto sample will be sent to your doorsteps from us.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="steps_box">
                    <div class="row">
                        <div class="col l3 animate_icon_box_six">
                            <div class="icon_box">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/quality-control.svg')}}" alt="icon"
                                    style="transform: translate(0px, 5px);" />
                            </div>
                        </div>
                        <div class="col l9">
                            <div class="count_and_details">
                                <div class="count animate_icon_count_box_six">
                                    <div class="count_number">
                                        <span>6</span>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div class="details animate_icon_details_box_six">
                                    <h3>Quality control</h3>
                                    <p class="show-read-more">Assuring the right product within the promised quality standard is our core competencies. Unlike all other platforms in the world, we do not leave you alone during the most critical production part. Our in-house quality assurance team and liaison with third party quality inspectors allow us to promise the required quality in all steps. All the QC updates are also sent to you via order management dashboard in real time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="steps_box">
                    <div class="row">
                        <div class="col l3 animate_icon_box_seven">
                            <div class="icon_box">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/shipment.svg')}}" alt="icon"
                                    style="transform: translate(0px, 5px);" />
                            </div>
                        </div>
                        <div class="col l9">
                            <div class="count_and_details">
                                <div class="count animate_icon_count_box_seven">
                                    <div class="count_number">
                                        <span>7</span>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div class="details animate_icon_details_box_seven">
                                    <h3>Shipment</h3>
                                    <p class="show-read-more">Our commercial team and partnered logistic companies can assist you in smooth shipment too. As mentioned, you just start by submitting your query and Merchant Bay takes care of you thorough out the complete apparel production journey.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="features py-50">
                <div class="row">
                    <div class="col s12 l4 m6 animate_feature_box_left">
                        <div class="feature_box">
                            <div class="icon">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/fast-fevelopment.svg')}}" alt="icon" />
                            </div>
                            <h5>Fast Development</h5>
                        </div>
                    </div>
                    <div class="col s12 l4 m6 animate_feature_box_top">
                        <div class="feature_box">
                            <div class="icon">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/secured-payement.svg')}}" alt="icon" />
                            </div>
                            <h5>Secured Payement</h5>
                        </div>
                    </div>
                    <div class="col s12 l4 m6 animate_feature_box_right">
                        <div class="feature_box">
                            <div class="icon">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/complete-traceability.svg')}}" alt="icon" />
                            </div>
                            <h5>Complete Traceability</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="why_us py-50">
                <div class="why_us_box">
                    <div class="row">
                        <div class="col l4 s12 animate_box_img_1">
                            <div class="box_img">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/health-care-for-rmg-workers.jpg')}}" alt="img" />
                            </div>
                        </div>
                        <div class="col l8 s12 animate_box_description_1" style="align-self: center;">
                            <div class="box_description">
                                <h3>100 years of sourcing experience</h3>
                                <p>Our 100 years of combined sourcing experience
                                    enables us to offer you the most efficient sourcing
                                    so that you can concentrate on brand building while
                                    we take care of the rest.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="why_us_box right_img">
                    <div class="row">
                        <div class="col l8 s12 animate_box_description_2" style="align-self: center;">
                            <div class="box_description">
                                <h3>Unmatched access to the industry
                                    and supply chain</h3>
                                <p>Our unmatched industry access and manufacturing
                                    expertise enables us to source any complex product
                                    for you. With us opportunity is endless.</p>
                            </div>
                        </div>
                        <div class="col l4 s12 animate_box_img_2" style="justify-content: right;">
                            <div class="box_img">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/warehousing.jpg')}}" alt="img" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="why_us_box">
                    <div class="row">
                        <div class="col l4 s12 animate_box_img_3">
                            <div class="box_img">
                                <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/oip.jpg')}}" alt="img" />
                            </div>
                        </div>
                        <div class="col l8 s12 animate_box_description_3" style="align-self: center;">
                            <div class="box_description">
                                <h3>Suppliers for any MOQ and any price</h3>
                                <p>Bangladesh is known for its most competitive price.
                                    We connect you to the most competitive market in
                                    a modern way. Now you can order with MOQ as low
                                    as 100 pcs. Win unfair advantage with more varieties
                                    in your product range.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="request_quotation py-50">
                <div class="animate_request_quotation_title">
                    <h3>We make sure you get Right Product at <br/>
                        the Right Price within the Right Time ....</h3>
                </div>
                <div class="animate_request_btn_green">
                    <a href="{{route('rfq.create')}}" class="btn_green">Request for Quotation</a>
                </div>

            </div>
        </div>

        <div id="manufacturers">
            <div class="container">
                <div class="page_title py-50">
                    <div class="title_and_tags">
                        <h2 class="animate_manuf_title_and_tags">Create a Profile, Join MB Pool <br/> Start Growing Business</h2>
                        <ul>
                            <li class="px-20 animate_manuf_tag_left">Get more business</li>
                            <li class="px-20 animate_manuf_tag_top">Generate more profit</li>
                            <li class="px-20 animate_manuf_tag_right">Grow Fast</li>
                        </ul>
                    </div>
                </div>
                <div class="steps_section py-50">
                    <div class="steps_box">
                        <div class="row">
                            <div class="col l3 animate_icon_box_1">
                                <div class="icon_box">
                                    <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/sign-up.svg')}}" alt="icon"
                                        style="transform: translate(15px, 15px);" />
                                </div>
                            </div>
                            <div class="col l9">
                                <div class="count_and_details">
                                    <div class="count animate_icon_count_box_1">
                                        <div class="count_number">
                                            <span>1</span>
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                    <div class="details animate_icon_details_box_1">
                                        <h3>Sign up as a Manufacturer</h3>
                                        <p class="show-read-more">Creating manufacturer account is an easy process, provide basic info about you and your business and you are good to go.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="steps_box">
                        <div class="row">
                            <div class="col l3 animate_icon_box_2">
                                <div class="icon_box">
                                    <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/business-profile.svg')}}" alt="icon"
                                        style="transform: translate(15px, 15px);" />
                                </div>
                            </div>
                            <div class="col l9">
                                <div class="count_and_details">
                                    <div class="count animate_icon_count_box_2">
                                        <div class="count_number">
                                            <span>2</span>
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                    <div class="details animate_icon_details_box_2">
                                        <h3>Setting up Business Profile</h3>
                                        <p class="show-read-more">You can open multiple business profiles under your supplier account. Make your profile as detailed as possible to get more targeted queries. Your profiles will be verified by Merchant Bay before publishing. After verification your profile will be available for query matching.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="steps_box">
                        <div class="row">
                            <div class="col l3 animate_icon_box_3">
                                <div class="icon_box">
                                    <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/storefront.svg')}}" alt="icon"
                                        style="transform: translate(15px, 15px);" />
                                </div>
                            </div>
                            <div class="col l9">
                                <div class="count_and_details">
                                    <div class="count animate_icon_count_box_3">
                                        <div class="count_number">
                                            <span>3</span>
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                    <div class="details animate_icon_details_box_3">
                                        <h3>Build your Storefront</h3>
                                        <p class="show-read-more">Brand and buyers like it when you showcase your products and samples in your digital profile. It creates more credibility and trust. Upload all your developed samples to your digital profile to get direct queries from buyers.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="steps_box">
                        <div class="row">
                            <div class="col l3 animate_icon_box_4">
                                <div class="icon_box">
                                    <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/join-mb-pool.svg')}}" alt="icon"
                                        style="transform: translate(15px, 15px);" />
                                </div>
                            </div>
                            <div class="col l9">
                                <div class="count_and_details">
                                    <div class="count animate_icon_count_box_4">
                                        <div class="count_number">
                                            <span>4</span>
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                    <div class="details animate_icon_details_box_4">
                                        <h3>Join MB Pool</h3>
                                        <p class="show-read-more">Join Merchant Bay pool to start getting orders instantly. You can join with your full capacity or you can dedicate as low as one line for Merchant Bay. Once you assign a line to MB pool you won’t have to worry about those lines production. You will keep getting best fit orders according to your capabilities to feed in the line. Win-Win deals doesn’t get better that this.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="steps_box">
                        <div class="row">
                            <div class="col l3 animate_icon_box_5">
                                <div class="icon_box">
                                    <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/payment-security.svg')}}" alt="icon"
                                        style="transform: translate(0px, 5px); max-width: 90px " />
                                </div>
                            </div>
                            <div class="col l9">
                                <div class="count_and_details">
                                    <div class="count animate_icon_count_box_5">
                                        <div class="count_number">
                                            <span>5</span>
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                    <div class="details animate_icon_details_box_5">
                                        <h3>Stop worrying about payment security</h3>
                                        <p class="show-read-more">You will receive your payment as stated in the payment terms. All buyers at Merchant Bay are authentic and have payment assurance. Our escrow service makes sure there is no misconduct.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="why_us manufacture py-50">
                <h2 class="animate_why_us_title">We get you the right queries and support
                    to help you grow your business faster</h2>
                <div class="manufacture_container">
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m2 d-l-none"></div>
                            <div class="col s12 m6 animate_why_us_box_1">
                                <div class="why_us_box" style="margin-bottom: 100px;">
                                    <div class="title">
                                        <div class="icon">
                                            <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/get-queries.svg')}}" alt="icon" />
                                        </div>
                                        <h3>Get Queries every day</h3>
                                    </div>
                                    <p>Once you are in MB Pool, you will get queries
                                        in a priority basis. Whenever a query comes in
                                        for your category you are notified.</p>
                                </div>
                            </div>
                            <div class="col s12 m4 d-l-none"></div>
                            <div class="col s12 m4 d-l-none"></div>
                            <div class="col s12 m6 animate_why_us_box_2">
                                <div class="why_us_box" style="margin-bottom: 100px;">
                                    <div class="title">
                                        <div class="icon">
                                            <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/product-develolpment-2.svg')}}" alt="icon" />
                                        </div>
                                        <h3>Gain advantage in
                                            product development</h3>
                                    </div>
                                    <p>Merchant Bay stays with you during all the
                                        process in the product development so that
                                        you are assured to have the order developed
                                        in the most effective way which will increase
                                        your production efficiency.</p>
                                </div>
                            </div>
                            <div class="col s12 m2 d-l-none"></div>
                            <div class="col s12 m4 animate_why_us_box_3" style="align-self: center;">
                                <div class="middle_text_card" style="margin-bottom: 140px;">
                                    <h3>Pioneering the decentralized
                                        manufacturing network with
                                        Merchant Bay</h3>
                                </div>
                            </div>
                            <div class="col s12 m1 d-l-none" style="margin: 0;"></div>
                            <div class="col s12 m6  animate_why_us_box_4">
                                <div class="why_us_box" style="margin-bottom: 100px;">
                                    <div class="title">
                                        <div class="icon">
                                            <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/empowered-with-tech.svg')}}" alt="icon" />
                                        </div>
                                        <h3>Get empowered with Tech</h3>
                                    </div>
                                    <p>MB Pool factories get privileged access to
                                        Merchant Bay tools. They never have to go for
                                        expensive ERP solutions to digitize their factory.
                                        Merchant Bay ensures they are digitized step by step in the right hierarchy.</p>
                                </div>
                            </div>
                            <div class="col s12 m4 d-l-none"></div>
                            <div class="col s12 m6 l6 animate_why_us_box_5">
                                <div class="why_us_box" style="margin-bottom: 100px;">
                                    <div class="title">
                                        <div class="icon">
                                            <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/global-storefront.svg')}}" alt="icon" />
                                        </div>
                                        <h3>Global footprint</h3>
                                    </div>
                                    <p>In Merchant Bay, your profile acts as your
                                        microsite. We guarantee your MB profile going
                                        more places than your own website.</p>
                                </div>
                            </div>
                            <div class="col s12 m2 d-l-none" style="margin: 0;"></div>
                            <div class="col s12 m2 d-l-none"></div>
                            <div class="col s12 m6 animate_why_us_box_6">
                                <div class="why_us_box">
                                    <div class="title">
                                        <div class="icon">
                                            <img src="{{Storage::disk('s3')->url('public/frontendimages/work-image/icon/manage-easily.svg')}}" alt="icon" />
                                        </div>
                                        <h3>Manage it easily</h3>
                                    </div>
                                    <p>We know how hard it is to run a manufacturing
                                        business. So, we bring our services to your
                                        pocket. Now you can review a query on the go.
                                        Also look into key analytics and production
                                        through OMD app.</p>
                                </div>
                            </div>
                            <div class="col s2 m4 d-l-none"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="request_quotation py-50">
                    <div class="animate_menuf_request_quotation">
                        <h3>Be a Merchant Bay manufacturing partner now!</h3>
                    </div>
                    <div class="animate_menuf_btn_green">
                        <a href="{{route('business.profile.create')}}" class="btn_green">Join MB Pool</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /.content-wrapper -->

@endsection

@push('js')
<script>
    $(document).ready(function(){
        var maxLength = 150;
        $(".show-read-more").each(function(){
            var myStr = $(this).text();
            if($.trim(myStr).length > maxLength){
                var newStr = myStr.substring(0, maxLength);
                var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                $(this).empty().html(newStr);
                $(this).append('<a href="javascript:void(0);" class="read-more">Read More...</a>');
                $(this).append('<span class="more-text">' + removedStr + '</span>');
            }
        });
        $(".read-more").click(function(){
            $(this).siblings(".more-text").contents().unwrap();
            $(this).remove();
        });

        $('#how_we_work').parent('div.container').addClass('howWeWorkContainer');


    });






</script>
@endpush
