<?php namespace UnixDevil\Crawler\Controllers;

use Backend\Facades\BackendMenu;

use Backend\Classes\Controller;
use UnixDevil\Crawler\Contracts\TrendingContract;
use UnixDevil\Crawler\Jobs\FeedCrawlerJob;

/**
 * Feed Backend Controller

 */
class TrendingNews extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\ListController::class,
    ];

    private TrendingContract $trendingContract;
    public function __construct(TrendingContract $trendingContract)
    {
        parent::__construct();

        $this->trendingContract = $trendingContract;

        BackendMenu::setContext('UnixDevil.Crawler', 'crawler', 'trending');
    }

    final public function onGetNews()
    {
        $keyword = post('keyword');
        $this->vars['result'] = $this->trendingContract->getNews($keyword);
    }
}
