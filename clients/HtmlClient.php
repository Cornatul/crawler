<?php

namespace UnixDevil\Crawler\Clients;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use JsonException;
use Symfony\Component\DomCrawler\Crawler;
use UnixDevil\Crawler\Contracts\WordpressContract;
use UnixDevil\Crawler\DTO\FeedFinderDTO;
use UnixDevil\Crawler\DTO\HtmlStructureDTO;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;
use UnixDevil\Crawler\DTO\NlpDTO;
use UnixDevil\Crawler\Jobs\SiteCrawler;

/**
 * @class NLPClient
 */
class HtmlClient
{
    private ClientInterface $client;
    private HtmlStructureDTO $htmlStructureDTO;

    public const HEADERS = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'Accept' => 'text/html,application/xhtml',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Connection' => 'keep-alive',
        'Upgrade-Insecure-Requests' => '1',
        'Cache-Control' => 'max-age=0',
        'TE' => 'Trailers',
    ];

    public function __construct(ClientInterface $client, HtmlStructureDTO $htmlStructureDTO)
    {
        $this->client = $client;
        $this->htmlStructureDTO = $htmlStructureDTO;
    }

    /**
     * @throws GuzzleException
     */
    final public function process(): void
    {
        $links = $this->htmlStructureDTO->links;

        foreach ($links as $category => $link) {
            $content = $this->client->request('GET', $link, [
                'headers' => self::HEADERS,
            ]);
            if ($content->getStatusCode() ===200) {
                $body = $content->getBody()->getContents();
                $this->processBody($body, $category);
            }
            if ($content->getStatusCode() === 403) {
                info("403 Forbidden");
            }
            if ($content->getStatusCode() === 404) {
                info("404 Page not found");
            }
        }
    }

    private function processBody(string $body, string $category): void
    {
        info("Processing body");
        info("Body length: " . strlen($body));
        $crawler = new Crawler($body);
        $crawler->filter($this->htmlStructureDTO->iterator)->each(function (Crawler $node, $i) use ($category) {
            $this->htmlStructureDTO->fields["category"] = $category;
            if (str_contains($node->attr('href'), $this->htmlStructureDTO->base_url)) {
                info("Contains base url");
                $this->processSingle($node->attr('href'), $this->htmlStructureDTO);
            }
            $this->processSingle($this->htmlStructureDTO->base_url . $node->attr('href'), $this->htmlStructureDTO);
        });
    }

    /**
     * @throws \Exception
     */
    private function processSingle(string $url, HtmlStructureDTO $htmlStructureDTO): void
    {
        $htmlStructureDTO->fields["url"] = trim(str_replace(PHP_EOL, '', $url));
        dispatch(new SiteCrawler($htmlStructureDTO))->delay(now()->addSeconds(random_int(1, 25)));
    }
}
