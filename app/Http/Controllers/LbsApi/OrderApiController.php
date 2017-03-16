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
     * @api {get} /lbs/search-order 工单搜索
     * @apiName shaozeming@xiaobaiyoupin.com
     * @apiDescription 针对师傅位置对指定范围的可接工单进行搜索
     * @apiGroup Order-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String='(-180.00000,-90.000000) ~ (180.00000,90.000000) '} geom  位置坐标，格式 `"精度，纬度"`
     * @apiParam {Int} [dist]  搜索范围(米)，默认30000
     * @apiParam {Int} [limit]  返回条数
     * @apiParam {Int} [order_status]  订单状态(0:待接单，1:已接单，2:已完成，4:已取消)默认为0
     * @apiSuccess {BigInt}  order_id  工单ID编号
     * @apiSuccess {String} dist 距离(米)
     * @apiSuccess {String}  full_address  联系人地址
     * @apiSuccess {String}  user_name  联系人姓名
     * @apiSuccess {String}  user_mobile  联系人电话
     * @apiSuccess {String}  merchant_name  厂商名称
     * @apiSuccess {String}  merchant_telphone  厂商联系方式
     * @apiSuccess {String}  description  工单描述
     * @apiSuccess {BigInt}  category_id  分类id
     * @apiSuccess {String}  category_name  分类名称
     * @apiSuccess {String}  created_at  创建时间
     * @apiSuccess {String}  updated_at  修改时间
     * @apiSuccessExample {json} 成功响应例子:
     * {
     * "error": 0,
     * "msg": "成功",
     * "data": {
     * "size": 3,
     * "list": [
     * {
     * "id": "1",
     * "order_id": "12315",
     * "description": "电视坏了，快来修",
     * "state": 0,
     * "merchant_name": "小米科技",
     * "merchant_telphone": "0103456789",
     * "category_id": "4",
     * "category_name": "家电",
     * "user_name": "流沙",
     * "user_mobile": "15196566135",
     * "full_address": "五道口家园",
     * "geom": "0101000020E61000007B319413ED8E5E4059C0046EDD9D4640",
     * "created_at": "2017-03-16 18:17:17",
     * "updated_at": "2017-03-16 18:17:17",
     * "dist": "0"
     * },
     * {
     * "id": "2",
     * "order_id": "123152",
     * "description": "电视坏了，快来修",
     * "state": 0,
     * "merchant_name": "小米科技",
     * "merchant_telphone": "0103456789",
     * "category_id": "4",
     * "category_name": "家电",
     * "user_name": "明月",
     * "user_mobile": "15196986655",
     * "full_address": "峨眉清风塔",
     * "geom": "0101000020E6100000895E46B1DC8E5E403A3B191C259F4640",
     * "created_at": "2017-03-16 18:18:03",
     * "updated_at": "2017-03-16 18:18:03",
     * "dist": "1114.70414013"
     * },
     * {
     * "id": "3",
     * "order_id": "1231524",
     * "description": "冰箱坏坏了，快来修",
     * "state": 0,
     * "merchant_name": "小米科技",
     * "merchant_telphone": "0103456789",
     * "category_id": "4",
     * "category_name": "家电",
     * "user_name": "明月",
     * "user_mobile": "15194586135",
     * "full_address": "蜀山",
     * "geom": "0101000020E61000009EEA909BE18E5E406553AEF02E9F4640",
     * "created_at": "2017-03-16 18:18:40",
     * "updated_at": "2017-03-16 18:18:40",
     * "dist": "1146.6200287"
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
        $geom = isset($options['geom']) ? $options['geom'] : '';
        $dist = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE', 30000);
        $limit = isset($options['limit']) ? (int)$options['limit'] : env('LIMIT', 1000);
        $status = isset($options['state']) ? $options['state'] : 0;
        if (empty($geom)) {
            Log::info('c=OrderApiController f=search  msg= 位置数据未知');
            return $this->response_json(1, "位置数据未知", [], 422);
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
     * @api {post} /lbs/insert-order 添加工单
     * @apiDescription 添加工单(create post)
     * @apiGroup Order-LBS
     * @apiPermission LBS_TOKEN
     * @apiParam {String='(-180.00000,-90.000000) ~ (180.00000,90.000000) '} geom 位置坐标，格式 `"精度，纬度"`
     * @apiParam {BigInt}  order_id  工单ID编号
     * @apiParam {String}  full_address  联系人地址
     * @apiParam {String}  user_name  联系人姓名
     * @apiParam {String}  user_mobile  联系人电话
     * @apiParam {String}  merchant_name  厂商名称
     * @apiParam {String}  merchant_telphone  厂商联系方式
     * @apiParam {String}  [description]  工单描述
     * @apiParam {BigInt}  [category_id]  分类id
     * @apiParam {String}  [category_name]  分类名称
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
     * "msg": "验证错误：工单编号已存在(order_id),",
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

        //1.距离范围，2.地理位置
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
     * @apiPermission none
     * @apiParam {String}  order_id  工单编号
     * @apiParam {Int}  [state]  工单状态(0:未接单，1:已接单，2:已完成，3:已取消)
     * @apiParam {String}  [full_address]  联系人地址
     * @apiParam {String}  [user_name]  联系人姓名
     * @apiParam {String}  [user_mobile]  联系人电话
     * @apiParam {String}  [merchant_name]  厂商名称
     * @apiParam {String}  [merchant_telphone]  厂商联系方式
     * @apiParam {String}  [description]  工单描述
     * @apiParam {BigInt}  [category_id]  分类id
     * @apiParam {String}  [category_name]  分类名称
     * @apiParam {String='(-180.00000,-90.000000) ~ (180.00000,90.000000) '} [geom]  位置坐标，格式 `"精度，纬度"`
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
        $order_num = isset($options['order_num']) ? $options['order_num'] : 0;

        $result = $this->apiRepository->saveData($options, $order_num);

        if ($result !== false) {
            return $this->response_json(0, "修改成功", []);
        } else {
            return $this->response_json(1, "修改失败", [], 422);
        }
    }

}
