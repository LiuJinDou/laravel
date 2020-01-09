<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout','showLoginForm']);
    }

    public function showLoginForm(Request $request)
    {
        $this->guard()->logout();

        return view('admin.login');
    }

    protected function guard()
    {
        return auth()->guard('admin');
    }

    /**
     * 后台管理员退出跳转到后台登录页面
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $data['code'] = 0;
        $data['msg'] = 'ok';
        try {
            // 验证用户名登录方式
            $usernameLogin = $this->guard()->attempt(
                ['name' => $username, 'password' => $password], $request->has('remember')
            );

            if ($usernameLogin) {
                $data['data'] = NULL;
                return response()->json($data);
            }
            // 验证手机号登录方式
            $mobileLogin = $this->guard()->attempt(
                ['mobile' => $username, 'password' => $password], $request->has('remember')
            );
            if ($mobileLogin) {
                $data['data'] = NULL;
                return response()->json($data);
            }

            // 验证邮箱登录方式
            $emailLogin = $this->guard()->attempt(
                ['email' => $username, 'password' => $password], $request->has('remember')
            );
            if ($emailLogin) {
                $data['data'] = NULL;
                return response()->json($data);
            }
            throw new \Exception('用户名/密码错误',1001);
        }catch (\Exception $e) {
            $data['code'] = $e->getCode();
            $data['msg'] = $e->getMessage();
        }

        return response()->json($data);

//        $check = Hash::check('$10$Xo60fgMBKGTC/cUvIIdpzednWg9NucciBJ/3tulbtwToLqGbpwh1C' ,$password);
//        $check2 = Hash::check($password, '$10$Xo60fgMBKGTC/cUvIIdpzednWg9NucciBJ/3tulbtwToLqGbpwh1C');
//        $test = Hash::make($password);
//        var_dump($test);
//        $check3 = Hash::check($password,$test);
//        var_dump($check);
//        var_dump($check2);
//        var_dump($check3);
//        \DB::enableQueryLog();

//        var_dump($this->guard());
//        $queries = \DB::getQueryLog(); // 获取查询日
//        print_r($queries); // 即可查看执行的sql
//        var_dump($usernameLogin);
//        if ($usernameLogin) {
//            return true;
//        }
        // 验证手机号登录方式
//        $mobileLogin = $this->guard()->attempt(
//            ['mobile' => $username, 'password' => $password], $request->has('remember')
//        );
//        if ($mobileLogin) {
//            return true;
//        }
//var_dump($mobileLogin);
        // 验证邮箱登录方式
//        $emailLogin = $this->guard()->attempt(
//            ['email' => $username, 'password' => $password], $request->has('remember')
//        );
//        if ($emailLogin) {
//            return true;
//        }
//        var_dump($emailLogin);die;
//        return false;
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
    protected function redirectTo()
    {
        return '/admin/index';
    }
    public function username()
    {
        return 'username';
    }
}