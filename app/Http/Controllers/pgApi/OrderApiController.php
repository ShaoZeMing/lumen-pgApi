<?php

namespace App\Http\Controllers\pgApi;

use App\Events\Repairman;
use App\Http\Controllers\Controller;
use App\Repositories\RepairmanApiRepository;
use GeoJson\Geometry\GeometryCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Phaza\LaravelPostgis\Geometries\Point;

class OrderApiController extends Controller
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

        //1.距离范围，2.地理位置
        $options = $this->request->all();
        Log::info('c=PgsqlApiController f=searchGeom  options='.json_encode($options));
        $geom = isset($options['geom']) ? $options['geom'] : '';
        $dist   = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE',10000);
        $limit   = isset($options['limit'])  ? (int)$options['limit'] : env('LIMIT',10);
        $status = isset($options['status']) ? $options['status'] : 0;
        if(empty($geom)) {
            Log::info('c=PgsqlApiController f=searchGeom  msg= '.config('message.5401'));
            return [
                'error' => 1,
                'msg' =>'位置数据未传入',
                'data' => '',
            ];
        }
        $lists  = $this->apiRepository->selectData($geom,$dist,$status,$limit);

//        dd($lists);

        $output = [
            'error' => 0,
            'msg' =>'成功',
            'page' => count($lists),
            'data' => $lists
        ];
        return response()->json($output);
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
        $options = $this->request->all();
        Log::info('c=PgsqlApiController f=searchGeom  options='.json_encode($options));
        $geom = isset($options['geom']) ? $options['geom'] : '';
        $dist   = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE',10000);
        $limit   = isset($options['limit'])  ? (int)$options['limit'] : env('LIMIT',10);
        $status = isset($options['status']) ? $options['status'] : 0;
        if(empty($geom)) {
            Log::info('c=PgsqlApiController f=searchGeom  msg= '.config('message.5401'));
            return [
                'error' => 1,
                'msg' =>'位置数据未传入',
                'data' => '',
            ];
        }
        $lists  = $this->apiRepository->selectData($geom,$dist,$status,$limit);

//        dd($lists);

        $output = [
            'error' => 0,
            'msg' =>'成功',
            'page' => count($lists),
            'data' => $lists
        ];
        return response()->json($output);
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

//        //1.距离范围，2.地理位置
//        $options = $this->request->all();
//        Log::info('c=PgsqlApiController f=searchGeom  options='.json_encode($options));
//        $geom = isset($options['geom']) ? $options['geom'] : '';
//        $dist   = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE',10000);
//        $limit   = isset($options['limit'])  ? (int)$options['limit'] : env('LIMIT',10);
//        $status = isset($options['status']) ? $options['status'] : 0;
//        if(empty($geom)) {
//            Log::info('c=PgsqlApiController f=searchGeom  msg= '.config('message.5401'));
//            return [
//                'error' => 1,
//                'msg' =>'位置数据未传入',
//                'data' => '',
//            ];
//        }

        $lists  = $this->apiRepository->saveData([],192065);

//        dd($lists);

        $output = [
            'error' => 0,
            'msg' =>'成功',
            'page' => count($lists),
            'data' => $lists
        ];
        return response()->json($output);
    }





    /**
     * 课程说明
     *
     * @author zhangjun@xiaobaiyoupin.com
     *
     * @param  Request $request
     *
     * @return mixed
     */
    public function desc(Request $request)
    {
        $options = $request->all();
        Log::info('c=lesson f=list  options='.json_encode($options));
        if(!isset($options['lesson_id']) || !(int)$options['lesson_id']) {
            return $this->output_response(1073, [], config('messages.1073'));
        }
        $result = $this->lessonApiRepository->getLessonDescById($options['lesson_id']);
        if(!$result) {
            Log::info('c=video f=detail msg=课程说明不存在 lessonId='.$options['lesson_id']);
            return $this->output_response(1077, [], config('messages.1077'));
        }
        return $this->output_response(0, $result, config('messages.0'));
    }






}
