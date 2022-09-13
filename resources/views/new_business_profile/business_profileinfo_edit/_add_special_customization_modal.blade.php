<div id="special-customization-modal" class="modal profile_form_modal">
<div class="modal-content">
	<div id="special-customization-errors">
	</div>
	<form  method="post" action="#" id="special-customization-form">
		@csrf
		<input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
		
		<div class="row">
			<div class="form-group  special-customization-details-block">
				<legend> 
					<div class="row">
						<span class="tooltipped_title">Special Customization ability</span> <a class="tooltipped" data-position="top" data-tooltip="Mention(if any) special customization capability you have.<br />Please write the relevant text and user keywords so that<br />your profile get advantage in promotion algorithm."><i class="material-icons">info</i></a>
					</div>
				</legend>
				<div class="special-customization-block">
					<table class="special-customization-table-block">
						<thead>
							<tr>
								<th>Description</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@if(count($business_profile->specialCustomizations)>0)
							@foreach($business_profile->specialCustomizations as $specialCustomization)
							<tr>
								<td><input name="special_customization_title[]" id="special-customizations-title" type="text" class="input-field" value="{{$specialCustomization->title}}" ></td>
								<td><a href="javascript:void(0);" class="btn_delete" onclick="removeSpecialCustomizationDetails(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
							</tr>
							@endforeach
							@else
							<tr id="special-customization-table-no-data">
								<td><input name="special_customization_title[]" id="special-customizations-title" type="text" class="input-field" value="" ></td>
								<td><a href="javascript:void(0);" class="btn_delete" onclick="removeSpecialCustomizationDetails(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
							</tr>
							@endif
						</tbody>
					</table>

					<div class="add_more_box">
						<a href="javascript:void(0);" class="add-more-block" onclick="addSpecialCustomizationsDetails()"><i class="material-icons dp48">add</i> Add More</a>
					</div>

					
				</div>
			</div>
		</div>

		<div class="submit_btn_wrap">
			<div class="row">
				<div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
				<div class="col s12 m6 l6 right-align">
					<button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit</button>
				</div>
			</div>
		</div>

	</form>

	<!-- <div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons">close</i></a>
	</div> -->

</div>
</div>