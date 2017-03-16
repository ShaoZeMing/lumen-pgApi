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
     * @apiDescription 针对师傅位置对师傅进行搜索
     * @apiGroup Worker-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String='(-180.00000,-90.000000) ~ (180.00000,90.000000) '} geom  位置坐标，格式 `"精度，纬度"`
     * @apiParam {Int} [dist]  搜索范围(米)，默认30000
     * @apiParam {Int} [limit]  返回条数
     * @apiSuccess {BigInt}  uid  师傅ID编号
     * @apiSuccess {String} dist 距离(米)
     * @apiSuccess {String}  full_address  联系人地址
     * @apiSuccess {String}  name  联系人姓名
     * @apiSuccess {String}  mobile  联系人电话
     * @apiSuccess {String}  created_at  创建时间
     * @apiSuccess {String}  updated_at  修改时间
     * @apiSuccessExample {json} 成功-Response:
     * {
     * "error": 0,
     * "msg": "成功",
     * "data": {
     * "size": 3,
     * "list": [
     * {
     * "id": "4",
     * "name": "近平先生",
     * "mobile": "15884565443",
     * "state": 0,
     * "full_address": "中关村创业大街123号",
     * "uid": "67",
     * "geom": "0101000020E610000060EAE74D45905E40EE42739D469E4640",
     * "created_at": "2017-03-16 18:58:36",
     * "updated_at": "2017-03-16 18:58:36",
     * "st_astext": "POINT(122.25423 45.23653)",
     * "dist": "1097.49543698"
     * },
     * {
     * "id": "3",
     * "name": "雷军",
     * "mobile": "15444565443",
     * "state": 0,
     * "full_address": "华清家园",
     * "uid": "12",
     * "geom": "0101000020E61000007E6FD39FFD8E5E404451A04FE49D4640",
     * "created_at": "2017-03-16 18:57:38",
     * "updated_at": "2017-03-16 18:57:38",
     * "st_astext": "POINT(122.23423 45.23353)",
     * "dist": "2121.35513343"
     * },
     * {
     * "id": "2",
     * "name": "弥勒法",
     * "mobile": "1333333333",
     * "state": 0,
     * "full_address": "少林寺",
     * "uid": "234",
     * "geom": "0101000020E61000007E6FD39FFD8E5E407D96E7C1DD9D4640",
     * "created_at": "2017-03-16 18:56:40",
     * "updated_at": "2017-03-16 18:56:40",
     * "st_astext": "POINT(122.23423 45.23333)",
     * "dist": "2136.42281823"
     * }
     * ]
     * }
     * }
     */
    public function search()
    {
        $options = $this->request->all();
        Log::info('c=WorkerApiController f=search  options=' . json_encode($options));
        $geom = isset($options['geom']) ? $options['geom'] : '';
        $dist = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE', 30000);
        $limit = isset($options['limit']) ? (int)$options['limit'] : env('LIMIT', 1000);
        $status = isset($options['state']) ? $options['state'] : 0;
        if (empty($geom)) {
            Log::info('c=WorkerApiController f=search  msg= 位置数据未输入');
            return $this->response_json(1, "位置数据未输入", [], 422);
        }
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
     * @apiParam {String='(-180.00000,-90.000000) ~ (180.00000,90.000000) '} geom 位置坐标，格式 `"精度，纬度"`
     * @apiParam {BigInt}  uid  师傅ID编号
     * @apiParam {String}  full_address  联系人地址
     * @apiParam {String}  name  姓名
     * @apiParam {String}  mobile  电话
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
     * @api {post} /lbs/insert-worker 修改师傅
     * @apiDescription 修改师傅信息
     * @apiGroup Worker-LBS
     * @apiPermission none
     * @apiParam {String}  uid  师傅uid
     * @apiParam {Int}  [state]  师傅状态(0:未接单，1:已接单，2:已完成，3:已取消)
     * @apiParam {String}  [full_address]  师傅地址
     * @apiParam {String}  [user_name]  师傅姓名
     * @apiParam {String}  [mobile]  师傅电话
     * @apiParam {String='(-180.00000,-90.000000) ~ (180.00000,90.000000) '} [geom]  位置坐标，格式 `"精度，纬度"`
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
