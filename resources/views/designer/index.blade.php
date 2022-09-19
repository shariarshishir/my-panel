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

    <div class="suppliers_container suppliers_filter_wrapper row" itemscope>
        <div class="col s12 m12 l12" itemscope>
            <h1>Single Designer</h1>
            {{$user->name}}
        </div>
    </div>

@endsection

@include('designers._scripts')
