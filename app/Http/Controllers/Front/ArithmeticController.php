<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArithmeticController extends Controller
{
    //
    public function arithmetic(){

        echo self::king(7,3);

        //获取上个月第一天
        date('Y-m-01',strtotime('-1 month'));
        //获取上个月最后一天
        date('Y-m-t',strtotime('-1 month'));
    }

    /**
     * PHP奇异算法
     */
    function queer(){
        //PHP7以下的版本返回的是 6，PHP7版本返回5 ，还真的算奇异，个人底层算法差，认为是PHP7以下版本的BUG
        $a=1;
        $b=&$a;
        echo (++$a)+(++$a);
    }
    /**
     * 一群猴子排成一圈，按1，2，…，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，再数到第m只，在把它踢出去…，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
     * @param $n
     * @param $m
     * @return mixed
     */
    function king($n, $m){

        $monkeys = range(1, $n);         //创建1到n数组
        //1245671
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

    /**
     * 有一母牛，到4岁可生育，每年一头，所生均是一样的母牛，到15岁绝育，不再能生，20岁死亡，问n年后有多少头牛。
     * @param $y
     * @return int
     */
    function niu($y){

        static $num= 1;                 //定义静态变量;初始化牛的数量为1

        for ($i=1; $i <=$y ; $i++) {

            if($i>=4 && $i<15){         //每年递增来算，4岁开始+1，15岁不能生育

                $num++;

                niu($y-$i);             //递归方法计算小牛$num，小牛生长年数为$y-$i

            }else if($i==20){

                $num--;                          //20岁死亡减一

            }
        }
        return $num;
    }

    /**
     * 遍历一个文件下的所有文件和子文件夹下的文件
     * @param $dir
     */
    function AllFile($dir){

        if($dh = opendir($dir)){

            while (($file = readdir($dh)) !== false){

                if($file !='..' && $file !='.'){

                    if(is_dir($dir.'/'.$file)){

                        AllFile($dir.'/'.$file);    //如果判断还是文件，则递归

                    }else{

                        echo $file;         //输出文件名

                    }

                }

            }

        }

    }

    /**
     * 从一个标准的Url提取出文件的扩展名
     * @param $url
     * @return mixed
     */
    function getExt($url)

    {

        $arr = parse_url($url);

        $file = basename($arr['path']);// basename函数返回路径中的文件名部分

        $ext = explode('.', $file);

        return $ext[count($ext)-1];

    }

    /**
     * 有个人想上一个n级的台阶，每次只能迈1级或者迈2级台阶，问：这个人有多少种方法可以把台阶走完？例如：总共3级台阶，可以先迈1级再迈2级，或者先迈2级再迈1级，或者迈3次1级总共3中方式
     * @param $nums
     * @return int
     */
    function step($num){   //实际上是斐波那契数列

        return $num<2?1:self::step($num-1)+self::step($num-2);

    }

    /**
     * 请写一段PHP代码，确保多个进程同时写入同一个文件成功
     */
    function process(){
        $fp = fopen("lock.txt","w+");

        if (flock($fp,LOCK_EX)) {
            //获得写锁，写数据
            fwrite($fp, "write something");
            // 解除锁定
            flock($fp, LOCK_UN);
        } else {
            echo "file is locking...";
        }
        fclose($fp);
    }

    /**
     * 无限级分类
     * @param $arr
     * @param int $pid
     * @param int $level
     * @return array
     */
    function tree($arr,$pid=0,$level=0){

        static $list = array();

        foreach ($arr as $v) {

            //如果是顶级分类，则将其存到$list中，并以此节点为根节点，遍历其子节点

            if ($v['pid'] == $pid) {

                $v['level'] = $level;

                $list[] = $v;

                tree($arr,$v['id'],$level+1);

            }

        }

        return $list;

    }
}
