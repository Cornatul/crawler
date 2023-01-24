<?php

namespace UnixDevil\Crawler\Clients;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use UnixDevil\Crawler\Contracts\TrendingContract;

class TrendingClient implements TrendingContract
{

    private ClientInterface $client;

    private string $trendingEndpoint;

    public function __construct(ClientInterface $client, string $trendingEndpoint = "")
    {
        $this->client = $client;
        $this->trendingEndpoint = $trendingEndpoint;
    }

    /**
     * @throws \JsonException
     */
    final public function getHeadlines(string $category = "technology", string $country = "us"): Collection
    {
        $response = $this->client->get($this->trendingEndpoint."category={$category}&country={$country}");

        $data =  json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return collect($data['articles']);
    }

    final public function getTrendingKeywords(): Collection
    {
        //@todo implement this
        return collect();
    }

}
