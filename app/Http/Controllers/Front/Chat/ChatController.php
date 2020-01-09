<?php

namespace App\Http\Controllers\Front\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    //
    public function getList(Request $request){

        app('User')->getList();

        $data['code'] = 0;
        $data['msg'] = 'ok';
        $data['data'] = [
            'mine' => [
                'username' => '测试',
                'id' => '100000',
                'status' => 'online',
                'sign' => '在深邃的编码世界，做一枚轻盈的纸飞机',
                'avatar' => '//res.layui.com/images/fly/avatar/00.jpg',
            ],
            'friend' => [
                [
                'groupname' => '知名人物',
                'id' => '0',
                'list' =>[
                    [
                        'username' => '测试1',
                        'id' => '100001',
                        'status' => 'online',
                        'sign' => '在深邃的编码世界，做一枚轻盈的纸飞机',
                        'avatar' => '//res.layui.com/images/fly/avatar/00.jpg',
                    ],
                    [
                        'username' => '测试2',
                        'id' => '100002',
                        'status' => 'online',
                        'sign' => '在深邃的编码世界，做一枚轻盈的纸飞机',
                        'avatar' => '//res.layui.com/images/fly/avatar/00.jpg',
                    ],
                ]
            ]

            ]
        ];
        return json_encode($data);
    }
}
