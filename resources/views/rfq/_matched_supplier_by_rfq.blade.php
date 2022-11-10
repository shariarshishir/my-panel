@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="row">
                <h4>{{$rfq['title']}}</h4>
                <div class="col s12 m2">
                    <label>Product Type</label>
                    {{$rfq['industry']}}
                </div>
                <div class="col s12 m2">
                    <label>Product Tags</label>
                    @foreach($rfq['category'] as $tag)
                        {{$tag['name']}}
                    @endforeach
                </div>
                <div class="col s12 m2">
                    <label>Quantity</label>
                    {{$rfq['quantity']}}
                </div>
                <div class="col s12 m2">
                    <label>Target Price</label>
                    {{$rfq['unit_price']}}
                </div>
                <div class="col s12 m2">
                    <label>Delivery In</label>
                    {{$rfq['delivery_time']}}
                </div>
                <div class="col s12 m2">
                    <label>Delivery To</label>
                    {{$rfq['destination']}}
                </div>
            </div>
        </div>

        <a class="waves-effect waves-light btn modal-trigger request-for-quotation-modal-trigger" id="request-for-quotation-from-rfq-button" href="#request-for-quotation-from-rfq" >Request for Quotation</a>
        <!-- Modal Structure -->
        <div id="request-for-quotation-from-rfq" class="modal">
            <div class="modal-content">
                <h4>Modal Header</h4>
                <p id="request-for-quotation-from-rfq-profile-count"></p>
                <a href="javascript:void(0)" class="btn btn_green" onclick='onRequestSubmit()'>Submit</a>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div class="rfq_new_layout_match_supplier_with_rfq">
            <div class="match_supplier_rfq_single_wrapper">
                <div class="row single_wraper_gapping">

                    @foreach($businessProfiles as $businessProfile)
                    <div class="col s12 m4 matched_supplier_item">
                        <!-- new -->
                        <div class="match_supplier_rfq_single_content">
                            <div class="input-field">
                                <label>
                                    <input type="checkbox" id={{$businessProfile['id']}} user_id={{$businessProfile['user_id']}} name="remember" onclick='onProfileSelected(this)'>
                                    <span></span>
                                </label>
                            </div>
                            <div class="match_supplier_rfq_single_content_inner_part">

                                <!-- First div part -->
                                <div class="row sparkle_part">
                                    <div class="col s12 m3 image_width_wrap">
                                        <img class="image_width" src='https://s3.ap-southeast-1.amazonaws.com/service.products/public/{{$businessProfile['business_profile_logo']}}' alt="">
                                    </div>
                                    <div class="col s12 m5 sparkle_knit">
                                        <h3>{{$businessProfile['business_name']}}</h3>
                                        <p>{{$businessProfile['location']}}</p>
                                    </div>
                                    <div class="col s12 m4 middle_wrap">
                                        <div class="">
                                            @if($businessProfile['profile_verified_by_admin'] == 1)
                                            <i class="material-icons">check_circle</i>
                                            @else
                                            <i class="material-icons">close_circle</i>
                                            @endif
                                        </div>
                                        <div class="icon_wrap">
                                            <p>@foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                                @if($data->name == 'year_of_establishment')    
                                                    <h5>{{date("Y")-$data->value}}+</h5>
                                                @endif
                                            @endforeach</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Second div part -->
                                <div class="middle_part_image_wrapper">
                                    <h6>Certification:</h6>
                                    <div class="inner_content_image">
                                    @foreach($businessProfile['certifications'] as $cert)
                                    <img class="" src='https://s3.ap-southeast-1.amazonaws.com/service.products/public/{{$cert['image']}}' alt="">
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
            @php
            var_dump($businessProfiles);
        @endphp
            
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
            document.getElementById('request-for-quotation-from-rfq-profile-count').innerHTML = 
            'Are you sure want to send Quotation to '+ len + 'suppliers';
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
                $("#request-for-quotation-from-rfq").modal('show');
            }else{
                $("#request-for-quotation-from-rfq").modal('hide');
                
            }
            console.log('business_profile_ids',business_profile_ids);
            console.log('business_profile_user_ids',business_profile_user_ids);
            
        }        
    </script>   
@endpush