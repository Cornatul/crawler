<?php namespace UnixDevil\Crawler\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Illuminate\Support\Facades\Config;

/**
 * TrendingKeywords Report Widget
 */
class TrendingKeywords extends ReportWidgetBase
{
    /**
     * @var string The default alias to use for this widget
     */
    protected $defaultAlias = 'TrendingKeywordsReportWidget';

    /**
     * Defines the widget's properties
     * @return array
     */
    final public function defineProperties(): array
    {
        return [
            'title' => [
                'title'             => 'backend::lang.dashboard.widget_title_label',
                'default'           => 'Trending Keywords Report Widget',
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
    public function render()
    {
        try {
            $this->prepareVars();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('trendingkeywords');
    }

    /**
     * Prepares the report widget view data
     * @throws \JsonException
     */
    final public function prepareVars(): void
    {
        $this->vars["trendingKeywords"] = $this->getTrendingKeywords();
    }

    private function getTrendingKeywords():array
    {
        //@todo create a client for the google trends api
        $config = collect(Config::get('nlp.endpoint.trending-keywords'));
        $client = new \GuzzleHttp\Client();
        $res = $client->get($config->random());
        $data = json_decode($res->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        return $data["data"]["response"];
    }
}
