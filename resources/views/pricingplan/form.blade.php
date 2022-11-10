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

@section('style')
<style >

</style>
@endsection

@section('content')

<div class="pricing-plan-wrapper">
    <div id="subscribeDataModalWrapperOuter" class="subscribe-data-modal-wrapper-outer">
        <div class="subscribe-data-modal-wrapper-inside">
            <h2 class="plan-label"></h2>
            <div class="row">
                <div class="row-inside first-modal" style="display: none;">
                    <div class="col s12 m6 l6 subscription_plan_block_outer" style="display: none">
                        <div class="subscription_plan_block free_block">
                            <div class="subscription_plan_block_top">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <div class="plan_title">Free Trial</div>
                                    </div>
                                    <div class="col s12 m6">
                                    <div class="plan_time_free">30 days free trial</div>
                                    </div>
                                </div>
                            </div>
                            <div class="subscription_plan_block_mid">
                                <ul>
                                    <li><i class="material-icons">check</i> 12 Request For Quotes Per Year.</li>
                                    <li><i class="material-icons">check</i> Place Orders To 1000+ Manufacturers In Bangladesh.</li>
                                    <li><i class="material-icons">check</i> Access To Manufacturer Profiles and Direct Messaging<span>*</span></li>
                                    <li><i class="material-icons">check</i> Access To Feature Designs By Manufacturers<span>*</span></li>
                                    <li><i class="material-icons">check</i> Full Access to 1000+ Raw Materials (Textiles, Yarns & Accessories).</li>
                                    <li><i class="material-icons">check</i> Develop Products & Samples In Our Product Development Studio</li>
                                    <li><i class="material-icons">check</i> Hire International Designers</li>
                                    <li><i class="material-icons">check</i> Monitor Your Order Through Our Order Management System</li>
                                </ul>
                                <span class="limited">* Limited</span>
                            </div>
                            <div class="subscription_plan_block_bottom">
                                <a href="javascript:void(0);" class="btn btn_green free_subscription_trigger" data-subscriptiontype="free">Start Your Free Trial</a>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l12 subscription_plan_block_outer">
                        <div class="subscription_plan_block paid_block">
                            <div class="subscription_pricing_block">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="yearly_billing_message">After your free trial month, you will be charged</div>
                                        <div class="yearly_pricing_block">
                                            <span class="yearly_plan_price old_plan_price">$10000</span>
                                            <span class="yearly_plan_price_separator">/</span>
                                            <span class="yearly_plan_price new_plan_price">$5000 <span class="bill_test">Billed Annually</span></span>
                                        </div>
                                        <div class="yearly_pricing_message_block">
                                            Top 10 Values To Make Your Sourcing Easy:
                                        </div>
                                    </div>
                                    <div class="col s12" style="display: none;">
                                        <div class="plan_time half_yearly">
                                            <ul>
                                                <li data-plantype="yearly" class="active"><a href="javascript:void(0);" class="yearly_plan">Yearly</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="subscription_plan_block_mid">
                                <ul>
                                    <li><i class="material-icons">check</i> Unlimited Request for Quotation</li>
                                    <li><i class="material-icons">check</i> Place orders with with 0% commission</li>
                                    <li><i class="material-icons">check</i> Filter and visit 1000+ vetted manufacturers virtually</li>
                                    <li><i class="material-icons">check</i> Access to Digital Textile Library with 2000+ Fabrics</li>
                                    <li><i class="material-icons">check</i> Access to Digital Design Studio with 1000+ designs every season</li>
                                    <li><i class="material-icons">check</i> Access to regular Live Exhibition, showcasing designs and ready stock</li>
                                    <li><i class="material-icons">check</i> Access to international designers to hire</li>
                                    <li><i class="material-icons">check</i> Develop 30 Free Samples annually from MB in-house studio</li>
                                    <li><i class="material-icons">check</i> Manage all order and production using M-Factory App</li>
                                    <li><i class="material-icons">check</i> Dedicated account manager for trade assurance</li>
                                </ul>
                            </div>
                            <div class="subscription_plan_block_bottom">
                                <a href="javascript:void(0);" class="btn btn_green paid_subscription_trigger" data-subscriptiontype="paid">Start Free Trial</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second-modal" style="display: block;">
                    <div class="backArrow" style="display: none;">
                        <a href="javascript:void(0);" class="plan_selection_back_trigger"><i class="material-icons">keyboard_backspace</i></a>
                    </div>
                    <div class="free_trial_subscription_message_box">
                        <div class="free_trial_subscription_leftText">
                            <span>Free Trial Subscription</span>
                        </div>
                        <div class="free_trial_subscription_rightText">
                            <p>Your free trial begins {{$trialPeiodStartDate}} and will end on {{$trialPeiodEndDate}}. You can cancel anytime before <b>{{$trialPeiodEndDate}}</b> to avoid being charged and we'll send an email reminder <b>7 days before the trial ends.</b></p>
                        </div>
                    </div>
                    <div class="row-inside row">
                        <div class="col s12 m6 l6">
                            <div class="selected_plan_content">
                                <div class="subscription_plan_block paid_block">
                                    <div class="subscription_pricing_block">
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="yearly_billing_message">After your free trial month, you will be charged</div>
                                                <div class="yearly_pricing_block">
                                                    <span class="yearly_plan_price old_plan_price">$10000</span>
                                                    <span class="yearly_plan_price_separator">/</span>
                                                    <span class="yearly_plan_price new_plan_price">$5000 <span class="bill_test">Billed Annually</span></span>
                                                </div>
                                                <div class="yearly_pricing_message_block">
                                                    Top 10 Values To Make Your Sourcing Easy:
                                                </div>
                                            </div>
                                            <div class="col s12" style="display: none;">
                                                <div class="plan_time half_yearly">
                                                    <ul>
                                                        <li data-plantype="yearly" class="active"><a href="javascript:void(0);" class="yearly_plan">Yearly</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="subscription_plan_block_mid">
                                        <ul>
                                            <li><i class="material-icons">check</i> Unlimited Request for Quotation</li>
                                            <li><i class="material-icons">check</i> Place orders with with 0% commission</li>
                                            <li><i class="material-icons">check</i> Filter and visit 1000+ vetted manufacturers virtually</li>
                                            <li><i class="material-icons">check</i> Access to Digital Textile Library with 2000+ Fabrics</li>
                                            <li><i class="material-icons">check</i> Access to Digital Design Studio with 1000+ designs every season</li>
                                            <li><i class="material-icons">check</i> Access to regular Live Exhibition, showcasing designs and ready stock</li>
                                            <li><i class="material-icons">check</i> Access to international designers to hire</li>
                                            <li><i class="material-icons">check</i> Develop 30 Free Samples annually from MB in-house studio</li>
                                            <li><i class="material-icons">check</i> Manage all order and production using M-Factory App</li>
                                            <li><i class="material-icons">check</i> Dedicated account manager for trade assurance</li>
                                        </ul>
                                    </div>
                                    <div class="subscription_plan_block_bottom">
                                        <a href="javascript:void(0);" class="btn btn_green paid_subscription_trigger" data-subscriptiontype="paid" style="display: none;">Start Free Trial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="selected_plan_contact">
                                <form method="post" id="contact-form-data" action="">
                                    <div class="input-field clearfix">
                                        <label for="">Name</label>
                                        <input type="text" name="contact_name" class="contact_name contact-input"
                                            placeholder="Your name">
                                    </div>
                                    <div class="input-field clearfix">
                                        <label for="">Email</label>
                                        <input type="email" name="contact_email" class="contact_email contact-input"
                                            placeholder="Your email">
                                    </div>
                                    <div class="input-field clearfix">
                                        <label for="">Company Name</label>
                                        <input type="text" name="contact_company_name"
                                            class="contact_company_name contact-input" placeholder="Your Company Name">
                                    </div>
                                    <div class="input-field clearfix">
                                        <label for="">Phone</label>
                                        <input type="number" name="contact_phone" class="contact_phone contact-input"
                                            placeholder="Your Phone Number">
                                    </div>
                                    <div class="input-field clearfix">
                                        <label for="">Message</label>
                                        <textarea name="contact_message" class="contact_message contact-input-message"
                                            cols="30" rows="10" placeholder="Please tell us anything..."></textarea>
                                    </div>
                                    <div class="input-field clearfix contact_subscription_privacy">
                                        <label>
                                            <input type="checkbox" class="contact_privacy" name="contact_privacy">
                                            <span>You agree to our <a href="{{route('front.policy')}}" target="_blank">privacy policy</a></span>
                                        </label>
                                    </div>

                                    <input type="hidden" value="{{$trialPeiodStartDateNonFormate}}" name="trial_priod_start_date" />
                                    <input type="hidden" value="{{$trialPeiodEndDateNonFormate}}" name="trial_priod_end_date" />

                                    <input type="hidden" value="1" name="contact_subscription" />
                                    <input type="hidden" value="" id="contact_subscription_plan_type" name="contact_subscription_plan_type" />
                                    <div class="" style="text-align: center">
                                        <button type="submit" class="btn_profile btn_green contact-submit-trigger">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@include('contactus._scripts')
