<?php

namespace UnixDevil\Crawler\Contracts;

use UnixDevil\Crawler\DTO\FeedFinderDTO;

interface FeedFinderContract
{
    public function find(string $topic, string $language):FeedFinderDTO;
}
