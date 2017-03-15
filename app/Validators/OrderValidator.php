<?php

namespace App\Validators;


class OrderValidator extends Validator
{

    //验证规则
    protected $rules = [
        Validator::RULE_CREATE => [
            'order_num'  => 'required|unique:orders,order_num',
            'firm_id'  =>'required',
            'firm_name'=>'required',
//            'user_id'=>'required',
            'user_name'=>'required',
            'user_mobile'=>'required',
            'firm_mobile'=>'required',
            'address'=>'required',
            'geom'=>'required',
        ],
        Validator::RULE_UPDATE => [
            'order_num'  => 'required',
        ],
    ];

    protected $errors = [
        'order_num.required' => '未输入工单编号',
        'order_num.unique' => '工单编号已存在',
        'firm_id.required' => '未获得商家ID！',
        'firm_name.required' => '未获得商家名称！',
//        'user_id.required' => '未获得联系人id！',
        'user_name.required' => '未获得联系人姓名！',
        'user_mobile.required' => '未获得联系人联系电话！',
        'firm_mobile.required' => '未获得商家联系电话！',
        'address.required' => '未获得联系地址！',
        'geom.required' => '未获得联系地址经纬度！',

    ];


}
