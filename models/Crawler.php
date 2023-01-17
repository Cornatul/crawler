<?php namespace UnixDevil\Crawler\Models;

use Model;
use Winter\Blog\Models\Category;

/**
 * Crawler Model
 * @property string status
 * @method feeds()
 * @method static find()
 */
class Crawler extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    public const FINISHED = "finished";
    public const RUNNING = "running";

    /**
     * @var string The database table used by the model.
     */
    public $table = 'unixdevil_crawlers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        "name",
        "status"
    ];

    /**
     * @var array Validation rules for attributes
     */
    public array $rules = [];

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

    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'feeds' => [
            Feed::class,
            'table' => 'unixdevil_crawlers_feeds',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    final public function getStatusOptions($value, $formData):array
    {
        return [
            'finished' => 'Finished',
            'running' => 'Running'
        ];
    }
}
