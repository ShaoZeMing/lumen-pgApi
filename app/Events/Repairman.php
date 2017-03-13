<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class Repairman extends Model
{

    /**
     * Create a new event instance.
     *
     * @return void
     */

    protected $table = 'repairmans';

    protected $fillable = [
        'name',
        'mobile',
        'status',
        'address',
        'uid',
        'geom',
        'created_at',
        'updated_at',
    ];


//    public function findForPassport($mobile)
//    {
//        if(strlen($mobile) == 11) {
//            $user = $this->where('mobile', $mobile)->first();
//            return $user;
//        } else {
//            $user = $this->where('wechat_unionid', $mobile)->first();
//            if($user->wechat_password) {
//                $user->password = $user->wechat_password;
//            }
//            return $user;
//        }
//    }


}
