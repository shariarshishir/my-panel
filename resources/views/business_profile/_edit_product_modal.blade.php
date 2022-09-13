<div id="product-edit-modal-block" class="modal ">

    <form action="" method="post" enctype="multipart/form-data" id="manufacture-product-update-form">
        @csrf
        <div class="modal-content">

        </div>




        <input type="hidden" name="remove_video_id">
    </form>

    <!-- <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div> -->

</div>

@push('js')
<script>
        //remove single  image
        function removeManufactureImage(obj){
            var check= confirm('are you sure?');
            if(check != true){
                return false;
            }
            var single_image_id= $(obj).attr('dataid');
            var url = '{{ route("remove.manufacture.single.image", ":slug") }}';
                url = url.replace(':slug', single_image_id);
            var obj=obj;
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
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();

                        $(obj).parent().parent().parent().parent().find('.img-thumbnail').attr('src', 'https://via.placeholder.com/380');
                        var html='<button type="button" class="btn_upload" style="background:#55A860; color:#fff;" onclick="$(this).parent().parent().prev().click();"><i class="fa fa-upload" aria-hidden="true"></i></button>';
                        $(obj).parent().parent().find('.btn-upload-wholesaler-img').show();
                        $(obj).remove();
                    },
                error: function(xhr, status, error)
                    {
                        $('.loading-message').html("");
		                $('#loadingProgressContainer').hide();
                        alert(error);

                    }
            });
        }
</script>
@endpush
