@foreach($orders as $orderItem)
            <tr class="newOrderRow">
                <td data-title="Order Number" class="order-number" >
                    <a  href="#order-details-modal_{{$orderItem->id}}" class="order-more-details modal-trigger">{{$orderItem->order_number}}
                        @if(isset($countOrderApproved))
                            @foreach ($countOrderApproved as $key => $count)
                                @if($key == $orderItem->id)
                                    <span class="new badge blue newOrder">{{$count}}</span>
                                @endif
                            @endforeach
                        @endif

                    </a>
                </td>
                <td data-title="Amount">$ {{$orderItem->grand_total}}</td>
                <td data-title="Date">{{ \Carbon\Carbon::parse($orderItem->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                <td data-title="Order Status" class="order-status">
                    <span class="chip lighten-5
                    @switch($orderItem->state)
                        @case('pending')
                            red red-text
                            @break
                        @case('approved')
                           green green-text
                            @break
                        @case('delivered')
                            gray gray-text
                            @break
                        @default

                    @endswitch ">{{ucfirst($orderItem->state)}}</span>
                </td>

                @if (auth()->user()->user_type=='wholesaler')
                    <td data-title="Order Status" class="order-status">
                        <span class="chip lighten-5 order_status_label {{$orderItem->order_type== 'received_order' ? 'green green-text' : 'blue blue-text' }}">{{$orderItem->order_type== 'received_order' ? 'Order Received' : 'Order Sent' }}</span>
                    </td>
                @endif

                <td data-title="Payment Status" class="order-status">
                    <span class="chip lighten-5 {{$orderItem->payment_status== 'paid' ? 'green green-text' : 'yellow yellow-text' }}">{{ucfirst($orderItem->payment_status)}}</span>
                </td>

                <td style="text-align: center;">
                    @if(isset($countOrderApproved))
                    <a id="notification_identifier" data-orderId="{{$orderItem->id}}"  href="#order-details-modal_{{$orderItem->id}}" class="order-more-details btn green waves-effect waves-light modal-trigger"><i class="material-icons">remove_red_eye</i></a>
                    @else
                    <a href="#order-details-modal_{{$orderItem->id}}" data-orderId="{{$orderItem->id}}" class="order-more-details btn green waves-effect waves-light modal-trigger"><i class="material-icons">remove_red_eye</i></a>
                    @endif
                </td>
            </tr>
@endforeach
