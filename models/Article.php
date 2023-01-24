<?php
namespace UnixDevil\Crawler\Models;

use Winter\Storm\Support\Str;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @method static Article find(int $id)
 */
class Article extends \Winter\Blog\Models\Post
{
    public $fillable = [
        'title' ,
        'slug' ,
        'excerpt',
        "content",
        "published_at",
        "published",
    ];
}
