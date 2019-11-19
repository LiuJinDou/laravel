<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtherController extends Controller{
    public function love(){
        return view('admin/love');
    }
}
