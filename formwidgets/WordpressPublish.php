<?php namespace UnixDevil\Crawler\FormWidgets;

use Backend\Classes\FormWidgetBase;
use UnixDevil\Crawler\Models\Website;

/**
 * WordpressPublish Form Widget
 */
class WordpressPublish extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'wordpress_publish';

    /**
     * @inheritDoc
     */
    public function init(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('wordpresspublish');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars(): void
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['websites'] = Website::all();
    }

    /**
     * @inheritDoc
     */
    public function loadAssets(): void
    {
        $this->addCss('css/wordpress-publish.css', 'UnixDevel.Crawler');
        $this->addJs('js/wordpress-publish.js', 'UnixDevel.Crawler');
    }


    public function onPublishPost(): void
    {
        $website = Website::find(post('website'));
        dispatch(new \UnixDevil\Crawler\Jobs\WordpressCreateRemotePost($website, $this->model));
    }
}
