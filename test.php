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
