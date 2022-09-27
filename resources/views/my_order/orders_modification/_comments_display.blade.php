<div id="order-modification-comment-modal" class="order-modification-comment-modal modal modal-fixed-footer">
            <div class="modal-content">
                <legend>Order Details</legend>
                <div class="row order-top-block">
                    {{-- @foreach (json_decode($orderModificationRequset->details) as $d)
                        <div class="col m12 ">
                            <div class="row order-info-top">
                                <div class="col m12 create-date">
                                    <i class="material-icons" >date_range</i> {{ \Carbon\Carbon::parse($orderModificationRequset->created_at)->isoFormat('MMMM Do YYYY')}}
                                </div>
                            </div>
                            <div class="row order-info-bottom">
                                <div class="col m12 order-info-details">{{ $d->details }}</div>
                                <div class="col m12 order-info-images">
                                @if(isset($d->image))
                                    <img src="{{ asset('storage/'.$d->image) }}" alt="" height="150" width="auto">
                                @endif
                                </div>
                            </div>
                        </div>
                    @endforeach --}}
                </div>
                <div class="row">
                    <legend>Comments</legend>
                </div>
                <div class="ord-mod-comments-show row">

                </div>
                {{-- @foreach ($orderModificationRequset->comments as $comment) --}}
                    {{-- <div class="row reply order-top-block"> --}}
                        {{-- @foreach (json_decode($comment->details) as $cd)
                            <div class="col m12">
                                <div class="row order-info-top">
                                    <div class="col m6 created-by">
                                        <p><i class="material-icons">person</i> {{ $comment->user->name }}</p>
                                        <p><i class="material-icons">date_range</i> {{ \Carbon\Carbon::parse($comment->created_at)->isoFormat('MMMM Do YYYY')}}</p>
                                    </div>
                                </div>
                                <div class="row order-info-bottom">
                                    <div class="col m12 order-info-details">{{ $cd->details }}</div>
                                    <div class="mod-detail-image col m12 order-info-details">
                                    @if(isset($cd->image))
                                        <img src="{{ asset('storage/'.$cd->image) }}" alt="" height="150" width="auto">
                                    @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach --}}
                    {{-- </div> --}}
                {{-- @endforeach  --}}
                {{-- @include('user.profile.orders_modification._commentsDisplay',['comments' => $item->comments, 'post_id' => $item->id, 'product_id' => $item->product_id]) --}}
                {{-- @if($item->comments->isEmpty() ) --}}
                <div class="right-align" style="padding: 10px 0;">
                    <a href="javascript:void();" class="display-comment btn_green waves-effect waves-light" style="line-height: 22px; padding: 5px 20px;">Add Comment</a>
                </div>
                
                <div class="mod-comment" >
                    <form action="#" method="post" name="ordModCommentForm" id="ordModCommentForm">
                        @csrf
                        <div class="prod-mod-req-content">
                            <div class="row input-field">
                                <div class="col s12 m4 l3">
                                    <label for="message" class="">Type your message</label>
                                </div>
                                <div class="col s12 m8 l9">
                                    <textarea class="materialize-textarea product-modification-message" name="ord_mod_replay[details][]"></textarea>
                                </div>
                            </div>
                            <div class="upload_replay_img">
                                <input style="background: none; box-shadow: none;" type="file" name="ord_mod_replay[image][]">
                            </div>
                        </div>
                       <input type="hidden" name="mod_req_id" value="">
                       <input type="hidden" name="product_id" value="">
                       <div class="right-align" style="padding: 10px 0;">
                            <button style="line-height: 25px;" type="submit" class="btn_green waves-effect waves-light" id="submitProdModReqReplay">Comment</button>
                       </div>
                       
                    </form>
                </div>
                {{-- @endif --}}
                <div class="row product-details-table-block">
                    <div class="col s12">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
                    <i class="material-icons green-text text-darken-1">close</i>
                </a>
            </div>
</div>
