<form action="{{route('shipping-charge.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <input type="hidden" name="order_id" value="{{$vendorOrder->id}}">
    <p class="btn btn-success add-shipping-charge">Add Shipment Charge</p>
    <div class="shipping-charge-block" style="@if (!$errors->any()) display: none @endif">

        <div class="form-group">
            <label for="">Forwarder Name:</label>
            <input type="text" name="forwarder_name" class="form-control col-sm-4" placeholder="Enter name" />        
        </div> 
        <div class="form-group">
            <label for="">Forwarder Address:</label>
            <input type="text" name="forwarder_address" class="form-control col-sm-4" placeholder="Enter address" />        
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
                        <tr>
                            <td data-title="Shipping Method">
                                <select class="form-select form-control" aria-label="Default select example" name="shipping[shipping_method][]" required>
                                    <option value="" selected>select</option>
                                    @foreach ($shippingMethod as $list )
                                        <option value="{{$list}}">{{$list}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-title="Shipment Type">
                                <select class="form-select form-control" aria-label="Default select example" name="shipping[shipment_type][]" required>
                                    <option value=""  selected>select</option>
                                    @foreach ($shipMentType as $list )
                                        <option value="{{$list}}">{{$list}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-title="UOM">
                                <select class="form-select form-control" aria-label="Default select example" name="shipping[uom][]" required>
                                    <option  value="" selected>select</option>
                                    @foreach ($uom as $list )
                                        <option value="{{$list}}">{{$list}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-title="Per UOM Price($)"><input type="number" name="shipping[unit_price][]" class="shipping-unit-price form-control" required /></td>
                            <td data-title="QTY"><input type="number" name="shipping[qty][]" class="shipping-qty form-control" required /></td>
                            <td data-title="Total($)"><input type="number" name="shipping[total][]" class="shipping-total form-control" readonly required /></td>
                            <td>&nbsp;</td>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <table class="table table-striped" style="width: 100%;">
            <tr>
                <td>
                    <label>Grand Total:</label>
                    $<span class="shipping-grand-total">0.00</span>
                </td>
            </tr>
        </table>
        <div class="form-group">
            <input type="hidden" name="grand_total" value="">
            <input type="file" name="file">
        </div>
        <button class="btn btn-success">Send</button>
    </div>
</form>
