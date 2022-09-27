@extends('layouts.app_containerless')
@section('style')
<style >
/*============= Importing Fonts =============*/
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap");
#home {
  font-family: "Poppins", sans-serif !important;
  color: #707070;
  font-size: 14px;
}

#main {
  padding: 0px !important;
  padding-top: 30px !important;
}

  /*============= Reset CSS =============*/
  #home h3,
  #home h2,
  #home h4,
  #home h5,
  #home h6 {
    font-family: "Poppins", sans-serif !important;
    font-weight: 600;
  }

  #home h2{
    font-size: 36px;
    line-height: 54px;
  }

  /*============= Common CSS =============*/
  #home .pt-40 {
    padding-top: 40px;
  }
  #home .pt-50 {
    padding-top: 50px;
  }
  #home .pt-60 {
    padding-top: 60px;
  }
  #home .pt-75 {
    padding-top: 75px;
  }
  #home .pt-80 {
    padding-top: 80px;
  }
  #home .pt-100 {
    padding-top: 100px;
  }

  #home .pb-40 {
    padding-bottom: 40px;
  }
  #home .pb-75 {
    padding-bottom: 75px;
  }

  #home .py-40 {
    padding-top: 40px;
    padding-bottom: 40px;
  }
  #home .py-60 {
    padding-top: 60px;
    padding-bottom: 60px;
  }
  #home .py-75 {
    padding-top: 75px;
    padding-bottom: 75px;
  }

  #home .p-50 {
    padding: 50px;
  }

  #home .mb-15 {
    margin-bottom: 15px;
  }
  #home .mb-20 {
    margin-bottom: 20px;
  }
  #home .mb-30 {
    margin-bottom: 30px;
  }
  #home .mb-75 {
    margin-bottom: 75px;
  }
  #home .mb-90 {
    margin-bottom: 90px;
  }
  #home .mb-100 {
    margin-bottom: 100px;
  }

  #home .mr-10 {
    margin-right: 10px;
  }
  #home .ms-auto {
    margin-left: auto;
  }

  #home .w-50 {
    width: 50%;
  }
  
  #home .cursor-pointer{
    cursor: pointer;
  }

  #home .d-flex {
    display: flex;
  }
  #home .d-inline-flex {
    display: inline-flex;
  }
  #home .align-items-center {
    align-items: center;
  }
  #home .align-items-stretch {
    align-items: stretch;
  }
  #home .justify-content-start {
    justify-content: flex-start;
  }
  #home .justify-content-center {
    justify-content: center;
  }
  #home .justify-content-end {
    justify-content: flex-end;
  }

  #home .text-color-brand {
    color: #217156;
  }
  #home .text-color-white {
    color: #fff;
  }
  #home .font-regular {
    font-weight: 400;
  }
  #home .font-semibold {
    font-weight: 600;
  }

  #home .bg-brand {
    background-color: #217156;
  }

  #home button:focus {
    border: none;
    outline: none;
  }
  #home .button {
    padding: 12px 22px;
    text-transform: uppercase;
    background-color: #217156;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    transition: 0.3s;
  }
  #home .button:hover {
    background-color: #0e3f2f;
  }

  #home .button.light-bg {
    background-color: #81a95a;
  }
  #home .button.light-hover:hover {
    background-color: #81a95a;
  }
  #home .button.regular-hover:hover {
    background-color: #217156;
  }

  #home .section-heading h3 {
    text-align: center;
    color: #81a95a;
    font-size: 30px;
    line-height: 45px;
    text-transform: capitalize;
  }
  #home .section-heading span {
    text-align: center;
    display: block;
    font-size: 24px;
    font-weight: 500;
    line-height: 36px;
  }
  /*============= Banner Section =============*/
  #home .banner {
    height: 100vh;
    display: flex;
    align-items: center;
    background-image: url("{{Storage::disk('s3')->url('public/frontendimages/tools_images/banner-bg.png')}}");
    background-size: cover;
    background-position: bottom center;
  }
  #home .banner .banner-inner {
    width: 100%;
  }
  #home .banner .banner-inner .description h2 {
    color: #fff;
  }
  #home .banner-inner .description span {
    color: #beffc6;
    font-size: 18px;
    margin-bottom: 18px;
    display: block;
  }
  #home .banner-inner .description p {
    font-size: 15px;
    margin-bottom: 42px;
    color: #fff;
  }
  #home .banner .banner-inner .image img {
    width: 100%;
  }

  /*============= Advance Tool Section =============*/
  #home .advance-tools {
    height: 100vh;
    display: flex;
    align-items: center;
    background-image: url("{{Storage::disk('s3')->url('public/frontendimages/tools_images/banner-bg.png')}}");
    background-size: cover;
    background-position: bottom center;
  }
  #home .advance-tools .banner-inner {
    width: 100%;
  }
  #home .advance-tools .banner-inner .description h2 {
    color: #fff;
  }
  #home .advance-tools .banner-inner .image img {
    width: 100%;
  }

  /*============= RequestDemo Section =============*/
  #home .requestDemo img {
    display: block;
    margin: 0 auto;
    height: 100px;
    width: 100px;
  }
  #home .requestDemo h3 {
    text-align: center;
    color: #81a95a;
    font-size: 30px;
    line-height: 45px;
    text-transform: capitalize;
    font-weight: 400;
    margin-bottom: 20px;
  }
  #home .requestDemo button {
    margin: 0 auto;
    display: block;
  }

  /*============= Pricing table Section =============*/
  #home .pricing-table {
    background-image: url("{{Storage::disk('s3')->url('public/frontendimages/tools_images/pricing-table-bg.png')}}");
    background-position: bottom center;
    background-size: cover;
    padding-bottom: 200px;
  }
  #home .pricing-table .price-card {
    padding: 50px 30px;
    box-shadow: 0px 3px 15px #81a95a42;
    border-radius: 15px;
    background-color: #fff;
    text-align: center;
    width: max-content;
    height: 100%;
  }
  #home .pricing-table .price-card .pricing {
      margin-bottom: 24px;
    }
    #home .pricing-table .price-card .pricing h4 {
        font-size: 24px;
        line-height: 36px;
        margin-bottom: 0;
    }
    #home .pricing-table .price-card .pricing h6 {
        font-size: 13px;
        line-height: 20px;
        color: #999;
    }
  #home .pricing-table .price-card .nametag {
    padding: 7px 30px;
    font-size: 16px;
    text-transform: uppercase;
    background-color: #77a359;
    border-radius: 7px;
    color: #fff;
    margin-bottom: 18px;
    display: inline-block;
  }
  #home .pricing-table .price-card h5 {
    font-size: 16px;
    font-weight: 600;
    color: #707070;
    text-transform: uppercase;
    margin-bottom: 16px;
  }
  #home .pricing-table .price-card li {
    font-size: 14px;
    color: #707070;
    line-height: 20px;
  }
  #home .pricing-table .price-card button {
    margin-top: 20px;
  }
  #home .pricing-table .price-card.popular {
    background: transparent linear-gradient(0deg, #81a95a 0%, #217156 100%) 0%
      0% no-repeat padding-box;
    overflow: hidden;
    position: relative;
    z-index: 1;
  }
  #home .price-card.popular .nametag {
      background-color: #ffa200;
    }
    #home .pricing-table .price-card.popular h5,
    #home .pricing-table .price-card.popular h4,
    #home .pricing-table .price-card.popular li,
    #home .pricing-table .price-card.popular h6 {
      color: #fff;
    }
  #home .pricing-table .price-card.popular .popular-badge {
    position: absolute;
    width: 100%;
    font-size: 11px;
    color: #707070;
    line-height: 17px;
    padding-top: 10px;
    padding-bottom: 10px;
    background-color: #fff;
    transform: rotate(45deg);
    right: -110px;
    top: 25px;
  }

  /*============= Features Section =============*/
  #home .features {
    background-image: url("{{Storage::disk('s3')->url('public/frontendimages/tools_images/features-bg.png')}}");
    background-position: bottom center;
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 900px;
    padding-bottom: 50px;
  }
  #home .features .tab-wrapper {
    background-color: #fff;
    border-radius: 15px;
  }
  #home .features .tab-wrapper .link-div {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgb(33, 113, 86);
    background: linear-gradient(
      90deg,
      rgba(33, 113, 86, 1) 11%,
      rgba(129, 169, 90, 1) 86%
    );
    border-radius: 15px;
    color: white;
  }
  #home .features .tab-wrapper .link-div .tab-button {
    height: 120px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    width: calc(100% / 4);
  }
  #home .features .tab-wrapper .link-div .tab-button .tab-button-inner {
    display: inline-flex;
    align-items: center;
  }
  #home .features .tab-wrapper .link-div .tab-button .tab-button-inner .button-text {
    font-family: "Poppins", sans-serif !important;
  }
  #home .features .tab-wrapper .link-div .tab-button .tab-button-inner .icon img {
    width: 40px;
    height: 40px;
    margin-right: 15px;
  }
  #home .features .tab-wrapper .share-list {
    padding: 60px;
  }
  #home .features .tab-wrapper .share-list .show-hide-content .content-img img {
    border: 8px solid white;
    border-radius: 12px;
    display: block;
    margin-left: auto;
    height: 333px;
    max-width: 100%;
  }
  #home .features .tab-wrapper .share-list .show-hide-content .description h4 {
    font-size: 24px;
    color: #707070;
    margin-bottom: 18px;
  }
  #home .features .tab-wrapper .share-list .show-hide-content .description p {
    color: #707070;
    font-size: 18px;
  }

  #home .display-web {
    display: flex;
    width: 100%;
  }
  #home .display-mobile {
    display: none;
  }

  #home .link-div-i {
    text-decoration: none;
    background-color: rgba(0, 0, 0, 0);
    /* background-color:  #81A95A; */
    border-radius: 15px;
  }
  #home .selected {
    color: white;
    background-color: #217156;
  }

  #home .link-div-i:hover {
    color: white;
    background-color: #217156;
    text-decoration: none;
    transition: 0.2s ease-in;
  }

  #home .flex-wrap{
    flex-wrap: wrap;
  }
  #home .order-0{
    order: 0;
  }
  #home .order-1{
    order: 1;
  }
  #home .order-2{
    order: 2;
  }

  @media only screen and (max-width: 992px) {
    #home .order-l-0{
    order: 0;
    }
    #home .order-l-1{
      order: 1;
    }
    #home .order-l-2{
      order: 2;
    }

    #home .mx-l-auto{
      margin-left: auto;
      margin-right: auto;
    }
    #home .mb-l-32{
      margin-bottom: 2rem;
    }
    
    #home .d-l-inline-flex{
      display: inline-flex;
    }
    #home .justify-content-l-center{
      justify-content: center;
    }

    #home .banner{
      height: unset;
      padding-top: 4rem;
      padding-bottom: 4rem;
    }
    #home .banner .right-side{
      margin-bottom: 2rem;
    }

    #home .features, 
    #home #pricing, 
    #home .advance-tools{
      height: unset;
      min-height: unset;
      padding-top: 40px;
      padding-bottom: 40px;
    }
    #home .features .tab-wrapper .link-div{
      overflow: auto;
    }
    #home .features .tab-wrapper .link-div .tab-button{
      height: 80px;
      min-width: 190px;
    }
    #home .features .tab-wrapper .share-list .show-hide-content .content-img img{
      height: auto;
    }
    #home .features .tab-wrapper .link-div .tab-button .tab-button-inner .icon img{
      height: 30px;
      width: 30px;
    }
    #home .features .tab-wrapper .link-div .tab-button .tab-button-inner .button-text{
      font-size: 12px;
    }
    #home .features .tab-wrapper .share-list .show-hide-content .description p{
      font-size: 16px;
    }

    #home #pricing{
      padding-bottom: 4rem;
    }
  }

  @media only screen and (max-width: 600px) {
    #home h2{
      font-size: 25px;
      line-height: 35px;
    }

    #home .pt-s-40{
      padding-top: 40px;
    }
    #home .mb-s-40{
      margin-bottom: 40px;
    }

    #home .banner-inner .description span{
      font-size: 16px;
      margin-bottom: .75rem;
    }
    #home .banner-inner .description p{
      font-size: 14px;
      margin-bottom: 1.25rem;
      color: #fff;
    }

    #home .features .tab-wrapper .share-list{
      padding: 30px;
    }
  }

</style>
@endsection

@section('content')

<div id="home">
    <section class="banner">
      <div class="banner-inner">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="left-side col s12 l6 order-l-1">
              <div class="description">
                <h2>
                  Manage your orders with <br />
                  Smart Order Management Dashboard.
                </h2>
                <span>
                  Managing task and following up with all supply chain
                  stakeholders has never been so easy for the RMG industry.
                </span>
                <p>
                  Having hundreds of threads over Mail, WhatsApp and Phone is
                  not required anymore. Using the correct organizational tools
                  can improve time management by 38%. 280 hours (7 weeks) per
                  year are lost by employees seeking clarification due to poor
                  communication.
                </p>
                <button class="button light-hover cursor-pointer" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</button>
              </div>
            </div>
            <div class="right-side col s12 l6 order-l-0">
                <img src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/banner.png')}}" alt="banner" />
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="features" class="features pt-75 pt-s-40">
      <div class="section-heading mb-75 mb-s-40">
        <h3>Our Top Features</h3>
      </div>
      <div class="container">
        <div class="tab-wrapper" id="id-3">
          <div class="link-div">
            <div class="display-web">
              <div class="tab-button link link-div-i col-6 col-md-3 icon-section" onclick="openCity(event, 'featureButton1')" target-el="featureButton1">
                <div class="tab-button-inner">
                  <div class="icon">
                    <img src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/icon-material-style.png')}}" alt="material-style" />
                  </div>

                  <div class="text-color-white ms-2 semi-bold button-text">
                    Style-wise <br />
                    Panel
                  </div>
                </div>
              </div>
              <div
                class="tab-button link link-div-i col-6 col-md-3 icon-section" onclick="openCity(event, 'featureButton2')" target-el="featureButton2"
              >
                <div class="tab-button-inner">
                  <div class="icon">
                    <img src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/icon-awesome-link.png')}}" alt="link icon" />
                  </div>

                  <div class="text-color-white text-left ms-2 semi-bold button-text">
                    Integrated Digital <br />
                    Supply Chain
                  </div>
                </div>
              </div>
              <div
                class="tab-button link link-div-i col-6 col-md-3 icon-section" onclick="openCity(event, 'featureButton3')" target-el="featureButton3">
                <div class="tab-button-inner">
                  <div class="icon">
                    <img src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/icon-awesome-calendar-check.png')}}" alt="calender" />
                  </div>
                  <div class="text-color-white ms-2 semi-bold button-text">
                    Smart Calendar
                    <br />
                    Management
                  </div>
                </div>
              </div>
              <div
                class="tab-button link link-div-i col-6 col-md-3 icon-section" onclick="openCity(event, 'featureButton4')" target-el="featureButton4">
                <div class="tab-button-inner">
                  <div class="icon">
                    <img
                      src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/icon-simple-campaignmonitor.png')}}"
                      alt="Simple Compaignmonitor Icon"
                    />
                  </div>
                  <div class="text-color-white ms-2 semi-bold button-text">
                    Production & Quality
                    <br />
                    Monitoring
                  </div>
                </div>
              </div>
            </div>
          </div>

          
          <div class="share-list" id="featureButton1">
              <div class="row show-hide-content">
              <div class="col s12 l6 content-img">
                  <img class="ms-auto mx-l-auto mb-l-32" src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/orderwise-panel.png')}}" alt="dashboard" />
              </div>
              <div class="col s12 l6 gray-text description">
                  <h4 class="title-1">Style-wise Panel</h4>
                  <p>
                  Have all communication and files of a style organized in a
                  single window to be able to follow up instantly in an
                  organized way
                  </p>
              </div>
              </div>
          </div>

          <div class="share-list" id="featureButton2">
              <div class="row show-hide-content">
              <div class="col s12 l6 content-img">
                  <img class="mx-l-auto mb-l-32" src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/dashboard-2.png')}}" alt="dashboard" />
              </div>
              <div class="col s12 l6 gray-text description">
                  <h4 class="title-1">Integrated Digital Supply Chain</h4>
                  <p>
                  Invite your buyers, suppliers and team with custom
                  permission in one place to streamline communication and
                  avoid any kind of delayed or miss communication.
                  </p>
              </div>
              </div>
          </div>

          <div class="share-list" id="featureButton3">
              <div class="row show-hide-content">
              <div class="col s12 l6 content-img">
                  <img class="mx-l-auto mb-l-32" src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/T&A-calender.png')}}" alt="dashboard" />
              </div>
              <div class="col s12 l6 gray-text description">
                  <h4 class="title-1">Smart Calendar Management</h4>
                  <p>
                  Manage time and action plan with integrated calendar
                  management tool. It gets super easy for the top management
                  to see pending tasks and tasks that needs instant attention.
                  </p>
              </div>
              </div>
          </div>

          <div class="share-list" id="featureButton4">
              <div class="row show-hide-content content-img">
              <div class="col s12 l6 content-img">
                  <img class="mx-l-auto mb-l-32" src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/production-report1.png')}}" alt="dashboard" />
              </div>
              <div class="col s12 l6 gray-text description">
                  <h4 class="title-1">Production and Quality Monitoring</h4>
                  <p>
                  Stay updated with all production and quality updates in an
                  organized way inside the style cart. Simple hack that makes
                  everything significantly easy.
                  </p>
              </div>
              </div>
          </div>
        </div>
      </div>
    </section>
    <section class="requestDemo py-60" style="background-color: #fff;">
        <img src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/problem-solve.svg')}}" alt="img" />
      <h3>Merchandising have never seemed so easy before.</h3>
    </section>
    <section id="pricing" class="pricing-table pt-75 pt-s-40">
      <div class="section-heading mb-75 mb-s-40">
        <h3>Smart OMD Pricing</h3>
      </div>
      <div class="container">
        <div class="row align-items-stretch">
          <div class="col s12 m6 l4 d-l-inline-flex justify-content-l-center mb-l-32">
            <div class="price-card">
              <span class="nametag">Trial</span>
              <h5 class="package-name">30 DAYS</h5>
              <div class="pricing">
                <h4 class="price">FREE</h4>
              </div>
              <div>
                <li>Manage unlimited orders</li>
                <li>Invite as many users as you need</li>
                <li>Live Customer support</li>
              </div>
              <button class="button light-hover cursor-pointer" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</button>
            </div>
          </div>
          <div class="col s12 m6 l4 d-inline-flex justify-content-center mb-l-32">
            <div class="price-card popular">
              <span class="popular-badge">Most Populer</span>
              <span class="nametag">Premium</span>
              <h5 class="package-name">PAID Quarterly</h5>
              <div class="pricing">
                <h4 class="price">$400</h4>
                <h6 class="price">$150/Mo (Save $50)</h6>
              </div>
              <div>
                <li>Manage unlimited orders</li>
                <li>Invite as many users as you need</li>
                <li>Live Customer support</li>
              </div>
              <button class="button light-hover cursor-pointer" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</button>
            </div>
          </div>
          <div class="col s12 m6 l4 d-inline-flex justify-content-end justify-content-l-center">
            <div class="price-card">
              <span class="nametag">PREMIUM</span>
              <h5 class="package-name">Paid Annually</h5>
              <div class="pricing">
                <h4 class="price">$1500</h4>
                <h6 class="price">$150/Mo (Save $200)</h6>
              </div>
              <div>
                <li>Manage unlimited orders</li>
                <li>Invite as many users as you need</li>
                <li>Live Customer support</li>
              </div>
              <button class="button light-hover cursor-pointer" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="advance-tools" style="margin-bottom: 0px;">
      <div class="banner-inner">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col s12 l6 order-l-1">
              <div class="description">
                <h2>M-Tools</h2>
                <span>
                  80% of papers and information that we keep, we never use. Make
                  data driven decision with M-OM Advance Tools
                </span>
                <p>
                  This is a Business Intelligence tool that helps you make use
                  of the data you generate and take informed decision. Make
                  monitoring and problem solving easy with smart analytics that
                  comes from only a couple of entry points. <br />
                  <br />
                  It is that SIMPLE.
                </p>
                <div class="button-group">
                  <button class="button light-hover cursor-pointer" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</button>
                </div>
              </div>
            </div>
            <div class="col s12 l6 order-l-0">
              <div class="image">
              <img src="{{Storage::disk('s3')->url('public/frontendimages/tools_images/mgmt-secret-weapon.png')}}" alt="secret weapon" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">

<!-- Calendly link widget end -->

@endsection

@push('js')
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
<script>
    openCity(event, "featureButton1");
    function openCity(evt, city) {
        var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("share-list");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-button");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove('selected');
            if(city === tablinks[i].getAttribute("target-el")){
                tablinks[i].classList.add('selected');
            }
        }
        
        document.getElementById(city).style.display = "block";
    }
</script>
@endpush