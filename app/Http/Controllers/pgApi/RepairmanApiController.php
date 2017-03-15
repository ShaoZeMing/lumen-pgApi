<?php

namespace App\Http\Controllers\pgApi;

use App\Http\Controllers\Controller;
use App\Repositories\RepairmanApiRepository;
use App\Validators\RepairmanValidator;
use App\Validators\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RepairmanApiController extends Controller
{
    public $request;
    public $apiRepository;
    public $validator;

    public function __construct(Request $request,RepairmanValidator $validator, RepairmanApiRepository $apiRepository)
    {
        $this->request = $request;
        $this->apiRepository = $apiRepository;
        $this->validator = $validator;
    }

    /**
     * 查询地理地址
     *
     * @author shaozeming@xiaobaiyoupin.com
     *
     * @param  Request $request
     *
     * @return mixed
     */
    public function search()
    {

        $options = $this->request->all();
        Log::info('c=RepairmanApiController f=search  options=' . json_encode($options));
        $geom = isset($options['geom']) ? $options['geom'] : '';
        $dist = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE', 30000);
        $limit = isset($options['limit']) ? (int)$options['limit'] : env('LIMIT', 1000);
        $status = isset($options['status']) ? $options['status'] : 0;
        if (empty($geom)) {
            Log::info('c=RepairmanApiController f=search  msg= 位置数据未输入');
            return $this->response_json(1, "位置数据未输入", [],422 );
        }
        $lists = $this->apiRepository->selectData($geom, $dist, $status, $limit);
        if ($lists !== false) {
            return $this->response_json(0, "成功", $lists);
        } else {
            return $this->response_json(1, "失败", [], 422);
        }

    }

    /**
     * 查询地理地址
     *
     * @author shaozeming@xiaobaiyoupin.com
     *
     * @param  Request $request
     *
     * @return mixed
     */
    public function insert()
    {

        try{
            $this->validate(
                $this->request,
                $this->validator->getRules(Validator::RULE_CREATE),
                $this->validator->getMassage());
        }catch (ValidationException $e){
            Log::info('c=RepairmanApiController f=insert  msg=' . $this->response_msg($e->getResponse()));
            return $this->response_msg($e->getResponse());
        }

        $data = $this->request->all();
        Log::info('c=RepairmanApiController f=insert  msg=' . json_encode($data));

        $result = $this->apiRepository->insertData($data);
        if ($result !== false) {
            return $this->response_json(0, "添加成功", []);
        } else {
            return $this->response_json(1, "添加失败", [], 422);
        }
    }


    /**
     * 修改师傅地址信息
     *
     * @author shaozeming@xiaobaiyoupin.com
     *
     * @param  Request $request
     *
     * @return mixed
     */
    public function save()
    {

        try{
            $this->validate(
                $this->request,
                $this->validator->getRules(Validator::RULE_UPDATE),
                $this->validator->getMassage());

        }catch (ValidationException $e){
            Log::info('c=RepairmanApiController f=save  msg=' .$this->response_msg($e->getResponse()));
            return $this->response_msg($e->getResponse());
        }

        $options = $this->request->all();
        Log::info('c=RepairmanApiController f=save  msg=' . json_encode($options));
        $uid = isset($options['uid']) ? (int)$options['uid'] : 0;

        $result = $this->apiRepository->saveData($options, $uid);

        if ($result !== false) {
            return $this->response_json(0, "修改成功", $result);
        } else {
            return $this->response_json(1, "修改失败", [], 422);
        }
    }


}
