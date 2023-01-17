<?php

namespace UnixDevil\Crawler\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use JsonException;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\DTO\FeedFinderDTO;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;
use UnixDevil\Crawler\DTO\NlpDTO;

/**
 * @class NLPClient
 */
class NLPClient extends Client implements NLPContract
{
    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    final public function getArticleSentiment(string $urlToExtract): NLPArticleSentimentDTO
    {
        //
        $response = $this->post(Config::get('nlp.endpoint.sentiment'), [
            'json' => [
                'query' => $urlToExtract
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

    /**
     * @return array
     * @throws JsonException
     * @throws GuzzleException
     */
    final public function getTrendingNews(string $category = "technology", string $country = "us"):array
    {
        //todo move this to a service
        $response = $this->get("https://newsapi.org/v2/top-headlines?category={$category}&country={$country}&apiKey=c29a123962034057aac547e7321be062");
        $data =  json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        return $data['articles'];
    }

    final public function getTrendingKeywords(): array
    {
        return [];
        //todo implement this
    }
}
