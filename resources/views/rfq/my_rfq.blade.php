@extends('layouts.app')

@section('content')

<!-- <div>
    <a class="waves-effect waves-light btn modal-trigger" href="#create-rfq-form">Create Rfq</a>
</div> -->
@include('rfq._create_rfq_form_modal')
<div id="errors">

</div>

<!-- RFQ html start -->

<div class="box_shadow_radius rfq_content_box ">
	<div class="rfq_info_wrap right-align rfq_top_navbar">
		<ul>
			<li class="{{ Route::is('rfq.index') ? 'active' : ''}}"><a href="{{route('rfq.index')}}" class="btn_grBorder">RFQ Home</a></li>
			<li class="{{ Route::is('rfq.my') ? 'active' : ''}}"><a href="{{route('rfq.my')}}" class="btn_grBorder">My RFQs</a></li>
			<li style="display: none;"><a href="javascript:void(0);" class="btn_grBorder">Saved RFQs</a></li>
			<li><a class="btn_grBorder modal-trigger open-create-rfq-modal">Create RFQ</a></li>
		</ul>
	</div>
	<div class="no_more_tables">
		@include('rfq.my_rfq_list')
    </div>
	@if($noOfPages>1)
	<nav aria-label="Page navigation example">
		<ul class="pagination">
			<li class="page-item">
				<a class="my-rfq-page-link my_rfq_prev_link" href="#" data-page="1" tabindex="-1">Previous</a>
			</li>
			@for($i=1; $i<=$noOfPages; $i++)
				<li class="page-item" ><a class="my-rfq-page-link" href="#" data-page="{{$i}}">{{$i}}</a></li>
			@endfor
			<li class="page-item">
				<a class="my-rfq-page-link my_rfq_next_link" href="#" data-page="2">Next</a>
			</li>
		</ul>
	</nav>
	@endif
</div>
<!-- RFQ html end -->


@include('rfq.share_modal')
@endsection

@include('rfq._scripts')
