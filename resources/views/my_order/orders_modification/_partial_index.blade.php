@if(count($orderModificationRequest) > 0)
    <div class="col-md-12">
        <div class="card card-with-padding order-list-block">
            <legend>Orders Modification List</legend>
            <div class="no_more_tables">
                <table class="table striped" id="orderQueryModificationTable">
                    <thead class="cf">
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Request User</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderModificationRequest as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td data-title="Product Name" class="order-number">
                                    <a href="{{ route('productdetails',$item->product->sku) }}" class="order-more-details modal-trigger">{{$item->product->name}}
                                        @if(isset($countOrderQueryMdf))
                                            @foreach ($countOrderQueryMdf as $key => $count)
                                                @if($key == $item->id)
                                                    <span class="new_item_color newOrder">{{$count}} New</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </a>
                                </td>
                                <td data-title="Request User" >{{ $item->user->name }}</td>
                                <td data-title="Date" >{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                                <td data-title="Status" class="order-status">
                                    <span class="chip lighten-5
                                        @switch($item->state)
                                            @case(1)
                                                red red-text
                                                @break
                                            @case(2)
                                                yellow yellow-text
                                                @break
                                            @case(3)
                                                green green-text
                                                @break
                                            @case(4)
                                                red red-text
                                                @break
                                            @default

                                        @endswitch ">

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
                                    </span>
                                </td>
                                <td width="20%" style="text-align: center">
                                    <a href="javascript:void(0)" id="{{$item->id}}" class="btn waves-effect waves-light green order-mod-comments-modal order-modification-request" data-order-modification-request-notification-id="{{$item->id}}"><i class="material-icons">remove_red_eye</i></a>
                                    @if( $item->orderModification)
                                        <a href="javascript:void(0)" id="{{$item->orderModification->id}}" class="confirm-order-modification-modal btn_green waves-effect waves-light order-modification-request" data-order-modification-request-notification-id="{{$item->id}}">
                                            Confirm Order
                                        </a>
                                    @endif
                                </td>

                            </tr>


                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('my_order.orders_modification._comments_display')
    {{-- @include('user.profile.orders_modification._create_order') --}}
    @include('my_order.orders_modification._confirm_order')



@else
    <div class="col-md-12">
        <div class="card card-with-padding">
            <div class="card-alert card cyan">
                <div class="card-content white-text">
                    <p>INFO : No modification available.</p>
                </div>
            </div>
        </div>
    </div>
@endif

@include('my_order.orders_modification._scripts')
