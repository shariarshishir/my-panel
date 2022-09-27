<div class="card-body">
    <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="name">Name :</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{old('name', $merchantAssistance->name)}}" placeholder="Enter assistance name">
                    @if($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" name="description" class="form-control" id="description" value="{{old('description', $merchantAssistance->description)}}" placeholder="Enter Description">
                    @if($errors->has('description'))
                        <div class="text-danger">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="amount">Amount :</label>
                    <input type="number" name="amount" class="form-control" id="amount" value="{{old('amount', $merchantAssistance->amount)}}">
                    @if($errors->has('amount'))
                        <div class="text-danger">{{ $errors->first('amount') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="parent_id">Seletct Parent :</label>
                    <select name="type" class="form-control parent-id" >
                        <option value="" selected="true">Select type of Assistancy</option>
                        <option value="USD" {{$merchantAssistance->type == 'USD' ? 'selected' : ''}} >USD</option>
                        <option value="Percentage"  {{$merchantAssistance->type == 'Percentage' ? 'selected' : ''}}>Percentage</option>
                    </select>
                </div>
            </div>
    </div>
</div>

