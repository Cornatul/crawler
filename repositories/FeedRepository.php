<?php

namespace UnixDevil\Crawler\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use UnixDevil\Crawler\Contracts\FeedContract;
use UnixDevil\Crawler\Models\Feed;
use Winter\Blog\Models\Category;

/**
 * @package FeedRepository
 */
class FeedRepository implements FeedContract
{
    public function find(int $recordID):Model
    {
        return Feed::find($recordID);
    }

    final public function create(array $data):Model
    {
        return Feed::create($data);
    }

    /**
     * @param Feed $feed
     * @param Collection $categories
     * @return void
     */
    final public function attachCategories(Feed $feed, Collection $categories): void
    {
        foreach ($categories->get('categories') as $category) {
            $categoryModel = Category::firstOrNew([
                "name" => $category
            ]);

            $feed->categories()->attach($categoryModel->id);
        }
    }


    final public function delete(int $recordID): int
    {
        return Feed::destroy($recordID);
    }
}
