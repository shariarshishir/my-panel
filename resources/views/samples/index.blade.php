@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | Samples | Clothing Manufacturers from Bangladesh')
@section('title', 'Samples | Clothing Manufacturers from Bangladesh')
@section('description', "Merchant Bay's pool of verified suppliers to manufacture your designs or source fashion, fabric, accessories, and raw materials from.")
@section('image', Storage::disk('s3')->url('public/frontendimages/Suppliers.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Samples | Clothing Manufacturers from Bangladesh')
@section('ogdescription', "Merchant Bay's pool of verified designers to manufacture your designs or source fashion, fabric, accessories, and raw materials from.")
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/Suppliers.png'))

@section('robots', 'index, nofollow')

@section('content')
@include('sweet::alert')

<div class="buyer_layout_contant_wrapper">
    <h4>Samples</h4>
    <div class="row">
        <div class="col s12">
            <div class="buyer_simple_img_upload_box">
                <a class="add_new modal-trigger" href="#buyerSampleUpload">
                    <i class="material-icons">file_upload</i>
                    <h6>Upload Images/PDf?mp4 </h6>
                    <div class="or"><span>OR</span></div>
                    <p>Drag and drop from below</p>
                </a>
                <!-- Modal window start -->
                <div id="buyerSampleUpload" class="modal modal_lg buyer_layout_modal">
                    <a href="javascript:void(0);" class="modal-action modal-close"><i class="material-icons">close</i></a>
                    <div class="modal-content">
                        <form action="" method="post" enctype="multipart/form-data" class="sample_upload_data_form">
                            <div class="buyer_modal_top">
                                <h4>Upload New Design</h4>
                            </div>
                            <div class="buyer_sample_upload_wrap">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <div class="fileBox col s12 input-field">
                                            <label>Images</label>
                                            <div class="sample-upload-wrapper">
                                                <div class="sample-images"></div>
                                                <div class="sample_image_browse center-align" style="display: none;">
                                                    <div class="or"><span>OR</span></div>
                                                    <a href="javascript:void(0);" class="btn_green browse_certificate_trigger">Browse files</a>
                                                    <div class="small-info" style="color: #afafaf; margin-top:10px"><i>Upload your Sample Images</i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6">
                                        <div class="input-field" style="display: none;">
                                            <label>Supplier's Name <span>*</span></label>
                                            <input type="text" name="supplier_name" class="" value="" />
                                        </div>
                                        <div class="input-field" style="display: none;">
                                            <label>Supplier's Email Address <span>*</span></label>
                                            <input type="text" name="supplier_email" class="" value="" />
                                        </div>
                                        <div class="input-field">
                                            <label>Select Product Tags <span>*</span></label>
                                            <select class="select2 browser-default" name="product_tags[]" multiple="multiple">
                                                @foreach($product_tags as $product_tag)
                                                    <option value="{{$product_tag->name}}">{{$product_tag->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-field">
                                            <label>Title <span>*</span></label>
                                            <input type="text" name="product_title" class="" value="" />
                                        </div>
                                        <div class="input-field">
                                            <label>Short Description <span>*</span></label>
                                            <textarea name="details"></textarea>
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
                <!-- Modal window end -->
            </div>
        </div>
    </div>
    <div class="buyer_product_design_tabNab">
        <div class="row">
            <div class="col s12">
                <ul class="sample-sub-menu">
                    <li class="col m3"><a href="{{route('samples')}}" class="{{ Route::is('samples') ? 'active' : ''}}">From My Collection</a></li>
                    <li class="col m3" style="display: none;"><a href="{{route('sample.mb.collection')}}" class="{{ Route::is('sample.mb.collection') ? 'active' : ''}}">From MB Collection</a></li>
                </ul>
            </div>
            <div id="buyerMyCollection" class="col s12">
                @if($page_param == 'mycollection')
                    @include('samples._mycollection')
                @else
                    @include('samples._mbcollection')
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@include('samples._scripts')
