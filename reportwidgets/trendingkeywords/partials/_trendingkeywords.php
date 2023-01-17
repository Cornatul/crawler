<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <?php if (!isset($error)): ?>
        <?php foreach ($trendingKeywords as $keyword): ?>
            <div class="keyword">
                <h6 class="keyword-name"><?= e($keyword) ?></h6>

            </div>
        <?php endforeach ?>
    <?php else: ?>
        <p class="flash-message static warning"><?= e($error) ?></p>
    <?php endif ?>
</div>
