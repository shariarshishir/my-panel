<div class="card-body admin_product_Category">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="businessMappingTree">Name :</label>
                <input type="text" name="name" class="form-control" id="businessMappingTree" value="{{old('name', $businessMappingTree->name)}}" placeholder="Enter name">
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
                        <option value="{{$categoryitem['id']}}" @if (isset($businessMappingTree->parent) && $businessMappingTree->parent->id == $categoryitem['id']) selected @endif>{{$categoryitem['name']}}</option>
                            @if(!empty($categoryitem['children'])) <!-- 1st sub level -->
                                @foreach($categoryitem['children'] as $childcategoryitem)
                                <option value="{{ $childcategoryitem['id'] }}" @if (isset($businessMappingTree->parent) && $businessMappingTree->parent->id == $childcategoryitem['id']) selected @endif> - {{ $childcategoryitem['name'] }}</option>
                                    @if(!empty($childcategoryitem['children'])) <!-- 2nd sub level -->
                                        @foreach($childcategoryitem['children'] as $subchildcategoryitem)
                                        <option value="{{ $subchildcategoryitem['id'] }}" @if (isset($businessMappingTree->parent) && $businessMappingTree->parent->id == $subchildcategoryitem['id']) selected @endif> -- {{ $subchildcategoryitem['name'] }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

