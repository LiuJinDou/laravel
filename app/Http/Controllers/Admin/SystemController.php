<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redis;

class SystemController extends Controller
{
    public function dictionary(Request $request)
    {
        $tables = DB::select('SELECT table_name ,table_comment FROM information_schema.TABLES WHERE table_schema = "blog" ORDER BY table_name');
        foreach ($tables as $key =>&$item) {
            $sql = "SELECT * FROM information_schema.columns where TABLE_SCHEMA = 'blog' AND TABLE_NAME ='{$item['table_name']}'";
            $item['tables'] = DB::select($sql);
        }
        return view('/admin/dictionary',['data' => $tables]);
    }

    /**
     * list
     * @param Request $request
     * @return mixed
     */
    public function rules(Request $request){

        $rules = app('develop_rule')->list();

        return view('/admin/rules',['data' => $rules]);

    }
    /**
     * add rules
     * @param Request $request
     * @return mixed
     */
    public function rulesSave(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('System')->rulesSave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * list
     * @param Request $request
     * @return mixed
     */
    public function updates(Request $request){

        $rules = app('update_log')->list();

        return view('/admin/updates',['data' => $rules]);
    }
    /**
     * add log
     * @param Request $request
     * @return mixed
     */
    public function updatesSave(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('System')->updatesSave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * data statistics
     */
    public function statistics(){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('System')->statistics();
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;
    }
}
