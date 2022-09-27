@foreach($orderQueries as $item)
    @if($item->orderModification)
        <div id="add-to-cart-order-query-modal" class="modal modal-fixed-footer order-query-details">
            <div class="modal-content">
                <legend>Details</legend>
                <div class="row order-top-block">
                    <div class="order-info-top col m6">
                        <p>Date: {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY , h:mm:ss a')}}</p>
                    </div>
                    <div class="order-status-block col m6">
                        <p>Status:
                            @switch($item->state)
                                    @case(1)
                                        Pending
                                        @break
                                    @case(2)
                                        Processed
                                        @break
                                    @case(3)
                                        Ordered
                                        @break
                                    @case(4)
                                        Cancel
                                        @break
                                    @default

                            @endswitch
                        </p>
                        {{-- //<a href="javascript:void(0);" class="waves-effect waves-green btn green">Shipped</a> --}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="color-and-size-block">
                        <div class="form-group row col s4">
                            <label for="unit-price" class="col-form-label ">Unit Price</label>
                            <input id="unit-price" class="unit-price" type="text" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" value="{{ $item->orderModification->unit_price }}"  autocomplete="unit_price" autofocus readonly>
                        </div>
                        <div class="no_more_tables">
                            <table class="color-size-table-block ord-mod-color-sizes">
                                <thead class="cf">
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
                                </thead>
                                <tbody class="ord-mod-color-tbody">
                                    @php $total_quantity= [] @endphp
                                    @foreach (json_decode($item->orderModification->colors_sizes) as $detail)
                                        @php array_push($total_quantity, $detail->xxs+$detail->xs+$detail->small+$detail->medium+$detail->large+$detail->extra_large+$detail->xxl+$detail->four_xxl+$detail->one_size); @endphp
                                        <tr>
                                            <td data-title="Color"><input type="text" value="{{ $detail->color }}" class="form-control" name="color" readonly/></td>
                                            <td data-title="XXS"><input type="text" value="{{ $detail->xxs }}" class="form-control count-color-size" name="xxs" readonly/></td>
                                            <td data-title="XS"><input type="text" value="{{ $detail->xs }}" class="form-control count-color-size" name="xs" readonly/></td>
                                            <td data-title="Small"><input type="text" value="{{ $detail->small }}" class="form-control count-color-size" name="small" readonly/></td>
                                            <td data-title="Medium"><input type="text" value="{{ $detail->medium }}" class="form-control count-color-size" name="medium" readonly/></td>
                                            <td data-title="Large"><input type="text" value="{{ $detail->large }}" class="form-control count-color-size" name="large" readonly/></td>
                                            <td data-title="Extra Large"><input type="text" value="{{ $detail->extra_large }}" class="form-control count-color-size" name="extra_large" readonly/></td>
                                            <td data-title="XXL"><input type="text" value="{{ $detail->xxl }}" class="form-control count-color-size" name="xxl" readonly/></td>
                                            <td data-title="XXXL"><input type="text" value="{{ $detail->xxxl }}" class="form-control count-color-size" name="xxxl" readonly/></td>
                                            <td data-title="4XXl"><input type="text" value="{{ $detail->four_xxl }}" class="form-control count-color-size" name="four_xxl" readonly/></td>
                                            <td data-title="One Size"><input type="text" value="{{ $detail->one_size }}" class="form-control count-color-size" name="one_size" readonly/></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @php  $total_quantity=array_sum($total_quantity); @endphp
                        <div class="form-group row">
                            <div class="col s2">
                                <label for="total-quantity" class="col-form-label ">Total Quantity</label>
                                <input id="total-quantity" type="number" class="form-control @error('total-quantity') is-invalid @enderror" name="total_quantity" value="{{ $total_quantity}}"  autocomplete="total-quantity" autofocus readonly>
                            </div>
                            <div class="col s2">
                                <label for="discount_type" class="col-form-label ">Discount type</label>
                                <select class="discount-type" name="discount_type" style="display: block !important;" >
                                    <option value="">select</option>
                                    <option value="1" {{ $item->orderModification->discount_type == 1 ? 'selected' : ''}} >Amount</option>
                                    <option value="2" {{ $item->orderModification->discount_type == 2 ? 'selected': ''  }}>Persentence</option>
                                </select>
                                {{-- <select class="form-select" aria-label="Default select example" name="discount_type" id="discount-type">
                                    <option value="">select</option>
                                    <option value="1" {{ $item->orderModification->discount_type ==1 ? 'selected' : ''}} >Amount</option>
                                    <option value="2" {{ $item->orderModification->discount_type == 2 ? 'selected': ''  }}>Persentence</option>
                                  </select> --}}
                            </div>
                            <div class="col s2">
                                <label for="discount" class="col-form-label ">Discount</label>
                                <input id="discount" type="text" class="form-control @error('discount_amount') is-invalid @enderror" name="discount" value="{{ $item->orderModification->discount ?? ''}}"  autocomplete="discount_amount" autofocus readonly>
                            </div>
                            <div class="col s2">
                                <label for="discount-amount" class="col-form-label ">Discount Amount</label>
                                <input id="discount-amount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" name="discount_amount" value="{{ $item->orderModification->discount_amount ?? ''}}"  autocomplete="discount_amount" autofocus readonly>
                            </div>
                            <div class="col s2">
                                <label for="total-price" class="col-form-label ">Total Price</label>
                                <input id="total-price" type="number" class="form-control @error('total-price') is-invalid @enderror" name="total_price" value="{{ $item->orderModification->total_price ?? ''}}""  autocomplete="total-price" autofocus readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="product_sku" value="{{ $item->product->product_sku }}">
                <input type="hidden" name="order_modification_req_id" value="{{ $item->id }}">
                <button type="submit" class="btn green waves-effect waves-light order-query-add-to-cart" id="order-query-add-to-cart">Add To Cart</button>
                </div>

                <div class="modal-footer">
                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
                    <i class="material-icons green-text text-darken-1">close</i>
                </a>
            </div>
        </div>
    @endif
@endforeach
