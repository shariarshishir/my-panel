<div class="card-body">
    <div class="admin_newsletter_form">
        <div class="row">
            <div class="col-sm-12 col-md-12" >
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{old('name', $newsletter->title)}}" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="pdf_path">PDF File:</label>
                    <div class="form-file-text"></div>
                    @if(isset($newsletter->pdf_path))
                    <div class="iframe_priview">
                        <a href="{{ Storage::disk('s3')->url('public/'.$newsletter->pdf_path) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Click here to view PDF">
                            <img src="https://s3.ap-southeast-1.amazonaws.com/development.service.products/public/frontendimages/iframe.png" alt="iframe preview" />
                        </a>
                    </div>
                    @endif
                    <div>
                        <a href="javascript:void(0)" class="btn btn-primary upload_trigger">
                            {{ isset($newsletter->pdf_path) ? 'Re-Upload PDF' : 'Upload PDF' }}
                        </a>
                    </div>
                    <input id="pdf_path" type="file" name="pdf_path" class="form-control" style="display: none;" />
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" class="editor form-control" name="description">{{old('description',$newsletter->description)}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

