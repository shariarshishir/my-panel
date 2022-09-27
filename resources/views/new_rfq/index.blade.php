@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | Post RFQ | Recieve Quotations in 48hrs | Produce your Designs')
@section('title', 'Post RFQ | Recieve Quotations in 48hrs | Produce your Designs')
@section('description', 'Find quality Manufacturers, Suppliers from the largest B2B bidding markets and customize your own product and service. 100+ Verified Sustainable Clothing Manufacturers. Free Samples Shipped. Low MOQ. Best Prices. Source Fashion, Fabric, Accessories from Bangladesh. Get connected with the right manufacturer. Get quotes for your fashion designs and begin production. Source garment manufacturers and manage orders through our app.')
@section('image', Storage::disk('s3')->url('public/frontendimages/RFQ.png'))
@section('keywords', 'Manufacturers,Suppliers,Exporters,Importers,RFQs,Merchant Bay,Textile Industry,Textile Company,Apparel Industry,Garments Company,Garment Manufacturing,Textile Factory,Business clothing factory,Fashion Manufacturers,B2B platform,B2B fashion,Fashion e-commerce,B2B e-commerce,RMG e-commerce,Fabric e-commerce,YARN e-commerce,Marketplace,RMG Marketplace,Fashion,Fashion Sourching,Best Suppliers in Bangladesh,Bangladesh RMG Sourching,Apparel Sourcing,Garments in Bangladesh,Post RFQ,RMG RFQ,RMG,Bulk RMG,RFQ,RMG Sourching,3D Design,3D Fashion,Merchandiser,Suppliers,Request for quotation,Fabric,Fabric Sourcing,Fabric Marketplace,Fabric Suppliers,Fabric RFQ,Fabric Suppliers in Bangladesh,Bulk Fabric,YARN,YARN Sourcing,YARN Marketplace,YARN Suppliers,YARN RFQ,YARN Suppliers in Bangladesh,Bulk YARN,Live fashion market,Ready Stock,merchantbay.com')

@section('ogtitle', 'Post RFQ | Recieve Quotations in 48hrs | Produce your Designs')
@section('ogdescription', 'Find quality Manufacturers, Suppliers from the largest B2B bidding markets and customize your own product and service. 100+ Verified Sustainable Clothing Manufacturers. Free Samples Shipped. Low MOQ. Best Prices. Source Fashion, Fabric, Accessories from Bangladesh. Get connected with the right manufacturer. Get quotes for your fashion designs and begin production. Source garment manufacturers and manage orders through our app.')
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/RFQ.png'))

@section('robots', 'index, nofollow')

@section('content')

<!-- Request For Quotation start -->
<div class="rfq_update_design_wrap">
    <div class="rfq_update_topbar center-align" >
        <h1>Request For Quotation</h1>
        <h5>Looking for raw materials or manufacturer to produce your merchandise?<br />Simply submit an RFQ and find the best match with speed and reliability.</h5>
        <a class="btn_green btn_post_rfq" href="{{route('rfq.create')}}">Post an RFQ <i class="material-icons">navigate_next</i></a>
    </div>
    <div class="rfq_update_question_bar">
        <div class="row">
            <div class="col s12 m6 xl3">
                <div class="rfq_update_question_innerBox">
                    <div class="rfq_icon_img center-align">
                        <span>
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/images/new-rfq-icon-2.png" alt="" />
                        </span>
                    </div>
                    <h3><span>What is RFQ?</span></h3>
                    <p>Request for Quotation (RFQ) in Merchant Bay is a system where users are able to submit their inquiry to receive verified manufacturers quotations and have Merchant Bay assist in finding the best production partner.</p>
                </div>
            </div>
            <div class="col s12 m6 xl3">
                <div class="rfq_update_question_innerBox">
                    <div class="rfq_icon_img center-align">
                        <span>
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/images/new-rfq-icon-3.png" alt="" />
                        </span>
                    </div>
                    <h3><span>When to post an RFQ?</span></h3>
                    <p>Buyer can post RFQ every time they need to source and/or manufacture apparel, raw materials and accessories. RFQ can be posted while requesting price or customization on any designs from MB design studio, or a buyer can submit any query that needs to be sourced or manufactured.</p>
                </div>
            </div>
            <div class="col s12 m6 xl3">
                <div class="rfq_update_question_innerBox">
                    <div class="rfq_icon_img center-align">
                        <span>
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/images/new-rfq-icon-4.png" alt="" />
                        </span>
                    </div>
                    <h3><span>What happens after RFQ is posted?</span></h3>
                    <p>After a user submits a RFQ, Merchant Bay algorithm look into the verified database of suppliers and matches it with the right partner. All matched suppliers can quote an offer to the query and a success manager from Merchant Bay is always there to help the buyer in selecting the best offer.</p>
                </div>
            </div>
            <div class="col s12 m6 xl3">
                <div class="rfq_update_question_innerBox">
                    <div class="rfq_icon_img center-align">
                        <span>
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/images/new-rfq-icon-1.png" alt="" />
                        </span>
                    </div>
                    <h3><span>How long does it take to receive a response?</span></h3>
                    <p>Typically within 48 hours after the RFQ is published, quotations starts coming. A user is notified in each steps of the action and assured to find the best fit supplier with MB success manager assistance.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="new_rfq_paths_boxwrap center-align">
        <div class="paths_container">
            <h3 class="paths-title">Explore</h3>
            <h5>You can also send RFQ from our Libraries</h5>
            <div class="row">
                <div class="col s12 m6 l4 xl2 new_rfq_paths_box">
                    <div class="path_box">
                        <div class="imgbox">
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/about-image/icons/design-studio.svg" alt="icon">
                        </div>
                        <a href="{{route('product.type.mapping',['studio', 'design'])}}">Design Studio
                            <i class="material-icons">navigate_next</i>
                        </a>
                    </div>
                </div>
                <div class="col s12 m6 l4 xl2 new_rfq_paths_box">
                    <div class="path_box">
                        <div class="imgbox">
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/about-image/icons/sample-storefront.svg" alt="icon">
                        </div>
                        <a href="{{route('product.type.mapping',['studio', 'product sample'])}}">Sample Storefront
                            <i class="material-icons">navigate_next</i>
                        </a>
                    </div>
                </div>
                <div class="col s12 m6 l4 xl2 new_rfq_paths_box">
                    <div class="path_box">
                        <div class="imgbox">
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/about-image/icons/fabric-library.svg" alt="icon">
                        </div>
                        <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">Fabric Library
                            <i class="material-icons">navigate_next</i>
                        </a>
                    </div>
                </div>
                <div class="col s12 m6 l4 xl2 new_rfq_paths_box">
                    <div class="path_box">
                        <div class="imgbox">
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/about-image/icons/yarn-library.svg" alt="icon">
                        </div>
                        <a href="{{route('product.type.mapping',['raw_materials', 'yarn'])}}">Yarn Library
                            <i class="material-icons">navigate_next</i>
                        </a>
                    </div>
                </div>
                <div class="col s12 m6 l4 xl2 new_rfq_paths_box">
                    <div class="path_box">
                        <div class="imgbox">
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/about-image/icons/accessories-library.svg" alt="icon">
                        </div>
                        <a href="{{route('product.type.mapping',['raw_materials', 'trims and accessories'])}}">Accessories Library
                            <i class="material-icons">navigate_next</i>
                        </a>
                    </div>
                </div>
                {{-- <div class="col s12 m6 l4 xl2">
                    <div class="path_box">
                        <div class="imgbox">
                            <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/about-image/icons/industry-isights.svg" alt="icon">
                        </div>
                        <a href="{{route('industry.blogs')}}">Industry Insights
                            <i class="material-icons">navigate_next</i>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<!-- Request For Quotation end -->

@endsection
