
<div id="response<?php echo  $record->id; ?>">

    <a class="btn btn-success" data-request-loading="#loading<?php echo  $record->id; ?>"
       data-request-update="result-sync: '#response<?php echo  $record->id; ?>'"
       data-request-data="id:'<?php echo  $record->id; ?>'"
       data-request="onSyncArticles">
        Sync Articles
    </a>
    <div id="loading<?php echo  $record->id; ?>" style="display: none;">
        <div class="loading-indicator-container">
            <div class="loading-indicator">
                <span></span>
            </div>
        </div>
    </div>

</div>
