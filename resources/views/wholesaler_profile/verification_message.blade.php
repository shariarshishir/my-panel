@if($business_profile->is_business_profile_verified == 0)
<div class="profile_verification_request_block">
    @if($business_profile->businessProfileVerificationsRequest)
    <div class="card-alert card orange lighten-5">
        <div class="card-content orange-text">
            <p><i class="material-icons verification-info-icon">info_outline</i> Your request is awaiting for verification. <a href="#send-verification-request-modal" class="send-verification-request-trigger modal-trigger">Resend Request</a></p>
        </div>
    </div>
    @else
    <div class="card-alert card orange lighten-5">
        <div class="card-content orange-text">
            <p><i class="material-icons verification-info-icon">info_outline</i> Your profile is not verified. <a href="#send-verification-request-modal" class="send-verification-request-trigger modal-trigger">Send Request</a></p>
        </div>
    </div>
    @endif
</div>	
@endif