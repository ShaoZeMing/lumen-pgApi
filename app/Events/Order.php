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
        'order_id',
        'state',
        'merchant_name',
        'merchant_telphone',
        'category_id',
        'category_name',
        'user_name',
        'user_mobile',
        'description',
        'full_address',
        'created_at',
        'updated_at',
    ];

    protected $postgisFields = [
        'order_geom',
    ];


}
