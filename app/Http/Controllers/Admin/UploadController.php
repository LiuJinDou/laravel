<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Storage;

class UploadController extends Controller
{
    public function fileUpload(Request $request){
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $newFileName = md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $date = date('Y-m-d');
        $type = $request->input('type');
        switch ($type) {
            case 1 :
                $savePath = 'upload/video/'.$date.'/'.$newFileName;break;
            case 2 :
                $savePath = 'upload/image/'.$date.'/'.$newFileName;break;
            default :
                $savePath = 'upload/image/'.$date.'/'.$newFileName;break;
        }
        $bytes = \Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        if(!\Storage::exists($savePath)){
            exit('保存文件失败！');
        }
        header("Content-Type: ".\Storage::mimeType($savePath));
//        $savePath =  \Storage::get($savePath);
        return [
            'code' => 0,
            'msg' => 'ok',
            'data' => '/'.$savePath,
        ];
    }
}
