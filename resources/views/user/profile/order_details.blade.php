@extends('layouts.app')

@section('content')

        <div  class="order-details">
            <div class="order-details">
                <legend>Order Details</legend>
                <div class="row order-top-block">
                    <div class="order-info-top col m6">
                        <p>Order Number: #{{$order->order_number}}</p>
                        <p>Date: {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('MMMM Do YYYY')}}</p>
                    </div>
                    <div class="order-status-block col m6">
                        <a href="javascript:void(0);" class="waves-effect waves-green btn green">Shipped</a>
                    </div>
                </div>
                <div class="row order-address-block">
                    <div class="billing-address-block col m6">
                        <h4><i class="material-icons">description</i> Billing Address</h4>
                        <p>{{$order->billingAddress->company_name}}</p>
                        <p>{{$order->billingAddress->address}}</p>
                        <p>{{$order->billingAddress->email}}</p>
                        <p>{{$order->billingAddress->phone}}</p>
                    </div>
                    <div class="shipping-address-block col m6">
                        <h4><i class="material-icons">card_travel</i> Shipping Address</h4>
                        <p>{{$order->shippingAddress->company_name}}</p>
                        <p>{{$order->shippingAddress->address}}</p>
                        <p>{{$order->shippingAddress->email}}</p>
                        <p>{{$order->shippingAddress->phone}}</p>
                    </div>
                </div>
                <div class="border-separator"></div>
                <i class="material-icons">payment</i> {{ $order->payment_name }}
                <div class="border-separator"></div>
                <div class="row product-details-table-block">
                    <div class="col s12">
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th data-field="Product Name">Product Name</th>
                                    <th data-field="SKU">SKU</th>
                                    <th data-field="Unit Price">Unit Price</th>
                                    <th data-field="Qty">Qty</th>
                                    <th data-field="Price" style="text-align: right;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $list )
                                    <tr>
                                        <td>{{$list->product->name ?? ""}} </td>
                                        <td>{{$list->product_sku}}</td>
                                        <td>${{$list->unit_price}}</td>
                                        <td>
                                            {{$list->quantity}}
                                            @php
                                            if(isset($list->colors_sizes)) {
                                            @endphp
                                            <a class="waves-effect waves-light modal-trigger" href="#colorSizeModal">Show More</a>
                                            <div id="colorSizeModal" class="modal modal-fixed-footer">
                                                <div class="modal-content">
                                                    <h4>Colors and Sizes</h4>
                                                    @php
                                                    foreach(json_decode($list->colors_sizes) as $key => $value)
                                                    {
                                                        $smallCount = ($value->small) ? $value->small .' Small, ':'';
                                                        $mediumCount = ($value->medium) ? $value->medium .' Medium, ':'';
                                                        $largeCount = ($value->large) ? $value->large .' Large, ':'';
                                                        $extra_largeCount = ($value->extra_large) ? $value->extra_large .' Extra Large, ':'';
                                                        echo "<p>".$value->color.": ". $smallCount . $mediumCount . $largeCount . $extra_largeCount."</p>";
                                                    }
                                                    @endphp
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:void(0);" class="waves-effect waves-green btn-flat hide-color-size-modal-trigger">
                                                        <i class="material-icons green-text text-darken-1">close</i>
                                                    </a>
                                                </div>
                                            </div>
                                            @php } @endphp
                                        </td>
                                        <td style="text-align: right;">
                                            @if($list->quantity*$list->unit_price != $list->price)
                                            <span class="tooltipped" data-position="top" data-tooltip="Copyright price is {{ $list->copyright_price }}"><i class="material-icons dp48">live_help</i></span>
                                            @endif
                                            ${{$list->price}}
                                        </td>

                                    </tr>
                                @endforeach
                                {{-- <tr class="sub-total">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Sub Total</td>
                                    <td style="text-align: right;">${{$order->sub_total}}</td>
                                </tr> --}}
                                <tr class="grand-total">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Grand Total</td>
                                    <td style="text-align: right;">${{$order->grand_total}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>



@endsection
