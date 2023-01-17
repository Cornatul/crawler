<?php

namespace UnixDevil\Crawler\Dto;

use Spatie\LaravelData\Data;

class CrawlerDTO extends Data
{
    public string $type;
    public string $link;
}
