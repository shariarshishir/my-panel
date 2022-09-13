@extends('layouts.vendor')
@section('css')
<style>
    .fontColor{
        color:black
    }
    .td{
        padding-right: 15px;
    }
    .td2{
        padding-left: 10px;
    }
   .row>div {
  position: relative;
}

.singleimage {
  width: 300px;
  height: 300px;
  margin: 5px;
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
                            <h3 class="card-title">Edit Product</h3>
                        </div>
                        <form action="{{ route('product.update',['vendor'=>$vendorId,'product'=>$product->sku]) }}" method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">{{ __('Product Name') }}</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name', $product->name)}}"  autocomplete="name" autofocus required>
                                        @if($errors->has('name'))
                                            <div class="text-danger">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="product_type">{{ __('Product Type') }}</label><br>
                                        <label>
                                            <input class="with-gap" name="product_type" type="radio" value="1" @if($product->product_type==1) checked @endif disabled/>
                                            <span>Fresh Order</span>
                                        </label>
                                        <label>
                                            <input class="with-gap" name="product_type" type="radio" value="2" @if($product->product_type==2) checked @endif disabled/>
                                            <span>Ready Stock</span>
                                        </label>
                                        <input type="hidden" value="{{$product->product_type}}" name="product_type">
                                        @if($errors->has('product_type'))
                                            <div class="text-danger">{{ $errors->first('product_type') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <input name="is_new_arrival" type="checkbox"  {{ old("new_arrival", $product->is_new_arrival) == "1" ? 'checked' : '' }}/>
                                            <span>{{ __('New Arrival') }}</span>
                                        </label>

                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <input name="is_featured" type="checkbox"  {{ old("is_featured", $product->is_featured) == "1" ? 'checked' : ''}}/>
                                            <span>{{ __('Featured') }}</span>
                                        </label>

                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <input name="published" type="checkbox" {{ old("state", $product->state) == "1" ? 'checked' : ''}} />
                                            <span>Published</span>
                                        </label>

                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <input name="rel-products" type="checkbox"  {{  count($related_products_id) > 0 ? 'checked' : ''}}/>
                                            <span>Select Related Products</span>
                                        </label>
                                    </div>

                                    <div class="related-product form-group" style="{{ count($related_products_id) > 0 ? ' ' : 'display: none;' }}">
                                        <label for="">Select Related Products</label>
                                        <select class="js-example-basic-multiple" name="related_products[]" multiple="multiple">
                                              @foreach ($related_products as $key => $value)
                                                   <option value="{{ $key }}" @if (in_array($key,$related_products_id)) selected @endif>{{ $value }}</option>
                                              @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="product_category_id">{{ __('Product Category') }}</label>
                                        <select name="category_id" class="select2 browser-default" >
                                            @foreach($category as $categoryitem)
                                                <option value="{{$categoryitem['id']}}" @if($product->product_category_id==$categoryitem['id'])selected @endif >{{$categoryitem['name']}}</option>
                                                    @if(!empty($categoryitem['children'])) <!-- 1st sub level -->
                                                        @foreach($categoryitem['children'] as $childcategoryitem)
                                                        <option value="{{ $childcategoryitem['id'] }}" @if($product->product_category_id==$childcategoryitem['id'])selected @endif> - {{ $childcategoryitem['name'] }}</option>
                                                            @if(!empty($childcategoryitem['children'])) <!-- 2nd sub level -->
                                                                @foreach($childcategoryitem['children'] as $subchildcategoryitem)
                                                                <option value="{{ $subchildcategoryitem['id'] }}" @if($product->product_category_id==$subchildcategoryitem['id'])selected @endif> -- {{ $subchildcategoryitem['name'] }}</option>
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
                                    @if($product->product_type==1)
                                    <div class="form-group">
                                        <label>Prices Breakdown</label>
                                        <div class="no_more_tables">
                                            <table class="fresh-order-attribute-table-block">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>Quantity Min</th>
                                                        <th>Quantity Max</th>
                                                        <th>Price(usd)</th>
                                                        <th>Lead Time(days)</th>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </thead>
                                                
                                                @foreach($fresh_attr as $key=>$list)
                                                <tr>
                                                    <td data-title="Quantity Min"><input name="quantity_min[]" id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror" value="{{$list[0]}}" placeholder="1-100"></td>
                                                    <td data-title="Quantity Max"> <input name="quantity_max[]" id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror" value="{{$list[1]}}" placeholder="1-100"></td>
                                                    <td data-title="Price(usd)"><input name="price[]" id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{$list[2]}}" ></td>
                                                    <td data-title="Lead Time(days)"><input name="lead_time[]"  id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror" name="lead_time" value="{{$list[3]}}" ></td>
                                                    <td><a href="javascript:void(0);" class="btn btn-success" onclick="removeFreshOrderAttribute(this)"><i class="fa fa-minus fa-lg" aria-hidden="true" style="margin-top:6px;"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        
                                        <a href="javascript:void(0);" class="btn btn-success" onclick="addFreshOrderAttribute()"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>

                                        <div class="form-group">
                                            <label for="copyright-price" class="col-form-label text-md-right">Copyright Price</label>
                                            <input id="copyright-price" type="number" class="form-control @error('copyright-price') is-invalid @enderror" name="copyright_price" value="{{ old('copyright-price', $product->copyright_price) }}"  autocomplete="copyright-price" autofocus>
                                        </div>
                                    </div>
                                    @endif

                                    @if($product->product_type==2)
                                        <div class="col-md-12" id="color-size-block">
                                            <label>Available Size & Colors</label>
                                            <div class="row">
                                                <div class="no_more_tables">
                                                    <table class="color-size-table-block" width="100%" border="1" cellpadding="0" cellspacing="0">
                                                        <thead class="cf">
                                                            <tr>
                                                                <td>Color</td>
                                                                <td>Small</td>
                                                                <td>Medium</td>
                                                                <td>Large</td>
                                                                <td>Extra Large</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($colors_sizes as $color)
                                                                <tr>
                                                                    <td data-title="Color"><input type="text" value="{{$color->color}}" name="color_size[color][]" /></td>
                                                                    <td data-title="Small"><input type="text" value="{{$color->small}}" name="color_size[small][]" /></td>
                                                                    <td data-title="Medium"><input type="text" value="{{$color->medium}}" name="color_size[medium][]" /></td>
                                                                    <td data-title="Large"><input type="text" value="{{$color->large}}" name="color_size[large][]" /></td>
                                                                    <td data-title="Extra Large"><input type="text" value="{{$color->extra_large}}" name="color_size[extra_large][]" /></td>
                                                                    <td><a href="javascript:void(0);" class="btn btn-success" onclick="removeProductColorSize(this)"><i class="fa fa-minus fa-lg" aria-hidden="true" style="margin-top:6px;"></i></a></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0);" class="btn btn-success" onclick="addProductColorSize()"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
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
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($fresh_attr as $key=>$list)
                                                        <tr>
                                                            <td data-title="Qty Min"><input name="ready_quantity_min[]" id="ready_quantity_min" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="{{$list[0]}}" placeholder="Min. Value"></td>
                                                            <td data-title="Qty Max"><input name="ready_quantity_max[]" id="ready_quantity_max" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="{{$list[1]}}" placeholder="Max. Value"></td>
                                                            <td data-title="Price (usd)"><input name="ready_price[]" id="ready_price" type="text" class="form-control @error('price') is-invalid @enderror"  value="{{$list[2]}}" placeholder="$" ></td>
                                                            <td><a href="javascript:void(0);" class="btn btn-success" onclick="removeReadyOrderAttribute(this)"><i class="fa fa-minus fa-lg" aria-hidden="true"></i></a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <a href="javascript:void(0);" class="btn btn-success" onclick="addReadyOrderAttribute()"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="form-group">
                                            <label for="availability" class="col-form-label">Availability</label>
                                            <input id="availability" type="text" class="form-control @error('availability') is-invalid @enderror" name="availability" value="{{old('availability', $product->availability)}}"  required autocomplete="moq" autofocus>
                                            @if($errors->has('availability'))
                                                <div class="text-danger">{{ $errors->first('availability') }}</div>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="moq" class="col-form-label">Minimum Order Quantity</label>
                                        <input id="moq" type="number" class="form-control @error('moq') is-invalid @enderror" name="moq" value="{{$product->moq}}"  autocomplete="moq" autofocus>
                                    </div>
                                        @if($errors->has('moq'))
                                            <div class="text-danger">{{ $errors->first('moq') }}</div>
                                        @endif
                                    <input name="vendor_id" type="hidden" value="{{$vendorId}}"/>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="input-field">
                                        <label class="active">Image:</label>
                                        <div class="uploaded-product-images">
                                            @foreach ($product->images as $image)
                                                <div>
                                                    <center><img alt="preview-image" id="singleImage" src="{{asset('storage/'.$image->image)}}" alt="image" style="width:300px; height:300px;" /></center>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="col-form-label">{{ __('Description') }}</label>
                                        <textarea id="description" class="editor" name="description">{{old('description', $product->description)}}</textarea>
                                        @if($errors->has('description'))
                                        <div class="text-danger">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="additional_description" class="col-form-label">{{ __('Additional Description') }}</label>
                                        <textarea id="additional_description" class="editor" name="additional_description">{{old('additional_description', $product->additional_description)}}</textarea>
                                        @if($errors->has('additional_description'))
                                        <div class="text-danger">{{ $errors->first('additional_description') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            </div>
                            <input type="hidden" name="product_type" value="{{$product->product_type}}">
                            <button type="submit" class="btn btn-success">Update</button>
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
    let preloaded ={!! json_encode($preloaded) !!};
   $('.input-images-1').imageUploader({
       preloaded:preloaded
   });
</script>

<script src="{{asset('upload-js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{asset('upload-js/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('upload-js/jquery.fileupload.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    $('.uploaded-product-images').slick({
        dots: false,
        infinite: false,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1
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
    html += '<td data-title="Color"><input type="text" value="" class="form-control" name="color_size[color][]" /></td>';
    html += '<td data-title="Small"><input type="text" value="0" class="form-control" name="color_size[small][]" /></td>';
    html += '<td data-title="Medium"><input type="text" value="0" class="form-control" name="color_size[medium][]" /></td>';
    html += '<td data-title="Large"><input type="text" value="0" class="form-control" name="color_size[large][]" /></td>';
    html += '<td data-title="Extra Large"><input type="text" value="0" class="form-control" name="color_size[extra_large][]" /></td>';
    html += '<td><a href="javascript:void(0);" class="btn btn-success" onclick="removeProductColorSize(this)"><i class="fa fa-minus fa-lg" aria-hidden="true" style="margin-top:6px;"></i></a></td>';
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
    html += '<td data-title="Quantity Min"><input name="quantity_min[]" id="quantity_min" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Min. Value"></td>';
    html += '<td data-title="Quantity Max"><input name="quantity_max[]" id="quantity_max" type="text" class="form-control @error('quantity') is-invalid @enderror"  value="" placeholder="Max. Value"></td>';
    html += '<td data-title="Price(usd)"><input name="price[]" id="price" type="text" class="form-control @error('price') is-invalid @enderror"  value="" placeholder="$"></td>';
    html += '<td data-title="Lead Time(days)"><input name="lead_time[]" id="lead_time" type="text" class="form-control @error('lead_time') is-invalid @enderror"  value="" placeholder="Days"></td>';
    html += '<td><a href="javascript:void(0);" class="btn btn-success" onclick="removeFreshOrderAttribute(this)"><i class="fa fa-minus fa-lg" aria-hidden="true" style="margin-top:6px;"></i></a></td>';
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
    html += '<td><a href="javascript:void(0);" class="btn waves-effect waves-light red" onclick="removeFreshOrderAttribute(this)"><i class="material-icons dp48">remove</i></a></td>';
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

<script>
       $('imageposition').change(function() {
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

  <script>
    $(document).on("click", ".imagePosition" , function() {
        var id = $(this).attr("data-id");
        $(this).parent().remove();
        $.ajax({
            type:'GET',
            url: "/admin/delete-single-image",
            dataType:'json',
            data:{id :id },
            success: function(data){

            }
        });


    });
  </script>

<script type="text/javascript">
    $(document).ready(function() {

        var editor_config = {
            /*
            path_absolute : "/",
            selector: "textarea.editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
            */
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
            }
            else{
                $('.related-product').hide();
            }
    });


</script>


@endsection
