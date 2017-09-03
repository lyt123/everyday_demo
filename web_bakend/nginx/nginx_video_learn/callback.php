<?php
/* User:lyt123; Date:2017/8/18; QQ:1067081452 */
$mem = new memcache();
$mem->addserver('127.0.0.1', 11211);
$mem->addserver('127.0.0.1', 11212);
$mem->addserver('127.0.0.1', 11213);
$uri = $_SERVER['REQUEST_URI'];
if ($value = $mem->get($uri)) {
    echo $value;
} else {
    $mem->set($uri, rand(10, 100));
}
$mem->close();