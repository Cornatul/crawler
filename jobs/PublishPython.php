<?php namespace UnixDevil\Crawler\Jobs;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\DomCrawler\Crawler;
use UnixDevil\Crawler\DTO\HtmlStructureDTO;

/**
 * @package UnixDevil\Crawler\Jobs
 * @class SiteCrawler
 */
class PublishPython implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
        info("PublishPython::__construct()");
    }

    /**
     *
     * Execute the job.
     */
    final public function handle():void
    {
        info("this should {$this->data} ");
    }
}
