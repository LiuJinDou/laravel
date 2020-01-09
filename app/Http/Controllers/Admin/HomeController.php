<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function test(){
        echo  phpinfo();
    }
    public function index()
    {
        $data = app('Index')->getPrivileges();
        return view('admin.index',['data' => $data]);
    }

    public function privilegeList(){
        return view('/admin/privilege_list.html');
    }
   
}
