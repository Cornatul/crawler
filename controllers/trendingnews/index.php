<div class="layout-relative">

    <div class="toolbar-widget list-header">
        <form class="form-elements" role="form" data-request="onSearchNews"
              data-request-update="result: '#feed-results'"
              data-request-loading="#loading"
        >
            <div class="form-group span-left">
                <label>Topic</label>
                <input type="text" name="keyword" value="<?php echo get("keyword");?>" class="form-control" />
            </div>

            <div class="form-group span-right">
                <label>Language</label>
                <select name="language" class="form-control custom-select">
                    <option selected="selected" value="en">English</option>
                    <option value="fr">French</option>
                    <option value="de">German</option>
                </select>
            </div>

            <div class="form-group span-full">
              <button type="submit"   class="btn btn-default">
                  Submit
              </button>
            </div>
        </form>
        <!-- Loading Indicator !-->
        <div id="loading" style="display: none;">
            <div class="loading-indicator-container">
                <div class="loading-indicator">
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    <div id="feed-results"></div>
</div>
