<div id="main-buyers-upload-form-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <div id="main-buyers-upload-errors">

        </div>

        <form  method="post" action="#" id="main-buyer-upload-form"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
            <div class="row">
                <div class="form-group  main-buyers-details-block">
                    <legend> 
                        <div class="row">
                            <span class="tooltipped_title">Main buyers Details</span> <a class="tooltipped" data-position="top" data-tooltip="Mentioning your main buyers increases your credibility.<br />Please mention at least 5 buyers that you already served.<br />Give the buyer Name, Logo and any description you want to add."><i class="material-icons">info</i></a>
                        </div>
                    </legend>
                    <div class="main-buyers-details-block">
                        <div class="no_more_tables">
                            <table class="main-buyers-details-table-block">
                                <thead class="cf">
                                    <tr>
                                        <th>Name</th>
                                        <th>Short description</th>
                                        <th>Image</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-title="Name"><input class="input-field" name="title[]" id="main-buyer-title" type="text"  ></td>
                                        <td data-title="Short description">
                                            <textarea class="input-field" name="short_description[]" id="main-buyer-short-description" rows="4" cols="50"></textarea>
                                        </td>
                                        <td data-title="Image"><input class="input-field file_upload" name="image[]" id="main-buyer-image" type="file"></td>
                                        <td><a href="javascript:void(0);" class="btn_delete" onclick="removeMainBuyersDetails(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span> </a></td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="add_more_box">
                            <a href="javascript:void(0);" class="add-more-block" onclick="addMainBuyersDetails()"><i class="material-icons dp48">add</i> Add More</a>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="submit_btn_wrap">
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