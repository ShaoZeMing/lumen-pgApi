<?php

namespace App\Http\Controllers\LbsApi;

use App\Http\Controllers\Controller;
use App\Repositories\OrderApiRepository;
use App\Validators\OrderValidator;
use App\Validators\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OrderApiController extends Controller
{
    public $request;
    public $apiRepository;
    public $validator;


    public function __construct(Request $request, OrderValidator $validator, OrderApiRepository $apiRepository)
    {
        $this->request = $request;
        $this->apiRepository = $apiRepository;
        $this->validator = $validator;
    }


    /**
     * @api {get} /lbs/search-order 工单搜索(json)
     * @apiName shaozeming@xiaobaiyoupin.com
     * @apiDescription 针对师傅位置对指定范围的可接工单进行搜索
     * @apiGroup Order-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String}  lbs_token  秘钥
     * @apiParam {Decimal} user_lng 经度
     * @apiParam {Decimal} user_lat 纬度
     * @apiParam {Int} [dist]  搜索范围(米)，默认30000
     * @apiParam {Int} [limit]  返回最多条数
     * @apiParam {Int} [state]  订单状态(0:待接单，1:已接单)默认为0
     * @apiSuccess {BigInt}  order_no  工单编号
     * @apiSuccess {String} dist 距离(米)
     * @apiSuccess {String}  order_desc  工单描述
     * @apiSuccess {String}  full_address  联系人地址
     * @apiSuccess {int}  user_id  用户id
     * @apiSuccess {String}  user_name  联系人姓名
     * @apiSuccess {String}  user_mobile  联系人电话
     * @apiSuccess {int}  merchant_id  厂商id
     * @apiSuccess {String}  merchant_name  厂商名称
     * @apiSuccess {String}  merchant_telphone  厂商联系方式
     * @apiSuccess {float}  user_lat  纬度
     * @apiSuccess {float}  user_lng  经度
     * @apiSuccess {string}  geom  位置几何
     * @apiSuccess {String}  published_at  发布工单时间
     * @apiSuccess {String}  big_cat  大类
     * @apiSuccess {String}  middle_cat  中类
     * @apiSuccess {String}  small_cat  小类
     * @apiSuccess {int}  order_type  0保内/1保外
     * @apiSuccess {int}  biz_type  0安装/1维修
     * @apiSuccess {String}  small_cat  小类
     * @apiSuccess {String}  updated_at  修改时间
     * @apiSuccessExample {json} 成功响应例子:
     * {
     * "error": 0,
     * "msg": "成功",
     * "data": {
     * "size": 2,
     * "list": [
     * {
     * "id": "3",
     * "order_no": "1229282922",
     * "order_desc": "不开机的喂不了",
     * "state": 0,
     * "order_type": 0,
     * "biz_type": 0,
     * "merchant_id": "4",
     * "merchant_name": "小米",
     * "merchant_tel": "13330333876",
     * "user_id": "232",
     * "user_name": "小姐",
     * "user_mobile": "18888888888",
     * "user_lat": "39.33",
     * "user_lng": "119.84",
     * "full_address": "清华大学一栋28号",
     * "geom": "0101000020E61000005D50DF32A7F55D40F46C567DAEAA4340",
     * "published_at": "2017-03-19 00:00:00",
     * "big_cat": "",
     * "middle_cat": "",
     * "small_cat": "",
     * @apiParam {int}  biz_type  0安装/1维修
     * @apiParam {String}  small_cat  小类
     * "created_at": "2017-03-20 18:36:31",
     * "updated_at": "2017-03-20 18:36:31",
     * "dist": "2223.90159469"
     * },
     * {
     * "id": "4",
     * "order_no": "1229282922",
     * "order_desc": "不开机的",
     * "state": 0,
     * "order_type": 0,
     * "biz_type": 0,
     * "merchant_id": "4",
     * "merchant_name": "小米",
     * "merchant_tel": "13330333876",
     * "user_id": "232",
     * "user_name": "少爷",
     * "user_mobile": "18888888888",
     * "user_lat": "39.33",
     * "user_lng": "119.84",
     * "full_address": "清华大学一栋28号",
     * "geom": "0101000020E61000005D50DF32A7F55D40F46C567DAEAA4340",
     * "published_at": "2017-03-20 23:34:33",
     * "big_cat": "",
     * "middle_cat": "",
     * "small_cat": "",
     * "created_at": "2017-03-20 18:38:13",
     * "updated_at": "2017-03-20 18:38:13",
     * "dist": "2223.90159469"
     * }
     * ]
     * }
     * }
     * @apiErrorExample {json} 失败例子:
     * {
     * "error": 1,
     * "msg": "",
     * "data": []
     * }
     */
    public function search()
    {

        $options = $this->request->all();
        Log::info('c=OrderApiController f=search  options=' . json_encode($options));
        $user_lng = isset($options['user_lng']) ? $options['user_lng'] : 0;
        $user_lat = isset($options['user_lat']) ? $options['user_lat'] : 0;
        $dist = isset($options['dist']) && !empty($options['dist']) ? (int)$options['dist'] : env('DISTANCE', 30000);
        $limit = isset($options['limit']) && !empty($options['limit']) ? (int)$options['limit'] : env('LIMIT', 1000);
        $status = isset($options['state']) ? $options['state'] : 0;
        if (!$user_lng || !$user_lat) {
            Log::info('c=OrderApiController f=search  msg= 位置数据未输入');
            return $this->response_json(1, "经纬度数据未输入", [], 422);
        }
        $geom = $user_lng . ' ' . $user_lat;
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
     * @api {post} /lbs/insert-order 添加工单
     * @apiDescription 添加工单(create post)
     * @apiGroup Order-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String}  lbs_token  认证秘钥
     * @apiParam {BigInt}  order_no  工单编号
     * @apiParam {String}  order_desc  工单描述
     * @apiParam {String}  full_address  联系人地址
     * @apiParam {int}  user_id  用户id
     * @apiParam {String}  user_name  联系人姓名
     * @apiParam {String}  user_mobile  联系人电话
     * @apiParam {int}  merchant_id  厂商id
     * @apiParam {String}  merchant_name  厂商名称
     * @apiParam {String}  merchant_telphone  厂商联系方式
     * @apiParam {float}  user_lat  纬度
     * @apiParam {float}  user_lng  经度
     * @apiParam {String}  published_at  发布工单时间
     * @apiParam {String}  [big_cat]  大类
     * @apiParam {String}  [middle_cat]  中类
     * @apiParam {String}  [small_cat]  小类
     * @apiParam {int}  [order_type]  0保内/1保外
     * @apiParam {int}  [biz_type]  0安装/1维修
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * {
     * "error": 0,
     * "msg": "添加成功",
     * "data": []
     * }
     *
     * @apiErrorExample {json} 错误例子:
     * {
     * "error": 1,
     * "msg": "验证错误：未获得详细联系地址！(full_address),",
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
            Log::info('c=OrderApiController f=insert  msg=' . $this->response_msg($e->getResponse()));
            return $this->response_msg($e->getResponse());
        }

        $data = $this->request->all();
        Log::info('c=OrderApiController f=insert  options=' . json_encode($data));

        $result = $this->apiRepository->insertData($data);
        if ($result !== false) {
            return $this->response_json(0, "添加成功", []);
        } else {
            return $this->response_json(1, "添加失败", [], 422);
        }
    }

    /**
     * @api {post} /lbs/save-order 修改工单
     * @apiDescription 修改工单信息
     * @apiGroup Order-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String}  lbs_token  认证秘钥
     * @apiParam {Bigint}  order_id  工单编号
     * @apiParam {Int}  state  工单状态(0:未接单，1:已接单，2:已完成，3:已取消)
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} 响应例子:
     * {
     * "error": 0,
     * "msg": "修改成功",
     * "data": []
     * }
     * @apiErrorExample {json} 错误例子:
     * {
     * "error": 1,
     * "msg": "验证错误：未输入工单编号(order_id),",
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
            Log::info('c=OrderApiController f=save  msg=' . $this->response_msg($e->getResponse()));
            return $this->response_msg($e->getResponse());
        }
        $options = $this->request->all();
        Log::info('c=OrderApiController f=save  options=' . json_encode($options));
        $order_num = isset($options['order_no']) ? $options['order_no'] : 0;

        $result = $this->apiRepository->saveData($options, $order_num);

        if ($result !== false) {
            return $this->response_json(0, "修改成功", []);
        } else {
            return $this->response_json(1, "修改失败", [], 422);
        }
    }

}
