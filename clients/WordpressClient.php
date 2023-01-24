<?php

namespace UnixDevil\Crawler\Clients;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use JsonException;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\Contracts\WordpressContract;
use UnixDevil\Crawler\DTO\FeedFinderDTO;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;
use UnixDevil\Crawler\DTO\NlpDTO;

/**
 * @todo find an way to implement a client here
 * @class NLPClient
 */
class WordpressClient implements WordpressContract
{

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    final public function createPost(): void
    {
        // TODO: Implement createPost() method.
    }


}
