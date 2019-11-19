<?php
namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model {

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    public function list(){
//        $role_id = auth('admin')->user()->role_id;
//        $privilege_id = DB::table('role_privilege')
//            ->where('role_id','=',$role_id)
//            ->get()->toArray();
//        $privilege_id = array_column($privilege_id,NULL,'privilege_id');
        $privileges = DB::table('privileges')
//            ->whereIn('id', array_keys($privilege_id))
            ->get()->toArray();

        $privilege_group = DB::table('privilege_group')->get()->toArray();
        $privilege_group = array_column($privilege_group, NULL, 'id');
        $current_privilege = [];
        foreach ($privileges as $value) {
            $current_privilege[$value['privilege_group_id']][] = $value;
        }

        foreach ($privilege_group as &$value) {
            if (isset($current_privilege[$value['id']])) {
                $value['list'] = $current_privilege[$value['id']];
            } else{
                $value['list'] = [];
            }
        }
        return $privilege_group;
    }
    public function groupSave($request){
        $id = $request->input('id');
        $group_name = $request->input('group_name');
        if ($id > 0) {
            $group =  app('privilege_group')->find($id);
        } else {
            $group =  app('privilege_group');
        }
        $group->group_name = $group_name;
        $group->create_at = time();
        $group->create_uid = app('Admin')->getAdminId();

        return $group->save();
    }
    public function privilegeSave($request){
        $id = $request->input('id');
        $privilege_name = $request->input('privilege_name');
        $privilege_group_id = $request->input('privilege_group_id');
        $privilege_url = $request->input('privilege_url');
        $type = $request->input('type');
        if (empty($privilege_name) || empty($privilege_url) || empty($type) || empty($privilege_group_id)) {
            throw  new  \Exception('参数有误',1001);
        }
        if ($id > 0){
            $privilege =  app('Privilege')::find($id);
            $privilege->id = $id;
        } else {
            $privilege = app('Privilege');
            $privilege_exit =  app('Privilege')->where('privilege_group_id','=',$privilege_group_id)->where('privilege_name','=',$privilege_name)->exists();
            if ($privilege_exit) {
                throw  new  \Exception('名称已存在',1001);
            }
            $privilege->create_at = time();
            $privilege->create_uid = app('Admin')->getAdminId();
        }
        $privilege->privilege_name = $privilege_name;
        $privilege->privilege_url = $privilege_url;
        $privilege->privilege_group_id = $privilege_group_id;
        $privilege->type = $type;
        return $privilege->save();
    }
    
}