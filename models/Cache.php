<?php
namespace Riuson\EveApi\Models;

use Model;

/**
 * Cache Model
 */
class Cache extends Model
{

    /**
     *
     * @var string The database table used by the model.
     */
    public $table = 'riuson_eveapi_caches';

    /**
     *
     * @var array Guarded fields
     */
    protected $guarded = [
        '*'
    ];

    /**
     *
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     *
     * @var array Relations
     */
    public $hasOne = [];

    public $hasMany = [];

    public $belongsTo = [];

    public $belongsToMany = [];

    public $morphTo = [];

    public $morphOne = [];

    public $morphMany = [];

    public $attachOne = [];

    public $attachMany = [];

    public function getDates()
    {
        return [
            'created_at',
            'updated_at',
            'cached',
            'cachedUntil'
        ];
    }
}