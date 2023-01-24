<?php

namespace UnixDevil\Crawler\Services;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Http\Client\HttpClientException;
use JsonException;
use UnixDevil\Crawler\Contracts\FeedFinderContract;
use UnixDevil\Crawler\DTO\FeedFinderDTO;
use Winter\Storm\Exception\ApplicationException;

/**
 * @class FeedFinderService
 * @todo move this to a concrete implementation of GuzzleHttp\ClientInterface
 */
class FeedFinderService implements FeedFinderContract
{

    protected ClientInterface $client;
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    private string $source = "https://feedly.com/v3/recommendations/topics/";

    /**
     * @method find
     * @throws JsonException
     */
    final public function find(string $topic, string $language = "en"): FeedFinderDTO
    {
        $dataArray = [];
        try {
            $url = ($this->source.$topic.'?locale='.$language);

            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);

            $response = $this->client->get($url);

            $dataArray = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return FeedFinderDTO::from($dataArray);
        } catch (GuzzleException $exception) {
            info("There was an issue with the client {$exception->getMessage()}");
            return FeedFinderDTO::from($dataArray);
        }
    }
}
