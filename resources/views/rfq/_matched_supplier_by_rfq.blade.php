@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="row">
                <h4>{{$rfq['title']}}</h4>
                <div class="rfq_posted_time">{{ $rfq['created_at'] }}</div>
                <div class="col s12 m2">
                    <label>Product Type</label>
                    <p>{{$rfq['industry']}}</p>
                </div>
                <div class="col s12 m2">
                    <label>Product Tags</label>
                    @foreach($rfq['category'] as $tag)
                        <p>{{$tag['name']}}</p>
                    @endforeach
                </div>
                <div class="col s12 m2">
                    <label>Quantity</label>
                    <p>{{$rfq['quantity']}}</p>
                </div>
                <div class="col s12 m2">
                    <label>Target Price</label>
                    <p>{{$rfq['unit_price']}}</p>
                </div>
                <div class="col s12 m2">
                    <label>Delivery In</label>
                    <p>{{$rfq['delivery_time']}}</p>
                </div>
                <div class="col s12 m2">
                    <label>Delivery To</label>
                    <p>{{$rfq['destination']}}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="supplier-matched-count-outerwrapper">
                <h4>Matched Suppliers</h4>
                <div class="supplier-matched-count-wrapper">
                    <div class="supplier-matched-count-box">{{ count($businessProfiles) }} Supplier Matched</div>
                    <div class="supplier-matched-selected-box"></div>
                </div>
            </div>

            @php
                $cookie = Cookie::get('sso_token');
                $cookie = base64_decode(explode(".",$cookie)[1]);
                $cookie = json_decode(json_decode(json_encode($cookie)));
            @endphp

            @if($cookie->subscription_status == 1)
                <div class="new_rfq_filter_wrapper">
                    <div class="new_rfq_filter_select">
                        <div class="input-field">
                            <label>
                                <input type="checkbox" id="select-all-supplier" name="select-all-supplier" />
                                <span>Select All</span>
                            </label>
                        </div>
                    </div>
                    <a class="waves-effect waves-light btn modal-trigger request-for-quotation-modal-trigger" id="request-for-quotation-from-rfq-button" href="#request-for-quotation-from-rfq" >Request for Quotation</a>
                </div>
                <!-- Modal Structure -->
                <div id="request-for-quotation-from-rfq" class="modal">
                    <div class="modal-content">
                        <h4>Request for quotation</h4>
                        <div class="request-for-quotation-from-rfq-profile-count-message">
                            <p>Are you sure about requesting for quotation to</p>
                            <p id="request-for-quotation-from-rfq-profile-count"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn_green" onclick='onRequestSubmit()'>Submit</a>
                        <a href="javascript:void(0)" class="btn btn_green modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                    </div>
                </div>

                <div class="rfq_new_layout_match_supplier_with_rfq">
                    <div class="match_supplier_rfq_single_wrapper">
                        <div class="row single_wraper_gapping">

                            @foreach($businessProfiles as $businessProfile)
                            <div class="col s12 m4 matched_supplier_item">
                                <div class="match_supplier_rfq_single_content">
                                    <div class="input-field">
                                        <label>
                                            <input type="checkbox" id="{{$businessProfile['id']}}" user_id="{{$businessProfile['user_id']}}" name="remember" onclick='onProfileSelected(this)'>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="match_supplier_rfq_single_content_inner_part">

                                        <!-- First div part -->
                                        <div class="row sparkle_part">
                                            <div class="col s12 m3">
                                                <div class="image_width_wrap">
                                                    <img class="image_width" src='{{Storage::disk('s3')->url('public/'.$businessProfile['business_profile_logo'])}}' alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m4">
                                            <div class="middle_wrap">
                                                <span class="check_circle">
                                                    @if($businessProfile['profile_verified_by_admin'] == 1)
                                                    <i class="material-icons">check_circle</i>
                                                    @endif
                                                </span>
                                                <span class="icon_wrap">
                                                    @foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                                        @if($data->name == 'year_of_establishment')
                                                            {{isset($data->value) ? ((int)date('Y') - (int)$data->value) :''}}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Second div part -->
                                        <div class="middle_part_image_wrapper">
                                            <h6>Certification:</h6>
                                            <div class="inner_content_image">
                                                @foreach($businessProfile['certifications'] as $cert)
                                                    <img class="" src='{{Storage::disk('s3')->url('public/'.$cert['image'])}}' alt="">
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- Third div part -->
                                        <div class="main_product_wrap">
                                            <h6>Main Products:</h6>
                                            <div class="row main_product_inner">
                                                <div class="col s12 m10">
                                                    @foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                                        @if($data->name == 'main_products')
                                                            <h5>{{$data->value}}</h5>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="col s12 m2 chatbox_wrap">
                                                    <img src="./images/chat-img.png" alt=""> <span>5</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="non-subscribe-message-block">
                    <div class="non-subscribe-block-text">
                        <p>We have {{count($businessProfiles)}} suppliers matched</p>
                        <p>with your Quotation.</p>
                    </div>
                    <div class="row">
                        <div class="col s6 m6">
                            <p>Please subscribe to see the suppliers</p>
                            <a href="{{route('pricing.plan.form')}}" class="btn btn_green">Subscribe</a>
                        </div>
                        <div class="col s6 m6">
                            <p>Get back to you with in 24 hours</p>
                            <a class="btn_green btn_rfq_post_next btn_rfq_post modal-trigger right" href="#rfq-user-system-entry-modal">Submit as Guest</a>
                        </div>
                    </div>
                </div>
                
            @endif


        </div>
@endsection
@push('js')
    <script type="text/javascript">

        let business_profile_ids = [];
        let business_profile_user_ids = [];

        $(document).ready(function(){
            console.log(business_profile_ids.length)
            if(business_profile_ids.length == 0) {
                $(".request-for-quotation-modal-trigger").attr("disabled", true);
            }
        });

        const isReadyToSumbit = () =>{
            return business_profile_ids.length>0;
        }
        const showBusinessProfileCount = (len) => {
            document.getElementById('request-for-quotation-from-rfq-profile-count').innerHTML = len + ' suppliers?';
        }
        const onRequestSubmit = () => {
            console.log('business_profile_ids',business_profile_ids);
            console.log('business_profile_user_ids',business_profile_user_ids);
            var xmlHttp = new XMLHttpRequest();
            // xmlHttp.open( "GET", "http://127.0.0.1:8000/rfq/submit-matched-suppleirs/"+business_profile_user_ids.join(','), false ); // false for synchronous request
            // xmlHttp.send( null );
            var redirect_url = '{{ route("rfq.submit-matched-suppleirs", ":slug") }}';
            redirect_url = redirect_url.replace(':slug', business_profile_user_ids.join(','));
            var url = redirect_url;
            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if(response.status == 200){
                    window.location.href = '{{ route("home") }}';
                }
            });
            // console.log()
        }

        const onProfileSelected = (e) => {

            let id = Number(e?.id);
            let user_id = Number(e?.attributes?.getNamedItem("user_id")?.value);
            let checked = e.checked;
            // add business profile id
            if(checked){
                business_profile_ids.push(id);
                if(business_profile_user_ids.indexOf(user_id) == -1){
                    business_profile_user_ids.push(user_id);
                }
            }else{
                // remove business profile id
                const index = business_profile_ids.indexOf(id);
                if (index > -1) {
                    business_profile_ids.splice(index, 1);
                }
                const user_index = business_profile_user_ids.indexOf(user_id);
                if (user_index > -1) {
                    business_profile_user_ids.splice(user_index, 1);
                }
            }
            if(business_profile_ids.length == 0) {
                $(".request-for-quotation-modal-trigger").attr("disabled", true);
            } else {
                $(".request-for-quotation-modal-trigger").attr("disabled", false);
            }
            if(isReadyToSumbit()){
                console.log('business_profile_ids.length',business_profile_ids.length)
                showBusinessProfileCount(business_profile_ids.length);
                //$("#request-for-quotation-from-rfq").modal('show');
            }else{
                //$("#request-for-quotation-from-rfq").modal('hide');
            }
            $(".supplier-matched-selected-box").html("Selected Suppliers "+business_profile_ids.length);
            console.log('business_profile_ids',business_profile_ids);
            console.log('business_profile_user_ids',business_profile_user_ids);

        }
    </script>
@endpush
