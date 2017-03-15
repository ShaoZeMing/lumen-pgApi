<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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


//
//    /**
//     * 搜索师傅.
//     *
//     * @param string $filePath
//     * @param bool   $immutable
//     * @param string   $point 经纬度
//     * @param int   $dist 距离范围
//     * @param int   $limit 查询多少个
//     * @param int   $status 师傅状态
//     *
//     * @return void
//     */
//
//    public static function selectData($point="116.340714 39.992727",$status=0,$dist=30000,$limit=100){
//
//        $point="point($point)";
//        $distSql="ST_DistanceSphere(geom,ST_GeomFromText('$point',4326))";
//        $results = app('db')->select(
//            "select *,
//            ST_AsText(geom),
//            {$distSql} dist
//            from repairmans
//            where {$distSql} < {$dist}
//            AND status = {$status}
//            order by {$distSql}
//            limit {$limit}"
//        );
//
//        return $results;
//    }
//
//
//    /**
//     * 添加师傅.
//     *
//     * @param string $filePath
//     * @param bool   $immutable
//     * @param string   $point 经纬度
//     * @param int   $dist 距离范围
//     * @param int   $limit 查询多少个
//     * @param int   $status 师傅状态
//     *
//     * @return void
//     */
//
//    public static function insertData($data){
//
//        $point="point({$data['point']})";
//        $geom="ST_GeomFromEWKT('SRID=312;POINTM(-126.4 45.32 15)')";
//
//    }

}
