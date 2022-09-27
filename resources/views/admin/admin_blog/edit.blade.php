@extends('layouts.admin')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blogs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Blog</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('blogs.update',$blog->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.admin_blog.form')
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection
@section('js')
<script>
      $(document).ready(function (e) {
        $('#author_img').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-for-author').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

</script>

<script>
      $(document).ready(function (e) {
        $('#feature_image').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-for-blog').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

</script>
<script>
      $(document).ready(function (e) {
        $('#meta_image').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-for-meta').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

</script>
<script type="text/javascript">
    
    $(document).ready(function() {

        var editor_config = {
            path_absolute : "/",
            selector: 'textarea.editor',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            /* enable title field in the Image dialog*/
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
                URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                images_upload_url: 'postAcceptor.php',
                here we add custom filepicker only to Image dialog
            */
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                /*
                Note: In modern browsers input[type="file"] is functional without
                even adding it to the DOM, but that might not be the case in some older
                or quirky browsers like IE, so you might want to add it to the DOM
                just in case, and visually hide it. And do not forget do remove it
                once you do not need it anymore.
                */

                input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    /*
                    Note: Now we need to register the blob in TinyMCEs image blob
                    registry. In the next release this part hopefully won't be
                    necessary, as we are looking to handle it internally.
                    */
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
                };

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        };

        function applyMCE() {
            tinymce.init(editor_config);
        }

        applyMCE();
    });
  </script>

  <script>
    $(document).ready(function(){

    $('.sourceList').on('click','.js__adder',function(e){
        e.preventDefault();
        $itme = $(this).closest('.form-group').clone();
        $itme.find('input[type=text]').val('');
        $itme.find('input[type=url]').val('');

        $itme.removeClass('has-feedback has-error').find('.help-block').remove();

        $itme.appendTo('.sourceList');
        rearangeInputsTechpackForm($('.sourceList'));
    });


// $('.sourceList').on('click','.js__remover',function(){
//     $(this).closest('.sourceItem-old').remove();
//     rearangeInputsTechpackForm($('.sourceList'));
// });
$('.sourceList').on('click','.js__remover',function(){
    $(this).closest('.form-group').remove();
    rearangeInputsTechpackForm($('.sourceList'));
});



function rearangeInputsTechpackForm($list) {
    $list.find('.form-group').each(function (idx) {
        $inputs = $(this).find('[name*="source"]');
        $inputs.each(function () {
            $name = $(this).attr('name');
            $(this).attr('name',$name.replace(/\d+/i,idx));
        });
    });
}

});
  </script>
<script>
  function addSourceUrl()
    {

        var html = '<tr>';
        html += '<td><input name="source[][name]" id="source_name" type="text"   value="" ></td>';
        html += '<td><input name="source[][url]" id="source_url" type="text"     value="" ></td>';
        html += '<td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeSourceItem(this)"><i class="fas fa-minus"></i></a></td>';
        html += '</tr>';
        $('.sourceList-table-block tbody').append(html);
    }
    function removeSourceItem(el)
    {
        $(el).parent().parent().remove();
    }
</script>

@endsection


