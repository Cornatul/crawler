<?php
namespace UnixDevil\Crawler\Models;

use Winter\Storm\Support\Str;

/**
 * @param $id
 * @param $title
 * @method static FeedArticle find($id)
 */
class FeedArticle extends \Winter\Blog\Models\Post
{
    public $fillable = [
        'title' ,
        'slug' ,
        'excerpt',
        'content',
        "content_html",
        "published_at",
        "published",
    ];
}
