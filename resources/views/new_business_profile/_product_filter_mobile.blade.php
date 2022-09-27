
<form action="{{route('new.profile.products',$alias)}}">
    <div class="new_profile_account_filterbar">
        <h4>Filtered by</h4>
        <div class="new_profile_account_filterbox">
            <label>Product type mapping</label>
            <select class="select2 dropdownOptions mobile-filter-select"  name="product_type_mapping_child_id[]" multiple>
                @foreach ($product_type_mapping as $ptm)
                    <option value={{$ptm->id}} {{ (in_array($ptm->id, $product_type_mapping_child_id))?'selected':'' }}>{{$ptm->title}}</option>
                @endforeach
            </select>
            <label>Product tags</label>
            <select class="select2 dropdownOptions mobile-filter-select"  name="product_tag[]" multiple>
                @foreach ($product_tags as $pt)
                    <option value={{$pt->id}} {{ (in_array($pt->id, $product_tag))?'selected':'' }}>{{$pt->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="account_filter_progress_wrap">
            <h4>Lead Time</h4>
            <div class="filter_progress_box">
                <div id="myRangeMobile"></div>
                <input type="hidden" name="min_lead" id="mobile_min_lead" value="{{$view_min_lead_time}}">
                <input type="hidden" name="max_lead" id="mobile_max_lead" value="{{$view_max_lead_time}}">
            </div>

            <h4>MOQ</h4>
            <div class="filter_progress_box_moq">
                <div id="myRangeMoqMobile"></div>
                <input type="hidden" name="min_moq" id="mobile_min_moq" value="{{$view_min_moq}}">
                <input type="hidden" name="max_moq" id="mobile_max_moq" value="{{$view_max_moq}}">
            </div>
        </div>
        <input type="hidden" name="view" value="{{$view}}">
        <div class="filter_reset_bottom_bar row">
            <div class="left">
                <a class="btn_green btn_clear btn_mobile_reset_filter mobile-filter-reset" href="{{route('new.profile.products',$alias)}}" style="display: none;"> Reset </a>
            </div>
            <div class="right">
                <input type="submit" class="btn_green btn_clear mobile-filter-reset" value="submit" style="display: none;">
            </div>
        </div>

    </div>
</form>

@push('js')
    <script>
        $( document ).ready(function() {
            var view_min_lead_time='{{$view_min_lead_time??$controller_min_lead_time}}';
            var view_max_lead_time='{{$view_max_lead_time??$controller_max_lead_time}}';
            var controller_max_lead_time='{{$controller_max_lead_time}}';
            var controller_min_lead_time='{{$controller_min_lead_time}}';
            $("#myRangeMobile").ionRangeSlider({
                type: "double",
                grid: true,
                min: controller_min_lead_time,
                max: controller_max_lead_time,
                from: view_min_lead_time,
                to: view_max_lead_time,
                onFinish: function (data) {
                    // Called then action is done and mouse is released
                    $('#mobile_min_lead').val(data.from);
                    $('#mobile_max_lead').val(data.to);
                    $('.mobile-filter-reset').show();
                },
            });


            var view_min_moq='{{$view_min_moq??$controller_min_moq}}';
            var view_max_moq='{{$view_max_moq??$controller_max_moq}}';
            var controller_max_moq='{{$controller_max_moq}}';
            var controller_min_moq='{{$controller_min_moq}}';
            $("#myRangeMoqMobile").ionRangeSlider({
                type: "double",
                grid: true,
                min: controller_min_moq,
                max: controller_max_moq,
                from: view_min_moq,
                to: view_max_moq,
                onFinish: function (data) {
                    // Called then action is done and mouse is released
                    $('#mobile_min_moq').val(data.from);
                    $('#mobile_max_moq').val(data.to);
                    $('.mobile-filter-reset').show();
                },
            });

        });

        $('.mobile-filter-select').on('change', function() {
            $('.mobile-filter-reset').show();
        });
        var check_selected_val =  $( ".mobile-filter-select option:selected" ).val();
        if(check_selected_val != undefined){
            $('.mobile-filter-reset').show();
        }

        var vmlt='{{$view_min_lead_time}}';
        var vmm = '{{$view_max_moq}}';
        if(vmlt!= '' || vmm!= ''){
            $('.mobile-filter-reset').show();
        }

    </script>
@endpush
