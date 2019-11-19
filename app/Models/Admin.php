<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 获取单个用户信息
     * @param $id
     * @return mixed
     */
    public function getUserInfo($id){
        return DB::table('admins')
                    ->where('id', '=', $id)
                    ->first(['id','name','headpic','email','mobile','status']);
    }

    /**
     * 获取用户列表
     * @return mixed
     */
    public function getAdminList($limit,$page,$request,$field = '*'){
        //语法：paginate(int $perPage, array $columns, string $pageName, int|null $page) 
        //int $perPage：每页几条
        //array $columns：返回的字段数组。
        //string $pageName:分页字段名（无特殊要求我都是命名为page）
        //int|null $page：第几页
        $name = $request->input('name');
        $rtn = self::where('name','like',"%$name%")->paginate($limit,[$field],'page',$page);
        $results = $rtn->toArray();
        $roleList = app('Role')::all(['name','id'])->toArray();
        $role = array_column($roleList,'name','id');
        $rst['data'] = $results['data'];
        foreach ($rst['data'] as &$v) {
            $v['role_name'] = isset($role[$v['role_id']]) ? $role[$v['role_id']] : '';
        }
        $rst['count'] = $results['total'];
        return $rst;
    }

    /**
     * 编辑用户信息
     * @param $request
     * @return mixed
     */
    public function editor($request){
        $id      = $request->input('id');
        $name    = $request->input('name');
        $mobile  = $request->input('mobile');
        $email  = $request->input('email');
        $headpic = $request->input('headpic');
        $password = $request->input('password');
        $role_id = $request->input('role_id');

        if ($id > 0){
            $admin = self::find($id);
            $admin->update_at = time();
            $admin->update_uid = auth('admin')->user()->id;
        } else {
            $admin = app('Admin');
            $admin->password = Hash::make($password);;
            $admin->create_at = time();
            $admin->create_uid = auth('admin')->user()->id;
        }
        $admin->name = $name;
        $admin->mobile = $mobile;
        $admin->role_id = $role_id;
        $admin->headpic = $headpic;
        $admin->email = $email;
        return $admin->save();

    }

    /**
     * 修改密码
     * @param $request
     */
    public function updatePassword($request){
        $id      = $request->input('id');
        $new_password   = $request->input('new_password');
        $forget   = $request->input('forget');
        $sure_password  = $request->input('sure_password');
        $old_password  = $request->input('old_password');
        if (strlen($new_password) < 6) {
            throw  new  \Exception('新密码长度不能低于六位',1002);
        }
        if ($new_password !== $sure_password) {
            throw  new  \Exception('前后密码不一致',1002);
        }
        $admin = self::find($id);
        if ($forget != 'on') {
            $check = Hash::check($old_password, $admin->password);
            if (!$check) {
                throw  new  \Exception('旧密码不对',1002);
            }
        }
        $password = Hash::make($new_password);

        $admin->update_at = time();
        $admin->update_uid = auth('admin')->user()->id;
        $admin->password = $password;

        return $admin->save();
    }
    /**
     * 获取当前登录的用户ID
     */
    public function getAdminId(){
        return auth('admin')->user()->id ?: 0;
    }
}