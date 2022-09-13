@foreach($orderQueries as $item)
        <div id="query-request-details-modal_{{$item->id}}" class="modal modal-fixed-footer">
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
                                    @foreach (json_decode($item->details) as $detail)
                                        @php array_push($total_quantity, $detail->xxs+$detail->xs+$detail->small+$detail->medium+$detail->large+$detail->extra_large+$detail->xxl+$detail->four_xxl+$detail->one_size); @endphp
                                        <tr>
                                            <td data-title="color"><input type="text" value="{{ $detail->color }}" class="form-control" name="color_size[color][]" /></td>
                                            <td data-title="XXS"><input type="text" value="{{ $detail->xxs }}" class="form-control count-color-size" name="color_size[xxs][]" /></td>
                                            <td data-title="XS"><input type="text" value="{{ $detail->xs }}" class="form-control count-color-size" name="color_size[xs][]" /></td>
                                            <td data-title="Small"><input type="text" value="{{ $detail->small }}" class="form-control count-color-size" name="color_size[small][]" /></td>
                                            <td data-title="Medium"><input type="text" value="{{ $detail->medium }}" class="form-control count-color-size" name="color_size[medium][]" /></td>
                                            <td data-title="Large"><input type="text" value="{{ $detail->large }}" class="form-control count-color-size" name="color_size[large][]" /></td>
                                            <td data-title="Extra Large"><input type="text" value="{{ $detail->extra_large }}" class="form-control count-color-size" name="color_size[extra_large][]" /></td>
                                            <td data-title="XXL"><input type="text" value="{{ $detail->xxl }}" class="form-control count-color-size" name="color_size[xxl][]" /></td>
                                            <td data-title="XXXL"><input type="text" value="{{ $detail->xxxl }}" class="form-control count-color-size" name="color_size[xxxl][]" /></td>
                                            <td data-title="4XXL"><input type="text" value="{{ $detail->four_xxl }}" class="form-control count-color-size" name="color_size[four_xxl][]" /></td>
                                            <td data-title="One Size"><input type="text" value="{{ $detail->one_size }}" class="form-control count-color-size" name="color_size[one_size][]" /></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       
                        @php  $total_quantity=array_sum($total_quantity); @endphp
                        <div class="col-md-2">
                            <label for="total-quantity" class="col-form-label ">Total Quantity</label>
                            <input id="total-quantity" type="number" class="form-control @error('total-quantity') is-invalid @enderror" name="total_quantity" value="{{  $total_quantity}}"  autocomplete="total-quantity" autofocus readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
                    <i class="material-icons green-text text-darken-1">close</i>
                </a>
            </div>
        </div>
    @endforeach
