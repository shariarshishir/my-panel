<div id="sampling-modal" class="modal profile_form_modal">
<div class="modal-content">
	<div id="sampling-errors">
	</div>
	<form  method="post" action="#" id="sampling-form">
		@csrf
		<input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
		
		<div class="row">
			<div class="form-group  sampling-details-block">
				<legend> 
					<div class="row">
						<span class="tooltipped_title">Sampling and R&D</span> <a class="tooltipped" data-position="top" data-tooltip="Mention the elements of your Sampling and R&D section.<br />Elements can be Sampling facility space, Manpower, Sample lead time (In weeks),<br />SMS Capacity/Lead Times (In weeks), Daily sample capacity,<br />Design studio facility (Yes/No), Design studio Manpower etc.<br /> Input the name of the Particular field and use the other<br /> field to input the quantity of that particular."><i class="material-icons">info</i></a>
					</div>
				</legend>
				<div class="sampling-block">
					<div class="no_more_tables">
						<table class="sampling-table-block">
							<thead class="cf">
								<tr>
									<th>Particulars</th>
									<th>Quantity</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								@if(count($business_profile->samplings)>0)
								@foreach($business_profile->samplings as $sampling)
								<tr>
									<td data-title="Particulars"><input name="sampling_title[]" id="sampling-title" type="text" class="input-field" value="{{$sampling->title}}" ></td>
									<td data-title="Quantity"><input name="sampling_quantity[]" id="sampling-quantity" type="number" class="input-field"  value="{{$sampling->quantity}}" ></td>
									<td><a href="javascript:void(0);" class="btn_delete" onclick="removeSamplingDetails(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td>
								</tr>
								@endforeach
								@else
								<tr id="sampling-details-table-no-data">
									<td data-title="Particulars"><input name="sampling_title[]" id="sampling-title" type="text" class="input-field" value="" ></td>
									<td data-title="Quantity"><input name="sampling_quantity[]" id="sampling-quantity" type="number" class="input-field"  value="" ></td>
									<td><a href="javascript:void(0);" class="btn_delete" onclick="removeSamplingDetails(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
					

					<div class="add_more_box">
						<a href="javascript:void(0);" class="add-more-block" onclick="addSamplingDetails()"><i class="material-icons dp48">add</i> Add More</a>
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