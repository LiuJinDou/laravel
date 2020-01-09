<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function info(Request $request)
    {
        $data['code'] = 0;
        $data['msg'] = 'ok';
        $id = $request->input('id') ?: auth('admin')->user()->id;
        try {
            $data['data'] = app('Admin')->getUserInfo($id);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);

//        $check = Hash::check('$10$Xo60fgMBKGTC/cUvIIdpzednWg9NucciBJ/3tulbtwToLqGbpwh1C' ,$password);
//        $check2 = Hash::check($password, '$10$Xo60fgMBKGTC/cUvIIdpzednWg9NucciBJ/3tulbtwToLqGbpwh1C');
//        $test = Hash::make($password);
//        var_dump($test);
//        $check3 = Hash::check($password,$test);
//        var_dump($check);
//        var_dump($check2);
//        var_dump($check3);
//        \DB::enableQueryLog();

//        var_dump($this->guard());
//        $queries = \DB::getQueryLog(); // 获取查询日
//        print_r($queries); // 即可查看执行的sql
//        var_dump($usernameLogin);
//        if ($usernameLogin) {
//            return true;
//        }
        // 验证手机号登录方式
//        $mobileLogin = $this->guard()->attempt(
//            ['mobile' => $username, 'password' => $password], $request->has('remember')
//        );
//        if ($mobileLogin) {
//            return true;
//        }
//var_dump($mobileLogin);
        // 验证邮箱登录方式
//        $emailLogin = $this->guard()->attempt(
//            ['email' => $username, 'password' => $password], $request->has('remember')
//        );
//        if ($emailLogin) {
//            return true;
//        }
//        var_dump($emailLogin);die;
//        return false;
    }

    public function list(Request $request){
        $limit = $request->input('limit');
        $page = $request->input('page');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {

            $rtn = app('Admin')->getAdminList($limit,$page,$request);
            $data['data'] = $rtn['data'];
            $data['count'] = $rtn['count'];
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function editor(Request $request)
    {
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Admin')->editor($request);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function updatePw(Request $request)
    {

        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Admin')->updatePassword($request);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function status(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (auth('admin')->user()->id == $id){
                throw  new \Exception('无权限、请联系超级管理员',4003);
            }
            if (!empty($id)) {
                $data['data'] = app('Admin')->where(['id'=>$id])->update(['status'=>$status]);
            }


        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function del(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (auth('admin')->user()->id == $id){
                throw  new \Exception('AND-NOT operation、Please contact your administrator',4003);
            }
            $role = app('Role')->find(app('Admin')->find(auth('admin')->user()->id)->role_id);
            if ($role->name== 'Dominates' || $role->name =='Managers') {
                app('Admin')->find($id)->delete();
            } else {
                throw  new \Exception('AND-NOT operation、Please contact your administrator',4003);
            }
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
}