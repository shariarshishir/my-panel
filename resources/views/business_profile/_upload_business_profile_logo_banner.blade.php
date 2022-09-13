<div id="business_profile_logo_banner" class="modal">
    <div class="modal-content">
        <div id="business-profile-logo-banner-upload-errors"></div>
        <form  method="post" action="#" id="business-profile-logo-banner-upload-form"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
            <div class="row">
                <div class="form-group">
                    <legend>Logo</legend>
                    <input class="input-field file_upload" name="logo" type="file">
                </div>
                <div class="form-group">
                    <legend>Banner - <span style="font-size: 14px; font-weight: 200;">(1920px X 300px)</span></legend>
                    <input class="input-field file_upload" name="banner" type="file">
                </div>
            </div>

            <div class="submit_btn_wrap">
                <div class="row">
                    <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                    <div class="col s12 m6 l6 right-align">
                        <button class="btn waves-effect waves-light btn_green" type="submit" >Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
