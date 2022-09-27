
@php $i = 1; @endphp
	@foreach ($rfqLists as $rfqSentList)
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
						<a class="btn_green btn_share" href="javascript:void(0);" onclick= "openShareModel('{{$rfqSentList['id']}}')"> <i class="material-icons"> share </i> <span>Share</span></a>
					</div>
				</div>
			</div>

			<div class="rfq_view_detail_wrap">
				<h5>{{$rfqSentList['title']}}</h5>
				<span class="short_description">{{$rfqSentList['short_description']}}</span>
				<button class="none_button btn_view_detail"  data-rfqId="{{$rfqSentList['id']}}" id="rfqViewDetail">Show More</button>

				<div class="rfq_view_detail_info" style="display: none;">
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
				@if(count($rfqSentList['images'])>0)
						@foreach ($rfqSentList['images'] as  $key => $rfqImage )
							<div class="rfq_thum_img">
								<a data-fancybox="gallery-{{$i}}" href="{{$rfqImage['image']}}">
									<img src="{{$rfqImage['image']}}" alt="" />
								</a>
							</div>
                    @endforeach
                @endif
			</div>

                <div class="responses_wrap right-align">
                    @if(auth::check())
                        @if($rfqSentList['isProposalSent'] == true)
                            <a href="javascript:void(0);" class="bid_rfq" onclick="openBidRfqModal('{{$rfqSentList['id']}}', '{{$rfqSentList['unit']}}');">Replied</a>
                        @else
                            <a href="javascript:void(0);" class="bid_rfq" onclick="openBidRfqModal('{{$rfqSentList['id']}}', '{{$rfqSentList['unit']}}');">Reply on this RFQ</a>
                        @endif
                    @else
                        <a href="#login-register-modal" itemprop="Login / Register" class="modal-trigger">Reply on this RFQ</a>
                    @endif
                    <button class="none_button btn_responses" id="rfqResponse" >
                        Responses <span class="respons_count  res_count_{{$rfqSentList['id']}}_">{{$rfqSentList['responseCount']}}</span>
                    </button>

                </div>

		</div>
	</div>
	@php $i++; @endphp
	@endforeach
