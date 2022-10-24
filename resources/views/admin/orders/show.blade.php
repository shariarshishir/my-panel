@extends('layouts.admin')
@if(auth()->guard('admin')->user()->unreadNotifications)
    @foreach (auth()->guard('admin')->user()->unreadNotifications as $notification)
        @if($notification->type == "App\Notifications\PaymentSuccessNotification")
            @if($notification->data['notification_data'] == $vendorOrder->id)
               {{  $notification->markAsRead(); }}
            @endif
        @endif
    @endforeach
@endif
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content order-details-block">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Order Details</h3>
                </div>
                <div class="row order-top-block">
                    <div class="col-md-6">
                        <p>Order Number: #{{$vendorOrder->order_number}}</p>
                        <p>Date: {{ \Carbon\Carbon::parse($vendorOrder->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</p>
                        <p>Order Status:
                            <span class="
                            @switch($vendorOrder->state)
                                @case('pending')
                                    text-danger
                                    @break
                                @case('approved')
                                    text-success
                                    @break
                                @case('delivered')
                                    text-info
                                    @break
                                @default

                            @endswitch
                            ">
                                {{ ucfirst($vendorOrder->state) }}
                            </span>
                        </p>
                        <p>Payment Status: <span class="{{$vendorOrder->payment_status == 'paid' ? 'text-success' : 'text-warning'}}">{{ ucfirst($vendorOrder->payment_status) }}</span></p>
                    </div>

                    {{-- @if($vendorOrder->state=='pending')
                        <div class="col-md-4 order-proceed-btn">
                            <a href="{{ route('order.updateby.admin',$vendorOrder->id) }}" class="btn btn-success">Proceed</a>
                        </div>
                    @endif --}}
                    <div class="col-md-6 order-proceed-btn">

                        <a href="{{ route('order.updateby.admin',$vendorOrder->id) }}" class="btn btn-success
                            @switch($vendorOrder->state)
                                @case('pending')

                                    @break
                                @case('approved')
                                    disabled
                                    @break
                                @case('delivered')
                                    disabled
                                    @break
                                @default
                                    disabled
                            @endswitch ">Approved

                        </a>
                        <a href="{{ route('order.ask.payment',$vendorOrder->order_number) }}" class="btn btn-success @php echo ($vendorOrder->payment_status=='paid')?'disabled':''; @endphp">Ask For Payment</a>
                        <a href="{{ route('order.status.change.delivered',$vendorOrder->id) }}" class="btn btn-success
                            @switch($vendorOrder->state)
                                @case('pending')
                                    disabled
                                    @break
                                @case('approved')

                                    @break
                                @case('delivered')
                                    disabled
                                    @break
                                @default
                                    disabled
                            @endswitch">Delivered
                        </a>
                    </div>
                </div>
                <div class="row order-address-block">
                    <div class="billing-address-block col-md-4">
                        <h4><i class="fas fa-address-card"></i> Billing Address</h4>
                        <p>{{$vendorOrder->billingAddress->company_name}}</p>
                        <p>{{$vendorOrder->billingAddress->address}}</p>
                        <p>{{$vendorOrder->billingAddress->email}}</p>
                        <p>{{$vendorOrder->billingAddress->phone}}</p>
                    </div>
                    <div class="shipping-address-block col-md-4">
                        <h4><i class="fas fa-briefcase"></i> Shipping Address</h4>
                        <p>{{$vendorOrder->shippingAddress->company_name}}</p>
                        <p>{{$vendorOrder->shippingAddress->address}}</p>
                        <p>{{$vendorOrder->shippingAddress->email}}</p>
                        <p>{{$vendorOrder->shippingAddress->phone}}</p>
                    </div>
                    <div class="store-address-block col-md-4">
                        <h4><i class="fas fa-briefcase"></i> Store Address</h4>
                        <p>{{$vendorOrder->businessProfile->business_name}}</p>
                        <p>{{$vendorOrder->businessProfile->location}}</p>
                        <p>{{$vendorOrder->businessProfile->user->email}}</p>
                        <p>{{$vendorOrder->businessProfile->user->phone}}</p>
                    </div>
                </div>

                <div class="border-separator"></div>

                {{-- <div class="row order-payment-block">
                    <div class="col-md-12">
                        <i class="far fa-credit-card"></i> Payment Method: {{ $vendorOrder->payment_name }}
                    </div>
                </div> --}}

                <div class="border-separator"></div>
                    <div class="no_more_tables">
                        <table class="table table-striped">
                            <thead class="cf">
                                <tr>
                                    <th data-field="Product Name">Product Name</th>
                                    <th data-field="SKU">SKU</th>
                                    <th data-field="Unit Price">Unit Price</th>
                                    <th data-field="Qty">Qty</th>
                                    <th data-field="Price" style="text-align: right;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendorOrder->orderItems as $list )
                                    <tr>
                                        <td data-title="Product Name">{{$list->product->name ?? ""}}
                                            @if($list->full_stock == 1)
                                            <span class="badge badge-primary">Full Stock</span>
                                            @elseif(isset($list->order_modification_req_id))
                                            <span class="badge badge-primary">Modified</span>
                                            @endif
                                        </td>
                                        <td data-title="SKU">{{$list->product_sku}}</td>
                                        <td data-title="Unit Price">${{ number_format($list->unit_price, 2) }}</td>
                                        <td data-title="Qty">
                                            {{$list->quantity}}
                                            @if ($list->full_stock == 1)
                                            <span  data-toggle="tooltip" title="Full Stock"><i class="fas fa-question-circle"></i></span>
                                            @endif

                                            @if(isset($list->colors_sizes))
                                                <a href="javascript:void(0);"  class="colorSizeModal">Show More</a>
                                                <div class="modal fade" id="colorSizeModal" tabindex="-1" role="dialog" aria-labelledby="colorSizeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Colors and Sizes</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                                @if($list->product->product_type == 1 || $list->product->product_type == 2)
                                                                    @foreach(json_decode($list->colors_sizes) as $key => $item)
                                                                        @php
                                                                            $xxs = ($item->xxs) ? $item->xxs .' XXS, ':'';
                                                                            $xs = ($item->xs) ? $item->xs .' XS, ':'';
                                                                            $smallCount = ($item->small) ? $item->small .' Small, ':'';
                                                                            $mediumCount = ($item->medium) ? $item->medium .' Medium, ':'';
                                                                            $largeCount = ($item->large) ? $item->large .' Large, ':'';
                                                                            $extra_largeCount = ($item->extra_large) ? $item->extra_large .' Extra Large, ':'';
                                                                            $xxl = ($item->xxl) ? $item->xxl .' XXL, ':'';
                                                                            $xxxl = ($item->xxxl) ? $item->xxxl .' XXXl, ':'';
                                                                            $four_xxl = ($item->four_xxl) ? $item->four_xxl .' 4XXXl, ':'';
                                                                            $one_size = ($item->one_size) ? $item->one_size .' One Size, ':'';
                                                                            echo "<p>".$item->color.": " .$xxs . $xs . $smallCount . $mediumCount . $largeCount . $extra_largeCount. $xxl .  $xxxl . $four_xxl . $one_size."</p>";
                                                                        @endphp
                                                                    @endforeach
                                                                @endif

                                                                @if ($list->product->product_type == 3)
                                                                    @foreach(json_decode($list->colors_sizes) as $key => $item)
                                                                        @php
                                                                            $quantity = ($item->quantity) ? $item->quantity .'Quantity, ':'';
                                                                            echo "<p>".$item->color.": " .$quantity."</p>";
                                                                        @endphp
                                                                    @endforeach
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>

                                            @endif
                                        </td>
                                        <td data-title="Price" style="text-align: right;">
                                            @if(isset($list->copyright_price))
                                            <span  data-toggle="tooltip" title=" Copyright price is {{ $list->copyright_price }}"><i class="fas fa-question-circle"></i></span>
                                            @endif
                                            @if(isset($list->discount))
                                            <span  data-toggle="tooltip" title="Discount amount {{ $list->discount }}"><i class="fas fa-question-circle"></i></span>
                                            @endif
                                            ${{ number_format($list->price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- <tr class="sub-total">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Sub Total</td>
                                    <td style="text-align: right;">$ {{ number_format($vendorOrder->sub_total, 2) }}</td>
                                </tr> --}}
                                <tr class="grand-total">
                                    <td class="empty_td">&nbsp;</td>
                                    <td class="empty_td">&nbsp;</td>
                                    <td class="empty_td">&nbsp;</td>
                                    <td class="grand_total_title">Grand Total</td>
                                    <td data-title="Grand Total" style="text-align: right;">${{ number_format($vendorOrder->grand_total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                <div class="shipping-charge-div">
                    @if($vendorOrder->shippingCharge)
                        @include('admin.orders._update_shipping_charge_form')
                    @else
                        @include('admin.orders._create_shipping_charge_form')
                    @endif

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@include('admin.orders._show_script')
