<div class="card-body">
    <div class="admin_blog_form">
        <div class="row">
            <div class="col-sm-12 col-md-6" style="padding-right: 10px;">
                <div class="form-group">
                    <label for="term_and_condition">Term and condition name* :</label>
                    <input type="text" name="term_and_condition" class="form-control" id="title" value="{{old('term_and_condition', $proFormaTermAndCondition->term_and_condition)}}" placeholder="Term and condition">
                    @if($errors->has('term_and_condition'))
                    <div class="text-danger">{{ $errors->first('term_and_condition') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

