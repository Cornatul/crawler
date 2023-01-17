<div data-control="toolbar">
    <a
        href="<?= Backend::url('unixdevil/crawler/feed/create') ?>"
        class="btn btn-primary wn-icon-plus">
       Create
    </a>

    <a
        href="<?= Backend::url('unixdevil/crawler/feedsearch') ?>"
        class="btn btn-primary wn-icon-search">
       Search
    </a>

    <button
        class="btn btn-danger wn-icon-trash-o"
        disabled="disabled"
        onclick="$(this).data('request-data', { checked: $('.control-list').listWidget('getChecked') })"
        data-request="onDelete"
        data-request-confirm="<?= e(trans('backend::lang.list.delete_selected_confirm')); ?>"
        data-trigger-action="enable"
        data-trigger=".control-list input[type=checkbox]"
        data-trigger-condition="checked"
        data-request-success="$(this).prop('disabled', 'disabled')"
        data-stripe-load-indicator>
        <?= e(trans('backend::lang.list.delete_selected')); ?>
    </button>
</div>
