<div id="worker-walfare-modal" class="modal profile_form_modal">
<div class="modal-content">
	<div id="worker-walfare-modal-errors">
	</div>
	<form  method="post" action="#" id="worker-walfare-form">
		<legend>Create Worker welfare and CSR</legend>
		@csrf
		<input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
		@if($business_profile->walfare)
		<div class="row">
            <div class="col s12 m6 l6">
                @foreach(json_decode($business_profile->walfare->walfare_and_csr) as $walfareAndCsr)
                    @if($walfareAndCsr->name == 'healthcare_facility')
                    <div class="welfare_box row">
                        <span class="title col s8 m6 l6">Healthcare Facility</span>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="healthcare_facility"  id="health-facility-form-checked"  type="radio" value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }}>
                        <span>Yes</span>
                        </label>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="healthcare_facility" id="health-facility-form-unchecked"    value="0" type="radio" {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
                        <span>No</span>
                        </label>
            
                    </div>
                    @endif
                    @if($walfareAndCsr->name == 'doctor')
                    <div class="welfare_box row">
                        <span class="title col s8 m6 l6">On sight Doctor</span>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="doctor"  id="doctor-form-checked"  type="radio" value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }}>
                        <span>Yes</span>
                        </label>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="doctor" id="doctor-form-unchecked"  value="0" type="radio" {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
                        <span>No</span>
                        </label>
                    </div>
                    @endif
                    @if($walfareAndCsr->name == 'day_care')
                    <div class="welfare_box row">
                        <span class="title col s8 m6 l6 ">On sight Day Care</span>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="day_care" id="day-care-from-checked" type="radio" value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }} >
                        <span>Yes</span>
                        </label>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="day_care" id="day-care-from-unchecked" value="0" type="radio" {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }} >
                        <span>No</span>
                        </label>
                    </div>
                    @endif
                @endforeach
            </div>

            <div class="col s12 m6 l6">
                @foreach(json_decode($business_profile->walfare->walfare_and_csr) as $walfareAndCsr)
                @if($walfareAndCsr->name == 'playground')
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Playground</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="playground" id="playground-form-checked"   type="radio" value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }}>
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="playground"  id="playground-form-unchecked"  value="0" type="radio" {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
                    <span>No</span>
                    </label>
                </div>
                @endif
                @if($walfareAndCsr->name == 'maternity_leave')
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Maternity Leave</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="maternity_leave" id="maternity-leave-form-checked" type="radio" value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }} > 
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="maternity_leave" id="maternity-leave-form-unchecked" type="radio" value="0" {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
                    <span>No</span>
                    </label>
                </div>
                @endif
                @if($walfareAndCsr->name == 'social_work')
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Social work</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="social_work"  id="social-work-form-checked" type="radio" value="1" {{  ($walfareAndCsr->checked == "1" ? ' checked' : '') }} >
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="social_work"  id="social-work-form-unchecked" type="radio" value="0" {{  ($walfareAndCsr->checked == "0" ? ' checked' : '') }}>
                    <span>No</span>
                    </label>
                </div>
                @endif
               @endforeach
            </div>
						
        </div>
        @else
		<div class="row">
            <div class="col s12 m6 l6">
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Healthcare Facility</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="healthcare_facility"  id="health-facility-form-checked"  type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="healthcare_facility" id="health-facility-form-unchecked"    value="0" type="radio">
                    <span>No</span>
                    </label>
                </div>
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">On sight Doctor</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="doctor"  id="doctor-form-checked"  type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="doctor" id="doctor-form-unchecked"  value="0" type="radio">
                    <span>No</span>
                    </label>
                </div>
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6 ">On sight Day Care</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="day_care" id="day-care-from-checked" type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="day_care" id="day-care-from-unchecked" value="0" type="radio">
                    <span>No</span>
                    </label>
                </div>
            </div>
            <div class="col s12 m6 l6">
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Playground</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="playground" id="playground-form-checked"   type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="playground"  id="playground-form-unchecked"  value="0" type="radio">
                    <span>No</span>
                    </label>
                </div>
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Maternity Leave</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="maternity_leave" id="maternity-leave-form-checked" type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="maternity_leave" id="maternity-leave-form-unchecked" type="radio" value="0">
                    <span>No</span>
                    </label>
                </div>
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Social work</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="social_work"  id="social-work-form-checked" type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="social_work"  id="social-work-form-unchecked" type="radio" value="0" >
                    <span>No</span>
                    </label>
                </div>
            </div>
        </div>
        @endif

        <!-- <div class="center-align submit_btn_wrap">
            <button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit
            </button>
		</div> -->

        <div class="submit_btn_wrap" style="padding-top: 30px;">
			<div class="row">
				<div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
				<div class="col s12 m6 l6 right-align">
					<button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit</button>
				</div>
			</div>
		</div>
	</form>


	<!-- <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons">close</i></a>
	</div> -->


</div>
</div>