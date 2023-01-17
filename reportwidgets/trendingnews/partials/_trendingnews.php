<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <?php if (!isset($error)): ?>
        <div class="control-list">
            <table class="table data">
                <thead>
                <tr>
                    <th><a href="#">Image</a></th>
                    <th><a href="#">Title</a></th>
                    <th><a href="#">Actions</a></th>
                    <th><a href="/">Published</a></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($news as $item) {
                    ?>
                    <tr>
                        <td width="10%"><img src="<?= $item["urlToImage"] ?>" style="width: 100%" alt="<?= $item["title"] ?>"></td>
                        <td>
                            <h3>
                                <a href="<?= $item["url"] ?>" target="_blank"><?= $item["title"] ?></a>
                            </h3>
                            <?= $item["content"] ?>
                        </td>
                        <td class="column-button nolink">
                            <a
                                href="#"
                                target="_blank"
                                class="btn btn-secondary btn-sm">
                                Extract Article
                            </a>
                        </td>
                        <td><?= e($item['publishedAt']) ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="flash-message static warning"><?= e($error) ?></p>
    <?php endif ?>
</div>
