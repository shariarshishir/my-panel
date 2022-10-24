<div class="tabcontent">
	
	@include('wholesaler_profile.verification_message')

	<h3>About the Company</h3>
	<div class="contentBox">
		<div class="company_stuff center-align row">
			@foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
				@if($company_overview->name=='floor_space')
				<div class="col s4 m3 l2">
					<div class="company_stuff_img">
						<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/factory.png')}}" alt="" /> 
					</div>
					<div class="title">Floor Space</div>
					<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
				</div>
				@endif
				@if($company_overview->name=='no_of_machines')
				<div class="col s4 m3 l2">
					<div class="company_stuff_img">
						<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/sewing-machine.png')}}" alt="" /> 
					</div>
					<div class="title">No. of Machines</div>
					<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}pcs</div>
				</div>
				@endif
				@if($company_overview->name=='production_capacity')
				<div class="col s4 m3 l3">
					<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/production.png')}}" alt="" /> 
					<div class="title">Production Capacity</div>
					<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}pcs</div>
				</div>
				@endif
				@if($company_overview->name=='number_of_worker')
					@if(isset($company_overview->value))
					<div class="col s4 m3 l2">
						<div class="company_stuff_img">
							<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/workers.png')}}" alt="" /> 
						</div>
						<div class="title">No. of workers</div>
						<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
					</div>
					@endif
				@endif
				@if($company_overview->name=='number_of_female_worker')
					@if(isset($company_overview->value))
					<div class="col s4 m3 l2">
						<div class="company_stuff_img">
							<img src="{{Storage::disk('s3')->url('public/frontendimages/new_layout_images/human.png')}}" alt="" /> 
						</div>
						<div class="title">No. of female workers</div>
						<div class="quantity {{$company_overview->name}}_value">{{$company_overview->value}}</div>
					</div>
					@endif
				@endif
			@endforeach
		</div>
	
		
	</div>
	<!-- company_stuff -->
	<div class="contentBox">
		@if($business_profile->companyOverview->about_company)
		<p itemprop="description">
			{{$business_profile->companyOverview->about_company}}
		</p>
		@else
			<div class="card-alert card cyan lighten-5">
				<div class="card-content cyan-text">
					<p>INFO : company details is not available.</p>
				</div>
			</div>
		@endif
	</div>
</div>