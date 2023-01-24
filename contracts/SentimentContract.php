<?php

namespace UnixDevil\Crawler\Contracts;

use GuzzleHttp\ClientInterface;
use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;

interface SentimentContract
{
    public function getArticleSentiment(string $urlToExtract):NLPArticleSentimentDTO;
}
