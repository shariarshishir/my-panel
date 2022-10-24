@if(auth()->guard('admin')->user()->unreadNotifications)
    @foreach (auth()->guard('admin')->user()->unreadNotifications as $notification)
        @if($notification->type == "App\Notifications\QueryCommuncationNotification" || $notification->type == "App\Notifications\NewOrderModificationRequestNotification")
            @if($notification->data['notification_data']== $collection->id)
               {{  $notification->markAsRead(); }}
            @endif
        @endif
    @endforeach
@endif
<div id="order-modification-comment-modal" class="order-modification-comment-modal  modal-fixed-footer">
            <div class="">
                @if($collection->type == config('constants.order_query_type.order_query_with_modification'))
                <legend>Order Details</legend>
                <div class="row order-top-block">
                    @foreach (json_decode($collection->details) as $d)
                        <div class="col-md-12">
                            <div class="row order-info-top">
                                <div class="col-md-12 create-date" style="margin-bottom: 15px;">
                                    <i class='far fa-clock'></i> {{ \Carbon\Carbon::parse($collection->created_at)->isoFormat('MMMM Do YYYY , h:mm:ss a')}}
                                </div>
                            </div>
                            <div class="row order-info-bottom">
                                <div class="col-md-12">
                                    <div class="order-info-details">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{ $d->details }}
                                            </div>
                                            <div class="col-md-12">
                                                @if(isset($d->image))
                                                    <img src="{{ asset('storage/'.$d->image) }}" alt="" height="250" width="250">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
                <legend>Comments</legend>
                <div class="ord-mod-comments-show">

                </div>
                @foreach ($collection->comments as $comment)
                    <div class="row reply order-top-block">
                        @foreach (json_decode($comment->details) as $cd)
                            <div class="col m12">
                                <div class="row order-info-top">
                                    <div class="col-md-12 create-date" style="margin-bottom: 15px;">
                                        <div class="row">
                                            <div class="col-md-6"><i class="fas fa-user"></i> {{ $comment->user->name ?? 'Merchantbay'}}</div>
                                            <div class="col-md-6" style="text-align: right;"><i class='far fa-clock'></i> {{ \Carbon\Carbon::parse($comment->created_at)->isoFormat('MMMM Do YYYY , h:mm:ss a')}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row order-info-bottom">
                                    <div class="col-md-12">
                                        <div class="order-info-details">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{ $cd->details }}
                                                </div>
                                                <div class="col-md-12">
                                                    @if(isset($cd->image))
                                                        <div class="mod-detail-image col m6 order-info-details"><img src="{{ asset('storage/'.$cd->image) }}" alt="" height="250" width="250"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
               @if($collection->state != config('constants.order_query_status.ordered'))
                    <a href="javascript:void();" class="display-comment add-comment btn btn-success" style="padding-bottom: 10px;">Add Comment</a>
                @endif
                <br>
                <br>
                <div class="mod-comment" style="display: none;">
                    <form action="{{ route('query.request.comment') }}" method="post" name="ordModCommentForm" id="ordModCommentForm" enctype="multipart/form-data">
                        @csrf
                        <div class="prod-mod-req-content">
                            <div class="row">
                                <div class="col-md-12 reply-message-block">
                                    <label>Type your message</label>
                                    <textarea class="form-control" name="ord_mod_replay[details][]" placeholder="Message"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="ord_mod_replay[image][]">
                                </div>
                            </div>
                        </div>
                       <input type="hidden" name="mod_req_id" value="{{ $collection->id }}">
                       <input type="hidden" name="product_id" value="{{ $collection->product_id }}">
                       <br>
                       <button type="submit" class="btn btn-success green waves-effect waves-light" id="submitProdModReqReplay">Comment</button>
                    </form>
                </div>

                <div class="row product-details-table-block">
                    <div class="col s12">

                    </div>
                </div>
            </div>

</div>

@push('js')
<script>
      $(document).on('click', '.add-comment', function(){
             $(this).siblings('.mod-comment').toggle();
         });
</script>
@endpush


