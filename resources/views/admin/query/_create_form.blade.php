
<form action="{{ route('query.request.store') }}" method="post" name="ordModCreateForm" id="ordModCreateForm" class="ordModCreateForm admin_order_create_form" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="color-and-size-block">
            <div class="no_more_tables">
                <table class="color-size-table-block ord-mod-color-sizes">
                    <thead class="cf">
                        @if($collection->product->product_type == 1 || $collection->product->product_type == 2)
                            <tr>
                                <th>Color</th>
                                <th>XXS</th>
                                <th>XS</th>
                                <th>Small</th>
                                <th>Medium</th>
                                <th>Large</th>
                                <th>Extra Large</th>
                                <th>XXL</th>
                                <th>XXXL</th>
                                <th>4XXL</th>
                                <th>One Size</th>
                                <!-- <th>&nbsp;</th> -->
                            </tr>
                        @endif
                        @if($collection->product->product_type == 3)
                        <tr>
                            <th>Color</th>
                            <th>Quantity</th>
                            <!-- <th>&nbsp;</th> -->
                        </tr>

                        @endif
                    </thead>
                    <tbody class="ord-mod-color-tbody">
                        @php $total_quantity= [] @endphp
                        {{-- readystock and buy design --}}
                        @if($collection->product->product_type == 1 || $collection->product->product_type == 2)
                            @foreach (json_decode($collection->details) as $detail)
                                @php array_push($total_quantity, $detail->xxs+$detail->xs+$detail->small+$detail->medium+$detail->large+$detail->extra_large+$detail->xxl+$detail->xxxl+$detail->four_xxl+$detail->one_size); @endphp
                                <tr>
                                    <td data-title="Color"><input type="text" value="{{ $detail->color }}" class="form-control" name="color_size[color][]" readonly/></td>
                                    <td data-title="XXS"><input type="text" value="{{ $detail->xxs }}" class="form-control count-color-size" name="color_size[xxs][]" readonly/></td>
                                    <td data-title="XS"><input type="text" value="{{ $detail->xs }}" class="form-control count-color-size" name="color_size[xs][]" readonly/></td>
                                    <td data-title="Small"><input type="text" value="{{ $detail->small }}" class="form-control count-color-size" name="color_size[small][]" readonly/></td>
                                    <td data-title="Medium"><input type="text" value="{{ $detail->medium }}" class="form-control count-color-size" name="color_size[medium][]" readonly/></td>
                                    <td data-title="Large"><input type="text" value="{{ $detail->large }}" class="form-control count-color-size" name="color_size[large][]" readonly/></td>
                                    <td data-title="Extra Large"><input type="text" value="{{ $detail->extra_large }}" class="form-control count-color-size" name="color_size[extra_large][]" readonly/></td>
                                    <td data-title="XXL"><input type="text" value="{{ $detail->xxl }}" class="form-control count-color-size" name="color_size[xxl][]" readonly/></td>
                                    <td data-title="XXXL"><input type="text" value="{{ $detail->xxxl }}" class="form-control count-color-size" name="color_size[xxxl][]" readonly/></td>
                                    <td data-title="4XXL"><input type="text" value="{{ $detail->four_xxl }}" class="form-control count-color-size" name="color_size[four_xxl][]" readonly/></td>
                                    <td data-title="One Size"><input type="text" value="{{ $detail->one_size }}" class="form-control count-color-size" name="color_size[one_size][]" readonly/></td>
                                </tr>
                            @endforeach
                        @endif
                        {{-- non-clothing-item --}}
                        @if($collection->product->product_type == 3)
                            @foreach (json_decode($collection->details) as $detail)
                                @php array_push($total_quantity, $detail->quantity); @endphp
                                <tr>
                                    <td><input type="text" value="{{ $detail->color }}" class="form-control" name="color_size[color][]" readonly/></td>
                                    <td><input type="text" value="{{ $detail->quantity }}" class="form-control count-color-size" name="color_size[quantity][]" readonly/></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
            @php  $total_quantity=array_sum($total_quantity); @endphp
            {{-- <a href="javascript:void(0);" class="btn waves-effect waves-light green add-more-block" onclick="addColorSize()"><i class="fas fa-plus-circle"></i> Add More</a> --}}
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group row amount-block">
        <div class="col-sm-12 col-md-6">
            <label for="unit-price" class="col-form-label ">Unit Price</label>
            <input id="unit-price" type="text"  class="unit-price form-control @error('unit_price') is-invalid @enderror price-value" name="unit_price" value="{{ old('unit_price') }}"  autocomplete="unit_price" autofocus>
        </div>
        <div class="col-sm-12 col-md-6">
            <label for="total-quantity" class="col-form-label ">Total Quantity</label>
            <input id="total-quantity" type="number" class="form-control @error('total-quantity') is-invalid @enderror" name="total_quantity" value="{{  $total_quantity}}"  autocomplete="total-quantity" autofocus readonly>
        </div>
        <div class="col-sm-12 col-md-6">
            <label for="discount_type" class="col-form-label ">Discount type</label>
            <select class="form-select form-control" aria-label="Default select example" name="discount_type" id="discount-type">
                <option value="">select</option>
                <option value="1">Amount</option>
                <option value="2">Persentence</option>
              </select>
        </div>
        <div class="col-sm-12 col-md-6">
            <label for="discount" class="col-form-label ">Discount</label>
            <input id="discount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" name="discount" value="{{ old('discount') }}"  autocomplete="discount_amount" autofocus>
        </div>
        <div class="col-sm-12 col-md-6">
            <label for="discount-amount" class="col-form-label ">Discount Amount</label>
            <input id="discount-amount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" name="discount_amount" value="{{ old('discount_amount') }}"  autocomplete="discount_amount" autofocus readonly>
        </div>
        <div class="col-sm-12 col-md-6">
            <label for="total-price" class="col-form-label ">Total Price</label>
            <input id="total-price" type="number" class="form-control @error('total-price') is-invalid @enderror" name="total_price" value="{{ old('total-price') }}"  autocomplete="total-price" autofocus readonly>
        </div>
    </div>
    <div class="clearfix"></div>

   <input type="hidden" name="ord_mod_req_id" value="{{ $collection->id }}">
   <input type="hidden" name="product_sku" value="{{ $collection->product->sku }}">
   <input type="hidden" name="product_name" value="{{ $collection->product->name}}">
   <button type="submit" class="btn btn-success" id="submitordModCreateForm">Submit</button>
</form>
