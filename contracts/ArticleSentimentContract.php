<?php

namespace UnixDevil\Crawler\Contracts;

use GuzzleHttp\ClientInterface;

interface ArticleSentimentContract extends ClientInterface
{
    public function getSentiment(string $text): float;

}
