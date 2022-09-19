@push('js')
    <script type="text/javascript">
        $('.designer_data_form').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('_token', "{{ csrf_token() }}");
            const designer_profile_update_url = "{{route('single.designer.details.update')}}";
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                url: designer_profile_update_url,
                beforeSend: function() {
                    $('.loading-message').html("Please Wait.");
                    $('#loadingProgressContainer').show();
                },
                success:function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error)
                {
                    $('.loading-message').html("");
                    $('#loadingProgressContainer').hide();
                    swal("Error!", error,"error");
                }
            });
        });
    </script>
@endpush
