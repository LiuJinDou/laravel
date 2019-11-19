<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * bind instance
         */
        $this->bindInstance();
        /**
         * record sql
         */
        $this->recordSql();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * * 获取指定目录下指定文件后缀的函数
     * @param $path 文件路径
     * @param $filename 使用时请提前赋值为空数组
     * @param bool $recursive 是否递归查找，默认为false
     * @param bool $ext 文件后缀名，默认为false为不指定，如果指定，请以数组方式传入
     * @param bool $baseurl 是否包含路径，默认包含
     * @return array
     */
    protected function getDirFilesLists($path,&$filename,$recursive = false,$ext = false,$baseurl = true){
        if(!$path){
            die('请传入目录路径');
        }
        $resource = opendir($path);
        if(!$resource){
            die('你传入的目录不正确');
        }
        //遍历目录
        while ($rows = readdir($resource)){
            //如果指定为递归查询
            if($recursive) {
                if (is_dir($path . '/' . $rows) && $rows != "." && $rows != "..") {
                    $this->getDirFilesLists($path . '/' . $rows, $filename,$resource,$ext,$baseurl);
                } elseif ($rows != "." && $rows != "..") {
                    //如果指定后缀名
                    if($ext) {
                        //必须为数组
                        if (!is_array($ext)) {
                            die('后缀名请以数组方式传入');
                        }
                        //转换小写
                        foreach($ext as &$v){
                            $v = strtolower($v);
                        }
                        //匹配后缀
                        $file_ext = strtolower(pathinfo($rows)['extension']);
                        if(in_array($file_ext,$ext)){
                            //是否包含路径
                            if($baseurl) {
                                $filename[] = $path . '/' . $rows;
                            }else{
                                $filename[] = $rows;
                            }
                        }
                    }else{
                        if($baseurl) {
                            $filename[] = $path . '/' . $rows;
                        }else{
                            $filename[] = $rows;
                        }
                    }
                }
            }else{
                //非递归查询
                if (is_file($path . '/' . $rows) && $rows != "." && $rows != "..") {
                    if($baseurl) {
                        $filename[] = $path . '/' . $rows;
                    }else{
                        $filename[] = $rows;
                    }
                }
            }
        }
        return $filename;
    }
    public function bindInstance(){
//
        /**
         * 简单绑定
         * 在服务提供者中，可以通过 $this->app 属性访问容器。我们可以通过 bind 方法进行绑定。
         * bind 方法需要两个参数，第一个参数是我们想要注册的类名或接口名称，第二个参数是返回类的实例的闭包。
         */
        $this->app->bind('login', function () {
            return new \App\Model\Login();
        });
        //绑定单例
        $this->app->singleton('test',function(){
            return new \App\Test\TestService();
        });
        /**
         * 绑定实例
         */
        $filename = array();
        $models_files = $this->getDirFilesLists(app_path('Models'),$filename,true);
        foreach ($models_files as $value) {
            $basename = basename($value);
            $position = strripos($basename,'.');
            $basename = substr($basename,0,$position);
            $dirname = dirname($value);
            $app_position = strpos($dirname,'app');
            $namespace = str_replace('app','\App',substr($dirname,$app_position));
            $namespace = str_replace('/','\\',$namespace);
            $namespace = str_replace('"','',$namespace).'\\'.$basename;
//            var_dump($basename);
//            var_dump($namespace);
            $this->app->instance($basename ,new $namespace());
        }
    }

    /**
     * record sql
     */
    public function recordSql(){
        \DB::listen(function ($query) {
            $tmp = str_replace('?', '"'.'%s'.'"', $query->sql);
            $qBindings = [];
            foreach ($query->bindings as $key => $value) {
                if (is_numeric($key)) {
                    $qBindings[] = $value;
                } else {
                    $tmp = str_replace(':'.$key, '"'.$value.'"', $tmp);
                }
            }
            $tmp = vsprintf($tmp, $qBindings);
            $tmp = str_replace("\\", "", $tmp);
//            \Log::info(' execution time: '.$query->time.'ms; '.$tmp."\n\n\t");
            $filepath = storage_path().'/logs/project/'.date('Y-m-d');
            $this->Directory($filepath);
            $filepath = $filepath.'/sql.log';
            file_put_contents($filepath, ' execution time: '.$query->time.'ms; '.$tmp."\n\n", FILE_APPEND);
        });
    }

    /**
     * create dir
     * @param $dir
     * @return bool
     */
    protected function Directory( $dir ){
        return is_dir ( $dir ) or $this->Directory(dirname( $dir )) and  mkdir ( $dir , 0777, true);
    }
}
