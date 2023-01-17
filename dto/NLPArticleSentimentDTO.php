<?php

namespace UnixDevil\Crawler\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Normalizers\ModelNormalizer;

/**
 * @package UnixDevel\Crawler
 * @class NLPArticleSentimentDTO
 *
 */
class NLPArticleSentimentDTO extends Data
{
    public string $title;
    public ?string $date;
    public string $text;
    public string $html;
    public string $summary;
    public ?array $authors;
    public ?array $keywords;
    public ?array $images;
    public ?array $entities;
}
