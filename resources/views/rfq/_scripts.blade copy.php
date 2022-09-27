@push('js')
<script>
        //create bid rfq
        function openBidRfqModal(id){
            var rfq_id=id;
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
                            $('#rfq-bid-modal .rfq_img_upload_wrap').show();
                            $('#rfq-bid-modal .previous-image-show').hide();

                            $('#rfq-bid-modal input[name=rfq_id]').val(data.data.id);
                            $('#rfq-bid-modal input[name=title]').val(data.data.title);
                            $('#rfq-bid-modal input[name=unit]').val(data.data.unit);
                            $('#rfq-bid-modal input[name=destination]').val(data.data.destination);

                            $('#my_business_list').html('');
                            $.each(data.my_business, function (i, item) {
                                    $('#my_business_list').append($('<option>', {
                                        value: item.id,
                                        text : item.business_name
                                    }));
                            });
                            if(data.hasOwnProperty('bid')){
                                $('#my_business_list').val(data.bid.business_profile_id);
                                $('#my_business_list').trigger('change');
                                $('#rfq-bid-modal input[name=quantity]').val(data.bid.quantity);
                                tinymce.get("product-bidding-desc").setContent(data.bid.description);
                                $('#rfq-bid-modal input[name=unit_price]').val(data.bid.unit_price);
                                $('#rfq-bid-modal input[name=total_price]').val(data.bid.total_price);
                                $('#product-payment-method').val(data.bid.payment_method);
                                $('#product-payment-method').trigger('change');
                                $('#rfq-bid-modal input[name=delivery_time]').val(data.bid.delivery_time);
                                $('#rfq-bid-modal .rfq-replay-submit').prop("disabled", true);
                                $('#rfq-bid-modal .rfq_img_upload_wrap').hide();
                                $('#rfq-bid-modal .previous-image-show').show();
                                $('#rfq-bid-modal .previous-image-show').html('');
                                $.each(JSON.parse(data.bid.media) ,function(key, item){
                                    var image="{{asset('storage')}}"+"/"+item;
                                    var html='<div class="replied_image">';
                                        html+='<img src="'+image+'" width="100%" alt="media">';
                                        html+= '</div>';
                                    $('#rfq-bid-modal .previous-image-show').append(html);
                                });

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
        $('#rfq-bid-form').on('submit',function(e){
            e.preventDefault();
            tinyMCE.triggerSave();
            var formData = new FormData(this);
            var url = '{{ route("rfq.bid.store") }}';
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
                        $('#rfq_bid_store_errors').empty();
                        $('#rfq-bid-modal').modal('close');
                        var rfq_id=$('#rfq-bid-modal input[name=rfq_id]').val();
                        var res_count=$(".res_count_"+rfq_id+"_").text();
                            res_count=parseInt(res_count);
                        $(".res_count_"+rfq_id+"_").text(res_count+1);
                        $(".res_count_"+rfq_id+"_").closest('.responses_wrap').find('.bid_rfq').text('Replied');
                        swal("Done!", data.msg,"success");

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


</script>
@endpush
