@extends('layouts.vendor')
@section('css')
<style>
    .fontColor {
        color:black
    }
    .td {
        padding-right: 15px;
    }
    .td2 {
        padding-left: 10px;
    }

</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
              </div><!-- /.col -->

              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
              </div><!-- /.col -->
          </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Product</h3>
                        </div>
                        <form method="POST" action="{{route('product.store',$vendorId)}}" enctype="multipart/form-data" id="seller_product_form">
                            @csrf


                            <div class="row">
                                <div class="col-md-6 product-details-block">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Product Name') }}</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus >
                                        @if($errors->has('name'))
                                            <div class="text-danger">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="product_type">{{ __('Product Type') }}</label>
                                        <div class="radio-block">
                                            <label>
                                                <input class="with-gap" name="product_type" type="radio" value="1" checked="checked"/>
                                                <span>Fresh Order</span>
                                            </label>
                                            <label>
                                                <input class="with-gap" name="product_type" type="radio" value="2" />
                                                <span>Ready Stock</span>
                                            </label>
                                        </div>
                                        @if($errors->has('product_type'))
                                            <div class="text-danger">{{ $errors->first('product_type') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <input name="is_new_arrival" type="checkbox" {{old('is_new_arrival')=='on'? 'checked' : " "}} />
                                            <span>{{ __('New Arrival') }}</span>
                                        </label>

                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <input name="is_featured" type="checkbox" {{old('is_featured')=='on'? 'checked' : " "}}/>
                                            <span>{{ __('Featured') }}</span>
                                        </label>

                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <input name="published" type="checkbox"  {{old('published')=='on'? 'checked' : " "}}/>
                                            <span>Published</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <input name="rel-products" type="checkbox"  {{old('rel-products')=='on'? 'checked' : " "}} />
                                            <span>Select Related Products</span>
                                        </label>
                                    </div>

                                    <div class="form-group related-product" style="display: none;">
                                        <label for="">Select Related Products</label>
                                        <select class="js-example-basic-multiple" name="related_products[]" multiple="multiple">

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="product_category_id">{{ __('Product Category') }}</label>
                                        <select name="category_id" class="select2 browser-default" >
                                            <option value="" selected="true">Choose your option</option>
                                                @foreach($category as $categoryitem)
                                                    <option value="{{$categoryitem['id']}}">{{$categoryitem['name']}}</option>
                                                        @if(!empty($categoryitem['children'])) <!-- 1st sub level -->
                                                            @foreach($categoryitem['children'] as $childcategoryitem)
                                                            <option value="{{ $childcategoryitem['id'] }}"> - {{ $childcategoryitem['name'] }}</option>
                                                                @if(!empty($childcategoryitem['children'])) <!-- 2nd sub level -->
                                                                    @foreach($childcategoryitem['children'] as $subchildcategoryitem)
                                                                    <option value="{{ $subchildcategoryitem['id'] }}"> -- {{ $subchildcategoryitem['name'] }}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                @endforeach
                                        </select>
                                        @if($errors->has('category_id'))
                                            <div class="text-danger">{{ $errors->first('category_id') }}</div>
                                        @endif
                                    </div>


                                    <div class="form-group fresh-rtd-attr">
                                        <label>Prices Breakdown</label>
                                        <div class="no_more_tables">
                                            <table class="fresh-order-attribute-table-block striped">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>Qty Min</th>
                                                        <th>Qty Max</th>
                                                        <th>Price (usd)</th>
                                                        <th>Lead Time (days)</th>
                                                        <th><a href="javascript:void(0);" class="btn btn-success" onclick="addFreshOrderAttribute()"><i class="fas fa-plus"></i></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-title="Qty Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>
                                                        <td data-title="Qty Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>
                                                        <td data-title="Price (usd)"><input name="price[]" id="price" type="text" class="form-control @error('price') is-invalid @enderror"  value="" placeholder="$" ></td>
                                                        <td data-title="Lead Time (days)"><input name="lead_time[]"  id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror"  value="" placeholder="Days"></td>
                                                        <td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeFreshOrderAttribute(this)"><i class="fas fa-minus"></i></a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group">
                                            <label for="copyright-price" class="col-form-label text-md-right">Copyright Price</label>
                                            <input id="copyright-price" type="number" class="form-control @error('copyright-price') is-invalid @enderror" name="copyright_price" value="{{ old('copyright-price') }}"  autocomplete="copyright-price" autofocus>
                                        </div>
                                    </div>

                                    <div class="stock-rtd-attr" style="display: none">
                                        <label>Available Size & Colors</label>
                                        <div class="col-md-12" id="color-size-block">
                                            <div class="no_more_tables">
                                                <table class="color-size-table-block striped">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>Color</th>
                                                            <th>Small</th>
                                                            <th>Medium</th>
                                                            <th>Large</th>
                                                            <th>Extra Large</th>
                                                            <th><a href="javascript:void(0);" class="btn btn-success" onclick="addProductColorSize()"><i class="fas fa-plus"></i></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td data-title="Color"><input type="text" value="" class="form-control" name="color_size[color][]" /></td>
                                                            <td data-title="Small"><input type="text" value="0" class="form-control" name="color_size[small][]" /></td>
                                                            <td data-title="Medium"><input type="text" value="0" class="form-control" name="color_size[medium][]" /></td>
                                                            <td data-title="Large"><input type="text" value="0" class="form-control" name="color_size[large][]" /></td>
                                                            <td data-title="Extra Large"><input type="text" value="0" class="form-control" name="color_size[extra_large][]" /></td>
                                                            <td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeProductColorSize(this)"><i class="fas fa-minus"></i></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Prices Breakdown</label>
                                            <div class="no_more_tables">
                                                <table class="ready-order-attribute-table-block striped">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>Qty Min</th>
                                                            <th>Qty Max</th>
                                                            <th>Price (usd)</th>
                                                            <th><a href="javascript:void(0);" class="btn btn-success" onclick="addReadyOrderAttribute()"><i class="fas fa-plus"></i></a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>
                                                            <td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>
                                                            <td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control @error('price') is-invalid @enderror"  value="" placeholder="$" ></td>
                                                            <td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeReadyOrderAttribute(this)"><i class="fas fa-minus"></i></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="availability" class="col-form-label text-md-right">Availability</label>
                                            <input id="availability" type="number" class="form-control @error('availability') is-invalid @enderror" name="availability" value="{{ old('availability') }}"  autocomplete="availability" autofocus>
                                        </div>
                                        @if($errors->has('moq'))
                                            <div class="text-danger">{{ $errors->first('availability') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="moq" class="col-form-label text-md-right">Minimum Order Quantity</label>
                                        <input id="moq" type="number" class="form-control @error('moq') is-invalid @enderror" name="moq" value="{{ old('moq') }}"  autocomplete="moq" autofocus>
                                    </div>
                                        @if($errors->has('moq'))
                                            <div class="text-danger">{{ $errors->first('moq') }}</div>
                                        @endif

                                    <input name="vendor_id" type="hidden" value="{{$vendorId}}"/>
                                </div>

                                <div class="col-md-6 product-upload-block">
                                    <div class="input-field">
                                        <label class="active">Image:</label>
                                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                                    </div>

                                </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="col-form-label text-md-right">{{ __('Short Description') }}</label>
                                        <textarea id="description" class="editor" name="description">{{old('description')}}</textarea>
                                    </div>
                                    @if($errors->has('description'))
                                        <div class="text-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                    <div class="form-group">
                                        <label for="additional_description" class="col-form-label text-md-right">{{ __('Additional Description') }}</label>
                                        <textarea id="additional_description" class="editor" name="additional_description">{{old('additional_description')}}</textarea>
                                    </div>
                                    @if($errors->has('additional_description'))
                                        <div class="text-danger">{{ $errors->first('additional_description') }}</div>
                                    @endif
                                </div>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-success seller_product_create">Save</button>
                            <a href="{{route('product.index', $vendorId)}}" class="btn btn-success">Cancel</a>
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

  $('.input-images-1').imageUploader();
</script>
<script src="{{asset('upload-js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{asset('upload-js/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('upload-js/jquery.fileupload.js')}}"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>

    $(document).ready(function (e) {
        $('#fileupload').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-before-upload').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

    $(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            add: function (e, data) {
                $('#loading').text('Uploading...');
                data.submit();
            },
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    console.log(file);
                    $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                    if ($('#file_ids').val() != '') {
                        $('#file_ids').val($('#file_ids').val() + ',');
                    }
                    $('#file_ids').val($('#file_ids').val() + file.fileID);
                });
                $('#loading').text('');
            }
        });
    });
</script>

<script>
    function addProductColorSize()
    {
    let totalChild = $('.color-size-table-block tbody').children().length;
    var html = '<tr>';
    html += '<td><input type="text" value="" class="form-control" name="color_size[color][]" /></td>';
    html += '<td><input type="text" value="0" class="form-control" name="color_size[small][]" /></td>';
    html += '<td><input type="text" value="0" class="form-control" name="color_size[medium][]" /></td>';
    html += '<td><input type="text" value="0" class="form-control" name="color_size[large][]" /></td>';
    html += '<td><input type="text" value="0" class="form-control" name="color_size[extra_large][]" /></td>';
    html += '<td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeProductColorSize(this)"><i class="fas fa-minus"></i></a></td>';
    html += '</tr>';
    $('.color-size-table-block tbody').append(html);
    }
    function removeProductColorSize(el)
    {
        $(el).parent().parent().remove();
    }

    function addFreshOrderAttribute()
    {
    let totalChild = $('.color-size-table-block tbody').children().length;
    var html = '<tr>';
    html += '<td data-title="Qty Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>';
    html += '<td data-title="Qty Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>';
    html += '<td data-title="Price (usd)"><input name="price[]" id="price" type="text" class="form-control @error('price') is-invalid @enderror"  value="" placeholder="$"></td>';
    html += '<td data-title="Lead Time (days)"><input name="lead_time[]" id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror"  value="" placeholder="Days"></td>';
    html += '<td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeFreshOrderAttribute(this)"><i class="fas fa-minus"></i></a></td>';
    html += '</tr>';
    $('.fresh-order-attribute-table-block tbody').append(html);
    }
    function removeFreshOrderAttribute(el)
    {
        $(el).parent().parent().remove();
    }

    function addReadyOrderAttribute()
    {
    let totalChild = $('.color-size-table-block tbody').children().length;
    var html = '<tr>';
    html += '<td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>';
    html += '<td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>';
    html += '<td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control @error('price') is-invalid @enderror"  value="" placeholder="$"></td>';
    html += '<td><a href="javascript:void(0);" class="btn btn-danger" onclick="removeFreshOrderAttribute(this)"><i class="fas fa-minus"></i></a></td>';
    html += '</tr>';
    $('.ready-order-attribute-table-block tbody').append(html);
    }
    function removeReadyOrderAttribute(el)
    {
        $(el).parent().parent().remove();
    }
  </script>

  <script>
       $('input[type=radio][name=product_type]').change(function() {
            if (this.value == '1') {
                $('.stock-rtd-attr').hide();
                $('.fresh-rtd-attr').show();
            }
            else if(this.value == '2') {
                $('.stock-rtd-attr').show();
                $('.fresh-rtd-attr').hide();
            }
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

    //related products
    $('.js-example-basic-multiple').select2();
    $(document).on('change','input[name=rel-products]',function(){
            if ($(this).prop("checked") == true) {
                $('.related-product').show();
                $.ajax({
                    method: 'get',
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: "{{route('admin.users.related.products')}}",
                    success:function(data)
                        {

                            $('.js-example-basic-multiple').html('');
                            $.each(data, function(key, value){
                            $('.js-example-basic-multiple').append('<option value="'+value.id+'">'+value.name+'</option>')
                            });

                        },
                    error: function(xhr, status, error)
                        {
                            $('#edit_errors').empty();
                            $("#edit_errors").append("<li class='alert alert-danger'>"+error+"</li>");

                        }
                });
            }
            else{
                $('.related-product').hide();
            }
    });

</script>

@endsection
