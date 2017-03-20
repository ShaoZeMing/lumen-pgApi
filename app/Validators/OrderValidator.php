<?php

namespace App\Validators;


class OrderValidator extends Validator
{

    //验证规则
    protected $rules = [
        Validator::RULE_CREATE => [
            'order_no' => 'required',
            'merchant_id' => 'required',
            'merchant_name' => 'required',
            'merchant_tel' => 'required',
            'user_id' => 'required',
            'user_name' => 'required',
            'user_mobile' => 'required',
            'full_address' => 'required',
            'user_lng' => 'required',
            'user_lat' => 'required',
            'published_at' => 'required',
        ],
        Validator::RULE_UPDATE => [
            'order_no' => 'required',
        ],
    ];

    protected $errors = [
        'order_no.required' => '未输入工单编号',
        'merchant_id.required' => '未获得商家ID！',
        'merchant_name.required' => '未获得商家名称！',
        'user_id.required' => '未获得联系人id！',
        'user_name.required' => '未获得联系人姓名！',
        'user_mobile.required' => '未获得联系人联系电话！',
        'merchant_tel.required' => '未获得商家联系电话！',
        'full_address.required' => '未获得详细联系地址！',
        'user_lng.required' => '未获得师傅联系地址经度！',
        'user_lat.required' => '未获得师傅联系地址纬度！',
        'published_at.required' => '未获取发布工单时间！',
    ];


}
