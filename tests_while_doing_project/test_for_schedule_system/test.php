<?php
/* User:lyt123; Date:2016/11/5; QQ:1067081452 */
$data = [1, 3, 4, 6];
foreach ($data as $item) {
    if ($item > 3)
        var_dump($item);
    else
        continue;
}
//output : 4  6
//this proves that continue will stop the foreach loop when the loop comes to the end

$value = '123(150)';
$data['number'] = substr($value, 0, strpos($value, '('));
var_dump($data);
//use of substr() and strpos(), be attention the needle is in the second parameter of the strpos()

$str = '第1-8周星期一第3、4节';
var_dump(substr($str, -14, 3));//a chinese character occupies 3 length
var_dump(count([3, 3, 6]));// output : 3
var_dump(is_int('013J1650'));//check whether a string is number : intval() function

$str = '013J1650';
$str = '23';
var_dump(preg_match('/[a-zA-Z]/', $str));
//check if a letter exists in the string

var_dump(implode(',', json_decode('[6]')));
//thinkPHP framework will filter data using htmlspecialchars() by default, but this function will stop us from send a string-array

$arr = [6, 2, 7];
sort($arr);//now $arr is sorted, pay attention to the return value of this function
var_dump($arr);

$str = 'kd;kjlsdf;';
$str2 = 'kd;kjlsdf';
var_dump(rtrim($str, ';'));
var_dump(rtrim($str2, ';'));
//if ';' is in the end, it will be trimed, if not, nothing will happen to the string

$data = explode(',', '哈哈');//$data = array('哈哈')
$data = implode(',', [6]);//$data = '6';
var_dump($data);

//the following function helps to get the string between $start and $end
function get_between($input, $start, $end)
{
    $substr = substr($input, strlen($start) + strpos($input, $start),
        (strlen($input) - strpos($input, $end)) * (-1));
    return $substr;
}

$value = '123(150)';
var_dump(get_between($value, '(', ')'));

//sort an two-dimension array accoding to a particular key-value
$test_array = [
    [
        'week' => 8,
        'week_day' => '3, 6'
    ],
    [
        'week' => 4,
        'week_day' => '3, 6'
    ],
    [
        'week' => 6,
        'week_day' => '3, 6'
    ]
];
foreach($test_array as $key => $item){
    $tmp[$key] = $item['week'];
}
array_multisort($tmp, SORT_ASC, $test_array);
var_dump($test_array);
        /* output */
//  0 =>
//    array (size=2)
//      'week' => int 4
//      'week_day' => string '3, 6' (length=4)
//  1 =>
//    array (size=2)
//      'week' => int 6
//      'week_day' => string '3, 6' (length=4)
//  2 =>
//    array (size=2)
//      'week' => int 8
//      'week_day' => string '3, 6' (length=4)