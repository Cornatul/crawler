<?php

namespace UnixDevil\Crawler\Contracts;

use Illuminate\Support\Collection;
use UnixDevil\Crawler\Models\Feed;

/**
 * @package UnixDevel\Crawler
 *
 */
interface FeedContract extends BaseRepositoryContract
{
    /**
     * @param Feed $feed
     * @param Collection $categories
     * @return void
     */
    public function attachCategories(Feed $feed, Collection $categories): void;
}
