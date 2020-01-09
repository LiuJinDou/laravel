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

Auth::routes();

Route::namespace('Admin')->group(function () {
    //Login api
    $this->get('/login', 'LoginController@showLoginForm');
    $this->post('/login', 'LoginController@login');
    $this->get('/logout', 'LoginController@logout');
    //Clear cache
    $this->get('/clear-cache', function (){
        Artisan::call('cache:clear');
        return "Cache is cleared";
    });
});
Route::namespace('Admin')->middleware('admin.auth')->group(function () {
    /**
     * public api
     */
    $this->post('files','UploadController@fileUpload');
    $this->get('index', 'HomeController@index');
    $this->get('home', function (){
        return view('admin/home');
    });
    $this->get('desktop', function (){
        return view('admin/desktop');
    });
    $this->get('welcome', function (){
        return view('admin/welcome');
    });
    $this->get('phpinfo', function (){
        echo phpinfo();
    });
    $this->get('info', 'AdminController@info');
    $this->get('list', 'AdminController@list');
    $this->post('editor', 'AdminController@editor');
    $this->post('updatePw', 'AdminController@updatePw');
    $this->post('status', 'AdminController@status');
    /**
     * 系统管理
     */
    $this->match(['get', 'post'],'/system/dictionary', 'SystemController@dictionary');
    $this->match(['get', 'post'],'/system/rules', 'SystemController@rules');
    $this->match(['get', 'post'],'/system/updates', 'SystemController@updates');
    $this->post('/system/updatesSave', 'SystemController@updatesSave');
    $this->post('/system/rulesSave', 'SystemController@rulesSave');
    $this->post('/system/statistics', 'SystemController@statistics');
    $this->get('/system/platform', function (){
        return view('admin/platform');
    });
    $this->post('/system/platform', 'SystemController@platform');
    /**
     * 权限管理
     */
    $this->post('groupSave', 'PrivilegeController@groupSave');
    $this->post('groupDel', 'PrivilegeController@groupDel');
    $this->post('privilegeSave', 'PrivilegeController@save');
    $this->post('privilegeDel', 'PrivilegeController@del');
    $this->post('roleList', 'PrivilegeController@roleList');
    $this->post('getRoleList', 'PrivilegeController@getRoleList');
    $this->post('roleSave', 'PrivilegeController@roleSave');
    $this->post('roleDel', 'PrivilegeController@roleDel');
    $this->get('rolePrivilege', 'PrivilegeController@rolePrivilege');
    $this->post('rolePrivilege', 'PrivilegeController@rolePrivilege');
    $this->post('memberList', 'AdminController@list');
    $this->post('memberSave', 'AdminController@editor');
    $this->post('/privilege/memberDel', 'AdminController@del');
    $this->get('privilege', 'PrivilegeController@privilege');
    $this->get('role', function (){
        return view('admin/role_list');
    });
    $this->get('member', function (){
        return view('admin/member_list');
    });
    /**
     * 文章管理
     */
    $this->get('article/list', function (){
        return view('admin/article_list');
    });
    $this->post('article/list', 'ArticleController@list');
//    $this->post('articleInfo', 'ArticleController@editor');
    $this->post('article/info', function (){
        return view('/js/admin/template.html');
    });
    $this->post('/article/del', 'ArticleController@del');
    $this->post('/article/editor', 'ArticleController@editor');
    $this->post('/article/status', 'ArticleController@status');
    $this->post('article/articleName', 'ArticleController@articleName');
    $this->post('/article/category', 'ArticleController@categoryList');
    $this->post('/article/categoryEditor', 'ArticleController@categoryEditor');
    $this->get('/article/categoryList', function (){
        return view('admin/article_category');
    });
    $this->post('article/categoryDel', 'ArticleController@categoryDel');
    $this->get('article/message', function (){
        return view('admin/article_message');
    });
    $this->post('article/message', 'ArticleController@message');
    $this->post('article/messageStatus', 'ArticleController@messageStatus');
    $this->post('article/messageDel', 'ArticleController@messageDel');

    $this->get('article/image_video', function (){
        return view('admin/article_image_video');
    });

    /**
     * 消费管理
     */
    $this->post('consume/list', 'ConsumeController@list');
    $this->get('consume/list', function (){
        return view('admin/consume');
    });
    $this->post('consume/save', 'ConsumeController@save');
    $this->post('consume/batchAdd', 'ConsumeController@batchAdd');
    $this->post('consume/del', 'ConsumeController@del');
    $this->post('consume/category', 'ConsumeController@category');
    $this->post('consume/categorySave', 'ConsumeController@categorySave');
    $this->get('consume/category', function (){
        return view('admin/consume_category');
    });
    $this->get('/consume/detailList', function (){
        return view('admin/consume_detail');
    });
    $this->post('/consume/detailList', 'ConsumeController@detailList');
    $this->post('/consume/detailSave', 'ConsumeController@detailSave');
    $this->post('/consume/detailDel', 'ConsumeController@detailDel');
    $this->post('/consume/detailExport', 'ConsumeController@detailExport');
    $this->post('/consume/echars', 'ConsumeController@echars');
    $this->get('/consume/echars', function (){
        return view('admin/consume_echars');
    });
    /**
     * Other Model
     */
    $this->get('/other/love','OtherController@love');

    /**
     * 图书管理
     */
    $this->get('/books/list', function (){
        return view('/admin/book_list');
    });
    $this->post('books/list', 'BooksController@list');
//    $this->post('articleInfo', 'ArticleController@editor');
    $this->post('books/info', function (){
        return view('/js/admin/template.html');
    });
    $this->post('/books/del', 'BooksController@del');
    $this->post('/books/editor', 'BooksController@editor');
    $this->post('/books/status', 'BooksController@status');
    $this->post('/books/share', 'BooksController@share');
    $this->post('/books/cancel_share', 'BooksController@cancelShare');
    $this->post('books/bookName', 'BooksController@bookName');
    $this->post('/books/category', 'BooksController@category');
    $this->post('/books/categoryEditor', 'BooksController@categoryEditor');
    $this->get('/books/category', function (){
        return view('admin/book_category');
    });
    $this->post('books/categoryDel', 'BooksController@categoryDel');
    $this->get('books/message', function (){
        return view('admin/article_message');
    });
    $this->post('books/message', 'BooksController@message');
    $this->post('books/messageStatus', 'BooksController@messageStatus');

    $this->get('books/image_video', function (){
        return view('admin/article_image_video');
    });
});

