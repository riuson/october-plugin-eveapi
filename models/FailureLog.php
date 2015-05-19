<?php
namespace Riuson\EveApi\Models;

use Model;

/**
 * FailureLog Model
 */
class FailureLog extends Model
{

    /**
     *
     * @var string The database table used by the model.
     */
    public $table = 'riuson_eveapi_failure_logs';

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
}
