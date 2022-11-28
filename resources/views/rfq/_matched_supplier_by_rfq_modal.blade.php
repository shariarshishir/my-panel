<div class="new_rfq_supplier_outer_wrapper">
    <div class="card new_rfq_supplier_product_info">
        <div class="row">
            <h4 id="modal-rfq-title"></h4>
            <div class="rfq_posted_time" id="modal-rfq-created-at"></div>
            <div class="col s12 m2">
                <label>Product Type</label>
                <p id="modal-rfq-product-type"></p>
            </div>
            <div class="col s12 m2">
                <label>Product Tags</label>
                <p id="modal-rfq-category-tags"></p>
            </div>
            <div class="col s12 m2">
                <label>Quantity</label>
                <p id="modal-rfq-quantity"></p>
            </div>
            <div class="col s12 m2">
                <label>Target Price</label>
                <p id="modal-rfq-unit-price"></p>
            </div>
            <div class="col s12 m2">
                <label>Delivery In</label>
                <p id="modal-rfq-delivery-time"></p>
            </div>
            <div class="col s12 m2">
                <label>Delivery To</label>
                <p id="modal-rfq-destination"></p>
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
                        <div class="supplier-matched-count-box" id="supplier-matched-total-count"></div>
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
                <div class="new_rfq_filter_wrap">
                    <div class="new_rfq_filter_select">
                        {{-- <div class="new_rfq_filter_wrap">
                            <div class="input-field">
                                <label>
                                    <input type="checkbox" id="select-all-supplier" name="select-all-supplier" onclick='onSelectAll(this)'/>
                                    <span>Select All</span>
                                </label>
                            </div>
                        </div> --}}
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
                {{-- <div class="filter_clear_all">
                    <a href="javascript:void(0);" class="btn btn_clear_all" onclick="clearFilter();">All Clear<i class="material-icons">clear_all</i></a>
                </div> --}}
                <div class="request_quotation_wrap">
                    <div class="request_for_quotation">
                        <button href="javascript:void(0)" class="btn btn_green" id="send-request-again-for-rfq" onclick="onRequestSubmit()" style="display:none;">Send Request</button>
                        <a class="btn_request_quotation waves-effect waves-light btn request-for-quotation-modal-trigger" id="request-for-quotation-from-rfq-button" href="javascript:void(0)" onclick="putSupplierList()">Request More</a>
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
                        <div id="matched-supplier-list"></div>
                    </div>
                </div>
            </div>
        {{-- Need to recommend --}}
        @else
            <div class="non-subscribe-message-block">
                <div class="non-subscribe-block-text">
                    <h4 id="business-profile-count-total" style="color: #fff;"></h4>
                </div>
                <div class="new_rfq_subscribe_wrap">
                    <div class="row">
                        <div class="col s12 m12">
                            <p>Please subscribe to see the suppliers</p>
                            <a href="{{route('pricing.plan.form')}}" class="btn_subscribe btn btn_green">Subscribe</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Need to recommend --}}
        @endif
        </div>



    </div>
</div>

@push('js')
    <script type="text/javascript">

        let business_profile_ids = [];
        let business_profile_user_ids = [];
        let business_profiles = [];
        let certifications = [];
        let rfq = {};
        let check_status = false;
        let filter_certs = [];
        let filter_exp = '';
        let filter_name = '';
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
        const isReadyToSumbit = () =>{
            return business_profile_ids.length>0;
        }
        const showBusinessProfileCount = (len) => {
            document.getElementById('request-for-quotation-from-rfq-profile-count').innerHTML = len + ' suppliers?';
            $(".supplier-matched-selected-box").html(business_profile_ids.length+" Suppliers Selected");

        }
        const getBusinessProfileLogo = (businessProfile) => {
            if(businessProfile?.user?.image == null){
                return "https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/no-image.png";
            }else{
                return "https://s3.ap-southeast-1.amazonaws.com/service.products/public/"+businessProfile?.user?.image;
            }
        }
        const getCertifications = (businessProfile) => {
            const data = businessProfile?.certifications || [];
            let imgs = [];
            data.map(cert=>{
                if(cert['image']!=null){
                    imgs.push('https://s3.ap-southeast-1.amazonaws.com/service.products/public/'+cert['image']);
                }

            });

            let v = '<div class="inner_content_image suppliers_certificates_list">';
            imgs.map(i=>{
                v += '<img class="" src="'+i+'" alt="">'
            });


            v+='</div>';
            return imgs.length == 0 ? '<p>No Certifications Found</p>' : v;
        }
        const getYearOfExperiance = (businessProfile) => {

            let date =  new Date().getFullYear();
            let dd = 0;
            const data = JSON.parse(businessProfile['company_overview']?.data) || [];
            data?.map(d=>{
                if(d['name'] == 'year_of_establishment'){
                    dd = date - d['value'];
                }
            });
            return dd || 0;
        }
        const getMainProducts = (businessProfile) => {
            const data = JSON.parse(businessProfile['company_overview']?.data) || [];
            const dd = [];
            data?.map(d=>{
                if(d['name'] == 'main_products'){
                    dd.push(d['value']);
                }
            });
            return dd.length == 0 ? 'No main Products found.' : dd.join(',');
        }
        const putSupplierList = () => {
            const content = document.getElementById('matched-supplier-list');
            check_status = !check_status;
            if(!check_status){
                document.getElementById("send-request-again-for-rfq").style.display = 'block';
                document.getElementById("send-request-again-for-rfq").disabled = true;
            }else{
                document.getElementById("send-request-again-for-rfq").style.display = 'none';
            }

            if(content){
                var myvar = '';

                business_profiles.map(businessProfile=>{
                    if(check_status){
                        if(business_profile_ids.includes(businessProfile?.id)){
                            myvar += '<div class="col s12 m6 l4 matched_supplier_item" name="'+businessProfile?.business_name+'">'+
        '						<div class="match_supplier_rfq_single_content">'+
        '							<div class="input-field">'+
        '								<label>'+
        '								<input type="checkbox" checked id="'+businessProfile.id+'" user_id="'+businessProfile.user_id+'" name="remember" onclick="onProfileSelected(this)">'+
        '								<span></span>'+
        '								</label>'+
        '							</div>'+
        '							<div class="match_supplier_rfq_single_content_inner_part">'+
        '								<!-- First div part -->'+
        '								<div class="row sparkle_part">'+
        '									<div class="col s12 m3">'+
        '										<div class="image_width_wrap">'+
        '											<img class="image_width" src="'+getBusinessProfileLogo(businessProfile)+'" alt="avatar" itemprop="img">'+
        '										</div>'+
        '									</div>'+
        '									<div class="col s12 m6">'+
        '										<h3>'+businessProfile?.business_name+'</h3>'+
        '										<span class="location">'+businessProfile?.location+'</span>'+
        '									</div>'+
        '									<div class="col s12 m3">'+
        '										<div class="middle_wrap">'+
        '											<span class="check_circle">'+
        '											<i class="material-icons">check_circle</i>'+
        '											</span>'+
        '											<span class="icon_wrap">'+
        '											'+getYearOfExperiance(businessProfile)+' Y'+
        '											</span>'+
        '										</div>'+
        '									</div>'+
        '								</div>'+
        '								<!-- Second div part -->'+
        '								<div class="middle_part_image_wrapper">'+
        '									<h6>Certification:</h6>'+
                                            getCertifications(businessProfile)+
        '								</div>'+
        '								<!-- Third div part -->'+
        '								<div class="main_product_wrap">'+
        '									<h6>Main Products:</h6>'+
        '									<div class="main_product_inner">'+
        '										<p>'+getMainProducts(businessProfile)+'</p>'+
        '									</div>'+
        '								</div>'+
        '								<div class="chatbox_wrap">'+
        '									<a href="javascript:void(0)">'+
        '										<img src="{{Storage::disk('s3')->url('public/frontendimages/chatbox_iocn.png')}}" alt="Chatbox Iocn"> <!--span>5</span-->' +
        '									</a>'+
        '								</div>'+
        '							</div>'+
        '						</div>'+
        '					</div>';
                        }
                    }else{
                        if(!business_profile_ids.includes(businessProfile?.id)){
                            myvar += '<div class="col s12 m6 l4 matched_supplier_item" name="'+businessProfile?.business_name+'">'+
        '						<div class="match_supplier_rfq_single_content">'+
        '							<div class="input-field">'+
        '								<label>'+
        '								<input type="checkbox" id="'+businessProfile.id+'" user_id="'+businessProfile.user_id+'" name="remember" onclick="onProfileSelected(this)">'+
        '								<span></span>'+
        '								</label>'+
        '							</div>'+
        '							<div class="match_supplier_rfq_single_content_inner_part">'+
        '								<!-- First div part -->'+
        '								<div class="row sparkle_part">'+
        '									<div class="col s12 m3">'+
        '										<div class="image_width_wrap">'+
        '											<img class="image_width" src="'+getBusinessProfileLogo(businessProfile)+'" alt="avatar" itemprop="img">'+
        '										</div>'+
        '									</div>'+
        '									<div class="col s12 m6">'+
        '										<h3>'+businessProfile?.business_name+'</h3>'+
        '										<span class="location">'+businessProfile?.location+'</span>'+
        '									</div>'+
        '									<div class="col s12 m3">'+
        '										<div class="middle_wrap">'+
        '											<span class="check_circle">'+
        '											<i class="material-icons">check_circle</i>'+
        '											</span>'+
        '											<span class="icon_wrap">'+
        '											'+getYearOfExperiance(businessProfile)+' Y'+
        '											</span>'+
        '										</div>'+
        '									</div>'+
        '								</div>'+
        '								<!-- Second div part -->'+
        '								<div class="middle_part_image_wrapper">'+
        '									<h6>Certification:</h6>'+
                                            getCertifications(businessProfile)+
        '								</div>'+
        '								<!-- Third div part -->'+
        '								<div class="main_product_wrap">'+
        '									<h6>Main Products:</h6>'+
        '									<div class="main_product_inner">'+
        '										<p>'+getMainProducts(businessProfile)+'</p>'+
        '									</div>'+
        '								</div>'+
        '								<div class="chatbox_wrap">'+
        '									<a href="javascript:void(0)">'+
        '										<img src="{{Storage::disk('s3')->url('public/frontendimages/chatbox_iocn.png')}}" alt="Chatbox Iocn"> <!--span>5</span-->' +
        '									</a>'+
        '								</div>'+
        '							</div>'+
        '						</div>'+
        '					</div>';
                        }
                    }

                });
            }
            content.innerHTML = myvar;
        }

        var dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
        const updateRFQHeader = (rfq) => {
            document.getElementById('modal-rfq-title').innerHTML = rfq['title'];
            document.getElementById('modal-rfq-created-at').innerHTML = '<i class="material-icons">access_time</i> ' + new Date(rfq['created_at']).toLocaleDateString("en-US", dateOptions);
            document.getElementById('modal-rfq-product-type').innerHTML = rfq['industry'];
            let tags = [];
            rfq['category']?.map(i=>{
                tags.push(i['name']);
            })
            document.getElementById('modal-rfq-category-tags').innerHTML = tags.join(',');
            document.getElementById('modal-rfq-quantity').innerHTML = rfq['quantity'];
            document.getElementById('modal-rfq-unit-price').innerHTML = rfq['unit_price'];
            document.getElementById('modal-rfq-delivery-time').innerHTML = rfq['delivery_time'];
            document.getElementById('modal-rfq-destination').innerHTML = rfq['destination'];

        }

        const loadSupplierList = (rfq_id) => {
            var redirect_url = '{{ route("rfq.matched-suppleirs-modal", ":slug") }}';
            redirect_url = redirect_url.replace(':slug', rfq_id);
            var url = redirect_url;
            business_profiles = [];
            certifications = [];
            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then((response) => {
                response.text().then(data=>{
                    const d = JSON.parse(data);
                    if(d?.businessProfiles){
                        check_status = false;
                        business_profiles = d.businessProfiles;
                        const supplier_matched_total_count = document.getElementById('supplier-matched-total-count');
                        if(supplier_matched_total_count){
                            supplier_matched_total_count.innerHTML = (business_profiles?.length || 0) + " Suppliers Found";
                        }
                        const select_all_supplier = document.getElementById('select-all-supplier');
                        if(select_all_supplier){
                            select_all_supplier.checked = false;
                        }
                        updateRFQHeader(d?.rfq);
                        business_profile_ids = d?.rfq?.selected_business_profiles || [];
                        rfq = d?.rfq;
                        showBusinessProfileCount(business_profile_ids.length);
                        putSupplierList();
                    }
                    const business_profile_count_total = document.getElementById('business-profile-count-total');
                    if(business_profile_count_total){
                        business_profile_count_total.innerHTML = "We have "+(business_profiles?.length||0)+" suppliers matched <br/> with your Quotation."
                    }
                    business_profiles.map(i=>{
                        certifications = [...certifications,...i.certifications];
                    });
                    const certs = [];
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
                })
            });
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
                    putSupplierList();
                    const msg = "Supplier selected successfully";
                    swal("Done!", msg,"success");
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
            // if(business_profile_ids.length == 0) {
            //     $(".request-for-quotation-modal-trigger").attr("disabled", true);
            // } else {
            //     $(".request-for-quotation-modal-trigger").attr("disabled", false);
            // }
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
            // if(business_profile_ids.length == 0) {
            //     $(".request-for-quotation-modal-trigger").attr("disabled", true);
            // } else {
            //     $(".request-for-quotation-modal-trigger").attr("disabled", false);
            // }
            if(isReadyToSumbit()){
                console.log('business_profile_ids.length',business_profile_ids.length)
                showBusinessProfileCount(business_profile_ids.length);
                //$("#request-for-quotation-from-rfq").modal('show');
            }else{
                //$("#request-for-quotation-from-rfq").modal('hide');
            }
            $(".supplier-matched-selected-box").html(business_profile_ids.length+" Suppliers Selected");
            document.getElementById("send-request-again-for-rfq").disabled = false;
        }
    </script>


    <script>
        function supplierlistTrigger() {
            var element = document.getElementById("rfqMatchedSupplierlist");
            element.classList.toggle("supplierlist");
        }
    </script>
@endpush
