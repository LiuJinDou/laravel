<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function list(Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
           $rtn = app('Article')->list($limit,$page,$request);
           $data['count'] = $rtn['count'];
           $data['data'] = $rtn['data'];

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function del(Request $request)
    {
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $info = app('Article')->find($id);
            if ($info->status) {
                throw new \Exception('Can not be deleted');
            }
            $data['data'] = app('Article')->destroy($id);

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
           $rtn = app('Article')->editor($request);
           $data['data'] = $rtn['data'];

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
            if (!empty($id)) {
                $data['data'] = app('Article')->where(['id'=>$id])->update(['status'=>$status]);
            }
            
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function articleName(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Article')->articleName($id);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function categoryEditor(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Article')->categoryEditor($request);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function categoryList(Request $request){
        $id = $request->input('id',0);
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Article')->categoryList($id);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function categoryDel(Request $request)
    {
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Article')->categoryDel($id);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function message(Request $request){
        $limit = $request->input('limit');
        $page = $request->input('page');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('Article')->message($page,$limit);
            $data['count'] = $rtn['count'];
            $data['data'] = $rtn['data'];
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function messageStatus(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (!empty($id)) {
                $data['data'] = app('Message')->where(['id'=>$id])->update(['status'=>$status]);
            }

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function messageDel(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (!empty($id)) {
                $data['data'] = app('Message')->find($id)->delete();
            }

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
