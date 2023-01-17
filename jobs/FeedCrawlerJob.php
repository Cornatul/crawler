<?php namespace UnixDevil\Crawler\Jobs;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Laminas\Feed\Reader\Entry\Rss;
use Laminas\Feed\Reader\Reader;
use Throwable;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\DTO\FeedExtractorDTO;
use UnixDevil\Crawler\DTO\FeedFinderDto;
use UnixDevil\Crawler\Exceptions\FeedCrawlerJobException;
use UnixDevil\Crawler\Models\Crawler;
use UnixDevil\Crawler\Models\Feed;

/**
 * @package UnixDevil\Crawler\Jobs
 * @class FeedCrawlerJob
 */
class FeedCrawlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Feed $feed;

    public int $tries = 1;

    public function __construct(Feed $feed)
    {
        $this->queue = 'feed-crawler';
        $this->feed = $feed;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        try
        {
            $data = Reader::import($this->feed->url);

            /**
             *
             * @var $entry Rss
             */
            foreach ($data as $key => $entry)
            {
                if ($entry->getDateCreated() < Carbon::now()->subDays(30))
                {
                    info("Entry older than 30 days, skipping {$entry->getDateCreated()->format('Y-m-d')}");

                    continue;
                }

                if(!Cache::has($entry->getLink()))
                {
                    Cache::put($entry->getLink(), $entry->getLink(), 60 * 60 * 24 * 30); //1 day in seconds

                    info("New entry found we should process it - {$entry->getLink()}");

                    dispatch(new NLPExtractor($entry->getLink()))->delay(5 + (5*$key));

                }else{
                    info("Entry already processed");
                }
            }

        }
        catch (FeedCrawlerJobException $exception)
        {
            info("Something went wrong {$exception->getMessage()}");
        }

    }

    public function failed($exception = null): void
    {
        $this->delete();
        $this->feed->delete();
    }

}
