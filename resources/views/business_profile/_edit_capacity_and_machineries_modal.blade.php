<div id="capacity-and-machineries-modal" class="modal profile_form_modal">
<div class="modal-content">
	<div id="capacity-machineries-errors">
	</div>
	<form  method="post" action="#" id="capacity-machinaries-form">
		@csrf
		<input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
		<div class="row">

			<!-- <div class="col s12 capacity_block_box">
				<div class="form-group production-capacity-block">
					<legend>Production Capacity (Annual)</legend>
					<div class="production-capacity-block">
						<table class="production-capacity-table-block">
							<thead>
								<tr>
									<th>Machine Type</th>
									<th>Annual Capacity</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								@if(count($business_profile->productionCapacities)>0)
								@foreach($business_profile->productionCapacities as $productionCapacity)
								<tr>
									<td><input name="machine_type[]" id="machine_type" type="text" class="form-control "  value="{{$productionCapacity->machine_type}}" ></td>
									<td><input name="annual_capacity[]" id="annual_capacity" type="number" class="form-control "  value="{{$productionCapacity->annual_capacity}}" ></td>
									<td><a href="javascript:void(0);" class="btn_delete" onclick="removeProductionCapacity(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
								</tr>
								@endforeach
								@else
								<tr id="production-capacity-table-no-data">
									<td><input name="machine_type[]" id="machine_type" type="text" class="form-control "  value="" ></td>
									<td><input name="annual_capacity[]" id="annual_capacity" type="number" class="form-control "  value="" ></td>
									<td><a href="javascript:void(0);" class="btn_delete" onclick="removeProductionCapacity(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
								</tr>
								@endif
							</tbody>
						</table>
						<div class="add_more_box">
							<a href="javascript:void(0);" class="add-more-block" onclick="addProductionCapacity()"><i class="material-icons dp48">add</i> Add More</a>
						</div>

					</div>
				</div>
			</div> -->

			<div class="col s12 capacity_block_box">
				<div class="form-group categories-produced-block">
					<legend> 
						<div class="row" style="margin:0;">
                            <span class="tooltipped_title">Categories</span> <a class="tooltipped" data-position="top" data-tooltip="Please input the percentage of Kids, <br />Man and Women products your factory manufactures.<br />For example: Men- 60%, Women 30% and kids 10%"><i class="material-icons">info</i></a>
                        </div>
					</legend>
					<div class="categories-produced-block">
						<div class="no_more_tables">
							<table class="categories-produced-table-block">
								<thead class="cf">
									<tr>
										<th>Category</th>
										<th>Percentage</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									@if(count($business_profile->categoriesProduceds)>0)
									@foreach($business_profile->categoriesProduceds as $categoriesProduced)
									<tr>
										<td data-title="Category"><input name="type[]" placeholder="Man, Woman, Kids etc." id="type" type="text" class="form-control "  value="{{$categoriesProduced->type}}" ></td>
										<td data-title="Percentage"><input name="percentage[]" placeholder="% on total annual production" id="percentage" type="number" class="form-control valid-number-check"  value="{{$categoriesProduced->percentage}}" ></td>
										<td><a href="javascript:void(0);" class="btn_delete" onclick="removeCategoriesProduced(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td>
									</tr>
									@endforeach
									@else
									<tr id="categories-produced-table-no-data">
										<td data-title="Type"><input name="type[]" id="type" placeholder="Man, Woman, Kids etc." type="text" class="form-control "  value="" ></td>
										<td data-title="Percentage"><input name="percentage[]" id="percentage" placeholder="% on total annual production" type="number" class="form-control valid-number-check"  value="" ></td>
										<td><a href="javascript:void(0);" class="btn_delete" onclick="removeCategoriesProduced(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>

						<div class="add_more_box">
							<a href="javascript:void(0);" class="add-more-block" onclick="addCategoriesProduced()"><i class="material-icons dp48">add</i> Add More</a>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="row capacity_block_box">
			<div class="form-group machinaries-details-block">
				<legend>
					<div class="row">
						<span class="tooltipped_title">Machinaries Details </span> <a class="tooltipped" data-position="top" data-tooltip="Please input the machineries name and quantity<br />in this section. Be specific while mentioning the machine name."><i class="material-icons">info</i></a>
					</div>
				</legend>
				<div class="machinaries-details-block">
					<div class="no_more_tables">
						<table class="machinaries-details-table-block">
							<thead class="cf">
								<tr>
									<th>Machine Name</th>
									<th>Quantity</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								@if(count($business_profile->machineriesDetails)>0)
								@foreach($business_profile->machineriesDetails as $machineriesDetail)
								<tr>
									<td data-title="Machine Name"><input name="machine_name[]" id="machine_name" type="text" class="form-control "  value="{{$machineriesDetail->machine_name}}" ></td>
									<td data-title="Quantity"><input name="quantity[]" id="quantity" type="number" class="form-control valid-number-check"  value="{{$machineriesDetail->quantity}}" ></td>
									<td data-title=""><a href="javascript:void(0);" class="btn_delete" onclick="removeMachinariesDetails(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td>
								</tr>
								@endforeach
								@else
								<tr id="machinaries-details-table-no-data">
									<td data-title="Machine Name"><input name="machine_name[]" id="machine_name" type="text" class="form-control "  value="" ></td>
									<td data-title="Quantity"><input name="quantity[]" id="quantity" type="number" class="form-control valid-number-check"  value="" ></td>
									<td><a href="javascript:void(0);" class="btn_delete" onclick="removeMachinariesDetails(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span></a></td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="add_more_box">
						<a href="javascript:void(0);" class="add-more-block" onclick="addMachinariesDetails()"><i class="material-icons dp48">add</i> Add More</a>
					</div>

				</div>
			</div>
		</div>

		<div class="submit_btn_wrap">
			<div class="row">
				<div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
				<div class="col s12 m6 l6 right-align">
					<button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit </button>
				</div>
			</div>
		</div>

	</form>

	<!-- <div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons">close</i></a>
	</div> -->

</div>
</div>

@push('js')
<script>
    $(document).on('change','.valid-number-check', function(){
        var value=$(this).val();
        if(value == 0 || value < 0){
            alert('0 or negative not accepted.');
        }
    });
</script>
@endpush
