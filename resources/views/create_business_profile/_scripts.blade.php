@push('js')
    <script>
        $(document).ready(function()
        {
            $(".next_to_business_profile_info, .last-step").click(function()
            {
                //alert("I am here");
                //collecting values
                var name = $("#business_name").val();
                var location = $("#location").val();
                var businessType = $('select[name="business_type"]').val();
                var numberOfFactories = $("#number_of_factories").val();
                var numberOfOutlets = $("#number_of_outlets").val();
                var tradeLicense = $("#trade_license").val();
                var industryType = $('select[name="industry_type"]').val();
                var factory_type = $('select[name="factory_type"]').val();
                var representiveName = $("#representive_name").val();
                var representiveEmail = $("#email").val();
                var representivePhone = $("#phone").val();
                var representiveNidPassport = $("#nid_passport").val();

                //setting values
                $("#review_name").html("<b>Organization Name:</b> "+name);
                $("#review_location").html("<b>Location:</b> "+location);
                if(businessType == 'manufacturer'){
                    $("#review_business_type").html("<b>Business Type:</b> Manufacturer");
                } else if(businessType == 'wholesaler') {
                    $("#review_business_type").html("<b>Business Type:</b> Wholesaler");
                } else {
                    $("#review_business_type").html("<b>Business Type:</b> Design Studio");
                }

                if(numberOfFactories){
                    $("#review_number_of_factories").html("<b>Number of Factories:</b> "+numberOfFactories);
                } else {
                    $("#review_number_of_factories").hide();
                }

                if(numberOfOutlets) {
                    $("#review_number_of_outlets").html("<b>Number of Outlets:</b> "+numberOfOutlets);
                } else {
                    $("#review_number_of_outlets").hide();
                }

                $("#review_trade_license").html("<b>Trade License:</b> "+tradeLicense);
                $("#review_industry_type").html("<b>Industry Type:</b> "+industryType);
                if(factory_type){
                    $("#review_factory_type").html("<b>Factory Type:</b> "+factory_type);
                } else {
                    $("#review_factory_type").hide();
                }

                if(representiveName){
                    $("#review_representative_name").html("<b>Representative Name:</b> "+representiveName);
                } else {
                    $("#review_representative_name").hide();
                }

                if(representiveEmail){
                    $("#review_representatives_email").html("<b>Representative Email:</b> "+representiveEmail);
                } else {
                    $("#review_representatives_email").hide();
                }

                if(representivePhone){
                    $("#review_representatives_contact").html("<b>Representative Phone:</b> "+representivePhone);
                } else {
                    $("#review_representatives_contact").hide();
                }

                if(representiveNidPassport) {
                    $("#review_representative_nidPassport").html("<b>Representative NID/Passport:</b> "+representiveNidPassport);
                } else {
                    $("#review_representative_nidPassport").hide();
                }

                if(!name){
                    var alertHtml = '<div class="card-alert card orange lighten-5">';
                    alertHtml += '<div class="card-content orange-text">';
                    alertHtml += '<p>WARNING : Please fill all the required fields.</p>';
                    alertHtml += '</div>';
                    alertHtml += '</div>';
                    $("#information_message").html(alertHtml);
                    $("#review_name, #review_location, #review_business_type, #review_number_of_factories, #review_number_of_outlets, #review_trade_license, #review_industry_type, #review_factory_type, #review_representative_name, #review_representatives_email, #review_representatives_contact, #review_representative_nidPassport").hide();
                } else {
                    var infoHtml = '<div class="card-alert card cyan lighten-5">';
                    infoHtml += '<div class="card-content cyan-text">';
                    infoHtml += '<p>Please check your provided data and submit to create profile.</p>';
                    infoHtml += '</div>';
                    infoHtml += '</div>';
                    $("#information_message").html(infoHtml);
                    $("#review_name, #review_location, #review_business_type, #review_number_of_factories, #review_number_of_outlets, #review_trade_license, #review_industry_type, #review_factory_type, #review_representative_name, #review_representatives_email, #review_representatives_contact, #review_representative_nidPassport").show();
                }
            });
        });

    $(document).on('change', 'input[name="has_representative"]', function(){
        if($(this).val()==1) {
            $(".representive_info").hide();
        } else {
            $(".representive_info").show();
        }
    })


    function changecategory(obj,type){

        if(type == 'business'){
            var value =  $('#'+obj.id).children(":selected").val();
            if(value == 'manufacturer'){

                $('.number_of_factories').show();
                $('.number_of_outlets').hide();
            }
            else if(value == 'wholesaler'){
                $('.number_of_factories').hide();
                $('.number_of_outlets').show();
            }
            else{
                $('.number_of_factories').hide();
                $('.number_of_outlets').hide();
            }
        }

        var id = $('#'+obj.id).children(":selected").attr("data-id");
        var url = '{{ route("business.mapping.child", ":slug") }}';
            url = url.replace(':slug', id);
        $.ajax({
                method: 'get',
                url: url,
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        if(type == 'business'){
                                if(data){
                                $("#industry_type").empty();
                                $("#industry_type").append('<option value="" disabled selected >Choose your industry type</option>');
                                $.each(data,function(key,value){
                                    $("#industry_type").append('<option value="'+value.name+'" data-id="'+value.id+'">'+value.name.toUpperCase()+'</option>');
                                });

                            }else{
                                $("#industry_type").empty();
                            }

                        }else if(type == 'industry'){
                                if(data){
                                $("#factory_type").empty();
                                $("#factory_type").append('<option value="" disabled selected >Choose your factory type</option>');
                                $.each(data,function(key,value){
                                    $("#factory_type").append('<option value="'+value.name+'" data-id="'+value.id+'">'+value.name.toUpperCase()+'</option>');
                                });

                            }else{
                                $("#factory_type").empty();
                            }
                        }
                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        swal("Error!", error,"error");
                    }
        });
    }
   //store business form data
   $('#business_profile_form').on('submit',function(e){
            e.preventDefault();
            var url = '{{ route("business.profile.store") }}';
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
                success:function(data)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#edit_errors').empty();
                        //console.log(data);
                        swal("Done!", data.msg,"success");
                        window.location.href=data.redirect_url;

                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('.edit_errors_wrapper').show();
                        $('#edit_errors').empty();
                        //$("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+error+"</div></div>");
                        $("#edit_errors").append("<div class=''>"+error+"</div>");
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            //$("#edit_errors").append("<div class='card-alert card red'><div class='card-content white-text card-with-no-padding'>"+item+"</div></div>");
                            $("#edit_errors").append("<div class=''>"+item+"</div>");

                        });

                    }
            });
        });

    </script>
@endpush
