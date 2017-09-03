<?php
/* User:lyt123; Date:2017/2/26; QQ:1067081452 */
/**
 * 根据给定类型，将数组转换后输出
 */
class Output
{
    public function render($array, $type = '')
    {
        if ($type === 'serialize') {
            return serialize($array);
        } elseif ($type === 'json') {
            return json_encode($array);
        } else {
            return $array;
        }
    }
}
/**
 * 客户端代码
 */
$test = ['a', 'b', 'c'];

// 实例化输出类
$output = new Output();

// 直接返回数组
$data = $output->render($test, 'array');

// 返回JSON字符串
$data = $output->render($test, 'json');