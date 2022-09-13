<div class="card-body">
    <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="name">Name :</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{old('name', $collection->name)}}" placeholder="Enter name">
                        @if($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                        @endif
                </div>
            </div>
    </div>
</div>

