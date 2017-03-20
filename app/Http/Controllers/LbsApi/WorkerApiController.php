<?php

namespace App\Http\Controllers\LbsApi;

use App\Http\Controllers\Controller;
use App\Repositories\WorkerApiRepository;
use App\Validators\WorkerValidator;
use App\Validators\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class WorkerApiController extends Controller
{
    public $request;
    public $apiRepository;
    public $validator;

    public function __construct(Request $request, WorkerValidator $validator, WorkerApiRepository $apiRepository)
    {
        $this->request = $request;
        $this->apiRepository = $apiRepository;
        $this->validator = $validator;
    }

    /**
     * @api {get} /lbs/search-worker 搜索师傅
     * @apiName shaozeming@xiaobaiyoupin.com
     * @apiDescription 针对位置对附近师傅进行搜索
     * @apiGroup Worker-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String}  lbs_token  认证秘钥
     * @apiParam {Decimal} worker_lng 经度
     * @apiParam {Decimal} worker_lat 纬度
     * @apiParam {Int} [dist]  搜索范围(米)，默认30000
     * @apiParam {Int} [state]  状态(`0:正常,1:锁定`)，默认0
     * @apiParam {Int} [limit]  返回最多条数
     * @apiSuccess {BigInt}  id  主键ID
     * @apiSuccess {BigInt}  uid  关联ID
     * @apiSuccess {String} dist 距离(米)
     * @apiSuccess {String}  full_address  地址
     * @apiSuccess {String}  name  姓名
     * @apiSuccess {String}  mobile  电话
     * @apiSuccess {float}  worker_lat  纬度
     * @apiSuccess {float}  worker_lng  经度
     * @apiSuccess {String}  geom  位置几何
     * @apiSuccess {String}  created_at  创建时间
     * @apiSuccess {String}  updated_at  修改时间
     * @apiSuccessExample {json} 成功-Response:
     * {
     * "error": 0,
     * "msg": "成功",
     * "data": {
     * "size": 2,
     * "list": [
     * {
     * "id": "108004",
     * "name": "明明",
     * "mobile": "13332425562",
     * "state": 0,
     * "worker_lat": "39.33",
     * "worker_lng": "119.94",
     * "full_address": "中关村五道口",
     * "uid": "233334",
     * "geom": "0101000020E6100000C3B645990DFC5D402D78D15790AA4340",
     * "created_at": "2017-03-20 18:30:18",
     * "updated_at": "2017-03-20 18:30:18",
     * "st_astext": "POINT(119.93833 39.33253)",
     * "dist": "0"
     * },
     * {
     * "id": "1",
     * "name": "明明",
     * "mobile": "13332425562",
     * "state": 0,
     * "worker_lat": "39.33",
     * "worker_lng": "158.94",
     * "full_address": "中关村五道口",
     * "uid": "1",
     * "geom": "0101000020E6100000C3B645990DFC5D402D78D15790AA4340",
     * "created_at": "2017-03-17 15:25:05",
     * "updated_at": "2017-03-20 18:55:56",
     * "st_astext": "POINT(119.93833 39.33253)",
     * "dist": "0"
     * }
     * ]
     * }
     * }
     */
    public function search()
    {
        $options = $this->request->all();
        Log::info('c=WorkerApiController f=search  options=' . json_encode($options));
        $worker_lng = isset($options['worker_lng']) ? $options['worker_lng'] : 0;
        $worker_lat = isset($options['worker_lat']) ? $options['worker_lat'] : 0;
        $dist = isset($options['dist']) && !empty($options['dist']) ? (int)$options['dist'] : env('DISTANCE', 30000);
        $limit = isset($options['limit']) && !empty($options['limit']) ? (int)$options['limit'] : env('LIMIT', 100);
        $status = isset($options['state']) ? (int)$options['state'] : 0;
        if (!$worker_lng || !$worker_lat) {
            Log::info('c=WorkerApiController f=search  msg= 位置数据未输入');
            return $this->response_json(1, "经纬度数据未输入", [], 422);
        }
        $geom = $worker_lng . ' ' . $worker_lat;
        $lists = $this->apiRepository->selectData($geom, $dist, $status, $limit);
        if ($lists !== false) {
            $out_response = [
                'size' => count($lists),
                'list' => $lists,
            ];
            return $this->response_json(0, "成功", $out_response);
        } else {
            return $this->response_json(1, "失败", [], 422);
        }

    }


    /**
     * @api {post} /lbs/insert-worker 添加师傅
     * @apiDescription 添加师傅位置信息
     * @apiGroup Worker-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String}  lbs_token  认证秘钥
     * @apiParam {BigInt}  uid  关联ID
     * @apiParam {String} dist 距离(米)
     * @apiParam {String}  full_address  地址
     * @apiParam {String}  name  姓名
     * @apiParam {String}  mobile  电话
     * @apiParam {float}  worker_lat  纬度
     * @apiParam {float}  worker_lng  经度
     * @apiParam {String}  geom  位置几何
     * @apiParam {String}  created_at  创建时间
     * @apiParam {String}  updated_at  修改时间
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} 成功-Response:
     * {
     * "error": 0,
     * "msg": "添加成功",
     * "data": []
     * }
     *
     * @apiErrorExample {json} 错误-Response:
     * {
     * "error": 1,
     * "msg": "验证错误：该uid关联师傅已存在(uid),",
     * "data": []
     * }
     */
    public function insert()
    {

        try {
            $this->validate(
                $this->request,
                $this->validator->getRules(Validator::RULE_CREATE),
                $this->validator->getMassage());
        } catch (ValidationException $e) {
            Log::info('c=WorkerApiController f=insert  msg=' . $this->response_msg($e->getResponse()));
            return $this->response_msg($e->getResponse());
        }

        $data = $this->request->all();
        Log::info('c=WorkerApiController f=insert  msg=' . json_encode($data));

        $result = $this->apiRepository->insertData($data);
        if ($result !== false) {
            return $this->response_json(0, "添加成功", []);
        } else {
            return $this->response_json(1, "添加失败", [], 422);
        }
    }

    /**
     * @api {post} /lbs/save-worker 修改师傅状态
     * @apiDescription 修改师傅信息
     * @apiGroup Worker-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String}  lbs_token  认证秘钥
     * @apiParam {Bigint}  uid  关联id
     * @apiParam {Int}  state  师傅状态(0:正常，1:锁定)
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} 成功-Response:
     *  {
     *   "error": 0,
     *   "msg": "修改成功",
     *   "data": []
     *  }
     * @apiErrorExample {json} 错误-Response:
     * {
     * "error": 1,
     * "msg": "验证错误：未输入师傅关联id(uid),",
     * "data": []
     * }
     */
    public function save()
    {
        try {
            $this->validate(
                $this->request,
                $this->validator->getRules(Validator::RULE_UPDATE),
                $this->validator->getMassage());

        } catch (ValidationException $e) {
            Log::info('c=WorkerApiController f=save  msg=' . $this->response_msg($e->getResponse()));
            return $this->response_msg($e->getResponse());
        }

        $options = $this->request->all();
        Log::info('c=WorkerApiController f=save  msg=' . json_encode($options));
        $uid = isset($options['uid']) ? (int)$options['uid'] : 0;

        $result = $this->apiRepository->saveData($options, $uid);

        if ($result !== false) {
            return $this->response_json(0, "修改成功", $result);
        } else {
            return $this->response_json(1, "修改失败", [], 422);
        }
    }


}
