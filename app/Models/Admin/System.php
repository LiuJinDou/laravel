<?php
namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class System extends Model {

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * develop rule save or editor
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function rulesSave($request){
        $id = $request->input('id');
        $name = $request->input('name');
        $date = $request->input('date');
        $content = $request->input('content');
        if (empty($name) || empty($date) || empty($content) ) {
            throw  new  \Exception('参数有误',1001);
        }
        if ($id > 0){
            $develop_rule =  app('develop_rule')::find($id);
            $develop_rule->id = $id;
        } else {
            $develop_rule = app('develop_rule');
        }
        $develop_rule->create_at = time();
        $develop_rule->create_uid = app('Admin')->getAdminId();
        $develop_rule->name = $name;
        $develop_rule->date = $date;
        $develop_rule->content = $content;
        return $develop_rule->save();
    }

    /**
     * update log save or editor
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function updatesSave($request){
        $id = $request->input('id');
        $version = $request->input('version');
        $date = $request->input('date');
        $content = $request->input('content');
        if (empty($version) || empty($date) || empty($content) ) {
            throw  new  \Exception('参数有误',1001);
        }
        if ($id > 0){
            $update_log =  app('update_log')::find($id);
            $update_log->id = $id;
        } else {
            $update_log = app('update_log');
            $update_log->create_at = time();
            $update_log->create_uid = app('Admin')->getAdminId();
        }
        $update_log->version = $version;
        $update_log->date = $date;
        $update_log->content = $content;
        return $update_log->save();
    }
    public function statistics(){
        $data = [];
        $data[] = [
            'total' => app('Role')->count(),
            'title' => '角色数量'
        ];
        $data[] = [
            'total' => app('Admin')->count(),
            'title' => '管理员数量'
        ];
        $data[] = [
            'total' => app('Article')->count(),
            'title' => '文章数量'
        ];
        $data[] = [
            'total' => app('Message')->count(),
            'title' => '评论数量'
        ];
        $data[] = [
            'total' => DB::table('users')->count(),
            'title' => '会员数量'
        ];
        $data[] = [
            'total' => DB::table('book')->where('status','=',1)->count(),
            'title' => '已读图书'
        ];
        return $data;
    }
}