@extends('layouts.app_containerless')

@section('content')
<h1 style="display: none;">Merchant Bay | Fashion Sourcing Solution | Tech Enabled B2B Platform</h1>
<!-- Banner section start  -->
<section class="bannerwrap">
	<div class="banner_slider">
		<div class="banner_inner">
			<!-- <h2>Apparel Sourcing Made Easy</h2> -->
			<h3>Find Ready Products, Designs, Raw Materials, Manufacturers</h3>
			<div class="banner_search">
				@php
					$searchType= request()->get('search_type');
				@endphp
				<div class="module-search">
					<select id="searchOption" class="select2 browser-default select-search-type">
                        <option value="all" name="search_key" {{ $searchType=="all" ? 'selected' : '' }}>All</option>
						<option value="product" name="search_key" {{ $searchType=="product" ? 'selected' : '' }}>Products</option>
						<option value="vendor"  name="search_key" {{ $searchType=="vendor" ? 'selected' : '' }}>Manufacturers</option>
					</select>
					<form name="system_search" action="{{route('onsubmit.search')}}" id="system_search" method="get">
						@if(Route::is('onsubmit.search'))
						<input type="text" placeholder="Example: Baby Sweaters, T-Shirts, Viscose, Radiant Sweaters etc." value="{{$searchInputValue}}" class="search_input"  name="search_input"/>
						@else
						<input type="text" placeholder="Example: Baby Sweaters, T-Shirts, Viscose, Radiant Sweaters etc." value="" class="search_input"  name="search_input"/>
						@endif
						<input type="hidden" name="search_type" class="search_type" value="" />
						<button class="btn waves-effect waves-light green darken-1 search-btn" type="submit" ><i class="material-icons dp48">search</i></button>
					</form>
                    <div id="search-results-wrapper" style="display: none;">
                        <div id="loadingSearchProgressContainer">
                            <div id="loadingSearchProgressElement">
                                <img src="{{asset('images/frontendimages/new_layout_images/loading-gray.gif')}}" width="128" height="15" alt="Loading">
                                <div class="loading-message" style="display: none;">Loading...</div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="close-search-modal-trigger"><i class="material-icons dp48">cancel</i></a>                    
					    <div id="search-results" style="display: none;"></div>
                    </div>
				</div>
				
			</div>
			<!-- <span class="search_verified">Example: Baby Sweaters, T-Shirts, Viscose, Radiant Sweaters etc.</span> -->
		</div>
	</div>
</section>
<!-- Banner section end  -->

<main id="homepage">
    <section class="banner pt-50">
        <div class="container">
            <div class="row banner-inner align-items-stretch d-flex flex-wrap">
                <div class="col s12 m12 l6 shop_banner_info_wrap">
                    <div class="description p-50">
                        <span>Find Your Next</span>
                        <h2 class="text-color-brand">Apparel Manufacturer</h2>
                        <!-- <p>Save the hassle of sourcing by connecting with the right partner, cutting your lead time and managing your orders with transparency.</p> -->
                        <ul>
                            <li>Save the hassle of sourcing by connecting with the right partner.</li>
                            <li>Cut your lead time with 3D virtual sampling and</li>
                            <li>Efficiently managing your orders through our Order Management Dashboard. </li>
                        </ul>
                        <a href="javascript:void(0);" class="button talk-to-us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">TALK TO US</a>
                        <img src="{{asset('images/homepage/circle.svg')}}" alt="circle"/>
                    </div>
                </div>
                <img class="line" src="{{asset('images/homepage/banner-line.png')}}" alt="line">
                <div class="col s12 m12 l6 shop_banner_img_wrap">
                    <div class="banner-image">
                        <span>
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/8z7uqq_Zqzg" allowfullscreen></iframe>
                            <!-- <img src="images/homepage/banner-img.png" alt="banner-img"> -->
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about pt-75">
        <div class="section-heading mb-100">
            <h3>What Can Merchant Bay Do For You?</h3>
        </div>
        <div class="container">
            <div class="row about-item mb-30">
                <div class="col s12 m2 d-none d-md-block">
                    <img class="full-image" src="{{asset('images/homepage/about-icon-1.svg')}}" alt="icon">
                    <!-- <div class="icon-box">
                        <div class="icon-box-inner-circle">
                            <img src="images/homepage/about-icon-1.png" alt="icon">
                        </div>
                    </div> -->
                </div>
                <div class="col s12 m12 l6">
                    <div class="item-body">
                        <span class="index-visible-circle"></span>
                        <div class="index-transparent-circle">
                            <img src="{{asset('images/homepage/about-index-1.svg')}}" alt="index" />
                        </div>
                        <div class="item-description">
                            <h4 class="text-color-brand">Connect you with 1000+ suppliers</h4>
                            <p class="mb-15">We have over 20 years’ worth of experience in the apparel industry in Bangladesh, with extensive industry knowledge. We have <span>1000+ suppliers</span> ready to create your products. Your designs + our manufacturing = a match made in apparel heaven.</p>
                            <a href="{{route('rfq.index')}}" class="button">Submit RFQ</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row about-item mb-30 d-flex justify-content-end">
                <div class="col s12 m2 l2 d-none d-md-block about_icon_wrap">
                    <img class="full-image" src="{{asset('images/homepage/about-icon-2.svg')}}" alt="icon">
                    <!-- <div class="icon-box">
                        <div class="icon-box-inner-circle">
                            <img src="images/homepage/about-icon-2.png" alt="icon">
                        </div>
                    </div> -->
                </div>
                <div class="col s12 m12 l6">
                    <div class="item-body">
                        <span class="index-visible-circle"></span>
                        <div class="index-transparent-circle">
                            <img src="{{asset('images/homepage/about-index-2.svg')}}" alt="index" />
                        </div>
                        <div class="item-description">
                            <h4 class="text-color-brand">Make Your Sourcing Easy</h4>
                            <p class="mb-15">We offer a balance of technology and traditional offline support. Our solutions let clients stay connected with multiple stakeholders in one place. We also have boots on the ground in Bangladesh, which enable us to provide you with real-time updates.</p>
                            <a href="javascript:void(0);" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;" class="button">Talk to Us</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row about-item">
                <div class="col s12 m2 l2 d-none d-md-block">
                    <img class="full-image" src="{{asset('images/homepage/about-icon-3.svg')}}" alt="icon">
                    <!-- <div class="icon-box">
                        <div class="icon-box-inner-circle">
                            <img src="images/homepage/about-icon-3.png" alt="icon">
                        </div>
                    </div> -->
                </div>
                <div class="col s12 m12 l6">
                    <div class="item-body">
                        <span class="index-visible-circle"></span>
                        <div class="index-transparent-circle">
                            <img src="{{asset('images/homepage/about-index-3.svg')}}" alt="index" />
                        </div>
                        <div class="item-description">
                            <h4 class="text-color-brand">Shorten Your Lead Time</h4>
                            <p class="mb-15">With our <span>3D virtual sampling</span> support, we can save you thousands of dollars and more than 21 days. From design to shipping, we got you covered. Fashion brands: book a call now, we guarantee you won’t regret it.</p>
                            <a href="{{route('buydesignsproducts')}}" class="button">Shop Designs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="demoButton py-40">
        <div class="container">
            <div class="content flex-wrap">
                <p>Merchandising have never seemed so easy before.</p>
                <div class="button-group">
                <a href="javascript:void(0);" class="button talk-to-us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">TALK TO US</a>
                <a href="{{route('front.tools')}}" class="button outline">Explore Dashboard</a>
                </div>
            </div>
        </div>
    </section>

    <section class="delivaryTime pt-60">
        <div class="container">
            <div class="guarantee">
                <img src="{{asset('images/homepage/five-star-rate.svg')}}" alt="rate">
                <h3>Merchant Bay Guarantee</h3>
                <p>Your Apparel Will Be Ready On Time Or We Work For Free</p>
            </div>
            <hr/>
            <div class="ontimeDescription">
                <div class="align-items-center d-flex flex-wrap align-items-md-stretch">
                    <div class="col s12 m12 l6">
                        <div class="banner-image">
                            <span>
                                <img src="{{asset('images/homepage/delivaryTime-img-apparels.png')}}" alt="banner-img">
                            </span>
                        </div>
                    </div>
                    <div class="col s12 m12 l6">
                        <div class="description p-50">
                            <h2 class="text-color-brand">On Time Or Freeeeee.</h2>
                            <p>Imagine having access to a digital marketplace of over 1000 independently verified apparel manufacturers in Bangladesh. And using an intelligent order management system to track your products’ progress. That’s Merchant Bay. And, we’re so confident in our manufacturers and system that</p>
                            <span style="color: #217156; font-weight: 500; font-size: 14px; letter-spacing: inherit;">“If your apparel isn’t ready on time, we work for free”</span>
                            <p class="mb-15">If you’re a fashion buyer, our guarantee means you’ve got nothing to lose. Book a call now to find out how we can help you get your designs on the market faster.</p>
                            <a href="javascript:void(0);" class="button talk-to-us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">TALK TO US</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Perform at Your Best-->
    <section class="perform-header">
        <div class="container">
            <div class="clear30" style="height: 0px; margin-bottom: 48px;"></div>
            <div>
                <h2 class="homebHd mb20">PERFORM AT YOUR BEST WITH EASE</h2>
                <p class="homepgp mb50" style="margin-bottom: 50px;" >Over 1000 suppliers and buyers can search, connect and manage their business with our 3-dimensional  sourcing platform</P>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col m12 plr0 htbcont">
                    <!--left-->
                    <div class="col s12 m12 l4 plr0">
                        <div class="htbcont-lft">
                            <ul class="tbm">
                                <li>
                                    <a href="javascript:void(0);" id="supplier" onclick="makeactive('suppliercontent',this)" class="active">
                                        Suppliers<br>
                                        <span>Adapt to the Smart and Credible way to present your business</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="buyer" onclick="makeactive('buyercontent',this)">
                                        Buyers<br>
                                        <span>The most reliable way to find and manage a supplier in Bangladesh</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="thirdparty" onclick="makeactive('thirdpartycontent',this)">
                                        Third Party Verification<br>
                                        <span>Know how we verify our suppliers</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="merchandising" onclick="makeactive('merchandisingcontent',this)">
                                        Merchandising Assistance&nbsp;<sup><i class="fa fa-plus" aria-hidden="true"></i></sup><br>
                                        <span>With our expert Merchandising Assistance learn how we solve your problem</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="order" onclick="makeactive('ordercontent',this)">
                                        Order Management Dashboard<br>
                                        <span>Book a demo call to see how our Dashboard makes your life super easy</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="col-md-9 left_bottom_note">
                                <p>“We believe that to expand our markets, reach out to the right business partners, we need to level up our digital footprint with credibility as that is now the best way of finding and being found.”</p>
                                <div class="clear30"></div>
                                <p><strong>Abrar H Sayem</strong></p>
                                <p>Founder, Merchant Bay Ltd.</p>
                            </div>
                            <div class="clear50 d-none d-md-block"></div>
                            <div class="clear20 d-none d-md-block"></div>
                        </div>
                    </div>
                    <!--/left-->

                    <!--right-->
                    <div class="col s12 m12 l8 plr0" id="suppliercontent">
                        <div class="row">
                            <h2 class="homebHd-sm mb20 mtop30">Adapt to the Smart and Credible way to present your business</h2>
                            <p class="homepgp-sm mb30">Open a Digital Profile on Merchant Bay to be on the niche Search Engine of Bangladesh manufacturing industry and get Verified to be noticed and win trust of buyers.</P>
                        </div>
                        <div class="clear"></div>
                        <img src="{{asset('images/homepage/profile_mockup.png')}}" alt="" class="img-responsive">
                        <div class="clear20"></div>
                    </div>
                    <div class="col s12 m12 l8 plr0" id="buyercontent" style="display: none;">
                        <div class="row">
                            <h2 class="homebHd-sm mb20 mtop30">The most reliable way to find and manage a supplier in Bangladesh</h2>
                            <p class="homepgp-sm mb30">Send your inquiry through RFQ (Request For Quotation) and let our smart matching system find the best matched suppliers to quote you, along with instant quotation you will have the advantage of connecting to Verified Suppliers, Order Management Dashboard and Merchandising Assistance.</P>
                        </div>
                        <div class="clear"></div>
                        <img src="{{asset('images/homepage/profile_mockup.png')}}" alt="" class="img-responsive">
                        <div class="clear20"></div>
                    </div>
                    <div class="col s12 m12 l8 plr0" style="display: none;" id="thirdpartycontent">
                        <div class="clear30"></div>
                        <p class="homepgp-sm"><b style="color:#217156; font-size:20px;">Third Party Verification<br></b></P>
                        <p class="homepgp-sm mb15">Know how we verify our suppliers</P>
                            <img src="{{asset('images/homepage/Thirdparty-verification.jpg')}}" alt="" class="img-responsive">
                        <div class="clear20"></div>
                        <div class="col s12 m10 col-md-offset-1 perform_tab_table">
                            <table class="table table-borderless ">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="homepgp-sm" style="text-align:left; padding-bottom:5px;"><strong>Protocol of Verification Process</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width:4%;"><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2" style="width:96%;">Step 1: Confirming general information</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Step 2: Checking all the mentioned information with physical visit by trained auditor</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Step 3: Cross checking the information by rechecking the gathered information with association / trade body</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Step 4: Goodwill check with the buyers the supplier served previously</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clear30"></div>
                        <div class="col s12 m10 col-md-offset-1 perform_tab_table">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="homepgp-sm" style="text-align:left; padding-bottom:5px;"><strong>Parameters of Verification</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width:4%;"><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2" style="width:96%;">Basic information verification</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Physical existence verification</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Capacity and Ability verification</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Compliance with local government</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Industry affiliation</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Goodwill check</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clear30"></div>
                        <div class="com m12">
                            <p class="homepgp-sm mb30">
                                <strong style="color:#217156;">Awarding the Verification Badge<br></strong>
                                After our verification process, we provide the badge with which a supplier can be trusted
                            </P>
                        </div>
                    </div>

                    <div class="col s12 m12 l8 plr0" style="display: none;" id="merchandisingcontent">
                        <div class="clear30"></div>
                        <p class="homepgp-sm"><b style="color:#217156; font-size:20px;">Merchandising Assistance<br></b></P>
                        <div class="clear"></div>
                        <p class="homepgp-sm mb15">
                            With our expert merchandiser getting tagged with your sourcing requirement, you will receive
                        </P>
                        <img src="{{asset('images/homepage/Merchandising-assistance.jpg')}}" alt="" class="img-responsive">
                        <div class="clear"></div>
                        <div class="col s12 m10 col-md-offset-1 perform_tab_table">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td style="width:4%;"><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2" style="width:96%;">24/7 Support on and offline</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Due diligence on behalf of you in finding the right supplier</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Real Time Follow up with supplier and updates</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Keep an eye on your Time and Action Plan and assuring on time shipment</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Providing you with inspection reports to assure your product quality</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col s12 m12 l8 plr0" style="display: none;" id="ordercontent">
                        <div class="clear30"></div>
                        <p class="homepgp-sm"><b style="color:#217156; font-size:20px;">Order Management Dashboard<br></b></P>
                        <div class="clear"></div>
                        <p class="homepgp-sm mb15">
                            With our Smart Order Management Dashboard you can
                        </P>
                        <img src="{{asset('images/homepage/omd_on_mac.png')}}" alt="" class="img-responsive">

                        <div class="clear10"></div>
                        <div class="col m10 s12 col-md-offset-1 perform_tab_table">
                            <table class="table table-borderless ">
                                <tbody>
                                    <tr>
                                        <td style="width:4%;"><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2" style="width:96%;">Follow up on your Time & Action Plan</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Create or Share Purchase Order</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Share and Save Files</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">View Daily Production Update</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Comment and Share Feedback to everyone at once</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Communicate with multiple stakeholder in one messenger</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-circle homepgp-sm2-bullet" aria-hidden="true"></i></td>
                                        <td class="homepgp-sm2">Have all communication and updates sorted order wise</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clear30"></div>
                        <div class="col s12 m12 text-center mtop40">
                            <!--<a href="" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/abrarsayem'});return false;">Book a Call</a>-->
                            <div class="center-align book_call"> 
                                <a href="" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;" class="jb"> <span class="material-icons">phone</span> &nbsp;Book a Call </a>
                            </div>                        
                        </div>
                    </div>
                    <!--right-->
                </div>
            </div>
        </div>
    </section>

	<div class="footer_topWrap">
		<div class="container">
			<div class="row">
				<div class="col s12 m6 l5 left">
					<div class="center-align thumb_box"><img src="{{asset('images/frontendimages/new_layout_images/thumb.png')}}" alt=""></div>
					<p>Your apparel will be ready <br /> on time or we work for free!</p>
				</div>
				<div class="col s12 m6 l5 right">
					<p>Merchandising have never seemed so easy before.</p>
					<div class="btn_talk ">
						<a class="btn_white" href="javascript:void(0);" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</a>
					</div>
				</div>
			</div>
		</div>
	</div>    

    <div class="modal fade bs-example-modal-md" id="book-call-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content ic-signup-wrapper modal-bdy-bdr">
                <div class="ic-signup-title">
                    <h2>Book a call </h2>
                    <button type="button" class="close" data-dismiss="modal" style="position: absolute;top: 15px;right: 15px;"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="ic-signup-form">
                    <form class="sampleformbox" id="bookRequestSampleForm" action="" method="POST" style="display: block;">
                        @csrf
                        <div class="inrsampleformbox">
                            <div class="form-group">
                                <label>Select Date and Time <span class="error">*</span></label>
                                <input type="datetime-local" id="birthdaytime" name="book_call_date" required>
                            </div>
                            <div class="form-group">
                                <label>Your Name <span class="error">*</span></label>
                                <input type="text" class="form-control" name="book_call_name" required="">
                            </div>
                            <div class="form-group">
                                <label>Email Address <span class="error">*</span></label>
                                <input type="email" class="form-control" name="book_call_email" required="">
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span class="error">*</span></label>
                                <input type="number" class="form-control" name="book_call_phone" required="">
                            </div>
                            <div class="form-group">
                                <label>Address <span class="error">*</span></label>
                                <input type="text" class="form-control" name="book_call_address" required="">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="3" autocomplete="off" spellcheck="false"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">SEND</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="subscribe-modal-popup">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="row">
                    <div class="col s12 m6 l6 position-relative">
                        <button type="button" class="close d-md-none d-block" data-dismiss="modal" style="position: absolute;top: 15px;right: 32px;"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <img src="{{ url('images/subscribe_newsletter.png') }}" class="w-100">
                    </div>
                    <div class="col s12 m6 l6 subscription-form-block">
                        <button type="button" class="close d-md-block" data-dismiss="modal" style="position: absolute;top: 15px;right: 32px;"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <div class="ic-signup-form">
                            <div class="subscribe-form">
                                <div class="subscription-form-mobile-logo"><center><img src="{{ url('images/homepage/subscribe_newsletter_mobile_logo_bg.png') }}" width="200px" alt="" /></center></div>
                                <h3>Subscribe to Monthly Industry Insights</h3>
                                <form action="#" method="post">
                                    @csrf
                                    <input type="hidden" name="captcha_token" class="captcha_token" value="">
                                    <div class="form-group">
                                        <label>Your Name <span class="error">*</span></label>
                                        <input type="text" class="form-control s-name-field" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address <span class="error">*</span></label>
                                        <input type="email" class="form-control s-email-field" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Company Name <span class="error">*</span></label>
                                        <input type="text" class="form-control s-cname-field" name="company_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" name="description">
                                    </div>
                                    <div class="form-group checkbox-block">
                                        <input type="checkbox" id="subscribe_modal_show_hide" name="subscribe_modal_show_hide" >
                                        <label for="subscribe_modal_show_hide"> Don't Show Me Again</label><br>
                                    </div>
                                    <div class="captchaContent" style="margin-bottom: 15px;">
                                        <div class="g-recaptcha" data-sitekey="6Lf_azEaAAAAAK4yET6sP7UU4X3T67delHoZ-T9G" data-callback="getCaptchaResponseReturn"></div>
                                        <div class="messageContent" style="color: red; text-align: left;"></div>
                                    </div>
                                    <button type="button" class="button submit-subscription-form-popup" style="background: #55A860;">Subscribe</button>
                                    <button type="submit" id="page_button" style="display: none;"></button>
                                </form>
                                {{-- <p class="descrioptionContents text-right" style="display: none;">{{ $subscription->contents['details'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>


@endsection
@section('style')
<style>
/*============= Reset CSS =============*/

/*============= Common CSS =============*/
    .w-100{
        width: 100%;
    }
    .pt-40{
        padding-top: 40px;
    }
    .pt-50{
        padding-top: 50px;
    }
    .pt-60{
        padding-top: 60px;
    }
    .pt-75{
        padding-top: 75px;
    }
    .pt-80{
        padding-top: 80px;
    }
    .pt-100{
        padding-top: 100px;
    }

    .pb-40{
        padding-bottom: 40px;
    }
    .py-40{
        padding-top: 40px;
        padding-bottom: 40px;
    }
    .p-50{
        padding: 50px;
    }
    .mb-15{
        margin-bottom: 15px;
    }
    .mb-20{
        margin-bottom: 20px;
    }
    .mb-30{
        margin-bottom: 30px;
    }
    .mb-100{
        margin-bottom: 100px;
    }
    .mb30 {
        margin-bottom: 30px;
    }
    .mb30 {
        margin-bottom: 50px;
    }
    
    .d-flex{
        display: flex;
    } 
    .d-block{
        display: block;
    }
    .d-none{
        display: none;
    }
    .align-items-center{
        align-items: center;
    }
    .align-items-stretch{
        align-items: stretch;
    }
    .justify-content-end{
        justify-content: flex-end;
    }
    .flex-wrap{
        flex-wrap: wrap;
    }
    .text-color-brand{
        color: #217156;
    }
    .bg-brand{
        background-color: #217156;
    }
    .button{
        padding: 12px 22px;
        text-transform: uppercase;
        background-color: #217156;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-weight: 500;
    }

    @media screen and (min-width: 992px) {
        .d-md-none{
            display: none;
        } 
        .d-md-block{
            display: block;
        }

        .align-items-md-center{
            align-items: center;
        }
        .align-items-md-stretch{
            align-items: stretch;
        }
    }

    @media screen and (max-width: 1199px) {
        #homepage .demoButton .content p{
            text-align: center;
            width: 100%;
            margin-bottom: 16px;
        }
        #homepage .demoButton .content .button-group{
            margin: 0 auto;
            display: flex;
        }
    }
    @media screen and (max-width: 991px) {
        .col-md-6{
            width: 100%;
        }

        #homepage .banner .description{
            margin-bottom: 30px;
        }
        #homepage .banner .banner-image{
            height: 400px;
        }
        #homepage .delivaryTime .ontimeDescription .banner-image{
            margin-bottom: 32px;
        }

        .tbm{
            margin-bottom: 32px;
        }
    }
    @media screen and (max-width: 575px) {
        .d-sm-none{
            display: none;
        }
        .d-sm-block{
            display: block;
        }


        #homepage .banner{
            padding-bottom: 180px;
        }
        #homepage .banner .description,
        #homepage .delivaryTime .ontimeDescription .description{
            padding: 24px;
        }
        #homepage .banner .description span{
            font-size: 18px
        }
        #homepage .banner .description h2, #homepage .homebHd,
        #homepage .delivaryTime .ontimeDescription .description h2{
            font-size: 35px;
            line-height: 50px;
        }
        #homepage .banner .banner-image{
            height: 300px;
        }

        #homepage .about .about-item .item-body .item-description h4{
            line-height: 32px;
            margin-bottom: 16px;
        }
        #homepage .about{
            padding-bottom: 200px;
        }

        #homepage .demoButton .content .button-group button.outline, 
        #homepage .demoButton .content .button-group a.outline{
            padding: 5px 10px;
        }
    }

    @media screen and (max-width: 767px) {
        #subscribe-modal-popup .ic-signup-form {
            padding-top: 25px;
        }
        #subscribe-modal-popup .col-md-6.position-relative {
            display: none;
        }
        .subscription-form-block {
            background-image: url('../images/homepage/subscribe_newsletter_mobile_bg.png');
            background-position: center center;
            background-size: cover;
        }
        .subscription-form-block .close {
            color: #fff;
            opacity: 1;
        }
        .subscription-form-mobile-logo {
            padding-bottom: 20px;
            display: block;
        }
        .subscription-form-block h3 {
            color: #fff;
            padding-bottom: 20px;
            display: block;
            font-weight: 800 !important;
        }
        .subscription-form-block .subscribe-form label {
            color: #fff;
            text-align: left;
            display: block;
        }
        .checkbox-block {
            text-align: left;
        }
        .checkbox-block label {
            display: inline-block !important;
            vertical-align: top;
        }
    }
</style>
@endsection
@push('js')
<script>
function makeactive(id,el)
{
    $('#buyercontent').css('display','none');
    $('#suppliercontent').css('display','none');
    $('#thirdpartycontent').css('display','none');
    $('#merchandisingcontent').css('display','none');
    $('#ordercontent').css('display','none');
    $('#thirdparty').removeClass('active');
    $('#merchandising').removeClass('active');
    $('#order').removeClass('active');
    $('#supplier').removeClass('active');
    $('#buyer').removeClass('active');
    $('#'+id).css('display','block');
    $(el).addClass('active');
}
</script>
@endpush
