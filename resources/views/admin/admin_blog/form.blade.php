<div class="card-body">
    <div class="admin_blog_form">
        <div class="row">
            <div class="col-sm-12 col-md-6" style="padding-right: 10px;">
                <div class="form-group">
                    <label for="title">Post Title* :</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{old('name', $blog->title)}}" placeholder="Post Title">
                    @if($errors->has('title'))
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="details" class="col-form-label text-md-right">{{ __('Details') }}</label>
                    <textarea id="details" class="editor" name="details">{{old('details',$blog->details)}}</textarea>
                    @if($errors->has('details'))
                        <div class="text-danger">{{ $errors->first('details') }}</div>
                    @endif
                </div>
                <div class="blog_feature_image_wrap">
                    <label >Feature image :</label>
                    <div class="feature_image">
                        @if($blog->feature_image)
                        <img id="preview-image-for-blog" src="{{Storage::disk('s3')->url('public/'.$blog->feature_image)}}"
                            alt="preview image" >
                        @else
                        <img id="preview-image-for-blog" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                            alt="preview image" >
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="feature_image">Choose feature image :</label>
                        <input id="feature_image" type="file" name="feature_image" class="form-control">
                        @if($errors->has('feature_image'))
                        <div class="text-danger">{{ $errors->first('feature_image') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6" style="padding-left: 10px;">
                <div class="form-group">
                    <label for="author_name">Author Name* :</label>
                    <input type="text" name="author_name" class="form-control" id="author_name" value="{{old('name', $blog->author_name)}}" placeholder="Author">
                    @if($errors->has('title'))
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="author_note" class="col-form-label text-md-right">{{ __('Author note') }}</label>
                    <textarea id="author_note" class="editor" name="author_note">{{old('author_note',$blog->author_note)}}</textarea>
                    @if($errors->has('author_note'))
                    <div class="text-danger">{{ $errors->first('author_note') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="parent_id">Author image :</label>
                    <div class="blog_feature_image_wrap">
                        @if($blog->author_img)
                        <img id="preview-image-for-author" src="{{Storage::disk('s3')->url('public/'.$blog->author_img)}}"
                            alt="preview image">
                        @else
                        <img id="preview-image-for-author" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                            alt="preview image">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="author_img">Choose Author image :</label>
                        <input id="author_img" type="file" name="author_img" class="form-control" >
                        @if($errors->has('author_img'))
                        <div class="text-danger">{{ $errors->first('author_img') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6" style="padding-right: 10px;">
                <div class="sourceList">
                    <label>Source</label>
                    @if(isset($blog->source))
                        @foreach($blog->source as $key=>$source)
                        <div class="form-group">
                            <div class="sourceItem">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="source[0][name]" value="{{$blog->source[$key]['name']}}" placeholder="Name" style="margin-bottom: 10px;" />
                                </div>
                                <div class="input-group">
                                    <input type="url" class="form-control" name="source[0][link]" value="{{$blog->source[$key]['link']}}"  placeholder="URL" />
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info js__adder"><i class="fas fa-plus"></i> Add More</button>
                                    <button type="button" class="btn btn-danger js__remover"><i class="fas fa-times"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="form-group">
                        <div class="sourceItem">
                            <div class="input-group">
                                <input type="text" class="form-control" name="source[0][name]" placeholder="Name" style="margin-bottom: 10px;" />
                            </div>
                            <div class="input-group">
                                <input type="url" class="form-control" name="source[0][link]" placeholder="URL" />
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-info js__adder"><i class="fas fa-plus"></i> Add More</button>
                                <button type="button" class="btn btn-danger js__remover"><i class="fas fa-times"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 col-md-6" style="padding-left: 10px;">
                <div class="form-group">
                    <label>Photo Courtesy</label>
                    <input type="text" name="photo_credit" value="{{old('photo_credit',$blog->photo_credit)}}" class="form-control">
                    @if($errors->has('photo_credit'))
                    <div class="text-danger">{{ $errors->first('photo_credit') }}</div>
                    @endif
                </div>
            </div>

        </div>
        <div><legend>Meta Information</legend></div>
        <div class="row">
            <div class="col-sm-12 col-md-6" style="padding-right: 10px;">
                <div class="form-group">
                    <label for="title">Meta Title* :</label>
                    <input type="text" name="meta_title" class="form-control" id="meta_title" value="{{old('meta_title', $blog->meta_title??'')}}" placeholder="Meta Title">
                    @if($errors->has('meta_title'))
                    <div class="text-danger">{{ $errors->first('meta_title') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="meta_description" class="col-form-label text-md-right">{{ __('Meta Description') }}</label>
                    <textarea id="meta_description" class="editor" name="meta_description">{{old('meta_description',$blog->meta_description??'')}}</textarea>
                    @if($errors->has('meta_description'))
                        <div class="text-danger">{{ $errors->first('meta_description') }}</div>
                    @endif
                </div>
                <input id="meta_type" type="hidden" name="meta_type" value="post" class="form-control">
                <div class="blog_meta_image_wrap">
                    <label >Meta image :</label>
                    <div class="meta_image">
                        @if(isset($blog->meta_image))
                        <img id="preview-image-for-meta" src="{{Storage::disk('s3')->url('public/'.$blog->meta_image)}}"
                            alt="preview image">
                        @else
                        <img id="preview-image-for-meta" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                            alt="preview image">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="meta_image">Choose Meta image :</label>
                        <input id="meta_image" type="file" name="meta_image" class="form-control">
                        @if($errors->has('meta_image'))
                        <div class="text-danger">{{ $errors->first('meta_image') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

