@extends('layouts.app')

@section('content')

<!-- <div>
    <a class="waves-effect waves-light btn modal-trigger" href="#create-rfq-form">Create Rfq</a>
</div> -->
@include('rfq._create_rfq_form_modal')
<div id="errors">

</div>

<!-- RFQ html start -->

<div class="box_shadow_radius rfq_content_box">
    <form action="{{route('rfq.my')}}" method="get" id="rfq_filter_form">
        @php $filter_type = array_key_exists('filter', app('request')->input())?app('request')->input('filter'):'';@endphp
        <div class="rfq_info_wrap right-align rfq_top_navbar">
            <ul>
                <li class="rfq_filter_select">
                    <select class="btn_grBorder" name="filter" id="rfq_filter">
                        <option value="" disabled selected>Choose your option</option>
                        <option value="all" {{$filter_type == 'all' ? 'selected' : ''}}>All</option>
                        <option value="active"  {{$filter_type == 'active' || $filter_type == ''  ? 'selected' : ''}}>Active</option>
                        <option value="inactive" {{$filter_type == 'inactive' ? 'selected' : ''}}>Inactive</option>
                    </select>
                </li>
                <li class="{{ Route::is('rfq.index') ? 'active' : ''}}"><a href="{{route('rfq.index')}}" class="btn_grBorder">RFQ Home</a></li>
                <li class="{{ Route::is('rfq.my') ? 'active' : ''}}"><a href="{{route('rfq.my')}}" class="btn_grBorder">My RFQs</a></li>
                <li style="display: none;"><a href="javascript:void(0);" class="btn_grBorder">Saved RFQs</a></li>
                <li><a class="btn_grBorder modal-trigger" href="#create-rfq-form">Create Rfq</a></li>
            </ul>
        </div>
    </form>
	<!--div class="rfq_day_wrap center-align"><span>Today</span></div-->
    @if(count($rfqLists)>0)
    @php $i = 1; @endphp
    @php $x = 1; @endphp
	@foreach ($rfqLists as $rfqSentList)
	<div class="rfq_profile_detail row">
		<div class="col s12 m3 l2">
			<div class="rfq_profile_img">
				@if($rfqSentList->user->image)
				<img src="{{ asset('storage/'.$rfqSentList->user->image) }}" alt="" />
				@else
				<img src="{{asset('images/frontendimages/no-image.png')}}" alt="avatar">
				@endif
			</div>
		</div>
        <div style="float: right;" class="rfq_share_box">
            @if($rfqSentList->deleted_at == null)
                <a class="btn_green btn_share" href="javascript:void(0);" onclick= "openShareModel({{$rfqSentList->id}})" ><i class="material-icons"> share </i> <span>Share</span></a>
            @endif
                <a href="javascript:void(0);" class="btn_rfq_edit"  onclick="editRfq({{$rfqSentList->id}});"><i class="material-icons">border_color</i></a>
        </div>
		<div class="col s12 m9 l10 rfq_profile_info">
			<div class="row">
				<div class="profile_info col s12 m8 l8">
					<h4>{{ $rfqSentList->user->name}}<img src="{{asset('images/frontendimages/new_layout_images/verified.png')}}" alt="" /> </h4>
					<p>Merchandiser, Fashion Tex Ltd.</p>
				</div>
				<!--div class="profile_view_time right-align col s12 m4 l4">
					<span> <i class="material-icons"> watch_later </i> 35 mins</span>
				</div-->
			</div>

                    <div class="rfq_view_detail_wrap">
                        <h5>{{$rfqSentList->title}} <span class="{{$rfqSentList->deleted_at ? 'btn_rfq_inactive' : 'green_active' }}">{{$rfqSentList->deleted_at ? '(Inactive)' : '(Active)' }}</span></h5>
                        <span class="short_description">{{$rfqSentList->short_description}}</span>
                        <button class="none_button btn_view_detail" id="rfqViewDetail">Show More</button>
                        <div class="rfq_view_detail_info" style="display: none;">
                            <h6>Query for {{$rfqSentList->category->name}}</h6>
                            <div class="full_specification"><span class="title">Details:</span> {{$rfqSentList->full_specification}} </div>
                            <div class="full_details">
                                <span class="title">Qty:</span> {{$rfqSentList->quantity}} {{$rfqSentList->unit}},
                                @if($rfqSentList->unit_price==0.00)
                                <span class="title">Target Price:</span> N/A,
                                @else
                                <span class="title">Target Price:</span> $ {{$rfqSentList->unit_price}},
                                @endif
                                <span class="title">Deliver to:</span>  {{$rfqSentList->destination}},
                                <span class="title">Within:</span> {{ date('F j, Y',strtotime($rfqSentList->delivery_time)) }},
                                <span class="title">Payment method:</span> {{$rfqSentList->payment_method}} </p>
                            </div>
                        </div>
                    </div>


                    <!-- <p>{{$rfqSentList->title}}</p>
                    <p>{{$rfqSentList->short_description}}</p> -->
                    <!--div class="tagS">
                        <a href="javascript:void(0);"> #Sweater</a> <a href="javascript:void(0);"> #Apparel</a>
                    </div-->
                    <div class="row rfq_thum_imgs left-align">

                        @if($rfqSentList->images()->exists())
                            @foreach ($rfqSentList->images as  $key => $rfqImage )
                                @if(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'pdf' || pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'PDF')
                                    <div class="rfq_thum_img">
                                        <a href="{{ asset('storage/'.$rfqImage->image) }}" class="pdf_icon" target="_blank">&nbsp; PDF</a>
                                    </div>
                                @elseif(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'doc' || pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'docx')
                                    <div class="rfq_thum_img">
                                        <a href="{{ asset('storage/'.$rfqImage->image) }}" class="doc_icon" >&nbsp; DOC</a>
                                    </div>
                                @elseif(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'xlsx')
                                    <div class="rfq_thum_img">
                                        <a href="{{ asset('storage/'.$rfqImage->image) }}" class="xlsx_icon" >&nbsp; XLSX</a>
                                    </div>
                                @elseif(pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'TAR'|| pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'tar'|| pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'rar'|| pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'RAR' ||pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'zip' || pathinfo($rfqImage->image, PATHINFO_EXTENSION) == 'ZIP')
                                <div class="rfq_thum_img">
                                    <a href="{{ asset('storage/'.$rfqImage->image) }}" class="zip_icon" >&nbsp; DOC</a>
                                </div>
                                @else
                                    <div class="rfq_thum_img">
                                        <a data-fancybox="gallery-{{$i}}" href="{{asset('storage/'.$rfqImage->image)}}">
                                            <img src="{{asset('storage/'.$rfqImage->image)}}" alt="" />
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                    </div>

                    <!-- <div class="rfq_view_detail_wrap center-align">
                        <button class="none_button btn_view_detail" onclick="myFunction()" id="rfqViewDetail">View Detail</button>
                        <div class="rfq_view_detail_info" style="display: none;">
                            <h6>Query for {{$rfqSentList->category->name}}</h6>
                            <table class="detail_table">
                                <tbody>
                                    <tr>
                                        <td>Details:</td>
                                        <td>{{$rfqSentList->full_specification}}</td>
                                    </tr>
                                    <tr>
                                        <td>Qty:</td>
                                        <td>{{$rfqSentList->quantity}} {{$rfqSentList->unit}}</td>
                                    </tr>
                                    <tr>
                                        <td>Target price:</td>
                                        <td>$ {{$rfqSentList->unit_price}}</td>
                                    </tr>
                                    <tr>
                                        <td>Deliver to:</td>
                                        <td>{{$rfqSentList->destination}}</td>
                                    </tr>
                                    <tr>
                                        <td>Within:</td>
                                        <td>{{ date('F j, Y',strtotime($rfqSentList->delivery_time)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment method:</td>
                                        <td>{{$rfqSentList->payment_method}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                    <div class="responses_wrap right-align">
                        <!--span><i class="material-icons">favorite</i> Saved</span-->
                        {{-- <a href="javascript:void(0);" class="bid_rfq" onclick="openBidRfqModal({{$rfqSentList->id}})">Reply on this RFQ</a> --}}

                        <button class="none_button btn_responses btn_responses_trigger" data-rfqId="{{$rfqSentList->id}}" id="rfqResponse">
                            Responses <span class="respons_count">{{$rfqSentList->bids_count}}</span>
                            @if(in_array($rfqSentList->id,$rfqsWithNewBid))<span class="new-bid-reply-badge">New</span>@endif
                        </button>
                        @if($rfqSentList->bids()->exists())
                        <div class="respones_detail_wrap" style="display: none;">
                            <div class="responses_open">&nbsp;</div>
                                @foreach ($rfqSentList->bids as $bid)

                                    <div class="row respones_box">
                                        <div class="col s12 m3 l2">
                                            <div class="rfq_profile_img">
                                                @if(auth()->user()->image)
                                                <img src="{{ asset('storage/'.auth()->user()->image) }}" alt="avatar">
                                                @else
                                                <img src="{{asset('images/frontendimages/no-image.png')}}" alt="avatar">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col s12 m9 l10 rfq_profile_info">
                                            <div class="row">
                                                <div class="col s12 l7 profile_info">
                                                    <h4>{{$bid->businessProfile->business_name}} </h4>
                                                    <p>{{$bid->businessProfile->business_type == 1 ? 'Manufacture' : 'Wholesalser'}}</p>
                                                </div>
                                                @if(Auth::guard('web')->check())
                                                    <div class="col s12 l5 right-align"><a href="javascript:void(0);" class="ic-btn btn_green" onClick="contactSupplierFromProduct({{ $bid->id }}); updateUserLastActivity('{{Auth::id()}}', '{{$bid->supplier_id}}'); sendmessage('{{$bid->rfq->title}}','{{$bid->rfq->quantity}}','{{$bid->rfq->unit}}','{{$bid->rfq->unit_price}}','{{$bid->rfq->quantity*$bid->rfq->unit_price}}','{{$bid->rfq->payment_method}}','{{$bid->rfq->delivery_time}}','{{strip_tags($bid->rfq->short_description)}}','{{$bid->supplier_id}}','{{$bid->businessProfile->business_name}}','{{$bid->unit_price}}')">Contact Supplier</a></div>
                                                @else
                                                    <div class="col s12 l5 right-align"><a href="javascript:void(0);" class="ic-btn btn_green">Contact Supplier</a></div>
                                                @endif

                                            </div>

                                            <div class="full_specification"><span class="title">Description:</span> {!! $bid->description !!} </div>
                                            <div class="full_details">
                                                <span class="title">Offer Price:</span> ${{$bid->unit_price}}/pc
                                                <!--<span class="title">Quantity:</span> {{$bid->quantity}},
                                                <span class="title">Unit Price:</span> {{$bid->unit_price}},
                                                <span class="title">Total Price:</span>  {{$bid->total_price}},
                                                <span class="title">Payment Method:</span> {{$bid->payment_method}},
                                                <span class="title">Delivery Time:</span> {{$bid->delivery_time}}-->
                                            </div>

                                            <!-- <p>Description: {{$bid->description}}</p>
                                            <p>Quantity: {{$bid->quantity}}</p>
                                            <p>Unit Price: {{$bid->unit_price}}</p>
                                            <p>Total Price: {{$bid->total_price}}</p>
                                            <p>Payment Method: {{$bid->payment_method}}</p>
                                            <p>Delivery Time: {{$bid->delivery_time}}</p> -->

                                             <!--<div class="respones_img_wrap">
                                                @if(isset($bid->media))
                                                    @foreach (json_decode($bid->media) as $image)
                                                        <div class="respones_img">
                                                            {{-- <a data-fancybox="bidgallery-{{$x}}" href="{{asset('storage/'.$image)}}">
                                                                <img src="{{asset('storage/'.$image)}}" alt="">
                                                            </a> --}}
                                                            @if(pathinfo($image, PATHINFO_EXTENSION) == 'pdf' || pathinfo($image, PATHINFO_EXTENSION) == 'PDF')
                                                                <div class="rfq_thum_img">
                                                                    <a href="{{ asset('storage/'.$image) }}" class="pdf_icon" target="_blank">&nbsp; PDF</a>
                                                                </div>
                                                            @elseif(pathinfo($image, PATHINFO_EXTENSION) == 'doc' || pathinfo($image, PATHINFO_EXTENSION) == 'docx')
                                                                <div class="rfq_thum_img">
                                                                    <a href="{{ asset('storage/'.$image) }}" class="doc_icon" >&nbsp; DOC</a>
                                                                </div>
                                                            @elseif(pathinfo($image, PATHINFO_EXTENSION) == 'xlsx')
                                                                <div class="rfq_thum_img">
                                                                    <a href="{{ asset('storage/'.$image) }}" class="xlsx_icon" >&nbsp; XLSX</a>
                                                                </div>
                                                            @elseif(pathinfo($image, PATHINFO_EXTENSION) == 'TAR'|| pathinfo($image, PATHINFO_EXTENSION) == 'tar'|| pathinfo($image, PATHINFO_EXTENSION) == 'rar'|| pathinfo($image, PATHINFO_EXTENSION) == 'RAR' ||pathinfo($image, PATHINFO_EXTENSION) == 'zip' || pathinfo($image, PATHINFO_EXTENSION) == 'ZIP')
                                                            <div class="rfq_thum_img">
                                                                <a href="{{ asset('storage/'.$image) }}" class="zip_icon" >&nbsp; DOC</a>
                                                            </div>
                                                            @else
                                                                <div class="rfq_thum_img">
                                                                    <a data-fancybox="bidgallery-{{$x}}" href="{{asset('storage/'.$image)}}">
                                                                        <img src="{{asset('storage/'.$image)}}" alt="" />
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>-->
                                        </div>
                                    </div>
                                @php $x++; @endphp
                                @endforeach
                        </div>
                        @endif
                    </div>

                    <!--div class="respones_detail_wrap">
                        <div class="row respones_box">
                            <div class="col s12 m2 l2">
                                <div class="rfq_profile_img"><img src="images/ic-logo.png" alt=""></div>
                            </div>
                            <div class="col s12 m10 l10 rfq_profile_info">
                                <div class="row">
                                    <div class="col m7 l7 profile_info">
                                        <h4>Sayem Fashion Ltd. <img src="images/verified.png" alt="" /> </h4>
                                        <p>Manufacturer, Sweater</p>
                                    </div>
                                    <div class="col m5 l5 right-align"><a href="" class="btn_white btn_supplier">Contact Supplier</a></div>
                                </div>
                                <p>I need 5000 pieces Full sleeve sweater for women, price US $5/pcs by Sep 28, 2021.</p>
                            </div>
                        </div>
                        <div class="row respones_box">
                            <div class="col s12 m2 l2">
                                <div class="rfq_profile_img"><img src="images/ic-logo.png" alt=""></div>
                            </div>
                            <div class="col s12 m10 l10">
                                <div class="row">
                                    <div class="col m7 l7 profile_info">
                                        <h4>Sayem Fashion Ltd. <img src="images/verified.png" alt="" /> </h4>
                                        <p>Manufacturer, Sweater</p>
                                    </div>
                                    <div class="col m5 l5 right-align"><a href="" class="btn_white btn_supplier">Contact Supplier</a></div>
                                </div>
                                <p>I need 5000 pieces Full sleeve sweater for women, price US $5/pcs by Sep 28, 2021.</p>
                            </div>
                        </div>
                    </div-->

                </div>
            </div>
        @php $i++; @endphp
        @endforeach
    @else
        <div class="card-alert card cyan">
            <div class="card-content white-text">
                <p>INFO : No rfq available.</p>
            </div>
        </div>
    @endif
</div>
<!-- RFQ html end -->

<div class="pagination-block-wrapper">
    <div class="col s12 center">
        {!! $rfqLists->links() !!}
    </div>
</div>
@include('rfq._create_rfq_bid_form_modal')
@include('rfq._edit_rfq_modal')
@include('rfq.share_modal')
@endsection


@include('rfq._scripts')
@push('js')
    <script>

var serverURL = "{{ env('CHAT_URL'), 'localhost' }}:3000";
        var socket = io.connect(serverURL);
        socket.on('connect', function(data) {
        //alert('connect');
        });
        @if(Auth::check())
        function sendmessage(title,quantity,unit,unit_price,total_price,payment_method,delivery_time,description,supplier_id,business_profile_name,bid_unit_price)
        {
        let message = {'message': business_profile_name+' offers: '+bid_unit_price+' / '+unit, 'product': {'title': title,'quantity': quantity,'unit_price': unit_price+" "+unit, 'total_price': total_price, 'payment_method': payment_method, 'delivery_time': delivery_time, 'description': description}, 'from_id' : "{{Auth::user()->id}}", 'to_id' : supplier_id};
        socket.emit('new message', message);
        setTimeout(function(){
            //window.location.href = "/message-center";
            var url = '{{ route("message.center") }}?uid='+supplier_id;
                // url = url.replace(':slug', sku);
                window.location.href = url;
            // window.location.href = "/message-center?uid="+supplier_id;
        }, 1000);
        }

        function updateUserLastActivity(form_id, to_id)
        {
        var form_id = form_id;
        var to_id = to_id;
        var csrftoken = $("[name=_token]").val();

        data_json = {
            "form_id": form_id,
            "to_id": to_id,
            "csrftoken": csrftoken
        }
        var url= '{{route("message.center.update.user.last.activity")}}';
        jQuery.ajax({
            method: "POST",
            url: url,
            headers:{
                "X-CSRF-TOKEN": csrftoken
            },
            data: data_json,
            dataType:"json",

            success: function(data){
                console.log(data);
            }
        });

        }

        function contactSupplierFromProduct(supplierId)
        {

        var supplier_id = supplierId;
        var csrftoken = $("[name=_token]").val();
        var buyer_id = "{{Auth::id()}}";
        data_json = {
            "supplier_id": supplier_id,
            "buyer_id": buyer_id,
            "csrftoken": csrftoken
        }
        var url='{{route("message.center.contact.supplier.from.product")}}';
        jQuery.ajax({
            method: "POST",
            url:url,
            headers:{
                "X-CSRF-TOKEN": csrftoken
            },
            data: data_json,
            dataType:"json",
            success: function(data){
                console.log(data);
            }
        });

        /*
        let message = {'message': 'Hi I would like to discuss More about your Product', 'product': null, 'from_id' : "{{Auth::user()->id}}", 'to_id' : supplierId};
        socket.emit('new message', message);
        setTimeout(function(){
            window.location.href = "/message-center?uid="+supplierId;
        }, 1000);
        */
        }

        function sendsamplemessage(productId,productTitle,productCategory,moq,qtyUnit,pricePerUnit,priceUnit,productImage,createdBy)
        {
        let message = {'message': 'We are Interested in Your Product ID:mb-'+productId+' and would like to discuss More about the Product', 'product': {'id': "MB-"+productId,'name': productTitle,'category': productCategory,'moq': moq,'price': priceUnit+" "+pricePerUnit, 'image': productImage}, 'from_id' : "{{Auth::user()->id}}", 'to_id' : createdBy};
        socket.emit('new message', message);
        setTimeout(function(){
            window.location.href = "/message-center";
        }, 1000);
        }
        @endif




        //edit
        function editRfq(rfq_id){
            var url = '{{ route("rfq.edit", ":slug") }}';
            url = url.replace(':slug', rfq_id);
            $.ajax({
                    method: 'get',
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: url,
                    beforeSend: function() {
                    $('.loading-message').html("Please Wait.");
                    $('#loadingProgressContainer').show();
                    },
                    success:function(data)
                        {
                            // $('#seller_product_form_update')[0].reset();
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();
                            $('#edit-rfq-form').modal('open');

                            $('#edit-rfq-form  input[name=edit_rfq_id]').val(data.data.id);
                            $('#edit-rfq-form #category_id').val(data.data.category_id);
                            $('#edit-rfq-form #category_id').trigger('change');
                            $('#edit-rfq-form input[name=title]').val(data.data.title);
                            $('#edit-rfq-form .short_description').text(data.data.short_description);
                            $('#edit-rfq-form .full_specification').text(data.data.full_specification);
                            $('#edit-rfq-form input[name=quantity]').val(data.data.quantity);
                            $('#edit-rfq-form #unit').val(data.data.unit);
                            $('#edit-rfq-form #unit').trigger('change');
                            $('#edit-rfq-form input[name=unit_price]').val(data.data.unit_price);
                            $('#edit-rfq-form input[name=destination]').val(data.data.destination);
                            $('#edit-rfq-form #payment_method').val(data.data.payment_method);
                            $('#edit-rfq-form #payment_method').trigger('change');
                            $('#edit-rfq-form .delivery_time').val(data.date);
                            if(data.data.deleted_at == null){
                                $('#edit-rfq-form #rfq-publish-yes').prop("checked", true);
                            }else{
                                $('#edit-rfq-form #rfq-publish-no').prop("checked", true);
                            }

                            for(i=1 ; i < 5 ; i++){

                                var id='#edit_img'+i;
                                $('#edit-rfq-form '+id+'').attr('src', 'https://via.placeholder.com/380');
                                var html='<button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                                $(id).parent().parent().find('.input-group-append').html(html);
                            }
                            if(data.data.images){
                                $.each(data.data.images, function(key, item){
                                    ++key;
                                    var id='#edit_img'+key;
                                    var asset="{{asset('storage')}}"+'/'+item.image
                                    $('#edit-rfq-form '+id+'').attr('src', asset);
                                    $(id).parent().parent().find('.input-group-append').html('');
                                    var html='<a href="javascript:void(0);" dataid="'+item.id+'" onclick="removeImageItem(this);">remove</a>';
                                    $(id).parent().parent().find('.input-group-append').html(html);
                                });
                            }



                        },

                    error: function(xhr, status, error)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();

                            // $('#errors').empty();
                            // $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                            $.each(xhr.responseJSON.error, function (key, item)
                            {
                                swal("Done!",item,"error");
                                // $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                            });

                        }
                });

        }

        //update
        $('#edit-rfq-submit-form').on('submit',function(e){
            e.preventDefault();
            var short_description= $('.edit-short-description').val().length;
                if($('.edit-short-description').val().length > 512){
                    alert('The short description character length limit is not more than 512, your given character length is '+short_description);
                    return false;
                }
            var id=$('input[name=edit_rfq_id]').val();
            var url = '{{ route("rfq.update", ":slug") }}';
                url = url.replace(':slug', id);
            var formData = new FormData(this);
            formData.append('_token', "{{ csrf_token() }}");
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                enctype: 'multipart/form-data',
                url: url,
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#edit-rfq-form').modal('close');
                        swal("Done!", data.msg,"success");
                        location.reload();

                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#edit_rfq_errors').empty();
                        $("#edit_rfq_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div></div>");
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#edit_rfq_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div></div>");
                        });

                    }
            });
        });

        //remove single rfq image
        function removeImageItem(obj){
            var single_image_id= $(obj).attr('dataid');
            var url = '{{ route("rfq.single.image.delete", ":slug") }}';
                url = url.replace(':slug', single_image_id);
            var obj=obj;
            $.ajax({
                method: 'get',
                processData: false,
                contentType: false,
                cache: false,
                url: url,
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();

                        $(obj).parent().parent().parent().parent().find('.img-thumbnail').attr('src', 'https://via.placeholder.com/380');
                        var html='<button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                        $(obj).parent().parent().find('.input-group-append').html(html);
                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#edit_rfq_errors').empty();
                        $("#edit_rfq_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div></div>");
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#edit_rfq_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div></div>");
                        });

                    }
            });
        }

        //select on change form submit
        $(document).ready(function() {
            $('#rfq_filter').on('change', function() {
                $('#rfq_filter_form').submit();
            });
        });

        $('.btn_responses_trigger').on('click',function(event){
            event.preventDefault();
            let rfqId = $(this).attr("data-rfqId");
            let obj=$(this).find('.new-bid-reply-badge');
            $.ajax({
                type:'GET',
                url: "{{route('bid-notification-mark-as-read')}}",
                data:{ rfqId: rfqId},
                success: function (data) {
                    $('.noticication_counter').text(data['noOfnotification']);
                    obj.remove();
                }
            });
        });



    </script>

@endpush
