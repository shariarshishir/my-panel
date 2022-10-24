<div id="factory-tour-add-modal-block" class="modal profile_form_modal">
<div class="modal-content">
        <div id="factory-tour-form-errors">

        </div>

        <form  method="post" action="#" id="factory-tour-form"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">

            <div class="row">
                <div class="form-group input-field factory-tour-photo">
                    <legend> 
                        <div class="row">
                            <span class="tooltipped_title">Virtual Tour Url</span> <span class="tooltipped" data-position="top" data-tooltip="You need to upload your video to Youtube and provide an embedded link.<br> You can find the embedded link for the video in the share button below the Youtube video."><i class="material-icons dp48">info</i></span>
                        </div>
                    </legend>
                    <input type="text" name="virtual_tour" value=""  >
                </div>
            </div>


            <div class="row">
                <div class="form-group factory-tour-photo factory_images_box">
                    <legend>Factory Images</legend>

                    <div class="factory_file_uploader">
                        <label for="product-upload">Media</label>
                        <div class="factory-image-block row ">
                            <div class="upload_img_box_wrap col s6 m3 l2">
                                <a href="javascript:void(0);" class="btn_close" onclick="removeFactoryImage(this)"><i class="material-icons dp48">close</i></a>
                                <div class="upload_imgage_box">
                                    <img id="preview-image-before-upload" class="factory-sm-image-preview" src="https://via.placeholder.com/80" alt="preview image" style="max-height: 80px;min-height:80px">
                                </div>
                                <div class="form-group">
                                    <input type="file" name="factory_images[]" placeholder="Choose image" class="factory-sm-image-trigger" id="factory-image">
                                </div>
                            </div>
                        </div>
                        <div class="factory_add_more row">
                            <a href="javascript:void(0);" class="add-more-factory-image-block" onclick="addFactoryImageBlock()"><i class="material-icons dp48">add</i> Add More</a>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col 12 factory-image-block">
                            <div class="col l2">
                                <label for="product-upload">Media</label>
                            </div>
                            <br>
                            <div class="col-md-12 mb-2">
                                <img id="preview-image-before-upload" src="https://via.placeholder.com/80"
                                    alt="preview image" style="max-height: 80px;min-height:80px">
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="factory_images[]" placeholder="Choose image"  id="factory-image">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <a href="javascript:void(0);" class="add-more-factory-image-block" onclick="addFactoryImageBlock()"><i class="material-icons dp48">add</i> Add More</a>
                    </div>  -->

                </div>
            </div>

            <div class="row">
                <div class="form-group factory-tour-photo factory_large_images_box">
                    <legend>Factory 360 Degree Images</legend>

                    <div class="factory_file_uploader">
                        <label for="product-upload">Media</label>
                        <div class="factory-large-image-block row">
                            <div class="upload_img_box_wrap col s6 m3 l2">
                            <a href="javascript:void(0);" class="btn_close" onclick="removeFactoryLargeImage(this)"><i class="material-icons dp48">close</i></a>
                                <div class="upload_imgage_box">
                                    <img id="preview-image-before-upload" class="factory-lg-image-preview" src="https://via.placeholder.com/80" alt="preview image" style="max-height: 80px;min-height:80px">
                                </div>
                                <div class="form-group">
                                    <input type="file" name="factory_large_images[]" placeholder="Choose image" class="factory-lg-image-trigger" id="factory-large-image">
                                </div>
                            </div>
                        </div>
                        <div class="factory_add_more row">
                            <a href="javascript:void(0);" class="add-more-factory-large-image-block" onclick="addFactoryLargeImageBlock()"><i class="material-icons dp48">add</i> Add More</a>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col 12 factory-large-image-block">
                            <div class="col l2">
                                <label for="product-upload">Media</label>
                            </div>
                            <br>
                            <div class="col-md-12 mb-2">
                                <img id="preview-image-before-upload" src="https://via.placeholder.com/80"
                                    alt="preview image" style="max-height: 80px;min-height:80px">
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="factory_large_images[]" placeholder="Choose image"  id="factory-large-image">
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <a href="javascript:void(0);" class="add-more-factory-large-image-block" onclick="addFactoryLargeImageBlock()"><i class="material-icons dp48">add</i> Add More</a>
                    </div> -->



                </div>
            </div>



                <!-- <div class="row">
                    <div class="col s12 m6 l6 right-align">
                        <button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit</button>
                    </div>
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
    <!-- <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div> -->
</div>
