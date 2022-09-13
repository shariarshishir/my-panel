@push('js')
<script>

    $(document).on('click', '.page-link', function(event){
        event.preventDefault();
        var page = $(this).data("page");
        if(page == 1){
            $('.prev_link').data('page',page);
        }else{
            $('.prev_link').data('page',page-1);
        }
        $('.next_link').data('page',page+1);
        $.ajax({
            method: 'get',
            data: {page:page},
            url: '{{ route("rfq.frontend.pagination") }}',
            beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
            },
            success:function(response){
                $('.loading-message').html("");
                $('#loadingProgressContainer').hide();
                $('.no_more_tables').html(response);
                $("html, body").animate({ scrollTop: "0" });
            }
        });
    });
    $(document).on('click', '.my-rfq-page-link', function(event){
        event.preventDefault();
        var page = $(this).data("page");
        if(page == 1){
            $('.my_rfq_prev_link').data('page',page);
        }else{
            $('.my_rfq_prev_link').data('page',page-1);
        }
        $('.my_rfq_next_link').data('page',page+1);
        $.ajax({
            method: 'get',
            data: {page:page},
            url: '{{ route("my.rfq.frontend.pagination") }}',
            beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
            },
            success:function(response){
                $('.loading-message').html("");
                $('#loadingProgressContainer').hide();
                $('.no_more_tables').html(response);
                $("html, body").animate({ scrollTop: "0" });
            }
        });
    });



    $('.open-create-rfq-modal').click(function(){
        $('#create-rfq-form').modal('open');
        $('.createRfqForm')[0].reset();
        $('#create-rfq-form #category_id').val(null).trigger('change');
        $('#create-rfq-form #unit').val('');
        $('#create-rfq-form #unit').trigger('change');
        $('#create-rfq-form #payment_method').val('');
        $('#create-rfq-form #payment_method').trigger('change');
        $('#create-rfq-form .img-thumbnail').attr('src','https://via.placeholder.com/380');
    });

    $('.createRfqForm').on('submit',function(e){
        e.preventDefault();
        const rfq_app_url = "{{env('RFQ_APP_URL')}}";
        var url = rfq_app_url+'/api/quotation';
        const sso_token = "Bearer " +"{{ Cookie::get('sso_token') }}";

        var formData = new FormData();
        var file_data = $('input[type="file"]')[0].files; // for multiple files
        var files = [];
        for (let i = 0; i < $('input[type="file"]').length; i++) {
            formData.append("files", $('input[type="file"]')[i].files[0]);
        }
        formData.append("rfq_from", 'service');


        var other_data = $('.createRfqForm').serializeArray();
        var category_id=[];
        $("#category_id :selected").each(function() {
            category_id.push(this.value);
        });
        var stringCatId=category_id.toString();

        $.each(other_data,function(key,input){
            if(input.name != 'category[]'){
                formData.append(input.name,input.value);
            }
        });

        formData.append('category_id', stringCatId);
        formData.append('_token', "{{ csrf_token() }}");

        $.ajax({
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            enctype: 'multipart/form-data',
            url: url,
            headers: { 'Authorization': sso_token },
            beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
            },

            success:function(response){
                $('.loading-message').html("");
                $('#loadingProgressContainer').hide();
                $('#create-rfq-form').modal('close');
                const msg = "Your RFQ was posted successfully.<br><br>Soon you will receive quotation from <br>Merchant Bay verified relevant suppliers.";
                swal("Done!", msg,"success");
            },
            error: function(xhr, status, error)
                {
                $('.loading-message').html("");
                $('#loadingProgressContainer').hide();
                swal("Error!", error,"error");
                }
            });
        });

        //create bid rfq
        function openBidRfqModal(id, unit){
            var rfq_id=id;
            var unit= unit;
            var url = '{{ route("rfq.bid.create", ":slug") }}';
            url = url.replace(':slug', rfq_id);
            $.ajax({
                    method: 'get',
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: url,
                    beforeSend: function() {
                    $('.loading-message').html("Please Wait.");
                    $('#loadingProgressContainer').show();
                    },
                    success:function(data)
                        {
                            //console.log(data);
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();

                            $('#rfq-bid-modal').modal('open');
                            $('#rfq-bid-form')[0].reset();
                            $('#rfq-bid-modal .rfq-replay-submit').prop("disabled", false);
                            $('#rfq-bid-modal input[name=rfq_id]').val(rfq_id);
                            $('#rfq-bid-modal #offer_price_unit').val(unit);
                            $('#rfq-bid-modal #offer_price_unit').trigger('change');
                            $('#rfq_bid_store_errors').empty();
                            $('#rfq-bid-modal .rfq-replay-submit').show();

                            $('#my_business_list').html('');
                            $.each(data.my_business, function (i, item) {
                                    $('#my_business_list').append($('<option>', {
                                        value: item.id,
                                        text : item.business_name
                                    }));
                            });
                            if(data.bid.length > 0){

                                $('#my_business_list').val(data.bid[0]['business_profile_id']);
                                $('#my_business_list').trigger('change');
                                // tinymce.get("product-bidding-desc").setContent(data.bid.description);
                                $('#rfq-bid-modal input[name=offer_price]').val(data.bid[0]['offer_price']);
                                $('#rfq-bid-modal #offer_price_unit').val(data.bid[0]['offer_price_unit']);
                                $('#rfq-bid-modal #offer_price_unit').trigger('change');
                                // $('#rfq-bid-modal .rfq-replay-submit').prop("disabled", true);
                                  $('#rfq-bid-modal .rfq-replay-submit').hide();

                            }

                        },

                    error: function(xhr, status, error)
                        {
                            $('.loading-message').html("");
                            $('#loadingProgressContainer').hide();

                            // $('#errors').empty();
                            // $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                            $.each(xhr.responseJSON.error, function (key, item)
                            {
                                swal("Done!",item,"error");
                                // $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                            });

                        }
                });

        }

        //store bid rfq

        function validateWordsLength() {
            var max = 1;
            var theEditor = tinymce.activeEditor;
            var wordCount = theEditor.plugins.wordcount.getCount();
            if(wordCount == 0){
                $('#rfq-bid-form .validation-error-description').text('Short description required');
                return false;
            }else{
                $('#rfq-bid-form .validation-error-description').text(' ');
            }
            if (wordCount > max) {
                alert("Short description Maximum " + max + " words allowed.your given words length is "+wordCount + "")
                return false;
            }
            return;
        }

        function validateUnitPrice(){
            var unit_value= $('#rfq-bid-modal input[name=unit_price]').val().length;
            if(unit_value == 0){
                $('#rfq-bid-form .validation-error-unit-price').text('Unit price required');
                return false;
            }else{
                $('#rfq-bid-form .validation-error-unit-price').text('');
            }
            return;
        }
        $('#rfq-bid-form').on('submit',function(e){
            e.preventDefault();
            var unit_value= $('#rfq-bid-modal input[name=offer_price]').val().length;
            if(unit_value == 0){
                $('#rfq-bid-form .validation-error-unit-price').text('Offer price required');
                return false;
            }else{
                $('#rfq-bid-form .validation-error-unit-price').text('');
            }
            var sso_auth_token = "Bearer " +"{{ Cookie::get('sso_token') }}";

            var formData = {
                rfq_id :$("#rfq-bid-modal input[name=rfq_id]").val(),
                business_profile_id: $("#rfq-bid-modal #my_business_list").val(),
                offer_price:$("#rfq-bid-modal input[name=offer_price]").val(),
                offer_price_unit:$("#rfq-bid-modal #offer_price_unit").val(),
                from_backend : 0,
            };
            var url="{{env('RFQ_APP_URL')}}/api/supplier-quotation-to-buyer";

            $.ajax({
                method: 'post',
                processData: false,
                dataType: 'json',
                contentType: 'application/json',
                cache: false,
                data: JSON.stringify(formData),
                enctype: 'multipart/form-data',
                url: url,
                headers: { 'Authorization': sso_auth_token },
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        console.log(data);
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#rfq_bid_store_errors').empty();
                        $('#rfq-bid-modal').modal('close');
                        var rfq_id=$('#rfq-bid-modal input[name=rfq_id]').val();
                        var res_count=$(".res_count_"+rfq_id+"_").text();
                            res_count=parseInt(res_count);
                        $(".res_count_"+rfq_id+"_").text(res_count+1);
                        $(".res_count_"+rfq_id+"_").closest('.responses_wrap').find('.bid_rfq').text('Replied');
                        const msg= 'Congratulations!!! Your Quotation has been successfully submitted. Buyer will contact you upon interest for further communication';
                        swal("Done!",msg,"success");

                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#rfq_bid_store_errors').empty();
                        $("#rfq_bid_store_errors").append("<div class=''>"+error+"</div>");
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#rfq_bid_store_errors").append("<div class=''>"+item+"</div>");

                        });

                    }
            });
        });

        $(document).ready(function(){
            $(".btn_view_detail").click(function(e){
                $(this).toggleClass("rfq_view_detail_info_open");
                $(this).next(".rfq_view_detail_info").slideToggle('slow');

                if($(this).text() == 'Show More')
                {
                    $(this).text('Show Less');
                }
                else
                {
                    $(this).text('Show More');
                }

            });
        });

        $(document).ready(function(){
            $(".btn_responses_trigger").click(function(){
                $(this).next(".respones_detail_wrap").toggle();
            });
        });

        $('.btn_view_detail').on('click',function(event){
            event.preventDefault();
            console.log('hi');
            let rfqId = $(this).attr("data-rfqId");

            let obj=$(this).closest('span');


            $.ajax({
                type:'GET',
                url: "{{route('notification-mark-as-read')}}",
                data:{ rfqId: rfqId},
                success: function (data) {
                    $('.noticication_counter').text(data['noOfnotification']);
                    obj.remove();
                }
            });
        });

        //open share model
        function openShareModel(link){
            var rfq_link=link;
            var url = '{{ route("show.rfq.using.link", ":slug") }}';
            url = url.replace(':slug', rfq_link);
            $('#share-modal').modal('open');
            $('#share-modal input[name=share_text]').val();
            $('#share-modal input[name=share_text]').val(url);
        }



</script>
@endpush
