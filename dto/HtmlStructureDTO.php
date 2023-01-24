<?php

namespace UnixDevil\Crawler\DTO;

use Spatie\LaravelData\Data;

class HtmlStructureDTO extends Data
{
    public string $base_url;

    public array $links = [];

    public string $iterator = "";

    public array $fields = [
        "url" => "",
        "title" => "",
        "content" => "",
        "category" => "",
        "image" => "",
    ];
}
