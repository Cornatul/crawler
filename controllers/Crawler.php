<?php namespace UnixDevil\Crawler\Controllers;


use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use Illuminate\Support\Facades\Log;
use UnixDevil\Crawler\Jobs\CrawlerJob;
use UnixDevil\Crawler\Jobs\FeedCrawlerJob;

/**
 * Crawler Backend Controller
 */
class Crawler extends Controller
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

        BackendMenu::setContext('UnixDevel.Crawler', 'crawler', 'crawler');
    }


    public function onSync(): void
    {
        $record = post("record");
        $crawler = \UnixDevil\Crawler\Models\Crawler::with('feeds')->find($record);
        foreach ($crawler->feeds()->get() as $feed):
            FeedCrawlerJob::dispatch($feed);
            $crawler->status = \UnixDevil\Crawler\Models\Crawler::RUNNING;
            $crawler->save();
        endforeach;
    }
}
