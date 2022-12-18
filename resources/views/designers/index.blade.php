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

    <div class="coming_soon_wrap ">
        <div class="img_box">
            <img src="{{Storage::disk('s3')->url('public/frontendimages/coming-soon.jpg')}}" alt="" />
        </div>
        <a href="{{route('product.type.mapping',['studio', 'design'])}}" class="btn_design_studio">Go to Design Studio</a>
    </div>
    <div id="buyerDesignerView" style="display: none;">
        <div class="buyer_designer_inner_box_wrap">
            <h2>Designers</h2>
            <div class="row">
                @if(count($users) > 0)
                    @foreach ($users as $user)
                    <div class="col s12 m6 l4 xl3">
                        <div class="buyer_designer_inner_infobox">
                            <div class="rating_level">
                                Level 1
                            </div>
                            @if(count($user->designerPortfolio) > 0)
                                <div class="cover_img">
                                    <img src="{{Storage::disk('s3')->url('public/designers/'.$user->id.'/portfolio/'.$user->designerPortfolio[0]->image)}}" alt="" />
                                </div>
                            @else
                                <div class="cover_img">
                                    <img itemprop="image" src="{{Storage::disk('s3')->url('public/frontendimages/no-portfolio.png')}}" alt="" />
                                </div>
                            @endif
                            <div class="profile_img">
                                @if($user->image)
                                    <img itemprop="image" src="{{ Storage::disk('s3')->url('public/'.$user->image) }}" id="designer_profile_image" alt="avatar" width="300px">
                                @else
                                    <img itemprop="image" src="{{Storage::disk('s3')->url('public/frontendimages/no-designer-profile-image.png')}}" alt="" />
                                @endif
                            </div>
                            <div class="designer_info">
                                <div class="designer_info_wrap">
                                    <div class="designer_top_box">
                                        <div class="row">
                                            <div class="col s6 m7">
                                                <h4>{{$user->name ?? ""}}</h4>
                                            </div>
                                            <div class="col s6 m5">
                                                <div class="buyer_price">
                                                    <span>$ {{$user['designers']['designer_asking_price'] ?? ""}}</span> /hr
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="designer_address_box">
                                    <div class="row">
                                        <div class="col s6 m6">
                                            <h6>{{$user['designers']['designer_location'] ?? ""}}</h6>
                                        </div>
                                        <div class="col s6 m6">
                                            <div class="buyer_rating">
                                                <i class="material-icons">star</i>
                                                <i class="material-icons">star</i>
                                                <i class="material-icons">star</i>
                                                <i class="material-icons">star_half</i>
                                                <i class="material-icons">star_border</i>
                                            </div>
                                            <div class="buyer_completed">
                                                <!-- <i class="material-icons">task</i> -->
                                                <span class="completed_number">{{$user['designers']['designer_completed_task'] ?? ""}} </span> Task Done
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="designer_bottom_box">
                                    <div class="row">
                                        <div class="col s6 m7">
                                            <a href="{{route('single.designer.details',$user->id)}}" class="btn_light_green">View Profile</a>
                                        </div>
                                        <div class="col s6 m5">
                                            <div class="talk_to_me">
                                                <a href="javascript:void(0);">Talk to Me</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    No Data.
                @endif
            </div>
        </div>
    </div>




@endsection

@include('designers._scripts')
