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
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" name="description" class="form-control" id="description" value="{{old('description', $collection->description)}}" placeholder="Enter Description">
                        @if($errors->has('description'))
                        <div class="text-danger">{{ $errors->first('description') }}</div>
                        @endif
                </div>
            </div>
    </div>
</div>

