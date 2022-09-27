<div id="categorires-produced-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <div id="categorires-produced-errors">
        </div>
        <form  method="post" action="#" id="categorires-produced-form">
            @csrf
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
            <div class="row">
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

            <div class="submit_btn_wrap">
                <div class="row">
                    <div class="col s12 m6 l6 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                    <div class="col s12 m6 l6 right-align">
                        <button class="btn waves-effect waves-light btn_green" type="submit" name="action">Submit </button>
                    </div>
                </div>
            </div>
        </form>
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
