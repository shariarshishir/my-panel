@extends('layouts.app_containerless')
@section('content')

<div class="account_profile_wrapper">
    <div class="account_profile_menu">
        <div class="container">
            <div class="profile_account_desktop_menu">
                @include('new_business_profile.buyer_profile.profile_menu')
            </div>

            <div class="profile_account_mobile_menu" style="display: none;">
                <div class="row">
                    <div class="col s12">
                        <div class="profile_account_rightbar">
                            <a onclick="openProfileAccountNav()" href="javascript:void(0);" class="btn-product-sidenav"><i class="material-icons">filter_alt</i></a>
                        </div>
                    </div>
                    <div class="col s12">
                        <ul class="collapsible">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">menu</i></div>
                                <div class="collapsible-body">
                                    @include('new_business_profile.buyer_profile.profile_menu')
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="profileAccountRight">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeProfileAccountNav()"><i class="material-icons">clear</i></a>

                    <div class="new_profile_account_rightsidebar_mobile">
                        <div class="new_profile_account_myrfq_details">
                            <div class="new_profile_myrfq_details_topbox">
                                <h6>RFQ ID <span>785672990</span></h6>
                                <h5>Women's Long-Sleeve 100% Cotton Cable Crewn with emb log</h5>
                                <span class="posted_time">Posted 3m ago</span>

                                <div class="center-align btn_accountrfq_info">
                                    <a class="accountrfq_btn" href="javascript:void(0);" onclick="">Show More</a>
                                </div>
                                <div id="accountRfqDetailesInfoMobile" class="account_rfqDetailes_infoWrap" style="display: none;">
                                    <div class="row">
                                        <div class="col s6 m6 l5">
                                            <p>Quantity <br/> <b>15000 pcs</b></p>
                                            <p>Target Price <br/> <b>$7.50 /pc</b></p>
                                        </div>
                                        <div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>
                                        <div class="col s6 m6 l5">
                                            <p>Deliver in <br/> <b>18 days</b></p>
                                            <p>Deliver to <br/> <b>London</b></p>
                                        </div>
                                    </div>
                                    <div class="account_rfqDetailes_imgWrap">
                                        <h6>Attachments</h6>
                                        <img src="{{ Storage::disk('s3')->url('public/account-images/pro-1.png') }}" />
                                        <img src="{{ Storage::disk('s3')->url('public/account-images/pro-2.png') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="rfq_review_results_wrap">
                                <div class="rfq_review_results_nav">
                                    <ul>
                                        <li><a href="buyer-account-profile-my-rfq-message.html">Messages</a></li>
                                        <li class="active"><a href="buyer-account-profile-my-rfq.html">Quotations</a></li>
                                    </ul>
                                </div>
                                <div class="rfq_review_results_box">
                                    <div class="row">
                                        <div class="col s12 xl2 rfq_review_result_leftBox">
                                            <span class="new_rfq_avatar">
                                                <img src="./images/account-images/avatar.jpg" alt="avatar" itemprop="img">
                                            </span>
                                        </div>
                                        <div class="col s12 xl5 rfq_review_result_midBox">
                                            <div class="new_rfq_review">
                                                <h6>Zex Fashions BD</h6>
                                                <p>Offer Price: <span>$1000</span> </p>
                                                <button class="btn_green">Ask for PI</button>
                                            </div>
                                        </div>
                                        <div class="col s12 xl5 rfq_review_result_rightBox">
                                            <div class="new_rfq_review">
                                                <span class="rfqEatting"><i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i></span>
                                                <span class="rqf_verified"><img src="./images/account-images/rfq-verified.png" alt=""> Verified</span>
                                                <button class="btn_green">Issue PO</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rfq_review_results_box">
                                    <div class="row">
                                        <div class="col s12 xl2 rfq_review_result_leftBox">
                                            <span class="new_rfq_avatar">
                                                <img src="./images/account-images/avatar.jpg" alt="avatar" itemprop="img">
                                            </span>
                                        </div>
                                        <div class="col s12 xl5 rfq_review_result_midBox">
                                            <div class="new_rfq_review">
                                                <h6>Zex Fashions BD</h6>
                                                <p>Offer Price: <span>$1000</span> </p>
                                                <button class="btn_green">Ask for PI</button>
                                            </div>
                                        </div>
                                        <div class="col s12 xl5 rfq_review_result_rightBox">
                                            <div class="new_rfq_review">
                                                <span class="rfqEatting"><i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i></span>
                                                <span class="rqf_verified"><img src="./images/account-images/rfq-verified.png" alt=""> Verified</span>
                                                <button class="btn_green">Issue PO</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rfq_review_results_box">
                                    <div class="row">
                                        <div class="col s12 xl2 rfq_review_result_leftBox">
                                            <span class="new_rfq_avatar">
                                                <img src="./images/account-images/avatar.jpg" alt="avatar" itemprop="img">
                                            </span>
                                        </div>
                                        <div class="col s12 xl5 rfq_review_result_midBox">
                                            <div class="new_rfq_review">
                                                <h6>Zex Fashions BD</h6>
                                                <p>Offer Price: <span>$1000</span> </p>
                                                <button class="btn_green">Ask for PI</button>
                                            </div>
                                        </div>
                                        <div class="col s12 xl5 rfq_review_result_rightBox">
                                            <div class="new_rfq_review">
                                                <span class="rfqEatting"><i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i></span>
                                                <span class="rqf_verified"><img src="./images/account-images/rfq-verified.png" alt=""> Verified</span>
                                                <button class="btn_green">Issue PO</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile_account_innerinfo_wrap">
        <div class="container">
            <div class="account_profile_box">
                <div class="row">
                    <div class="col s12 m112">
                        <div class="profile_supplier_account_product_wrap">
                            <div class="profile_account_explore_info">
                                <div class="row">
                                    <div class="col s12 m12 l9">
                                        <div class="profile_account_searchBar">
                                            <div class="row">
                                                <div class="col s12 m5 l4">
                                                    <a class="modal-trigger post_new" href="#profileAccountPostNew">
                                                        <i class="material-icons">add</i><span>Add New</span>
                                                    </a>
                                                </div>
                                                <div class="col s12 m7 l8">
                                                    <div class="profile_account_search">
                                                        <i class="material-icons">search</i>
                                                        <input class="profile_filter_search" type="search" placeholder="Search Merchant Bay Studio/Raw Material Libraries" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile_product_view_menu">
                                            <ul>
                                                <li class="grid_view active"><a href="javascript:void(0);"><i class="material-icons">grid_view</i></a></li>
                                                <li class=""><a href="javascript:void(0);"><i class="material-icons">view_list</i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product_design_wrapper profile_account_product">
                                            <div class="row">
                                                <div class="col s6 m4 l3 product_item_box">
                                                    <div class="productBox">
                                                        <div class="inner_productBox">
                                                            <a href="javascript:void(0);">
                                                                <div class="imgBox">
                                                                    <img src="./images/account-images/pro-1.png" class="" alt="">
                                                                </div>
                                                                <div class="products_inner_textbox">
                                                                    <h4><span>Rugby Top-MB-2130</span></h4>
                                                                    <div class="row">
                                                                        <div class="col s12 m6">
                                                                            <div class="product_moq">
                                                                                MOQ: <br> <span>1000</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col s12 m6">
                                                                            <div class="pro_leadtime">
                                                                                Lead Time <br> <span>30-45</span> days
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s6 m4 l3 product_item_box">
                                                    <div class="productBox">
                                                        <div class="inner_productBox">
                                                            <a href="javascript:void(0);">
                                                                <div class="imgBox">
                                                                    <img src="./images/account-images/pro-2.png" class="" alt="">
                                                                </div>
                                                                <div class="products_inner_textbox">
                                                                    <h4><span>Rugby Top-MB-2130</span></h4>
                                                                    <div class="row">
                                                                        <div class="col s12 m6">
                                                                            <div class="product_moq">
                                                                                MOQ: <br> <span>1000</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col s12 m6">
                                                                            <div class="pro_leadtime">
                                                                                Lead Time <br> <span>30-45</span> days
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s6 m4 l3 product_item_box">
                                                    <div class="productBox">
                                                        <div class="inner_productBox">
                                                            <a href="javascript:void(0);">
                                                                <div class="imgBox">
                                                                    <img src="./images/account-images/pro-1.png" class="" alt="">
                                                                </div>
                                                                <div class="products_inner_textbox">
                                                                    <h4><span>Rugby Top-MB-2130</span></h4>
                                                                    <div class="row">
                                                                        <div class="col s12 m6">
                                                                            <div class="product_moq">
                                                                                MOQ: <br> <span>1000</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col s12 m6">
                                                                            <div class="pro_leadtime">
                                                                                Lead Time <br> <span>30-45</span> days
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s6 m4 l3 product_item_box">
                                                    <div class="productBox">
                                                        <div class="inner_productBox">
                                                            <a href="javascript:void(0);">
                                                                <div class="imgBox">
                                                                    <img src="./images/account-images/pro-2.png" class="" alt="">
                                                                </div>
                                                                <div class="products_inner_textbox">
                                                                    <h4><span>Rugby Top-MB-2130</span></h4>
                                                                    <div class="row">
                                                                        <div class="col s12 m6">
                                                                            <div class="product_moq">
                                                                                MOQ: <br> <span>1000</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col s12 m6">
                                                                            <div class="pro_leadtime">
                                                                                Lead Time <br> <span>30-45</span> days
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m12 l3 new_profile_account_rightsidebar_desktop">
                                        <div class="new_profile_account_filterbar">
                                            <h4>Filtered by</h4>
                                            <div class="new_profile_account_filterbox">
                                                <ul>
                                                    <li><a href="javascript:void(0);">Designs</a></li>
                                                    <li class="active"><a href="javascript:void(0);">Production Samples</a></li>
                                                    <li><a href="javascript:void(0);">Textile</a></li>
                                                    <li><a href="javascript:void(0);">Yarn</a></li>
                                                    <li><a href="javascript:void(0);">Ready Stock</a></li>
                                                    <li><a href="javascript:void(0);">Trims and Accessories</a></li>
                                                </ul>
                                                <ul>
                                                    <li><a href="javascript:void(0);">Knit</a></li>
                                                    <li><a href="javascript:void(0);">Woven</a></li>
                                                    <li><a href="javascript:void(0);">Denim</a></li>
                                                    <li><a href="javascript:void(0);">Woven</a></li>
                                                    <li><a href="javascript:void(0);">Denim</a></li>
                                                </ul>
                                                <ul>
                                                    <li><a href="javascript:void(0);">Kids</a></li>
                                                    <li><a href="javascript:void(0);">Male</a></li>
                                                    <li><a href="javascript:void(0);">Female</a></li>
                                                    <li><a href="javascript:void(0);">Yarn</a></li>
                                                </ul>
                                                <ul>
                                                    <li><a href="javascript:void(0);">T shirts</a></li>
                                                    <li><a href="javascript:void(0);">T shirts</a></li>
                                                </ul>
                                            </div>

                                            <div class="account_filter_progress_wrap">
                                                <h4>Lead Time</h4>
                                                <div class="filter_progress_box">
                                                    <input type="range" min="30" max="100" value="30" class="filter_progress" id="myRange"><span class="thumb"><span class="value"></span></span>
                                                    <span id="filterProgressValue">30</span>
                                                </div>

                                                <h4>MOQ</h4>
                                                <div class="filter_progress_box_moq">
                                                    <input type="range" min="100" max="1000" value="100" class="filter_progress_moq" id="myRangeMoq"><span class="thumb"><span class="value"></span></span>
                                                    <span id="filterProgressValueMoq">100</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
