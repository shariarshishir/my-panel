<div id="share-modal" class="modal">
    <div class="modal-content">
        <h3>Please, copy the link to share the RFQ</h3>
        <div class="share_url_box">
            <input class="share_text_box" type="text" name="share_text" id="share_text" readonly >
            <a class="share_copy" href="javascript:void(0)" onclick="copyToClipboard();">Copy</a>
        </div>
    </div>
</div>

@push('js')
<script type="text/javascript">
    function copyToClipboard(){
        document.getElementById('share_text').select();
        document.execCommand('copy');
    }
</script>

@endpush
