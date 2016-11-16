<?php
/* User:lyt123; Date:2016/11/5; QQ:1067081452 */
//$data = [1, 3, 4, 6];
//foreach ($data as $item) {
//    if ($item > 3)
//        var_dump($item);
//    else
//        continue;
//}
//output : 4  6
//this proves that continue will stop the foreach loop when the loop comes to the end
//$data = array();
//$test_data[] = [1,2,3];
//$test_data[] = $data;
//$test_data[] = [3];
//var_dump($test_data);
//$value = '123(150)';
//$data['number'] = substr($value, 0, strpos($value, '('));
//var_dump($data);
//phpinfo();
$str = '第1-8周星期一第3、4节';
var_dump(substr($str, -14, 3));