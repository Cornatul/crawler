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
class SiteCrawler implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private HtmlStructureDTO $htmlStructureDTO;

    public function __construct(HtmlStructureDTO $htmlStructureDTO)
    {
        $this->htmlStructureDTO = $htmlStructureDTO;
        info("SiteCrawler::__construct() {$this->htmlStructureDTO->toJson()}");
    }

    /**
     *
     * Execute the job.
     */
    final public function handle():void
    {
        $client = new Client();
        try {
            $content = $client->get($this->htmlStructureDTO->fields["url"]);
            $body = $content->getBody()->getContents();
            $this->processBody($body);
        } catch (ClientException|GuzzleException $e) {
            info($e->getMessage() . $e->getTraceAsString());
        }
        foreach ($this->htmlStructureDTO->fields as $field => $value) {
            $this->htmlStructureDTO->fields[$field] = "";
        }
    }

    private function processBody(string $body): void
    {
        $crawler = new Crawler($body);

        foreach ($this->htmlStructureDTO->fields as $field => $value) {
            if ($field === "url") {
                continue;
            }
            if ($field === "category") {
                continue;
            }
            $crawler->filter($this->htmlStructureDTO->fields[$field])->each(function (Crawler $node, $i) use ($field) {
                $this->htmlStructureDTO->fields[$field] = $node->text();
            });
        }
        info($this->htmlStructureDTO->toJson());
    }
}
