<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class Repairman extends Model
{
    use PostgisTrait;

    protected $fillable = [
        'name',
        'address'
    ];

    protected $postgisFields = [
        'geom',
    ];

}
