<?php
/* User:lyt123; Date:2016/11/25; QQ:1067081452 */
$date_data = file_get_contents('./period_to_date.json');
$content = json_decode($date_data, 1);
var_dump($content);
$time_string = strtotime($content['date']);
var_dump($time_string);
//var_dump(strtotime())
$date = date('m月d日', $time_string+12*7*24*3600);//calculate the date of the monday of the 13th week
var_dump($date);