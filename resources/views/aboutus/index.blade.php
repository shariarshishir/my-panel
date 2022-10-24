@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | About Us')
@section('title', 'Merchant Bay | About Us')
@section('description', 'Simplest way to source apparel from Bangladesh.Get to know us! We match fashion buyers with the right clothing manufacturers and help manage your orders. Competitive Prices with Complete Visibility. Instant Response. Secured Payments.')
@section('image', Storage::disk('s3')->url('public/frontendimages/About-Us.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Merchant Bay | About Us')
@section('ogdescription', 'Simplest way to source apparel from Bangladesh.Get to know us! We match fashion buyers with the right clothing manufacturers and help manage your orders. Competitive Prices with Complete Visibility. Instant Response. Secured Payments.')
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/About-Us.png'))

@section('robots', 'index, nofollow')

@section('style')
<style >

</style>
@endsection

@section('content')

<div id="mb_about_wrap" itemprop="mainEntity">
    <div id="mb_about">
      <div class="about_us">
        <div class="about_us_container">
          <div class="section_title about-section-title">
            <h1>Simplest way to source apparel from Bangladesh</h1>
            <div class="title_bottom">
              <p>We match the right partners</p>
              <p>We bring in our fashion expertise</p>
            </div>
          </div>
          <div class="row">
            <div class="col m6 about-content-left">
              <div class="about_content">
                <h4>Who we are.....</h4>
                <p>
                  Merchant Bay is a tech enabled fashion sourcing platform.
                  That creates a critical channel for buyers to explore
                  suppliers to source apparel from Bangladesh. Our multisided
                  platform enables both buyers and suppliers to start doing
                  business fast, manage orders with efficiency and grow
                  together simultaneously.
                </p>
              </div>
            </div>
            <div class="col m6 about-content-right">
              <div class="about_content">
                <h4>What we do.....</h4>
                <p>
                  We thoroughly verify and welcome factories, textile mills,
                  yarn spinners, trims & accessories suppliers to our
                  platform. We create their digital profile to increase their
                  visibility and be a part of the visible supply chain.
                  Our multi-tier supplier base enables us to match with
                  suitable partners for demand generated instantly. Constantly
                  updating the raw material library helps us to do costing more
                  efficiently so that buyers can benefit from end to end.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="why_us py-50 yellow-box">
        <div class="why_us_container">
          <div class="section_title">
            <h3>Things are different here at Merchant Bay</h3>
          </div>
          <div>
            <ul class="why_us-tab py-50">
              <li class="tab">
                <a class="active" href="#why_us-any-quantity">Any Quantity
                </a>
              </li>
              <li class="tab">
                <a href="#why_us-instant-responses">Instant Responses</a>
              </li>
              <li class="tab">
                <a href="#why_us-competitive-quotations">Competitive Quotations</a>
              </li>
              <li class="tab">
                <a href="#why_us-development-support">Development Support</a>
              </li>
              <li class="tab">
                <a href="#why_us-complete-visibility">Complete Visibility</a>
              </li>
              <li class="tab">
                <a href="#why_us-preferred-payment-method">Preferred Payment Method
                </a>
              </li>
            </ul>
          </div>
          <div class="why_us-content" id="why_us-any-quantity">
            <h4>Any Quantity</h4>
            <p>
              We know emerging DTC brands need more styles in flexible quantities
              to avoid dead stocks and edge fast fashion. So, we prepare
              manufacturers to support low minimum order quantity orders and
              scale together. Our pool suppliers are also assisted with our
              technical and raw materials support which enables them to cater to short quantity orders.
            </p>
          </div>
          <div class="why_us-content" id="why_us-instant-responses">
            <h4>Instant Responses</h4>
            <p>All quotations are important to us and need special attention. Our team reaches out to you as soon as
your quotation comes to us and assist you in selecting the best fit manufacturer.</p>
          </div>
          <div class="why_us-content" id="why_us-competitive-quotations">
            <h4>Competitive Quotations</h4>
            <p>Our supplier-matching algorithm suggests best sourcing partners instantly. You will get quotes only
from the perfect matches rather than being bombarded by responses in your inbox with irrelevant
messages. This reduces quotation time significantly, compared to traditional time consuming and
open market platforms.</p>
          </div>
          <div class="why_us-content" id="why_us-development-support">
            <h4>Development Support</h4>
            <p>We give full support in product development to assure the right product and shorter lead time. Our
experienced product developers assist you in developing the right product as per your sketch with
optimum technical specifications to produce efficiently</p>
          </div>
          <div class="why_us-content" id="why_us-complete-visibility">
            <h4>Complete Visibility</h4>
            <p>We do not stop by giving you visibility over the supply chain. We also give full traceability
              over the production process. For the first time, you will see real-time production updates
              from anywhere in the world, eliminating the cons of off-shoring.</p>
          </div>
          <div class="why_us-content" id="why_us-preferred-payment-method">
            <h4>Preferred Payment Method</h4>
            <p>Payment is secured and flexible with us. You may pay with our escrow; you may pay directly to
manufacturers through LC or you may pay in deferred terms as our retained customers.</p>
          </div>
        </div>
      </div>
      <div class="work_process py-50">
        <div class="work_process_container">
          <h3 class="work-process-title">Our work process....</h3>
          <div class="row py-50">
            <div class="col s6 m4 xl2 work_process-box-1">
              <div class="work_process-box">
                <div class="left_side">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/sign-up.svg')}}" alt="icon" />
                  <h6>Sign up</h6>
                </div>
                <img class="arrow" src="{{Storage::disk('s3')->url('public/frontendimages/about-image/right-arrow.png')}}" alt="arrow" />
              </div>
            </div>
            <div class="col s6 m4 xl2 work_process-box-2">
              <div class="work_process-box">
                <div class="left_side">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/post-an-rfq.svg')}}" alt="icon" />
                  <h6>Post an RFQ</h6>
                </div>
                <img class="arrow" src="{{Storage::disk('s3')->url('public/frontendimages/about-image/right-arrow.png')}}" alt="arrow" />
              </div>
            </div>
            <div class="col s6 m4 xl2 work_process-box-3">
              <div class="work_process-box">
                <div class="left_side">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/select-the-best-offer.svg')}}" alt="icon" />
                  <h6>Select the Best Offer</h6>
                </div>
                <img class="arrow" src="{{Storage::disk('s3')->url('public/frontendimages/about-image/right-arrow.png')}}" alt="arrow" />
              </div>
            </div>
            <div class="col s6 m4 xl2 work_process-box-4">
              <div class="work_process-box">
                <div class="left_side">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/develop-together.svg')}}" alt="icon" />
                  <h6>Develop Together</h6>
                </div>
                <img class="arrow" src="{{Storage::disk('s3')->url('public/frontendimages/about-image/right-arrow.png')}}" alt="arrow" />
              </div>
            </div>
            <div class="col s6 m4 xl2 work_process-box-5">
              <div class="work_process-box">
                <div class="left_side">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/see-real-time-update.svg')}}" alt="icon" />
                  <h6>See Real Time Updates</h6>
                </div>
                <img class="arrow" src="{{Storage::disk('s3')->url('public/frontendimages/about-image/right-arrow.png')}}" alt="arrow" />
              </div>
            </div>
            <div class="col s6 m4 xl2 work_process-box-6">
              <div class="work_process-box">
                <div class="left_side">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/get-shipment.svg')}}" alt="icon" />
                  <h6>Get Shipment</h6>
                </div>
              </div>
            </div>
          </div>
          <a href="{{route('front.howwework')}}" class="btn btn_green lg how-we-work-btn">How we Work <span class="material-icons">
              east
            </span></a>
        </div>
      </div>
      <div class="features py-50">
        <div class="features_container">
          <div class="features_slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
              <!-- Slides -->
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary </h5>
                      <h3>Detailed profiling of <br/>
                        the suppliers </h3>
                        <div class="feature_info_text">
                          <p>Based on vast experience and R&D, we have
                          developed a standardized supplier profiling
                          system that is accepted by the brands and
                          buyers all over the world.</p>
                        </div>
                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                      <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/profile.png')}}" alt="Profile" />
                      </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary</h5>
                      <h3>Digital library of designs, samples, textiles, yarns, trims and accessories</h3>
                      <div class="feature_info_text">
                        <p>Buyers can source from our trendy 3D designs catalogue and suppliers' samples.
                          They can also source raw materials from the same place.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                    <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/design-catelogue.png')}}" alt="Design Catelogue" />
                    </div>

                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary </h5>
                      <h3>Matching algorithm</h3>
                      <div class="feature_info_text">
                        <p>Matchmaking algorithm instantly matches
                            suppliers to your requirement. This tool cuts the processing time by 50%.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                    <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/supplier-matching.png')}}" alt="Supplier Matching" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary </h5>
                      <h3>Secure conversation channel</h3>
                      <div class="feature_info_text">
                        <p>Suppliers, buyers and platform are connected
                            through our secure conversation panel.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                    <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/message-centre.png')}}" alt="Message Centre" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary </h5>
                      <h3>Product development studio</h3>
                      <div class="feature_info_text">
                        <p>Our team of expert product developers
                            develops a digital sample engaging you in
                            the whole process.</p>
                      </div>

                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                    <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/development-pool.png')}}" alt="profile" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary </h5>
                      <h3>MB pool manufacturing capacity</h3>
                      <div class="feature_info_text">
                        <p>We are pioneering a decentralized factory
                            network. We are calling it MB Pool.
                            Pool network enables us to cater for any MOQ, reduce lead time significantly and ensure the highest quality.
                        </p>
                      </div>

                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                    <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/capacity-check.png')}}" alt="Development Pool" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary </h5>
                      <h3>Order management dashboard</h3>
                      <div class="feature_info_text">
                        <p>OMD is an always online service accessible
                            from anywhere in the world.
                            OMD provides a single dashboard for key matrices related to T&A, production updates, file organization, and conversations.
                        </p>
                      </div>

                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                    <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/omd-for-mock-up.png')}}" alt="omd" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="row">
                  <div class="col s12 m6 l5">
                    <div class="feature_left">
                      <h5>Tools that made us revolutionary </h5>
                      <h3>Smart factory business intelligence tools</h3>
                      <div class="feature_info_text">
                        <p>Our Smart factory tools like production intelligence,
                            store management, BTB monitoring, planning etc.
                            are all connected to make rich insights so that you
                            can manage your factory efficiently.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m6 l7">
                    <div class="feature_right_img">
                        <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/supplier-admin.png')}}" alt="omd" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- If we need pagination -->
            <div class="navigation">
              <div class="prev_after">
                <div class="features_slider-button-prev"><span class="material-icons">
                    west
                  </span>
                </div>
                <div class="features_slider-button-next"><span class="material-icons">
                    east
                  </span>
                </div>
              </div>
              <div class="features_slider-pagination"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="we_believe py-50">
        <div class="section_title">
          <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/we-believe.png')}}" class="we-believe-img" src="We Believe" />
          <h3 class="py-50 we-believe-title">
            We believe traceability is the first step to sustainability
          </h3>
        </div>
        <div class="we_believe_container">
          <p>
            Our goal is to help you with intelligence to make better decisions about
            reducing your product's carbon footprint. Our traceable supply chain enables
            us to develop the sustainability score of a product and calculate its
            carbon footprint. Multi-tier supplier mapping system also enables us to
            track down the main source of carbon within the supply chain.
          </p>
        </div>
      </div>
      <div class="achivement py-50">
        <h3 class="achieved-title">What have we achieved?</h3>
        <div class="achivement_container">
          <div class="row">
            <div class="col m6 achivement-box-1">
              <div class="achivement_box top_border">
                <div class="icon">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/success-achievement.png')}}" alt="achivement" />
                </div>
                <div class="description">
                  Successfully created a visible supply chain of Bangladesh
                  RMG Industry.
                </div>
              </div>
            </div>
            <div class="col m6 achivement-box-2">
              <div class="achivement_box top_border">
                <div class="icon">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/success-achievement.png')}}" alt="achivement" />
                </div>
                <div class="description">
                  Setup technical support for executing orders with faster
                  development and trade security.
                </div>
              </div>
            </div>
            <div class="col m6 achivement-box-3">
              <div class="achivement_box">
                <div class="icon">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/success-achievement.png')}}" alt="achivement" />
                </div>
                <div class="description">
                  Created a raw materials library of textile, yarn, trims and
                  accessories to support better sourcing.
                </div>
              </div>
            </div>
            <div class="col m6 achivement-box-4">
              <div class="achivement_box">
                <div class="icon">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/success-achievement.png')}}" alt="achivement" />
                </div>
                <div class="description">
                  Brought all sourcing support and services at a click of a button.
                </div>
              </div>
            </div>
            <div class="col m6 achivement-box-5">
              <div class="achivement_box">
                <div class="icon">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/success-achievement.png')}}" alt="achivement" />
                </div>
                <div class="description">
                  Opened doors to new markets for small medium manufacturers
                  of Bangladesh.
                </div>
              </div>
            </div>
            <div class="col m6 achivement-box-6">
              <div class="achivement_box">
                <div class="icon">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/success-achievement.png')}}" alt="achivement" />
                </div>
                <div class="description">
                  Implemented easy to use order management system and factory
                  digitization tools
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="vision_and_mission py-50">
        <div class="vision_and_mission_container">
          <div class="row">
            <div class="col m6 vision-box">
              <div class="vision_and_mission_box">
                <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/vision.svg')}}" alt="">
                <h4>Our Vision</h4>
                <p>To be the world's largest fashion
                  manufacturing platform with end-to-end
                  sourcing and production support
                  through technology.</p>
              </div>
            </div>
            <div class="col m6 mission-box">
              <div class="vision_and_mission_box">
                <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/mission.svg')}}" alt="">
                <h4>Our Mission</h4>
                <p>To simplify global fashion
                  manufacturing through a technology
                  platform that increases speed,
                  reliability and traceability. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="paths py-50">
        <div class="paths_container">
          <h3 class="paths-title">Let's get you to</h3>
          <div class="row">
            <div class="col s12 m4 l2 path-box-1">
              <div class="path_box">
                <div class="imgbox">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/design-studio.svg')}}" alt="icon" />
                </div>
                <a href="{{route('product.type.mapping',['studio', 'design'])}}">Design Studio
                  <span class="material-icons">navigate_next</span>
                </a>
              </div>
            </div>
            <div class="col s12 m4 l2 path-box-2">
              <div class="path_box">
                <div class="imgbox">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/sample-storefront.svg')}}" alt="icon" />
                </div>
                <a href="{{route('product.type.mapping',['studio', 'product sample'])}}">Sample Storefront
                  <span class="material-icons">navigate_next</span>
                </a>
              </div>
            </div>
            <div class="col s12 m4 l2 path-box-3">
              <div class="path_box">
                <div class="imgbox">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/fabric-library.svg')}}" alt="icon" />
                </div>
                <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">Fabric Library
                  <span class="material-icons">navigate_next</span>
                </a>
              </div>
            </div>
            <div class="col s12 m4 l2 path-box-4">
              <div class="path_box">
                <div class="imgbox">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/yarn-library.svg')}}" alt="icon" />
                </div>
                <a href="{{route('product.type.mapping',['raw_materials', 'yarn'])}}">Yarn Library
                  <span class="material-icons">navigate_next</span>
                </a>
              </div>
            </div>
            <div class="col s12 m4 l2 path-box-5">
              <div class="path_box">
                <div class="imgbox">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/accessories-library.svg')}}" alt="icon" />
                </div>
                <a href="{{route('product.type.mapping',['raw_materials', 'trims and accessories'])}}">Accessories Library
                  <i class="material-icons">navigate_next</i>
                </a>
              </div>
            </div>
            <div class="col s12 m4 l2 path-box-6">
              <div class="path_box">
                <div class="imgbox">
                  <img src="{{Storage::disk('s3')->url('public/frontendimages/about-image/icons/industry-isights.svg')}}" alt="icon" />
                </div>
                <a href="{{route('industry.blogs')}}">Industry Insights
                  <span class="material-icons">navigate_next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ending py-80">
        <h3>We have 300+ mentions in the media.</h3>
      </div>
    </div>
  </div>

@endsection

@push('js')
<script type="text/javascript">
    $(".why_us-tab").tabs();

    const features_slider = new Swiper('.features_slider', {
      // If we need pagination
      pagination: {
        el: '.features_slider-pagination',
        type: "fraction",
      },
      // Navigation arrows
      navigation: {
        nextEl: '.features_slider-button-next',
        prevEl: '.features_slider-button-prev',
      },
    });
    const swiper = new Swiper('.testemonial_slider', {
      // Navigation arrows
      navigation: {
        nextEl: '.testemonial_slider-button-next',
        prevEl: '.testemonial_slider-button-prev',
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      slidesPerView: 2,
      spaceBetween: 30,
    });

    var maxLength = 414;
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


</script>
@endpush
