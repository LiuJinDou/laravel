<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrivilegeController extends Controller
{
    /**
     * 权限列表
     * @return mixed
     */
    public function privilege()
    {
        $data = app('Privilege')->list();

        return view('admin.privilege_list',['privilege' => $data]);
    }

    /**
     * 添加分组
     * @param Request $request
     * @return mixed
     */
    public function groupSave(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('Privilege')->groupSave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * 删除分组
     * @param Request $request
     * @return mixed
     */
    public function groupDel(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (empty($id)) {
                throw  new  \Exception('确实参数',1001);
            }
            //视图间共享数据
            $data['data'] = app('Privilege_group')->destroy($id);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * 添加权限
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('Privilege')->privilegeSave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * 删除权限
     * @param Request $request
     * @return mixed
     */
    public function del(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (empty($id)) {
                throw  new  \Exception('确实参数',1001);
            }
            //视图间共享数据
            $data['data'] = app('Privilege')->destroy($id);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * 角色列表
     * @return mixed
     */
    public function roleList(Request $request){
        $limit = $request->input('limit');
        $page = $request->input('page');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('Role')->list($limit,$page,$request);
            $data['count'] = $rtn['count'];
            $data['data'] = $rtn['data'];

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * 获取角色列表
     * @return mixed
     */
    public function getRoleList(){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('Role')->getList();
            $data['data'] = $rtn;

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    /**
     * 添加角色
     * @param Request $request
     * @return mixed
     */
    public function roleSave(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('Role')->roleSave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * 删除角色
     * @param Request $request
     * @return mixed
     */
    public function roleDel(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (empty($id)) {
                throw  new  \Exception('确实参数',1001);
            }
            //视图间共享数据
            $data['data'] = app('Role')->del($id);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * 权限列表
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function rolePrivilege(Request $request){

        if ($request->isMethod('post')) {
            $data['code'] = 0;
            $data['msg'] = 'ok';
            try{
                $data['data'] = app('Role')->savePrivilege($request);
            }catch (\Exception $exception){
                $data['code'] = $exception->getCode();
                $data['msg'] = $exception->getMessage();
            }
            return $data;
        } else {
            $id = $request->input('id');
            if (empty($id)) {
                throw  new  \Exception('缺少参数',1001);
            }
            $data = app('Role')->rolePrivilege($id);
            return view('admin.role_privilege',['privilege' => $data]);
        }
    }
    /**
     * 成员列表
     * @return mixed
     */
    public function memberList(Request $request){
        $limit = $request->input('limit');
        $page = $request->input('page');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('Admin')->list($limit,$page,$request);
            $data['count'] = $rtn['count'];
            $data['data'] = $rtn['data'];

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

}
