<form class="form-elements" role="form"
>
    <div class="form-group">
        <label>Language</label>
        <br>
        <label>
            <select name="website" class="form-control custom-select">
                <?php foreach ($websites as $website): ?>
                    <option value="<?php echo $website->id; ?>"><?php echo $website->name; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>

    <div class="form-group span-full">
        <button
            type="button"
            data-request="onPublishPost"
            data-request-data="close:true"
            data-hotkey="ctrl+enter, cmd+enter"
            data-load-indicator="Creating Category..."
            class="btn btn-default">
            Create and Close
        </button>
    </div>
</form>
