<div id="back-button-wrapper" class="mb-3">
    <button type="button" id="back-button" class="btn btn-outline-secondary btn-sm" onclick="window.history.back();" style="display:none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </button>
</div>

<script>
    (function(){
        try {
            var btn = document.getElementById('back-button');
            // show button if there's a referrer or history length > 1
            var show = document.referrer || (window.history && window.history.length > 1);
            if(show){
                btn.style.display = 'inline-block';
            }
        } catch(e) { /* ignore */ }
    })();
</script>
