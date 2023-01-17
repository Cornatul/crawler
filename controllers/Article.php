<?php namespace UnixDevil\Crawler\Controllers;

use Backend\Facades\BackendMenu;

use Backend\Classes\Controller;
use UnixDevil\Crawler\Jobs\FeedCrawlerJob;

/**
 * Feed Backend Controller

 */
class Article extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('UnixDevil.Crawler', 'crawler', 'article');
    }
}
