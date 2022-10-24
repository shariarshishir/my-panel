<div class="col-md-12">
    <div class="card card-with-padding">
        @php
        if(count($vendorReviews) > 0) 
        {
            foreach($vendorReviews as $vendorReview) 
            {
        @endphp
        <div class="review-item">
            <div class="reviewed-by row">
                <div class="user-image left">
                    <img src="{{asset('storage/'.$vendorReview->user->image)}}" class="responsive-img" />
                </div>
                <div class="user-name left">
                    <span>Reviewd by</span> {{ $vendorReview->user->name }}
                </div>
            </div>
            <div class="review-info">
                <div class="row">
                    <div class="col s12 review_info_box">
                        <label>Overall : </label>
                        <div class="star-rating" data-score="{{ $vendorReview->overall_rating }}"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 review_info_box">
                        <label>Communication : </label>
                        <div class="star-rating" data-score="{{ $vendorReview->communication_rating }}"></div>

                    </div>
                </div>
                <div class="row">
                    <div class="col s12 review_info_box">
                        <label>On Time Delivery : </label>
                        <div class="star-rating" data-score="{{ $vendorReview->ontime_delivery_rating }}"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 review_info_box">
                        <label>Sample Support : </label>
                        <div class="star-rating" data-score="{{ $vendorReview->sample_support_rating }}"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 review_info_box">
                        <label>Product Quality : </label>
                        <div class="star-rating" data-score="{{ $vendorReview->product_quality_rating }}"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 review_info_box">
                        <label>Experience : </label>
                        {{ $vendorReview->experience }}
                    </div>
                </div>
            </div>
        </div>
        @php
            }
        } else {
        @endphp
        <div class="card-alert card cyan">
            <div class="card-content white-text">
                <p>INFO : Don't have any reviews</p>
            </div>
        </div>
        @php } @endphp
    </div>    
</div>

@include('user.profile.reviews._scripts')

