<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getList(){
        $uid = 1;
        $userInfo = app('User')::where('id','=',$uid)->all()->toArray();
//        $userFriend = app('chat_group_rel')->where('id','=',$uid)->all()->toArray();
        var_dump($userInfo);die;
    }
}
