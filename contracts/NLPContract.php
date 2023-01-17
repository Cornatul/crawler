<?php

namespace UnixDevil\Crawler\Contracts;

use UnixDevil\Crawler\DTO\NLPArticleSentimentDTO;

interface NLPContract
{
    public function getArticleSentiment(string $urlToExtract):NLPArticleSentimentDTO;
}
