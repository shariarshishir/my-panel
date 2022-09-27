@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | Site Map')
@section('title', 'Merchant Bay | Site Map')
@section('description', 'Simplest way to source apparel from Bangladesh.Get to know us! We match fashion buyers with the right clothing manufacturers and help manage your orders. Competitive Prices with Complete Visibility. Instant Response. Secured Payments.')
@section('image', Storage::disk('s3')->url('public/images/supplier.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Merchant Bay | Site Map')
@section('ogdescription', 'Simplest way to source apparel from Bangladesh.Get to know us! We match fashion buyers with the right clothing manufacturers and help manage your orders. Competitive Prices with Complete Visibility. Instant Response. Secured Payments.')
@section('ogimage', Storage::disk('s3')->url('public/images/supplier.png'))

@section('robots', 'index, nofollow')

@section('style')
<style >

</style>
@endsection

@section('content')

<div class="sitemap-wrapper">
    <legend>Site Map</legend>
    <div class="sitemap-inside-wrapper">
        <ol class="wtree">
            <li><span><a href="{{route('home')}}">Home</a></span></li>
            <li>
                <span>Explore</span>
                <ol>
                    <li>
                        <span>Studio</span>
                        <ol>
                            <li><span><a href="{{route('product.type.mapping',['studio', 'design'])}}">Design</a></span></li>
                            <li><span><a href="{{route('product.type.mapping',['studio', 'product sample'])}}">Product Sample</a></span></li>
                            <li><span><a href="{{route('product.type.mapping',['studio', 'ready stock'])}}">Ready Stock</a></span></li>
                        </ol>
                    </li>
                    <li>
                        <span>Raw materials</span>
                        <ol>
                            <li><span><a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">Textile</a></span></li>
                            <li><span><a href="{{route('product.type.mapping',['raw_materials', 'yarn'])}}">Yarn</a></span></li>
                            <li><span><a href="{{route('product.type.mapping',['raw_materials', 'trims and accessories'])}}">Trims and Accessories</a></span></li>
                        </ol>
                    </li>
                    <li><span><a href="{{route('suppliers')}}">Suppliers</a></span></li>
                </ol>
            </li>
            <li>
                <span><a href="{{route('new_rfq.index')}}">RFQ</a></span>
                <ol>
                    <li><span><a href="{{route('rfq.create')}}">Submit RFQ</a></span></li>
                </ol>
            </li>
            <li>
                <span>Why Us?</span>
                <ol>
                    <li><span><a href="{{route('front.howwework')}}">How We Work</a></span></li>
                    <li><span><a href="{{route('front.aboutus')}}">About Us</a></span></li>
                    <li><span><a href="{{route('front.faq')}}">FAQ</a></span></li>
                    <li><span><a href="{{route('industry.blogs')}}">Blogs</a></span></li>
                </ol>
            </li>
            <li><span><a href="{{route('front.policy')}}">Policies</a></span></li>
        </ol>
    </div>
</div>
@endsection
