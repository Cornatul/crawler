<?php

namespace UnixDevil\Crawler\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Normalizers\ModelNormalizer;

/**
 * @package UnixDevel\Crawler
 * @class FeedFinderDTO
 *
 */
class FeedFinderDTO extends Data
{
    private string $title;

    private string $description;

    private string $url;

    public string $language;

    public int $size;

    #[MapInputName('feedInfos')]
    public array $feeds;

    /**
     * @method getFeeds
     * @return Collection
     */
    public function getFeeds(): Collection
    {
        $collection = collect();
        foreach ($this->feeds as $feed) {
            $collection->push([
                "title" => $feed["title"] ?? "",
                "description" => $feed["description"] ?? "",
                "url" => str_replace("feed/", "", $feed["id"]),
                "image" => $feed["coverUrl"] ?? "",
                "score" => $feed["leoScore"] ?? "",
                "last_update" => Carbon::parse($feed["updated"]),
                "subscribers" => $feed["subscribers"] ?? "",
                "categories" => $feed["topics"] ?? [],
                "imported" => $this->checkIfFeedImported(str_replace("feed/", "", $feed["id"]))
            ]);
        }
        return $collection;
    }

    private function checkIfFeedImported(string $url): bool
    {
        $record = (new \UnixDevil\Crawler\Models\Feed)->where('url', $url)->first();

        return !is_null($record);
    }

}
