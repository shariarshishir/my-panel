@extends('layouts.app')
@section('content')
@include('sweet::alert')
<section class="content">
    <div class="container-fluid">

            @if($vendorReviewExistOrNot)
            <div class="col-md-12">
                <div class="card card-with-padding">
                    <div class="card-alert card cyan">
                        <div class="card-content white-text">
                            <p>INFO : You already have a review on this order</p>
                        </div>
                    </div>
                </div>
            </div>

            @else
                <div class="form">
                    <legend>Write your review</legend>
                    <!--div class="overall-star-rating" data-rateit-value="3.5" data-rateit-ispreset="true" data-rateit-readonly="true"></div-->
                    <form action="{{route('vendor.review.create',['orderNumber'=>$order->order_number,'vendorUid'=>$vendor->vendor_uid])}}" method="post" name="reviewForm" id="reviewForm">
                        @csrf
                        <div class="row">
                            <div class="col s12">
                                <label>Overall : </label>
                                <div id="overall-star-rating" class="score"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label>Communication : </label>
                                <div id="communication-star-rating" class="score"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label>On Time Delivery : </label>
                                <div id="ontimedelivery-star-rating" class="score"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label>Sample Support : </label>
                                <div id="samplesupport-star-rating" class="score"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label>Product Quality : </label>
                                <div id="productquality-star-rating" class="score"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label>Share your experience : </label>
                                <textarea id="experience" name="experience" class="materialize-textarea"></textarea>
                            </div>
                        </div>

                        <input type="hidden" value="{{$vendor->id}}" name="vendor_id" />
                        <input type="hidden" value="{{$order->id}}" name="order_id" />
                        <button type="submit" class="btn green waves-effect waves-light" id="submitReview">Submit Review</button>
                        <br>
                        <br>
                    </form>
                </div>
            @endif

        </div>

</div>

@endsection

@push('js')

@endpush
