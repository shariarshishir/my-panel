@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | Pricing Plan')
@section('title', 'Merchant Bay | Pricing Plan')
@section('description', 'Simplest way to source apparel from Bangladesh.Get to know us! We match fashion buyers with the right clothing manufacturers and help manage your orders. Competitive Prices with Complete Visibility. Instant Response. Secured Payments.')
@section('image', Storage::disk('s3')->url('public/images/supplier.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Merchant Bay | Pricing Plan')
@section('ogdescription', 'Simplest way to source apparel from Bangladesh.Get to know us! We match fashion buyers with the right clothing manufacturers and help manage your orders. Competitive Prices with Complete Visibility. Instant Response. Secured Payments.')
@section('ogimage', Storage::disk('s3')->url('public/images/supplier.png'))

@section('robots', 'index, nofollow')

@section('content')

<div class="success-message-container">
    <i class="material-icons">mail_outline</i>
    <h3>Thanks for submitting!</h3>
    <p>Your request is successfully received.<br />Merchant Bay will contact you within 48 Hours.<br />Thank You!</p>
</div>

@endsection
