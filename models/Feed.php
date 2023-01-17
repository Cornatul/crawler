<?php namespace UnixDevil\Crawler\Models;

use Carbon\Carbon;

use Model;
use Winter\Blog\Models\Category;

/**
 * CrawlerFeed Model
 * @property string $url
 * @method first()
 * @method static find(int $recordID)
 * @method static create(array $data)
 * @method where(string $column, string $value)
 * @method categories()
 */
class Feed extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'unixdevil_feeds';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'image',
        'score',
        'subscribers'
    ];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'links' => [
            Category::class,
            'table' => 'unixdevil_feeds_categories',
        ],
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'categories' => [
            Category::class,
            'table' => 'unixdevil_feeds_categories',
        ],
        'crawlers' => [
            Crawler::class,
            'table' => 'unixdevil_crawlers_feeds',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
