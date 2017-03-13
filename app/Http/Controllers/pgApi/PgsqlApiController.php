<?php

namespace App\Http\Controllers\pgApi;

use App\Events\Repairman;
use App\Http\Controllers\Controller;
use App\Repositories\RepairmanApiRepository;
use GeoJson\Geometry\GeometryCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Phaza\LaravelPostgis\Geometries\Point;

class PgsqlApiController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        //
//    }

    public $request;
    public $apiRepository;


//    protected $_orderStatus    = [0, 1];
//    protected $_collectionType = [0, 1];

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
    public function searchGeom(Request $request)
    {


        $geom=new Point(37.422009, -122.084047);


        dd($geom);

        $location1 = new Repairman();
        $location1->name = '小明';
        $location1->address = '北京市海淀区银谷大厦';
        $location1->geom = '';
        $location1->save();


//        dd($gis);

        //1.距离范围，2.地理位置
        $options = $request->all();
        Log::info('c=PgsqlApiController f=searchGeom  options='.json_encode($options));
        $geom = isset($options['geom']) ? $options['geom'] : '';
        $status = isset($options['status']) ? $options['status'] : 0;
        $dist   = isset($options['dist']) ? (int)$options['dist'] : env('DISTANCE',10000);
        $limit   = isset($options['limit'])  ? (int)$options['limit'] : env('LIMIT',10);

        if(empty($geom)) {
            Log::info('c=PgsqlApiController f=searchGeom  msg= '.config('message.5401'));
            return [
                'error' => 1,
                'msg' =>config('message.5401'),
                'data' => '',
            ];
        }
        $where['status'] = $status;
        $lists  = $this->apiRepository->getSqlData();

        dd($lists);

        $output = [
            'page' => $limit,
            'list' => $lists
        ];
        return $this->output_response(0, $output, config('messages.0'));
    }
    /**
     * 课程详细信息
     *
     * @author zhangjun@xiaobaiyoupin.com
     *
     * @param  Request $request
     *
     * @return mixed
     */
    public function detail(Request $request)
    {
        try{
            $options = $request->all();
            Log::info('c=lesson f=list  options='.json_encode($options));
            if(!isset($options['lesson_id']) || !(int)$options['lesson_id']) {
                return $this->output_response(1073, [], config('messages.1073'));
            }
            $lessonId = (int)$options['lesson_id'];
            $devId    = isset($options['dev_id']) ? $options['dev_id'] : '';
            $userId   = $this->getUserId();
            $result   = $this->lessonApiRepository->getLessonById($lessonId, $devId, $userId);
            if(!$result) {
                Log::info('c=video f=detail msg=课程不存在 lessonId='.$options['lesson_id']);
                return $this->output_response(1073, [], config('messages.1073'));
            }
            if(($result->status != 1) && ($result->is_buy == 0)) {
                Log::info('c=video f=detail msg=课程下线 lessonId='.$options['lesson_id']);
                return $this->output_response(1076, [], config('messages.1076'));
            }
            return $this->output_response(0, $result, config('messages.0'));
        }catch(\Exception $ex) {
            Log::info('c=lesson f=checkFavourite msg='.$ex->getMessage());
            return $this->output_response(1073, [], config('messages.1073'));
        }
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
