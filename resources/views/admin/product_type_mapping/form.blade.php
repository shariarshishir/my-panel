<div class="card-body admin_product_Category">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="productTypeMapping">Title:</label>
                <input type="text" name="title" class="form-control" id="productTypeMapping" value="{{old('title', $productTypeMapping->title)}}" placeholder="Enter title">
                @if($errors->has('title'))
                <div class="text-danger">{{ $errors->first('title') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="parent_id">Seletct Parent :</label>
                <select name="parent_id" class="form-control parent-id" >
                    <option value="" selected="true">No Parent</option>
                    @foreach($outArray as $categoryitem)
                        <option value="{{$categoryitem['id']}}" @if (isset($productTypeMapping->parent) && $productTypeMapping->parent->id == $categoryitem['id']) selected @endif> {{$categoryitem['title']}}</option>
                            {{-- @if(!empty($categoryitem['children'])) <!-- 1st sub level -->
                                @foreach($categoryitem['children'] as $childcategoryitem)
                                <option value="{{ $childcategoryitem['id'] }}"> - {{ $childcategoryitem['title'] }}</option>
                                    @if(!empty($childcategoryitem['children'])) <!-- 2nd sub level -->
                                        @foreach($childcategoryitem['children'] as $subchildcategoryitem)
                                        <option value="{{ $subchildcategoryitem['id'] }}"> -- {{ $subchildcategoryitem['title'] }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif --}}
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

