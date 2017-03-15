<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class Order extends Model
{


    /**
     * Create a new event instance.
     *
     * @return void
     */
    use PostgisTrait;

    protected $table= 'orders';

    protected $fillable = [
        'o_id',
        'status',
        'b_id',
        'b_name',
        'c_id',
        'c_name',
        'u_name',
        'mobile',
        'description',
        'address',
        'created_at',
        'updated_at',
    ];

    protected $postgisFields = [
        'geom',
    ];


}
