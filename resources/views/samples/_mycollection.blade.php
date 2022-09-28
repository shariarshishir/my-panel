<div class="row">
    @foreach ($samples as $item)
    @php
        $productImg = json_decode($item['product_images']);
        $productTags = json_decode($item->product_tags);
    @endphp
    <div class="col s12 m6 l3">
        <div class="buyer_simple_imgbox">
            <div class="imgBox">
                <a class="modal-trigger" href="#buyerSampleEdit-{{$item->id}}">
                <img src="{{Storage::disk('s3')->url('public/sample_images/'.auth()->user()->id.'/'.$productImg[0])}}" alt="" />
                </a>
            </div>

            <div id="buyerSampleEdit-{{$item->id}}" class="modal modal_lg buyer_layout_modal">
                <a href="javascript:void(0);" class="modal-action modal-close"><i class="material-icons">close</i></a>
                <div class="modal-content">
                    <form action="" method="post" enctype="multipart/form-data" class="sample_edit_data_form">
                        <input type="hidden" name="product_id" value="{{$item->id}}" />
                        <div class="buyer_modal_top">
                            <h4>Edit Sample</h4>
                        </div>
                        <div class="buyer_sample_upload_wrap">
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="fileBox col s12 input-field">
                                        <label>Images</label>
                                        <div class="sample-upload-wrapper">
                                            <div class="sample-images-edit"></div>
                                            <div class="sample_image_browse center-align">
                                                <div class="or"><span>OR</span></div>
                                                <a href="javascript:void(0);" class="btn_green browse_certificate_trigger">Browse files</a>
                                                <div class="small-info" style="color: #afafaf; margin-top:10px"><i>Upload your Sample Images</i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <label>Supplier's Name <span>*</span></label>
                                        <input type="text" name="supplier_name" class="" value="{{$item->supplier_name}}" />
                                    </div>
                                    <div class="input-field">
                                        <label>Supplier's Email Address <span>*</span></label>
                                        <input type="text" name="supplier_email" class="" value="{{$item->supplier_email}}" />
                                    </div>
                                    <div class="input-field">
                                        <label>Select Product Tags <span>*</span></label>
                                        <select class="select2 browser-default" name="product_tags[]" multiple="multiple">
                                            @foreach($product_tags as $product_tag)
                                                <option value="{{$product_tag->name}}" @php echo (in_array($product_tag->name, $productTags)) ? "selected":""; @endphp>{{$product_tag->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field">
                                        <label>Title <span>*</span></label>
                                        <input type="text" name="product_title" class="" value="{{$item->product_title}}" />
                                    </div>
                                    <div class="input-field">
                                        <label>Short Description <span>*</span></label>
                                        <input type="text" name="details" class="" value="{{$item->details}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row buyer_modal_footer" style="padding-top: 30px;">
                            <div class="col s6">
                                <button type="button" class="modal-close btn_white">Cancle</button>
                            </div>
                            <div class="col s6 right-align">
                                <button type="submit" class="btn_green" style="margin: 0;">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>
