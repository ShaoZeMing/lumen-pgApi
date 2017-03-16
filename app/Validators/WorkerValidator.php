<?php

namespace App\Validators;


class WorkerValidator extends Validator
{

    //验证规则
    protected $rules = [
        Validator::RULE_CREATE => [
            'uid' => 'required|unique:workers,uid',
            'name' => 'required',
            'mobile' => 'required',
            'full_address' => 'required',
            'geom' => 'required',
        ],
        Validator::RULE_UPDATE => [
            'uid' => 'required',
        ],
    ];

    protected $errors = [
        'uid.required' => '未输入师傅关联id',
        'uid.unique' => '该uid关联师傅已存在',
        'name.required' => '师傅名称参数无！',
        'mobile.required' => '师傅联系电话参数必需！',
        'full_address.required' => '未获得师傅联系地址！',
        'geom.required' => '未获得师傅联系地址经纬度！',

    ];


}
