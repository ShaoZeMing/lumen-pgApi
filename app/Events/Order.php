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
        'order_no',
        'order_desc',
        'state',
        'order_type',
        'biz_type',
        'merchant_id',
        'merchant_name',
        'merchant_tel',
        'user_id',
        'user_name',
        'user_mobile',
        'user_lat',
        'user_lng',
        'full_address',
        'published_at',
        'big_cat',
        'middle_cat',
        'small_cat',
        'created_at',
        'updated_at',
    ];

    protected $postgisFields = [
        'geom',
    ];


}
