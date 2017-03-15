<?php

namespace App\Validators;


class Validator
{

    const RULE_CREATE = 'create';
    const RULE_UPDATE = 'update';

    //验证规则
    protected $rules = [];

    protected $errors = [];


    /**
     * 返回验证字段
     * @param string $type 属性
     * @return array
     */


    public function  getRules($type){

        return $this->rules[$type];
    }



    /**
     * 返回错误.
     *
     * @return array
     */


    public function  getMassage(){

        return $this->errors;
    }




}
