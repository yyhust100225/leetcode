<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class CodeController extends BaseController
{
    public function output()
    {
        // dd($this->preg_test("99/4*2998+10*568/14"));
        // dd($this->find_minimum_value([1,-2,-3]));
        // dd($this->isPerfectSquare(14));
        // dd($this->twoSum([2,7,11,15], 9));
        // dd($this->mainshi());
        // dd($this->fileOperation('./a.txt'));
        // $this->delDirOperation('./目录1');
        // $this->yinyong();
        // $this->magicFunctions();
        // echo __FILE__;

         $conn = Factory::createInstance();
         echo $conn->getName() . '<br>';
         $conn1 = Register::getObject('db');
         $conn1->connect();


    }

    public function preg_test($str)
    {
        $preg = '/\d+[*\/]\d+/';
        preg_match($preg, $str, $match);
        return $match;
    }

    /*
     * 逐步求和得到正数的最小值
     * 给你一个整数数组 nums 。你可以选定任意的 正数 startValue 作为初始值
     * 你需要从左到右遍历 nums 数组，并将 startValue 依次累加上 nums 数组中的值
     * 请你在确保累加和始终大于等于 1 的前提下，选出一个最小的 正数 作为 startValue
     */
    public function find_minimum_value($nums)
    {
//        $flag = false;
//        $begin = 1;
//        while(!$flag) {
//            $temp = $begin;
//            foreach($arr as $value) {
//                $temp += $value;
//                if($temp < 1) {
//                    $begin++;
//                    continue 2;
//                }
//            }
//            $flag = true;
//        }
//        return $begin;

        $sum = 0;
        $min = 0;
        foreach($nums as $num) {
            $sum += $num;
            if($sum < $min)
                $min = $sum;
        }

        return 1 - $min;
    }

    /**
     * 有效的完全平方数
     * 给定一个正整数 num，编写一个函数，如果 num 是一个完全平方数，则返回 True，否则返回 False
     * 说明：不要使用任何内置的库函数，如  sqrt
     * @param $num
     * @return bool
     */
    public function isPerfectSquare($num) {
        $last_num = $num % 10;
        if(!in_array($last_num, [0, 1, 4, 5, 6, 9]))
            return false;

        $i = 1;
        while($i*$i < $num) {
            $i++;
        }

        if($i*$i > $num) return false;
        else return true;
    }

    /**
     * 给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那 两个 整数，并返回他们的数组下标
     * 你可以假设每种输入只会对应一个答案。但是，数组中同一个元素不能使用两遍
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum($nums, $target) {
        $new_array = array_flip($nums);
        foreach($nums as $key => $num) {
            if(in_array($target - $num, $nums)) {
                if($key != $new_array[$target - $num])
                return [$key, $new_array[$target - $num]];
            }
        }
    }

    public function mainshi()
    {
        static $count;

        return $count++;
    }

    /**
     * 文件操作练习
     */
    public function fileOperation($file){
        $handle = fopen($file, 'r+');
        $content = fread($handle, filesize($file));

        $str = "桃李春风一杯酒，江湖夜雨十年灯。——黄庭坚《寄黄几复》\n";
        $content = $str . $content;
        fseek($handle, 0);
        $res = fwrite($handle, $content);
        fclose($handle);
        return $res;
    }

    /**
     * 目录操作练习
     */
    public function dirOperation($dir, $deep = 0)
    {
        $handle = opendir($dir);
        while(false !== ($file = readdir($handle))) {
            if($file != '.' && $file != '..') {
                echo str_repeat('-', $deep) . $file . "<br>";
                if(filetype($dir. DIRECTORY_SEPARATOR . $file) == 'dir') {
                    $this->dirOperation($dir. DIRECTORY_SEPARATOR . $file, $deep+1);
                }
            }
        }
    }

    /**
     * 遍历删除目录
     */
    public function delDirOperation($dir) {

        if(!is_dir($dir)) return false;

        $handle = opendir($dir);
        while(false !== ($file = readdir($handle))) {
            if($file != '.' && $file != '..') {
                $dirname = $dir . DIRECTORY_SEPARATOR . $file;
                is_dir($dirname) ? $this->delDirOperation($dirname) : unlink($dirname);
            }
        }
        closedir($handle);
        if(rmdir($dir)) {
            echo "已删除目录: " . $dir . "<br>";
            return true;
        }

        else return false;
    }

    public function yinyong(){
        $data = ['a', 'b', 'c'];
        foreach($data as $key => $value) {
            $value = &$data[$key];
        }
        print_r($data);
    }

    /**
     * 魔术方法测试学习
     */
    public function magicFunctions() {
        $mf = new MagicFunctions();
        // $mf->testCall('123', '456');
        // MagicFunctions::testStaticMagicFunctions('1', '2', '3');
        // $mf->name = "youyan";
        // echo $mf->getName();
        // echo $mf->age;
        // dd(isset($mf->abc));
        // unset($mf->sex);
        // dd($temp = serialize($mf));
        // echo $mf;
//        $c_mf = clone $mf;
//        echo $c_mf->name.$c_mf->age;
        $mf("asd");
    }
}

class MagicFunctions
{
    public $name = 'huorui';
    public $age = 25;

    public function __call($name, $arguments)
    {
        echo $name . "<br>";
        print_r($arguments);
    }

    public static function __callStatic($method, $args){
        echo $method . "<br>";
        print_r($args);
    }

    public function __set($name, $value)
    {
        echo $name.'<br>'.$value;
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $name . ":" .'29';
    }

    public function __isset($name){
        return $name == 'sex';
    }

    public function __unset($name){
        echo $name;
    }

    public function __sleep(){
        echo '123456789';
        return ['name'];
    }

    public function __toString(){
        return 'this is an example instance';
    }

    public function __clone(){
        $this->name = "new class";
        $this->age = 30;
    }

    public function __invoke($args)
    {
        echo "12312312312321" . $args;
        return true;
    }
}

/**
 * 单例模式
 * class SimpleInstance
 * @package App\Http\Controllers\Admin
 */
class SimpleInstance {
    private static $_instance = NULL;
    private $name;
    private $password;

    private function __construct($name, $password){
        $this->name = $name;
        $this->password = $password;
    }

    public static function getInnstance() {
        if(is_null(self::$_instance)) {
            echo "new object! <br>";
            return self::$_instance = new self("youyan", '327920843');
        } else {
            echo "old object! <br>";
            return self::$_instance;
        }
    }

    public function getName() {
        return $this->name;
    }

    public function connect() {
        echo "use name: ".$this->name.", password: ".$this->password." login, success!";
        return true;
    }
}

/**
 * 工厂模式
 * Class Factory
 * @package App\Http\Controllers\Admin
 */
class Factory{
    public static function createInstance() {
        $db_instance = SimpleInstance::getInnstance();
        Register::set('db', $db_instance);
        return $db_instance;
    }
}

/**
 * 注册树模式
 * Class Register
 * @package App\Http\Controllers\Admin
 */
class Register{
    private static $objects;

    public static function set($alias, $object) {
        self::$objects[$alias] = $object;
    }

    public static function _unset($alias) {
        unset(self::$objects[$alias]);
    }

    public static function getObject($alias) {
        return self::$objects[$alias];
    }
}
