<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    public function list(Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('Book')->list($limit,$page,$request);
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
            $is_del = app('Book')->find($id);
            if ($is_del->status || $is_del->share_status) throw new  \Exception('Cant`t be deleted');
            $data['data'] = app('Book')->destroy($id);

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
            $rtn = app('Book')->editor($request);
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
                $data['data'] = app('Book')->where(['id'=>$id])->update(['status'=>$status]);
            }

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function share(Request $request){
        $id = $request->input('id');

        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (empty($id)) {
                throw new \Exception('Param error',2001);
            }
            $data['data'] = app('Book')->share($id);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function cancelShare(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            if (!empty($id)) {
                $book = app('Book')->find($id);
                $data['data'] = app('Book')->where(['id'=>$id])->update(['share_status'=>0]);
                app('Article')->find($book->article_id)->delete();
            }

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function bookName(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Book')->bookName($id);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function category(){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Book')->categoryList();

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
            $data['data'] = app('Book')->categoryEditor($request);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function categoryDel(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Book')->categoryDel($request);

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
            $rtn = app('Book')->message($page,$limit);
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
}
