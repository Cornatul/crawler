<?php

namespace UnixDevil\Crawler\Contracts;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;

interface TrendingContract
{
    public function getHeadlines(string $category, string $country):Collection;
    public function getTrendingKeywords():Collection;
}
