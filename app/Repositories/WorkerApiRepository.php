<?php

namespace App\Repositories;

use App\Events\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkerApiRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Worker::class;
    }


    /**
     * 搜索师傅.
     *
     * @param string $filePath
     * @param bool $immutable
     * @param string $point 经纬度
     * @param int $dist 距离范围
     * @param int $limit 查询多少个
     * @param int $status 师傅状态
     *
     * @return bool
     */

    public function selectData($point, $dist, $status, $limit)
    {

        $sql = $this->getSearchSql($point, $dist, $status, $limit);
        try {
            $result = DB::select($sql);
        } catch (\Exception $e) {
            Log::info('c=WorkerApiRepository f=selectData  msg=' . $e->getMessage());
            return false;
        }
        return $result;
    }


    /**
     * 添加师傅.
     *
     * @param string $filePath
     * @param array $data 添加数据
     *
     * @return bool
     */

    public function insertData($data)
    {
        $sql = $this->getInsertSql($data);

        try {
            $result = DB::insert($sql);
        } catch (\Exception $e) {
            Log::info('c=WorkerApiRepository f=insertData  msg=' . $e->getMessage());
            return false;
        }
        return $result;

    }

    /**
     * 修改师傅.
     *
     * @param string $filePath
     * @param array $data 修改数据
     *
     * @return bool
     */

    public function saveData($data, $id)
    {
        $sql = $this->getSaveSql($data, $id);
//        echo $sql;
        try {
            $result = DB::update($sql);
        } catch (\Exception $e) {
            Log::info('c=WorkerApiRepository f=saveData  msg=' . $e->getMessage());
            return false;
        }
        return $result;

    }


    /**
     * 拼装插入数据GIS sql语句.
     *
     * @param string $filePath
     * @param array $data 要插入的字段/数据
     *
     * @return string  sql
     */

    protected function getSearchSql($point, $dist, $status, $limit)
    {


        $point = "point($point)";
        $distSql = "ST_DistanceSphere(geom,ST_GeomFromText('$point',4326))";

        $sql = "select *,
            ST_AsText(geom),
            {$distSql} dist
            from workers
            where {$distSql} < {$dist}
            AND state = {$status}
            order by {$distSql}
            limit {$limit}";

        return $sql;

    }


    /**
     * 拼装插入数据GIS sql语句.
     *
     * @param string $filePath
     * @param array $data 要插入的字段/数据
     *
     * @return string  sql
     */

    protected function getInsertSql($data)
    {
        $strfield = '';
        $strvalue = '';
        $data['geom']=$data['worker_lng'].' '.$data['worker_lat'];
        foreach ($data as $k => $v) {
            if($k =='worker_lat' || $k="lbs_token"  || $k =='worker_lng') {
                continue;
            }
            $strfield .= $k . ',';
            if ($k == 'geom') {
                $strvalue .= "ST_GeomFromText('POINT(" . addslashes($v) . ")',4326),";
            } else {
                $strvalue .= "'" . addslashes($v) . "',";
            }
        }
        $strfield = rtrim($strfield, ',');
        $strvalue = rtrim($strvalue, ',');

        return "insert into workers({$strfield},created_at,updated_at) VALUES ($strvalue,now(),now())";

    }


    /**
     * 拼装修改师傅数据GIS sql语句.
     *
     * @param string $filePath
     * @param array $data 要插入的字段/数据
     * @param array $uid 修改关联uid键
     *
     * @return string  sql
     */

    protected function getSaveSql($data, $uid)
    {
        $set = '';
        if(isset($data['worker_lng'])&& isset($data['worker_lat'])){
            $data['geom']=$data['worker_lng'].' '.$data['worker_lat'];
        }
        foreach ($data as $k => $v) {
            if($k =='worker_lat' || $k="lbs_token"  || $k =='worker_lng') {
                continue;
            }
            if ($k == 'geom') {
                $strvalue = "ST_GeomFromText('POINT({$v})',4326)";
            } else {
                $strvalue = "'" . addslashes($v) . "'";
            }

            $set .= $k . '=' . $strvalue . ',';

        }
        $strfield = rtrim($set, ',');

        return "UPDATE workers SET {$strfield},updated_at = now() WHERE uid = '" . $uid . "'";

    }


}