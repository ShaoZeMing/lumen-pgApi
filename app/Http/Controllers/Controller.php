<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //


    /**
     * 返回数据格式
     *
     * @author shaozeming@xiaobaiyoupin.com
     *
     * @param  int $code     0，成功，1错误
     * @param  string $msg   信息
     * @param  array $data   数据
     * @param  int $http_num 状态码
     *
     * @return mixed
     */
    public function response_json($code, $msg, $data, $http_num = 200)
    {

        return response()->json([
            'error' => $code,
            'msg' => $msg,
            'data' => $data,
        ], $http_num);
    }


    /**
     * 返回验证错误数据格式
     *
     * @author shaozeming@xiaobaiyoupin.com
     *
     * @param  object $getResponse
     *
     * @return mixed
     */
    public function response_msg($getResponse)
    {
        $msgArr=json_decode($getResponse->getContent());
        $msg='验证错误：';
        foreach($msgArr as $k=> $v){
            $msg .= $v[0]."($k)," ;
        }
        return response()->json([
            'error' => 1,
            'msg' => $msg,
            'data' => [],
        ], 422);
    }


}
