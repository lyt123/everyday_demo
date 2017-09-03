<?php
/* User:lyt123; Date:2017/4/5; QQ:1067081452 */
include "./redisConnect.php";
$connect = new redis_cli();
$result = $connect->get();
var_dump($result);