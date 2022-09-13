<div id="sustainability-commitment-modal" class="modal profile_form_modal">
<div class="modal-content">
	<div id="sustainability-commitment-errors">
	</div>
	<form  method="post" action="#" id="sustainability-commitment-form">
		@csrf
		<input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
		
		<div class="row">
			<div class="form-group  sustainability-commitment-details-block">
				<legend> 
					<div class="row">
						<span class="tooltipped_title">Sustainability commitments</span> <a class="tooltipped" data-position="top" data-tooltip="Mention if you have any feature or facility which is dedicated to<br />your sustainability commitment. For example: Have rainwater harvesting plant,<br /> Water recovery system able to recover 90% of the used water etc."><i class="material-icons">info</i></a>
					</div>
				</legend>
				<div class="sustainability-commitment-block">
					<table class="sustainability-commitment-table-block">
						<thead>
							<tr>
								<th>Description</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@if(count($business_profile->sustainabilityCommitments)>0)
							@foreach($business_profile->sustainabilityCommitments as $sustainabilityCommitment)
							<tr>
								<td><input name="sustainability_commitment_title[]" id="sustainability-Commitment-title" type="text" class="input-field" value="{{$sustainabilityCommitment->title}}" ></td>
								<td><a href="javascript:void(0);" class="btn_delete" onclick="removeSustainabilityCommitmentDetails(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
							</tr>
							@endforeach
							@else
							<tr id="sustainability-commitment-table-no-data">
								<td><input name="sustainability_commitment_title[]" id="sustainability-Commitment-title" type="text" class="input-field" value="" ></td>
								<td><a href="javascript:void(0);" class="btn_delete" onclick="removeSustainabilityCommitmentDetails(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
							</tr>
							@endif
						</tbody>
					</table>
					<div class="add_more_box">
						<a href="javascript:void(0);" class="add-more-block" onclick="addSustainabilityCommitmentDetails()"><i class="material-icons dp48">add</i> Add More</a>
					</div>
					
				</div>
			</div>
		</div>

		<!-- <div class="center-align submit_btn_wrap">
			<button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit
				<i class="material-icons right">send</i>
			</button>
		</div> -->

		<div class="submit_btn_wrap" style="padding-top: 30px;">
			<div class="row">
				<div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
				<div class="col s12 m6 l6 right-align">
					<button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit</button>
				</div>
			</div>
		</div>
	</form>
<!-- 
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons">close</i></a>
	</div> -->

</div>
</div>