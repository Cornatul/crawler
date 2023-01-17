<?php namespace UnixDevil\Crawler\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use UnixDevil\Crawler\Clients\NLPClient;

/**
 * TrendingNews Report Widget
 */
class TrendingNews extends ReportWidgetBase
{
    /**
     * @var string The default alias to use for this widget
     */
    protected $defaultAlias = 'TrendingNewsReportWidget';

    /**
     * Defines the widget's properties
     * @return array
     */
    public function defineProperties():array
    {
        return [
            'title' => [
                'title'             => 'backend::lang.dashboard.widget_title_label',
                'default'           => 'Trending News Report Widget',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error',
            ],
        ];
    }

    /**
     * Adds widget specific asset files. Use $this->addJs() and $this->addCss()
     * to register new assets to include on the page.
     * @return void
     */
    protected function loadAssets(): void
    {
    }

    /**
     * Renders the widget's primary contents.
     * @return string HTML markup supplied by this widget.
     */
    public function render(): string
    {
        try {
            $this->prepareVars();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('trendingnews');
    }

    /**
     * Prepares the report widget view data
     * @throws \JsonException
     */
    public function prepareVars(): void
    {
        $this->vars["news"] =  (new NLPClient())->getTrendingNews();
    }

}
