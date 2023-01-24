<?php

namespace UnixDevil\Crawler\Clients;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use JsonException;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\Contracts\SentimentContract;
use UnixDevil\Crawler\DTO\FeedFinderDTO;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;
use UnixDevil\Crawler\DTO\NlpDTO;

/**
 * @todo find an way to implement a client here
 * @class NLPClient
 */
class SentimentClient implements SentimentContract
{

    private string $sentimentEndpoint;

    private ClientInterface $client;

    public function __construct(ClientInterface $client, string $sentimentEndpoint = "")
    {
        $this->client = $client;
        $this->sentimentEndpoint = $sentimentEndpoint;
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    final public function getArticleSentiment(string $urlToExtract): NLPArticleSentimentDTO
    {
        //
        $response = $this->client->post($this->sentimentEndpoint, [
            'json' => [
                'link' => $urlToExtract
            ]
        ]);

        $collection = collect(
            json_decode(
                $response->getBody()->getContents(),
                false,
                512,
                JSON_THROW_ON_ERROR
            )
        );

        return NLPArticleSentimentDTO::from($collection->get('data'));
    }
}
