@if(count($orderModificationRequest) > 0)
    <div class="col-md-12">
        <div class="card card-with-padding order-list-block">
            <legend>Orders Modification List</legend>
            <table class="table striped" id="orderQueryModificationTable">
                <thead>
                    <tr>
                        <th width="28%" class="text-center">Product Name</th>
                        <th width="28%" class="text-center">Request User</th>
                        <th width="29%" class="text-center">Date</th>
                        <th width="28%" class="text-center">Status</th>
                        <th width="10%" class="text-center">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderModificationRequest as $item)
                    {{-- @if (in_array($item->id, $orderModificationRequestIds))
                        @foreach($notifications as $notification)
                            @if($notification->type == "App\Notifications\QueryWithModificationToUserNotification" && $notification->data['notification_data']==$item->id)

                                <tr class="newOrderModificationRequestRow">
                                    <td width="28%" class="order-number">
                                        <a href="{{ route('productdetails',$item->product->sku) }}" class="order-more-details modal-trigger">{{$item->product->name}} <span class="newOrderModificationRequest">(new)<span></a>
                                    </td>
                                    <td width="28%">{{ $item->user->name }}</td>
                                    <td width="29%">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY , h:mm:ss a')}}</td>
                                    <td width="28%" class="order-status">
                                        <span class="chip lighten-5 orange orange-text">
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
                                    <td width="15%" style="text-align: center">

                                        <a href="javascript:void(0)" id="{{$item->id}}"   class="btn waves-effect waves-light green order-mod-comments-modal " ><i class="material-icons">remove_red_eye</i></a> --}}
                                        {{-- @if(Auth::user()->user_type == 'wholesaler')
                                        <a href="javascript:void(0)" id="{{$item->id}}" product_id="{{$item->product_id}}" class="order-more-details btn green waves-effect waves-light create-order-modification-modal"><i class="material-icons">add_circle_outline</i></a>
                                        @endif--}}
                                        {{-- @if( $item->orderModification)
                                        <a href="javascript:void(0)" id="{{$item->orderModification->id}}"  data-order-modification-request-notification-id="{{$notification->id}}" class="confirm-order-modification-modal btn green waves-effect waves-light order-modification-request"><i class="material-icons">add_circle_outline</i></a>
                                        @endif
                                    </td> --}}
{{--
                                </tr>
                            @endif
                            @if($notification->type == "App\Notifications\QueryCommuncationNotification" && $notification->data['notification_data']==$item->id)

                            <tr class="newOrderModificationRequestRow">
                                <td width="28%" class="order-number">
                                    <a href="{{ route('productdetails',$item->product->sku) }}" class="order-more-details modal-trigger">{{$item->product->name}} <span class="newOrderModificationRequest">(new)<span></a>
                                </td>
                                <td width="28%">{{ $item->user->name }}</td>
                                <td width="29%">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY , h:mm:ss a')}}</td>
                                <td width="28%" class="order-status">
                                    <span class="chip lighten-5 orange orange-text">
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
                                <td width="15%" style="text-align: center">

                                    <a href="javascript:void(0)" id="{{$item->id}}"  data-order-modification-request-notification-id="{{$notification->id}}" class="btn waves-effect waves-light green order-mod-comments-modal order-modification-request" ><i class="material-icons">remove_red_eye</i></a> --}}
                                    {{-- @if(Auth::user()->user_type == 'wholesaler')
                                    <a href="javascript:void(0)" id="{{$item->id}}" product_id="{{$item->product_id}}" class="order-more-details btn green waves-effect waves-light create-order-modification-modal"><i class="material-icons">add_circle_outline</i></a>
                                    @endif--}}
                                    {{-- @if( $item->orderModification)
                                    <a href="javascript:void(0)" id="{{$item->orderModification->id}}" class="confirm-order-modification-modal btn green waves-effect waves-light"><i class="material-icons">add_circle_outline</i></a>
                                    @endif
                                </td>

                            </tr>
                            @endif

                        @endforeach
                     @else --}}

                        <tr>
                            <td width="20%" class="order-number">
                                <a href="{{ route('productdetails',$item->product->sku) }}" class="order-more-details modal-trigger">{{$item->product->name}}
                                    @if(isset($countOrderQueryMdf))
                                        @foreach ($countOrderQueryMdf as $key => $count)
                                            @if($key == $item->id)
                                                <span class="new badge blue newOrder">{{$count}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </a>
                            </td>
                            <td width="20%">{{ $item->user->name }}</td>
                            <td width="20%">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                            <td width="20%" class="order-status">
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
                                    <a href="javascript:void(0)" id="{{$item->orderModification->id}}" class="confirm-order-modification-modal btn green waves-effect waves-light order-modification-request" data-order-modification-request-notification-id="{{$item->id}}">
                                        Confirm Order
                                    </a>
                                @endif
                            </td>

                        </tr>

                    {{-- @endif --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('user.profile.orders_modification._comments_display')
    {{-- @include('user.profile.orders_modification._create_order') --}}
    @include('user.profile.orders_modification._confirm_order')



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

@include('user.profile.orders_modification._scripts')
