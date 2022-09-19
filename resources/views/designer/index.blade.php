@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | Designers | Clothing Manufacturers from Bangladesh')
@section('title', 'Designers | Clothing Manufacturers from Bangladesh')
@section('description', "Merchant Bay's pool of verified suppliers to manufacture your designs or source fashion, fabric, accessories, and raw materials from.")
@section('image', Storage::disk('s3')->url('public/frontendimages/Suppliers.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Designers | Clothing Manufacturers from Bangladesh')
@section('ogdescription', "Merchant Bay's pool of verified designers to manufacture your designs or source fashion, fabric, accessories, and raw materials from.")
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/Suppliers.png'))

@section('robots', 'index, nofollow')

@section('content')
@include('sweet::alert')

    <div class="buyer_designer_details_wrap">
        <div class="back_to">
            <a href="buyer-design.html"> <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/new_layout_images/back-arrow.png" alt="" width="10px"></a>
        </div>
        <div class="suppliers_container suppliers_filter_wrapper row">
            <div class="col s12 m4 l3">
                <div class="buyer_designer_details_left center-align">
                    <div class="designer_details_left_profile">
                        <div class="profile_img">
                            <img src="./images/profile-img.jpg" alt="" >
                        </div>
                        <div class="designer_info">
                            <div class="designer_top_box">
                                <h4>{{$user->name}}</h4>
                                <h6>Leeds, United Kingdom</h6>
                                <div class="buyer_price">
                                    <span>$25</span> /hr
                                </div>
                            </div>
                            <div class="designer_bottom_box">
                                <button class="btn_green">Hire Me</button>
                                <div class="talk_to_me btn_white">
                                    <a href="!#">Talk to Me</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buyer_designer_details_skill">
                        <h4>Skills</h4>
                        <ul>
                            <li>Fashion Design</li>
                            <li>Print & Layout Design</li>
                            <li>Technical Drawing</li>
                            <li>Techpack Building</li>
                            <li>Lookbook Design</li>
                        </ul>
                    </div>
                    <div class="buyer_designer_details_certification">
                        <h4>Certicications</h4>
                        <div class="row">
                            <div class="col s12 m6">
                                <img src="./images/certification.jpg" alt="" />
                            </div>
                            <div class="col s12 m6">
                                <img src="./images/certification.jpg" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m8 l9">
                <div class="buyer_designer_details_right">
                    <div class="buyer_designer_details_aboutMe">
                        <button class="edit_icon_box modal-trigger" href="#designerDetailsAboutMe">
                            <i class="material-icons">edit</i>
                        </button>
                        <div class="details_aboutme_topbar">
                            <div class="row">
                                <div class="col s6 m4 l2">
                                    <h6>Nationality</h6>
                                    <h5>British</h5>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h6>Experience</h6>
                                    <h5>12+ Years</h5>
                                </div>
                                <div class="col s6 m4 l3">
                                    <h6>Worked With</h6>
                                    <h5>250+ Brands</h5>
                                </div>
                                <div class="col s6 m4 l3">
                                    <h6>Completed</h6>
                                    <h5>436 Projects</h5>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h6>Response Time</h6>
                                    <h5>40 Minutes</h5>
                                </div>
                            </div>
                        </div>
                        <div class="buyer_about_me">
                            <h4>About Me</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <p>Experience: <b>Womenswear</b>, <b>menwear</b>, <b>babywear</b>, <b>swimwear</b></p>
                        </div>
                    </div>
                    <div class="buyer_designer_details_protfolio">
                        <button class="edit_icon_box modal-trigger" href="#designerDetailsPortfolio">
                            <i class="material-icons">edit</i>
                        </button>
                        <h4>Portfolio</h4>
                        <div class="row">
                            <div class="col s12 m6 l4">
                                <img src="./images/certification.jpg" alt="" />
                            </div>
                            <div class="col s12 m6 l4">
                                <img src="./images/certification.jpg" alt="" />
                            </div>
                            <div class="col s12 m6 l4">
                                <img src="./images/certification.jpg" alt="" />
                            </div>
                            <div class="col s12 m6 l4">
                                <img src="./images/certification.jpg" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Designer section start -->
    <div id="designerDetailsAboutMe" class="modal designer_details_edit_modal">
        <a href="javascript:void(0);" class="modal-action modal-close"><i class="material-icons">close</i></a>
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" action="{{route('single.designer.details.update')}}" class="designer_data_form">
                @csrf
                <div class="design_profile_edit_section">
                    <div class="row">
                        <div class="col s6 input-field">
                            <label>Name</label>
                            <input type="text" name="designer_name" class="" value=""  />
                        </div>
                        <div class="col s6 input-field">
                            <label>Address</label>
                            <input type="text" name="designer_location" class="" value=""  />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <label>Nationality</label>
                            <input type="text" name="designer_nationality" class="" value="" />
                        </div>
                        <div class="col s6 input-field">
                            <label>Experience</label>
                            <input type="text" name="designer_experience" class="" value="" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <label>Worked With</label>
                            <input type="text" name="designer_worked_with" class="" value="" />
                        </div>
                        <div class="col s6 input-field">
                            <label>Completed</label>
                            <input type="text" name="designer_completed_task" class="" value="" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label>Skills</label>
                            <select class="select2" name="designer_skills[]" multiple="multiple">
                                <option value="Fashion Design">Fashion Design</option>
                                <option value="Print & Layout Design">Print & Layout Design</option>
                                <option value="Technical Drawing">Technical Drawing</option>
                                <option value="Techpack Building">Techpack Building</option>
                                <option value="Lookbook Design">Lookbook Design</option>
                            </select>
                        </div>
                        <div class="col s6 input-field">
                            <label>Asking Price</label>
                            <input type="text" name="designer_asking_price" class="" value="" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="fileBox col s12 input-field">
                            <label>Certifications</label>
                            <input type="file" name="designer_certifications[]" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 input-field">
                            <label>About Me</label>
                            <textarea name="designer_about_me"></textarea>
                        </div>
                    </div>
                    <div class="right-align">
                        <button type="submit" class="btn_green" >Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="designerDetailsPortfolio" class="modal designer_details_edit_modal">
        <a href="javascript:void(0);" class="modal-action modal-close"><i class="material-icons">close</i></a>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="fileBox col s12 input-field">
                        <label>Portfolio</label>
                        <input type="file" />
                    </div>
                    <button class="add_more">Add More</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Designer section end -->


@endsection

@include('designer._scripts')
