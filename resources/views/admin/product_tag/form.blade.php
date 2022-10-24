<div class="card-body admin_product_Category">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="productTag">Tag Name :</label>
                <input type="text" name="name" class="form-control" id="productTag" value="{{old('name', $product_tag->name)}}" placeholder="Enter name">
                @if($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="parent">Tag Factory Types :</label>
                <select class="form-control select2" name="parent[]" multiple aria-label="multiple select example">
                    @foreach ($business_mapping_tree as $first )
                            @foreach ($first->children as $second)
                                    <optgroup label="{{$second->name}}">
                                        @foreach ($second->children as $item)
                                        <option value="{{$item->id}}"
                                            @if($product_tag->tagMapping)
                                                @foreach ($product_tag->tagMapping as $tag)
                                                    @if($tag->id == $item->id) selected @endif
                                                @endforeach
                                            @endif>
                                            {{$item->name}}
                                        </option>
                                        @endforeach
                                    </optgroup>
                            @endforeach
                    @endforeach
                </select>
                @if($errors->has('parent'))
                    <div class="text-danger">{{ $errors->first('parent') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Open this select menu',
        });
    });
</script>
@endpush
