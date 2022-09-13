@if(count($orderQueries) > 0)
    <div class="col-md-12">
        <div class="card card-with-padding order-list-block">
            <legend>Orders Queries List</legend>

            <div class="no_more_tables">
                <table class="table striped" id="orderQueryTable">
                    <thead class="cf">
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Queries Type</th>
                            <th class="text-center">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orderQueries as $item)
                                <tr>
                                <td>{{$item->id}}</td>
                                <td data-title="Product Name" class="order-number">
                                    <a href="javascript:void(0);" class="order-more-details ">
                                        {{$item->product->name}}
                                        @if(isset($countOrderQuery))
                                            @foreach ($countOrderQuery as $key => $count)
                                                @if($key == $item->id)
                                                    <span class="new_item_color  newOrder">{{$count}} New</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </a>
                                </td>
                                <td data-title="Date">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                                <td data-title="Status">
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
                                <td>{{$item->queries_type}}</td>
                                <td>
                                    @if($item->queries_type == 'giving')
                                        <a href="javascript:void(0);" id="{{$item->id}}" class="open-communication-channel btn green waves-effect waves-light modal-trigger order-query-notification tooltipped" data-notification-id="{{$item->id}}" data-position="top" data-tooltip="Click here to send any message."><i class="material-icons">chat_bubble_outline</i></a>
                                        <a href="javascript:void(0);" id="{{$item->id}}" class="add-to-cart-order-query-modal btn green waves-effect waves-light order-query-notification tooltipped" data-notification-id="{{$item->id}}" data-position="top" data-tooltip="Click here to see order details."><i class="material-icons">description</i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    @include('my_order.orders_queries._communication_channel')
    @include('my_order.orders_queries._add_to_cart_modal')
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

@include('my_order.orders_queries._scripts')
