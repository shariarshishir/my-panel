<div id="machinery-details-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <div id="machinery-details-errors">
        </div>
        <form  method="post" action="#" id="machinery-details-form">
            @csrf
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
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
