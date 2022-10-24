<div id="details-rfq-modal-{{$rfqSentList['id']}}" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="rfq_profile_detail">
            <!-- <div class="col s12 m3 l2">
                <div class="rfq_profile_img">
                    @if(isset($rfqSentList['user']['image']))
                    <img src="{{ asset('storage/'.$rfqSentList['user']['image']) }}" alt="" />
                    @else
                    <img src="{{asset('images/frontendimages/no-image.png')}}" alt="avatar">
                    @endif
                </div>
            </div> -->
            <div class="rfq_profile_info">
                <div class="row">
                    <div class="profile_info col s12 m8 l8">
                        <h4>
                            {{ $rfqSentList['user']['user_name']}}
                            @if(isset($rfqSentList->businessProfile->is_business_profile_verified))
                            <img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/verified.png')}}" alt="" />
                            @endif
                        </h4>
                        <!--p>Fashion Tex Ltd.</p-->
                    </div>

                    <div class="profile_view_time right-align col s12 m4 l4">
                        <div style="float: right;" class="rfq_share_box">
                            <a class="btn_green btn_share" href="javascript:void(0);" onclick="openShareModel('{{$rfqSentList['id']}}')"> <i class="material-icons"> share </i> <span>Share</span></a>
                        </div>
                    </div>
                </div>

                <div class="rfq_view_detail_wrap">
                    <h5>{{$rfqSentList['title']}}</h5>
                    <span class="short_description">{{$rfqSentList['short_description']}}</span>

                    <div class="rfq_view_detail_info">
                        @php
                            $category_list=[];
                        @endphp
                        @foreach ($rfqSentList['category'] as  $cat)
                            @php
                                array_push($category_list, $cat['name']);
                            @endphp
                        @endforeach
                        <h6>Query for {{implode(",",$category_list);}}</h6>
                        <div class="full_specification"><span class="title">Details:</span> {{$rfqSentList['full_specification']}}</div>
                        <div class="full_details">
                            <span class="title">Qty:</span> {{$rfqSentList['quantity']}} {{$rfqSentList['unit']}},
                            @if($rfqSentList['unit_price']==0.00)
                            <span class="title">Target Price:</span> N/A,
                            @else
                            <span class="title">Target Price:</span> $ {{$rfqSentList['unit_price']}},
                            @endif
                            <span class="title">Deliver to:</span> {{$rfqSentList['destination']}},
                            <span class="title">Within:</span> {{ date('F j, Y',strtotime($rfqSentList['delivery_time'])) }},
                            <span class="title">Payment method:</span> {{$rfqSentList['payment_method']}} </p>
                        </div>
                    </div>
                </div>

                <div class="row rfq_thum_imgs left-align">
                    @if(count($rfqSentList['images']) > 0)
                        @foreach ($rfqSentList['images'] as  $key => $rfqImage )
                            @if( pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'png' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'PNG' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'JPEG' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'JPG')
                            <div class="imgBox rfq_thum_img">
                                <img src="{{ $rfqImage['image'] }}" class="rfqImage" alt="">
                            </div>
                            @elseif( pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'pdf' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'PDF')
                            <div class="imgBox rfq_thum_img">
                                <a href="{{$rfqImage['image']}}">
                                    <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/new_layout_images/pdf-bg.png" class="rfqFileImage" alt="">
                                </a>
                            </div>
                            @elseif( pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'doc' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'DOC' ||  pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'docx') || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'DOCX')
                            <div class="imgBox rfq_thum_img">
                                <a href="{{$rfqImage['image']}}">
                                    <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/new_layout_images/doc-bg.png" class="rfqFileImage" alt="">
                                </a>
                            </div>
                            @elseif( pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'xlsx' || pathinfo($rfqImage['image'], PATHINFO_EXTENSION) == 'XLSX' )
                            <div class="imgBox rfq_thum_img">
                                <a href="{{$rfqImage['image']}}">
                                    <img src="https://s3.ap-southeast-1.amazonaws.com/service.products/public/frontendimages/new_layout_images/excel-bg.png" class="rfqFileImage" alt="">
                                </a>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="responses_box_wrap">
                <div class="row">
                    <div class="col s12 m6 right">
                        <div class="responses_wrap right-align">
                            {{-- <a href="javascript:void(0);" class="bid_rfq">Reply on this RFQ</a> --}}
                            <button class="none_button btn_responses" id="rfqResponse" >
                                Responses <span class="respons_count">{{$rfqSentList['responseCount']}}</span>
                            </button>
                        </div>
                    </div>
                    <div class="col s12 m6 left">
                        @if($rfqSentList['status'] == 'pending')
                            <div class="responses_wrap_right left-align">
                                <p>* Waiting for admin approval</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
