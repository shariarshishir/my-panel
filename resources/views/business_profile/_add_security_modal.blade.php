<div id="security-modal" class="modal profile_form_modal">
<div class="modal-content">
	<div id="security-modal-errors">
	</div>
	<form  method="post" action="#" id="security-form">
        <legend>Create Security and others</legend>
		@csrf
		<input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
		@if($business_profile->security)
		<div class="row">
            <div class="col s12 m6 l6">
                @foreach(json_decode($business_profile->security->security_and_others) as $securityAndOther)
                    @if($securityAndOther->name == 'fire_exit')
                    <div class="welfare_box row">
                        <span class="title col s8 m6 l6">Fire Exit</span>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="fire_exit"  id="fire-exit-form-checked"  type="radio" value="1" {{  ($securityAndOther->checked == "1" ? ' checked' : '') }}>
                        <span>Yes</span>
                        </label>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="fire_exit" id="fire-exit-form-unchecked"    value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} >
                        <span>No</span>
                        </label>
            
                    </div>
                    @endif
                    @if($securityAndOther->name == 'fire_hydrant')
                    <div class="welfare_box row">
                        <span class="title col s8 m6 l6">On sight Fire Hydrant</span>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="fire_hydrant"  id="fire-hydrant-checked"  type="radio" value="1" {{  ($securityAndOther->checked == "1"? ' checked' : '') }}>
                        <span>Yes</span>
                        </label>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="fire_hydrant" id="fire-hydrant-unchecked"  value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} >
                        <span>No</span>
                        </label>
                    </div>
                    @endif
                    @if($securityAndOther->name == 'water_source')
                    <div class="welfare_box row">
                        <span class="title col s8 m6 l6 ">Onsight water source</span>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="water_source" id="water-source-from-checked" type="radio" value="1" {{  ($securityAndOther->checked == "1" ? ' checked' : '') }} >
                        <span>Yes</span>
                        </label>
                        <label class="radio_box col s2 m2 l2">
                        <input class="with-gap" name="water_source" id="water-source-from-unchecked" value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} >
                        <span>No</span>
                        </label>
                    </div>
                    @endif
                @endforeach
            </div>

            <div class="col s12 m6 l6">
            @foreach(json_decode($business_profile->security->security_and_others) as $securityAndOther)
                @if($securityAndOther->name == 'protocols')
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Other protocols</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="protocols" id="protocols-form-checked"   type="radio" value="1" {{  ($securityAndOther->checked == "1" ? ' checked' : '') }}>
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="protocols"  id="protocols-form-unchecked"  value="0" type="radio" {{  ($securityAndOther->checked == "0" ? ' checked' : '') }} >
                    <span>No</span>
                    </label>
                </div>
                @endif
               @endforeach
            </div>
						
        </div>
        @else
        <div class="row worker_welfare_box">
           
            <div class="col s12 m6 l6">
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Fire Exit</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="fire-exit" id="fire-exit-form-checked"   type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="fire-exit" id="fire-exit-form-unchecked"   type="radio" value="0">
                    <span>No</span>
                    </label>
                </div>
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">On sight Fire Hydrant</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="fire-hydrant" id="fire-hydrant-form-checked"   type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap"  name="fire-hydrant" id="fire-hydrant-form-unchecked"   type="radio" value="0" >
                    <span>No</span>
                    </label>
                </div>
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Onsight water source</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap"  name="water-source" id="water-source-form-checked"   type="radio" value="1"  checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="water-source" id="water-source-form-unchecked"   type="radio" value="0" >
                    <span>No</span>
                    </label>
                </div>
            </div>
            <div class="col s12 m6 l6">
                <div class="welfare_box row">
                    <span class="title col s8 m6 l6">Other protocols</span>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="protocols" id="protocols-form-checked"   type="radio" value="1" checked="">
                    <span>Yes</span>
                    </label>
                    <label class="radio_box col s2 m2 l2">
                    <input class="with-gap" name="protocols" id="protocols-form-unchecked"   type="radio" value="0" >
                    <span>No</span>
                    </label>
                </div>
            </div>
        </div>
        @endif

        <!-- <div class="center-align submit_btn_wrap">
            <button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit
                <i class="material-icons right">send</i>
            </button>
		</div>
		 -->

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