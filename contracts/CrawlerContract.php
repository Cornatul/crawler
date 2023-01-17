<?php

namespace UnixDevil\Crawler\Contracts;

use UnixDevil\Crawler\Models\Crawler;

interface CrawlerContract
{
    public function process(Crawler $crawler):void;
}
