<div class="card-body admin_product_Category">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="productCategory">Product Category Name :</label>
                <input type="text" name="name" class="form-control" id="productCategory" value="{{old('name', $productCategory->name)}}" placeholder="Enter productCategory">
                @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="parent_id">Seletct Parent :</label>
                <select name="parent_id" class="form-control parent-id" >
                    <option value="" selected="true">No Parent</option>
                    @foreach($outArray as $categoryitem)
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
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="admoin_category_img">
                @if($productCategory->image)
                <img id="preview-image" src="{{ asset('storage/'.$productCategory->image) }}"
                    alt="preview image" >
                @else
                <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                    alt="preview image" >
                @endif
            </div>
            <div class="form-group">
                <label for="productCategory">Image :</label>
                <input id="image" type="file" name="image" class="form-control" value="{{old('image', $productCategory->image)}}" placeholder="Enter productCategory">
                @if($errors->has('image'))
                <div class="text-danger">{{ $errors->first('image') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputStatus">Status :</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="1" {{ old("status", $productCategory->status) == "1" ? 'checked' : '' }}/>
                    <label class="form-check-label">Published</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="0" {{ old("status", $productCategory->status) == "0" ? 'checked' : '' }}>
                    <label class="form-check-label">Unpublished</label>
                </div>
                @if($errors->has('status'))
                <div class="text-danger">{{ $errors->first('status') }}</div>
                @endif
            </div>
        </div>
    </div>

</div>

