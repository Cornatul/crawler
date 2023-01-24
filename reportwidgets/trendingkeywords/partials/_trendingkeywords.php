<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>
    <?php if (!isset($error)) : ?>
        <table class="table data">
            <thead>
            <tr>
                <th><a href="#">Keyword</a></th>
                <th><a href="#">Get News Articles</a></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($trendingKeywords as $keyword) : ?>
                <tr>
                    <td><?= $keyword ?></td>
                    <td class="column-button nolink">
                        <a
                            href="<?= Backend::url('unixdevil/crawler/trendingnews') ?>?keyword=<?= $keyword ?>"
                            target="_blank"
                            class="btn btn-secondary btn-sm">
                            Find News
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="flash-message static warning"><?= e($error) ?></p>
    <?php endif ?>
</div>
