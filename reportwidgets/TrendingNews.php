<?php namespace UnixDevil\Crawler\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use UnixDevil\Crawler\Clients\NLPClient;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\Contracts\TrendingContract;

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
    final public function defineProperties():array
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
     * Renders the widget's primary contents.
     * @return string HTML markup supplied by this widget.
     */
    final public function render(): string
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
    final public function prepareVars(): void
    {
        $this->vars["news"] =  app(TrendingContract::class)->getHeadlines();
    }

}
