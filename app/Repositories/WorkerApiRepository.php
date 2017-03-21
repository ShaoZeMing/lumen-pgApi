<?php

namespace App\Repositories;

use App\Events\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Phaza\LaravelPostgis\Geometries\GeomPoint;

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


        try {
            $location1 = new Worker();
            $location1->name = $data['name'];
            $location1->uid = $data['uid'];
            $location1->mobile = $data['mobile'];
            $location1->worker_lat = $data['worker_lat'];
            $location1->worker_lng = $data['worker_lng'];
            $location1->full_address = $data['full_address'];
            $location1->geom = new GeomPoint($data['worker_lng'], $data['worker_lat']);
            $location1->save();
        } catch (\Exception $e) {
            Log::info('c=WorkerApiRepository f=insertData  msg=' . $e->getMessage());
            return false;
        }

        return $location1->getQueueableId();




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
        try {
            $location1 = Worker::where('uid', $data['uid'])->first();;
            $location1->name = isset($data['name']) ? $data['name'] : $location1->name;
            $location1->uid = isset($data['uid']) ? $data['uid'] : $location1->uid;
            $location1->state = isset($data['state']) ? $data['state'] : $location1->state;
            $location1->mobile = isset($data['mobile']) ? $data['mobile'] : $location1->mobile;
            $location1->worker_lat = isset($data['worker_lat']) ? $data['worker_lat'] : $location1->worker_lat;
            $location1->worker_lng = isset($data['worker_lng']) ? $data['worker_lng'] : $location1->worker_lng;
            $location1->full_address = isset($data['full_address']) ? $data['full_address'] : $location1->full_address;
            $location1->geom = new GeomPoint( $location1->worker_lng,$location1->worker_lat);
            return $location1->save();
        } catch (\Exception $e) {
            Log::info('c=WorkerApiRepository f=saveData  msg=' . $e->getMessage());
            return false;
        }



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


}