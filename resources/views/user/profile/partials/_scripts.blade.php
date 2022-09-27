@push('js')
<script>
$('.profile-banner-upload-trigger').click(function(){
    $(this).next(".profile-banner-upload-trigger-alias").click();
})
var $modal = $('#banner-img-preview-modal');
var image = document.getElementById('profile-banner-image-preview');
var cropper;
$(document).on("change", ".profile-banner-upload-trigger-alias", function(e) {
    var files = e.target.files;
    var done = function(url) {
        image.src = url;
        $modal.modal('open');
        cropper = new Cropper(image, {
            aspectRatio: 5,
            viewMode: 0,
            preview: '.preview',
            crop(event) {
                console.log(event.detail.x);
                console.log(event.detail.y);
                console.log("width - "+event.detail.width);
                console.log("Height - "+event.detail.height);
            },
        });
    };

    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});
// $modal.on('shown.bs.modal', function() {
//     cropper = new Cropper(image, {
//         aspectRatio: 1,
//         viewMode: 3,
//         preview: '.preview'
//     });
// }).on('hidden.bs.modal', function() {
//     cropper.destroy();
//     cropper = null;
// });

$(document).on('click', '#crop' ,function () {
    canvas = cropper.getCroppedCanvas({
        width: 1124,
        height: 222,
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            var base64data = reader.result;
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{route('banner.update')}}",
                data: {
                    '_token': $('meta[name="_token"]').attr('content'),
                    'image': base64data
                },
                success: function(data) {
                    $modal.modal('close');
                    var image="{{asset('storage/')}}"+'/'+data.user.user_banner;
                    $('#preview-banner-before-upload').attr('src', image);
                    swal(data.message);
                     $(".profile-banner-upload-trigger-alias").val('');
                     $('#profile-banner-image-preview').attr('src', '');
                     cropper.destroy();
                     cropper = null;
                }
            });
        }
    });
})


//close cropper image modal
$(document).on('click', '.cropper-image-modal-close', function () {
    $modal.modal('close');
    $(".profile-banner-upload-trigger-alias").val('');
    $('#profile-banner-image-preview').attr('src', '');
    cropper.destroy();
    cropper = null;
});
</script>

@endpush
