<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Front')->group(function () {
    //登录接口
    $this->get('/', 'IndexController@index');
//    $this->get('/test', 'IndexController@test');
    $this->get('/test', 'TestController@test');
    $this->get('/client', 'TestController@client');
    $this->get('/worker', 'TestController@worker');
//    Route::get('/', function () {
//        return view('welcome');
//    });
    $this->post('/front/index', 'IndexController@index');
    $this->get('/front/about', 'IndexController@about');
    $this->match(['get','post'],'/front/work', 'IndexController@work');
    $this->match(['get','post'],'/front/study', 'IndexController@study');
    $this->match(['get','post'],'/front/life', 'IndexController@life');
    $this->match(['get','post'],'/front/message', 'IndexController@message');
    $this->post('/front/addMessage', 'IndexController@addMessage');
    $this->get('/front/info', 'IndexController@info');
    $this->get('/front/search', 'IndexController@search');
    $this->post('/front/love', 'IndexController@love');

    $this->get('front/chat',function (){
        return view('front/chat/index');
    });
    $this->get('/front/chat/getList', 'Chat\ChatController@getList');
});


