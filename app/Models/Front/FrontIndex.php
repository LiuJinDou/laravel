<?php
namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class FrontIndex extends Model{

    public function getIndexArticle(){

        $rst['special'] = app('Article')->where('status','=',1)->orderBy('update_at', 'desc')->paginate(3)->toArray()['data'];
        $rst['recommends'] = app('Article')->where('status','=',1)->orderBy('update_at', 'desc')->paginate(6)->toArray()['data'];
        $rst['news'] = app('Article')->where('status','=',1)->orderBy('create_at', 'desc')->paginate(6)->toArray()['data'];
        $rst['browses'] = app('Article')->where('status','=',1)->orderBy('browse', 'desc')->paginate(6)->toArray()['data'];

        return $rst;
    }
    public function getWorkArticle($page,$limit){
        $rst = app('Article')->where('category_id','=','1')->where('status','=',1)->orderBy('create_at', 'desc')->paginate($limit)->toArray();
        $return['works'] = $rst['data'];
        $return['count'] = $rst['total'];
        $return['recommends'] = app('Article')->where('category_id','=','1')->where('status','=',1)->orderBy('browse', 'desc')->paginate(6)->toArray()['data'];
        $return['ranking'] = app('Article')->where('category_id','=','1')->where('status','=',1)->orderBy('browse', 'desc')->paginate(6)->toArray()['data'];

        return $return;
    }
    public function getStudyArticle($page,$limit){
        $rst = app('Article')->where('category_id','=','3')->where('status','=',1)->orderBy('create_at', 'desc')->paginate($limit)->toArray();
        $return['studys'] = $rst['data'];
        $return['count'] = $rst['total'];
        $return['recommends'] = app('Article')->where('category_id','=','3')->where('status','=',1)->orderBy('browse', 'desc')->paginate(6)->toArray()['data'];
        $return['ranking'] = app('Article')->where('category_id','=','3')->where('status','=',1)->orderBy('browse', 'desc')->paginate(6)->toArray()['data'];

        return $return;
    }
    public function getLifeArticle($page,$limit){
        $rst = app('Article')->where('category_id','=','2')->where('status','=',1)->orderBy('create_at', 'desc')->paginate($limit)->toArray();
        $return['lifes'] = $rst['data'];
        $return['count'] = $rst['total'];
        $return['recommends'] = app('Article')->where('category_id','=','2')->where('status','=',1)->orderBy('browse', 'desc')->paginate(6)->toArray()['data'];
        $return['ranking'] = app('Article')->where('category_id','=','2')->where('status','=',1)->orderBy('browse', 'desc')->paginate(6)->toArray()['data'];

        return $return;
    }
    public function getMessage($page,$limit,$article_id){
        $rst = app('Message')->where('article_id','=',$article_id)->where('status','=',1)->orderBy('create_at', 'desc')->paginate($limit)->toArray();

        $return['message'] = $rst['data'];
        $return['count'] = $rst['total'];

        return $return;
    }
    public function addMessage($request){
        $id = $request->input('article_id',0);
        $name = $request->input('name');
        $content = $request->input('content');
        $headpic = $request->input('headpic');
        $client_ip = $_SERVER['REMOTE_ADDR'];
        $time = Redis::get('client_ip'.$client_ip);
        if (time()- $time < 180) {
            return true;
        } else {
            Redis::set('client_ip'.$client_ip, time());
        }
        $message = app('Message');
        $message->article_id = $id;
        $message->name = $name;
        $message->content = htmlspecialchars($content);
        $message->headpic = $headpic;
        $message->client_ip = $client_ip;
        $message->create_at = date('Y-m-d H:i:s');
        return $message->save();
    }

}