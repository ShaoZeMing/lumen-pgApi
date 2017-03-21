<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;

class Worker extends Model
{
    use PostgisTrait;

    protected $table= 'workers';

    protected $fillable = [
        'name',
        'mobile',
        'state',
        'uid',
        'full_address',
        'worker_lat',
        'worker_lng',
        'created_at',
        'updated_at',
    ];

    protected $postgisFields = [
        'geom '=> Point::class,
    ];


}
