<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class Repairman extends Model
{
    use PostgisTrait;

    protected $table= 'repairmans';

    protected $fillable = [
        'name',
        'mobile',
        'status',
        'uid',
        'address',
        'created_at',
        'updated_at',
    ];

    protected $postgisFields = [
        'geom',
    ];

}
