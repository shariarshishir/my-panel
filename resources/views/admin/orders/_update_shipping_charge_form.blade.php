<form action="{{route('shipping-charge.update', $vendorOrder->shippingCharge->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <p class="btn btn-success add-shipping-charge">Shipment Charge</p>
    <input type="hidden" name="order_id" value="{{$vendorOrder->id}}">
    <div class="shipping-charge-block">
        <div class="form-group">
            <label for="">Forwarder Name:</label>
            <input type="text" name="forwarder_name" class="form-control col-sm-4" value="{{$vendorOrder->shippingCharge->forwarder_name}}" />
        </div>
        <div class="form-group">
            <label for="">Forwarder Address:</label>
            <input type="text" name="forwarder_address" class="form-control col-sm-4" value="{{$vendorOrder->shippingCharge->forwarder_address}}" />
        </div>
        <div class="no_more_tables">
            <table class="table table-striped shipping-charge-table" style="width: 100%;">
                <thead class="cf">
                    <tr>
                        <th>Shipping Method</th>
                        <th>Shipment Type</th>
                        <th>UOM</th>
                        <th>Per UOM Price($)</th>
                        <th>QTY</th>
                        <th>Total($)</th>
                        <th><a href="javascript:void(0);" class="btn btn-success" onclick="addMoreShippingCharge()"><i class="fas fa-plus"></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (json_decode($vendorOrder->shippingCharge->details)  as  $shippingList)
                        <tr>
                            <td data-title="Shipping Method">
                                <select class="form-select form-control" aria-label="Default select example" name="shipping[shipping_method][]" required>
                                    @foreach ($shippingMethod as $list )
                                        <option value="{{$list}}" {{$list == $shippingList->shipping_method ? 'selected' : ''}}>{{$list}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-title="Shipment Type">
                                <select class="form-select form-control" aria-label="Default select example" name="shipping[shipment_type][]" required>
                                    @foreach ($shipMentType as $list )
                                        <option value="{{$list}}" {{$list == $shippingList->shipment_type ? 'selected' : ''}}>{{$list}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-title="UOM">
                                <select class="form-select form-control" aria-label="Default select example" name="shipping[uom][]" required>
                                    @foreach ($uom as $list )
                                        <option value="{{$list}}" {{$list == $shippingList->uom ? 'selected' : ''}}>{{$list}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-title="Per UOM Price($)"><input type="number" name="shipping[unit_price][]" class="shipping-unit-price form-control" value="{{$shippingList->unit_price}}" required /></td>
                            <td data-title="QTY"><input type="number" name="shipping[qty][]" class="shipping-qty form-control" value="{{$shippingList->qty}}" required /></td>
                            <td data-title="Total($)"><input type="number" name="shipping[total][]" class="shipping-total form-control" value= "{{$shippingList->total}}" readonly required /></td>
                            <td data-title=""><a href="javascript:void(0);" class="btn btn-danger remove-shipping-charge-tr" onclick="removeShippingChargeTr(this)"><i class="fas fa-minus"></i></a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <table class="table table-striped" style="width: 100%;">
                <tr>
                    <td data-title="Grand Total:">
                        <label class="grand_total_title">Grand Total:</label>
                        $<span class="shipping-grand-total">{{$vendorOrder->shippingCharge->grand_total}}</span>
                    </td>
                </tr>
            </table>
        </div>
                
        <div class="form-group">
            <input type="hidden" name="grand_total" value="{{$vendorOrder->shippingCharge->grand_total}}">
            <input type="file" name="file">
        </div>
        @if($vendorOrder->shippingCharge->status == 1)
            <button class="btn btn-success">Send</button>
            <a class="btn btn-success" href="{{route('shipping.charge.change.status', $vendorOrder->id)}}">Confirm</a>
        @endif
    </div>
</form>
