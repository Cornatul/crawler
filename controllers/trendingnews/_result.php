<div class="control-list">
    <table class="table data">
        <thead>
        <tr>
            <th><span>Title</span></th>
            <th><span>Url</span></th>
            <th><span>Subscribers</span></th>
            <th><span>Categories</span></th>
            <th><span>Websites</span></th>
            <th><span>Actions</span></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($result->getFeeds() as $key => $row) :?>
            <tr>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["url"]; ?></td>
                <td><?php echo $row["subscribers"]; ?></td>
                <td><?php echo implode(',', $row["categories"]); ?></td>
                <td>
                    <!-- @todo add website selection -->
                    <div id="response<?php echo $key;?>">
                        <?php if ($row["imported"]) :?>
                            <a class="btn btn-danger" data-request-loading="#loading<?php echo $key;?>"
                               data-request-update="result-unsubscribe: '#response<?php echo $key;?>'"
                               data-request-data="record:'<?php echo base64_encode(json_encode($row));?>'"
                               data-request="onUnsubscribe">
                                Unsubscribe
                            </a>
                        <?php else :?>
                            <a class="btn btn-success" data-request-loading="#loading<?php echo $key;?>"
                               data-request-update="result-subscribe: '#response<?php echo $key;?>'"
                               data-request-data="record:'<?php echo base64_encode(json_encode($row));?>'"
                               data-request="onSubscribe">
                                Subscribe
                            </a>
                        <?php endif;?>
                        <div id="loading<?php echo $key;?>" style="display: none;">
                            <div class="loading-indicator-container">
                                <div class="loading-indicator">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
