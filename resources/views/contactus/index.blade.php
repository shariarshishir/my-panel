@extends('layouts.app')
@section('style')
<style >

</style>
@endsection
@php
$isFromSubscription = request()->subscription;
$isFromSubscription = explode("=", $isFromSubscription);
@endphp
@section('content')

<div class="contactus-content-body">

    <div class="contact_top_wrapper">
        <p>Book a demo of Merchant Bay's Souring Panel</p>
        <a href="javascript:void(0);" class="btn_profile btn_green" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Schedule a meeting</a>
        <div class="or_part"><span>or</span></div>
    </div>
    <div class="row contact_content_block">
        <div class="col s12 m4 l4 contact_left_block">
            <div class="contact_left_block_content contact_get_in_touch">
                <h3>Get in Touch</h3>
                <p>We love to hear from you. Our friendly team is always here to help</p>
            </div>
            <div class="contact_left_block_content contact_email_to_us">
                <i class="fas fa-envelope icon_size"></i>
                <div>
                    <h6>Email to us</h6>
                    <p>success@merchantbay.com</p>
                </div>
            </div>
            <div class="contact_left_block_content contact_office">
                <i class="fas fa-print icon_size"></i>
                <div>
                    <h6>Office</h6>
                    <p>Meem Tower,<br />Floor: B, House: 18, Road: 12<br />Sector: 6, Uttara, Dhaka</p>
                </div>
            </div>
            <div class="contact_left_block_content contact_phone">
                <i class="fas fa-phone icon_size"></i>
                <div>
                    <h6>Phone</h6>
                    <p>Sun-Thu from 9 am to 7 pm<br />+9123456789</p>
                </div>
            </div>
            <div class="contact_left_block_content contact_follow_us">
                <h6>Follow us on</h6>
                <ul>
                    <li><a href="https://www.facebook.com/merchantbaybd" target="_blank"><i class="fab fa-facebook-square social_icons"></i></a></li>
                    <li><a href="https://twitter.com/merchantbay_com" target="_blank"><i class="fab fa-twitter-square social_icons"></i></a></li>
                    <li><a href="https://www.linkedin.com/company/merchantbay" target="_blank"><i class="fab fa-linkedin social_icons"></i></a></li>
                    <li><a href="https://www.instagram.com/merchant.bay/" target="_blank"><i class="fab fa-instagram-square social_icons"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="col s12 m8 l8 contact_right_block">
            <h3>Contact us</h3>
            <p>Fill up the form and our team will get back to you within 24 hours</p>
            <div class="input_field_wrapper">
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
                    <div class="input-field clearfix contact_privacy_checkbox">
                        <label>
                            <input type="checkbox" class="contact_privacy" name="contact_privacy">
                            <span>You agree to our <a href="{{route('front.policy')}}" target="_blank">privacy policy</a></span>
                        </label>
                    </div>
                    <input type="hidden" value="0" name="contact_subscription" />
                    <div class="" style="text-align: center">
                        <button type="submit" class="btn_profile btn_green contact-submit-trigger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
@include('contactus._scripts')
