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

@php
    if($page_mode == 1)
    {
        $preloaded_image = $preloaded_image;
        $portfolio_preloader_image = $portfolio_preloader_image;
        // echo "<pre>"; print_r($preloaded_image); echo "</pre>";
        // echo "<pre>"; print_r($portfolio_preloader_image); echo "</pre>";
    }
    else
    {
        $preloaded_image = [];
        $portfolio_preloader_image = [];
    }
@endphp

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
                            <img src="https://s3.ap-southeast-1.amazonaws.com/development.service.products/public/frontendimages/no-image.png" alt="" >
                        </div>
                        <div class="designer_info">
                            <div class="designer_top_box">
                                <h4>{{$user->name}}</h4>
                                <h6>{{$designer->designer_location ?? "---"}}</h6>
                                <div class="buyer_price">
                                    <span>${{$designer->designer_asking_price ?? "---"}}</span> /hr
                                </div>
                            </div>
                            <div class="designer_bottom_box">
                                <button class="btn_green">Hire Me</button>
                                <div class="talk_to_me btn_white">
                                    <a href="javascript:void(0);">Talk to Me</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buyer_designer_details_skill">
                        <h4>Skills</h4>
                        @if(isset($designer->designer_skills))
                        <ul>
                            @foreach (json_decode($designer->designer_skills) as $skill)
                            <li>{{$skill}}</li>
                            @endforeach
                        </ul>
                        @else
                            No Data.
                        @endif
                    </div>
                    <div class="buyer_designer_details_certification">
                        <h4>Certicications</h4>
                        @if(isset($designer->designer_certifications))
                        <div class="row">
                            @foreach (json_decode($designer->designer_certifications) as $certificate)
                            <div class="col s12 m6">
                                <a href="{{Storage::disk('s3')->url('public/designers/'.auth()->user()->id.'/certificates/'.$certificate)}}" data-fancybox="certificate-gallery">
                                    <img src="{{Storage::disk('s3')->url('public/designers/'.auth()->user()->id.'/certificates/'.$certificate)}}" alt="" />
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @else
                            No Data.
                        @endif
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
                                    <h5>{{$designer->designer_nationality ?? "---"}}</h5>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h6>Experience</h6>
                                    <h5>{{$designer->designer_experience ?? "---"}} Years</h5>
                                </div>
                                <div class="col s6 m4 l3">
                                    <h6>Worked With</h6>
                                    <h5>{{$designer->designer_worked_with ?? "---"}} Brands</h5>
                                </div>
                                <div class="col s6 m4 l3">
                                    <h6>Completed</h6>
                                    <h5>{{$designer->designer_completed_task ?? "---"}} Projects</h5>
                                </div>
                                <div class="col s6 m4 l2">
                                    <h6>Response Time</h6>
                                    <h5>{{$designer->designer_response_time ?? "---"}}  Minutes</h5>
                                </div>
                            </div>
                        </div>
                        <div class="buyer_about_me">
                            <h4>About Me</h4>
                            {{$designer->designer_about_me ?? "---"}}
                        </div>
                    </div>
                    <div class="buyer_designer_details_protfolio">
                        <button class="edit_icon_box modal-trigger" href="#designerDetailsPortfolio">
                            <i class="material-icons">edit</i>
                        </button>
                        <h4>Portfolio</h4>
                        <div class="row">
                            @if(count($designerPortfolio) > 0)
                                @foreach ($designerPortfolio as $item)
                                    <div class="col s12 m6 l4">
                                        <a href="{{Storage::disk('s3')->url('public/designers/'.auth()->user()->id.'/portfolio/'.$item['image'])}}" data-fancybox="portfolio-gallery">
                                            <img src="{{Storage::disk('s3')->url('public/designers/'.auth()->user()->id.'/portfolio/'.$item['image'])}}" alt="" />
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                No Data.
                            @endif
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
            <form method="post" enctype="multipart/form-data" action="" class="designer_data_form">
                <input type="hidden" name="page_mode" value="{{$page_mode}}" />
                <input type="hidden" name="designer_id" value="{{$designer->user_id ?? 0}}" />
                <div class="design_profile_edit_section">
                    <div class="row">
                        <div class="col s6 input-field">
                            <label>Name</label>
                            <input type="text" name="designer_name" class="" value="{{$user->name ?? ""}}" disabled="disabled" />
                        </div>
                        <div class="col s6 input-field">
                            <label>Address</label>
                            <input type="text" name="designer_location" class="" value="{{$designer->designer_location ?? ""}}" />
                            <div class="small-info" style="color: #afafaf;"><i>your current location</i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <label>Nationality</label>
                            <input type="text" name="designer_nationality" class="" value="{{$designer->designer_nationality ?? ""}}" />
                            <div class="small-info" style="color: #afafaf;"><i>your nationality</i></div>
                        </div>
                        <div class="col s6 input-field">
                            <label>Experience</label>
                            <input type="number" name="designer_experience" class="" value="{{$designer->designer_experience ?? ""}}" />
                            <div class="small-info" style="color: #afafaf;"><i>your year of experience</i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <label>Worked With</label>
                            <input type="number" name="designer_worked_with" class="" value="{{$designer->designer_worked_with ?? ""}}" />
                            <div class="small-info" style="color: #afafaf;"><i>how many brands</i></div>
                        </div>
                        <div class="col s6 input-field">
                            <label>Completed</label>
                            <input type="number" name="designer_completed_task" class="" value="{{$designer->designer_completed_task ?? ""}}" />
                            <div class="small-info" style="color: #afafaf;"><i>how many completed tasks</i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label>Skills</label>
                            @php
                                $designerSkills = json_decode($designer->designer_skills);
                            @endphp
                            <select class="select2" name="designer_skills[]" multiple="multiple">
                                <option value="Fashion Design" @php echo (in_array("Fashion Design", $designerSkills)) ? "selected":""; @endphp>Fashion Design</option>
                                <option value="Print & Layout Design" @php echo (in_array("Print & Layout Design", $designerSkills)) ? "selected":""; @endphp>Print & Layout Design</option>
                                <option value="Technical Drawing" @php echo (in_array("Technical Drawing", $designerSkills)) ? "selected":""; @endphp>Technical Drawing</option>
                                <option value="Techpack Building" @php echo (in_array("Techpack Building", $designerSkills)) ? "selected":""; @endphp>Techpack Building</option>
                                <option value="Lookbook Design" @php echo (in_array("Lookbook Design", $designerSkills)) ? "selected":""; @endphp>Lookbook Design</option>
                            </select>
                            <div class="small-info" style="color: #afafaf;"><i>select your skills</i></div>
                        </div>
                        <div class="col s6 input-field">
                            <label>Asking Price</label>
                            <input type="number" name="designer_asking_price" class="" value="{{$designer->designer_asking_price ?? ""}}" />
                            <div class="small-info" style="color: #afafaf;"><i>your hourly price in USD</i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="fileBox col s12 input-field">
                            <label>Certifications</label>
                            <div class="certificate-upload-wrapper">
                                <div class="designer-certificates"></div>
                                <div class="or"><span>OR</span></div>
                                <a href="javascript:void(0);" class="btn_green browse_certificate_trigger">Browse files</a>
                            </div>
                            <div class="small-info" style="color: #afafaf;"><i>upload your certificates</i></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 input-field">
                            <label>About Me</label>
                            <textarea name="designer_about_me">{{$designer->designer_about_me ?? ""}}</textarea>
                        </div>
                    </div>
                    <div class="right-align">
                        <button type="submit" class="btn_green designer-profile-data-submit-trigger">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="designerDetailsPortfolio" class="modal designer_details_edit_modal">
        <a href="javascript:void(0);" class="modal-action modal-close"><i class="material-icons">close</i></a>
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" action="" class="designer_portfolio_data_form">
                <input type="hidden" name="page_mode" value="{{$page_mode}}" />
                <input type="hidden" name="designer_id" value="{{$designer->user_id ?? 0}}" />
                <div class="protfolio-upload-wrapper">
                    <div class="designer-protfolio-images"></div>
                    <div class="or"><span>OR</span></div>
                    <a href="javascript:void(0);" class="btn_green browse_portfolio_trigger">Browse files</a>
                </div>
                <div class="right-align">
                    <button type="submit" class="btn_green designer-portfolio-submit-trigger">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Designer section end -->


@endsection

@include('designer._scripts')
