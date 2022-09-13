<div id="association-membership-upload-form-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <div id="association-membership-upload-errors">

        </div>

        <form  method="post" action="#" id="association-membership-upload-form"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
            <div class="row">
                <div class="form-group  association-membership-details-block">
                    <legend> 
                        <div class="row">
                            <span class="tooltipped_title">Association memberships</span> <a class="tooltipped" data-position="top" data-tooltip="Mention the association memberships you have.<br />This increases the credibility of your facility. <br />Mention the association name in the Name field,<br /> Upload the logo of the association in the logo<br /> field and mention the membership number in the<br /> membership number filed."><i class="material-icons">info</i></a>
                        </div>
                    </legend>
                    <div class="association-membership-details-block">
                        <div class="no_more_tables">
                            <table class="association-membership-details-table-block">
                                <thead class="cf">
                                    <tr>
                                        <th>Name</th>
                                        <th>Membership number</th>
                                        <th>Image</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-title="Name"><input class="input-field" name="title[]" id="association-membership-title" type="text"  ></td>
                                        <td data-title="Membership number">
                                            <textarea class="input-field" name="short_description[]" id="association-membership-short-description" rows="4" cols="50"></textarea>
                                        </td>
                                        <td data-title="Image"><input class="input-field file_upload" name="image[]" id="association-membership-image" type="file"></td>
                                        <td><a href="javascript:void(0);" class="btn_delete" onclick="removeAssociationMembershipDetails(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="add_more_box">
                            <a href="javascript:void(0);" class="add-more-block" onclick="addAssociationMembershipDetails()"><i class="material-icons dp48">add</i> Add More</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <!-- <div class="center-align submit_btn_wrap">
                <button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
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