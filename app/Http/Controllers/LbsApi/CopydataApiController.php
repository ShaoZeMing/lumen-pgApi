<?php

namespace App\Http\Controllers\LbsApi;

use App\Exceptions\MyException;
use App\Http\Controllers\Controller;
use App\Repositories\WorkerApiRepository;
use App\Validators\WorkerValidator;
use App\Validators\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CopydataApiController extends Controller
{
    private $num = 0;



    /**
     * @api {get} /lbs/sync-worker 同步师傅数据
     * @apiDescription 同步师傅数据，将老系统mysql中的师傅数据导入定位系统postSql中
     * @apiGroup LBS-Sync
     * @apiPermission LBS_TOKEN
     * @apiParam {String}  lbs_token  认证秘钥
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} 成功-Response:
     *  {
     *   "error": 0,
     *   "msg": "同步成功",
     *   "data": []
     *  }
     * @apiErrorExample {json} 错误-Response:
     * {
     * "error": 1,
     * "msg": "导入失败",
     * "data": []
     * }
     */

    public function sync(Request $request)
    {
        $options=$request->all();

        Log::info('c=CopydataApiController f=sync  msg=' .json_encode($options));

        if($options)

        $starttime = explode(' ', microtime());

        $maxUid = $this->getMaxUid();
        $maxId = $this->getMaxId();
        $size = $maxId - $maxUid;

        $limit = 2000;
        if ($size <= 0) {
            return $this->response_json(0, "当前同步已最新，没有需要同步的数据", []);
        }

        try{
            for ($i = 0; $i < ceil($size / $limit); $i++) {
                $data = $this->getMySqlData($limit, $maxUid);
                $maxUid += $limit;
                $this->insertData($data);
            }
        }catch (\Exception $e){
            return $this->response_json(1, "数据导入失败", []);
        }



        $endtime = explode(' ', microtime());
        $thistime = $endtime[0] + $endtime[1] - ($starttime[0] + $starttime[1]);
        $thistime = round($thistime, 3);

        $str = "本次共同步了" . $this->num . "条数据，用时:" . $thistime . '秒';
        return $this->response_json(0, $str, []);
    }

    /**
     * 获取pgsql中师傅表最大的uid.
     * @return int  uid
     */

    public function getMaxUid()
    {

        try {
            $result = app('db')->select("select max(uid) uid from " . config("database.pgsql_workers"));

        } catch (\Exception $e) {
            Log::info('c=CopydataApiController f=getMaxUid  msg=' . $e->getMessage());
            return false;
        }
        $max = $result[0]->uid;
        return (int)$max;
    }

    /**
     * 获取mysql中师傅表最大的id.
     * @return int  id
     */

    public function getMaxId()
    {

        try {
            $result = app('db')->connection('mysql')->select("select max(id) maxid from " . config("database.mysql_workers"));

        } catch (\Exception $e) {
            Log::info('c=CopydataApiController f=getMaxId  msg=' . $e->getMessage());
            return false;
        }
        $max = $result[0]->maxid;
        return (int)$max;
    }


    /**
     * 获取mysql师傅数据.
     *
     * @param int $limit 一次返回多少条
     * @param int $offset 数据偏移
     * @return array
     */

    public function getMySqlData($limit, $offset)
    {

        try {
            $data = app('db')
                ->connection('mysql')
                ->select("select id as uid ,name,mobile,full_address,worker_lat as x,worker_lng as y,created_at,updated_at from " . config("database.mysql_workers") . " limit {$offset},{$limit}");
        } catch (\Exception $e) {
            Log::info('c=CopydataApiController f=getMySqlData  msg=' . $e->getMessage());
            return false;
        }
        return $data;
    }


    public function insertData($data)
    {
        $sql = $this->getInsertSql($data);
        try {
            $result = app("db")->insert($sql);
        } catch (\Exception $e) {
            Log::info('c=CopydataApiController f=insertData  msg=' . $e->getMessage());
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

    protected function getInsertSql($data)
    {
        $sql = '';
        foreach ($data as $v) {
            $v->geom = $v->x . " " . $v->y;
            $strfield = '';
            $strvalue = '';
            foreach ($v as $k => $vv) {
                if ($k == 'x' || $k == 'y') {
                    continue;
                }
                $strfield .= $k . ',';
                if ($k == 'geom') {
                    $strvalue .= "ST_GeomFromText('POINT(" . addslashes($vv) . ")',4326),";
                } else {
                    $strvalue .= "'" . addslashes($vv) . "',";
                }
            }

            $this->num += 1;
            $strfield = rtrim($strfield, ',');
            $strvalue = rtrim($strvalue, ',');
            $sql .= "({$strvalue}),";
        }
        $sql = rtrim($sql, ',');
        $sql = "insert into " . config("database.pgsql_workers") . "({$strfield}) VALUES {$sql}";


        return $sql;

    }



    //添加数据导入测试师傅数据
//    public function insert()
//    {
//        $i = 1;
//        $ii = 0;
//        $sql = '';
//        while ($i < 10000) {
//            $x = (0.5 - mt_rand(0, 100000) / 100000) * 180;
//            $p = mt_rand(0, 10000000000) * 8;
//
//            $y = (0.5 - mt_rand(0, 100000) / 100000) * 90;
//            $sql .= "(\"高渐离\",\"{$p}\",\"易水寒\",1,23,\"墨家机关城68号\",{$x},{$y}),";
//
//            $i++;
//        }
//
//        $sql = "INSERT INTO `lsd_workers`(`name`, `mobile`, `nickname`, `sex`, `age`, `full_address`, `worker_lat`, `worker_lng`) VALUES " . $sql;
//        $sql = rtrim($sql, ',');
//        $users = DB::connection('mysql')->insert($sql);
//        echo $users;

//    }


}
