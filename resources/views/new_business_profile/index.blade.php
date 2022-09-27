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
                    <div class="col s12 m12 l9" style="margin: 0 auto; float: none;">
                        <div class="profile_insight_info">
                            <div class="row">
                                <div class="col s10">
                                    <h4>Profile Insights</h4>
                                </div>
                                <div class="col s2 right-align profile_insight_edit" >
                                    <img src="./images/account-images/Icon-edit.png" alt="" >
                                </div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">I am a</div>
                                <div class="col s12 m9 insight_info_right">{{ucwords($business_profile->profile_type)}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">Business type</div>
                                <div class="col s12 m9 insight_info_right">{{ucwords($business_profile->business_type)}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">Company Name</div>
                                <div class="col s12 m9 insight_info_right">{{ucwords($business_profile->business_name)}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">Email</div>
                                <div class="col s12 m9 insight_info_right">{{$business_profile->user->email}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">Full Name</div>
                                <div class="col s12 m9 insight_info_right">{{$business_profile->user->name}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">Designation</div>
                                <div class="col s12 m9 insight_info_right">{{$business_profile->user->designation}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">Phone</div>
                                <div class="col s12 m9 insight_info_right">{{$business_profile->user->phone}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">Company Website</div>
                                <div class="col s12 m9 insight_info_right">{{$business_profile->user->company_website}}</div>
                            </div>
                            <div class="row insight_info_box">
                                <div class="col s12 m3 insight_info_left">LinkedIn Profile</div>
                                <div class="col s12 m9 insight_info_right">{{$business_profile->user->linkedin_profile}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
