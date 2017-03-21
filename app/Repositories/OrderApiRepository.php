<?php

namespace App\Repositories;

use App\Events\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Phaza\LaravelPostgis\Geometries\GeomPoint;

class OrderApiRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }


    /**
     * 搜索订单.
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
            Log::info('c=OrderApiRepository f=selectData  msg=' . $e->getMessage());
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
            $location1 = new Order();
            $location1->order_no = $data['order_no'];
            $location1->order_desc = $data['order_desc'];
            $location1->full_address = $data['full_address'];
            $location1->user_id = $data['user_id'];
            $location1->user_name = $data['user_name'];
            $location1->user_mobile = $data['user_mobile'];
            $location1->merchant_id = $data['merchant_id'];
            $location1->merchant_name = $data['merchant_name'];
            $location1->merchant_tel = $data['merchant_tel'];
            $location1->published_at = $data['published_at'];
            $location1->user_lat = $data['user_lat'];
            $location1->user_lng = $data['user_lng'];
            $location1->geom = new GeomPoint($data['user_lng'], $data['user_lat']);
            $location1->big_cat = isset($data['big_cat']) ? $data['big_cat'] : '';
            $location1->middle_cat = isset($data['middle_cat']) ? $data['middle_cat'] : '';
            $location1->small_cat = isset($data['small_cat']) ? $data['small_cat'] : '';
            $location1->order_type = isset($data['order_type']) ? $data['order_type'] :0;
            $location1->biz_type = isset($data['biz_type']) ? $data['biz_type'] : 0;
            $location1->save();
        } catch (\Exception $e) {
            Log::info('c=OrderApiRepository f=insertData  msg=' . $e->getMessage());
            return false;
        }
        return $location1->getQueueableId();

    }

    /**
     * 修改工单.
     *
     * @param string $filePath
     * @param array $data 修改数据
     *
     * @return bool
     */

    public function saveData($data)
    {

        try {
            $location1 = Order::where('order_no', $data['order_no'])->first();;
            $location1->state = isset($data['state']) ? $data['state'] : $location1->state;
            $location1->order_desc = isset($data['order_desc']) ? $data['order_desc'] : $location1->order_desc;
            $location1->full_address = isset($data['full_address']) ? $data['full_address'] : $location1->full_address;
            $location1->user_id = isset($data['user_id']) ? $data['user_id'] : $location1->user_id;
            $location1->user_name = isset($data['user_name']) ? $data['user_name'] : $location1->user_name;
            $location1->user_mobile = isset($data['user_mobile']) ? $data['user_mobile'] : $location1->user_mobile;
            $location1->merchant_id = isset($data['merchant_id']) ? $data['merchant_id'] : $location1->merchant_id;
            $location1->merchant_name = isset($data['merchant_name']) ? $data['merchant_name'] : $location1->merchant_name;
            $location1->merchant_tel = isset($data['merchant_tel']) ? $data['merchant_tel'] : $location1->merchant_tel;
            $location1->published_at = isset($data['published_at']) ? $data['published_at'] : $location1->published_at;
            $location1->user_lat = isset($data['user_lat']) ? $data['user_lat'] : $location1->user_lat;
            $location1->user_lng = isset($data['user_lng']) ? $data['user_lng'] : $location1->user_lng;
            $location1->big_cat = isset($data['big_cat']) ? $data['big_cat'] : $location1->big_cat;
            $location1->middle_cat = isset($data['middle_cat']) ? $data['middle_cat'] : $location1->middle_cat;
            $location1->small_cat = isset($data['small_cat']) ? $data['small_cat'] : $location1->small_cat;
            $location1->order_type = isset($data['order_type']) ? $data['order_type'] : $location1->order_type;
            $location1->biz_type = isset($data['biz_type']) ? $data['biz_type'] : $location1->biz_type;
            $location1->geom = new GeomPoint( $location1->user_lng,$location1->user_lat);
            return $location1->save();

        } catch (\Exception $e) {
            Log::info('c=OrderApiRepository f=saveData  msg=' . $e->getMessage());
            return false;
        }


    }


    /**
     * 拼装搜索数据GIS sql语句.
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
            {$distSql} dist
            from orders
            where {$distSql} < {$dist}
            AND state = {$status}
            order by {$distSql}
            limit {$limit}";
        return $sql;

    }


}