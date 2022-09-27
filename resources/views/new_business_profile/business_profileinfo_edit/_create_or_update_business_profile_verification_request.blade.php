<div id="send-verification-request-modal" class="modal">
    <div class="modal-content">
        <legend>Request for verification</legend>
        <form id="profile_verification_request" method="POST">
            <div class="row">
                <div class="input-field col s12">
                    <label for="verification_message">Message <i data-position="top" data-tooltip="Write your message below" class="material-icons tooltipped">info</i></label>
                    <textarea id="verification_message" name="verification_message" value=""></textarea>
                </div>
            </div>
            <input type="hidden" id="requested_business_profile_id" name="requested_business_profile_id" value="{{$business_profile->id}}" />
			<input type="hidden" id="requested_business_profile_name" name="requested_business_profile_name" value="{{$business_profile->business_name}}" />
            <button type="button" class="modal-action modal-close waves-effect waves-green btn btn_green">Close</button>            
            <button type="button" class="btn btn_green waves-effect waves-green verification_request_trigger">Submit <i class="material-icons right">send</i></button>
        </form>
    </div>
</div>