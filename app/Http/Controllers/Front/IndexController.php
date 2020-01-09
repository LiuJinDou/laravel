<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index(Request $request){
        if ($request->isMethod('post')){
            $data['code'] = 0;
            $data['msg'] = 'ok';
            try {
                $data['data'] = app('FrontIndex')->getIndexArticle();

            }catch (\Exception $e) {
                $data['code'] = $e->getCode();
                $data['msg'] = $e->getMessage();
            }

            return response()->json($data);
        }else {
            $data = app('FrontIndex')->getIndexArticle();

            return view('front.index',['data' => $data]);
        }
    }
    public function about(){
        $data = app('FrontIndex')->getIndexArticle();

        return view('front/about');
    }
    public function work(Request $request){
        if ($request->isMethod('post')){
            $limit = $request->input('limit',10);
            $page = $request->input('page',1);
            $data['code'] = 0;
            $data['msg'] = 'ok';
            try {
                $data['data'] = app('FrontIndex')->getWorkArticle($page,$limit);

            }catch (\Exception $e) {
                $data['code'] = $e->getCode();
                $data['msg'] = $e->getMessage();
            }

            return response()->json($data);
        }else {
            return view('front.work');
        }

    }
    public function study(Request $request){
        if ($request->isMethod('post')){
            $limit = $request->input('limit',10);
            $page = $request->input('page',1);
            $data['code'] = 0;
            $data['msg'] = 'ok';
            try {
                $data['data'] = app('FrontIndex')->getStudyArticle($page,$limit);

            }catch (\Exception $e) {
                $data['code'] = $e->getCode();
                $data['msg'] = $e->getMessage();
            }

            return response()->json($data);
        }else {
            return view('front.study');
        }

    }
    public function life(Request $request){
        if ($request->isMethod('post')){
            $limit = $request->input('limit',10);
            $page = $request->input('page',1);
            $data['code'] = 0;
            $data['msg'] = 'ok';
            try {
                $data['data'] = app('FrontIndex')->getLifeArticle($page,$limit);

            }catch (\Exception $e) {
                $data['code'] = $e->getCode();
                $data['msg'] = $e->getMessage();
            }

            return response()->json($data);
        }else {
            return view('front.life');
        }

    }
    public function info(Request $request){
        $id = $request->input('id');
        // 
        $data['current'] =  app('Article')->info($id);
        // get previous post id
        $data['prev'] =  app('Article')->getPrevArticleId($id,['id','title']);
        // get next post id
        $data['next'] =  app('Article')->getNextArticleId($id,['id','title']);
        $data['recommend'] =   app('Article')->where('category_id','=',$data['current']['category_id'])->paginate(6);

        if ($data['current']) {
            return view('front/info',['data'=>$data]);
        } else {
            return view('front/404',['data'=>$data]);
        }
    }
    public function message(Request $request){
        if ($request->isMethod('post')){
            $limit = $request->input('limit',10);
            $page = $request->input('page',1);
            $article_id = $request->input('article_id',0);
            $data['code'] = 0;
            $data['msg'] = 'ok';
            try {
                $data['data'] = app('FrontIndex')->getMessage($page,$limit,$article_id);

            }catch (\Exception $e) {
                $data['code'] = $e->getCode();
                $data['msg'] = $e->getMessage();
            }

            return response()->json($data);
        }else {
            return view('front/message');
        }
    }
    public function addMessage(Request $request){
        $data['code'] = 0;
        $data['msg'] = 'Thanks your message!';
        try {
            $data['data'] = app('FrontIndex')->addMessage($request);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function search(Request $request){
        $keyboard = $request->input('keyboard');
        $data['search'] = app('Article')->searchArticle($keyboard);
        return view('front/search',['data'=>$data]);
    }
    public function love(Request $request){
        $id = $request->input('id');
        $data['code'] = 0;
        $data['msg'] = 'Thank you for your appreciation. ';
        try {
            if (empty($id)) {
                throw  new  \Exception('System error,please try again later ');
            }
            $data['data'] = app('Article')->increase($id,'love',1);

        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);
    }
    public function test(){
        $encrypt = encrypt(123);
        $decrypt = decrypt($encrypt);
//        $encrypt = encrypt_function(123);
//        $decrypt = decrypt_function($encrypt);
        var_dump($encrypt);
        var_dump($decrypt);
        var_dump(function_exists('test_method'));die;

        echo self::king(7,3);
    }
    function king($n, $m){

        $monkeys = range(1, $n);         //创建1到n数组

        $i=0;

        while (count($monkeys)>1) {   //循环条件为猴子数量大于1

            if(($i+1)%$m==0) {   //$i为数组下标;$i+1为猴子标号

                unset($monkeys[$i]);    //余数等于0表示正好第m个，删除，用unset删除保持下标关系

            } else {

                array_push($monkeys,$monkeys[$i]);     //如果余数不等于0，则把数组下标为$i的放最后，形成一个圆形结构

                unset($monkeys[$i]);

            }

            $i++;//$i 循环+1，不断把猴子删除，或 push到数组

        }

        return current($monkeys);   //猴子数量等于1时输出猴子标号，得出猴王

    }

}
