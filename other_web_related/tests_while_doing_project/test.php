<?php
/* User:lyt123; Date:2017/1/17; QQ:1067081452 */
//ob_start();
//echo 1;
//echo 2;
//var_dump("1:".ob_get_contents());
//ob_flush();
//var_dump("2:".ob_get_contents());
//echo 3;
//ob_clean();
//var_dump("3:".ob_get_contents());
//echo 4;

//echo 'haha';
//for($i = 0; $i < 10; $i++)
//{
//    echo $i;
//    sleep(1);
//    flush();
//}

//echo 'hello100';
//header('charset=utf-8');
//echo 'hello200';

//output
/*
12
1:12
3:
4
// */
//$str = '333-525-333lfsdakj';
//$reg_expression = '/(\d)\1{2}-(\d)\d\2-\1{3}/i';
//preg_match($reg_expression, $str, $result);
//var_dump($result);
//$str2 = '234@qq.com';
//$reg_exp = '/[0-9a-zA-Z]{1,20}@[0-9a-zA-Z]{1,20}.com/i';
//preg_match($reg_exp, $str2, $result2);
//var_dump($result2);
//var_dump(empty($test));
//var_dump(isset($test));
//var_dump(date('m月d日',1483804800));
//var_dump(date('m月d日',1479830400));
/*$a=array(
    1=>1,
    3=>3,
    6=>6
);
sort($a);
var_dump($a);*/
//output :
//array (size=3)
//  0 => int 1
//  1 => int 3
//  2 => int 6
//var_dump($_SERVER);
//php获取变量名(未成功)
//$tt='abcd';
//$ret=getVarName($tt);
//function getVarName($tst)
//{
//    $allDefVar = get_defined_vars();var_dump(key($allDefVar));
//    $varName   = array_keys($allDefVar,$tst);
//    return $varName;
//}
//var_dump($ret);
//$str = '1周:4节(马兰芳教学楼101)2-4、6-8周:4节(综合实验楼204)10周:4节(综合实验楼204/214)';
//$save_data = explode(')', $str);
//var_dump($save_data);
//var_dump(dirname(__FILE__));
/*class Test{

}

function test(Test $test){
   var_dump($test);
}
$mytest = new Test;
test($mytest);*/
//$data = 'hhah';
//$test_data = $data ? : '';
//var_dump($test_data);
//output : hhar
//var_dump(password_hash('a', PASSWORD_DEFAULT));
//echo md5('123456');
//$a = 4;
//$b = &$a;
//$c = &$a;
//$c += 1;
//$a += 1;
//$b += 1;
//var_dump($a, $b, $c);
//echo md5(111111);

//$data = ['dd' => 33];
//echo $data['hh'];
//
//if($data['hh']){
//    echo '33';
//}

/*
(string) $name Name of the function that you will add to class.
Usage : $Foo->add(function(){},$name);
This will add a public function in Foo Class.
*/
/*class Foo
{
    public function add($func,$name)
    {
        $this->$name = $func;
    }
    public function __call($func,$arguments){
        call_user_func_array($this->$func, $arguments);
    }
}

$Foo = new Foo();
var_dump($Foo);
$Foo->add(function(){
    echo "Hello World";
},"helloWorldFunction");
$Foo->add(function($parameterone){
    echo $parameterone;
},"exampleFunction");
var_dump($Foo);

$Foo->helloWorldFunction(); //Output : Hello World
$Foo->exampleFunction("Hello PHP"); //Output : Hello PHP

$test = 33;
var_dump('test', $test);*/
//echo '<html><div>hah</div></html>';

//$arr_origin = ['a' => 'b'];
//$arr_now = &$arr_origin;
//$arr_origin['a'] = 'c';
//var_dump($arr_origin);var_dump($arr_now);
//c  c
//$arr_now['a'] = 'd';
//var_dump($arr_origin);var_dump($arr_now);
//d  d
//unset($arr_origin);
//var_dump($arr_origin);var_dump($arr_now);
//null  d

/*$test_scope_var = 'he';
function test_function(&$test_scope_var)
{
//    global $test_scope_var;
    $test_scope_var = 'hi';
}
test_function($test_scope_var);
var_dump($test_scope_var);*/

//for ($i=0; $i < 10; $i++){
//    var_dump($i);
//}
//var_dump($i);

//if(true)
//    $test = '1';
//var_dump($test);

/*class TestClass {
    public $name;
}

function setName(&$obj) {
    $obj->name = "Nicholas";
    $obj = new TestClass();
    $obj->name = "Greg";
}
$person = new TestClass();
setName($person);
var_dump($person->name); //”Greg”*/

/*function makeAdder($x) {
    return function($y) use($x) {
        return $x + $y;
    };
}

$add5 = makeAdder(5);
$add10 = makeAdder(10);

var_dump($add5(2));  // 7
var_dump($add10(2)); // 12*/

//in javascript, no output
//if(null == 0)
//    echo 'null equals 0  ';

//if(true == 2)
//    echo 'true equals 2';
//output : null equals 0  true equals 2

//$test_null = new stdClass();
//var_dump(gettype($test_null));
//$string = 'jsfdie';
//$string[2] = '3';
//var_dump($string);

//var_dump(urldecode('https://blog.yangxitian.cn/2016/05/28/centOS%E4%B8%8B%E5%88%A9%E7%94%A8webhook%E5%AE%9E%E7%8E%B0%E8%87%AA%E5%8A%A8%E9%83%A8%E7%BD%B2%EF%BC%88PHP%EF%BC%89/'));
//echo random_bytes(12);
//var_dump(urldecode('https://pan.baidu.com/disk/home#list/vmode=list&path=%2F%E6%8A%80%E6%9C%AF%E8%A7%86%E9%A2%91%2F%E9%9F%A9%E9%A1%BA%E5%B9%B3%E5%90%84%E7%A7%8D%E8%A7%86%E9%A2%91%E9%9B%86%E5%90%88%2F%E6%AF%8F%E5%AD%A6%E7%BD%91%20%E9%9F%A9%E9%A1%BA%E5%B9%B3%20%E5%A4%A7%E5%9E%8B%E9%97%A8%E6%88%B7%E7%BD%91%E7%AB%99Memcached%E7%BC%93%E5%AD%98%E6%8A%80%E6%9C%AF(%E5%AE%8C%E6%95%B4%E7%89%88)%E3%80%90%E9%99%90%E6%97%B6%E7%89%B9%E4%BB%B7%E8%AF%BE%E7%A8%8B%EF%BC%8C%E7%8B%AC%E5%AE%B6%E9%85%8D%E6%9D%83%E5%A8%81%E7%9A%84PPT%20%E8%AF%BE%E5%A0%82%E7%AC%94%E8%AE%B0%20%E7%BB%83%E4%B9%A0%E9%A2%98%E3%80%91'));

//function sum($carry, $item)
//{
//    var_dump($carry, $item);
//
//    $carry += $item;
//    return $carry;
//}

//function product($carry, $item)
//{
//    $carry *= $item;
//    return $carry;
//}

//$a = array(1, 2, 3, 4, 5);
//$x = array();

//var_dump(array_reduce($a, "sum", 'hehe')); // int(15)
//var_dump(array_reduce($a, "product", 10)); // int(1200), because: 10*1*2*3*4*5
//var_dump(array_reduce($x, "sum", "No data to reduce")); // string(17) "No data to reduce"
var_dump( $_SERVER);