<?php

namespace App\Http\Controllers\pgApi;

use App\Events\Repairman;
use App\Http\Controllers\Controller;
use App\Repositories\RepairmanApiRepository;
use GeoJson\Geometry\GeometryCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Phaza\LaravelPostgis\Geometries\Point;

class RepairmanApiController extends Controller
{
    public $request;
    public $apiRepository;

    public function __construct(Request $request,RepairmanApiRepository $apiRepository)
    {
        $this->request   = $request;
        $this->apiRepository   = $apiRepository;

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
        Log::info('c=RepairmanApiController f=search  options='.json_encode($options));
        $geom = isset($options['geom']) ? $options['geom'] : '';
        $dist   = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE',30000);
        $limit   = isset($options['limit'])  ? (int)$options['limit'] : env('LIMIT',1000);
        $status = isset($options['status']) ? $options['status'] : 0;
        if(empty($geom)) {
            Log::info('c=RepairmanApiController f=search  msg= 未获得位置数据');
            return $this->response_json(1,"未获得位置数据",[],403);
        }
        $lists  = $this->apiRepository->selectData($geom,$dist,$status,$limit);
        if($lists){
            return $this->response_json(0,"成功",$lists);
        }else{
            return $this->response_json(1,"失败",[],403);
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
        //1.距离范围，2.地理位置
        $data = $this->request->all();
        Log::info('c=RepairmanApiController f=insert  options='.json_encode($data));

        $result = $this->apiRepository->insertData($data);
        if($result){
            return $this->response_json(0,"添加成功",[]);
        }else{
            return $this->response_json(1,"添加失败",[],403);
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
        $options = $this->request->all();
        Log::info('c=RepairmanApiController f=save  options='.json_encode($options));
        $uid = isset($options['uid']) ? (int)$options['id'] :0;
        $data  = isset($options['options']) ? $options['options'] :[];
        if(empty($uid)) {
            Log::info('c=PgsqlApiController f=save  msg= 未获得师傅关联uid');
            return $this->response_json(1,"未获得师傅关联uid",[],403);

        }else if(empty($data)){
            Log::info('c=PgsqlApiController f=save  msg= 未获得需修改的参数');
            return $this->response_json(1,"未获得需修改的参数",[],403);
        }

        $result = $this->apiRepository->saveData($data,192063);

        if($result){
            return $this->response_json(0,"修改成功",$result);
        }else{
            return $this->response_json(1,"修改失败",[],403);
        }
    }


    public function response_json($code,$msg,$data,$http_num=200){

        return response()->json([
            'error' => $code,
            'msg' =>$msg,
            'data' => $data,
        ],$http_num);
    }

}
