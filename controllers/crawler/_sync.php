<a
    data-request-data="record:'<?php echo $record->id;?>'"
    data-request="onSync"
    data-request-loading="#loading"
    class="btn btn-info"
   >
    Start Crawling
</a>
<div id="loading" style="display: none;">
    <div class="loading-indicator-container">
        <div class="loading-indicator">
            <span></span>
        </div>
    </div>
</div>
