@push('js')
<script src="{{ asset('js/jquery.tinyscrollbar.min.js') }}"></script>
<script>
    $(document).ready(function(){
        var envMode = "{{ env('APP_ENV') }}";
        var fromId;
        if(envMode == 'production') {
            fromId = '{{auth()->user()->sso_reference_id}}';
        } else{
            fromId = '{{auth()->user()->sso_reference_id}}';
        }

        $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
        $(".scrollabled").each(function(){
            $(this).tinyscrollbar();
        });
        var serverURL = "{{ env('CHAT_URL') }}?userId="+fromId;
            var socket = io.connect(serverURL);
        socket.on('connect', function(data) {
            console.log("Socket Connect successfully.");
        });

        socket.on('new message', function(data) {
            var authUserId = '{{auth()->user()->sso_reference_id}}';
            var activeRfqId = $('.quotation_tab').attr("data-rfq_id");

            // message for supplier
            if(data.factory == true && data.to_id == authUserId){
                var quotationClass = '.unseen_quotation_count_'+data.rfq_id;
                var unseenQuotationCount = $(quotationClass).attr('data-unseen_quotation_count');
                if(unseenQuotationCount == 0){
                    $(quotationClass).show();
                    $(quotationClass).text(parseInt( unseenQuotationCount == '' ? '0' : unseenQuotationCount)+1);
                    $(quotationClass).attr('data-unseen_quotation_count',parseInt(unseenQuotationCount)+1);
                }else{
                    $(quotationClass).show();
                    $(quotationClass).val(0);
                    $(quotationClass).text(parseInt(unseenQuotationCount)+1);
                    $(quotationClass).attr('data-unseen_quotation_count',parseInt(unseenQuotationCount)+1);
                }
            }
            // message for buyer
            else if(data.factory == false && data.to_id == authUserId){
                var messageClass = '.unseen_message_count_'+data.rfq_id;
                var unseenMessageCount = $(messageClass).attr('data-unseen_message_count');
                if(unseenMessageCount == 0){
                    $(messageClass).show();
                    $(messageClass).text(parseInt( unseenMessageCount == '' ? '0' : unseenMessageCount)+1);
                    $(messageClass).attr('data-unseen_message_count', parseInt(unseenMessageCount)+1);
                }else{
                    $(messageClass).show();
                    $(messageClass).val(0);
                    $(messageClass).text(parseInt(unseenMessageCount)+1);
                    $(messageClass).attr('data-unseen_message_count', parseInt(unseenMessageCount)+1);
                }
            }

            if( data.from_id == authUserId && activeRfqId == data.rfq_id ){
                var msgHtml = '<div class="rfq_message_box chat-right right">';
                    msgHtml += '<div class="chat-text right-align">';
                    msgHtml += '<p><span>'+data['message']+'</span></p>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
            }
            else if( data.to_id == authUserId && activeRfqId == data.rfq_id ){
                var msgHtml = '<div class="rfq_message_box chat-left left">';
                    msgHtml += '<div class="chat-text left-align">';
                    msgHtml += '<p><span>'+data['message']+'</span></p>';
                    msgHtml += '</div>';
                    msgHtml += '</div>';
            }

            // message for all admins
            if(data.to_id == 5771) {
                jQuery.ajax({
                    type : "get",
                    data : {'rfq_id':data.rfq_id},
                    url : "{{route('send_firebase_push_notification_to_all_admin_for_rfq_message')}}",
                    success : function(response){
                    }
                });
            }

            $('.rfq_review_message_box').append(msgHtml);
        });

        $('.messagebox').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                event.preventDefault();
                var from_user_image = '{{$userImage}}';
                let sent_message = $(this).val();
                var activeRfqId = $('.quotation_tab').attr("data-rfq_id");
                let from_user_sso_reference_id = '{{$user->sso_reference_id}}';
                var envMode = "{{ env('APP_ENV') }}";
                var to_user_id;
                if(envMode == 'production') {
                    to_user_id = '5771';
                } else{
                    to_user_id = '5552';
                }
                let message = {'message': sent_message, 'image': "", 'from_id' : from_user_sso_reference_id, 'to_id' : to_user_id, 'rfq_id': activeRfqId,'factory':false,'product': null};
                socket.emit('new message', message);
                $(".chat-area").animate({ scrollTop:$('#messagedata').prop("scrollHeight")});
                $(this).val('');
            }
        });

        $('.messageSendButton').click(function(event){
            event.preventDefault();
            var activeRfqId = $('.quotation_tab').attr("data-rfq_id");
            var from_user_image = '{{$userImage}}';
            let sent_message = $(this).closest('.rfq_message_box_bottom').children('.messagebox').val();
            let from_user_sso_reference_id = '{{$user->sso_reference_id}}';
            var envMode = "{{ env('APP_ENV') }}";
            var to_user_id;
            if(envMode == 'production') {
                to_user_id = '5771';
            } else{
                to_user_id = '5552';
            }
            let message = {'message': sent_message, 'image': "", 'from_id' : from_user_sso_reference_id, 'to_id' : to_user_id, 'rfq_id': activeRfqId,'factory':false,'product': null};
            socket.emit('new message', message);
            $(this).closest('.rfq_message_box_bottom').children('.messagebox').val('');
        });

        $(".reset_myrfq_filter").click(function(){
            location.href = "{{route('new.profile.my_rfqs', $alias)}}";
        });

        $(".reset_myquery_filter").click(function(){
            location.href = "{{route('new.profile.my_queries', $alias)}}";
        });

        $(".rfq-bid-send-trigger").click(function(){
            var business_profile_id = $(this).closest("#rfq-quotation-modal").find('input[name="bid_businessprofileid"]').val();
            var business_profile_name = $(this).closest("#rfq-quotation-modal").find('input[name="bid_businessprofilename"]').val();
            var rfq_id = $(this).closest("#rfq-quotation-modal").find('input[name="bid_rfqid"]').val();
            var offer_price = $(this).closest("#rfq-quotation-modal").find('input[name="offer_price"]').val();
            var offer_price_unit = $(this).closest("#rfq-quotation-modal").find('select[name="offer_price_unit"]').val();
            var url = "{{route('query.bid.store')}}";
            $.ajax({
                type:'post',
                url: url,
                dataType:'json',
                data:{business_profile_id: business_profile_id, business_profile_name: business_profile_name, rfq_id: rfq_id, offer_price: offer_price, offer_price_unit: offer_price_unit},
                beforeSend: function() {
                    $('.loading-message').html("Please Wait.");
                    $('#loadingProgressContainer').show();
                },
                success:function(data)
                {
                    window.location.reload();
                }
            });
        })

    });

</script>
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

        // RFQ sidebar fixed on scroll.
        // $(window).scroll(function() {
        //     var scroll = $(window).scrollTop();
        //     if (scroll >= 180) {
        //         $(".fixed-rfq-message-bar").css({"position": "fixed", "top": "75px", "max-width": "25%"});
        //     } else {
        //         $(".fixed-rfq-message-bar").css({"position": "inherit", "top": "inherit", "right": "inherit", "max-width": "100%"});
        //     }

        //     if ($(".fixed-rfq-message-bar").offset().top + $(".fixed-rfq-message-bar").height() > $(".footer_wrap").offset().top) {
        //         $(".fixed-rfq-message-bar").css({"position": "inherit", "top": "inherit", "right": "inherit", "max-width": "none"});
        //     }
        // });

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

            $(document).on("click", ".accountrfq_btn", function(e){
                $(this).parent().next(".account_rfqDetailes_infoWrap").slideToggle('slow');

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

            $('.message_tab').on('click',function(event){
                event.preventDefault();
                let rfqId = $(this).attr("data-rfq_id");
                $.ajax({
                    type:'GET',
                    url: "{{route('auth_user_conversations.by_rfq_id')}}",
                    data:{ rfqId: rfqId},
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success: function (response) {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();

                        $('.quotation_tab_li').removeClass("active");
                        $('.message_tab_li').addClass("active");
                        $('.rfq_quotation_box').hide();
                        $('.rfq_message_box').show();
                        $('.rfq_review_message_box').empty();
                        $('.my_rfq_quotation_box').hide();

                        var unseenMessageCountClass = '.unseen_message_count_'+rfqId;
                        $(unseenMessageCountClass).attr('data-unseen_message_count',0);
                        $(unseenMessageCountClass).text('');
                        $(unseenMessageCountClass).hide();

                        var authUserId = '{{auth()->user()->sso_reference_id}}';
                        for(var i=0;i<response.chats.length;i++){
                            if(response.chats[i].from_id == authUserId){
                                var html='<div class="rfq_message_box chat-right right">';
                                html+='<div class="chat-text right-align">';
                                html+='<p><span>'+response.chats[i].message+'</span></p>';
                                html+='</div>';
                                html+='</div>';
                            }else{
                                var html='<div class="rfq_message_box chat-left left">';
                                html+='<div class="chat-text left-align">';
                                html+='<p><span>'+response.chats[i].message+'</span></p>';
                                html+='</div>';
                                html+='</div>';
                            }
                            $('.rfq_review_message_box').append(html);

                        }

                    }
                });
            });

            $('.message-button, .profile_account_myrfq_box').on('click',function(event){
                event.preventDefault();
                let rfqId = $(this).attr("data-rfq_id");
                let pageTitle = "{{$pageTitle}}";
                console.log(pageTitle);
                $.ajax({
                    type:'GET',
                    url: "{{route('auth_user_conversations.by_rfq_id')}}",
                    data:{ rfqId: rfqId},
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success: function (response) {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();

                        $('.quotation_tab').attr("data-rfq_id",rfqId);
                        $('.my_quotation_tab').attr("data-rfq_id",rfqId);
                        $('.message_tab').attr("data-rfq_id",rfqId);
                        var rfqBoxClass = '.rfq_box_'+rfqId;
                        $('.profile_account_myrfq_box').removeClass("active");
                        $(rfqBoxClass).addClass("active");
                        $('.quotation_tab_li').removeClass("active");
                        $('.message_tab_li').addClass("active");
                        $('.rfq_quotation_box').hide();
                        $('.rfq_message_box').show();
                        $('.rfq_review_message_box').empty();
                        $('.my_rfq_quotation_box').hide();

                        var unseenMessageCountClass = '.unseen_message_count_'+rfqId;
                        $(unseenMessageCountClass).attr('data-unseen_message_count',0);
                        $(unseenMessageCountClass).text('');
                        $(unseenMessageCountClass).hide();

                        var html='<div class="titleBox">';
                            // html+='<h6>RFQ ID <span>'+response.rfq.id+'</span></h6>';
                            html+='<h5>'+response.rfq.title+'</h5>';
                            // html+='<span class="posted_time">'+response.rfq.created_at+'</span>';
                            if(pageTitle=="My Queries"){
                                if(response.quotationOffer) {
                                    html+='<span class="quotation_html"><span class="quotation_label">Your submitted quotation on this RFQ:</span> $ '+response.quotationOffer+' / '+response.quotationOfferunit+'</span>';
                                } else {
                                    html+='<span class="quotation_html"><span class="quotation_label">No quotation submitted.</span></span>';
                                }
                            }
                            html+='<div class="center-align btn_accountrfq_info">';
                            html+='<a class="accountrfq_btn" href="javascript:void(0);" onclick="">Show More</a>';
                            html+='</div>';
                            html+='<div id="accountRfqDetailesInfo" class="account_rfqDetailes_infoWrap" style="display: none;">';

                            if(pageTitle=="My Queries")
                            {
                                html+='<div class="row">';
                                html+='<div class="col s6 m6 l5">';
                                html+='<p>Quantity <br/> <b>'+response.rfq.id+' pcs</b></p>';
                                html+='<p>Deliver to <br/> <b>'+response.rfq.destination+'</b></p>';
                                html+='</div>';
                                html+='<div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>';
                                html+='<div class="col s6 m6 l5">';
                                html+='<p>Deliver in <br/> <b>'+response.rfq.delivery_time+'</b></p>';
                                html+='</div>';
                                html+='</div>';
                            }
                            else
                            {
                                html+='<div class="row">';
                                html+='<div class="col s6 m6 l5">';
                                html+='<p>Quantity <br/> <b>'+response.rfq.id+' pcs</b></p>';
                                html+='<p>Target Price <br/> <b>'+response.rfq.unit_price+' /pc</b></p>';
                                html+='</div>';
                                html+='<div class="col s6 m6 l2 proinfo_account_blank">&nbsp;</div>';
                                html+='<div class="col s6 m6 l5">';
                                html+='<p>Deliver in <br/> <b>'+response.rfq.delivery_time+'</b></p>';
                                html+='<p>Deliver to <br/> <b>'+response.rfq.destination+'</b></p>';
                                html+='</div>';
                                html+='</div>';
                            }

                            html+='<div class="row">';
                            html+='<div class="col s12 m12 l12">';
                            html+='<p>Description <br/> <b>'+response.rfq.full_specification+'</b></p>';
                            html+='</div>';
                            html+='</div>';
                            html+='<div class="account_rfqDetailes_imgWrap">';
                            html+='<h6>Attachments</h6>';
                            response.rfq.images.forEach((item, index)=>{
                                html+='<a href='+item.image+' data-fancybox><img src='+item.image+' /></a>';
                            })
                            html+='</div>';
                            html+='</div>';
                            $('.new_profile_myrfq_details_topbox').empty().append(html);
                            html+='</div>';

                        var authUserId = '{{auth()->user()->sso_reference_id}}';
                        for(var i=0;i<response.chats.length;i++){
                            if(response.chats[i].from_id == authUserId){
                                var html='<div class="rfq_message_box chat-right right ">';
                                html+='<div class="chat-text right-align">';
                                html+='<p><span>'+response.chats[i].message+'</span></p>';
                                html+='</div>';
                                html+='</div>';
                            }else{
                                var html='<div class="rfq_message_box chat-left left">';
                                html+='<div class="chat-text left-align">';
                                html+='<p><span>'+response.chats[i].message+'</span></p>';
                                html+='</div>';
                                html+='</div>';
                            }
                            $('.rfq_review_message_box').append(html);
                        }
                    }
                });
            });

            $('.my_quotation_tab').on('click',function(event){
                // $('.quotation_tab_li').addClass("active");
                // $('.message_tab_li').removeClass("active");
                // $('.my_rfq_quotation_box').show();
                // $('.rfq_message_box').hide();

                event.preventDefault();
                $('.my_rfq_review_results_box').empty();
                let rfqId = $(this).attr("data-rfq_id");
                $.ajax({
                    type:'GET',
                    url: "{{route('my_quotation.by_rfq_id')}}",
                    data:{ rfqId: rfqId},
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success: function (response) {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();
                        $('.my_rfq_review_results_box').append(response.html);
                        $('.quotation_tab_li').addClass("active");
                        $('.message_tab_li').removeClass("active");
                        $('.my_rfq_quotation_box').show();
                        $('.rfq_message_box').hide();

                        // var unseenQuotationCountClass = '.unseen_quotation_count_'+rfqId;
                        // $(unseenQuotationCountClass).attr('data-unseen_quotation_count',0);
                        // $(unseenQuotationCountClass).text('');
                        // $(unseenQuotationCountClass).hide();
                        //$('.rfq_review_results_box').empty().append(html);
                    }
                });
            })

            $('.quotation_tab').on('click',function(event){
                event.preventDefault();
                $('.rfq_review_results_box').empty();
                let rfqId = $(this).attr("data-rfq_id");
                $.ajax({
                    type:'GET',
                    url: "{{route('auth_user_quotations.by_rfq_id')}}",
                    data:{ rfqId: rfqId},
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success: function (response) {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();

                        for(var i=0;i<response.quotations.length;i++){
                            var offersSplit = response.quotations[i].message.split("offers");
                            var html ='<div class="quatationInfo">';
                                if(response.quotations[i].business_profile_image){
                                    html+='<span class="quatationProfile"><img src="{{ Storage::disk('s3')->url('public/') }}'+response.quotations[i].business_profile_image+'" alt="avatar" itemprop="img"></span>';
                                } else {
                                    html+='<span class="quatationProfile"><img src="{{ Storage::disk('s3')->url('public/account-images/avatar.jpg') }}" alt="avatar" itemprop="img"></span>';
                                }
                                html+='<span class="companyName">'+offersSplit[0]+'</span>';
                                html+='<span class="offerPriceBox">';
                                //html+='<span class="offers">Offers</span>';
                                html+='<span class="pointNum">'+offersSplit[1]+'</span>';
                                html+='</span>';
                                html+='</div>';
                            /*
                            var html ='<div class="row">';
                            html+='<div class="col s12 xl2 rfq_review_result_leftBox">';
                            html+='<span class="new_rfq_avatar">';
                            html+='<img src="{{ Storage::disk('s3')->url('public/account-images/avatar.jpg') }}" alt="avatar" itemprop="img">';
                            html+='</span>';
                            html+='</div>';
                            html+='<div class="col s12 xl5 rfq_review_result_midBox">';
                            html+='<div class="new_rfq_review">';
                            html+='<p><span>'+response.quotations[i].message+'</span> </p>';
                            //html+='<button class="btn_green">Ask for PI</button>';
                            html+='</div>';
                            html+='</div>';
                            //html+='<div class="col s12 xl5 rfq_review_result_rightBox">';
                            //html+='<div class="new_rfq_review">';
                            //html+='<span class="rfqEatting"><i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i></span>';
                            //html+='<span class="rqf_verified"><img src="./images/account-images/rfq-verified.png" alt=""> Verified</span>';
                            //html+='<button class="btn_green">Issue PO</button>';
                            //html+='</div>';
                            //html+='</div>';
                            html+='</div>';
                            */
                            $('.rfq_review_results_box').append(html);
                        }
                        $('.quotation_tab_li').addClass("active");
                        $('.message_tab_li').removeClass("active");
                        $('.rfq_quotation_box').show();
                        $('.rfq_message_box').hide();

                        var unseenQuotationCountClass = '.unseen_quotation_count_'+rfqId;
                        $(unseenQuotationCountClass).attr('data-unseen_quotation_count',0);
                        $(unseenQuotationCountClass).text('');
                        $(unseenQuotationCountClass).hide();
                        //$('.rfq_review_results_box').empty().append(html);
                    }
                });
            });

            $('.quotation-button').on('click',function(event){
                event.preventDefault();
                $('.rfq_review_results_box').empty();
                let rfqId = $(this).attr("data-rfq_id");
                $.ajax({
                    type:'GET',
                    url: "{{route('auth_user_quotations.by_rfq_id')}}",
                    data:{ rfqId: rfqId},
                    beforeSend: function() {
                        $('.loading-message').html("Please Wait.");
                        $('#loadingProgressContainer').show();
                    },
                    success: function (response) {
                        $('.loading-message').html("");
                        $('#loadingProgressContainer').hide();

                        for(var i=0;i<response.quotations.length;i++){
                            var offersSplit = response.quotations[i].message.split("offers");
                            var html ='<div class="quatationInfo">';
                                if(response.quotations[i].business_profile_image){
                                    html+='<span class="quatationProfile"><img src="{{ Storage::disk('s3')->url('public/') }}'+response.quotations[i].business_profile_image+'" alt="avatar" itemprop="img"></span>';
                                } else {
                                    html+='<span class="quatationProfile"><img src="{{ Storage::disk('s3')->url('public/account-images/avatar.jpg') }}" alt="avatar" itemprop="img"></span>';
                                }
                                html+='<span class="companyName">'+offersSplit[0]+'</span>';
                                html+='<span class="offerPriceBox">';
                                //html+='<span class="offers">Offers</span>';
                                html+='<span class="pointNum">'+offersSplit[1]+'</span>';
                                html+='</span>';
                                html+='</div>';
                            /*
                            var html ='<div class="row">';
                            html+='<div class="col s12 xl2 rfq_review_result_leftBox">';
                            html+='<span class="new_rfq_avatar">';
                            html+='<img src="{{ Storage::disk('s3')->url('public/account-images/avatar.jpg') }}" alt="avatar" itemprop="img">';
                            html+='</span>';
                            html+='</div>';
                            html+='<div class="col s12 xl5 rfq_review_result_midBox">';
                            html+='<div class="new_rfq_review">';
                            html+='<p><span>'+response.quotations[i].message+'</span> </p>';
                            //html+='<button class="btn_green">Ask for PI</button>';
                            html+='</div>';
                            html+='</div>';
                            //html+='<div class="col s12 xl5 rfq_review_result_rightBox">';
                            //html+='<div class="new_rfq_review">';
                            //html+='<span class="rfqEatting"><i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i> <i class="material-icons">star_border</i></span>';
                            //html+='<span class="rqf_verified"><img src="./images/account-images/rfq-verified.png" alt=""> Verified</span>';
                            //html+='<button class="btn_green">Issue PO</button>';
                            //html+='</div>';
                            //html+='</div>';
                            html+='</div>';
                            */
                            $('.rfq_review_results_box').append(html);
                        }
                        var unseenQuotationCountClass = '.unseen_quotation_count_'+rfqId;
                        $(unseenQuotationCountClass).attr('data-unseen_quotation_count',0);
                        $(unseenQuotationCountClass).text('');
                        $(unseenQuotationCountClass).hide();

                        var rfqBoxClass = '.rfq_box_'+rfqId;
                        $('.profile_account_myrfq_box').removeClass("active");
                        $(rfqBoxClass).addClass("active");
                        $('.quotation_tab_li').addClass("active");
                        $('.message_tab_li').removeClass("active");
                        $('.rfq_quotation_box').show();
                        $('.rfq_message_box').hide();
                        //$('.rfq_review_results_box').empty().append(html);

                    }
                });
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
