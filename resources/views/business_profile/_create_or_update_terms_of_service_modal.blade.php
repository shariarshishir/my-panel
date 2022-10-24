<div id="terms-of-service-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <legend>Edit Terms of service</legend>
        <div class="row">
            <div id="terms-of-service-create-or-update-form-errors"></div>
            <form class="col s12" method="post" action="#" id="terms-of-service-create-or-update-form">
                @csrf
                <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
                <div class="row ">
                    <div class="col s12 input-field">
                        <label for="terms-of-service">Terms of services</label>
                        <td>
                            <textarea class="terms-of-service" name="terms_of_service" value="{{$business_profile->companyOverview->terms_of_service}}" type="text" id="terms-of-service" rows="20" cols="50">{{$business_profile->companyOverview->terms_of_service  ?? ''}}</textarea>
                        </td>
                    </div>
                </div>
                
                <div class="submit_btn_wrap">
                    <div class="row">
                        <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                        <div class="col s12 m6 l6 right-align">
                            <button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    
</div>