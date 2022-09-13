@if(count($orderQueries) > 0)
    <div class="col-md-12">
        <div class="card card-with-padding order-list-block">
            <legend>Orders Queries List</legend>
            <table class="table striped" id="orderQueryTable">
                <thead>
                    <tr>
                        <th width="28%" class="text-center">Product Name</th>
                        <th width="29%" class="text-center">Date</th>
                        <th width="28%" class="text-center">Status</th>
                        <th width="10%" class="text-center">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderQueries as $item)
                            <tr>
                            <td width="28%" class="order-number">
                                <a href="javascript:void(0);" class="order-more-details ">
                                    {{$item->product->name}}
                                    @if(isset($countOrderQuery))
                                        @foreach ($countOrderQuery as $key => $count)
                                            @if($key == $item->id)
                                                <span class="new badge blue newOrder">{{$count}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </a>
                            </td>
                            <td width="29%">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                            <td>
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
                            <td>
                                <a href="javascript:void(0);" id="{{$item->id}}" class="open-communication-channel btn green waves-effect waves-light modal-trigger order-query-notification tooltipped" data-notification-id="{{$item->id}}" data-position="top" data-tooltip="Click here to send any message."><i class="material-icons">chat_bubble_outline</i></a>
                                <a href="javascript:void(0);" id="{{$item->id}}" class="add-to-cart-order-query-modal btn green waves-effect waves-light order-query-notification tooltipped" data-notification-id="{{$item->id}}" data-position="top" data-tooltip="Click here to see order details."><i class="material-icons">description</i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('user.profile.orders_queries._communication_channel')
    @include('user.profile.orders_queries._add_to_cart_modal')
    {{-- @include('user.profile.orders_queries._create_add_to_cart') --}}




@else
    <div class="col-md-12">
        <div class="card card-with-padding">
            <div class="card-alert card cyan">
                <div class="card-content white-text">
                    <p>INFO : No Queries available.</p>
                </div>
            </div>
        </div>
    </div>
@endif

@include('user.profile.orders_queries._scripts')
