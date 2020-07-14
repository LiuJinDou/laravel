<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller{
    public function test(){
        $arr = [
            'name'=>'test',
            'age' => 23
        ];
        ksort($arr);
        echo http_build_query($arr);echo '<br>';
        $array = ['a','b','c'];
        echo http_build_query($array,'blog');
        echo '<br>';
        echo http_build_query($arr,'','blog');die;
        $res = httpRequest('www.mengshadow.top/client','','get');
        var_dump($res);
        var_dump(function_exists('httpRequest'));

    }

    public function client(){
        return 23423442341;
        $client = new \GearmanClient();
        $client->addServer();
        print $client->doNormal ("reverse", "Hello World!");
    }
}
