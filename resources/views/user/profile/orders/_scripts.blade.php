@push('js')
    <script>
        var table= $('#ordertable').DataTable({
            "order": [[ 0, "desc" ]],
        });

        $(document).on('click', '.colorSizeModal', function(){
            $(this).siblings('#colorSizeModal').modal('open');
        });

        //get order type data
        $('#filter_order_type').change(function(){
            var order_type= $(this).val();
            var url = '{{ route("order.type.filter") }}';
            $.ajax({
                method: 'get',
                data: {order_type : order_type },
                url: url,
                beforeSend: function() {
                $('.loading-message').html("Please Wait.");
                $('#loadingProgressContainer').show();
                },
                success:function(data)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('.order-data').html('');
                        $('.order-data').html(data.data);


                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        $('#errors').empty();
                        $("#errors").append("<li class='alert alert-danger'>"+error+"</li>")
                        $.each(xhr.responseJSON.error, function (key, item)
                        {
                            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
                        });
                    }
            });
            });
    </script>
@endpush
