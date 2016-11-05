<?php
/* User:lyt123; Date:2016/11/1; QQ:1067081452 */
//var_dump(strpos('heehlsdjfk', 'A'));
$str = '11、18周：3节（马兰芳教学楼101）  12-17周：3节（北主楼1602/06）';
//$start = strpos($str, '）');
//var_dump(substr_count($str, '）'));
//$str_back = ltrim(substr($str, $start+3));
//$str_front = substr($str, 0, $start+3);
//var_dump($str_front);
//$str = '12,32,';
//var_dump(substr($str, -1, 1));
//$teacher_name = '人、哈';
//if(strpos($teacher_name, '、') !== false){
//    $teacher_name = substr($teacher_name, 0, strpos($teacher_name, '、'));
//}
//var_dump($teacher_name);
//var_dump(time());
$result = array_diff([1,3,4,5], [1,3]);
var_dump($result);
$second_result = array_diff($result, array(4,5));
var_dump(count($second_result));