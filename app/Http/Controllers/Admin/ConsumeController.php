<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsumeController extends Controller
{
    /**
     * list
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('Consume')->list($limit,$page,$request);
            $data['count'] = $rtn['count'];
            $data['data'] = $rtn['data'];

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * add/editor one
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('Consume')->consumeSave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * batch add
     * @param Request $request
     * @return mixed
     */
    public function batchAdd(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('Consume')->batchAdd($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }
    public function del(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $id = $request->input('id');
            if (empty($id)){
                throw  new  \Exception('缺少条件',3001);
            }
            $detail = app('ConsumeDetail')->where('consume_id',$id)->exists();
            if ($detail) {
                throw  new  \Exception('存在详情、不可删除',3001);
            }
            //视图间共享数据
            $data['data'] = app('Consume')->destroy($id);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }
    public function echars(Request $request)
    {
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('Consume')->echars($request);
            $data['data'] = $rtn;

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    /**
     * 消费详情列表
     * @param Request $request
     * @return mixed
     */
    public function detailList(Request $request)
    {
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $rtn = app('ConsumeDetail')->list($limit,$page,$request);
            $data['count'] = $rtn['count'];
            $data['data'] = $rtn['data'];

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * 添加详情
     * @param Request $request
     * @return mixed
     */
    public function detailSave(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('ConsumeDetail')->detailSave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }

    /**
     * Delete detail
     * @param Request $request
     * @return mixed
     */
    public function detailDel(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $id = $request->input('id');
            if (empty($id)){
                throw  new  \Exception('缺少条件',3001);
            }
            //视图间共享数据
            $data['data'] = app('ConsumeDetail')->destroy($id);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }
    /**
     * Category list
     * @return mixed
     */
    public function category()
    {
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            $data['data'] = app('Consume')->category();

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    /**
     * Add/Editor category
     * @param Request $request
     * @return mixed
     */
    public function categorySave(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            //视图间共享数据
            $data['data'] = app('Consume')->categorySave($request);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return  $data;

    }
}
