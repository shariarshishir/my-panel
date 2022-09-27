@php
$profileEditMode = Request::get('editmode');
@endphp
<!-- profile tabcontent end -->
<div id="profile" class="tabcontent profile_table_design ">
<div class="overview_table_wrap">
		
		@include('wholesaler_profile.verification_message')
		
		<div class="row top_titleWrap">
			<div class="col s6 m6">
				<h3>Company Overview</h3>
			</div>
			@if($profileEditMode == 'enabled')
			<div class="col s6 m6 right-align editBox">
				<button data-target="company-overview-modal" type="button" class="btn_edit btn_green_White modal-trigger">
					<span class="btn_icon"><i class="material-icons">border_color</i></span>
                    <span class="btn_edit_white"> Edit</span>
				</button>
			</div>
			@endif
		</div>
		
		<div class="overview_table box_shadow">
			<table>
				<tbody>
					@foreach (json_decode($business_profile->companyOverview->data) as $company_overview)
					<tr>
						<td>{{str_replace('_', ' ', ucfirst($company_overview->name))}}</td>
						<td class="{{$company_overview->name}}_value">{{$company_overview->value}}</td>
						@if($company_overview->status==1)
						<td><i class="material-icons {{$company_overview->name}}_status" style="color:green">check_circle</i></td>
						@else
						<td><i class="material-icons {{$company_overview->name}}_status"style="color:gray">check_circle</i></td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="membership_wrap">
		<div class="row top_titleWrap upload_delete_wrap">
			<div class="col s6 m6">
				<h3>Association memberships</h3>
			</div>
			@if($profileEditMode == 'enabled')
			<div class="col s6 m6 right-align editBox">
				<button type="button" data-target="association-membership-upload-form-modal" class="btn_upload btn_green_White modal-trigger">
					<span class="btn_icon"><i class="material-icons">file_upload</i></span>
                    <span class="btn_edit_white"> Upload</span>
				</button>
				<button type="button" class="btn_delete btn_green_White delete-association-membership-button">
					<span class="btn_icon"><i class="material-icons">delete</i></span>
                    <span class="btn_edit_white"> Delete</span>
				</button>
			</div>
			@endif
		</div>
		
		<div class="membership_textBox association-membership-block">
			@if(count($business_profile->associationMemberships) > 0)
			@foreach($business_profile->associationMemberships as $associationMembership)
			<div class="center-align association-membership-img">
				<a href="javascript:void(0)" style="display: none;"data-id="{{$associationMembership->id}}" class="remove-association-membership"><i class="material-icons dp48">remove_circle_outline</i></a>
				<div class="imgbox"><img  src="{{ Storage::disk('s3')->url('public/'.$associationMembership->image) }}" alt=""></div>
				<p>{{$associationMembership->title}}</p>
			</div>
	
			@endforeach
			@else
			<div class="card-alert card cyan lighten-5">
				<div class="card-content cyan-text">
					<p>INFO : No data found.</p>
				</div>
			</div>	
			@endif
		</div>
	</div>
	<div class="pr_highlights_wrap">
		<div class="row top_titleWrap upload_delete_wrap">
			<div class="col s6 m6">
				<h3>PR Highlights</h3>
			</div>
			@if($profileEditMode == 'enabled')
			<div class="col s6 m6 right-align editBox">
				<button type="button" data-target="press-highlight-upload-form-modal" class="btn_upload btn_green_White modal-trigger"> 
					<span class="btn_icon"><i class="material-icons">file_upload</i></span>
                    <span class="btn_edit_white"> Upload</span>
				</button>
				<button type="button" class="btn_delete btn_green_White delete-press-highlight-button" >
					<span class="btn_icon"><i class="material-icons">delete</i></span>
                    <span class="btn_edit_white"> Delete</span>
				</button>
			</div>
			@endif
		</div>

		<div class="row press-highlight-block">
			@if(count($business_profile->pressHighlights)>0)
			@foreach($business_profile->pressHighlights as $pressHighlight)
				<div class="col s6 m4 l2 paper_img press-highlight-img">
					<a href="javascript:void(0)" style="display: none;"data-id="{{$pressHighlight->id}}" class="remove-press-highlight"><i class="material-icons dp48">remove_circle_outline</i></a>
					<div class="press_img">
						<div class="press_img_box">
							<img src="{{ Storage::disk('s3')->url('public/'.$pressHighlight->image) }}" alt="" />
						</div>
					</div>
				</div>
			@endforeach
			@else
				<div class="card-alert card cyan lighten-5">
					<div class="card-content cyan-text">
						<p>INFO : No data found.</p>
					</div>
				</div>
			@endif
			
		</div>
	
	</div>
</div>
