<div id="order-query-communication-modal" class="modal profile_form_modal">
    <div class="modal-content">
        <legend>Message</legend>
        <div id="pmr-errors"></div>
        <div class="order-query-message-show row">

        </div>

        <legend>Submit a new message</legend>
        <div class="order-query-message-block" >
            <form action="#" method="post" name="order-query-message-form" id="order-query-message-form">
                @csrf
                <div class="order-query-message-content">
                    <div class="row">
                        <div class="input-field col s12">
                           <div class="col s12 m12 l3">
                                <label for="message" class="">Type your message</label>
                           </div>
                           <div class="col s12 m12 l9">
                                <textarea class="materialize-textarea product-modification-message" name="details" placeholder="Type your message"></textarea>
                           </div>
                        </div>
                        <div class="input-field col s12">
                            <input type="file" name="image">
                        </div>
                    </div>
                </div>
               <input type="hidden" name="order_modification_request_id" value="">
               <!-- <button type="submit" class="btn_green waves-effect waves-light" id="submit-order-query-message-form">Submit</button> -->

            <div class="submit_btn_wrap">
                <div class="row">
                    <div class="col s12 m6 l4 left-align"><a href="#!" class="modal-close btn_grBorder">Cancel</a></div>
                    <div class="col s12 m6 l8 right-align">
                        <button type="submit" class="btn_green waves-effect waves-light" id="submit-order-query-message-form">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <!-- <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">
            <i class="material-icons green-text text-darken-1">close</i>
        </a>
    </div> -->
</div>
