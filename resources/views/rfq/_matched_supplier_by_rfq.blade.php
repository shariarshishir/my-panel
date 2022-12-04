@extends('layouts.app')

@section('content')

    <div class="new_rfq_supplier_outer_wrapper">
        <div class="card new_rfq_supplier_product_info">
            <h4>{{$rfq['title']}}</h4>
            <div class="rfq_posted_time"> <i class="material-icons">access_time</i> {{ \Carbon\Carbon::parse($rfq['created_at'])->isoFormat('MMMM Do YYYY')}}</div>

            <div class="rfq_product_infoBox">
                <div class="row">
                    <div class="col s12 m4 l2">
                        <label>Product Type</label>
                        <p>{{$rfq['industry']}}</p>
                    </div>
                    <div class="col s12 m4 l2">
                        <label>Product Tags</label>
                        @foreach($rfq['category'] as $tag)
                            <p>{{$tag['name']}}</p>
                        @endforeach
                    </div>
                    <div class="col s12 m4 l2">
                        <label>Quantity</label>
                        <p>{{$rfq['quantity']}}</p>
                    </div>
                    <div class="col s12 m4 l2">
                        <label>Target Price</label>
                        <p>{{$rfq['unit_price']}}</p>
                    </div>
                    <div class="col s12 m4 l2">
                        <label>Delivery In</label>
                        <p>{{$rfq['delivery_time']}}</p>
                    </div>
                    <div class="col s12 m4 l2">
                        <label>Delivery To</label>
                        <p>{{$rfq['destination']}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card new_rfq_supplier_matched_outerwrapper">
            <div class="supplier-matched-count-outerwrapper">
                <div class="row">
                    <div class="col s12 l4">
                        <h4>Matched Suppliers</h4>
                    </div>
                    <div class="col s12 l8">
                        <div class="supplier-matched-count-wrapper">
                            <div class="supplier-matched-count-box">{{ count($businessProfiles) }} Supplier Matched</div>
                            <div class="supplier-matched-selected-box" id="supplier-matched-selected-count"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Need to recommend --}}
            @php
                $cookie = Cookie::get('sso_token');
                $cookie = base64_decode(explode(".",$cookie)[1]);
                $cookie = json_decode(json_decode(json_encode($cookie)));
                //$cookie->subscription_status = 1;
            @endphp

            <div class="rfq_new_layout_match_suppliers_wrap">
                @if($cookie->subscription_status == 1)
                <div class="new_rfq_filter_wrapper">
                    <div class="new_rfq_filter_select">
                        <div class="new_rfq_filter_wrap">
                            <div class="input-field">
                                <label>
                                    <input type="checkbox" id="select-all-supplier" name="select-all-supplier" onclick='onSelectAll(this)'/>
                                    <span>Select All</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="rfq_supplier_filter rfq_filter_box">
                        <i class="material-icons">search</i>
                        <input placeholder="Type a Supplier Name" type="text" name="rfq_supplier_filter_field" value="" onkeyup="filterSupplier(this.value,0)"/>
                    </div>
                    <div class="rfq_matched_supplier_list_wrapper rfq_filter_box">
                        <a onclick="supplierlistTrigger()" href="javascript:void(0);" class="rfq_matched_supplier_list_trigger">Select one/multiple certificates</a>
                        <div id="rfqMatchedSupplierlist">
                            <ul id="rfq_matched_supplier_list_ul" style="height: 200px; overflow-y: auto;">

                            </ul>
                        </div>
                    </div>
                    <div class="rfq_filter_box input-field rfq_filter_experience">
                        <input placeholder="Years Of Experience" type="number" name="rfq_supplier_filter_field" value="" onkeyup="filterSupplier(this.value,2)"/>
                    </div>
                    <div class="filter_clear_all">
                        <a href="javascript:void(0);" class="btn btn_clear_all" onclick="clearFilter();">All Clear<i class="material-icons">clear_all</i></a>
                    </div>
                    <div class="request_quotation_wrap">
                        <div class="request_for_quotation">
                            <a class="btn_request_quotation waves-effect waves-light btn modal-trigger request-for-quotation-modal-trigger" id="request-for-quotation-from-rfq-button" href="#request-for-quotation-from-rfq" >Request for Quotation</a>

                        </div>
                    </div>
                </div>
                <!-- Modal Structure -->
                <div id="request-for-quotation-from-rfq" class="modal request_quotation_rfq_from">
                    <a href="javascript:void(0)" class="btn btn_green_close modal-action modal-close waves-effect waves-green btn-flat"><i class="material-icons">close</i></a>
                    <div class="modal-content">
                        <h4>Request for quotation</h4>
                        <div class="request-for-quotation-from-rfq-profile-count-message">
                            <img class="" src="{{Storage::disk('s3')->url('public/frontendimages/matched-supplier-icon.png')}}" alt="matched-supplier-icon" itemprop="img">
                            <p>Are you sure about requesting for quotation to</p>
                            <p class="nupplier_numbers" id="request-for-quotation-from-rfq-profile-count"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn_green" onclick='onRequestSubmit()'>Submit</a>
                        <a href="javascript:void(0)" class="btn btn_green btn_cancle modal-action modal-close waves-effect waves-green btn-flat">Caccle</a>
                    </div>
                </div>

                <div class="rfq_new_layout_match_supplier_with_rfq">
                    <div class="match_supplier_rfq_single_wrapper">
                        <div class="row single_wraper_gapping">
                            <label id="no-supplier-found" style="display:none;">No Supplier Found</label>
                            
                            @foreach($businessProfiles as $businessProfile)
                            <div class="col s12 m6 l4 matched_supplier_item" name="{{$businessProfile['business_name']}}">
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
                                                    @if($businessProfile['user']['image'])
                                                    <img class="image_width" src='{{Storage::disk('s3')->url('public/'.$businessProfile['user']['image'])}}' alt="">
                                                    @else
                                                    <img class="image_width" src="{{Storage::disk('s3')->url('public/frontendimages/no-image.png')}}" alt="avatar" itemprop="img">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col s12 m7">
                                                <h3>{{$businessProfile['business_name']}}</h3>
                                                <span class="location">{{$businessProfile['location']}}</span>
                                            </div>
                                            <div class="col s12 m2">
                                                <div class="middle_wrap">
                                                    <span class="check_circle">
                                                        @if($businessProfile['profile_verified_by_admin'] == 1)
                                                        <i class="material-icons">check_circle</i>
                                                        @endif
                                                    </span>
                                                    <span class="icon_wrap">
                                                        @foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                                            @if($data->name == 'year_of_establishment')
                                                            {{isset($data->value) ? ((int)date('Y') - (int)$data->value) :''}} Y
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Second div part -->

                                        <div class="middle_part_image_wrapper">
                                            <h6>Certification:</h6>
                                            @if($businessProfile['certifications'])
                                            <div class="inner_content_image suppliers_certificates_list">
                                                @foreach($businessProfile['certifications'] as $cert)
                                                    <img class="" src='{{Storage::disk('s3')->url('public/'.$cert['image'])}}' alt="">
                                                @endforeach
                                            </div>
                                            @else
                                                <p>No Certifications found.</p>
                                            @endif
                                        </div>
                                        <div class="main_product_wrap">
                                            <h6>Workers:</h6>
                                            <div class="main_product_inner">
                                                @php $t=0; @endphp
                                                @foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                                    @if($data->name == 'number_of_worker' || $data->name == 'number_of_female_worker')
                                                        @php $t = (int)$t + (int)$data->value @endphp
                                                    @endif
                                                @endforeach
                                                @php echo $t; @endphp
                                            </div>
                                        </div>
                                        <!-- Third div part -->
                                        <div class="main_product_wrap">
                                            <h6>Main Products:</h6>
                                            <div class="main_product_inner">
                                                @foreach(json_decode($businessProfile['company_overview']['data']) as $data)
                                                    @if($data->name == 'main_products')
                                                        @if($data->value == '')
                                                        <h5>No Main Product Found</h5>
                                                        @else
                                                        <h5>{{$data->value}}</h5>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <div class="chatbox_wrap">
                                            {{-- <img src="./images/chat-img.png" alt="">  --}}
                                            <a href="javascript:void(0)">
                                                {{-- <i class="material-icons">chat</i> <!--span>5</span--> --}}
                                                <img src="{{Storage::disk('s3')->url('public/frontendimages/chatbox_iocn.png')}}" alt="Chatbox Iocn">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            {{-- Need to recommend --}}
            @else
                <div class="non_subscriber_message_block_outer">
                    <div class="non-subscribe-message-block">
                        <div class="non-subscribe-block-text">
                            <h4>We have {{count($businessProfiles)}} suppliers matched <br/> with your Quotation.</h4>
                        </div>
                        <div class="new_rfq_subscribe_wrap">
                            <div class="row">
                                <div class="col s12 m5 new_rfq_subscribe_box">
                                    <p>Please subscribe to see the suppliers</p>
                                    <a href="{{route('pricing.plan.form')}}" class="btn_subscribe btn btn_green">Subscribe</a>
                                </div>
                                <div class="col s12 m2">
                                    <div class="or"><span>or</span></div>
                                </div>
                                <div class="col s12 m5 new_rfq_subscribe_box">
                                    <p>Get back to you within 24 hours</p>
                                    <a class="btn_submit_as_guest btn_green btn_rfq_post_next btn_rfq_post modal-trigger right" href="{{ route('home')}}">Submit as Guest</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Need to recommend --}}
                </div>
            @endif
            </div>



        </div>
    </div>

@endsection
@push('js')
    <script type="text/javascript">

        let business_profile_ids = [];
        let business_profile_user_ids = [];
        let business_profiles = [];
        let rfq = {};
        let filter_certs = [];
        let filter_exp = '';
        let filter_name = '';
        let certifications = [];
        const clearFilter = () => {
            filter_certs = [];
            filter_exp = '';
            filter_name = '';
            window.location.reload();
        }
        const filterSupplier = (e,t) => {
            const value = e.toLowerCase();
            if(t == 0){
                filter_name = value;
            }
            if(t == 1){
                console.log(value);
                if(filter_certs.includes(value)){
                    filter_certs = filter_certs.filter((item)=>item != value);
                }else{
                    filter_certs.push(value);
                }

                console.log(filter_certs);
            }
            if(t == 2){
                filter_exp = value;
            }


            let search_by = [...[filter_name],...filter_certs,...[filter_exp]];
            search_by = search_by.filter(i=>i!="");

            let profile_count = 0;
            business_profiles.map(i=>{
                const elms = document.getElementsByName(i['business_name']);
                let certs = '';
                i?.certifications?.map(c=>{
                    certs += '-'+c.title;
                });
                let dd = 0;
                let date =  new Date().getFullYear();
                const year_of_establishment_data = JSON.parse(i?.company_overview?.data||[]);
                year_of_establishment_data?.map(d=>{
                    if(d['name'] == 'year_of_establishment'){
                        dd = date - d['value'];
                    }
                });
                const business_name = i['business_name'];
                const search_field = (business_name + '-' + certs + '-' + dd).toLowerCase();
                for(var k = 0; k < elms.length; k++) {
                    if(search_by){

                        const a = search_by.filter(i=>search_field.includes(i));
                        // business_name certifications years of experience
                        if(a.length == search_by.length){
                            elms[k].style.display='block';
                            profile_count = profile_count + 1;
                        }else{
                            elms[k].style.display='none';
                        }
                    }else{
                        elms[k].style.display='block';
                        profile_count = profile_count + 1;
                    }

                }

            });
            const not_found = document.getElementById('no-supplier-found');
            if(profile_count == 0){
                if(not_found){
                    not_found.style.display = 'block';
                }
            }else{
                if(not_found){
                    not_found.style.display = 'none';
                }
            }
        }
        $(document).ready(function(){

            business_profiles = @json($businessProfiles);
            rfq = @json($rfq);
            if(business_profile_ids.length == 0) {
                $(".request-for-quotation-modal-trigger").attr("disabled", true);
            }
            const certs = [];
            certifications = [];
            business_profiles.map(i=>{
                certifications = [...certifications,...i.certifications];
            });
            certifications.map(i=>{
                const a = certs.filter(b=>b.title == i.title);
                if(a.length == 0){
                    if(i.image){
                        certs.push(i);
                    }
                }
            });
            certifications = certs;
            const rfq_matched_supplier_list_ul = document.getElementById('rfq_matched_supplier_list_ul');
            let ul_html = '';
            certifications.map(i=>{
                ul_html += '<li>'
                        +    '<div class="input-field">'
                        +        '<label>'
                        +            '<input type="checkbox" value="'+i?.title+'" onchange="filterSupplier(this.value,1)" />'
                        +            '<span>'+i?.title+'</span>'
                        +        '</label>'
                        +    '</div>'
                        +'</li>';
            });
            rfq_matched_supplier_list_ul.innerHTML = ul_html;
        });

        const isReadyToSumbit = () =>{
            return business_profile_ids.length>0;
        }
        const showBusinessProfileCount = (len) => {
            document.getElementById('request-for-quotation-from-rfq-profile-count').innerHTML = len + ' suppliers?';
            $(".supplier-matched-selected-box").html(business_profile_ids.length+" Suppliers Selected");

        }
        const onRequestSubmit = () => {
            var xmlHttp = new XMLHttpRequest();
            // xmlHttp.open( "GET", "http://127.0.0.1:8000/rfq/submit-matched-suppleirs/"+business_profile_user_ids.join(','), false ); // false for synchronous request
            // xmlHttp.send( null );
            var redirect_url = '{{ route("rfq.submit-matched-suppleirs", ":slug") }}';

            redirect_url = redirect_url.replace(':slug', JSON.stringify({rfq_id:rfq['id'],business_profile_ids:business_profile_ids}));
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
        }
        const onSelectAll = (e) => {

            if(e?.checked){
                business_profiles.map(i=>{

                    business_profile_ids.push(i['id']);
                    business_profile_user_ids.push(i['user_id']);
                    const card = document.getElementById(""+i['id']+"");
                    card.checked = true;
                });
                business_profile_ids = business_profile_ids.filter((i,index)=> business_profile_ids.indexOf(i)==index);
                business_profile_user_ids = business_profile_user_ids.filter((i,index)=> business_profile_user_ids.indexOf(i)==index);
            } else {
                business_profiles.map(i=>{
                    const card = document.getElementById(""+i['id']+"");
                    card.checked = false;
                });
                business_profile_ids = [];
                business_profile_user_ids = [];

            }
            showBusinessProfileCount(business_profile_ids.length);
            if(business_profile_ids.length == 0) {
                $(".request-for-quotation-modal-trigger").attr("disabled", true);
            } else {
                $(".request-for-quotation-modal-trigger").attr("disabled", false);
            }
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
            $(".supplier-matched-selected-box").html(business_profile_ids.length+" Suppliers Selected");
            console.log('business_profile_ids',business_profile_ids);
            console.log('business_profile_user_ids',business_profile_user_ids);

        }
    </script>

    <script>
        function supplierlistTrigger() {
            var element = document.getElementById("rfqMatchedSupplierlist");
            element.classList.toggle("supplierlist");
        }
    </script>
@endpush
