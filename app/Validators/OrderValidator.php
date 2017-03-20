<?php

namespace App\Validators;


class OrderValidator extends Validator
{

    //验证规则
    protected $rules = [
        Validator::RULE_CREATE => [
            'order_id' => 'required|unique:orders,order_id',
            'merchant_name' => 'required',
            'merchant_telphone' => 'required',
            'user_name' => 'required',
            'user_mobile' => 'required',
            'full_address' => 'required',
            'user_lng' => 'required',
            'user_lat' => 'required',
        ],
        Validator::RULE_UPDATE => [
            'order_id' => 'required',
        ],
    ];

    protected $errors = [
        'order_id.required' => '未输入工单编号',
        'order_id.unique' => '工单编号已存在',
        'merchant_name.required' => '未获得商家名称！',
        'user_name.required' => '未获得联系人姓名！',
        'user_mobile.required' => '未获得联系人联系电话！',
        'merchant_telphone.required' => '未获得商家联系电话！',
        'full_address.required' => '未获得详细联系地址！',
        'user_lng.required' => '未获得师傅联系地址经度！',
        'user_lat.required' => '未获得师傅联系地址纬度！',
    ];


}
