@extends('layouts.app_createbusinessprofile')

@section('content')
@include('sweet::alert')


<div class="sign-wrap business_sign_wrap">
	<div class="row">
		<div class="col s12 m12 l4 leftbar">
			<div class="logo-wrap">
				<div class="logo-inner">
                    <img title="logo" src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/merchantbay_logoX200.png')}}">
					<img class="logo_white_img" title="logo" src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/logo_white.png')}}">
					<h4>Connect all the stakeholders in one place</h4>
				</div>
			</div>
		</div>
		<div class="col s12 m12 l8 rightbar">
			<div class="signRight-innter business_stepper_wrap">
				<div class="sign-from-wrap">
                    <div class="back_to" style="margin-bottom: 30px;">
                        <a href="{{ url()->previous() }}"> <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/back-arrow.png')}}" alt="" ></a>
                    </div>
                    <h3>Creating Business Profile...</h3>
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li class="tab col s4 m4 l4 business_details_tab">
                                    <a class="active" href="#business_details_info">
                                        <span class="step_count">1</span> Business Details
                                    </a>
                                </li>
                                <li class="tab col s4 m4 l4 disabled representive_details_tab">
                                    <a href="#representative_details_info">
                                        <span class="step_count">2</span> Representive Details
                                    </a>
                                </li>
                                <li class="tab col s4 m4 l4 disabled business_profile_details_tab">
                                    <a href="#business_profile_info" class="last-step">
                                        <span class="step_count">3</span> Business Profile
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col s12 edit_errors_wrapper" style="display: none;">
                            <div class="col s12" id="edit_errors"></div>
                        </div>
                        <form id="business_profile_form" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <div id="business_details_info" class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <div class="col s12 m4">
                                            <label for="business_name">Organization Name</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <input id="business_name" type="text" class="validate" placeholder="Your Company/Factory/Studio name" name="business_name" value="{{old('business_name')}}">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="col s12 m4">
                                            <label for="location">Location</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <input id="location" type="text" class="validate" placeholder="Address of your Company/Factory/Studio" name="location" value="{{old('location')}}">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="col s12 m4">
                                            <label for="business_type">Business Type</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <select id="business_type" class="select2 browser-default select-business-type" name="business_type" onchange="changecategory(this,'business');">
                                                <option value="" disabled selected>Choose your business type</option>
                                                @foreach ($business_mapping_tree as $parent )
                                                    <option value="{{$parent->name}}" data-id="{{$parent->id}}" {{old('business_type') == $parent->name ? 'selected' : ''}}>{{ucwords($parent->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 number_of_outlets" style="display: none">
                                        <div class="col s12 m4">
                                            <label>&nbsp;</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <div class="row">
                                                <div class="col s12 m5">
                                                    <label for="number_of_outlets">Number Of Outlets</label>
                                                </div>
                                                <div class="col s12 m7">
                                                    <input id="number_of_outlets" type="text" class="validate zero-not-allowed" name="number_of_outlets" value="{{old('number_of_outlets')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 number_of_factories" style=" display:none">
                                        <div class="col s12 m4">
                                            <label>&nbsp;</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <div class="row">
                                                <div class="col s12 m5">
                                                    <label for="number_of_factories">Number Of Factories</label>
                                                </div>
                                                <div class="col s12 m7">
                                                    <input id="number_of_factories" type="text" class="validate zero-not-allowed" name="number_of_factories"  value="{{old('number_of_factories')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="col s12 m4">
                                            <label for="trade_license">Trade License</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <input id="trade_license" type="text" class="validate" placeholder="Your valid Trade License number" value="{{old('trade_license')}}" name="trade_license">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="col s12 m4">
                                            <label for="industry_type">Industry Type</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <select id="industry_type" class="select2 browser-default select-industry-type"  name="industry_type" onchange="changecategory(this,'industry');">
                                                <option value="" disabled selected>Choose your industry type</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 business-category-div" >
                                        <div class="col s12 m4">
                                            <label>&nbsp;</label>
                                        </div>
                                        <div class="col s12 m8">
                                            <div class="row">
                                                <div class="col s12 m5">
                                                    <label for="factory_type">Factory Type</label>
                                                </div>
                                                <div class="col s12 m7">
                                                    <select  class="select2 browser-default business-category"  name="factory_type" id="factory_type"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="next next_to_representative_details_info btn waves-effect waves-light green" onclick='$(".representive_details_tab").removeClass("disabled");$(".business_details_tab").addClass("disabled");$(".tabs").tabs( "select", "representative_details_info" )'>Next</a>
                            </div>
                            <div id="representative_details_info" class="col s12">
                                <div class="representative_box">
                                    <label class="title" for="business_name">Do you want to represent this business yourself?<span class="tooltipped" data-position="top"  data-tooltip="A representative will receive notifications about orders,<br />queries and other activities from Merchant Bay.<br />You can only represent one business."><i class="material-icons dp48">info</i></span></label>
                                    <span class="radio_box_wrap">
                                        <label class="radio_box">
                                            <input name="has_representative" type="radio" value="1"  />
                                            <span>Yes</span>
                                        </label>
                                        <label class="radio_box">
                                            <input name="has_representative" type="radio" value="0" checked/>
                                            <span>No</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="representive_info">
                                    <div class="input-field col s12">
                                        <div class="row">
                                            <div class="col s12 m4">
                                                <label for="representive_name">Representive Name</label>
                                            </div>
                                            <div class="col s12 m8">
                                                <input id="representive_name" type="text" class="validate" placeholder="Mr. John Deo" value="{{old('representive_name')}}" name="representive_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="row">
                                            <div class="col s12 m4">
                                                <label for="email">Email Address</label>
                                            </div>
                                            <div class="col s12 m8">
                                                <input id="email" type="text" class="validate" placeholder="name@company.com" value="{{old('email')}}" name="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="row">
                                            <div class="col s12 m4">
                                                <label for="phone">Contact Number</label>
                                            </div>
                                            <div class="col s12 m8">
                                                <input id="phone" type="text" class="validate" placeholder="Contact Number" value="{{old('phone')}}" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <div class="row">
                                            <div class="col s12 m4">
                                                <label for="nid_passport">NID/Passport</label>
                                            </div>
                                            <div class="col s12 m8">
                                                <input id="nid_passport" type="text" class="validate" value="{{old('nid_passport')}}" name="nid_passport">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-actions">
                                    <a href="javascript:void(0)" class="previous previous_to_business_details_info btn waves-effect waves-light green" onclick='$(".edit_errors_wrapper").hide();$(".business_details_tab").removeClass("disabled");$(".representive_details_tab").addClass("disabled");$(".tabs").tabs( "select", "business_details_info" )'>Back</a>
                                    <a href="javascript:void(0)" class="next next_to_business_profile_info btn waves-effect waves-light green" onclick='$(".business_profile_details_tab").removeClass("disabled");$(".representive_details_tab").addClass("disabled");$(".tabs").tabs( "select", "business_profile_info" )'>Next</a>
                                </div>

                            </div>
                            <div id="business_profile_info" class="col s12">
                                <div id="review-profile-data" class="business_steps_content">
                                    <div id="information_message" class="review-profile-data-info" style="padding-bottom: 25px;"></div>
                                    <div id="review_name" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_location" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_business_type" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_number_of_factories" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_number_of_outlets" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_trade_license" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_industry_type" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_factory_type" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_representative_name" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_representatives_email" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_representatives_contact" class="review-profile-data-info" style="padding-bottom: 10px;"></div>
                                    <div id="review_representative_nidPassport" class="review-profile-data-info"></div>
                                </div>

                                <div class="step-actions">
                                    <a href="javascript:void(0)" class="previous previous_to_representative_details_info btn waves-effect waves-light green" onclick='$(".edit_errors_wrapper").hide();$(".business_profile_details_tab").addClass("disabled");$(".representive_details_tab").removeClass("disabled");$(".tabs").tabs( "select", "representative_details_info" )'>Back</a>
                                    <button type="submit" class="btn waves-effect waves-light green">Submit <i class="material-icons right">send</i></button>
                                </div>
                            </div>
                        </form>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@include('create_business_profile._scripts')
@section('css')
<style>
    .footer_wrap {
        display: none;
    }
</style>
@endsection

@push('js')
    <script>
        $(document).on('keyup', '.zero-not-allowed', function(){
            var value= parseInt($(this).val());
            var regex = /[0-9]|\./;
            if( !regex.test(value) ) {
                swal('alert!', 'Text not allowed. You have to enter a valid number.', 'warning');
            }
            if(value == 0 || value < 0){
                swal('alert!', 'Zero or negative not allowed', 'warning');
                //$(this).val(1);
            }
        });
    </script>
@endpush
