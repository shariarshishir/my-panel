<div id="export-destination-upload-form-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <div id="export-destination-upload-errors">

        </div>

        <form  method="post" action="#" id="export-destination-upload-form"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="business_profile_id" value="{{$business_profile->id}}">
            <div class="row">
                <div class="form-group  export-destination-details-block">
                    <legend>
                        <div class="row">
                            <span class="tooltipped_title">Export Destinations</span> <a class="tooltipped" data-position="top" data-tooltip="Mention the countries you export most often.<br />This information will help to recommend your profile <br />to the buyers from those regions."><i class="material-icons">info</i></a>
                        </div>
                    </legend>
                    <div class="export-destination-details-block">
                        <div class="no_more_tables">
                            <table class="export-destination-table-block">
                                <thead class="cf">
                                    <tr>
                                        <th>Name</th>
                                        <th>Short description</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-title="Name" class="input-field">
                                            <select name="country_id[]"  class="certificate-select2">
                                                <option value=""  selected>Choose your option</option>
                                                @foreach ($country as $key => $name)
                                                    <option value="{{$key}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td data-title="Short Description">
                                            <textarea class="input-field" name="short_description[]" id="export-destination-short-description" rows="4" cols="50"></textarea>
                                        </td>
                                        <td><a href="javascript:void(0);" class="btn_delete" onclick="removeExportDestinationDetails(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="add_more_box">
                            <a href="javascript:void(0);" class="add-more-block" onclick="addExportDestinationDetails()"><i class="material-icons dp48">add</i> Add More</a>
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

@push('js')

    <script>
        //export destination add remove
    function addExportDestinationDetails()
    {

        $('#export-destination-details-table-no-data').hide();
        var html = '<tr>';
        html +='<td data-title="Name" class="input-field"><select name="country_id[]"class="certificate-select2"><option value="" selected>Choose your option</option>@foreach ($country as $key => $name)<option value="{{$key}}">{{$name}}</option>@endforeach</select></td>';
        html +='<td data-title="Short Description"><textarea class="input-field" name="short_description[]" id="export-destination-short-description" rows="4" cols="50"></textarea></td>';
        html +='<td><a href="javascript:void(0);" class="btn_delete" onclick="removeExportDestinationDetails(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
        html +='</tr>';
        $('.export-destination-table-block tbody').append(html);
        selectRefresh();
    }

    function removeExportDestinationDetails(el)
    {
        $(el).parent().parent().remove();
    }
     //submit form for export destination

     $('#export-destination-upload-form').on('submit',function(e){
    e.preventDefault();
    var url = '{{ route("exportdestinations.upload") }}';
    var formData = new FormData(this);
    formData.append('_token', "{{ csrf_token() }}");
    $.ajax({
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        enctype: 'multipart/form-data',
        url: url,
        beforeSend: function() {
        $('.loading-message').html("Please Wait.");
        $('#loadingProgressContainer').show();
        },

      success:function(response){
        $('.loading-message').html("");
		$('#loadingProgressContainer').hide();
        $('#export-destination-upload-form')[0].reset();
        $('#export-destination-upload-errors').empty();
        var exportDestinations=response.exportDestinations;

        var nohtml="";
        if(exportDestinations.length >0){
            $('.export-destination-block').html(nohtml);

            for(let i = 0;i < exportDestinations.length ;i++){
                var html='';
                var image_name=exportDestinations[i].country.code+'.png';
                var image="{{Storage::disk('s3')->url('public/frontendimages/flags')}}"+'/'+image_name.toLowerCase();
                html +='<div class="col s6 m4 l2">';
                html +='<div class="flag_img export-destination-img">';
                html +='<a style="display: none;" href="javascript:void(0)" data-id="'+ exportDestinations[i].id+'" class="remove-export-destination"><i class="material-icons dp48">remove_circle_outline</i></a>';
                html +='<img src="'+image+'" alt="">';
                html +='</div>';
                html +='<h5>'+exportDestinations[i].country.name+'</h5>';
                html +='</div>';
                $('.export-destination-block').append(html);
            }

            //append in form
            $('.export-destination-table-block tbody').children().empty();
                var html='<tr>';
                html +='<td data-title="Name" class="input-field"><select name="country_id[]"class="certificate-select2"><option value=""  selected>Choose your option</option>@foreach ($country as $key => $name)<option value="{{$key}}">{{$name}}</option>@endforeach</select></td>';
                html +='<td data-title="Short Description"><textarea class="input-field" name="short_description[]" id="main-buyer-short-description" rows="4" cols="50"></textarea></td>';
                html +='<td><a href="javascript:void(0);" class="btn_delete" onclick="removeMainBuyersDetails(this)"><i class="material-icons dp48">delete_outline</i><span>Delete</span> </a></td>';
                html +='<tr>';
                $('.export-destination-table-block  tbody').append(html);
                selectRefresh();
        }
        else{
                $('.export-destination-block').html(nohtml);
                var html='';
                html +='<div class="card-alert card cyan lighten-5">';
                html +='<div class="card-content cyan-text">';
                html +='<p>INFO : No data found.</p>';
                html +='</div>';
                $('.export-destination-block').append(html);
            }

        $('#export-destination-upload-form-modal').modal('close');
        swal("Done!", response.message,"success");
      },
      error: function(xhr, status, error)
            {
                $('.loading-message').html("");
		        $('#loadingProgressContainer').hide();
                $('#export-destination-upload-errors').empty();
                $("#export-destination-upload-errors").append("<div class=''>"+error+"</div>");
                $.each(xhr.responseJSON.error, function (key, item)
                {
                    $("#export-destination-upload-errors").append("<div class='danger'>"+item+"</div>");
                });
            }
      });
    });



    $(document).on('click', '.delete-export-destination-button',function(e){
        e.preventDefault();
        $('.remove-export-destination').show();
    });


    $(document).on('click', '.remove-export-destination',function(e)
    {
        e.preventDefault();
        var id=$(this).attr("data-id");

        swal({
                title: "Want to delete this export destionation ?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true)
                {
                    $.ajax({
                        url: '{{ route("exportdestinations.delete") }}',
                        type: "GET",
                        data:{id:id},
                        beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                        },
                        success:function(response)
                            {
                                $('.loading-message').html("");
                                $('#loadingProgressContainer').hide();
                                var exportDestinations=response.exportDestinations;

                                var nohtml="";
                                if(exportDestinations.length >0){
                                    $('.export-destination-block').html(nohtml);
                                    for(let i = 0;i < exportDestinations.length ;i++){
                                        var html='';
                                        var image_name=exportDestinations[i].country.code+'.png';
                                        var image="{{Storage::disk('s3')->url('public/frontendimages/flags')}}"+'/'+image_name.toLowerCase();
                                        html +='<div class="col s6 m4 l2">';
                                        html +='<div class="flag_img export-destination-img">';
                                        html +='<a style="display: none;" href="javascript:void(0)" data-id="'+exportDestinations[i].id+'" class="remove-export-destination"><i class="material-icons dp48">remove_circle_outline</i></a>';
                                        html +='<img src="'+image+'" alt="">';
                                        html +='</div>';
                                        html +='<h5>'+exportDestinations[i].country.name+'</h5>';
                                        html +='</div>';
                                        $('.export-destination-block').append(html);
                                    }
                                }
                                else{
                                    $('.export-destination-block').html(nohtml);
                                    var html='';
                                    html +='<div class="card-alert card cyan lighten-5">';
                                    html +='<div class="card-content cyan-text">';
                                    html +='<p>INFO : No data found.</p>';
                                    html +='</div>';
                                    $('.export-destination-block').append(html);
                                }
                                $('#export-destination-upload-form-modal').modal('close');
                                swal("Done!", response.message,"success");
                            },
                            error: function(xhr, status, error)
                            {
                                $('.loading-message').html("");
                                $('#loadingProgressContainer').hide();
                                toastr.success(error);
                            }
                        });
                }
                else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
    });

    </script>
@endpush
