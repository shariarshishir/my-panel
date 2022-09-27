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
                    <div class="col s12 m12 xl9" style="margin: 0 auto; float: none;">

                        <div class="order_management_inner_wrap">
                            <div class="row">
                                <div class="col s12 m5 l4">
                                    <div class="order_management_inner_left">
                                        <div class="order_manag_icon">
                                            <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/icon-m-factory.png')}}" alt="" />

                                        </div>
                                        <h3>M Factory</h3>
                                        <ul>
                                            <li>Unlimited Orders</li>
                                            <li>Unlimited Messages, Notes, Tasks & RFQs.</li>
                                            <li>Actionable Rich Reporting</li>
                                            <li>Production and Quality Tracking</li>
                                        </ul>
                                        <div class="center-align">
                                            <a href="https://app.merchantbay.com/" class="btn_green btn_lounch" >Lounch</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m7 l8">
                                    <div class="order_management_inner_right">
                                        <div class="order_manage_right_infobox_wrap">
                                            <div class="row">
                                                <div class="col s12 m3">
                                                    <div class="order_icon_image">
                                                        <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/icon-store-management.png')}}" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col s12 m9">
                                                    <div class="order_icon_infobox">
                                                        <h4>Store Management</h4>
                                                        <p class="comingSoon">Coming Soon...</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order_manage_right_infobox_wrap">
                                            <div class="row">
                                                <div class="col s12 m3">
                                                    <div class="order_icon_image">
                                                        <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/icon-planning-board.png')}}" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col s12 m9">
                                                    <div class="order_icon_infobox">
                                                        <h4>Planning Board</h4>
                                                        <p class="comingSoon">Coming Soon...</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order_manage_right_infobox_wrap">
                                            <div class="row">
                                                <div class="col s12 m3">
                                                    <div class="order_icon_image">
                                                        <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/icon-qc-module.png')}}" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col s12 m9">
                                                    <div class="order_icon_infobox">
                                                        <h4>QC Module</h4>
                                                        <p class="comingSoon">Coming Soon...</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- order_management_inner_wrap end-->


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
