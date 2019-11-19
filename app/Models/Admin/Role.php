<?php
namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'roles';
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 角色列表
     * @param $limit /条数
     * @param $page /页码
     * @param $request /请求
     * @param array $field / 字段
     * @return mixed
     */
    public function list($limit,$page,$request,array $field = ['*']){
        $name = $request->input('name');
        $rtn = app('Role')->where('name','like',"%$name%")->paginate($limit,$field);
        $results = $rtn->toArray();
        $admins = DB::table('admins')
            ->select('id','role_id',DB::table('admins')->raw('count(*) as total'))
            ->groupBy('role_id')
            ->get()->toArray();
        $admins_count = array_column($admins,'total','role_id');
        $names = DB::table('admins')
            ->select('id','role_id','name')
            ->get()->toArray();
        $admins_name = [];
        foreach ($names as $value) {
            if (isset($admins_name[$value['role_id']])) {
                $admins_name[$value['role_id']] = $admins_name[$value['role_id']].','.$value['name'];
            } else{
                $admins_name[$value['role_id']] = $value['name'];
            }
        }

        $rst['data'] = $results['data'];
        foreach ($rst['data'] as &$value) {
            $value['count'] = isset($admins_count[$value['id']]) ? $admins_count[$value['id']] : 0;
            $value['member_name'] = isset($admins_name[$value['id']]) ? $admins_name[$value['id']] : '';
        }
        $rst['count'] = $results['total'];
        $rst['last_page_url'] = $results['last_page_url'];
        $rst['next_page_url'] = $results['next_page_url'];
        $rst['prev_page_url'] = $results['prev_page_url'];
        $rst['first_page_url'] = $results['first_page_url'];
        return $rst;
    }

    /**
     * 新增角色
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function roleSave($request){
        $id = $request->input('id');
        $name = $request->input('name');
        if (empty($name)) {
            throw  new  \Exception('参数有误',1001);
        }
        $role = app('Role');
        if ($id > 0){
            $role =  $role->find($id);
            $role->id = $id;
            $role->update_at = time();
            $role->update_uid = app('Admin')->getAdminId();
        } else {
            /**
             * isEmpty()、isNotEmpty()、exists()、doesntExist()
             */
            $role_exit =  app('Role')->where('name','=',$name)->exists();
//            $role_exit =  app('Role')->where('name','=',$name)->doesntExist();
            if ($role_exit) {
                throw  new  \Exception('名称已存在',1001);
            }
            $role->create_at = time();
            $role->create_uid = app('Admin')->getAdminId();
        }
        $role->name = $name;
        return $role->save();
    }

    /**
     * 删除角色
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function del($id){
        $admin = DB::table('admins')->where('role_id', '=',$id)->exists();
        if ($admin) {
            throw  new  \Exception('不能删除该角色',4003);
        }
        return self::destroy($id);
    }
    public function getList(){
        return self::all(['id','name'])->toArray();
    }

    /**
     * 角色权限
     * @param $id
     * @return mixed
     */
    public function rolePrivilege($id){
        $role_pivilege = app('role_privilege')::where('role_id',$id)->get()->toArray();
        $role_pivilege = array_column($role_pivilege,'role_id','privilege_id');
        $data = app('Privilege')->list();
        foreach ($data as &$value){
            foreach ($value['list'] as &$item) {
                if (isset($role_pivilege[$item['id']])) {
                    $item['is_allow'] = true;
                } else {
                    $item['is_allow'] = false;
                }
            }
        }
        return $data;
    }

    /**
     * 更新角色权限
     * @param $request
     * @return mixed
     */
    public function savePrivilege($request){
        $id = $request->input('id');
        $privileges = $request->input('privileges');
        $data = [];
        foreach ($privileges as $value) {
            $data[] = [
                'role_id'=> $id,
                'privilege_id'=> $value,
            ];
        }
        app('role_privilege')::where('role_id',$id)->delete();
        return DB::table('role_privilege')->insert($data);

    }
}