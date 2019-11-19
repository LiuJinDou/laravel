<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Index extends Model {

    public function getPrivileges(){
        $role_id = auth('admin')->user()->role_id;
        $privilege_id = DB::table('role_privilege')
            ->where('role_id','=',$role_id)
            ->get()->toArray();
        $privilege_id = array_column($privilege_id,NULL,'privilege_id');
        $privileges = DB::table('privileges')
            ->whereIn('id', array_keys($privilege_id))
            ->where('type','=', 2)
            ->get()->toArray();

        $privilege_group = DB::table('privilege_group')->get()->toArray();
        $privilege_group = array_column($privilege_group, NULL, 'id');
        $current_privilege = [];
        foreach ($privileges as $value) {
            $current_privilege[$value['privilege_group_id']]['title'] = $privilege_group[$value['privilege_group_id']]['group_name'];
            $current_privilege[$value['privilege_group_id']]['list'][] = $value;
        }
        return $current_privilege;
    }
}