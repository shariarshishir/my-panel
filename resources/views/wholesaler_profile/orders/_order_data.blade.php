@foreach($orders as $orderItem)
            <tr class="newOrderRow">
                <td data-title="Order No" class="order-number" >
                    <a  href="#order-details-modal_{{$orderItem->id}}" class="order-more-details modal-trigger">{{$orderItem->order_number}} @if(in_array($orderItem->id,$orderApprovedNotificationIds))<span class="order-new-bedge new_item_color"> New</span>@endif </a>
                </td>
                <td data-title="Amount" >$ {{$orderItem->grand_total}}</td>
                <td data-title="Date">{{ \Carbon\Carbon::parse($orderItem->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                <td data-title="Order status" class="order-status">
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

                <td data-title="Payment status" class="order-status">
                    <span class="chip lighten-5 {{$orderItem->payment_status== 'paid' ? 'green green-text' : 'yellow yellow-text' }}">{{ucfirst($orderItem->payment_status)}}</span>
                </td>

                <td style="text-align: center">
                    <a href="#order-details-modal_{{$orderItem->id}}" data-orderId="{{$orderItem->id}}" class="order-more-details btn green waves-effect waves-light modal-trigger"><i class="material-icons">remove_red_eye</i></a>
                </td>
            </tr>
@endforeach
